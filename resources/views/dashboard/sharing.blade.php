@section('title-page')
    Sharing
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:75%;
        }
        

        @media only screen and (max-width:720px){
            .modal-dialog{
                max-width:100%;
            }         
        }
        .cover-produk{
            height:200px;
        }

        .c-pointer{
            cursor:pointer;
        }
    </style>
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row">
        <center>
            <ul class="nav nav-pills w-70">
                    <li class="nav-item">
                        <a class="nav-link " href="#" aria-current="page" id="pills-pelatihanku-tab" data-bs-toggle="pill" data-bs-target="#pelatihanku">Pelaltihan Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="pills-pelatihan-tab" data-bs-toggle="pill" data-bs-target="#pelatihan">Pelatihan Yang Dibuat</a>
                    </li>
            </ul>   
        </center> 
    </div>
    <div class="tab-content w-100">
         <div class="row mt-3 p-4 tab-pane" id="pelatihanku" role="tabpanel" aria-labelledby="pelatihanku">            
            <div class="row">    
            @foreach($enroll as $data)
                    <div class="col-md-3 c-pointer" onclick="window.location.assign('{{url('/dashboard_detail_pelatihan_user/'.$data->id)}}')">
                        <div class="card">
                            <div class="cover-produk" style="background: url('{{asset('cover_pelatihan/'.$data->foto_cover)}}');background-size:cover;"></div>
                            <div class="card-body">
                                <h5 clas="mb-0">{{$data->nama_pelatihan}}</h5>
                                <p class="mt-0">{{$data->mentor}}</p>                    
                            </div>
                        </div>                                    
                    </div>
                @endforeach                            
            </div>
        </div>

        <div class="row mt-3 p-4 tab-pane  fade show active" id="pelatihan" role="tabpanel" aria-labelledby="pelatihan">
                <div class="col-md-12 mb-4"><h5>Pelatihan Yang Telah di Buat</h5> <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalTambahPelatihan">+ Buat Pelatihan</button></div>
                <div class="row">
                    @foreach($sharing as $data)
                    <div class="col-md-3 c-pointer" onclick="window.location.assign('{{url('/dashboard_detail_pelatihan/'.$data->id)}}')">
                        <div class="card">
                            <div class="cover-produk" style="background: url('{{asset('cover_pelatihan/'.$data->foto_cover)}}');background-size:cover;"></div>
                            <div class="card-body">
                                <h5 clas="mb-0">{{$data->nama_pelatihan}}</h5>
                                <p class="mt-0">{{$data->mentor}}</p>                    
                            </div>
                        </div>                                    
                    </div>
                    @endforeach
                </div>
        </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal fade" id="modalTambahPelatihan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Buat Pelatihan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
          <form action="{{url('/tambahPelatihan')}}" method="post" enctype="multipart/form-data">
              {{csrf_field()}}
          <div class="row">
              
              <div class="col-md-6 col-12">
                    <label for="nama_produk" class="form-label">Nama Pelatihan</label>
                    <input type="text" required="required" name="judul_pelatihan" class="form-control" id="nama_produk" placeholder="">
                    <br>
                    <label for="harga_produk"  class="form-label">Mentor</label>
                    <input type="text" required="required" name="mentor" class="form-control" id="harga_produk" placeholder="">
                    <br>
                    <label>Pelatihan Berorientasi Pada Produk : </label>
                    <select name="id_produk" class="form-control" required="required">
                        @foreach($produk as $data)
                            <option value="{{$data->id}}">{{$data->nama_produk}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="deskripsi_produk" class="form-label" >Deskripsi Pelatihan</label>
                    <textarea class="form-control" required="required" name="deskripsi_pelatihan" id="" cols="30" rows="4"></textarea>
              </div>
              <div class="col-md-6">
                    <center><img src="{{asset('assets/images/noimage.png')}}" style="width:80%" alt="" id="img-prev"></center>
                    <br>
                    <label for="fotoproduk">Cover Produk</label>
                    <input type="file" name="foto_cover" required="required" id="fotoproduk" class="form-control">
                </div>
                
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">+ Tambah Data</button>
        </form>
    </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
        // $("#jadwalTabel").DataTable({
        //   "responsive": true,
        //     "autoWidth": false,
        // });

        $("#fotoproduk").change(function(){
            readURL(this,'#img-prev');
        });  
    });
</script>
@endsection