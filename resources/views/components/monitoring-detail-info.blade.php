{{-- resources/views/components/monitoring-detail-info.blade.php --}}
@props(['data'])

<div class="space-y-1 text-sm">
    <div class="grid grid-cols-2 gap-x-4">
        <div>
            <p><strong>Jumlah Bedeng:</strong> {{ $data['bedeng'] ?? '-' }}</p>
            <p><strong>Komoditi:</strong> {{ $data['id_komoditi'] ?? '-' }}</p>
            <p><strong>Luas Tanam:</strong> {{ $data['luas_tanam'] ?? '-' }}</p>
            <p><strong>Wilayah:</strong> {{ $data['wilayah_tc'] ?? '-' }}</p>
        </div>
        <div>
            <p><strong>Asman:</strong> {{ $data['id_budidaya'] ?? '-' }}</p>
            <p><strong>Manager:</strong> {{ $data['nm_asman_manager'] ?? '-' }}</p>
        </div>
    </div>
</div>
