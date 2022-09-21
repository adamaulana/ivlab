<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KategoriController extends Controller
{
    public function getKategori(){
        $kategori = DB::table('kategori')->get();
         return response($kategori);
    }

    public function uploadKategori(Request $req){
        $time_upload = date("d_m_Y_h_i_s");
        $tujuan_file = 'icon_kategori/';           
        $file = $req->icon_kategori;
        $ekstensi = $file->getClientOriginalExtension();
        $namafile = "$time_upload".'.'.$ekstensi;
        $pindahin =  $file->move($tujuan_file,$namafile);
        if($pindahin){
            $insert = DB::table('kategori')->insert([
                'nama_kategori'     => $req->nama_kategori,
                'nama_file'       => $namafile                     
            ]);

            if($insert == 1){
                $res['status'] = 'sukses tambah data';
            }else{
                $res['status'] = 'gagal tambah data';
            }
            
            $res['upload'] = 'Upload Sukses';
        }else{                                                                                                             
            $res['upload'] = 'Upload Gagal';

        }  

        return response($res);
    }   
           
}
