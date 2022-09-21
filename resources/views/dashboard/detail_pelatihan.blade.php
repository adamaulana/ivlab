@section('title-page')
Detail Pelatihan
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-body">   
                    <h4>Tentang Pelatihan</h4>
                    @foreach($pelatihan as $data)                 
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td>Judul Pelatihan</td>
                                <td>:</td>
                                <td>{{$data->nama_pelatihan}}</td>
                            </tr>
                            <tr>
                                <td>Mentor</td>
                                <td>:</td>
                                <td>{{$data->mentor}}</td>
                            </tr>
                            <tr>
                                <td>Bumdes</td>
                                <td>:</td>
                                <td>{{$data->nama_bumdes}}</td>
                            </tr>     
                            <tr>
                            <td>Deskripsi</td>
                                <td>:</td>                                
                            </tr>         
                            <tr>
                                <td colspan="3">
                                    {{$data->deskripsi}}
                                </td>
                            </tr>              
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#tambahVideoModal">+ Tambah Video </button>
                    <h4>Daftar Video</h4>
                    <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>No</td>
                            <td width="80%">Judul Materi</td>
                            <td>Video Pembelajaran</td>
                        </tr>
                        @php $no = 1;@endphp
                        @foreach($video as $data)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$data->judul_pelatihan}}</td>
                            <td><a href="{{url('/video/'.$data->id.'/'.$data->id_pelatihan)}}" class="btn-sm btn-warning"><span class="mdi mdi-play"></span></a></td>
                        </tr>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-body">
                    @foreach($pelatihan as $data)    
                        <center><img src="{{asset('cover_pelatihan/'.$data->foto_cover)}}" style="width:80%" alt=""></center>
                    @endforeach
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Foto-->
<div class="modal fade" id="tambahVideoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Profil BUMDes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{url('/tambahVideo')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="modal-body">
        <div class="row">
            @foreach($pelatihan as $data)
            <input type="hidden" value="{{$data->id}}" name="id_pelatihan">
            @endforeach
            <div class="mb-3">
                <label for="" class="form-label">Judul Pelathihan</label>
                <input required="required" type="text" name="judul_pelatihan" value="" class="form-control" id="exampleFormControlInput1">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Link Embed Video</label>
                <input required="required" type="text" name="link_video" value="" class="form-control" >
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Deskripsi Materi </label>
                <textarea required="required" name="caption" id="" cols="30" rows="10" class="form-control">
                </textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
