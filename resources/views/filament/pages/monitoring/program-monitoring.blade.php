{{-- resources/views/filament/pages/monitoring/program-monitoring.blade.php --}}

<x-filament-panels::page>
    <form wire:submit.prevent="simpanData" class="space-y-6">
        {{ $this->form }}
    </form>

    <x-filament::section>
        <x-slot name="heading">A. Biaya</x-slot>
        {{-- Menggunakan key Livewire untuk memaksa refresh saat data berubah --}}
        <div wire:key="biaya-table-{{ json_encode($this->biayaData) }}">
            @include('components.monitoring-table', ['data' => $this->biayaData, 'grup' => 'Biaya'])
        </div>
        <p class="text-sm text-gray-500 mt-2">NILAI MONITORING (NILAI AKAN DITAMPILKAN SECARA TERPISAH)</p>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">B. Teknis</x-slot>
        <div wire:key="teknis-table-{{ json_encode($this->teknisData) }}">
            @include('components.monitoring-table', ['data' => $this->teknisData, 'grup' => 'Teknis'])
        </div>
        <p class="text-sm text-gray-500 mt-2">NILAI MONITORING (NILAI AKAN DITAMPILKAN SECARA TERPISAH)</p>
    </x-filament::section>

</x-filament-panels::page>
