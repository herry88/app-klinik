@extends('layouts.app')
@section('title','Kelola Jenis Pemeriksaan Laboratorium')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Jenis Pemeriksaan Laboratorium
        <small>Daftar Jenis Pemeriksaan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Jenis Pemeriksaan Laboratorium</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
        
              <div class="box-body">
                  <a href="{{route('jenis-pemeriksaan-lab.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                     Tambah Data</a>
                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="jenis-pemeriksaan-lab-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Nama Jenis Pemeriksaan</th>
                        <th width="100">#</th>
                      </tr>
                  </thead>
              </table>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function() {
        $('#jenis-pemeriksaan-lab-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/jenis-pemeriksaan-lab',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'nama_jenis', name: 'nama_jenis' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush