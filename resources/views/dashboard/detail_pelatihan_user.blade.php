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
                    <br>
                    <a href="{{url('/unEnroll')}}" class="btn btn-danger">Tinggalkan Pelatihan Ini</a>
                </div>

                
            </div>
        </div>
    </div>
</div>

@endsection
