<?php

namespace App\Filament\Pages\Monitoring;

// Import Trait dan Contracts
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

// Import Components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Actions;
use Filament\Actions\Action as ActionsAction;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;

// Import Helpers
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan untuk mendapatkan user ID

// Import Models
use App\Models\Tc;
use App\Models\MstFasemonitor;
use App\Models\MonitorTc;
use App\Models\Budidaya;
use App\Models\Kriteria; // Tambahkan Kriteria jika Anda ingin memproses kriteria
use Filament\Schemas\Components\Actions as ComponentsActions;
use Filament\Schemas\Components\Fieldset as ComponentsFieldset;
use Filament\Schemas\Components\Form as ComponentsForm;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;

class ProgramMonitoring extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.monitoring.program-monitoring';

    protected static ?string $title = 'Program Monitoring Biaya dan Teknis Operasional';

    // Properti Form utama
    public ?array $data = [];

    // Properti untuk menampung data dinamis (Display only)
    public ?array $traceCodeDetail = null;
    public array $biayaData = [];
    public array $teknisData = [];

    // --- 1. Inisialisasi dan Listeners ---

    public function mount(): void
    {
        $this->form->fill();
        $this->loadTraceCodeDetail();
    }

    protected function getFormStateListeners(): array
    {
        return [
            'data.trace_code' => 'loadTraceCodeDetail',
            'data.fase_monitoring' => 'loadMonitoringTables',
        ];
    }

    // --- 2. Logika Pemuatan Data Dinamis (Detail & Tabel Display) ---

    public function loadTraceCodeDetail(): void
    {
        $traceCodeId = $this->data['trace_code'] ?? null;

        $this->traceCodeDetail = [
            'bedeng' => '-',
            'komoditi' => '-',
            'luas_tanam' => '-',
            'wilayah' => '-',
            'asman_manager' => '-',
            'manager' => '-',
        ];

        if ($traceCodeId) {
            // Menggunakan relasi yang tersedia di Model Tc: komoditi dan budidaya
            $tc = Tc::with(['komoditi', 'budidaya'])->find($traceCodeId);

            if ($tc) {
                // Asumsi: Budidaya memiliki relasi ke AsmanManager atau memiliki field nama manager
                $budidaya = $tc->budidaya;

                $this->traceCodeDetail = [
                    'bedeng' => $tc->jumlah_bedeng ?? '-', // Jika field 'jumlah_bedeng' ada di tabel 'tcs'
                    'komoditi' => $tc->komoditi->nm_komoditi ?? '-',
                    'luas_tanam' => $tc->luas_tanaman ?? '-',
                    'wilayah' => $tc->wilayah_tc ?? '-',
                    // Catatan: Anda perlu menyesuaikan cara mendapatkan Manager dari Model Budidaya
                    'asman_manager' => $budidaya->nm_asman_manager ?? '-', // Ambil dari Budidaya
                    'manager' => $budidaya->nm_atasan ?? '-', // Ambil dari Budidaya
                ];
            }
        }
        $this->dispatch('refreshDetailArea');
    }

    public function loadMonitoringTables(): void
    {
        $fase = $this->data['fase_monitoring'] ?? null;

        if (!$fase) {
            $this->biayaData = [];
            $this->teknisData = [];
            return;
        }

        // Ambil data mst_fasemonitors yang sesuai
        $monitorings = MstFasemonitor::where('fase_monitoring', $fase)->get();

        // Memuat kriteria yang terkait untuk ditampilkan di tabel
        $dataWithKriteria = $monitorings->map(function ($item) {
            // Ambil kriteria pertama atau set default
            $kriteria = $item->kriteria->first();
            return array_merge($item->toArray(), [
                'kriteria' => $kriteria->nilai_kriteria ?? 'Kriteria tidak ditemukan',
                'id_kriteria' => $kriteria->id_kriteria ?? null,
            ]);
        });

        // Pisahkan berdasarkan grup
        $this->biayaData = $dataWithKriteria->where('grup_fasemonitor', 'Biaya')->values()->toArray();
        $this->teknisData = $dataWithKriteria->where('grup_fasemonitor', 'Teknis')->values()->toArray();

        $this->dispatch('refreshMonitoringTables');
    }

    // --- 3. Skema Form ---
    // public function form(\Filament\Forms\FormsComponent $form): \Filament\Forms\FormsComponent
    // {
    //     // Skema Form yang sama seperti sebelumnya (hanya memastikan komponen sudah terimport)
    //     return $form
    //         ->schema([
    //             ComponentsGrid::make(2)
    //                 ->schema([
    //                     ComponentsSection::make('Trace Code & Detail')
    //                         ->schema([
    //                             Select::make('trace_code')
    //                                 ->label('Trace Code')
    //                                 ->options(Tc::all()->pluck('tracecode', 'id_tc')->toArray())
    //                                 ->searchable()
    //                                 ->required()
    //                                 ->live()
    //                                 ->afterStateUpdated(fn(callable $set) => $set('fase_monitoring', null)),

    //                             ComponentsFieldset::make('Detail Area')
    //                                 ->schema([
    //                                     Placeholder::make('detail_info')
    //                                         ->content(fn() => view('components.monitoring-detail-info', ['data' => $this->traceCodeDetail])),
    //                                 ])
    //                         ])
    //                         ->columnSpan(1),

    //                     ComponentsSection::make('Fase Monitoring & Input Data')
    //                         ->schema([
    //                             ComponentsGrid::make(2)
    //                                 ->schema([
    //                                     Select::make('fase_monitoring')
    //                                         ->label('Fase Monitoring')
    //                                         ->options(MstFasemonitor::pluck('fase_monitoring', 'fase_monitoring')->unique()->toArray())
    //                                         ->required()
    //                                         ->live(),

    //                                     Select::make('monitoring_poin')
    //                                         ->label('Monitoring Poin')
    //                                         ->options(MstFasemonitor::pluck('monitoring_poin', 'monitoring_poin')->unique()->toArray())
    //                                         ->required(),
    //                                 ]),

    //                             // Repeater untuk input nilai parameter (5 baris)
    //                             // Data di Repeater harus sesuai dengan urutan mst_fasemonitors yang ditampilkan
    //                             Repeater::make('parameter_values')
    //                                 ->label('Input Parameter')
    //                                 ->schema([
    //                                     // Placeholder yang menampilkan nama parameter dari mst_fasemonitors yang di-load
    //                                     Placeholder::make('name')
    //                                         ->label('Parameter Name')
    //                                         ->content('Parameter Name Placeholder'),

    //                                     TextInput::make('nilai_monitor')
    //                                         ->label('Nilai Input')
    //                                         ->numeric()
    //                                         ->required()
    //                                         ->placeholder('Masukkan nilai'),

    //                                     // Hidden fields untuk ID FK
    //                                     TextInput::make('id_monitor')->hidden(),
    //                                     TextInput::make('id_kriteria')->hidden(),

    //                                 ])
    //                                 ->columns(2)
    //                                 // Default Repeater harus di-set melalui mount/state, ini hanya contoh statis
    //                                 ->default(array_map(fn($i) => ['id_monitor' => $i, 'id_kriteria' => 1, 'nilai_monitor' => null], range(1, 5)))
    //                                 ->disableItemCreation()
    //                                 ->disableItemDeletion()
    //                                 ->disableItemMovement(),
    //                         ])
    //                         ->columnSpan(1),
    //                 ]),

    //             // AKSI BUTTONS
    //             ComponentsActions::make([
    //                 ActionsAction::make('ekspor')->label('Ekspor')
    //                     ->icon('heroicon-o-document-arrow-down')->color('gray')
    //                     ->action(fn() => $this->exportData()),

    //                 ActionsAction::make('simpan')->label('Simpan')
    //                     ->icon('heroicon-o-check-circle')->color('success')
    //                     ->action('simpanData'),

    //                 ActionsAction::make('update_only')->label('Update Data Only')
    //                     ->color('warning')
    //                     ->action('updateDataOnly'),
    //             ])->fullWidth()->alignCenter(),
    //         ])
    //         ->statePath('data')
    //         ->model(null);
    // }


    // public function form(): array
    // {
    //     return [
    //         ComponentsGrid::make(2)
    //             ->schema([
    //                 ComponentsSection::make('Trace Code & Detail')
    //                     ->schema([
    //                         Select::make('trace_code')
    //                             ->label('Trace Code')
    //                             ->options(Tc::all()->pluck('tracecode', 'id_tc'))
    //                             ->searchable()
    //                             ->required()
    //                             ->live()
    //                             ->afterStateUpdated(fn(callable $set) => $set('fase_monitoring', null)),

    //                         ComponentsFieldset::make('Detail Area')
    //                             ->schema([
    //                                 Placeholder::make('detail_info')
    //                                     ->content(fn() => view('components.monitoring-detail-info', [
    //                                         'data' => $this->traceCodeDetail
    //                                     ])),
    //                             ]),
    //                     ])
    //                     ->columnSpan(1),

    //                 ComponentsSection::make('Fase Monitoring & Input Data')
    //                     ->schema([
    //                         ComponentsGrid::make(2)
    //                             ->schema([
    //                                 Select::make('fase_monitoring')
    //                                     ->label('Fase Monitoring')
    //                                     ->options(MstFasemonitor::pluck('fase_monitoring', 'fase_monitoring')->unique())
    //                                     ->required()
    //                                     ->live(),

    //                                 Select::make('monitoring_poin')
    //                                     ->label('Monitoring Poin')
    //                                     ->options(MstFasemonitor::pluck('monitoring_poin', 'monitoring_poin')->unique())
    //                                     ->required(),
    //                             ]),

    //                         Repeater::make('parameter_values')
    //                             ->label('Input Parameter')
    //                             ->schema([
    //                                 Placeholder::make('name')
    //                                     ->label('Parameter Name')
    //                                     ->content('Parameter Name Placeholder'),

    //                                 TextInput::make('nilai_monitor')
    //                                     ->label('Nilai Input')
    //                                     ->numeric()
    //                                     ->required()
    //                                     ->placeholder('Masukkan nilai'),

    //                                 TextInput::make('id_monitor')->hidden(),
    //                                 TextInput::make('id_kriteria')->hidden(),
    //                             ])
    //                             ->columns(2)
    //                             ->default(array_map(
    //                                 fn($i) => ['id_monitor' => $i, 'id_kriteria' => 1, 'nilai_monitor' => null],
    //                                 range(1, 5)
    //                             ))
    //                             ->disableItemCreation()
    //                             ->disableItemDeletion()
    //                             ->disableItemMovement(),
    //                     ])
    //                     ->columnSpan(1),
    //             ]),

    //         ComponentsActions::make([
    //             ActionsAction::make('ekspor')
    //                 ->label('Ekspor')
    //                 ->icon('heroicon-o-document-arrow-down')
    //                 ->color('gray')
    //                 ->action(fn() => $this->exportData()),

    //             ActionsAction::make('simpan')
    //                 ->label('Simpan')
    //                 ->icon('heroicon-o-check-circle')
    //                 ->color('success')
    //                 ->action('simpanData'),

    //             ActionsAction::make('update_only')
    //                 ->label('Update Data Only')
    //                 ->color('warning')
    //                 ->action('updateDataOnly'),
    //         ])->fullWidth()->alignCenter(),
    //     ];
    // }

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             ComponentsGrid::make(2)
    //                 ->schema([
    //                     ComponentsSection::make('Trace Code & Detail')
    //                         ->schema([
    //                             Select::make('trace_code')
    //                                 ->label('Trace Code')
    //                                 ->options(Tc::pluck('tracecode', 'id_tc'))
    //                                 ->searchable()
    //                                 ->required()
    //                                 ->live()
    //                                 ->afterStateUpdated(fn(callable $set) => $set('fase_monitoring', null)),

    //                             ComponentsFieldset::make('Detail Area')
    //                                 ->schema([
    //                                     Placeholder::make('detail_info')
    //                                         ->content(fn() => view('components.monitoring-detail-info', [
    //                                             'data' => $this->traceCodeDetail
    //                                         ])),
    //                                 ]),
    //                         ])
    //                         ->columnSpan(1),

    //                     ComponentsSection::make('Fase Monitoring & Input Data')
    //                         ->schema([
    //                             ComponentsGrid::make(2)
    //                                 ->schema([
    //                                     Select::make('fase_monitoring')
    //                                         ->label('Fase Monitoring')
    //                                         ->options(MstFasemonitor::pluck('fase_monitoring', 'fase_monitoring')->unique())
    //                                         ->required()
    //                                         ->live(),

    //                                     Select::make('monitoring_poin')
    //                                         ->label('Monitoring Poin')
    //                                         ->options(MstFasemonitor::pluck('monitoring_poin', 'monitoring_poin')->unique())
    //                                         ->required(),
    //                                 ]),

    //                             Repeater::make('parameter_values')
    //                                 ->label('Input Parameter')
    //                                 ->schema([
    //                                     Placeholder::make('name')
    //                                         ->label('Parameter Name')
    //                                         ->content('Parameter Name Placeholder'),

    //                                     TextInput::make('nilai_monitor')
    //                                         ->label('Nilai Input')
    //                                         ->numeric()
    //                                         ->required()
    //                                         ->placeholder('Masukkan nilai'),

    //                                     TextInput::make('id_monitor')->hidden(),
    //                                     TextInput::make('id_kriteria')->hidden(),
    //                                 ])
    //                                 ->columns(2)
    //                                 ->default(array_map(
    //                                     fn($i) => ['id_monitor' => $i, 'id_kriteria' => 1, 'nilai_monitor' => null],
    //                                     range(1, 5)
    //                                 ))
    //                                 ->disableItemCreation()
    //                                 ->disableItemDeletion()
    //                                 ->disableItemMovement(),
    //                         ])
    //                         ->columnSpan(1),
    //                 ]),

    //             ComponentsActions::make([
    //                 ActionsAction::make('ekspor')
    //                     ->label('Ekspor')
    //                     ->icon('heroicon-o-document-arrow-down')
    //                     ->color('gray')
    //                     ->action(fn() => $this->exportData()),

    //                 ActionsAction::make('simpan')
    //                     ->label('Simpan')
    //                     ->icon('heroicon-o-check-circle')
    //                     ->color('success')
    //                     ->action('simpanData'),

    //                 ActionsAction::make('update_only')
    //                     ->label('Update Data Only')
    //                     ->color('warning')
    //                     ->action('updateDataOnly'),
    //             ])->fullWidth()->alignCenter(),
    //         ])
    //         ->statePath('data');
    // }


    //desainnya pake ini 
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                ComponentsGrid::make(2)
                    ->schema([
                        ComponentsSection::make('Trace Code & Detail')
                            ->schema([
                                \Filament\Forms\Components\DatePicker::make('tgl_monitoring')
                                    ->label('Tanggal Monitoring') // Opsional: Tambahkan label yang lebih jelas
                                    ->required(), // Opsional: Jadikan wajib diisi
                                // Select::make('trace_code'),
                                \Filament\Forms\Components\Select::make('trace_code')
                                    ->label('Kode Traceability') // Label yang jelas
                                    ->options(function () {
                                        // Pastikan Anda telah mengimpor model Tc di file ini
                                        // use App\Models\Tc;

                                        // Ambil semua data tracecode dari tabel tcs
                                        // Menggunakan pluck('tracecode', 'tracecode') agar nilai (value) dan labelnya sama.
                                        return \App\Models\Tc::pluck('tracecode', 'tracecode');
                                    })
                                    ->searchable() // Opsional: Memungkinkan pencarian dalam dropdown
                                    ->required()
                                    ->live() // Akan memicu form untuk di-refresh
                                    // ->afterStateUpdated(function ($state, $set, $livewire) {
                                    //     if ($state) {
                                    //         // 2. Cari data Tc berdasarkan trace_code yang dipilih
                                    //         $detail = \App\Models\Tc::where('tracecode', $state)->first();

                                    //         if ($detail) {
                                    //             // 3. Update properti $traceCodeDetail di kelas Livewire/Page
                                    //             // Pastikan Anda mengubah $livewire->traceCodeDetail menjadi $livewire->traceCodeDetail
                                    //             $livewire->traceCodeDetail = $detail->toArray();
                                    //         } else {
                                    //             $livewire->traceCodeDetail = [];
                                    //         }
                                    //     } else {
                                    //         // 4. Reset jika trace_code dikosongkan
                                    //         $livewire->traceCodeDetail = [];
                                    //     }

                                    //     // 5. Ini tidak diperlukan lagi karena $livewire->traceCodeDetail sudah di-update
                                    //     // $set('trace_code', $state); 
                                    // }),
                                    ->afterStateUpdated(function ($state, $set, $livewire) {
                                        // 1. Update traceCodeDetail
                                        if ($state) {
                                            $detail = Tc::where('tracecode', $state)->first();
                                            $livewire->traceCodeDetail = $detail ? $detail->toArray() : [];

                                            // 2. Panggil fungsi untuk memuat data tabel
                                            // Asumsi Anda menggunakan `$this->data` untuk menyimpan nilai form
                                            // Agar fungsi `loadMonitoringData` bisa mengakses nilai terbaru:
                                            $livewire->loadMonitoringData();
                                        } else {
                                            $livewire->traceCodeDetail = [];
                                            $livewire->biayaData = []; // Reset data tabel
                                            $livewire->teknisData = []; // Reset data tabel
                                        }
                                    }),
                                ComponentsFieldset::make('Detail Area')
                                    ->schema([
                                        Placeholder::make('detail_info')
                                            ->content(fn() => view('components.monitoring-detail-info', [
                                                'data' => $this->traceCodeDetail
                                            ])),
                                    ]),
                            ])
                            ->columnSpan(1),

                        ComponentsSection::make('Fase Monitoring & Input Data')
                            ->schema([
                                ComponentsGrid::make(2)
                                    ->schema([
                                        Select::make('fase_monitoring') /* ... */,
                                        Select::make('monitoring_poin') /* ... */,
                                    ]),

                                Repeater::make('parameter_values')
                                    ->schema([
                                        Placeholder::make('name') /* ... */,
                                        TextInput::make('nilai_monitor') /* ... */,
                                        TextInput::make('id_monitor')->hidden(),
                                        TextInput::make('id_kriteria')->hidden(),
                                    ])
                                    ->columns(2)
                                    // ->default(/* ... */)
                                    ->disableItemCreation()
                                    ->disableItemDeletion()
                                    ->disableItemMovement(),
                            ])
                            ->columnSpan(1),
                    ]),

                ComponentsActions::make([
                    ActionsAction::make('ekspor')->action(fn() => $this->exportData()),
                    ActionsAction::make('simpan')->action('simpanData'),
                    ActionsAction::make('isi_data')->action('updateDataOnly'),
                ])->fullWidth()->alignCenter(),
            ])
            ->statePath('data');
    }


    /**
     * Fungsi untuk memuat data monitoring berdasarkan trace_code yang dipilih.
     */
    protected function loadMonitoringData(): void
    {
        $traceCode = $this->data['tracecode'] ?? null;

        if ($traceCode) {
            // Asumsi model MonitoringItem memiliki kolom 'trace_code' dan 'grup'
            // Contoh sederhana: Ambil semua data monitoring yang terkait dengan traceCode ini.

            // Data Biaya
            $this->biayaData = MstFasemonitor::where('tracecode', $traceCode)
                ->where('grup', 'Biaya')
                ->get()
                ->toArray();

            // Data Teknis
            $this->teknisData = MstFasemonitor::where('tracecode', $traceCode)
                ->where('grup', 'Teknis')
                ->get()
                ->toArray();
        } else {
            $this->biayaData = [];
            $this->teknisData = [];
        }
    }
    // --- 4. Logika Penyimpanan Data ---

    public function simpanData(): void
    {
        try {
            $data = $this->form->getState();

            // Guard Clause
            if (!isset($data['trace_code']) || !isset($data['fase_monitoring'])) {
                Notification::make()->title('Trace Code dan Fase Monitoring wajib diisi.')->danger()->send();
                return;
            }

            DB::beginTransaction();

            $tc_id = $data['trace_code'];
            $fase_monitoring = $data['fase_monitoring'];
            $user_id = Auth::id() ?? 0; // Ambil ID user yang login

            // Gabungkan data Biaya dan Teknis yang di-load untuk mendapatkan ID
            $allMonitors = MstFasemonitor::where('fase_monitoring', $fase_monitoring)
                ->where('monitoring_poin', $data['monitoring_poin'])
                ->get();

            // Dapatkan semua kriteria yang terkait
            $kriteriaMap = Kriteria::whereIn('id_monitor', $allMonitors->pluck('id_monitor'))
                ->pluck('id_kriteria', 'id_monitor');


            // Untuk setiap input parameter di Repeater
            foreach ($data['parameter_values'] as $index => $param) {

                // Asumsi yang lebih aman: Ambil data MstFasemonitor berdasarkan urutan Repeater
                $fasemonitor = $allMonitors->get($index);

                if ($fasemonitor && $param['nilai_monitor'] !== null) {

                    // Ambil id_kriteria yang terkait dengan id_monitor ini
                    $id_kriteria_terkait = $kriteriaMap->get($fasemonitor->id_monitor);

                    MonitorTc::create([
                        'id_user' => $user_id,
                        'id_tc' => $tc_id,
                        'tracecode' => Tc::find($tc_id)->tracecode, // Dapatkan tracecode dari ID
                        'id_kriteria' => $id_kriteria_terkait,
                        'id_monitor' => $fasemonitor->id_monitor,
                        'nilai_monitor' => $param['nilai_monitor'],
                        'ket_monitoring' => $fasemonitor->parameter . ' - ' . $fase_monitoring,
                        'tgl_monitoring' => now(),
                    ]);
                }
            }

            DB::commit();

            Notification::make()->title('Data Monitoring berhasil disimpan!')->success()->send();
            $this->form->fill();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data monitoring:', ['error' => $e->getMessage()]);
            Notification::make()->title('Gagal menyimpan data.')->body($e->getMessage())->danger()->send();
        }
    }

    public function updateDataOnly(): void
    {
        // Logika update akan memerlukan pencarian record MonitorTc yang sudah ada 
        // berdasarkan id_tc dan id_monitor, lalu menggunakan updateOrCreate atau setDoc.
        Notification::make()->title('Fitur Update Belum Diimplementasikan.')->warning()->send();
    }

    public function exportData(): void
    {
        Notification::make()->title('Mengekspor data...')->info()->send();
    }
}
