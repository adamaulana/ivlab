
@extends('template/dashboard_index')
@section('css')
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
            position: relative;
            min-height:80vh;   
            width:100%;      
            margin-top:-8vh; 
            margin-bottom:10vh;                                    
        }
        #alur .col-md-3{
            padding:10px;
        }
        #alur .card-alur-wrapper{
            margin-top:-4%;                      
        }
        #alur .card-alur{
            background-color:#ffff;
            min-height:250px;
            text-align:center;
            cursor:pointer;                                 
        }
        #alur .card-alur img{
            width:40%;
            margin-top: 30%;
        }
        #alur .card-alur p{
            margin-top:10px;
            font-weight:700;
        }

        #alur .profil-bumdes{
            background-color:#fff;
            padding:0.1px;
            margin:0px;
            margin-top:15px;
        }
        #alur .profil-bumdes .profil-wrapper{
            margin:4%;
            width:100%;
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
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-6 col-12 desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito"><span class="color-main">Selamat Datang</span><br> BUMDES {{session('nama_bumdes')}}<span></h1>
                <p class="text-white nunito"></p>                
            </div>
        </div>   
</section>

<section id="alur">
    <div class="container">
        <div class="row card-alur-wrapper">
            <div class="col-md-3" onclick="window.location.href='{{url('/dashboard')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur1.png')}}" alt="">
                    <p class="nunito">Profil Bumdes</p>
                </div>
            </div>
            <div class="col-md-3" onclick="window.location.href='{{url('/sharing')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur2.png')}}" alt="">
                    <p class="nunito">Sharing dan Mentoring</p>
                </div>
            </div>
            <div class="col-md-3" onclick="window.location.href='{{url('/dashboard_ujicoba')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur3.png')}}" alt="">
                    <p class="nunito">Uji Coba Produk</p>
                </div>
            </div>
            <div class="col-md-3" onclick="window.location.href='{{url('/dashboard_launching')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur4.png')}}" alt="">
                    <p class="nunito">Launching Produk</p>                
                </div>
            </div>                        
        </div>

        @foreach($bumdes as $data)
        <div class="row profil-bumdes">
            <div class="row profil-wrapper">
                <div class="col-md-10 col-lg-10 col-sm-12 col-12">
                    <h2>Informasi Badan Usaha Milik Desa</h2><button class="btn bt-main">Edit Profil Desa</button>                     
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <br>
                    <table>
                        <tr>
                            <td class="nunito label"><strong>Nama Bumdes</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->nama_bumdes}}</td>
                        </tr>
                        <tr>
                            <td class="nunito label"><strong>Kelurahan / Desa</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->desa}}</td>
                        </tr>                        
                        <tr>
                            <td class="nunito label"><strong>Kecamatan</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">-</td>
                        </tr>                      
                        <tr>
                            <td class="nunito label"><strong>Kabupaten / Kota</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">-</td>
                        </tr>                                                
                        <tr>
                            <td class="nunito label"><strong>Status</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito"><span class="bade badge-success"> Aktif</span></td>
                        </tr>                      

                        <tr>
                            <td class="nunito label"><strong>Email</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->email}}</td>
                        </tr>                      

                        <tr>
                            <td class="nunito label"><strong>Ketua Bumdes</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">-</td>
                        </tr>                      

                    </table>
                </div>
                @endforeach
                <div class="col-md-6 col-sm-12 col-12">
                    <p class="nunito"><strong>Lokasi Bumdes :</strong></p>
                    <div class="map-area" id="map-area"> 
                    
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>
@endsection
@section('js')
<script>  
  function initMap(){
     var map = new google.maps.Map(document.getElementById('map-area'), {
        zoom: 10,
        center: new google.maps.LatLng(-7.715149994966249, 112.80859670456456),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

     marker = new google.maps.Marker({
      position: new google.maps.LatLng(-7.715149994966249, 112.80859670456456),      
      map : map
     });
  }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-qaQX8HId_x223Rd74bNlpTVyg6k3AY&libraries=places&callback=initMap"
  async defer></script>
@endsection