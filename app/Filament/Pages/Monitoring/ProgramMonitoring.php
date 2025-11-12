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

    public function mount(): void
    {
        $this->form->fill();
        $this->loadProgressData();
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
                                    ->label('Kode Traceability')
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
                                        // Jika sudah ada daftar parameter yang dimuat sebelumnya
                                        if (!empty($this->availableParameters)) {
                                            return $this->availableParameters;
                                        }

                                        // Jika tidak ada tapi sudah ada id_monitor yang terpilih
                                        $selectedMonitor = $get('id_monitor');
                                        if ($selectedMonitor) {
                                            $monitor = \App\Models\MstFasemonitor::find($selectedMonitor);
                                            if ($monitor) {
                                                return [$monitor->id_monitor => $monitor->parameter];
                                            }
                                        }

                                        // Default: kosong
                                        return [];
                                    })
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $livewire) {
                                        $livewire->loadKriteriaByMonitor($state);
                                        $set('id_kriteria', null);
                                        $set('nilai_monitor', null);
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

                        Grid::make(2)
                            ->schema([
                                TextInput::make('nilai_monitor')
                                    ->label('Nilai Monitoring')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan nilai monitoring')
                                    ->visible(fn($get) => !empty($get('id_kriteria')))
                                    ->columnSpan(1),

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

        // Initialize default values
        $this->traceCodeDetail = [
            'tgl_tanam' => '-',
            'luas_tanam' => '-',
            'tdk_tc' => '-',
            'wilayah_tc' => '-',
            'jumlah_bedeng' => '-',
            'komoditi_name' => '-',
            'budidaya_name' => '-',
            'asman_manager' => '-',
        ];

        if ($traceCode) {
            $tc = Tc::with(['komoditi', 'budidaya'])->where('tracecode', $traceCode)->first();

            if ($tc) {
                $this->traceCodeDetail = [
                    'tgl_tanam' => $tc->tgl_tanam ? \Carbon\Carbon::parse($tc->tgl_tanam)->format('d/m/Y') : '-',
                    'luas_tanam' => $tc->luas_tanam ?? '-',
                    'tdk_tc' => $tc->tdk_tc ?? '-',
                    'wilayah_tc' => $tc->wilayah_tc ?? '-',
                    'jumlah_bedeng' => $tc->jumlah_bedeng ?? '-',
                    'komoditi_name' => $tc->komoditi->nm_komoditi ?? '-',
                    'budidaya_name' => $tc->budidaya->nm_asman_manager ?? '-',
                    'asman_manager' => $tc->budidaya->nm_asman_manager ?? '-',
                ];
            }
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

            if (empty($data['nilai_monitor'])) {
                Notification::make()->title('Nilai Monitoring wajib diisi.')->danger()->send();
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

            // Cek apakah sudah ada data monitoring untuk kombinasi ini pada tanggal yang sama
            $existingMonitor = MonitorTc::where('id_tc', $tc->id_tc)
                ->where('id_kriteria', $data['id_kriteria'])
                ->whereDate('tgl_monitoring', $tgl_monitoring)
                ->first();

            if ($existingMonitor) {
                // Update data yang sudah ada
                $existingMonitor->update([
                    'nilai_monitor' => $data['nilai_monitor'],
                    'evalusi_monitoring' => $data['evaluasi_monitoring'] ?? '',
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
                    'id_monitor' => $kriteria->id_monitor,
                    'nilai_monitor' => $data['nilai_monitor'],
                    'evalusi_monitoring' => $data['evaluasi_monitoring'] ?? '',
                    'tgl_monitoring' => $tgl_monitoring,
                    'ket_monitor' => '',
                    'tgl_update' => now()->format('Y-m-d'),
                    'hasil' => '',
                ]);

                $message = 'Data Monitoring berhasil disimpan!';
            }

            DB::commit();

            Notification::make()->title($message)->success()->send();

            // Reload reference data untuk update tabel
            $this->loadMonitoringReferenceData();

            // Reload progress data untuk update stats
            $this->loadProgressData();

            // Reset form input monitoring saja, biarkan TC detail tetap
            $this->data['fase_monitoring'] = null;
            $this->data['id_kriteria'] = null;
            $this->data['nilai_monitor'] = null;
            $this->data['evaluasi_monitoring'] = null;
            $this->availableKriteria = [];
            $this->existingMonitorData = [];
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
