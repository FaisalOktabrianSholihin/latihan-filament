<x-filament-panels::page>
    {{-- Stats Cards --}}
    {{-- @if (!empty($this->progressData))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total TC</p>
                        <p class="text-2xl font-bold">{{ $this->progressData['total_tc'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-400/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Parameter</p>
                        <p class="text-2xl font-bold">{{ $this->progressData['total_parameters'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-400/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Monitoring Hari Ini</p>
                        <p class="text-2xl font-bold">{{ $this->progressData['total_monitored_today'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-400/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Monitoring</p>
                        <p class="text-2xl font-bold">{{ $this->progressData['total_monitored_all'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-400/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    {{-- Alert Info --}}
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 p-5 rounded-xl">
        <h3 class="text-sm font-bold text-gray-800 mb-2">🎯 Alur Monitoring Program</h3>
        <div class="text-sm text-gray-700 space-y-1">
            <p><span class="font-semibold text-blue-600">1.</span> Pilih <strong>Tanggal Monitoring</strong> dan
                <strong>Tracecode</strong>
            </p>
            <p><span class="font-semibold text-blue-600">2.</span> Lihat informasi detail TC dan <strong>Tabel
                    Referensi</strong> di bawah</p>
            <p><span class="font-semibold text-blue-600">3.</span> Pilih <strong>Fase Monitoring</strong> sesuai
                kebutuhan</p>
            <p><span class="font-semibold text-blue-600">4.</span> Pilih <strong>Parameter dan Kriteria
                    Monitoring</strong> yang
                tersedia</p>
            <p><span class="font-semibold text-blue-600">5.</span> Input <strong>Nilai Monitoring</strong> dan evaluasi
            </p>
            <p><span class="font-semibold text-blue-600">6.</span> Klik <strong>Simpan</strong> untuk menyimpan data</p>
        </div>
    </div>

    {{-- Form Input --}}
    <form wire:submit="simpanData">
        {{ $this->form }}

        {{-- Action Buttons --}}
        <div class="mt-6 flex gap-3 justify-end border-t pt-4">
            <x-filament::button type="submit" color="success" size="lg" :disabled="empty($this->data['id_kriteria'] ?? null)"
                icon="heroicon-o-check-circle">
                <span class="font-semibold">Simpan Data Monitoring</span>
            </x-filament::button>

            <x-filament::button wire:click="resetForm" color="gray" outlined size="lg"
                icon="heroicon-o-arrow-path">
                Reset Form
            </x-filament::button>

            <x-filament::button wire:click="testConnection" color="info" outlined size="lg"
                icon="heroicon-o-wrench-screwdriver">
                Test DB
            </x-filament::button>
        </div>
    </form>

    {{-- Existing Data Info --}}
    @if (!empty($this->existingMonitorData))
        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
            <div class="flex items-start gap-3">
                {{-- <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div> --}}
                <div>
                    <h4 class="font-semibold text-amber-800">Data Monitoring Sudah Ada</h4>
                    <p class="text-sm text-amber-700 mt-1">
                        Kriteria ini sudah pernah dimonitor pada tanggal
                        {{ \Carbon\Carbon::parse($this->existingMonitorData['tgl_monitoring'])->format('d/m/Y') }}
                        dengan nilai: <strong>{{ $this->existingMonitorData['nilai_monitor'] }}</strong>
                    </p>
                    <p class="text-xs text-amber-600 mt-1">Data akan diperbarui jika Anda menyimpan nilai baru.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Tabel Referensi --}}
    @if (!empty($this->data['trace_code']))
        <div class="mt-8 space-y-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">📊 Tabel Referensi Monitoring</h2>
                <p class="text-sm text-gray-600 mt-2">Data parameter monitoring untuk Trace Code:
                    <strong>{{ $this->data['trace_code'] }}</strong>
                </p>
            </div>

            {{-- History Monitoring --}}
            @php
                $traceCode = $this->data['trace_code'] ?? null;
                $tc = $traceCode ? \App\Models\Tc::where('tracecode', $traceCode)->first() : null;
                $historyData = $tc
                    ? \App\Models\MonitorTc::where('id_tc', $tc->id_tc)
                        ->with(['kriteria.mstfasemonitoring', 'user'])
                        ->orderBy('tgl_monitoring', 'desc')
                        ->limit(10)
                        ->get()
                    : collect();
            @endphp

            @if ($historyData->isNotEmpty())
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 text-white bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg font-bold text-lg shadow-lg">
                                    📈
                                </span>
                                <span class="text-xl font-bold text-gray-800">History Monitoring</span>
                            </div>
                            <span
                                class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                {{ $historyData->count() }} Record
                            </span>
                        </div>
                    </x-slot>

                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50/80 border-b border-gray-200">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            Fase</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            Parameter</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            Kriteria</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            Nilai</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            Evaluasi</th>
                                        <th
                                            class="px-4 py-3 text-left text-[11px] font-semibold text-gray-600 uppercase tracking-wider">
                                            User</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($historyData as $index => $history)
                                        <tr
                                            class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/60 transition-colors duration-150">
                                            <td class="px-4 py-2.5 text-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-purple-100 text-purple-700 font-semibold text-[10px]">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span class="text-xs text-gray-700">
                                                    {{ \Carbon\Carbon::parse($history->tgl_monitoring)->format('d/m/Y H:i') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                    {{ $history->kriteria->mstfasemonitoring->fase_monitoring ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span class="text-xs text-gray-900 font-medium">
                                                    {{ Str::limit($history->kriteria->mstfasemonitoring->parameter ?? '-', 25) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span class="text-xs text-gray-700">
                                                    {{ $history->kriteria->nilai_kriteria ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-50 text-green-700 border border-green-200">
                                                    {{ $history->nilai_monitor }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span class="text-xs text-gray-600"
                                                    title="{{ $history->evalusi_monitoring }}">
                                                    {{ Str::limit($history->evalusi_monitoring ?? 'Tidak ada evaluasi', 30) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5">
                                                <span class="text-xs text-gray-700">
                                                    {{ $history->user->name ?? 'System' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                            <p class="text-xs text-gray-600">Menampilkan 10 data monitoring terbaru</p>
                        </div>
                    </div>
                </x-filament::section>
            @endif

            {{-- Monitoring Biaya --}}
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 text-white bg-gradient-to-br from-green-500 to-green-600 rounded-lg font-bold text-lg shadow-lg">
                                💰
                            </span>
                            <span class="text-xl font-bold text-gray-800">Monitoring Biaya</span>
                        </div>
                        @if (count($this->biayaData) > 0)
                            @php
                                $monitoredCount = collect($this->biayaData)->where('is_monitored', true)->count();
                                $totalCount = count($this->biayaData);
                            @endphp
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    {{ $totalCount }} Item
                                </span>
                                @if ($monitoredCount > 0)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        {{ $monitoredCount }}/{{ $totalCount }} Monitored
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </x-slot>

                @include('components.monitoring-table', ['data' => $this->biayaData, 'grup' => 'Biaya'])
            </x-filament::section>

            {{-- Monitoring Teknis --}}
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 text-white bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg font-bold text-lg shadow-lg">
                                ⚙️
                            </span>
                            <span class="text-xl font-bold text-gray-800">Monitoring Teknis</span>
                        </div>
                        @if (count($this->teknisData) > 0)
                            @php
                                $monitoredCount = collect($this->teknisData)->where('is_monitored', true)->count();
                                $totalCount = count($this->teknisData);
                            @endphp
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    {{ $totalCount }} Item
                                </span>
                                @if ($monitoredCount > 0)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        {{ $monitoredCount }}/{{ $totalCount }} Monitored
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </x-slot>

                @include('components.monitoring-table', ['data' => $this->teknisData, 'grup' => 'Teknis'])
            </x-filament::section>
        </div>

        {{-- Footer Info --}}
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
            <div class="flex items-start gap-3">
                {{-- <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div> --}}
                <div>
                    <p class="text-sm text-gray-700">
                        <strong class="text-gray-900">Catatan Penting:</strong>
                        Tabel referensi di atas menampilkan semua parameter monitoring yang tersedia.
                        Gunakan sebagai panduan untuk memilih fase monitoring dan kriteria yang sesuai dengan kondisi
                        lapangan.
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
