<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use File;

class ProdukController extends Controller
{
    public function uploadProduk(Request $req){
        $time_upload = date("d_m_Y_h_i_s");
        $tujuan_file = 'cover_produk/';           
        $file = $req->foto_produk;
        $ekstensi = $file->getClientOriginalExtension();
        $namafile = "$time_upload".'.'.$ekstensi;
        $pindahin =  $file->move($tujuan_file,$namafile);
        if($pindahin){
            $insert = DB::table('produk')->insert([
                'nama_produk'       => $req->nama_produk,
                'deskripsi_produk'  => $req->deskripsi_produk,
                'id_bumdes'         => session('id_bumdes'),
                'foto_produk'       => $namafile,        
                'id_kategori'       => $req->kategori,   
                'harga'             => $req->harga
            ]);
            
            return redirect('/produkku')->with('upload_berhasil','Berhasil Upload Produk');
        }else{                                                                                                             
            return redirect('/sharing')->with('upload_gagal','Maaf Upload Produk Potensi Desa Belum Berhasil');

        }        
    }   

    public function editProdukBumdes(Request $req){
        $prod = DB::table('produk')
        ->where('produk.id',$req->id_produk)        
        ->get();
        $foto = '';
        foreach($prod as $datas){
            $foto = $datas->foto_produk;
        }
        
        $myfile = 'cover_produk/'.$foto;
        if(file_exists($myfile)){
            $delete = unlink($myfile);
            if($delete){
                $time_upload = date("d_m_Y_h_i_s");
                $tujuan_file = 'cover_produk/';           
                $file = $req->foto_produk;
                $ekstensi = $file->getClientOriginalExtension();
                $namafile = "$time_upload".'.'.$ekstensi;
                $pindahin =  $file->move($tujuan_file,$namafile);
                if($pindahin){
                    $update = DB::table('produk')
                    ->where('id', $req->id_produk)
                    ->update([
                        'nama_produk'       => $req->nama_produk,
                        'deskripsi_produk'  => $req->deskripsi_produk,
                        'foto_produk'       => $namafile,
                        'harga'             => $req->harga,
                        'id_kategori'       => $req->kategori
                    ]);

                    if($update){
                        return redirect('/produkku')->with('Status', 'Success Edit');
                    }else{
                        return redirect('/produkku')->with('Status', 'Gagal Edit');
                    }
                }else{
                    echo 'Gagal Upload';
                }
            }
        }else{
            $time_upload = date("d_m_Y_h_i_s");
            $tujuan_file = 'cover_produk/';           
            $file = $req->foto_produk;
            $ekstensi = $file->getClientOriginalExtension();
            $namafile = "$time_upload".'.'.$ekstensi;
            $pindahin =  $file->move($tujuan_file,$namafile);
            if($pindahin){
                $update = DB::table('produk')
                ->where('id', $req->id_produk)
                ->update([
                    'nama_produk'       => $req->nama_produk,
                    'deskripsi_produk'  => $req->deskripsi_produk,
                    'foto_produk'       => $namafile,
                    'harga'             => $req->harga,
                    'id_kategori'       => $req->kategori
                ]);

                if($update){
                    return redirect('/produkku')->with('Status', 'Success Edit');
                }else{
                    return redirect('/produkku')->with('Status', 'Gagal Edit');
                }
            }else{
                echo 'Gagal Upload';
            }
        }
    }   

    public function produkByIdBumdes(){
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')
        ->join('kategori','produk.id_kategori','=','kategori.id')        
        ->select('produk.*','kategori.nama_kategori')
        ->where('produk.id_bumdes',session('id_bumdes'))
        ->orderBy('created_at', 'DESC')
        ->get();

        $kat = DB::table('kategori')->get();
        return view('dashboard/product',compact('produk','kat'));

    }    
    // API
    public function getProdukById($id){
        $produk = DB::table('produk')        
        ->where('produk.id',$id)
        ->get();

        $pelatihan = DB::table('pelatihan')
        ->where('id_produk',$id)
        ->get();

        $res['data'] = $produk;
        $res['pelatihan'] = $pelatihan;
        return response($res);
    }
    public function apigetProduk(){
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')        
        ->select('produk.*', 'bumdes.*', 'produk.id as produk_id')
        ->get();

        // $pelatihan = DB::table('pelatihan')->get();
       return response($produk);
    }
    public function getProdukByIdBumdes($id){
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')        
        ->select('produk.*')
        ->where('produk.id_bumdes',$id)
        ->get();

        
        // $res['data'] = $produk;
        return response($produk);
    }

    public function getProdukByKategori($id_kategori){
        $produk = DB::table('produk')
                  ->where('id_kategori',$id_kategori)
                  ->get();                  
        return response($produk);
    }

    public function searchProduk(Request $req){
        $produk = DB::table('produk')
                  ->where('nama_produk','LIKE',"%{$req->keyword}%")
                //   ->whereLike('nama_produk',$req->keyword)
                  ->get();                  
        

        $pelatihan = DB::table('pelatihan')
                  ->where('nama_pelatihan','LIKE',"%{$req->keyword}%")
                //   ->whereLike('nama_produk',$req->keyword)
                  ->get();                  
        
        $res['produk'] = $produk;
        $res['pelatihan'] = $pelatihan;
        return response($res);
    }

    public function searchingProduk(Request $req){
        $produk = DB::table('produk')
                  ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')   
                  ->where('nama_produk','LIKE',"%{$req->keyword}%")
                //   ->whereLike('nama_produk',$req->keyword)
                  ->get();                          

        return response($produk);
    }
    
    public function apiuploadProduk(Request $req){
        $time_upload = date("d_m_Y_h_i_s");
        $tujuan_file = 'cover_produk/';           
        $file = $req->foto_produk;
        $ekstensi = $file->getClientOriginalExtension();
        $namafile = "$time_upload".'.'.$ekstensi;
        $pindahin =  $file->move($tujuan_file,$namafile);
        if($pindahin){
            $insert = DB::table('produk')->insert([
                'nama_produk'       => $req->nama_produk,
                'deskripsi_produk'  => $req->deskripsi_produk,
                'id_bumdes'         => $req->id_bumdes,
                'foto_produk'       => $namafile,        
                'id_kategori'       => $req->kategori,   
                'harga'             => $req->harga
            ]);

            if($insert){
                $res['status'] = 'Success';
                $res['msg']    = 'Berhasil Menambahkan Produk';
            }
            
            $res['upload'] = 'Success Upload'; 
        }else{                                                                                                             
            $res['upload'] = 'Failed Upload';

        }        

        return response($res);
    }   


}
