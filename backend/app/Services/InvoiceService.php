<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;
use Illuminate\Http\UploadedFile;
use JamesGordo\CSV\Parser;

class InvoiceService {
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
        protected SqsService        $sqsService
    ){}

    public function datatable()
    {
        return $this->invoiceRepository->datatable();
    }

   public function processCSV(UploadedFile $file): string {
       $path = $file->getRealPath();

       if (file_exists($path)) {
           $invoices = new Parser($path);

           if($invoices->count() >= env('CSV_LIMIT')) {
               $items = [];
               foreach ($invoices->all() as $item) {
                   $items[] = $item;

                   if (count($items) == env('CSV_LIMIT')) {
                       $this->sqsService->send($items);
                       $items = [];
                   }
               }

               if (count($items) > 0) {
                   $this->sqsService->send($items);
               }

               return 'CSV_FILE_SENT_TO_SQS';

           }else{
               $this->invoiceRepository->saveCSV($invoices->all());
           }

           return 'CSV_FILE_PROCESSED';
       }

       throw new \Exception("File not found");
   }

    public function batch(array $data): void {
         $this->invoiceRepository->batch($data);
    }
}
