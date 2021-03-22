<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tenant(){
        return $this->belongsTo(Tenant::class);
    }

    public function bill_type(){
        return $this->belongsTo(Bill_type::class);
    }

    public static function getAnnualIncome() {
        // Make this a property
        $accountBalance = Billing::where('bill_type_id', '1')
                                    ->whereBetween('transaction_date', [
                                        now()->startOfYear(),
                                        now()->endOfYear() ])
                                        ->sum('amount');

        return $accountBalance;
    }
}
