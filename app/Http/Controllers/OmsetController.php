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

class OmsetController extends Controller
{
    /**
     * Menampilkan data omset...
     *
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function index($tahun)
    {
        // Data usaha jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::orderBy('id','desc')->get();
            $wilayah = Wilayah::all();
        }
        // Data usaha jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
            $wilayah = array();
        }

        // Data omset...
        $omset = array();
        $total_omset = array();
        foreach($usaha as $key=>$data){
            $array = array();
            for($i=1; $i<=12; $i++){
                $x = Omset::where('usaha_id','=',$data->id)->where('bulan','=',$i)->where('tahun','=',$tahun)->first();
                $x ? array_push($array, $x->omset) : array_push($array, 0);
            }
            $omset[$key] = $array;
            $total_omset[$key] = array_sum($array);
        }
        
        $wil = 0;

        // View...
        return view('omset/admin/index', [
            'usaha' => $usaha,
            'omset' => $omset,
            'total_omset' => $total_omset,
            'tahun' => $tahun,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
        ]);
    }
    
    /**
     * Menampilkan data omset per wilayah...
     *
     * @param  int  $tahun
     * @param  int  $wil
     * @return \Illuminate\Http\Response
     */
    public function omset_per_wilayah($tahun, $wil)
    {
        // Data wilayah...
        $w = Wilayah::find($wil);
        
        // Jika tidak ada wilayah...
        if(!$w){
            abort(404);
        }
        // Jika ada wilayah...
        else{
            // Data usaha jika rolenya super admin...
            if(Auth::user()->role_id == 0){
                $usaha = Usaha::where('wilayah_id','=',$wil)->orderBy('id','desc')->get();
                $wilayah = Wilayah::all();
            }
            // Data usaha jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
                $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
                $wilayah = array();
            }
    
            // Data omset...
            $omset = array();
            foreach($usaha as $key=>$data){
                $array = array();
                for($i=1; $i<=12; $i++){
                    $x = Omset::where('usaha_id','=',$data->id)->where('bulan','=',$i)->where('tahun','=',$tahun)->first();
                    $x ? array_push($array, $x->omset) : array_push($array, 0);
                }
                $omset[$key] = $array;
            }
        }

        // View...
        return view('omset/admin/index', [
            'usaha' => $usaha,
            'omset' => $omset,
            'tahun' => $tahun,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
        ]);
    }
    
    /**
     * Menampilkan data omset per tahun...
     *
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function omset_per_tahun(Request $request)
    {
        // Data omset...
        $omset_per_tahun = array();
        for($i=1; $i<=12; $i++){
            // Data usaha berdasarkan $id jika rolenya super admin...
            if(Auth::user()->role_id == 0){
        	    $omset = Omset::where('tahun','=',$request->tahun)->where('bulan','=',$i)->get();
            }
            // Data usaha berdasarkan $id jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
            	$omset = Omset::join('usaha','omset.usaha_id','=','usaha.id')->where('wilayah_id','=',Auth::user()->wilayah_id)->where('tahun','=',$request->tahun)->where('bulan','=',$i)->get();
            }
        	$total_omset = 0;
        	foreach($omset as $data){
        		$total_omset += (int)$data->omset;
        	}
        	array_push($omset_per_tahun, $total_omset);
        }
        
        // Konversi data ke json
        $data['omset'] = $omset_per_tahun;
        $data['total'] = array_sum($omset_per_tahun);
        echo json_encode($data);
    }

    /**
     * Menampilkan form data omset berdasarkan usaha_id...
     *
     * @param  int  $usaha_id
     * @param  int  $bulan
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($usaha_id, $bulan, $tahun)
    {
        // Data usaha berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::find($usaha_id);
        }
        // Data usaha berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('id','=',$usaha_id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }

        if(!$usaha){
            abort(404);
        }

        // Data omset...
        $omset = Omset::where('usaha_id','=',$usaha_id)->where('bulan','=',$bulan)->where('tahun','=',$tahun)->first();

        // View...
        return view('omset/admin/edit', [
            'omset' => $omset,
            'usaha_id' => $usaha_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    /**
     * Mengupdate data omset...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Pesan Error...
        $messages = [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute wajib dengan nomor atau angka.',
            'unique' => ':attribute sudah ada.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
        ];

        // Validasi...
        $validator = Validator::make($request->all(), [
            'omset' => 'required|numeric',
            'penjualan' => 'required|numeric',
            'bulan' => 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $omset = Omset::where('usaha_id','=',$request->usaha_id)->where('bulan','=',$request->bulan)->where('tahun','=',$request->tahun)->first();
            if(!$omset) $omset = new Omset;
            $omset->usaha_id = $request->usaha_id;
            $omset->omset = $request->omset;
            $omset->penjualan = $request->penjualan;
            $omset->bulan = $request->bulan;
            $omset->tahun = $request->tahun;
            $omset->save();
        }

        // Redirect...
        return redirect('/admin/omset/tahun/'.$request->tahun);
    }


    /**
     * Menampilkan form grafik omset...
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        // Data usaha jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::orderBy('id','desc')->get();
        }
        // Data usaha jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
        }

        // View...
        return view('omset/admin/form', [
            'usaha' => $usaha,
        ]);  
    }

    /**
     * Menampilkan data omset berdasarkan UMKM dan tahun...
     *
     * @param  int  $usaha_id
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function detail($usaha_id, $tahun)
    {
        // Data usaha jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::orderBy('id','desc')->get();
        }
        // Data usaha jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
        }

        // Data omset berdasarkan $usaha_id dan $tahun...
        $omset = Omset::where('usaha_id','=',$usaha_id)->where('tahun','=',$tahun)->orderBy('bulan','asc')->get();
        if(!$omset){
        	abort(404);
        }
        else{
	        $data_omset = $data_penjualan = array();
            for($bulan=1;$bulan<=12;$bulan++){
                $o = Omset::where('usaha_id','=',$usaha_id)->where('tahun','=',$tahun)->where('bulan','=',$bulan)->orderBy('bulan','asc')->first();
	        	$o ? array_push($data_omset, $o->omset) : array_push($data_omset, 0);
	        	$o ? array_push($data_penjualan, $o->penjualan) : array_push($data_penjualan, 0);
            }
        }

        // View...
        return view('omset/admin/detail', [
            'usaha_id' => $usaha_id,
            'omset' => $omset,
            'data_omset' => $data_omset,
            'data_penjualan' => $data_penjualan,
            'usaha' => $usaha,
            'tahun' => $tahun,
        ]);  
    }
}
