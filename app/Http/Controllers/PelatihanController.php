<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use File;

class PelatihanController extends Controller
{
    public function uploadPelatihan(Request $req){
        $time_upload = date("d_m_Y_h_i_s");
        $tujuan_file = 'cover_pelatihan/';           
        $file = $req->foto_cover;
        $ekstensi = $file->getClientOriginalExtension();
        $namafile = "$time_upload".'.'.$ekstensi;
        $pindahin =  $file->move($tujuan_file,$namafile);
        if($pindahin){
            $insert = DB::table('pelatihan')->insert([
                'nama_pelatihan'        => $req->judul_pelatihan,
                'deskripsi'             => $req->deskripsi_pelatihan,
                'id_bumdes'             => session('id_bumdes'),
                'foto_cover'            => $namafile,                           
                'mentor'                => $req->mentor,
                'id_produk'             => $req->id_produk
            ]);
            
            return redirect('/sharing')->with('status','Berhasil Upload Produk');
        }else{                                          
            echo 'gagal';                                                                   
            // return redirect('/sharing')->with('status','Maaf Upload Produk Potensi Desa Belum Berhasil');

        }        
    }  

    public function enrollPelatihan(Request $request)
    {
        
        $countenroll = DB::table('enroll')
        ->where('enroll.id_bumdes',$request->id_bumdes)
        ->where('enroll.id_pelatihan',$request->id_pelatihan)
        ->count();
        

        if($countenroll > 0){
            $res['status'] = 'enrolled';
            $res['message'] = 'Maaf Anda Sudah Mengikuti Pelatihan Ini';
        }else{
            $cekplatihan = DB::table('enroll')
            ->join('pelatihan','pelatihan.id','=','enroll.id_pelatihan')
            ->where('pelatihan.id', $request->id_pelatihan)
            ->where('pelatihan.id_bumdes', $request->id_bumdes)
            ->count();
                
            if($cekplatihan == 0){
                $enroll = DB::table('enroll')->insert([
                    'id_pelatihan'  => $request->id_pelatihan,
                    'id_bumdes'     => $request->id_bumdes
                ]);

                if($enroll){
                    $res['status'] = 'success';
                    $res['message'] = 'Anda berhasil mengikuti pelatihan ini';    
                }
            }else{
                $res['status'] = 'invalid';
                $res['message'] = 'Maaf Ini Adalah Pelatihan Yang Anda Buat Sendiri';
            }    
        }

        return response($res);
    }

    public function enroll(Request $request)
    {
        
        $countenroll = DB::table('enroll')
        ->where('enroll.id_bumdes',$request->id_bumdes)
        ->where('enroll.id_pelatihan',$request->id_pelatihan)
        ->count();
        

        if($countenroll > 0){
            $res['status'] = 'enrolled';
            $res['message'] = 'Maaf Anda Sudah Mengikuti Pelatihan Ini';
        }else{
            $cekplatihan = DB::table('enroll')
            ->join('pelatihan','pelatihan.id','=','enroll.id_pelatihan')
            ->where('pelatihan.id', $request->id_pelatihan)
            ->where('pelatihan.id_bumdes', $request->id_bumdes)
            ->count();
                
            if($cekplatihan == 0){
                $enroll = DB::table('enroll')->insert([
                    'id_pelatihan'  => $request->id_pelatihan,
                    'id_bumdes'     => $request->id_bumdes
                ]);

                if($enroll){
                    return redirect('/dashboard_detail_pelatihan_user/'.$request->id_pelatihan);
                }
            }else{
                return redirect('/shadesa')->with('Status','Maaf ini adalah pelatihan anda sendiri');
            }    
        }

        return response($res);
    }

    public function getSharingByIdBumdes(){
        $sharing = DB::table('pelatihan')
                   ->where('pelatihan.id_bumdes', session('id_bumdes'))
                   ->get();
        $enroll = DB::table('enroll')
                   ->join('pelatihan', 'pelatihan.id','=','enroll.id_pelatihan')
                   ->select('pelatihan.*', 'enroll.id_bumdes')
                   ->where('enroll.id_bumdes',session('id_bumdes')) 
                   ->get(); 
        $produk = DB::table('produk')
                    ->where('produk.id_bumdes', session('id_bumdes'))
                    ->get();                 
        return view('/dashboard/sharing', compact('sharing','enroll','produk'));
    }


    public function detailpelatihan($id){        
        $pelatihan = DB::table('pelatihan')
        ->join('produk', 'produk.id','=','pelatihan.id_produk') 
        ->join('bumdes', 'bumdes.id','=','pelatihan.id_bumdes') 
        ->select('bumdes.*','produk.*','pelatihan.*','pelatihan.id as id_pelatihan','bumdes.nama_bumdes')               
        ->where('pelatihan.id',$id)
        ->get();

        $video = DB::table('video')
        ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
        ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
        ->where('video.id_pelatihan',$id)
        ->get();

        
        return view('dashboard/detail_pelatihan',compact('pelatihan','video'));
    }

    public function detailpelatihanuser($id){        
        $pelatihan = DB::table('pelatihan')
        ->join('produk', 'produk.id','=','pelatihan.id_produk') 
        ->join('bumdes', 'bumdes.id','=','pelatihan.id_bumdes')         
        ->where('pelatihan.id',$id)
        ->get();

        $video = DB::table('video')
        ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
        ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
        ->where('video.id_pelatihan',$id)
        ->get();

        // echo json_encode($pelatihan);
        return view('dashboard/detail_pelatihan_user',compact('pelatihan','video'));
    }       

    public function tambahMateri(Request $req){
        $materi = DB::table('video')->insert([
            'link_video' => $req->link_video,
            'judul_pelatihan' => $req->judul_pelatihan,
            'id_pelatihan' => $req->id_pelatihan,
            'caption' => $req->caption
        ]);

        if($materi){
            return redirect(url('/dashboard_detail_pelatihan/'.$req->id_pelatihan));
        }
    }

    public function seeVideo($id,$pelatihan)
    {
                       
            $video = DB::table('video')
            ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
            ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
            ->where('video.id_pelatihan',$pelatihan)
            ->get();
    
            $materi = DB::table('video')
            ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
            ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
            ->where('video.id',$id)
            ->get();
            
            foreach($materi as $vid){
                $playervideo = htmlspecialchars_decode($vid->link_video);
            }
            // echo json_encode($pelatihan);
            return view('dashboard/detail_materi',compact('video','materi','playervideo'));
        
    }
    // API

    public function getPelatihan(){
        $pelatihan = DB::table('pelatihan')->get();
       return response($pelatihan);
    }
    
    public function getPelatihanById($id){
        $pelatihan = DB::table('pelatihan')        
        ->where('id_produk',$id)
        ->get();
        return response($pelatihan);    
    }

    public function searchingPelatihan(Request $req){
        $produk = DB::table('pelatihan')
                  ->where('nama_pelatihan','LIKE',"%{$req->keyword}%")
                //   ->whereLike('nama_produk',$req->keyword)
                  ->get();                          

        return response($produk);
    }


    public function getPelatihanByEnroll($id_bumdes){
        $enroll = DB::table('enroll')
        ->join('pelatihan', 'pelatihan.id','=','enroll.id_pelatihan')
        ->select('pelatihan.*', 'enroll.id_bumdes')
        ->where('enroll.id_bumdes',$id_bumdes)
        ->get();

        
        return response($enroll);
    }

    public function getAllpelatihan(){        
        $pelatihan = DB::table('pelatihan')
        ->join('produk', 'produk.id','=','pelatihan.id_produk') 
        ->join('bumdes', 'bumdes.id','=','pelatihan.id_bumdes')
        ->join('video','pelatihan.id','=','video.id_pelatihan')        
        ->select('pelatihan.*',
            'bumdes.nama_bumdes',
            'produk.nama_produk',
            'pelatihan.id as id_pelatihan',
            'video.caption',
            'video.id as id_video',
            'video.link_video')                               
        ->get();
        return response($pelatihan); 
    }    

    public function getDetailpelatihan($id){        
        $pelatihan = DB::table('pelatihan')
        ->join('produk', 'produk.id','=','pelatihan.id_produk') 
        ->join('bumdes', 'bumdes.id','=','pelatihan.id_bumdes') 
        ->select('bumdes.*','produk.*','pelatihan.*','pelatihan.id as id_pelatihan')               
        ->where('pelatihan.id',$id)
        ->get();

        $video = DB::table('video')
        ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
        ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
        ->where('video.id_pelatihan',$id)
        ->get();

        // echo json_encode($pelatihan);
        $res['data'] = $pelatihan;
        $res['video'] = $video;
        return response($res); 
    }    

    public function getDetailMateri($id_materi){        
        $materi = DB::table('video')
        ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
        ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
        ->where('video.id',$id_materi)
        ->get();
        
        foreach($materi as $vid){
            $playervideo = htmlspecialchars_decode($vid->link_video);
        }

        $res['deskripsi_materi'] = $materi;
        $res['embed_video']      = $playervideo; 
        return response($res);
    }
}
