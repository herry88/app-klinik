@extends('layouts.app')
@section('title','Kelola Data Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Pasien
        <small>Daftar Pasien</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
        
              <div class="box-body">
                  <a href="{{route('pasien.create')}}" class="btn btn-info btn-social btn-flat">
                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>Pendaftaran Pasien Baru</a>
                  <a href="{{route('pasien.create')}}" class="btn btn-success btn-social btn-flat">
                      <i class="fa fa-plus-square-o" aria-hidden="true"></i>Pendaftaran Pasien Lama</a>
                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Nomor KTP</th>
                        <th>Nama Pasien</th>
                        <th>Alamat</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th width="97">#</th>
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/pasien',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'nomor_ktp', name: 'nomor_ktp' },
                { data: 'nama', name: 'nama' },
                { data: 'alamat', name: 'alamat' },
                { data: 'tempat_tanggal_lahir', name: 'tempat_tanggal_lahir' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
