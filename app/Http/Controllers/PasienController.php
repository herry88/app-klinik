<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Pasien;
use App\Http\Requests\PasienStoreRequest;
use App\Models\Poliklinik;
use App\Models\Pendaftaran;

use App\Models\Province;
use App\Models\Regency;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use PDF;

class PasienController extends Controller
{
    protected $agama;
    protected $jenjang_pendidikan;
    protected $status_pernikahan;
    protected $kewarganegaraan;
    protected $golongan_darah;
    protected $privilage_khusus;
    protected $hubungan_pasien;
    protected $penjamin;

    public function __construct()
    {
        $this->agama              = config('datareferensi.agama');
        $this->jenjang_pendidikan = config('datareferensi.jenjang_pendidikan');
        $this->status_pernikahan  = config('datareferensi.status_pernikahan');
        $this->kewarganegaraan    = config('datareferensi.kewarganegaraan');
        $this->golongan_darah     = config('datareferensi.golongan_darah');
        $this->privilage_khusus   = config('datareferensi.privilage_khusus');
        $this->hubungan_pasien    = config('datareferensi.hubungan_pasien');
        $this->penjamin           = config('datareferensi.penjamin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pasien::all())
                ->addColumn('tempat_tanggal_lahir', function ($row) {
                    return $row->tempat_lahir . ', ' . $row->tanggal_lahir;
                })
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pasien/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    // $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/diagnosa"><i class="fa fa-user" aria-hidden="true"></i></a>';
                    // $btn .= '<a title="Pendaftaran Baru" class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pasien.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['agama']              = $this->agama;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        $data['status_pernikahan']  = $this->status_pernikahan;
        $data['kewarganegaraan']    = $this->kewarganegaraan;
        $data['golongan_darah']     = $this->golongan_darah;
        $data['privilage_khusus']   = $this->privilage_khusus;
        $data['hubungan_pasien']    = $this->hubungan_pasien;
        $data['penjamin']           = $this->penjamin;

        $data['provinces'] = Province::pluck('name', 'id');
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        return view('pasien.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PasienStoreRequest $request)
    {
        $data               =   $request->all();
        $pasien             =   Pasien::create($data);
        $data['pasien_id']  =   $pasien->id;
        $pendaftaran        =   Pendaftaran::create($data);
        return redirect('/pendaftaran/'.$pendaftaran->id.'/cetak');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pasien'] = Pasien::findOrFail($id);
        $data['agama'] = $this->agama;
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        return view('pasien.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pasien'] = Pasien::findOrFail($id);
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['agama']  = $this->agama;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        return view('pasien.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());
        return redirect(route('pasien.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        return redirect(route('pasien.index'))->with('message', 'Data Berhasil Dihapus');
    }
    
}
