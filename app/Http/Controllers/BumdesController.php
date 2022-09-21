<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BumdesController extends Controller
{
    public function regis(Request $req)
    {
        $pass = md5($req->password).sha1($req->password);
        $sql = DB::table('bumdes')->insert([
            'nama_bumdes' =>$req->nama_bumdes,
            'desa' =>$req->desa,
            'email' =>$req->email,
            'password' =>$pass
        ]);

        if($sql){
            return redirect(url('/login'));
        }
    }

    public function updateBumdes(Request $req)
    {
        // $pass = md5($req->password).sha1($req->password);
        $sql = DB::table('bumdes')
            ->where('id', session('id_bumdes'))
            ->update([
                'nama_bumdes'   =>$req->nama_bumdes,
                'desa'          =>$req->desa,
                'email'         =>$req->email,                
                'provinsi'      => $req->provinsi,
                'kabupaten'     => $req->kabupaten,
                'kecamatan'     => $req->kecamatan,                
        ]);

        if($sql){
            return redirect('/profile')->with('status','Berhasil Update Data');
        }else{
            return redirect('/profile')->with('status','Gagal Update Data');

        }
    }


    public function updateFotoBumdes(Request $req)
    {
        $bumdes = DB::table('bumdes')
        ->where('bumdes.id',session('id_bumdes'))        
        ->get();
        $foto = '';
        foreach($bumdes as $datas){
            $foto = $datas->pp;
        }
        
        $myfile = 'profil_bumdes/'.$foto;
        
        if(file_exists($myfile) && $foto != NULL){            
            $delete = unlink($myfile);
            if($delete){
                $time_upload = date("d_m_Y_h_i_s");
                $tujuan_file = 'profil_bumdes/';           
                $file = $req->foto_profil;
                $ekstensi = $file->getClientOriginalExtension();
                $namafile = "$time_upload".'.'.$ekstensi;
                $pindahin =  $file->move($tujuan_file,$namafile);
                if($pindahin){
                    $update = DB::table('bumdes')
                    ->where('id', session('id_bumdes'))
                    ->update([
                        'pp'       => $namafile,
                    ]);

                    if($update){
                        return redirect('/profile')->with('Status', 'Success Edit');
                    }else{
                        return redirect('/profile')->with('Status', 'Gagal Edit');
                    }
                }else{
                    echo 'Gagal Upload';
                }
            }
        }else{
            $time_upload = date("d_m_Y_h_i_s");
            $tujuan_file = 'profil_bumdes/';           
            $file = $req->foto_profil;
            $ekstensi = $file->getClientOriginalExtension();
            $namafile = "$time_upload".'.'.$ekstensi;
            $pindahin =  $file->move($tujuan_file,$namafile);
            if($pindahin){
                $update = DB::table('bumdes')
                ->where('id', session('id_bumdes'))
                ->update([
                    'pp'       => $namafile,
                ]);

                if($update){
                    return redirect('/profile')->with('Status', 'Success Edit');
                }else{
                    return redirect('/profile')->with('Status', 'Gagal Edit');
                }
            }else{
                echo 'Gagal Upload';
            }
        }
    }   

    public function login(Request $req){
        $enc =   md5($req->password).sha1($req->password);
		$logins = DB::table('bumdes')
		->where('email',$req->nis)
		->where('password',$enc)
		->count();        
        
		if($logins != 0 ){
			$data = DB::table('bumdes')
                ->where('email', $req->email)
                ->where('password', $enc)
                ->get();
             foreach ($data as $val) {
             		$namabumdes =  $val->nama_bumdes;
             		$idbumdes =  $val->id;
             }

            session(['nama_bumdes' => $namabumdes]);
            session(['id_bumdes' => $idbumdes]);
             return redirect('/dashboard');             
		}else{
			 return redirect('/login')->with('login_error','Maaf Login Gagal');             
		}
    }

    public function logout(Request $request){        
        $request->session()->forget('id_bumdes');
        return redirect('/login');
    }


    public function dashboard(){       
        $bumdes = DB::table('bumdes')
                ->where('id',session('id_bumdes'))
                ->get(); 
        return view('dashboard/dashboard',compact('bumdes'));
    }

    public function profil(){
        $fget = DB::table('bumdes')
                ->where('bumdes.id',session('id_bumdes'))
                ->get();

        foreach($fget as $data){
            $provinsi = $data->provinsi;
        }
        if($provinsi != NULL)
            $bumdes = DB::table('bumdes')
            ->join('provinsi','bumdes.provinsi','=','provinsi.id')
            ->join('kabupaten','bumdes.kabupaten','=','kabupaten.id')
            ->join('kecamatan','bumdes.kecamatan','=','kecamatan.id')
            ->select('bumdes.*',                
                    'provinsi.nama as nama_provinsi',
                    'kabupaten.nama as nama_kabupaten',
                    'kecamatan.nama as nama_kecamatan')
            ->where('bumdes.id',session('id_bumdes'))
            ->get();            
        else{
            $bumdes = $fget;
        }

        $prov = DB::table('provinsi')->get();
        // return response($bumdes);
        return view('dashboard/profile',compact('bumdes','prov'));
    }

    public function sharing(){
        $getid = session('id_bumdes');
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')        
        ->select('produk.*', 'bumdes.*', 'produk.id as produk_id')
        ->where('produk.id_bumdes',$getid)
        ->get();

        $enroll = DB::table('enroll')
        ->join('pelatihan', 'pelatihan.id','=','enroll.id_pelatihan')
        ->where('enroll.id_bumdes',session('id_bumdes'))
        ->get();

        return view('/page/sharing_dashboard', compact('produk','enroll'));
        // echo json_encode($produk);
    }
    public function detailsharing($id){
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')        
        ->select('produk.*', 'bumdes.*', 'produk.id as produk_id')
        ->where('produk.id',$id)
        ->get();

        $pelatihan = DB::table('pelatihan')        
        ->where('id_produk',$id)
        ->get();
        return view('page/detail_sharing_dashboard',compact('produk','pelatihan'));
    }

    public function detailprodukuser($id){
        $produk = DB::table('produk')
        ->join('bumdes', 'bumdes.id','=','produk.id_bumdes')        
        ->select('produk.*', 'bumdes.*', 'produk.id as produk_id')
        ->where('produk.id',$id)
        ->get();

        $pelatihan = DB::table('pelatihan')
        ->where('id_produk',$id)
        ->get();
        return view('page/detail_produk',compact('produk','pelatihan'));
    }

    public function detailpelatihan($id){        
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
        return view('dashboard/detail_pelatihan',compact('pelatihan','video'));
    }

    public function detailpelatihanuserdashboard($id){        
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
        return view('page/detail_pelatihan_dashboard_users',compact('pelatihan','video'));
    }

    public function detailpelatihanuser($id){        
        $pelatihan = DB::table('pelatihan')
        ->join('produk', 'produk.id','=','pelatihan.id_produk') 
        ->join('bumdes', 'bumdes.id','=','pelatihan.id_bumdes')
        ->select('produk.*','bumdes.*','pelatihan.*','pelatihan.id as id_pelatihan')         
        ->where('pelatihan.id',$id)
        ->get();

        $video = DB::table('video')
        ->join('pelatihan','pelatihan.id','=','video.id_pelatihan')
        ->select('pelatihan.*', 'video.*','pelatihan.id as id_pelatihan')
        ->where('pelatihan.id',$id)
        ->get();

        // echo json_encode($pelatihan);
        return view('page/detail_pelatihan',compact('pelatihan','video'));
    }
    
    public function detailmateri($pelatihan,$id){                
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
        return view('page/detail_materi',compact('video','materi','playervideo'));
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


    // API 
    public function apilogin(Request $req){
        $enc =   md5($req->password).sha1($req->password);
		$logins = DB::table('bumdes')
		->where('email',$req->email)
		->where('password',$enc)
		->count();        
        
		if($logins != 0 ){
			$data = DB::table('bumdes')
                ->where('email', $req->email)
                ->where('password', $enc)
                ->get();
             foreach ($data as $val) {
             		$namabumdes =  $val->nama_bumdes;
             		$idbumdes =  $val->id;
             }

             $res['message'] = "Success";
             $res['data'] = $data;
		}else{
			 $res['message'] = "Gagal";             
		}
        return response($res);
    }
    public function apiregis(Request $req)
    {
        // $time_upload = date("d_m_Y_h_i_s");
        // $tujuan_file = 'profil_bumdes/';           
        // $file = $req->foto_profil;
        // $ekstensi = $file->getClientOriginalExtension();
        // $namafile = "$time_upload".'.'.$ekstensi;
        // $pindahin =  $file->move($tujuan_file,$namafile);
        // if($pindahin){
            $pass = md5($req->password).sha1($req->password);
            $sql = DB::table('bumdes')->insert([
                'nama_bumdes'   =>$req->nama_bumdes,
                'desa'          =>$req->desa,
                'email'         =>$req->email,
                'password'      =>$pass,
                'provinsi'      =>$req->provinsi,
                'kabupaten'     =>$req->kabupaten,
                'kecamatan'     =>$req->kecamatan,                
            ]);
    
            if($sql){
                $res['message'] = $sql;
                $res['status']  = 'Success';                
            }
        // }else{
        //     $res = "Failed Upload";
        // }

        return response($res);
    }

    public function apitugas(Request $req)
    {
                
        $sql = DB::table('tes')->insert([
            'nama'              =>$req->nama,                
            'email'             =>$req->email,
            'alamat'            =>$req->alamat,            
        ]);

        if($sql){
            $res['message'] = $sql;
            $res['status']  = 'Success';                
        }        

        return response($res);
    }

    public function apiupdate(Request $req)
    {
        $pass = md5($req->password).sha1($req->password);
        $sql = DB::table('bumdes')
            ->where('id', $req->id)
            ->update([
                'nama_bumdes' =>$req->nama_bumdes,
                'desa'      =>$req->desa,
                'email'     =>$req->email,
                'password'  =>$pass,
                'provinsi'  => $req->provinsi,
                'kabupaten' => $req->kabupaten,
                'kecamatan' => $req->kecamatan,
                'lat'       => $req->lat,
                'longi'     => $req->longi    
        ]);

        if($sql){
            $bumdes = DB::table('bumdes')
            ->where('id',$req->id)
            ->get();

            $res['status'] = "Success";
            $res['data']   = $bumdes;            
        }

        return response($res);
    }

    public function getProvinsi(){
        $get = DB::table('provinsi')->get();
        return response($get);
    }

    public function getKabupaten($id_provinsi){
        $get = DB::table('kabupaten')
        ->where('provinsi_id',$id_provinsi)
        ->get();
        return response($get);
    }

    public function getKecamatan($id_kabupaten){
        $get = DB::table('kecamatan')
        ->where('kabupaten_id',$id_kabupaten)
        ->get();
        return response($get);
    }
    
}
