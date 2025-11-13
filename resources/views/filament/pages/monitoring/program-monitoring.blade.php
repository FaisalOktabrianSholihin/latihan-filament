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
        <h3 class="text-sm font-bold text-gray-800 mb-2">Alur Monitoring Program</h3>
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
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tabel Data Monitoring</h2>
                    <p class="text-sm text-gray-600 mt-2">Data parameter monitoring untuk Trace Code:
                        <strong>{{ $this->data['trace_code'] }}</strong>
                    </p>
                </div>
                <div>
                    <x-filament::button wire:click="$dispatch('export-monitoring-pdf')" color="danger"
                        icon="heroicon-o-document-arrow-down" size="lg">
                        <span class="font-semibold">Export PDF (Biaya & Teknis)</span>
                    </x-filament::button>
                </div>
            </div>

            {{-- Monitoring Biaya --}}
            @if ($this->selectedTraceCode)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between w-full">
                            <span class="text-xl font-bold text-gray-800">Monitoring Biaya</span>
                            <div class="flex gap-2">
                                <x-filament::button wire:click="$dispatch('export-biaya-excel')" color="success"
                                    icon="heroicon-o-arrow-down-tray" size="sm">
                                    Export Excel
                                </x-filament::button>
                            </div>
                        </div>
                    </x-slot>

                    <div class="filament-tables-container">
                        @livewire(\App\Filament\Widgets\MonitoringBiayaTable::class, ['traceCode' => $this->selectedTraceCode])
                    </div>
                </x-filament::section>
            @endif

            {{-- Monitoring Teknis --}}
            @if ($this->selectedTraceCode)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between w-full">
                            <span class="text-xl font-bold text-gray-800">Monitoring Teknis</span>
                            <div class="flex gap-2">
                                <x-filament::button wire:click="$dispatch('export-teknis-excel')" color="success"
                                    icon="heroicon-o-arrow-down-tray" size="sm">
                                    Export Excel
                                </x-filament::button>
                            </div>
                        </div>
                    </x-slot>

                    <div class="filament-tables-container">
                        @livewire(\App\Filament\Widgets\MonitoringTeknisTable::class, ['traceCode' => $this->selectedTraceCode])
                    </div>
                </x-filament::section>
            @endif
        </div>

        {{-- Footer Info --}}
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
            <div class="flex items-start gap-3">
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
