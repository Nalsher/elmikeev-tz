<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'g_number',
        'sale_id',
        'date',
        'last_change_date',
        'nm_id',
        'supplier_article',
        'barcode',
        'warehouse_name',
        'region_name',
        'total_price',
        'discount_percent',
        'for_pay',
        'finished_price',
        'is_supply',
        'is_realization',
        'is_storno',
    ];

    protected $casts = [
        'date' => 'date',
        'last_change_date' => 'date',
        'is_supply' => 'boolean',
        'is_realization' => 'boolean',
        'is_storno' => 'boolean',
    ];
}
