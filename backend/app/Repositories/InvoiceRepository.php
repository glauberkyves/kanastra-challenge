<?php
namespace App\Repositories;

use App\Contracts\InvoiceRepositoryContract;
use App\Models\Invoice;
use Yajra\DataTables\DataTables;

class InvoiceRepository implements InvoiceRepositoryContract {
    public function __construct(
        protected Invoice $model
    ){}

    public function datatable()
    {
        $model = $this->model->query();

        return DataTables::of($model)->toJson();
    }

   public function saveCSV(array $items): void {
       foreach ($items as $item) {
           $this->model->insert($item);
      }
   }

   public function batch(array $data): void {
       foreach ($data as $item) {
           $this->model->insert($item);
       }
   }
}
