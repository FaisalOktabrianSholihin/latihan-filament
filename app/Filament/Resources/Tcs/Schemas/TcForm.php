<?php

namespace App\Filament\Resources\Tcs\Schemas;

use App\Models\Budidaya;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;


class TcForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // TextInput::make('id_tc')
            //     ->label('ID TC')
            //     ->required()
            //     ->numeric()
            //     ->unique(ignoreRecord: true)
            //     ->maxLength(10),

            // Trace Code otomatis (readonly)
            TextInput::make('tracecode')
                ->label('Tracecode (Otomatis)')
                ->disabled()
                ->dehydrated(true)
                ->reactive(),

            Select::make('id_komoditi')
                ->label('Komoditi')
                ->relationship('komoditi', 'nm_komoditi')
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(
                    fn($state, callable $set, callable $get) =>
                    self::generateTraceCode($set, $get)
                ),

            // Select::make('id_budidaya')
            //     ->label('Penanggung Jawab')
            //     ->relationship('budidaya', 'nm_asman_manager')
            //     ->searchable()
            //     ->preload()
            //     ->required()
            //     ->reactive()
            //     ->afterStateUpdated(
            //         fn($state, callable $set, callable $get) =>
            //         self::generateTraceCode($set, $get)
            //     ),

            Select::make('filter_manager')
                ->label('Pilih Manager (Atasan)')
                ->options(
                    fn() => Budidaya::query()
                        // Asumsi: Manager adalah yang kolom id_atasan-nya NULL atau Kosong
                        // Sesuaikan logika ini dengan data Anda. 
                        // Jika Manager juga punya atasan (Direktur), logic ini perlu disesuaikan.
                        ->whereNull('id_atasan')
                        ->orWhere('id_atasan', '')
                        ->pluck('nm_asman_manager', 'id_asman_manager') // Value-nya Kode Asman (misal '013')
                )
                ->searchable()
                ->preload()
                ->live() // Gunakan live() agar reaktif real-time (di v3)
                ->dehydrated(false) // PENTING: Agar tidak error "column not found" saat save
                ->afterStateUpdated(function (callable $set) { // Ubah Set jadi callable
                    $set('id_budidaya', null);
                }),

            // 2. PILIH ASMAN (Penanggung Jawab)
            // Ini yang akan disimpan ke database sebagai 'id_budidaya'
            Select::make('id_budidaya')
                ->label('Penanggung Jawab (Asman)')
                ->options(function (callable $get) {
                    $managerCode = $get('filter_manager');

                    if (! $managerCode) {
                        return []; // Kosongkan jika Manager belum dipilih
                    }

                    // Cari bawahan (Asman) yang id_atasan-nya sesuai kode manager di atas
                    return Budidaya::where('id_atasan', $managerCode)
                        ->pluck('nm_asman_manager', 'id_budidaya'); // Value-nya PK (id_budidaya) untuk disimpan
                })
                ->searchable()
                ->preload()
                ->required()
                ->reactive() // Tetap reactive untuk trigger generateTraceCode
                ->afterStateUpdated(
                    fn($state, callable $set, callable $get) =>
                    self::generateTraceCode($set, $get)
                ),

            DatePicker::make('tgl_tanam')
                ->label('Tanggal Tanam')
                ->required()
                ->native(false)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    self::generateTraceCode($set, $get);
                    self::generateTdkTc($set, $state);
                }),

            TextInput::make('kode_manual')
                ->label('Kode Input (misal: A-0020)')
                ->helperText('Masukkan kode input, contoh: A-0020')
                ->reactive()
                ->required()
                ->afterStateUpdated(
                    fn($state, callable $set, callable $get) =>
                    self::generateTraceCode($set, $get)
                ),

            TextInput::make('luas_tanam')
                ->label('Luas Tanaman (Ha)')
                ->required()
                ->maxLength(50)
                ->suffix('Ha'),

            // TDK TC otomatis
            TextInput::make('tdk_tc')
                ->label('TDK TC (Otomatis)')
                ->disabled()
                ->dehydrated(true)
                ->reactive(),

            TextInput::make('wilayah_tc')
                ->label('Wilayah TC')
                ->required()
                ->maxLength(255),

            TextInput::make('jumlah_bedeng')
                ->label('Jumlah Bedeng')
                ->required()
                ->maxLength(255),
        ]);
    }

    // === Fungsi generate tracecode otomatis ===
    protected static function generateTraceCode(callable $set, callable $get): void
    {
        $tanggal = $get('tgl_tanam');
        $idBudidaya = $get('id_budidaya');
        $idKomoditi = $get('id_komoditi');
        $kodeManual = $get('kode_manual');

        if (! $tanggal || ! $idBudidaya || ! $idKomoditi || ! $kodeManual) {
            return;
        }

        // Ambil id_asman_manager dari tabel budidayas
        $budidaya = Budidaya::find($idBudidaya);
        $idAsmanManager = $budidaya?->id_asman_manager ?? '000';


        // Ambil dua digit tahun & tentukan kategori bulan
        $year = date('y', strtotime($tanggal));
        $month = date('n', strtotime($tanggal));

        $kategori = match (true) {
            $month >= 1 && $month <= 4 => 'A',
            $month >= 5 && $month <= 8 => 'B',
            default => 'C',
        };

        // ✨ Tambahan logika baru: id_komoditi jadi dua digit
        $idKomoditiFormatted = str_pad($idKomoditi, 2, '0', STR_PAD_LEFT);

        // Format final tracecode
        $traceCode = "{$year}{$kategori}.{$idAsmanManager}.{$idKomoditiFormatted}.{$kodeManual}";

        $set('tracecode', strtoupper($traceCode));
    }


    // === Fungsi generate TDK TC otomatis ===
    // protected static function generateTdkTc(callable $set, $tanggal): void
    // {
    //     if (! $tanggal) {
    //         return;
    //     }

    //     $month = date('n', strtotime($tanggal));
    //     $kategori = match (true) {
    //         $month >= 1 && $month <= 4 => 'A',
    //         $month >= 5 && $month <= 8 => 'B',
    //         default => 'C',
    //     };

    //     // Format: bulan dua digit + kategori
    //     $tdkTc = str_pad($month, 2, '0', STR_PAD_LEFT) . strtoupper($kategori);

    //     $set('tdk_tc', $tdkTc);
    // }
    protected static function generateTdkTc(callable $set, $tanggal): void
    {
        if (! $tanggal) {
            return;
        }

        $time = strtotime($tanggal);
        $month = date('n', $time);
        $day = date('j', $time);

        // Jumlah hari dalam bulan tersebut
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, date('Y', $time));

        // Tentukan batas segmen
        $segment = intdiv($totalDays, 3); // Pembagian dasar
        $sisa = $totalDays % 3; // Untuk menangani bulan yang tidak habis dibagi 3

        // Tentukan batas segmen A, B, C
        $endA = $segment;
        $endB = $segment * 2;

        // Jika ada sisa hari, tambahkan 1 hari ke segmen awal
        if ($sisa >= 1) $endA++;
        if ($sisa == 2) $endB++;

        // Tentukan kategori berdasarkan tanggal
        $kategori = match (true) {
            $day <= $endA => 'A',
            $day <= $endB => 'B',
            default => 'C',
        };

        // Format: dua digit bulan + kategori
        $tdkTc = str_pad($month, 2, '0', STR_PAD_LEFT) . $kategori;

        $set('tdk_tc', $tdkTc);
    }
}
