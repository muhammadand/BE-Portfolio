<?php

namespace App\Services\Concretes;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    protected Sheets $service;
    protected string $spreadsheetId;

    public function __construct(string $spreadsheetId)
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-service-account.json'));
        $client->addScope(Sheets::SPREADSHEETS_READONLY);

        $this->service = new Sheets($client);
        $this->spreadsheetId = $spreadsheetId;
    }

    public function getSheetData(string $range): array
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            return $response->getValues() ?? [];
        } catch (\Exception $e) {
            Log::error("Gagal membaca data dari Google Sheet", [
                'spreadsheet_id' => $this->spreadsheetId,
                'range' => $range,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
