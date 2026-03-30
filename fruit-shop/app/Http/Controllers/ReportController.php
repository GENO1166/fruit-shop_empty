<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function generatePDF()
    {
        $products = DB::table('products')->get();

        $data = [
            'title' => 'รายงานรายการผลไม้ในระบบ',
            'date' => date('d/m/Y H:i'),
            'products' => $products,
        ];

        $pdf = Pdf::loadView('products_pdf', $data);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('product-report-' . date('Ymd') . '.pdf');
    }
}
