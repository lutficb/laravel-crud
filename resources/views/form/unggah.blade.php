
@extends('layouts.app')

@section('content')
  <center>
    <h1>Form Sederhana</h1>
    <div class="container">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @if (\Session::has('berhasil'))
      <div class="alert alert-success">
        <p>{{\Session::get('berhasil')}}</p>
      </div>
      @endif
      <form method="post" action="{{url('form/submit')}}">
      {{csrf_field()}}
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="nama">Nama :</label>
            <input type="text" class="form-control" name="nama" value="{{$data[0]}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" value="{{$data[1]}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="tgl_lahir">Tanggal Lahir :</label>
            <input type="date" class="form-control" name="tgl_lahir" value="{{$data[2]}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="alamat">Alamat :</label>
            <textarea type="text" class="form-control" name="alamat">{{$data[3]}}</textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-right:10px">Submit</button>
            <form method="get" action="{{url('form/reset')}}">
              <button type="reset" class="btn btn-warning" style="margin-left:10px">Reset</button>
            </form>
          </div>
        </div>
      </form>
    </div>
  </center>
@endsection
