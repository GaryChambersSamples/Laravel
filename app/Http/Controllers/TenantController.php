<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Apartment;
use App\Models\Billing;
use App\Models\Owner;
use App\Models\Property;
use App\Models\State;
use App\Models\Tenant;
use PDF;

class TenantController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        $tenants = Tenant::where('active', 1)
                        ->orderBy('last_name')
                        ->orderBy('first_name')
                        ->with('apartment.property.address.state')
                        ->paginate(3);

        return view('tenants.index', compact('tenants'));
    }

    public function indexInactive() {

        $tenants = Tenant::where('active', '0')
                        ->orderBy('last_name')
                        ->orderBy('first_name')
                        ->with('apartment.property.address.state')
                        ->paginate(3);

        return view('tenants.indexInactive', compact('tenants'));
    }

    public function show(Tenant $tenant) {

        //Calculate account balance this way because using the sum function on a paginated
        //recordset only tabulates the records on that page
        $accountBalance = Billing::where('tenant_id', $tenant->id)->sum('amount');

        $billings = Billing::where('tenant_id', $tenant->id)
                            ->orderByDesc('transaction_date')->paginate(3);
        return view('tenants.show', compact('tenant', 'billings', 'accountBalance'));
    }

    public function create() {
        $tenant = new Tenant();
        
        //Get a list of available apartments for dropdown
        $availableApartments = Apartment::where('rented', 0)->get();
        $availableApartments->load('property.address');
        $availableApartments->sortBy('address')
                            ->sortBy('apartment_number');

        $action = "create";

        return view('tenants.create', compact('tenant', 'availableApartments', 'action'));
    }

    public function edit(Tenant $tenant) {

        $action = "edit";
        
        return view('tenants.edit', compact('tenant', 'action'));
    }

    public function changeActivation(Tenant $tenant) {

        $apartment = Apartment::findOrFail($tenant->apartment_id);

            $tenant->active = !0;
            $tenant->update();

            $apartment->rented = !0;
            $apartment->update();

            return redirect('/tenants/')->with('mssg', request('apartment_number') . ' has been added.');         
    }

    public function generateLease(Tenant $tenant) {

        $owner = Owner::findOrFail($tenant->apartment->property->owner_id);
        $filename = $tenant->first_name . " " . $tenant->last_name . " lease";

        $pdf = PDF::loadView('tenants.lease', compact('tenant', 'owner'));
        return $pdf->stream($filename);

        // return view('tenants.lease', compact('tenant', 'owner'));
    }

    public function generateInvoice(Tenant $tenant) {

        $owner = Owner::findOrFail($tenant->apartment->property->owner_id);
        $billings = Billing::where('tenant_id', $tenant->id)
                         ->orderByDesc('transaction_date')->paginate(10);
        $filename = $tenant->first_name . " " . $tenant->last_name . " invoice";

        $pdf = PDF::loadView('tenants.invoice', compact('tenant', 'owner', 'billings'));
        return $pdf->stream($filename);
    }

    public function store() {
        $tenant = Tenant::create($this->validateRequest());

        //Update the apartments rented flag
        $apartment = Apartment::findOrFail($tenant->apartment_id);
        $apartment->rented = $tenant->active;
        $apartment->update();

        return redirect('/tenants')->with('mssg', request('apartment_number') . ' has been added.');
    }

    public function update(Tenant $tenant) {

        $data = $this->validateRequest();

        $tenant->update($data);

        //Update the apartments rented flag
        $apartment = Apartment::findOrFail($tenant->apartment_id);
        $apartment->rented = $tenant->active;
        $apartment->update();
        
        return redirect('tenants/' . $tenant->id);
    }

    private function validateRequest(){

        return request()->validate([
            'apartment_id' => 'required',
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'required|date',
            'monthly_rent' => 'required',
            'late_fee' => 'required',
            'grace_period' => 'required',
            'returned_check_fee' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'primary_phone' => 'required',
            'secondary_phone' => '',
            'email' => 'nullable|email',
            'active' => 'required',
            'notes' => '',
            //Emergency Contact information
            //additional occupants
            //ssn and/or drivers license (encrypted)
            //employer info
            //salary/hourly
            //anything else in application
        ]);
    }

    public function destroy(Tenant $tenant) {
        $tenant->delete();

        return redirect('/properties');
    }

}
