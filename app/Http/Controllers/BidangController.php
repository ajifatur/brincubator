<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Bidang;
use App\Pemilik;
use App\Usaha;
use App\Wilayah;

class BidangController extends Controller
{
    /**
     * Menampilkan data bidang...
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data bidang...
        $bidang = Bidang::orderBy('id','desc')->get();

        // Data bidang...
        foreach($bidang as $key=>$data){
            // Data UMKM jika rolenya super admin...
            if(Auth::user()->role_id == 0){
                $total = Usaha::where('bidang_id','=',$data->id)->get();
            }
            // Data UMKM jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
                $total = Usaha::where('bidang_id','=',$data->id)->where('wilayah_id','=',Auth::user()->wilayah_id)->get();
            }
            $bidang[$key]->total = count($total);
        }

        // View...
    	return view('bidang/admin/index', ['bidang' => $bidang]);
    }

    /**
     * Menampilkan form untuk memasukkan data bidang...
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // View...
        return view('bidang/admin/create');  
    }

    /**
     * Menyimpan bidang ke database...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'nama' => 'required|string|min:3|max:100',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $bidang = new Bidang;
            $bidang->nama = $request->nama;
            $bidang->save();
        }

        // Redirect...
        return redirect('/admin/bidang');
    }

    /**
     * Menampilkan data UMKM pada bidang...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Data bidang...
        $bidang = Bidang::find($id);
        
        // Jika tidak ada bidang...
        if(!$bidang){
            abort(404);
        }
        // Jika ada...
        else{
            // Data UMKM jika rolenya super admin...
            if(Auth::user()->role_id == 0){
                $umkm = Usaha::where('bidang_id','=',$bidang->id)->get();
                $usaha = Usaha::orderBy('nama_usaha','asc')->get();
                $wilayah = Wilayah::all();
            }
            // Data UMKM jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
                $umkm = Usaha::where('bidang_id','=',$bidang->id)->where('wilayah_id','=',Auth::user()->wilayah_id)->get();
                $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('nama_usaha','asc')->get();
                $wilayah = array();
            }
            
            foreach($umkm as $data){
            	$data->pemilik_id = Pemilik::find($data->pemilik_id);
            	$data->wilayah_id = Wilayah::find($data->wilayah_id);
            }
        }
        
        $wil = 0;
        
        // View...
        return view('/bidang/admin/detail', [
            'bidang' => $bidang,
            'umkm' => $umkm,
            'usaha' => $usaha,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
        ]);
    }

    /**
     * Menampilkan data UMKM pada bidang per wilayah...
     *
     * @param  int  $id
     * @param  int  $wil
     * @return \Illuminate\Http\Response
     */
    public function detail_per_wilayah($id, $wil)
    {
        // Data bidang...
        $bidang = Bidang::find($id);
        
        // Data wilayah...
        $w = Wilayah::find($wil);
        
        // Jika tidak ada bidang atau wilayah...
        if(!$bidang || !$w){
            abort(404);
        }
        // Jika ada...
        else{
            // Data UMKM jika rolenya super admin...
            if(Auth::user()->role_id == 0){
                $umkm = Usaha::where('bidang_id','=',$bidang->id)->where('wilayah_id','=',$wil)->get();
                $usaha = Usaha::orderBy('nama_usaha','asc')->get();
                $wilayah = Wilayah::all();
            }
            // Data UMKM jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
                $umkm = Usaha::where('bidang_id','=',$bidang->id)->where('wilayah_id','=',Auth::user()->wilayah_id)->get();
                $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('nama_usaha','asc')->get();
                $wilayah = array();
            }
            
            foreach($umkm as $data){
            	$data->pemilik_id = Pemilik::find($data->pemilik_id);
            	$data->wilayah_id = Wilayah::find($data->wilayah_id);
            }
        }
        
        // View...
        return view('/bidang/admin/detail', [
            'bidang' => $bidang,
            'umkm' => $umkm,
            'usaha' => $usaha,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
        ]);
    }

    /**
     * Menambah UMKM baru ke data bidang usaha...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_umkm(Request $request)
    {
        // Mengecek apakah UMKM sudah terdaftar dalam bidangnya atau belum...
        $umkm = Usaha::where('bidang_id','=',$request->bidang)->where('id','=',$request->usaha)->first();
        
        // Jika tidak ada, maka akan menyimpan data...
        if(!$umkm){
            $ub = Usaha::where('id','=',$request->usaha)->first();
            $ub->bidang_id = $request->bidang;
            $ub->save();
        }

        // Redirect...
        return redirect('/admin/bidang/umkm/'.$request->bidang);
    }

    /**
     * Menghapus UMKM dari data bidang...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_umkm(Request $request)
    {
        // Data usaha berdasarkan $id
        $usaha = Usaha::find($request->id);
        $usaha->bidang_id = 0;

        // Menghapus data...
        if($usaha->save()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }

    /**
     * Menampilkan form untuk mengedit data bidang...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data bidang berdasarkan $id
        $bidang = Bidang::find($id);

        // View...
        return view('bidang/admin/edit', [
            'bidang' => $bidang,
        ]);  
    }

    /**
     * Mengupdate data bidang...
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
            'nama' => 'required|string|min:3|max:100',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $bidang = Bidang::find($request->id);
            $bidang->nama = $request->nama;
            $bidang->save();
        }

        // Redirect...
        return redirect('/admin/bidang');
    }

    /**
     * Menghapus data bidang...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Data bidang berdasarkan $id
        $bidang = Bidang::find($id);

        // Menghapus data...
        if($bidang->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }
}
