@section('title-page')
    Dashboard
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row text-center">
        @foreach($bumdes as $data)
        <h2>Selamat Datang BUMDes {{$data->nama_bumdes}} </h2>
        @endforeach
    </div>    
    <br>
    <div class="row p-30">    
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{asset('assets/images/alur1.png')}}" alt="" class="w-50 mt-2">
                    <h5 class="mt-3" ><br>Potensi dan Profil Desa</h5>
                    <p>Inputkan potensi dan lengkapi profil BUMDes anna untuk agar mamupun saling mengenal sesama bumdes </p>
                    <a href="{{url('/profile')}}" class="w-100 btn btn-warning">MULAI</a>
                </div>
            </div>
        </div>    
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{asset('assets/images/alur2.png')}}" alt="" class="w-50 mt-2">
                    <h5 class="mt-3" ><br> Sharing dan Mentoring</h5>
                    <p>Pelajari atau bagikan  potensi dan informasi pengolahan produk, agar dapat saling memperkuat insight 
                        sesama BUMDes</p>

                    <a href="{{url('/shadesa')}}" class="w-100 btn btn-warning">MULAI</a>
                </div>
            </div>
        </div>          
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{asset('assets/images/alur3.png')}}" alt="" class="w-50 mt-2">
                    <h5 class="mt-3" > <br> Pengujian</h5>
                    <p>Biarkan produk yang anda kembangkan, serta skill bisnis yang anda pelajari di validasi oleh para ahli pada program ini </p>
                    <a href="#" onclick="alert('Masih Dalam Proses Pengembangan')" class="w-100 btn btn-warning">MULAI</a>
                </div>
            </div>
        </div>  
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{asset('assets/images/alur4.png')}}" alt="" class="w-50 mt-2">
                    <h5 class="mt-3" > <br> Launching</h5>
                    <p>Melelui program ini , anda dapat meluncurkan produk anda sendiri
                        sesuai dengan standar minat masa sekarang
                    </p>
                    <a href="#" onclick="alert('Masih Dalam Proses Pengembangan')" class="w-100 btn btn-warning">MULAI</a>  
                </div>
            </div>
        </div>            
    </div>
    <!-- <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pelatihan Yang Diikuti</h5>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection