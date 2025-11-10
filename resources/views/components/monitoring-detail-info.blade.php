{{-- resources/views/components/monitoring-detail-info.blade.php --}}
@props(['data'])

<div class="bg-white rounded-xl border border-gray-200 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="text-sm font-semibold text-gray-700 tracking-wide">Informasi Trace Code</h2>
    </div>
    <div class="px-5 py-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Tanggal Tanam</p>
                    @php($v = $data['tgl_tanam'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $v }}">{{ $v }}</p>
                </div>
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Luas Tanam</p>
                    @php($luas = $data['luas_tanam'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $luas }}">{{ $luas }}
                        @if ($luas !== '-')
                            <span class="text-xs font-normal text-gray-500">Ha</span>
                        @endif
                    </p>
                </div>
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">TDK TC</p>
                    @php($v = $data['tdk_tc'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $v }}">{{ $v }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Wilayah TC</p>
                    @php($v = $data['wilayah_tc'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $v }}">{{ $v }}</p>
                </div>
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Komoditi</p>
                    @php($v = $data['komoditi_name'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $v }}">{{ $v }}</p>
                </div>
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Budidaya</p>
                    @php($v = $data['budidaya_name'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $v }}">{{ $v }}</p>
                </div>
                <div class="group">
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Asman / Manager</p>
                    @php($v = $data['asman_manager'] ?? '-')
                    <p class="text-sm font-medium text-gray-900" title="{{ $v }}">{{ $v }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
