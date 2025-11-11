{{-- resources/views/components/monitoring-detail-info.blade.php --}}
@props(['data'])

<div class="bg-white rounded-xl border border-gray-200 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="text-sm font-semibold text-gray-700 tracking-wide">Informasi Trace Code</h2>
    </div>
    <div class="px-5 py-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-4">
            {{-- Kolom kiri --}}
            <div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Tanggal Tanam : </span>
                    <span class="text-sm font-medium text-gray-900">{{ $data['tgl_tanam'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Luas Tanam : </span>
                    @php($luas = $data['luas_tanam'] ?? '-')
                    <span class="text-sm font-medium text-gray-900">
                        {{ $luas }} @if ($luas !== '-')
                            <span class="text-xs text-gray-500">Ha</span>
                        @endif
                    </span>
                </div>

                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">TDK TC : </span>
                    <span class="text-sm font-medium text-gray-900">{{ $data['tdk_tc'] ?? '-' }}</span>
                </div>
            </div>

            {{-- Kolom kanan --}}
            <div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Wilayah TC : </span>
                    <span class="text-sm font-medium text-gray-900">{{ $data['wilayah_tc'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Komoditi : </span>
                    <span class="text-sm font-medium text-gray-900">{{ $data['komoditi_name'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Budidaya : </span>
                    {{-- //ini nama Asman --}}
                    <span class="text-sm font-medium text-gray-900">{{ $data['budidaya_name'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Asman / Manager :
                    </span>
                    <span class="text-sm font-medium text-gray-900">{{ $data['asman_manager'] ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
