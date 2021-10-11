<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class KehadiranPegawaiExport implements FromView, ShouldAutoSize
{
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $kelompok_pegawai_id;
    protected $status_kehadiran;

    public function __construct($tanggal_mulai, $tanggal_selesai, $kelompok_pegawai_id)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
        $this->kelompok_pegawai_id = $kelompok_pegawai_id;
        $this->status_kehadiran = config('datareferensi.status_kehadiran');
    }

    public function view(): View
    {
        $laporan_kehadiran = DB::table('kehadiran_pegawai')->select('*')
            ->join('pegawai', 'pegawai.id', '=', 'kehadiran_pegawai.pegawai_id')
            ->join('shift', 'shift.id', '=', 'kehadiran_pegawai.shift_id')
            ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai]);

        if ($this->kelompok_pegawai_id != null) {
            $laporan_kehadiran = $laporan_kehadiran->where('kelompok_pegawai_id', $this->kelompok_pegawai_id);
        }

        $data['status_kehadiran'] = $this->status_kehadiran;
        $data['laporan_kehadiran'] = $laporan_kehadiran->get();
        return view('kehadiran-pegawai.laporan-kehadiran-excel', $data);
    }
}
