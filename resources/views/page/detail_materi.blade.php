
@extends('template/dashboard_index')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"></link>
    <link rel="stylesheet" href="{{asset('assets/datatables-responsive/css/responsive.bootstrap4.min.css')}}"></link>
    <style>
        body{
            background-color:#E5E5E5;
        }
        #cover-page{            
            margin:0px;
            width:100%;
            overflow-x:hidden;
            min-height: 50vh;
            padding-top: 18vh;
            background-image: linear-gradient(to right, #03192E , #153A5C);            
        }

        #cover-page h1{
            color:white;
            font-size:26px;
            font-weight:700;
        }
        #cover-page .iso{
            width:100%;
            margin-top:3%;
        }
        #cover-page .desc{
            padding:2% 10%;
        }
        #cover-page .desc .btn{
            padding:10px 25px;
        } 

        #alur{            
            min-height:80vh;   
            width:100%;      
            margin-top:-12vh; 
            margin-bottom:10vh;                                    
        }        
        #alur .card-alur-wrapper{
            margin-top:-4%;
            min-height:100px;  
            margin-bottom:10px;                    
        }
        #alur .card-alur{            
            min-height:250px;
            background-color:#ffff;            
            cursor:pointer; 
            margin:0px;                                         
        }
        #alur  .desc{
           padding:30px 40px;
        }
        #alur .desc p{            
            font-family:nunito; 
            font-size:15px;
            margin-bottom:0px;          
        }

        #alur  .photo-produk img{
          margin-top:50px;
        }
        #alur  .photo-produk{
          padding:20px;        
        }
        #alur  .photo-produk p{
          font-size:15px;
          font-family:nunito;
          margin-top:10px;  
          margin-bottom:0px;
        }
        #alur  .photo-produk .kelengkapan-produk{
          padding-right:10px;
          padding-left:10px;          
        }
        #alur  .photo-produk .kelengkapan-produk .col-lg-4{
          padding:0px;
          text-align:center;
        }
        #alur  .photo-produk .kelengkapan-produk .btn{
          width:97%;          
          color:#ffff;
          font-size:10px;
          margin:3px;
        }


        #alur .profil-bumdes{            
            padding:0.1px;            
            margin:0px;
            margin-top:15px;
        }
        #alur .profil-bumdes .profil-wrapper{ 
          background-color:#ffff;
          margin:0;
          padding:2%;                     
        }
        #alur .profil-bumdes .profil-wrapper .profil-pelatihan{
          background-color:#ffff;
          padding:0px;
          min-height:200px;
        }
        #alur .profil-bumdes .profil-wrapper h2{
            width:100%;
            font-weight:700;
            font-size:20px;
            font-family:nunito;
        }

        #alur .profil-bumdes table .label{
            width:40%;
        }
        #alur .profil-bumdes table td{
            padding-bottom:20px;
        }
        #alur .profil-bumdes table .colon{
            width:5%;
        }
        #alur .profil-bumdes .map-area{
            width:100%;
            min-height:250px;
            background-color:#ededed;
        }

        #alur iframe{
          width:100%;
          min-height:60vh;
        }


        

        @media only screen and (max-width: 720px) {  
            #cover-page{
                min-height:70%;
            } 
            #cover-page .iso{
                display:none;
            }
            #cover-page .desc{
                text-align:center;
            }
            #cover-page .desc h1{
                font-size:40px;
            }

        }
    </style>
@endsection
@section('content')
@foreach($materi as $datas)
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-6 col-12 desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito">{{$datas->nama_pelatihan}}</h1>
                <p class="text-white nunito"></p>                
            </div>
        </div>   
</section>

<section id="alur">
    <div class="container">
        <div class="row card-alur-wrapper">                    
            <div class="col-md-12">
                <div class="card-alur desc">

                  <p style="margin-top:54px;">Materi Yang Dipelajari :</p>
                  <h2 class="nunito"><strong>{{$datas->judul_pelatihan}}</strong></h2>
                  <br>
                  <div class="video-area">
                  
                  </div>
                  <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/-HDGyYb34SY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                                    
                  <br>
                  <br>
                  <p><strong>Materi Singkat:</strong></p>
                  <p>{{$datas->caption}}</p>
                  <br>
                  <div class="row profil-bumdes">
                      <div class="row profil-wrapper col-lg-12 col-md-12 col-12">            
                          <h2 class="mb-2 ml-3 mt-1">
                            Daftar Materi  <br>
                            <small>Berikut ini adalah materi pelatihan pelatihan yang diadakan</small>
                          </h2>
                          <br>
                          <table class="table table-stripped">
                              <thead>
                                <th>No</th>
                                <th>Judul Materi</th> 
                                <th></th>                                   
                              </thead>
                              <tbody>
                                @php $no = 1; @endphp                                     
                                @foreach($video as $datavideo)
                                <tr>
                                  <td>{{$no++}}</td>
                                  <td>{{$datavideo->judul_pelatihan}}</td>
                                  <td><a href="{{url('detail_materi/'.$datavideo->id_pelatihan.'/'.$datavideo->id)}}" class="btn-sm btn-success">Pelajari&nbsp;<span class="fa fa-play"></span></a></td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>                                                                                                    
                      </div>
                  </div>  
                </div>
            </div>                    
        </div>  
    @endforeach                        
    </div>  
</section>

@endsection
@section('js')
<script src="{{asset('assets/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(function(){

        $(".video-area").html('@php echo $playervideo @endphp');
        $("#jadwalTabel").DataTable({
          "responsive": true,
            "autoWidth": false,
        });
    });
</script>
@endsection