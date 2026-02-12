<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Stock;

class ParseStocks extends Command
{
    private const LIMIT = 500;

    protected $signature = 'parse:stocks';
    protected $description = 'Parse stocks from API';

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
                ->send('GET', env('PARSE_URL') . '/api/stocks', [
                    'query' => [
                        'page' => $page,
                        'limit' => self::LIMIT,
                        'dateFrom' => now()->toDateString(),
                        'dateTo' => now()->addDay()->toDateString(),
                    ],
                ]);

            $data = $response->json()['data'];

            foreach ($data as $i) {
                try {
                    Stock::insert([[
                        'external_id' => $i['g_number'] ?? 0,
                        'nm_id' => $i['nm_id'] ?? 0,
                        'supplier_article' => $i['supplier_article'] ?? '',
                        'barcode' => $i['barcode'] ?? 0,
                        'warehouse_name' => $i['warehouse_name'] ?? '',
                        'quantity' => $i['quantity'] ?? 0,
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
