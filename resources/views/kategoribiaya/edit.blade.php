@extends('layouts.app')
@section('title','Edit Kategori Biaya')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Kategori Biaya
        <small>Edit Kategori Biaya</small>
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
                  {!! Form::model($kategoribiaya,['route'=>['kategoribiaya.update',$kategoribiaya->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  @include('kategoribiaya.form')
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
