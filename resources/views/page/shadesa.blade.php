
@extends('template/lightindex')
@section('css')
    <style>
        #shadesa-cover{
            min-height:90vh;
        }
        #shadesa-cover .title h1{
            margin-top:35vh;
            font-size:48px;
            font-weight:700;
            font-family:nunito;
        }
        #shadesa-cover .title p{
            font-family:nunito;
            font-size:24px;

        }
        #shadesa-cover .title input{
            border-radius:10px;
        }
        #shadesa-cover .ilus img{
            margin-top:24vh;
            width:100%;
        }
        #pelatihan{
            margin-top:2%;
        }
        #produk-potensi h3{
            width:100%;
            font-weight:700;
            margin-bottom:0px;
            line-height:20px;
        }        
        #pelatihan h3{
            width:100%;
            font-weight:700;            
            margin-bottom:0px;
            line-height:20px;
        }        

        #pelatihan {
            width:100%;
            font-weight:700;            
            margin-bottom:0px;
            line-height:20px;
            padding-bottom:5%;
        }        

        @media only screen and (max-width: 720px) { 
            #shadesa-cover {                
                min-height:60vh;
            }
            #shadesa-cover .title{
                margin-bottom:10vh;
            }
            #shadesa-cover .title .form-group{
                padding-right:20px;
                padding-left:20px;
            }
            #shadesa-cover .title h1{
                text-align:center;
                margin-top:21vh;
            }
            #shadesa-cover .title p{
                text-align:center;
            }
            
            #shadesa-cover .ilus{
                display:none
            }
            #produk-potensi h3{
                text-align:center;
                font-size:17px;
                height:19px;
                line-height:20px;
            }
            #pelatihan h3{
                text-align:center;
                font-size:17px;
                height:19px;
                line-height:20px;
            }
        }
    </style>
@endsection
@section('content')    
    <div class="container">
        <div class="row" id="shadesa-cover">
            <div class="col-md-5 col-lg-5 title" data-aos="fade-right" data-aos-duration="1500">
                <h1><span class="color-main">Sha</span><span class="color-lblue">desa</span></h1>
                <p>Cari Pelajari dan Berbagi, Temukan Potensi Emas Dalam Desa Kita</p>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Cari Referensi Potensi">
                </div>
            </div>
            <div class="col-md-7 col-lg-7 ilus text-center">
                <img  data-aos="fade-up" data-aos-duration="1500" src="{{asset('assets/images/sharing.png')}}" alt="">
            </div>
        </div>
        <div id="produk-potensi">                      
            <h3 class="nunito">Produk Potensi Desa <br> <br></h3>
            <div class="row">
                @foreach($produk as $data)
                <!-- card produk -->                
                <div class="col-md-3 col-lg-3 col-6 product-wrapper" data-aos="fade-up" data-aos-duration="1500" onclick="window.location.href='{{url('/detail_produk/'.$data->produk_id)}}'">
                    <div class="card-produk">
                        <div class="cover-produk" style="background:url('{{asset('cover_produk/'.$data->foto_produk)}}');background-size:cover;"></div>
                        <div class="desc-produk">
                            <h5>{{$data->nama_produk}}</h5>
                            <p>{{$data->nama_bumdes}}</p>
                        </div>
                    </div>                    
                </div>    
                                         
                <!-- end card produk -->  
                @endforeach    
            </div>
        </div>

        <div id="pelatihan">                      
            <h3 class="nunito">Pelatihan dan Sharing <br> <br></h3>
            <div class="row">                
                <!-- card produk -->                
                @foreach($pelatihan as $data)
                    <div class="col-lg-4 col-md-4 col-12">                       
                      <div class="card-pelatihan">
                          <div class="cover-card">
                            <img src="{{asset('cover_pelatihan/'.$data->foto_cover)}}" alt="">
                          </div>
                          <div class="caption-card">                      
                            <a href="{{url('/detail_pelatihan/'.$data->id)}}">
                              <span class="fa fa-sign-in-alt"></span>
                            </a>
                            <p>{{$data->nama_pelatihan}}
                              <br>
                              <p class="mentor"><span class="fa fa-user"></span> &nbsp;{{$data->mentor}}</p>
                            </p>
                            
                          </div>
                        </div>  
                        <br><br>                   
                    </div>
                  @endforeach           
                <!-- end card produk -->                  
            </div>
        </div>
    </div>
@endsection