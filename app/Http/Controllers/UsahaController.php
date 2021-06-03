<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Bidang;
use App\Izin;
use App\Mentor;
use App\Pelatihan;
use App\Pemilik;
use App\ProgramUsaha;
use App\Usaha;
use App\UsahaPhoto;
use App\Wilayah;

class UsahaController extends Controller
{
    /**
     * Menampilkan data usaha...
     *
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

        // Data usaha...
        foreach($usaha as $data){
        	$data->pemilik_id = Pemilik::find($data->pemilik_id);
        	$data->wilayah_id = Wilayah::find($data->wilayah_id);
        }
        
        $wil = 0;

        // View...
    	return view('usaha/admin/index', [
    	    'usaha' => $usaha,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	]);
    }
    
    /**
     * Menampilkan data usaha per wilayah...
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
    
            // Data usaha...
            foreach($usaha as $data){
            	$data->pemilik_id = Pemilik::find($data->pemilik_id);
            	$data->wilayah_id = Wilayah::find($data->wilayah_id);
            }
        }

        // View...
    	return view('usaha/admin/index', [
    	    'usaha' => $usaha,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	]);
    }

    /**
     * Menampilkan form untuk memasukkan data usaha...
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        // Data bidang...
        $bidang = Bidang::all();

        // Data wilayah...
        $wilayah = Wilayah::all();

        // Data mentor...
        $mentor = Mentor::all();

        // View...
        return view('usaha/admin/create', [
            'bidang' => $bidang,
            'wilayah' => $wilayah,
            'mentor' => $mentor,
        ]);  
    }

    /**
     * Menyimpan usaha ke database...
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
            'nama_usaha' => 'required|string|min:3|max:100',
            // 'tahun_berdiri' => 'required|numeric',
            // 'alamat_usaha' => 'required|string',
            // 'notelp' => 'required|min:3|max:20',
            // 'email' => 'required|email|min:6|max:120',
            // 'website' => 'required|min:6|max:120',
            // 'kredit_bank' => 'required',
            // 'tenaga_kerja' => 'required|numeric',
            // 'bidang_id' => 'required',
            'wilayah_id' => 'required',
            // 'mentor_id' => 'required',
            'nama_pemilik' => 'required|string|min:3|max:100',
            // 'alamat_pemilik' => 'required|string',
            // 'notelp_pemilik' => 'required|min:3|max:20',
            'akte_notaris' => 'max:100',
            'badan_hukum' => 'max:100',
            'siup' => 'max:50',
            'npwp' => 'max:50',
            'tdp' => 'max:50',
            'lain' => 'max:80',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data pemilik UMKM...
            $pemilik = new Pemilik;
            $pemilik->nama = $request->nama_pemilik;
            $pemilik->alamat = $request->alamat_pemilik;
            $pemilik->notelp = $request->notelp_pemilik;
            $pemilik->status = 0;
            if($pemilik->save()){
                $pemilik_new = Pemilik::latest('id')->first();
                $pemilik_id = $pemilik_new->id;
            }
            else{
                $pemilik_id = 0;
            }

            // Menyimpan data izin usaha...
            $izin = new Izin;
            $izin->akte_notaris = $request->akte_notaris != null ? $request->akte_notaris : '';
            $izin->badan_hukum = $request->badan_hukum != null ? $request->badan_hukum : '';
            $izin->siup = $request->siup != null ? $request->siup : '';
            $izin->npwp = $request->npwp != null ? $request->npwp : '';
            $izin->tdp = $request->tdp != null ? $request->tdp : '';
            $izin->lain = $request->lain != null ? $request->lain : '';
            if($izin->save()){
                $izin_new = Izin::latest('id')->first();
                $izin_id = $izin_new->id;
            }
            else{
                $izin_id = 0;
            }

            // Menyimpan data usaha...
            $usaha = new Usaha;
            $usaha->pemilik_id = $pemilik_id;
            $usaha->bidang_id = $request->bidang_id;
            $usaha->izin_id = $izin_id;
            $usaha->mentor_id = $request->mentor_id;
            $usaha->nama_usaha = $request->nama_usaha;
            $usaha->tahun_berdiri = $request->tahun_berdiri;
            $usaha->alamat_usaha = $request->alamat_usaha;
            $usaha->notelp = $request->notelp;
            $usaha->email = $request->email;
            $usaha->website = $request->website;
            $usaha->kredit_bank = $request->kredit_bank;
            $usaha->tenaga_kerja = $request->tenaga_kerja;
            $usaha->wilayah_id = $request->wilayah_id;
            $usaha->save();
        }

        // Redirect...
        return redirect('/admin/umkm');
    }

    /**
     * Menampilkan foto produk UMKM...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function photo($id)
    {
        // Data usaha berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::find($id);
        }
        // Data usaha berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }
        
        // Jika tidak ada data usaha...
        if(!$usaha){
            abort(404);
        }
        // Jika ada...
        else{
            $usaha_photo = UsahaPhoto::where('usaha_id','=',$usaha->id)->get();
        }
        
        return view('usaha/admin/photo', [
            'usaha' => $usaha,
            'usaha_photo' => $usaha_photo,
        ]); 
    }

    /**
     * Mengupload foto produk UMKM...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload_photo(Request $request)
    {
        // Mengupload foto...
        list($type, $request->file) = explode(';', $request->file);
        list(, $request->file)      = explode(',', $request->file);
        $gambar = base64_decode($request->file);
        $nama_gambar = time().'.jpg';
        file_put_contents('assets/images/foto-produk/'.$nama_gambar, $gambar);
        
        // Menambahkan data foto produk...
        $usaha_photo = new UsahaPhoto;
        $usaha_photo->usaha_id = $request->usaha;
        $usaha_photo->photo = $nama_gambar;
        $usaha_photo->tanggal = date('Y-m-d h:i:s');
        $usaha_photo->deskripsi = $request->deskripsi != null ? $request->deskripsi : '';
        $usaha_photo->save();

        // Redirect...
        return redirect('/admin/umkm/foto/'.$request->usaha);
    }

    /**
     * Menghapus data foto produk...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_photo(Request $request)
    {
        // Data foto berdasarkan $request->id...
        $usaha_photo = UsahaPhoto::find($request->id);

        // Menghapus foto...
        if($usaha_photo->delete()){
            File::delete('assets/images/foto-produk/'.$usaha_photo->photo);
            echo "Berhasil menghapus foto.";
        }
        else{
            echo "Terjadi masalah dalam menghapus foto.";
        }
    }

    /**
     * Menampilkan form untuk mengedit data usaha...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data usaha berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::find($id);
        }
        // Data usaha berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }

        // Jika data usaha tidak ditemukan...
        if(!$usaha){
            abort(404);
        }

        // Data pemilik usaha berdasarkan $usaha->pemilik_id
        $pemilik = Pemilik::find($usaha->pemilik_id);

        // Data izin usaha berdasarkan $usaha->pemilik_id
        $izin = Izin::find($usaha->izin_id);
        
        // Data pelatihan berdasarkan $usaha->id...
        $pelatihan = ProgramUsaha::join('program','program_usaha.pelatihan_id','=','program.id')->where('usaha_id','=',$usaha->id)->get();
        
        // Data pelatihan...
        $data_pelatihan = Pelatihan::where('wilayah_id','=',$usaha->wilayah_id)->get();

        // Data bidang...
        $bidang = Bidang::all();

        // Data wilayah...
        $wilayah = Wilayah::all();

        // Data mentor...
        $mentor = Mentor::where('wilayah_id','=',$usaha->wilayah_id)->get();

        // View...
        return view('usaha/admin/edit', [
            'usaha' => $usaha,
            'pemilik' => $pemilik,
            'izin' => $izin,
            'pelatihan' => $pelatihan,
            'data_pelatihan' => $data_pelatihan,
            'bidang' => $bidang,
            'wilayah' => $wilayah,
            'mentor' => $mentor,
        ]);  
    }

    /**
     * Mengupdate usaha ke database...
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
            'nama_usaha' => 'required|string|min:3|max:100',
            // 'tahun_berdiri' => 'required|numeric',
            // 'alamat_usaha' => 'required|string',
            // 'notelp' => 'required|min:3|max:20',
            // 'email' => 'required|email|min:6|max:120',
            // 'website' => 'required|min:6|max:120',
            // 'kredit_bank' => 'required',
            // 'tenaga_kerja' => 'required|numeric',
            // 'bidang_id' => 'required',
            'wilayah_id' => 'required',
            // 'mentor_id' => 'required',
            'nama_pemilik' => 'required|string|min:3|max:100',
            // 'alamat_pemilik' => 'required|string',
            // 'notelp_pemilik' => 'required|min:3|max:20',
            'akte_notaris' => 'max:100',
            'badan_hukum' => 'max:100',
            'siup' => 'max:50',
            'npwp' => 'max:50',
            'tdp' => 'max:50',
            'lain' => 'max:80',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Mengupdate data pemilik UMKM...
            $pemilik = Pemilik::find($request->pemilik_id);
            $pemilik->nama = $request->nama_pemilik;
            $pemilik->alamat = $request->alamat_pemilik;
            $pemilik->notelp = $request->notelp_pemilik;
            $pemilik->status = 0;
            if($pemilik->save()){
                $pemilik_id = $request->pemilik_id;
            }
            else{
                $pemilik_id = 0;
            }

            // Menyimpan data izin usaha...
            $izin = Izin::find($request->izin_id);
            $izin->akte_notaris = $request->akte_notaris != null ? $request->akte_notaris : '';
            $izin->badan_hukum = $request->badan_hukum != null ? $request->badan_hukum : '';
            $izin->siup = $request->siup != null ? $request->siup : '';
            $izin->npwp = $request->npwp != null ? $request->npwp : '';
            $izin->tdp = $request->tdp != null ? $request->tdp : '';
            $izin->lain = $request->lain != null ? $request->lain : '';
            if($izin->save()){
                $izin_id = $request->izin_id;
            }
            else{
                $izin_id = 0;
            }

            // Menyimpan data usaha...
            $usaha = Usaha::find($request->usaha_id);
            $usaha->pemilik_id = $pemilik_id;
            $usaha->bidang_id = $request->bidang_id;
            $usaha->izin_id = $izin_id;
            $usaha->mentor_id = $request->mentor_id;
            $usaha->nama_usaha = $request->nama_usaha;
            $usaha->tahun_berdiri = $request->tahun_berdiri;
            $usaha->alamat_usaha = $request->alamat_usaha;
            $usaha->notelp = $request->notelp;
            $usaha->email = $request->email;
            $usaha->website = $request->website;
            $usaha->kredit_bank = $request->kredit_bank;
            $usaha->tenaga_kerja = $request->tenaga_kerja;
            $usaha->wilayah_id = $request->wilayah_id;
            $usaha->save();
        }

        // Redirect...
        return redirect('/admin/umkm');
    }

    /**
     * Menghapus data usaha...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Data usaha berdasarkan $id...
        $usaha = Usaha::find($id);

        // Menghapus data...
        if($usaha->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }

    /**
     * Menambahkan pelatihan ke usaha...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_program(Request $request)
    {
        // Data program usaha...
        $check = ProgramUsaha::where('pelatihan_id','=',$request->program)->where('usaha_id','=',$request->id)->get();
        
        // Jika tidak ada...
        if(count($check) <= 0){
            $program_usaha = new ProgramUsaha;
            $program_usaha->pelatihan_id = $request->program;
            $program_usaha->usaha_id = $request->id;
            if($program_usaha->save()){
                $p = ProgramUsaha::where('pelatihan_id','=',$request->program)->where('usaha_id','=',$request->id)->latest('id_program_usaha')->first();
                $pelatihan = Pelatihan::find($request->program);
                $data['status'] = 1;
                $data['id'] = $p->id_program_usaha;
                $data['pelatihan'] = $pelatihan->nama;
                $data['lokasi'] = $pelatihan->lokasi_pelatihan;
            }
        }
        else{
            $data['status'] = 0;
        }
        
        echo json_encode($data);
    }

    /**
     * Menghapus data program usaha...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_program(Request $request)
    {
        // Data program usaha berdasarkan $request->id...
        $program_usaha = ProgramUsaha::find($request->id);

        // Menghapus data...
        if($program_usaha->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }
}
