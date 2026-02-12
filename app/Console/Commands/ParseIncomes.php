<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Income;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;

class ParseIncomes extends Command
{
    private const LIMIT = 500;

    protected $signature = 'parse:incomes';
    protected $description = 'Parse incomes from API';

    public function handle(): void
    {
        $this->parse();
    }

    public function parse(): void
    {
        $page = 1;

        do {
            $response = Http::withOptions(['verify' => false])
                ->withBody(json_encode([
                    'key' => env('PARSE_KEY'),
                ]), 'application/json')
                ->send('GET', env('PARSE_URL') . '/api/incomes', [
                    'query' => [
                        'page' => $page,
                        'limit' => 500,
                        'dateFrom' => '2000-01-01',
                        'dateTo' => now()->toDateString(),
                    ],
                ]);

            $data = $response->json()['data'];
            if (empty($data)) break;

            echo count($data);
            echo "\n";

            foreach ($data as $i) {
                dump($i['income_id'], $i['date'], $i['barcode']);
            }

            foreach ($data as $i) {
                try {
                    Income::insert(
                        [[
                            'income_id' => $i['income_id'] ?? 0,
                            'date' => $i['date'] ?? now()->toDateString(),
                            'last_change_date' => $i['last_change_date'] ?? now()->toDateString(),
                            'date_close' => $i['date_close'] ?? null,
                            'nm_id' => $i['nm_id'] ?? 0,
                            'supplier_article' => $i['supplier_article'] ?? '',
                            'barcode' => $i['barcode'] ?? 0,
                            'quantity' => $i['quantity'] ?? 0,
                            'total_price' => $i['total_price'] ?? 0,
                            'warehouse_name' => $i['warehouse_name'] ?? '',
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]]
                    );
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }

            $page++;
        } while (count($data) === self::LIMIT);
    }
}
