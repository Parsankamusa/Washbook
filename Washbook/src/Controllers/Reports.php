<?php

namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\Auth;
use Simcify\Controllers\Sales;

class Reports {

    /**
     * Display the sales report.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $title = "Sales Report";

        $salesData = Sales::sales($user);

        return view("Reports", compact("user", "title", "salesData"));
    }

    /**
     * Export sales data to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportToExcel()
    {
        $user = Auth::user();
        $salesData = Sales::sales($user);

        // Create a new Excel file
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headers
        $sheet->setCellValue('A1', 'Client');
        $sheet->setCellValue('B1', 'Amount / Commission');
        $sheet->setCellValue('C1', 'Item / Services');
        $sheet->setCellValue('D1', 'Performed By');
        $sheet->setCellValue('E1', 'Payment Method');
        $sheet->setCellValue('F1', 'Date');

        // Fill data rows
        $row = 2;
        foreach ($salesData as $sale) {
            $sheet->setCellValue('A' . $row, $sale->client->fullname);
            $sheet->setCellValue('B' . $row, $sale->total . ' / ' . $sale->commission);
            $sheet->setCellValue('C' . $row, $sale->item);
            $sheet->setCellValue('D' . $row, implode(', ', $sale->performedBy->pluck('name')->toArray()));
            $sheet->setCellValue('E' . $row, $sale->paymentMethod);
            $sheet->setCellValue('F' . $row, $sale->createdAt);
            $row++;
        }

        // Set column auto-width
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Create a temporary file in the system's temp directory
        $tempFile = tempnam(sys_get_temp_dir(), 'sales_report_');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        // Return the Excel file as a download
        return response()->download($tempFile, 'sales_report.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
