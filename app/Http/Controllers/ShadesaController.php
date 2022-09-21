<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use File;
class ShadesaController extends Controller
{
    public function getProduk(){
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')        
        ->select('produk.*', 'bumdes.*', 'produk.id as produk_id')
        ->get();

        $pelatihan = DB::table('pelatihan')->get();

        return view('page/shadesa',compact('produk','pelatihan'));
    }

    public function enrollPelatihan($id){
        $enroll = DB::table('enroll')->insert([
            'id_pelatihan'  => $id,
            'id_bumdes'     => session('id_bumdes')
        ]);

        return redirect('/dashboard_detail_pelatihan_user/'.$id);
    }


    // api
    
    
    public function apigetPelatihan(){
        $pelatihan = DB::table('pelatihan')->get();
       return response($pelatihan);
    }
    
    public function getPelatihanById($id){
        $pelatihan = DB::table('pelatihan')        
        ->where('id_produk',$id)
        ->get();
        return response($pelatihan);    
    }
}
