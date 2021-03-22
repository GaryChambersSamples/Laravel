<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }

    public function billing(){
        return $this->hasMany(Billing::class);
    }
}
