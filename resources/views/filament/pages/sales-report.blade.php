<x-filament-panels::page>
    <div class="flex flex-col gap-y-6">
        <div class="flex items-center gap-x-3">
            <x-filament::input.wrapper class="max-w-xs">
                <x-filament::input.select wire:model.live="period">
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>

            <div wire:loading wire:target="period">
                <x-filament::loading-indicator class="h-5 w-5 text-gray-400" />
            </div>
        </div>

        <div wire:loading.class.delay="opacity-50" wire:target="period">
            <x-filament::section>
                <x-slot name="heading">
                    Laporan Penjualan - {{ $periodTitle }}
                </x-slot>

                <div class="fi-ta">
                    <table
                        class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr class="text-left text-sm">
                                <th
                                    class="fi-ta-header-cell w-16 px-6 py-3 font-semibold text-gray-900 dark:text-white">
                                    No.</th>
                                <th
                                    class="fi-ta-header-cell w-2/5 px-6 py-3 font-semibold text-gray-900 dark:text-white">
                                    Nama Item</th>
                                <th
                                    class="fi-ta-header-cell px-6 py-3 text-center font-semibold text-gray-900 dark:text-white">
                                    Jumlah</th>
                                <th
                                    class="fi-ta-header-cell px-6 py-3 text-right font-semibold text-gray-900 dark:text-white">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                            @forelse ($reportData['items'] as $index => $item)
                                <tr class="fi-ta-row text-sm">
                                    <td class="fi-ta-cell p-6 text-center">{{ $index + 1 }}</td>
                                    <td class="fi-ta-cell p-6">{{ $item['product_name'] }}</td>
                                    <td class="fi-ta-cell p-6 text-center">{{ $item['total_quantity'] }}</td>
                                    <td class="fi-ta-cell p-6 text-right">Rp
                                        {{ number_format($item['total_revenue'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr class="fi-ta-row text-sm">
                                    <td class="fi-ta-cell p-6 text-center" colspan="4">
                                        Tidak ada data penjualan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if (!empty($reportData['items']))
                            <tfoot class="bg-gray-50 dark:bg-white/10">
                                <tr class="text-sm font-semibold text-gray-900 dark:text-white">
                                    <td class="fi-ta-cell p-6 text-right" colspan="2">Total Keseluruhan</td>
                                    <td class="fi-ta-cell p-6 text-center">
                                        {{ number_format($reportData['totals']['total_quantity']) }}</td>
                                    <td class="fi-ta-cell p-6 text-right">Rp
                                        {{ number_format($reportData['totals']['grand_total'], 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
