<?php

namespace App\Filament\Pages;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;

class SalesReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static string $view = 'filament.pages.sales-report';
    protected static ?string $title = 'Laporan Penjualan';

    // Properti untuk menyimpan periode aktif dan data laporan
    public string $period = 'daily';
    public ?array $reportData = null;
    public Carbon $startDate;
    public Carbon $endDate;
    public string $periodTitle = '';

    // Dijalankan saat halaman pertama kali di-mount
    public function mount(): void
    {
        $this->updateReportData();
    }

    /**
     * Menentukan header actions (tombol di kanan atas).
     * Di sinilah tombol Ekspor PDF akan berada.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Ekspor PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn() => $this->exportToPdf())
                // Hanya aktifkan tombol jika ada data
                ->disabled(!$this->reportData || empty($this->reportData['stats']['total_transactions'])),
        ];
    }

    /**
     * Metode utama untuk mengubah periode laporan.
     * Akan dipanggil oleh tombol-tombol di view.
     */
    public function setPeriod(string $period): void
    {
        $this->period = $period;
        $this->updateReportData();
    }

    /**
     * Menghitung rentang tanggal dan mengambil data dari service.
     * Ini adalah inti dari logika reaktif halaman.
     */
    public function updateReportData(): void
    {
        switch ($this->period) {
            case 'weekly':
                $this->startDate = now()->startOfWeek();
                $this->endDate = now()->endOfWeek();
                $this->periodTitle = 'Minggu Ini';
                break;
            case 'monthly':
                $this->startDate = now()->startOfMonth();
                $this->endDate = now()->endOfMonth();
                $this->periodTitle = 'Bulan Ini';
                break;
            case 'daily':
            default:
                $this->startDate = now()->startOfDay();
                $this->endDate = now()->endOfDay();
                $this->periodTitle = 'Hari Ini';
                break;
        }

        $reportService = app(ReportService::class);
        $this->reportData = $reportService->generateReport($this->startDate, $this->endDate);
    }

    /**
     * Menangani logika ekspor ke PDF.
     */
    public function exportToPdf()
    {
        $data = [
            'reportData' => $this->reportData,
            'periodTitle' => $this->periodTitle,
            'startDate' => $this->startDate->format('d/m/Y'),
            'endDate' => $this->endDate->format('d/m/Y'),
        ];

        // Membuat nama file yang dinamis
        $filename = 'laporan-penjualan-' . strtolower($this->periodTitle) . '-' . now()->format('Y-m-d') . '.pdf';

        // Merender view PDF dan mengirimkannya sebagai unduhan
        $pdf = Pdf::loadView('pdf.sales-report', $data);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }
}
