@csrf

{{-- Tenant information --}}
<div class="row">
    <div class="col-4 form-group">
        <label for="name">* First Name:</label>
        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') ?? $tenant->first_name}}"> 
        <div><small class="text-danger">{{ $errors-> first('first_name') }}</small></div>
    </div>

    <div class="col-4 form-group">
        <label for="last_name">* Last Name:</label>
        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') ?? $tenant->last_name}}"> 
        <div><small class="text-danger">{{ $errors-> first('last_name') }}</small></div>
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        <label for="name">* Primary Phone:</label>
        <input type="text" id="primary_phone" name="primary_phone" class="form-control" value="{{ old('primary_phone') ?? $tenant->primary_phone}}"> 
        <div><small class="text-danger">{{ $errors-> first('primary_phone') }}</small></div>
    </div>

    <div class="col-4 form-group">
        <label for="secondary_phone">Secondary Phone:</label>
        <input type="text" id="secondary_phone" name="secondary_phone" class="form-control" value="{{ old('secondary_phone') ?? $tenant->secondary_phone}}"> 
        <div><small class="text-danger">{{ $errors-> first('secondary_phone') }}</small></div>
    </div>

    <div class="col-4 form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') ?? $tenant->email}}"> 
        <div><small class="text-danger">{{ $errors-> first('email') }}</small></div>
    </div>
</div>

<hr>

{{-- for javascript reasons load standard rate --}}
@if ($action != "edit")
    @foreach ($availableApartments as $availableApartment)
        <input disabled type="hidden" id="{{ $availableApartment->id }}rent" name="{{ $availableApartment->id }}rent" value="{{ $availableApartment->standard_rent }}">
        <input disabled type="hidden" id="{{ $availableApartment->id }}late" name="{{ $availableApartment->id }}late" value="{{ $availableApartment->standard_late_fee }}">
        <input disabled type="hidden" id="{{ $availableApartment->id }}grace" name="{{ $availableApartment->id }}grace" value="{{ $availableApartment->standard_grace_period }}">
        <input disabled type="hidden" id="{{ $availableApartment->id }}check" name="{{ $availableApartment->id }}check" value="{{ $availableApartment->standard_returned_check_fee }}">
    @endforeach
@endif


<div class="row">
    @if ($action == "edit")
        <input type="hidden" id="apartment_id" name="apartment_id" value="{{ $tenant->apartment_id }}">
        <div class="col-4 form-group">
            <label for="apartment">Apartment:</label>
            <input disabled type="text" id="apartment" name="apartment" class="form-control" value="{{ $tenant->apartment->property->address->address}} {{ $tenant->apartment->apartment_number }}"> 
        </div>
    @else
        <div class="col-4 form-group">
            <label for="apartment_id">* Available Apartments:</label>
            <select name="apartment_id" id="apartment_id" onChange="showStandards()" class="form-control">
                <option selected value> -- select an apartment -- </option>
                @foreach ($availableApartments as $availableApartment)
                    <option value="{{ $availableApartment->id }}" {{$tenant->apartment_id == $availableApartment->id ? 'selected' : '' }}>{{ $availableApartment->property->address->address }} {{ $availableApartment->apartment_number }}</option>
                @endforeach
            </select>
            <div><small class="text-danger">{{ $errors-> first('apartment_id') }}</small></div>
        </div>
    @endif

    <div class="col-4 form-group">
        <label for="lease_start_date">* Lease Start Date:</label>
        <input type="date" id="lease_start_date" name="lease_start_date" class="form-control" value="{{ old('lease_start_date') ?? $tenant->lease_start_date}}"> 
        <div><small class="text-danger">{{ $errors-> first('lease_start_date') }}</small></div>
    </div>

    <div class="col-4 form-group">
        <label for="lease_end_date">* Lease End Date:</label>
        <input type="date" id="lease_end_date" name="lease_end_date" class="form-control" value="{{ old('lease_end_date') ?? $tenant->lease_end_date}}"> 
        <div><small class="text-danger">{{ $errors-> first('lease_end_date') }}</small></div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        <label for="active">* Active Tenant:</label>
        <select name="active" id="active" class="form-control">
            <option value="0" @if ($tenant->active == 0) selected @endif>No</option>
            <option value="1" @if ($tenant->active == 1) selected @endif>Yes</option>
        </select>
        <div><strong class="text-danger">Remember to set the tenant's Active flag to "yes" when they sign the lease!</strong></div>
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        <label for="monthly_rent">* Monthly Rent:</label>
        <input type="text" id="monthly_rent" name="monthly_rent" class="form-control" value="{{ old('monthly_rent') ?? $tenant->monthly_rent}}"> 
        <div><small class="text-danger">{{ $errors-> first('monthly_rent') }}</small></div>
    </div>

    <div class="col-4 form-group">
        <label for="late_fee">* Late Fee:</label>
        <input type="text" id="late_fee" name="late_fee" class="form-control" value="{{ old('late_fee') ?? $tenant->late_fee}}"> 
        <div><small class="text-danger">{{ $errors-> first('late_fee') }}</small></div>
    </div>

    <div class="col-4 form-group">
        <label for="grace_period">* Grace Period:</label>
        <input type="text" id="grace_period" name="grace_period" class="form-control" value="{{ old('grace_period') ?? $tenant->grace_period}}"> 
        <div><small class="text-danger">{{ $errors-> first('grace_period') }}</small></div>
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        <label for="returned_check_fee">* Late Fee:</label>
        <input type="text" id="returned_check_fee" name="returned_check_fee" class="form-control" value="{{ old('returned_check_fee') ?? $tenant->returned_check_fee}}"> 
        <div><small class="text-danger">{{ $errors-> first('returned_check_fee') }}</small></div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-12 form-group">
        <label for="notes">Notes:</label>
        <textarea name="notes" id="notes" cols="30" rows="5" class="form-control">{{ old('notes') ?? $tenant->notes}}</textarea>
    </div>
</div>


<script>
    function showStandards() {
      var x = document.getElementById("apartment_id").value;
      document.getElementById("monthly_rent").value = document.getElementById(x + "rent").value;
      document.getElementById("late_fee").value = document.getElementById(x + "late").value;
      document.getElementById("grace_period").value = document.getElementById(x + "grace").value;
      document.getElementById("returned_check_fee").value = document.getElementById(x + "check").value;
    }
</script>

