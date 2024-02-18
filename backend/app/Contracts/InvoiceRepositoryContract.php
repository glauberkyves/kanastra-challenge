<?php

namespace App\Contracts;

interface InvoiceRepositoryContract {
    public function datatable();
    public function saveCSV(array $items): void;

    public function batch(array $data): void;
}
