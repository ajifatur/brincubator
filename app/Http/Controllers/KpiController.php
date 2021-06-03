<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Usaha;
use App\Wilayah;

class KpiController extends Controller
{
    /**
     * Menampilkan data KPI Program...
     *
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        
        $wil = 0;

        // View...
        return view('kpi-program/admin/index', [
            'usaha' => $usaha,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
        ]);
    }
    
    /**
     * Menampilkan data KPI Program per wilayah...
     *
     * @param  int  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function data_per_wilayah($wil)
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
        }

        // View...
    	return view('kpi-program/admin/index', [
    	    'usaha' => $usaha,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	]);
    }

    /**
     * Mengupdate data KPI Program...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Menyimpan data...
        $usaha = Usaha::find($request->id);
        if($request->column == 'go_modern') $usaha->go_modern = $request->val;
        elseif($request->column == 'go_digital') $usaha->go_digital = $request->val;
        elseif($request->column == 'go_online') $usaha->go_online = $request->val;
        elseif($request->column == 'go_global') $usaha->go_global = $request->val;
        echo $usaha->save() ? 'Sukses' : 'Gagal';
    }

}
