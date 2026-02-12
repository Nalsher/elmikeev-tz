<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'g_number',
        'date',
        'last_change_date',
        'nm_id',
        'supplier_article',
        'barcode',
        'warehouse_name',
        'total_price',
        'discount_percent',
        'is_cancel',
        'cancel_dt',
    ];

    protected $casts = [
        'date' => 'datetime',
        'last_change_date' => 'datetime',
        'cancel_dt' => 'datetime',
        'is_cancel' => 'boolean',
    ];
}
