<?php

namespace Tests\Feature\app\Services;

use App\Repositories\InvoiceRepository;
use App\Services\InvoiceService;
use App\Services\SqsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    protected InvoiceService $invoiceService;
    protected string         $pathMockCsvFile;

    protected function setUp(): void
    {
        parent::setUp();

        $invoiceRepositoryMock = $this->createMock(InvoiceRepository::class);
        $sqsServiceMock        = $this->createMock(SqsService::class);

        $this->invoiceService = new InvoiceService($invoiceRepositoryMock, $sqsServiceMock);
    }

    public function testProcessCSVInvalid()
    {
        $csvData = "";
        $file    = UploadedFile::fake()
            ->createWithContent('invoices.csv', $csvData);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File is not a valid csv file');

        $this->invoiceService->processCSV($file);
    }

    public function testProcessCSVValid()
    {
        $csvData = [
            0 =>
                [
                    'name',
                    'governmentId',
                    'email',
                    'debtAmount',
                    'debtDueDate',
                    'debtId',
                ],
            1 =>
                [
                    'John Doe',
                    '11111111111',
                    'johndoe@kanastra.com.br',
                    '1000000.00',
                    '2022-10-12',
                    '1adb6ccf-ff16-467f-bea7-5f05d494280f',
                ],
        ];

        $file = UploadedFile::fake()
            ->createWithContent('example.csv', $this->toCsvString($csvData));

        $result = $this->invoiceService->processCSV($file);
        $this->assertEquals('CSV_FILE_PROCESSED', $result);
    }

    private function toCsvString(array $data): string
    {
        $output = fopen('php://temp', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csvString = stream_get_contents($output);
        fclose($output);
        return $csvString;
    }
}
