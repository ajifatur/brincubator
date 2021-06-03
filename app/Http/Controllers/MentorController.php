<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mentor;
use App\Pemilik;
use App\Usaha;
use App\Wilayah;

class MentorController extends Controller
{
    /**
     * Menampilkan data mentor...
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data mentor jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $mentor = Mentor::orderBy('id','desc')->get();
            $wilayah = Wilayah::all();
        }
        // Data mentor jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $mentor = Mentor::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
            $wilayah = array();
        }

        // Data mentor...
        foreach($mentor as $key=>$data){
            $total = Usaha::where('mentor_id','=',$data->id)->get();
            $mentor[$key]->total = count($total);
        	$data->wilayah_id = Wilayah::find($data->wilayah_id);
        }
        
        $wil = 0;

        // View...
    	return view('mentor/admin/index', [
    	    'mentor' => $mentor,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	 ]);
    }
    
    /**
     * Menampilkan data mentor per wilayah...
     *
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
            // Data mentor jika rolenya super admin...
            if(Auth::user()->role_id == 0){
                $mentor = Mentor::where('wilayah_id','=',$wil)->orderBy('id','desc')->get();
                $wilayah = Wilayah::all();
            }
            // Data mentor jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
                $mentor = Mentor::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
                $wilayah = array();
            }
    
            // Data mentor...
            foreach($mentor as $key=>$data){
                $total = Usaha::where('mentor_id','=',$data->id)->get();
                $mentor[$key]->total = count($total);
            	$data->wilayah_id = Wilayah::find($data->wilayah_id);
            }
        }

        // View...
    	return view('mentor/admin/index', [
    	    'mentor' => $mentor,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	 ]);
    }

    /**
     * Menampilkan form untuk memasukkan data mentor...
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data wilayah...
        $wilayah = Wilayah::orderBy('nama_kota','asc')->get();

        // View...
        return view('mentor/admin/create', ['wilayah' => $wilayah]);  
    }

    /**
     * Menyimpan mentor ke database...
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
            'nama' => 'required|string|min:3|max:80',
            'wilayah_id' => 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $mentor = new Mentor;
            $mentor->nama = $request->nama;
            $mentor->tempat_lahir = $request->tempat_lahir;
            $mentor->tanggal_lahir = $request->tanggal_lahir;
            $mentor->alamat = $request->alamat;
            $mentor->pekerjaan = $request->pekerjaan;
            $mentor->alamat_kantor = $request->alamat_kantor;
            $mentor->jabatan = $request->jabatan;
            $mentor->email = $request->email;
            $mentor->pendidikan_terakhir = $request->pendidikan_terakhir;
            $mentor->notelp = $request->notelp;
            $mentor->nama_usaha = $request->nama_usaha;
            $mentor->wilayah_id = $request->wilayah_id;
            $mentor->save();
        }

        // Redirect...
        return redirect('/admin/mentor');
    }

    /**
     * Menampilkan data mentee mentor...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Data mentor berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $mentor = Mentor::find($id);
        }
        // Data mentor berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $mentor = Mentor::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }
        
        // Jika tidak ada mentor...
        if(!$mentor){
            abort(404);
        }
        // Jika ada...
        else{
            // Data mentee mentor...
            $mentee = Usaha::where('mentor_id','=',$id)->get();
            foreach($mentee as $data){
            	$data->pemilik_id = Pemilik::find($data->pemilik_id);
            }
            
            // Data UMKM...
            $usaha = Usaha::where('wilayah_id','=',$mentor->wilayah_id)->orderBy('nama_usaha','asc')->get();
        }
        
        // View...
        return view('/mentor/admin/detail', [
            'mentor' => $mentor,
            'mentee' => $mentee,
            'usaha' => $usaha
        ]);
    }

    /**
     * Menambah mentee baru ke data mentor...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_mentee(Request $request)
    {
        // Mengecek apakah UMKM sudah terdaftar sebagai mentee atau belum...
        $mentee = Usaha::where('mentor_id','=',$request->mentor)->where('id','=',$request->usaha)->first();
        
        // Jika tidak ada, maka akan menyimpan data...
        if(!$mentee){
            $mu = Usaha::where('id','=',$request->usaha)->first();
            $mu->mentor_id = $request->mentor;
            $mu->save();
        }

        // Redirect...
        return redirect('/admin/mentor/mentee/'.$request->mentor);
    }

    /**
     * Menghapus mentee dari data mentor...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_mentee(Request $request)
    {
        // Data usaha berdasarkan $id
        $usaha = Usaha::find($request->id);
        $usaha->mentor_id = 0;

        // Menghapus data...
        if($usaha->save()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }

    /**
     * Menampilkan form untuk mengedit data mentor...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data mentor berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $mentor = Mentor::find($id);
        }
        // Data mentor berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $mentor = Mentor::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }

        if(!$mentor){
            abort(404);
        }

        // Data wilayah...
        $wilayah = Wilayah::orderBy('nama_kota','asc')->get();

        // View...
        return view('mentor/admin/edit', [
            'mentor' => $mentor,
            'wilayah' => $wilayah,
        ]);  
    }

    /**
     * Mengupdate data mentor...
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
            'nama' => 'required|string|min:3|max:80',
            'wilayah_id' => 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $mentor = Mentor::find($request->id);
            $mentor->nama = $request->nama;
            $mentor->tempat_lahir = $request->tempat_lahir;
            $mentor->tanggal_lahir = $request->tanggal_lahir;
            $mentor->alamat = $request->alamat;
            $mentor->pekerjaan = $request->pekerjaan;
            $mentor->alamat_kantor = $request->alamat_kantor;
            $mentor->jabatan = $request->jabatan;
            $mentor->email = $request->email;
            $mentor->pendidikan_terakhir = $request->pendidikan_terakhir;
            $mentor->notelp = $request->notelp;
            $mentor->nama_usaha = $request->nama_usaha;
            $mentor->wilayah_id = $request->wilayah_id;
            $mentor->save();
        }

        // Redirect...
        return redirect('/admin/mentor');
    }

    /**
     * Menghapus data mentor...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Data mentor berdasarkan $id
        $mentor = Mentor::find($id);

        // Menghapus data...
        if($mentor->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }
}
