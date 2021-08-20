<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name',
        'date',
        'sales_person',
        'customer_name',
        'created_at'
    ];

    protected $appends = ['registered_at'];

    public function getRegisteredAtAttribute() {
        return $this->created_at;
    }
}
