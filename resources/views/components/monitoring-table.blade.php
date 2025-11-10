{{-- resources/views/components/monitoring-table.blade.php --}}
@props(['data', 'grup'])

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead
                class="bg-gray-50/80 backdrop-blur supports-[backdrop-filter]:sticky supports-[backdrop-filter]:top-0 supports-[backdrop-filter]:z-10 border-b border-gray-200">
                <tr>
                    <th
                        class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider w-14">
                        No</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Fase
                        Monitoring</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                        Parameter</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                        Titik Kritis</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                        Monitoring Poin</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                        Kriteria</th>
                    <th
                        class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider w-20">
                        Status</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                        Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($data as $index => $item)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/60 transition-colors duration-150">
                        <td class="px-4 py-2.5 whitespace-nowrap text-center align-top">
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-gray-100 text-gray-700 font-semibold text-[11px]">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-200 whitespace-nowrap">
                                {{ $item['fase_monitoring'] ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            @php($v = $item['parameter'] ?? '-')
                            <span class="text-gray-900 font-medium truncate block max-w-xs"
                                title="{{ $v }}">{{ $v }}</span>
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            @if (isset($item['titik_kritis']) && $item['titik_kritis'] !== '-' && $item['titik_kritis'] !== null)
                                @php($v = $item['titik_kritis'])
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200"
                                    title="{{ $v }}">
                                    {{ Str::limit($v, 20) }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            @php($v = $item['monitoring_poin'] ?? '-')
                            <span class="text-gray-700 truncate block max-w-md text-xs"
                                title="{{ $v }}">{{ Str::limit($v, 30) }}</span>
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            @if (isset($item['kriteria']) && $item['kriteria'] !== 'Tidak ada kriteria')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-green-50 text-green-700 border border-green-200 whitespace-nowrap">
                                    {{ $item['kriteria'] }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">Tidak ada kriteria</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            {{-- Status monitoring bisa ditambahkan logic untuk cek apakah sudah pernah dimonitor --}}
                            @if (isset($item['is_monitored']) && $item['is_monitored'])
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-50 text-green-700 border border-green-200">
                                    ✓ Done
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 align-top">
                            @php($v = $item['keterangan'] ?? '-')
                            <span class="text-gray-600 text-xs block max-w-md truncate"
                                title="{{ $v }}">{{ Str::limit($v, 40) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-14 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m12 0h-2m-5-3v3m0 3v.01">
                                    </path>
                                </svg>
                                <p class="text-gray-600 font-medium">Belum ada data monitoring</p>
                                <p class="text-sm text-gray-400">Pilih Kode Traceability untuk memuat data referensi</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($data) > 0)
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-700">
                    Total <strong class="text-gray-900">{{ count($data) }}</strong> parameter monitoring
                    {{ $grup }}
                </span>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                        Sudah Dimonitor
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        Belum Dimonitor
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>
