<?php

namespace App\Services\Concretes;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Log;
use Google\Service\Sheets\ValueRange;



class GoogleSheetService
{
    protected Sheets $service;
    protected string $spreadsheetId;

    public function __construct(string $spreadsheetId)
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-service-account.json'));
        $client->addScope(Sheets::SPREADSHEETS); // ← read & write
    
        $this->service = new Sheets($client);
        $this->spreadsheetId = $spreadsheetId;
    }
    
    public function updateData(string $range, array $values): bool
    {
        try {
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $values
            ]);
    
            $params = [
                'valueInputOption' => 'RAW', // Bisa juga 'USER_ENTERED' kalau mau formulas diproses
            ];
    
            $response = $this->service->spreadsheets_values->update(
                $this->spreadsheetId, // Spreadsheet ID aktif
                $range,               // Range target misalnya "Category!A2:D2"
                $body,
                $params
            );
    
            // Cek apakah berhasil update minimal 1 sel
            return $response->getUpdatedCells() > 0;
        } catch (\Throwable $e) {
            \Log::error("Gagal update data ke Google Sheet", [
                'spreadsheet_id' => $this->spreadsheetId,
                'range' => $range,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function clearRange(string $range): bool
    {
        try {
            $this->service->spreadsheets_values->clear($this->spreadsheetId, $range, new \Google\Service\Sheets\ClearValuesRequest());
            return true;
        } catch (\Exception $e) {
            \Log::error("Gagal clear range di Google Sheet: {$e->getMessage()}");
            return false;
        }
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
    


    
    public function appendData(array $values, ?string $range = null, ?string $spreadsheetId = null): bool
    {
        $spreadsheetId = $spreadsheetId ;
        $range = $range ;
    
        try {
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $values
            ]);
    
            $params = ['valueInputOption' => 'USER_ENTERED'];
    
            $response = $this->service->spreadsheets_values->append(
                $spreadsheetId,
                $range,
                $body,
                $params
            );
    
            // Cek jumlah sel yang berhasil diupdate
            if (isset($response['updates']['updatedCells']) && $response['updates']['updatedCells'] > 0) {
                return true;
            }
    
            Log::error("Push spreadsheet gagal: updatedCells = 0", [
                'range' => $range,
                'values' => $values
            ]);
    
            return false;
    
        } catch (\Exception $e) {
            Log::error("Gagal menulis data ke Google Sheet", [
                'spreadsheet_id' => $spreadsheetId,
                'range' => $range,
                'values' => $values,
                'error' => $e->getMessage()
            ]);
            throw $e; // lempar exception supaya DB di-rollback
        }
    }
    
    


    public function clearSheet(string $range): void
{
    $requestBody = new \Google\Service\Sheets\ClearValuesRequest();
    $this->service->spreadsheets_values->clear($this->spreadsheetId, $range, $requestBody);
}

public function updateSheetData(string $range, array $values): void
{
    $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
    $params = ['valueInputOption' => 'RAW'];
    $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
}

}
