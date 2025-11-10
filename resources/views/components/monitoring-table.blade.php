{{-- resources/views/components/monitoring-table.blade.php --}}
@props(['data', 'grup'])

<div class="border border-gray-200 rounded-lg overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <caption class="p-2 text-lg font-semibold text-left text-gray-900 bg-white">
            Tabel data {{ $grup }}
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-3 py-2 w-10">No.</th>
                <th scope="col" class="px-6 py-2">Fase Monitoring</th>
                <th scope="col" class="px-6 py-2">Parameter</th>
                <th scope="col" class="px-6 py-2">Titik Kritis</th>
                <th scope="col" class="px-6 py-2">Monitoring Poin</th>
                <th scope="col" class="px-6 py-2">Kriteria</th>
                <th scope="col" class="px-6 py-2">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="px-6 py-3">{{ $item['fase_monitoring'] ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $item['parameter'] ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $item['titik_kritis'] ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $item['monitoring_poin'] ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $item['kriteria'] ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $item['keterangan'] ?? '-' }}</td>
                </tr>
            @empty
                <tr class="bg-white">
                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">Pilih **Trace Code** dan **Fase
                        Monitoring** untuk memuat data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
