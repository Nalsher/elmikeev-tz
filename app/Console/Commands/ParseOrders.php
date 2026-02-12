<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Order;

class ParseOrders extends Command
{
    private const LIMIT = 500;

    protected $signature = 'parse:orders';
    protected $description = 'Parse orders from API';

    public function handle(): void
    {
        $this->parse();
    }

    public function parse(): void
    {
        $page = 1;

        do {
            $response = Http::withOptions(['verify' => false])
                ->withBody(json_encode(['key' => env('PARSE_KEY')]), 'application/json')
                ->send('GET', env('PARSE_URL') . '/api/orders', [
                    'query' => [
                        'page' => $page,
                        'limit' => self::LIMIT,
                        'dateFrom' => '2000-01-01',
                        'dateTo' => now()->toDateString(),
                    ],
                ]);

            $data = $response->json()['data'];

            foreach ($data as $i) {
                try {
                    Order::insert([[
                        'g_number' => $i['g_number'] ?? 0,
                        'date' => $i['date'] ?? now()->toDateString(),
                        'last_change_date' => $i['last_change_date'] ?? now()->toDateString(),
                        'nm_id' => $i['nm_id'] ?? 0,
                        'supplier_article' => $i['supplier_article'] ?? '',
                        'barcode' => $i['barcode'] ?? 0,
                        'warehouse_name' => $i['warehouse_name'] ?? '',
                        'total_price' => $i['total_price'] ?? 0,
                        'discount_percent' => $i['discount_percent'] ?? 0,
                        'is_cancel' => $i['is_cancel'] ?? false,
                        'cancel_dt' => $i['cancel_dt'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }

            $page++;
        } while (count($data) === self::LIMIT);
    }
}
