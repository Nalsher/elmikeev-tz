<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'income_id',
        'date',
        'last_change_date',
        'date_close',
        'nm_id',
        'supplier_article',
        'barcode',
        'quantity',
        'total_price',
        'warehouse_name',
    ];

    protected $casts = [
        'date' => 'date',
        'last_change_date' => 'date',
        'date_close' => 'date',
    ];
}
