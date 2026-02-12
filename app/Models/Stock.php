<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'external_id',
        'nm_id',
        'supplier_article',
        'barcode',
        'warehouse_name',
        'quantity',
    ];
}
