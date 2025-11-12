{{-- resources/views/components/monitoring-table.blade.php --}}
@props(['data', 'grup'])

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="p-4">
        <table id="monitoringTable" class="min-w-full text-sm border-collapse">
            <thead class="bg-gray-50/80 border-b border-gray-200 text-[11px] uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Fase Monitoring</th>
                    <th class="px-4 py-3 text-left font-semibold">Parameter</th>
                    <th class="px-4 py-3 text-left font-semibold">Titik Kritis</th>
                    <th class="px-4 py-3 text-left font-semibold">Monitoring Poin</th>
                    <th class="px-4 py-3 text-left font-semibold">Kriteria</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-xs">
                @forelse ($data as $index => $item)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-4 py-2 text-center">
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-gray-100 text-gray-700 font-semibold">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $item['fase_monitoring'] ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 font-medium text-gray-800">{{ $item['parameter'] ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if (!empty($item['titik_kritis']) && $item['titik_kritis'] !== '-')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ Str::limit($item['titik_kritis'], 20) }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-700">{{ Str::limit($item['monitoring_poin'] ?? '-', 30) }}</td>
                        <td class="px-4 py-2">
                            @if (isset($item['kriteria']) && $item['kriteria'] !== 'Tidak ada kriteria')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 border border-green-200">
                                    {{ $item['kriteria'] }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">Tidak ada kriteria</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if (!empty($item['is_monitored']))
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-50 text-green-700 border border-green-200 text-[10px] font-medium">
                                    ✓ Done
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-50 text-gray-600 border border-gray-200 text-[10px] font-medium">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-600">{{ Str::limit($item['keterangan'] ?? '-', 40) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                            <p class="font-medium">Belum ada data monitoring</p>
                            <p class="text-xs text-gray-400">Pilih Kode Traceability untuk memuat data</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (count($data) > 0)
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 text-sm flex justify-between items-center">
            <span>Total <strong>{{ count($data) }}</strong> parameter monitoring {{ $grup }}</span>
            <div class="flex items-center gap-3 text-xs text-gray-500">
                <span class="flex items-center gap-1"><span class="w-2 h-2 bg-green-400 rounded-full"></span> Sudah
                    Dimonitor</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 bg-gray-400 rounded-full"></span> Belum
                    Dimonitor</span>
            </div>
        </div>
    @endif
</div>

{{-- Tambahkan DataTables + Buttons --}}
@pushOnce('scripts')
    {{-- DataTables core + Tailwind theme --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.tailwindcss.css" />
    {{-- DataTables Buttons extension --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css" />

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.querySelector('#monitoringTable');
            if (!table) return;

            new DataTable('#monitoringTable', {
                responsive: true,
                pageLength: 10,
                ordering: true,
                dom: '<"flex justify-between items-center mb-3"Bf>rt<"flex justify-between items-center mt-3"lip>',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '📋 Copy',
                        className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-3 py-1 rounded-md border border-gray-300'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '🧾 Excel',
                        className: 'bg-green-100 hover:bg-green-200 text-green-700 font-medium px-3 py-1 rounded-md border border-green-300'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 PDF',
                        className: 'bg-red-100 hover:bg-red-200 text-red-700 font-medium px-3 py-1 rounded-md border border-red-300'
                    },
                    {
                        extend: 'print',
                        text: '🖨️ Print',
                        className: 'bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium px-3 py-1 rounded-md border border-blue-300'
                    }
                ],
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    zeroRecords: "Tidak ditemukan data yang cocok"
                }
            });
        });
    </script>
@endPushOnce
