<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mentor;
use App\Omset;
use App\Usaha;
use App\Wilayah;

class PageController extends Controller
{
    /**
     * Menampilkan halaman dashboard...
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $mentor = Mentor::all();
            $usaha = Usaha::all();
            $wilayah = wilayah::all();

            // Overall omset...
            $overall_omset = 0;
            $o = Omset::all();
            foreach($o as $data){
            	$overall_omset += (int)$data->omset;
            }

            // Omset tahun ini...
            $omset_tahun_ini = array();
            for($i=1; $i<=12; $i++){
            	$omset = Omset::where('tahun','=',date('Y'))->where('bulan','=',$i)->get();
            	$total_omset = 0;
            	foreach($omset as $data){
            		$total_omset += (int)$data->omset;
            	}
            	array_push($omset_tahun_ini, $total_omset);
            }

            // UMKM terdaftar dan random warna...
            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $nama_wilayah = array();
            $jumlah_umkm = array();
            $random_warna = array();
            foreach($wilayah as $data){
            	$umkm = Usaha::where('wilayah_id','=',$data->id)->get();
            	array_push($nama_wilayah, '"'.$data->nama_kota.'"');
            	array_push($jumlah_umkm, count($umkm));
            	
            	$warna = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            	array_push($random_warna, $warna);
            }
            
            // UMKM Go-Modern...
            $umkm_go_modern = array();
            foreach($wilayah as $data){
                $umkm = Usaha::where('wilayah_id','=',$data->id)->where('go_modern','=',1)->get();
                $umkm_go_modern[$data->nama_kota] = count($umkm);
            }
            
            // UMKM Go-Digital...
            $umkm_go_digital = array();
            foreach($wilayah as $data){
                $umkm = Usaha::where('wilayah_id','=',$data->id)->where('go_digital','=',1)->get();
                $umkm_go_digital[$data->nama_kota] = count($umkm);
            }
            
            // UMKM Go-Online...
            $umkm_go_online = array();
            foreach($wilayah as $data){
                $umkm = Usaha::where('wilayah_id','=',$data->id)->where('go_online','=',1)->get();
                $umkm_go_online[$data->nama_kota] = count($umkm);
            }
            
            // UMKM Go-Global...
            $umkm_go_global = array();
            foreach($wilayah as $data){
                $umkm = Usaha::where('wilayah_id','=',$data->id)->where('go_global','=',1)->get();
                $umkm_go_global[$data->nama_kota] = count($umkm);
            }
            
            $umkm_tidak_go_modern = array();
            $umkm_tidak_go_digital = array();
            $umkm_tidak_go_online = array();
            $umkm_tidak_go_global = array();
        }
        // Data jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $mentor = Mentor::where('wilayah_id','=',Auth::user()->wilayah_id)->get();
            $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->get();
            $wilayah = array();
            $nama_wilayah = array();
            $jumlah_umkm = array();

            // Overall omset...
            $overall_omset = 0;
            $o = Omset::join('usaha','omset.usaha_id','=','usaha.id')->where('wilayah_id','=',Auth::user()->wilayah_id)->get();
            foreach($o as $data){
            	$overall_omset += (int)$data->omset;
            }

            // Omset tahun ini...
            $omset_tahun_ini = array();
            for($i=1; $i<=12; $i++){
            	$omset = Omset::join('usaha','omset.usaha_id','=','usaha.id')->where('wilayah_id','=',Auth::user()->wilayah_id)->where('tahun','=',date('Y'))->where('bulan','=',$i)->get();
            	$total_omset = 0;
            	foreach($omset as $data){
            		$total_omset += (int)$data->omset;
            	}
            	array_push($omset_tahun_ini, $total_omset);
            }
            
            // Random warna...
            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $random_warna = array();
			for($i=1; $i<=2; $i++){
            	$warna = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            	array_push($random_warna, $warna);
			}
            
            // UMKM Go dan yang tidak...
            $umkm_go_modern = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->where('go_modern','=',1)->get();
            $umkm_tidak_go_modern = count($usaha) - count($umkm_go_modern);
            
            $umkm_go_digital = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->where('go_digital','=',1)->get();
            $umkm_tidak_go_digital = count($usaha) - count($umkm_go_digital);
            
            $umkm_go_online = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->where('go_online','=',1)->get();
            $umkm_tidak_go_online = count($usaha) - count($umkm_go_online);
            
            $umkm_go_global = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->where('go_global','=',1)->get();
            $umkm_tidak_go_global = count($usaha) - count($umkm_go_global);
        }

        // View...
    	return view('/index', [
    		'mentor' => $mentor,
    		'usaha' => $usaha,
    		'wilayah' => $wilayah,
    		'overall_omset' => $overall_omset,
    		'omset_tahun_ini' => $omset_tahun_ini,
    		'nama_wilayah' => $nama_wilayah,
    		'jumlah_umkm' => $jumlah_umkm,
    		'umkm_go_modern' => $umkm_go_modern,
    		'umkm_tidak_go_modern' => $umkm_tidak_go_modern,
    		'umkm_go_digital' => $umkm_go_digital,
    		'umkm_tidak_go_digital' => $umkm_tidak_go_digital,
    		'umkm_go_online' => $umkm_go_online,
    		'umkm_tidak_go_online' => $umkm_tidak_go_online,
    		'umkm_go_global' => $umkm_go_global,
    		'umkm_tidak_go_global' => $umkm_tidak_go_global,
    		'random_warna' => $random_warna,
    	]);
    }
}
