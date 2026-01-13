<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Download;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
// Import class untuk Middleware Laravel 12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ReportController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware secara statis (Standar Laravel 12)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin'),
        ];
    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        $revenueData = $this->getRevenueData($startDate, $endDate);
        $salesData = $this->getSalesData($startDate, $endDate);
        $userData = $this->getUserData($startDate, $endDate);
        $downloadData = $this->getDownloadData($startDate, $endDate);

        return view('admin.reports.index', compact(
            'revenueData',
            'salesData',
            'userData',
            'downloadData',
            'period'
        ));
    }

    // ... (Sisa method export, getStartDate, dll tetap sama seperti kode Anda sebelumnya)
    
    public function export(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $format = $request->get('format', 'pdf');
        $period = $request->get('period', 'month');

        $startDate = $this->getStartDate($period);
        $endDate = now();

        $data = $this->getReportData($type, $startDate, $endDate);

        if ($format === 'pdf') {
            return $this->exportPDF($data, $type);
        } elseif ($format === 'excel') {
            return $this->exportExcel($data, $type);
        } else {
            return $this->exportCSV($data, $type);
        }
    }

    private function getStartDate($period)
    {
        switch ($period) {
            case 'today':
                return Carbon::today();
            case 'week':
                return Carbon::now()->subWeek();
            case 'month':
                return Carbon::now()->subMonth();
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subMonth();
        }
    }

    private function getRevenueData($startDate, $endDate)
    {
        return Order::where('payment_status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getSalesData($startDate, $endDate)
    {
        return Product::withCount(['orderItems' => function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->orderBy('order_items_count', 'desc')
        ->take(10)
        ->get();
    }

    private function getUserData($startDate, $endDate)
    {
        return [
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'active_users' => User::whereHas('orders', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->count(),
            'total_users' => User::count(),
        ];
    }

    private function getDownloadData($startDate, $endDate)
    {
        return Download::whereBetween('downloaded_at', [$startDate, $endDate])
            ->selectRaw('DATE(downloaded_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getReportData($type, $startDate, $endDate)
    {
        switch ($type) {
            case 'revenue':
                return $this->getRevenueData($startDate, $endDate);
            case 'sales':
                return $this->getSalesData($startDate, $endDate);
            case 'users':
                return User::whereBetween('created_at', [$startDate, $endDate])->get();
            case 'downloads':
                return $this->getDownloadData($startDate, $endDate);
            default:
                return collect();
        }
    }

    private function exportPDF($data, $type)
    {
        $pdf = Pdf::loadView('admin.reports.pdf', [
            'data' => $data,
            'type' => $type,
            'date' => now()->format('d M Y')
        ]);

        return $pdf->download("report-{$type}-" . now()->format('Y-m-d') . '.pdf');
    }

    private function exportExcel($data, $type)
    {
        return Excel::download(new \App\Exports\ReportExport($data, $type), 
            "report-{$type}-" . now()->format('Y-m-d') . '.xlsx');
    }

    private function exportCSV($data, $type)
    {
        $filename = "report-{$type}-" . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()->toArray()));
            }
            foreach ($data as $row) {
                fputcsv($file, $row->toArray());
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}