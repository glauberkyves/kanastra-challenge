<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchRequest;
use App\Http\Requests\FileRequest;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class InvoiceController extends Controller
{
    public function index(Request $request, InvoiceService $invoice, Builder $builder)
    {
        if ($request->ajax()) {
            return $invoice->datatable();
        }

        $html = $builder->columns(
            [
                ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
                ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
                ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
                ['data' => 'debtAmount', 'name' => 'debtAmount', 'title' => 'Amount'],
                ['data' => 'debtDueDate', 'name' => 'debtDueDate', 'title' => 'Due Date'],
                ['data' => 'debtId', 'name' => 'debtId', 'title' => 'Debit Id'],
            ]
        );

        return view('invoice.index', compact('html'));
    }

    public function store(FileRequest $request, InvoiceService $invoice): RedirectResponse
    {
        if ($invoice->processCSV($request->file('file')) === 'CSV_FILE_SENT_TO_SQS') {
            session()->flash('success', 'File sent to SQS');
        }

        return redirect(route('invoice.index'))->with('success', 'File uploaded successfully');
    }

    public function batch(BatchRequest $request, InvoiceService $invoice): JsonResponse
    {
        $invoice->batch($request->all());

        response()->json(['success' => 'success']);
    }

    public function list(BatchRequest $request, InvoiceService $invoice): JsonResponse
    {
        return response()->json($invoice->datatable()->getData());
    }
}
