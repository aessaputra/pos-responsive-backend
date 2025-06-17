<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReportMail;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-sales-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send the daily sales report via email.';

    /**
     * Execute the console command.
     */
    public function handle(ReportService $reportService)
    {
        $this->info('Memulai pembuatan laporan harian...');

        $startDate = now()->subDay()->startOfDay();
        $endDate = now()->subDay()->endOfDay();
        $periodTitle = 'Harian';

        $reportData = $reportService->generateDetailedReport($startDate, $endDate);

        if (empty($reportData['items'])) {
            $this->info('Tidak ada transaksi kemarin. Email tidak dikirim.');
            return;
        }

        $pdf = Pdf::loadView('pdf.sales-report', [
            'reportData' => $reportData,
            'periodTitle' => $periodTitle,
            'startDate' => $startDate->format('d/m/Y'),
            'endDate' => $endDate->format('d/m/Y'),
        ]);

        $recipientEmail = 'aessaputra@yahoo.com';

        Mail::to($recipientEmail)->send(new DailySalesReportMail(
            $reportData,
            $pdf->output()
        ));

        $this->info('Laporan penjualan harian telah berhasil dikirim ke ' . $recipientEmail);
    }
}
