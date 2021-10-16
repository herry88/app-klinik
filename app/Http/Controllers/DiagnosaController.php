<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Diagnosa;
use App\Http\Requests\DiagnosaStoreRequest;
use App\Models\PendaftaranDiagnosa;

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Diagnosa::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'diagnosa/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/diagnosa/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->addColumn('aktif', function ($row) {
                    return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('diagnosa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('diagnosa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiagnosaStoreRequest $request)
    {
        Diagnosa::create($request->all());
        return redirect(route('diagnosa.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['diagnosa'] = Diagnosa::findOrFail($id);
        return view('diagnosa.edit', $data);
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
        $diagnosa = Diagnosa::findOrFail($id);
        $diagnosa->update($request->all());
        return redirect(route('diagnosa.index'))->with('message', 'Data Diagnosa Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diagnosa = Diagnosa::findOrFail($id);
        $diagnosa->delete();
        return redirect(route('diagnosa.index'))->with('message', 'Data Diagnosa Berhasil Dihapus');
    }

    public function riwayatDiagnosa(Request $request)
    {
        $riwayatDiagnosa = PendaftaranDiagnosa::with('icd')->where('pendaftaran_id', $request->id)->get();

        if ($request->ajax()) {
            return DataTables::of($riwayatDiagnosa)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
