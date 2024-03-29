<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Tindakan;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\Poliklinik;
use App\Models\TindakanBHP;
use App\Models\Barang;
use App\Http\Requests\TindakanStoreRequest;

class TindakanController extends Controller
{
    public $object_fee;


    public function __construct()
    {
        $this->object_fee   = config('datareferensi.object_fee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Tindakan::all())
            ->addColumn('action', function ($row) {
                $btn = "<a href='/tindakan/" . $row->id . "' class='btn btn-danger btn-sm ' style='margin-right:10px'><i class='fa fa-eye'></i></a>";
                $btn .= \Form::open(['url' => 'tindakan/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/tindakan/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->editColumn('kode', function ($row) {
                return $row->icd->code;
            })
            ->editColumn('jenis', function ($row) {
                return config('datareferensi.jenis_tindakan')[$row->jenis];
            })
            ->addColumn('aktif', function ($row) {
                return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('tindakan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['jenis']      = ['Umum','Perusahaan','Bpjs'];
        $data['object']     = $this->object_fee;
        return view('tindakan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TindakanStoreRequest $request)
    {
        $request['pembagian_tarif'] = serialize($request->pembagian_tarif);
        Tindakan::create($request->all());
        return redirect(route('tindakan.index'))->with('message', 'Data Tindakan Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data['barang']     = Barang::all();
        $data['tindakan']   = Tindakan::findOrFail($id);
        if ($data['tindakan']->jenis == 'tindakan_laboratorium') {
            return view('tindakan.indikator', $data);
        } else {
            return view('tindakan.show', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['tindakan']   = Tindakan::findOrFail($id);
        $data['object']     = $this->object_fee;
        $data['jenis']      = ['Umum','Perusahaan','Bpjs'];
        return view('tindakan.edit', $data);
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
        $tindakan = Tindakan::findOrFail($id);
        $request['pembagian_tarif'] = serialize($request->pembagian_tarif);
        $tindakan->update($request->all());
        return redirect(route('tindakan.index'))->with('message', 'Data tindakan Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        TindakanBHP::where('tindakan_id', $tindakan->id)->delete();
        $tindakan->delete();
        return redirect(route('tindakan.index'))->with('message', 'Data tindakan Berhasil Dihapus');
    }
}
