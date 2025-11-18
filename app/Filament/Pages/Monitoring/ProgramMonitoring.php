<?php

namespace App\Filament\Pages\Monitoring;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Actions\Action;
use BackedEnum;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Tc;
use App\Models\MstFasemonitor;
use App\Models\MonitorTc;
use App\Models\Budidaya;
use App\Models\Kriteria;

class ProgramMonitoring extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.monitoring.program-monitoring';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $title = 'Program Monitoring';

    // Properties
    public ?array $data = [];
    public ?array $traceCodeDetail = null;
    public array $biayaData = [];
    public array $teknisData = [];
    public array $availableKriteria = [];
    public array $existingMonitorData = [];
    public array $progressData = [];
    public ?string $selectedTraceCode = null;

    public function mount(): void
    {
        if (!auth()->user()?->can('View:ProgramMonitoring')) {
        abort(403);
        }
        $this->form->fill();
        $this->loadProgressData();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('View:ProgramMonitoring');
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getListeners(): array
    {
        return [
            'export-biaya-excel' => 'exportBiayaExcel',
            'export-teknis-excel' => 'exportTeknisExcel',
            'export-monitoring-pdf' => 'exportMonitoringPdf',
        ];
    }

    public function exportBiayaExcel()
    {
        if (!$this->selectedTraceCode) {
            Notification::make()->warning()->title('Trace Code belum dipilih')->send();
            return;
        }

        $widget = app(\App\Filament\Widgets\MonitoringBiayaTable::class);
        $widget->traceCode = $this->selectedTraceCode;
        return $widget->exportToExcel();
    }

    public function exportMonitoringPdf()
    {
        if (!$this->selectedTraceCode) {
            Notification::make()->warning()->title('Trace Code belum dipilih')->send();
            return;
        }

        $tc = Tc::with(['komoditi', 'budidaya'])->where('tracecode', $this->selectedTraceCode)->first();

        if (!$tc) {
            Notification::make()->warning()->title('Data TC tidak ditemukan')->send();
            return;
        }

        // Ambil data Biaya (semua, termasuk yang belum diisi)
        $dataBiaya = MonitorTc::with(['fasemonitoring', 'kriteria'])
            ->where('id_tc', $tc->id_tc)
            ->whereHas('fasemonitoring', function ($query) {
                $query->where('grub_fasemonitor', 'Biaya');
            })
            ->orderBy('id_monitor')
            ->get();

        // Ambil data Teknis (semua, termasuk yang belum diisi)
        $dataTeknis = MonitorTc::with(['fasemonitoring', 'kriteria'])
            ->where('id_tc', $tc->id_tc)
            ->whereHas('fasemonitoring', function ($query) {
                $query->where('grub_fasemonitor', 'Teknis');
            })
            ->orderBy('id_monitor')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan-monitoring', [
            'tc' => $tc,
            'dataBiaya' => $dataBiaya,
            'dataTeknis' => $dataTeknis
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Laporan-Monitoring-' . $this->selectedTraceCode . '.pdf');
    }

    public function exportTeknisExcel()
    {
        if (!$this->selectedTraceCode) {
            Notification::make()->warning()->title('Trace Code belum dipilih')->send();
            return;
        }

        $widget = app(\App\Filament\Widgets\MonitoringTeknisTable::class);
        $widget->traceCode = $this->selectedTraceCode;
        return $widget->exportToExcel();
    }

    public function loadProgressData(): void
    {
        // Load data progress monitoring untuk dashboard mini
        $this->progressData = [
            'total_tc' => Tc::count(),
            'total_parameters' => MstFasemonitor::count(),
            'total_monitored_today' => MonitorTc::whereDate('tgl_monitoring', today())->count(),
            'total_monitored_all' => MonitorTc::count(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Dasar Monitoring')
                    ->description('Lengkapi informasi dasar untuk memulai monitoring')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('tgl_monitoring')
                                    ->label('Tanggal Monitoring')
                                    ->required()
                                    ->default(now())
                                    ->columnSpan(1),

                                Select::make('trace_code')
                                    ->label('Tracecode')
                                    ->options(function () {
                                        return Tc::with(['komoditi', 'budidaya'])
                                            ->get()
                                            ->pluck('tracecode', 'tracecode');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $livewire) {
                                        if ($state) {
                                            $livewire->loadTraceCodeDetail();
                                            $livewire->generateMonitoringRecords($state);
                                            $livewire->loadMonitoringReferenceData();
                                        } else {
                                            $livewire->traceCodeDetail = null;
                                            $livewire->biayaData = [];
                                            $livewire->teknisData = [];
                                            $livewire->availableKriteria = [];
                                        }
                                        // Reset all subsequent fields
                                        $set('fase_monitoring', null);
                                        $set('id_monitor', null);
                                        $set('id_kriteria', null);
                                        $set('nilai_monitor', null);
                                        $set('evaluasi_monitoring', null);
                                    })
                                    ->columnSpan(1),
                            ]),

                        // Detail TC Info (hidden until TC selected)
                        Fieldset::make('Detail Trace Code')
                            ->schema([
                                Placeholder::make('detail_info')
                                    ->content(fn() => view('components.monitoring-detail-info', [
                                        'data' => $this->traceCodeDetail ?? []
                                    ])),
                            ])
                            ->visible(fn($get) => !empty($get('trace_code'))),
                    ]),

                Section::make('Input Data Monitoring')
                    ->description('Pilih fase monitoring dan kriteria, kemudian input nilai')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                // ini buat pilih fase
                                Select::make('fase_monitoring')
                                    ->label('Fase Monitoring')
                                    ->options(function () {
                                        return MstFasemonitor::select('fase_monitoring')
                                            ->distinct()
                                            ->orderBy('fase_monitoring')
                                            ->pluck('fase_monitoring', 'fase_monitoring');
                                    })
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $livewire) {
                                        // $livewire->loadKriteriaByFase($state);
                                        // $set('id_kriteria', null);
                                        // $set('nilai_monitor', null);
                                        // $set('evaluasi_monitoring', null);
                                        $livewire->availableParameters = MstFasemonitor::where('fase_monitoring', $state)
                                            ->pluck('parameter', 'id_monitor')
                                            ->toArray();

                                        $set('id_monitor', null);
                                        $set('id_kriteria', null);
                                        $set('nilai_monitor', null);
                                        $set('evaluasi_monitoring', null);
                                    })
                                    ->visible(fn($get) => !empty($get('trace_code')))
                                    ->columnSpan(1),

                                // 2️⃣ Pilih Parameter
                                // Select::make('id_monitor')
                                //     ->label('Parameter')
                                //     ->options(fn() => $this->availableParameters ?? [])
                                //     ->required()
                                //     ->live()
                                //     ->afterStateUpdated(function ($state, $set, $livewire) {
                                //         $livewire->loadKriteriaByMonitor($state);
                                //         $set('id_kriteria', null);
                                //         $set('nilai_monitor', null);
                                //         $set('evaluasi_monitoring', null);
                                //     })
                                //     ->visible(fn($get) => !empty($get('fase_monitoring')))
                                //     ->columnSpan(1),

                                Select::make('id_monitor')
                                    ->label('Parameter')
                                    ->options(function ($get) {
                                        // Selalu tampilkan semua parameter dari fase yang dipilih
                                        $fase = $get('fase_monitoring');
                                        if (!$fase) {
                                            return [];
                                        }

                                        return MstFasemonitor::where('fase_monitoring', $fase)
                                            ->pluck('parameter', 'id_monitor')
                                            ->toArray();
                                    })
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $livewire) {
                                        $livewire->loadKriteriaByMonitor($state);
                                        $set('id_kriteria', null);
                                        $set('evaluasi_monitoring', null);
                                    })
                                    ->visible(fn($get) => !empty($get('fase_monitoring')))
                                    ->columnSpan(1),


                                // pilih kriteria
                                // Select::make('id_kriteria')
                                //     ->label('Kriteria Monitoring')
                                //     ->options(function () {
                                //         return collect($this->availableKriteria)->pluck('display_name', 'id_kriteria');
                                //     })
                                //     ->required()
                                //     ->live()
                                //     ->afterStateUpdated(function ($state, $set, $livewire) {
                                //         // Load existing data if any
                                //         $livewire->loadExistingMonitorData($state);
                                //     })
                                //     ->visible(fn($get) => !empty($get('fase_monitoring')))
                                //     ->columnSpan(1),
                                Select::make('id_kriteria')
                                    ->label('Kriteria Monitoring')
                                    ->options(fn() => collect($this->availableKriteria)->pluck('display_name', 'id_kriteria'))
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn($state, $set, $livewire) => $livewire->loadExistingMonitorData($state))
                                    ->visible(fn($get) => !empty($get('id_monitor')))
                                    ->columnSpan(1),
                            ]),

                        Grid::make(1)
                            ->schema([
                                Textarea::make('evaluasi_monitoring')
                                    ->label('Evaluasi / Catatan')
                                    ->placeholder('Tambahkan catatan evaluasi (opsional)')
                                    ->rows(3)
                                    ->visible(fn($get) => !empty($get('id_kriteria')))
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->visible(fn($get) => !empty($get('trace_code'))),
            ])
            ->statePath('data');
    }

    public function loadTraceCodeDetail(): void
    {
        $traceCode = $this->data['trace_code'] ?? null;

        // Set selected trace code for widget
        $this->selectedTraceCode = $traceCode;

        // Initialize default values
        $this->traceCodeDetail = [
            'tgl_tanam' => '-',
            'luas_tanam' => '-',
            'tdk_tc' => '-',
            'wilayah_tc' => '-',
            'jumlah_bedeng' => '-',
            'komoditi_name' => '-',
            'is_manager' => false,
            'manager_name' => '-',
            'asman_name' => '-',
        ];

        if ($traceCode) {
            $tc = Tc::with(['komoditi', 'budidaya'])->where('tracecode', $traceCode)->first();

            if ($tc && $tc->budidaya) {
                $budidaya = $tc->budidaya;

                // Cek apakah ini Manager (id_atasan null) atau Asman (id_atasan ada)
                $isManager = is_null($budidaya->id_atasan);

                $this->traceCodeDetail = [
                    'tgl_tanam' => $tc->tgl_tanam ? \Carbon\Carbon::parse($tc->tgl_tanam)->format('d/m/Y') : '-',
                    'luas_tanam' => $tc->luas_tanam ?? '-',
                    'tdk_tc' => $tc->tdk_tc ?? '-',
                    'wilayah_tc' => $tc->wilayah_tc ?? '-',
                    'jumlah_bedeng' => $tc->jumlah_bedeng ?? '-',
                    'komoditi_name' => $tc->komoditi->nm_komoditi ?? '-',
                    'is_manager' => $isManager,
                    // Jika Manager: tampilkan nama manager, jika Asman: tampilkan nama atasan (manager)
                    'manager_name' => $isManager ? ($budidaya->nm_asman_manager ?? '-') : ($budidaya->nama_atasan ?? '-'),
                    // Jika Manager: null (tidak ditampilkan), jika Asman: tampilkan nama asman
                    'asman_name' => $isManager ? null : ($budidaya->nm_asman_manager ?? '-'),
                ];
            }
        }
    }

    /**
     * Generate 35 records monitoring saat pertama kali memilih TC
     * Status TC berubah dari "belum" ke "sudah"
     */
    public function generateMonitoringRecords($traceCode): void
    {
        try {
            // Cari TC berdasarkan trace code
            $tc = Tc::where('tracecode', $traceCode)->first();

            if (!$tc) {
                return;
            }

            // Cek apakah sudah pernah di-generate (status sudah)
            if ($tc->status === 'sudah') {
                // Sudah pernah di-generate, tidak perlu generate lagi
                return;
            }

            DB::beginTransaction();

            // Ambil semua fase monitoring (35 parameter)
            $allMonitors = MstFasemonitor::with('kriteria')->get();

            if ($allMonitors->isEmpty()) {
                DB::rollBack();
                return;
            }

            $userId = Auth::id() ?? 1;
            $tglMonitoring = now()->format('Y-m-d');

            // Generate record untuk setiap fase monitoring
            foreach ($allMonitors as $monitor) {
                // Generate unique ID
                $newId = (int) (now()->format('YmdHis') . rand(1000, 9999));
                while (MonitorTc::find($newId)) {
                    $newId = (int) (now()->format('YmdHis') . rand(1000, 9999));
                }

                // Buat record monitoring dengan nilai kosong
                MonitorTc::create([
                    'id_monitor_tc' => $newId,
                    'id_user' => $userId,
                    'id_tc' => $tc->id_tc,
                    'id_kriteria' => null, // Kosong, akan diisi saat monitoring
                    'id_monitor' => $monitor->id_monitor,
                    'nilai_monitor' => null, // Kosong, akan diisi saat monitoring
                    'evalusi_monitoring' => null,
                    'tgl_monitoring' => $tglMonitoring,
                    'ket_monitor' => null,
                    'tgl_update' => now()->format('Y-m-d'),
                    'hasil' => null,
                ]);

                // Small delay to ensure unique timestamp
                usleep(1000);
            }

            // Update status TC menjadi "sudah"
            $tc->update(['status' => 'sudah']);

            DB::commit();

            Notification::make()
                ->title('Monitoring Records Generated')
                ->body('35 fase monitoring telah dibuat untuk TC: ' . $traceCode)
                ->success()
                ->send();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to generate monitoring records:', [
                'error' => $e->getMessage(),
                'trace_code' => $traceCode,
            ]);

            Notification::make()
                ->title('Gagal Generate Monitoring')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function loadMonitoringReferenceData(): void
    {
        $traceCode = $this->data['trace_code'] ?? null;

        if (!$traceCode) {
            $this->biayaData = [];
            $this->teknisData = [];
            return;
        }

        // Cari TC berdasarkan trace code
        $tc = Tc::where('tracecode', $traceCode)->first();
        if (!$tc) {
            $this->biayaData = [];
            $this->teknisData = [];
            return;
        }

        // Load semua data monitoring sebagai referensi
        $allMonitoringData = MstFasemonitor::with(['kriteria'])
            ->orderBy('grub_fasemonitor')
            ->orderBy('fase_monitoring')
            ->orderBy('parameter')
            ->get();

        // Ambil data monitoring yang sudah dilakukan untuk TC ini
        $existingMonitors = MonitorTc::where('id_tc', $tc->id_tc)
            ->with(['kriteria.mstfasemonitoring'])
            ->get();

        // Buat lookup untuk monitor yang sudah ada
        $monitoredLookup = $existingMonitors->groupBy(function ($item) {
            return $item->kriteria->id_monitor ?? null;
        });

        $processedData = $allMonitoringData->map(function ($item) use ($monitoredLookup) {
            $kriteria = $item->kriteria->first();

            // Cek apakah sudah dimonitor
            $isMonitored = $monitoredLookup->has($item->id_monitor);
            $lastMonitorData = $isMonitored ? $monitoredLookup->get($item->id_monitor)->first() : null;

            return array_merge($item->toArray(), [
                'kriteria' => $kriteria->nilai_kriteria ?? 'Tidak ada kriteria',
                'id_kriteria' => $kriteria->id_kriteria ?? null,
                'is_monitored' => $isMonitored,
                'last_monitor_value' => $lastMonitorData ? $lastMonitorData->nilai_monitor : null,
                'last_monitor_date' => $lastMonitorData ? $lastMonitorData->tgl_monitoring : null,
            ]);
        });

        // Pisahkan berdasarkan grup atau bagi 2
        $allData = $processedData->values();

        // Coba pisahkan berdasarkan grub_fasemonitor jika ada
        $biayaData = $allData->filter(function ($item) {
            return stripos($item['grub_fasemonitor'] ?? '', 'biaya') !== false ||
                stripos($item['grub_fasemonitor'] ?? '', 'cost') !== false;
        });

        $teknisData = $allData->filter(function ($item) {
            return stripos($item['grub_fasemonitor'] ?? '', 'teknis') !== false ||
                stripos($item['grub_fasemonitor'] ?? '', 'technical') !== false;
        });

        // Jika tidak ada pembagian grup yang jelas, bagi manual
        if ($biayaData->isEmpty() && $teknisData->isEmpty()) {
            $midPoint = (int) ceil($allData->count() / 2);
            $biayaData = $allData->take($midPoint);
            $teknisData = $allData->slice($midPoint);
        }

        $this->biayaData = $biayaData->values()->toArray();
        $this->teknisData = $teknisData->values()->toArray();
    }

    // public function loadKriteriaByFase($fase): void
    // {
    //     $this->availableKriteria = [];

    //     if (!$fase) {
    //         return;
    //     }

    //     // Load kriteria berdasarkan fase monitoring
    //     $monitors = MstFasemonitor::where('fase_monitoring', $fase)
    //         ->with(['kriteria'])
    //         ->get();

    //     $kriteriaList = [];
    //     foreach ($monitors as $monitor) {
    //         foreach ($monitor->kriteria as $kriteria) {
    //             $kriteriaList[] = [
    //                 'id_kriteria' => $kriteria->id_kriteria,
    //                 'id_monitor' => $monitor->id_monitor,
    //                 'parameter' => $monitor->parameter,
    //                 'monitoring_poin' => $monitor->monitoring_poin,
    //                 'kriteria_name' => $kriteria->nm_kriteria,
    //                 'kriteria_value' => $kriteria->nilai_kriteria,
    //                 'display_name' => "{$monitor->parameter} - {$kriteria->nm_kriteria} ({$kriteria->nilai_kriteria})",
    //             ];
    //         }
    //     }

    //     $this->availableKriteria = $kriteriaList;
    // }
    public function loadKriteriaByMonitor($id_monitor): void
    {
        $this->availableKriteria = [];

        if (!$id_monitor) {
            return;
        }

        $monitor = MstFasemonitor::with('kriteria')->find($id_monitor);

        if (!$monitor) {
            return;
        }

        $this->availableKriteria = $monitor->kriteria->map(function ($kriteria) use ($monitor) {
            return [
                'id_kriteria' => $kriteria->id_kriteria,
                'id_monitor' => $monitor->id_monitor,
                'parameter' => $monitor->parameter,
                'monitoring_poin' => $monitor->monitoring_poin,
                'kriteria_name' => $kriteria->nm_kriteria,
                'kriteria_value' => $kriteria->nilai_kriteria,
                'display_name' => "{$monitor->parameter} - {$kriteria->nm_kriteria} ({$kriteria->nilai_kriteria})",
            ];
        })->toArray();
    }


    public function loadExistingMonitorData($kriteriaId): void
    {
        $this->existingMonitorData = [];

        if (!$kriteriaId || !isset($this->data['trace_code'])) {
            return;
        }

        $traceCode = $this->data['trace_code'];
        $tc = Tc::where('tracecode', $traceCode)->first();

        if (!$tc) {
            return;
        }

        // Cek apakah sudah ada data monitoring untuk kriteria ini
        $existingData = MonitorTc::where('id_tc', $tc->id_tc)
            ->where('id_kriteria', $kriteriaId)
            ->latest('tgl_monitoring')
            ->first();

        if ($existingData) {
            $this->existingMonitorData = [
                'nilai_monitor' => $existingData->nilai_monitor,
                'evaluasi_monitoring' => $existingData->evalusi_monitoring,
                'tgl_monitoring' => $existingData->tgl_monitoring,
            ];

            // Pre-fill form dengan data existing
            $this->data['nilai_monitor'] = $existingData->nilai_monitor;
            $this->data['evaluasi_monitoring'] = $existingData->evalusi_monitoring;
        }
    }
    public function simpanData(): void
    {
        try {
            $data = $this->form->getState();

            // Debug logging
            Log::info('Form data received:', $data);

            // Validasi data yang diperlukan
            if (empty($data['trace_code'])) {
                Notification::make()->title('Kode Traceability wajib diisi.')->danger()->send();
                return;
            }

            if (empty($data['fase_monitoring'])) {
                Notification::make()->title('Fase Monitoring wajib diisi.')->danger()->send();
                return;
            }

            if (empty($data['id_monitor'])) {
                Notification::make()->title('Parameter Monitoring wajib dipilih.')->danger()->send();
                return;
            }

            if (empty($data['id_kriteria'])) {
                Notification::make()->title('Kriteria Monitoring wajib dipilih.')->danger()->send();
                return;
            }

            DB::beginTransaction();

            $traceCode = $data['trace_code'];
            $user_id = Auth::id() ?? 1;

            // Format tanggal dengan benar
            $tgl_monitoring = isset($data['tgl_monitoring'])
                ? \Carbon\Carbon::parse($data['tgl_monitoring'])->format('Y-m-d')
                : now()->format('Y-m-d');

            Log::info('Processing data:', [
                'trace_code' => $traceCode,
                'user_id' => $user_id,
                'tgl_monitoring' => $tgl_monitoring
            ]);

            // Cari TC berdasarkan trace code
            $tc = Tc::where('tracecode', $traceCode)->first();
            if (!$tc) {
                Notification::make()->title('Trace Code tidak ditemukan.')->danger()->send();
                DB::rollBack();
                return;
            }

            $monitor = MstFasemonitor::find($data['id_monitor']);
            if (!$monitor) {
                Notification::make()->title('Parameter Monitoring tidak ditemukan.')->danger()->send();
                DB::rollBack();
                return;
            }

            // Cari kriteria yang dipilih
            $kriteria = Kriteria::find($data['id_kriteria']);
            if (!$kriteria) {
                Notification::make()->title('Kriteria tidak ditemukan.')->danger()->send();
                DB::rollBack();
                return;
            }

            // HITUNG NILAI_MONITOR: bobot (dari mst_fasemonitor) × nilai_kriteria (dari kriteria)
            // Convert to float untuk memastikan perhitungan numerik yang benar
            // $bobot = floatval($monitor->bobot ?? 0);
            // $nilaiKriteria = floatval($kriteria->nilai_kriteria ?? 0);
            // $nilaiMonitor = $bobot * $nilaiKriteria;

            // Log::info('Calculating nilai_monitor:', [
            //     'bobot' => $bobot,
            //     'nilai_kriteria' => $nilaiKriteria,
            //     'nilai_monitor' => $nilaiMonitor,
            // ]);
            $bobot = floatval($monitor->bobot ?? 0); // contoh: 20
            $nilaiKriteria = floatval($kriteria->nilai_kriteria ?? 0); // contoh: 80

            // konversi bobot persen ke bentuk desimal
            $nilaiMonitor = ($bobot / 100) * $nilaiKriteria; // 20/100 * 80 = 16

            Log::info('Calculating nilai_monitor:', [
                'bobot' => $bobot,
                'nilai_kriteria' => $nilaiKriteria,
                'nilai_monitor' => $nilaiMonitor,
            ]);

            // Cek apakah sudah ada data monitoring untuk kombinasi ini
            $existingMonitor = MonitorTc::where('id_tc', $tc->id_tc)
                ->where('id_monitor', $data['id_monitor'])
                ->first();

            if ($existingMonitor) {
                // Update data yang sudah ada
                $existingMonitor->update([
                    'id_kriteria' => $data['id_kriteria'],
                    'nilai_monitor' => $nilaiMonitor,
                    'evalusi_monitoring' => $data['evaluasi_monitoring'] ?? '',
                    'tgl_monitoring' => $tgl_monitoring,
                    'updated_at' => now(),
                ]);

                $message = 'Data Monitoring berhasil diperbarui!';
            } else {
                // Generate unique ID untuk primary key manual
                $newId = (int) (now()->format('YmdHis') . rand(1000, 9999));

                // Pastikan ID unik
                while (MonitorTc::find($newId)) {
                    $newId = (int) (now()->format('YmdHis') . rand(1000, 9999));
                }

                // Buat data monitoring baru
                MonitorTc::create([
                    'id_monitor_tc' => $newId,
                    'id_user' => $user_id,
                    'id_tc' => $tc->id_tc,
                    'id_kriteria' => $data['id_kriteria'],
                    'id_monitor' => $monitor->id_monitor,
                    'nilai_monitor' => $nilaiMonitor,
                    'evalusi_monitoring' => $data['evaluasi_monitoring'] ?? '',
                    'tgl_monitoring' => $tgl_monitoring,
                    'ket_monitor' => '',
                    'tgl_update' => now()->format('Y-m-d'),
                    'hasil' => null, // Akan dihitung setelah semua parameter dalam fase selesai
                ]);

                $message = 'Data Monitoring berhasil disimpan!';
            }

            // HITUNG HASIL: Sum total nilai_monitor untuk satu fase
            $this->calculateHasilPerFase($tc->id_tc, $data['fase_monitoring']);

            DB::commit();

            Notification::make()->title($message)->success()->send();

            // Dispatch events untuk refresh widget
            $this->dispatch('refreshMonitoringBiaya');
            $this->dispatch('refreshMonitoringTeknis');

            // Reload reference data untuk update tabel
            $this->loadMonitoringReferenceData();

            // Reload progress data untuk update stats
            $this->loadProgressData();

            // Reset hanya kriteria dan evaluasi, biarkan fase dan parameter tetap untuk input berikutnya
            $this->data['id_kriteria'] = null;
            $this->data['evaluasi_monitoring'] = null;
            $this->availableKriteria = [];
            $this->existingMonitorData = [];

            // Reload kriteria untuk parameter yang sama
            if (!empty($data['id_monitor'])) {
                $this->loadKriteriaByMonitor($data['id_monitor']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data monitoring:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? null,
                'user_id' => $user_id ?? null,
                'tc_found' => isset($tc) ? $tc->id_tc : 'not found',
                'kriteria_found' => isset($kriteria) ? $kriteria->id_kriteria : 'not found'
            ]);
            Notification::make()
                ->title('Gagal menyimpan data.')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Hitung HASIL untuk satu fase monitoring
     * HASIL = SUM(nilai_monitor) untuk semua parameter dalam satu fase
     */
    private function calculateHasilPerFase($idTc, $faseMonitoring): void
    {
        try {
            // Ambil semua id_monitor yang termasuk dalam fase ini
            $monitorIds = MstFasemonitor::where('fase_monitoring', $faseMonitoring)
                ->pluck('id_monitor');

            if ($monitorIds->isEmpty()) {
                return;
            }

            // Ambil semua nilai_monitor dan hitung total secara manual karena kolom string
            $records = MonitorTc::where('id_tc', $idTc)
                ->whereIn('id_monitor', $monitorIds)
                ->whereNotNull('nilai_monitor')
                ->get();

            // Convert ke float dan sum
            $totalNilaiMonitor = $records->sum(function ($record) {
                return floatval($record->nilai_monitor);
            });

            // Update semua record monitoring dalam fase ini dengan hasil yang sama
            MonitorTc::where('id_tc', $idTc)
                ->whereIn('id_monitor', $monitorIds)
                ->update(['hasil' => $totalNilaiMonitor]);

            Log::info('Hasil calculated for fase:', [
                'fase' => $faseMonitoring,
                'id_tc' => $idTc,
                'total_nilai_monitor' => $totalNilaiMonitor,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to calculate hasil:', [
                'error' => $e->getMessage(),
                'id_tc' => $idTc,
                'fase' => $faseMonitoring,
            ]);
        }
    }

    public function resetForm(): void
    {
        $this->data = [];
        $this->traceCodeDetail = null;
        $this->biayaData = [];
        $this->teknisData = [];
        $this->availableKriteria = [];
        $this->existingMonitorData = [];

        // Reload progress data
        $this->loadProgressData();

        $this->form->fill();

        Notification::make()
            ->title('Form berhasil direset')
            ->success()
            ->send();
    }

    public function testConnection(): void
    {
        try {
            $tcCount = Tc::count();
            $kriteriaCount = Kriteria::count();
            $monitorCount = MstFasemonitor::count();

            Notification::make()
                ->title('Test Koneksi Database')
                ->body("TC: {$tcCount}, Kriteria: {$kriteriaCount}, Monitor: {$monitorCount}")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error Database')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
