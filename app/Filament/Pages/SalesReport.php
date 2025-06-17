<?php

namespace App\Filament\Pages;

use App\Services\ReportService;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class SalesReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.sales-report';
    protected static ?string $title = 'Laporan Penjualan';

    public string $period = 'daily';
    public ?array $reportData = null;
    public string $periodTitle = '';

    public function mount(): void
    {
        $this->updateReportData();
    }

    public function updatedPeriod(): void
    {
        $this->updateReportData();
    }

    public function updateReportData(): void
    {
        switch ($this->period) {
            case 'weekly':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                $this->periodTitle = 'Minggu Ini';
                break;
            case 'monthly':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                $this->periodTitle = 'Bulan Ini';
                break;
            case 'daily':
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                $this->periodTitle = 'Hari Ini';
                break;
        }

        $reportService = app(ReportService::class);
        $this->reportData = $reportService->generateDetailedReport($startDate, $endDate);
    }
}
