<x-filament-panels::page>
    <div class="flex flex-col gap-y-8">
        {{-- Filter Periode --}}
        <div class="flex items-center justify-between">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="period">
                    <option value="daily">Laporan Harian</option>
                    <option value="weekly">Laporan Mingguan</option>
                    <option value="monthly">Laporan Bulanan</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>

            {{-- Indikator loading saat periode diubah --}}
            <div wire:loading wire:target="period">
                <x-filament::loading-indicator class="h-5 w-5 text-gray-400" />
            </div>
        </div>

        {{-- Konten Laporan --}}
        <div wire:loading.remove wire:target="period" class="space-y-6">
            @if ($reportData && !empty($reportData['stats']['total_transactions']))
                {{-- Kartu Statistik dengan Ikon (Tata Letak Diperbaiki) --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                        <div class="flex items-center gap-x-4">
                            <div class="flex-shrink-0 rounded-md bg-primary-100 p-3 dark:bg-primary-500/20">
                                <x-heroicon-o-banknotes class="h-6 w-6 text-primary-600 dark:text-primary-400" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pendapatan</p>
                                <p class="mt-1 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    Rp {{ number_format($reportData['stats']['total_revenue']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                        <div class="flex items-center gap-x-4">
                            <div class="flex-shrink-0 rounded-md bg-info-100 p-3 dark:bg-info-500/20">
                                <x-heroicon-o-receipt-percent class="h-6 w-6 text-info-600 dark:text-info-400" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transaksi</p>
                                <p class="mt-1 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    {{ number_format($reportData['stats']['total_transactions']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                        <div class="flex items-center gap-x-4">
                            <div class="flex-shrink-0 rounded-md bg-success-100 p-3 dark:bg-success-500/20">
                                <x-heroicon-o-shopping-bag class="h-6 w-6 text-success-600 dark:text-success-400" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Item Terjual</p>
                                <p class="mt-1 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    {{ number_format($reportData['stats']['total_items_sold']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Produk Terlaris (Tata Letak Diperbaiki) --}}
                <div
                    class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                    <div class="border-b px-6 py-4 dark:border-white/10">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Produk Terlaris -
                            {{ $periodTitle }}</h3>
                    </div>
                    <div class="fi-ta">
                        <table
                            class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                            <thead>
                                <tr class="bg-gray-50 text-left text-sm dark:bg-white/5">
                                    <th
                                        class="fi-ta-header-cell w-1/2 px-6 py-3 font-semibold text-gray-900 dark:text-white">
                                        Nama Produk</th>
                                    <th
                                        class="fi-ta-header-cell px-6 py-3 text-center font-semibold text-gray-900 dark:text-white">
                                        Jumlah Terjual</th>
                                    <th
                                        class="fi-ta-header-cell px-6 py-3 text-right font-semibold text-gray-900 dark:text-white">
                                        Total Omzet</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                @forelse ($reportData['top_selling_items'] as $item)
                                    <tr class="fi-ta-row text-sm">
                                        <td class="fi-ta-cell p-6">{{ $item['product_name'] }}</td>
                                        <td class="fi-ta-cell p-6 text-center">{{ $item['total_quantity_sold'] }}</td>
                                        <td class="fi-ta-cell p-6 text-right">Rp
                                            {{ number_format($item['total_revenue'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr class="fi-ta-row text-sm">
                                        <td class="fi-ta-cell p-6 text-center" colspan="3">
                                            Tidak ada produk terjual pada periode ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                {{-- Pesan jika tidak ada data --}}
                <div
                    class="rounded-xl border border-gray-200 bg-white p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                        <x-heroicon-o-x-circle class="h-6 w-6 text-gray-500 dark:text-gray-400" />
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Tidak Ada Data Penjualan</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Tidak ada transaksi yang tercatat untuk periode {{ strtolower($periodTitle) }}.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
