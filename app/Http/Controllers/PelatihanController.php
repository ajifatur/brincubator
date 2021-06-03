<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Pemilik;
use App\Pelatihan;
use App\ProgramUsaha;
use App\Usaha;
use App\Wilayah;

class PelatihanController extends Controller
{
    /**
     * Menampilkan data pelatihan...
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data pelatihan jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $pelatihan = Pelatihan::orderBy('id','desc')->get();
            $wilayah = Wilayah::all();
        }
        // Data pelatihan jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $pelatihan = Pelatihan::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
            $wilayah = array();
        }

        // Data pelatihan...
        foreach($pelatihan as $key=>$data){
            $total = ProgramUsaha::where('pelatihan_id','=',$data->id)->get();
            $pelatihan[$key]->total = count($total);
        	$data->wilayah_id = Wilayah::find($data->wilayah_id);
        }
        
        $wil = 0;

        // View...
    	return view('pelatihan/admin/index', [
    	    'pelatihan' => $pelatihan,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	]);
    }
    
    /**
     * Menampilkan data pelatihan per wilayah...
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
            // Data pelatihan jika rolenya super admin...
            if(Auth::user()->role_id == 0){
                $pelatihan = Pelatihan::where('wilayah_id','=',$wil)->orderBy('id','desc')->get();
                $wilayah = Wilayah::all();
            }
            // Data pelatihan jika rolenya admin...
            elseif(Auth::user()->role_id == 1){
                $pelatihan = Pelatihan::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
                $wilayah = array();
            }
    
            // Data pelatihan...
            foreach($pelatihan as $key=>$data){
                $total = ProgramUsaha::where('pelatihan_id','=',$data->id)->get();
                $pelatihan[$key]->total = count($total);
            	$data->wilayah_id = Wilayah::find($data->wilayah_id);
            }
        }

        // View...
    	return view('pelatihan/admin/index', [
    	    'pelatihan' => $pelatihan,
    	    'wil' => $wil,
    	    'wilayah' => $wilayah
    	 ]);
    }

    /**
     * Menampilkan form untuk memasukkan data pelatihan...
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data wilayah...
        $wilayah = Wilayah::orderBy('nama_kota','asc')->get();

        // Data pelatihan jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::orderBy('id','desc')->get();
        }
        // Data usaha jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
        }

        // View...
        return view('pelatihan/admin/create', [
        	'usaha' => $usaha,
        	'wilayah' => $wilayah,
        ]);  
    }

    /**
     * Menyimpan pelatihan ke database...
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
            'tanggal_pelatihan' => 'required',
            'jam_pelatihan_mulai' => 'required',
            'jam_pelatihan_selesai' => 'required',
            'lokasi_pelatihan' => 'required',
            'wilayah_id' => 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Mengatur tanggal dan jam pelatihan...
            $tanggal = explode('/', $request->tanggal_pelatihan);
            $tanggal = $tanggal[2].'-'.$tanggal[0].'-'.$tanggal[1];
            $jam = $request->jam_pelatihan_mulai.' - '.$request->jam_pelatihan_selesai;
            
            // Menyimpan data...
            $pelatihan = new Pelatihan;
            $pelatihan->nama = $request->nama;
            $pelatihan->tanggal_pelatihan = $tanggal;
            $pelatihan->jam_pelatihan = $jam;
            $pelatihan->lokasi_pelatihan = $request->lokasi_pelatihan;
            $pelatihan->wilayah_id = $request->wilayah_id;
            $pelatihan->save();
        }

        // Redirect...
        return redirect('/admin/pelatihan');
    }

    /**
     * Menampilkan data peserta pelatihan...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Data pelatihan berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $pelatihan = Pelatihan::find($id);
        }
        // Data pelatihan berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $pelatihan = Pelatihan::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }
        
        // Jika tidak ada pelatihan...
        if(!$pelatihan){
            abort(404);
        }
        // Jika ada...
        else{
            // Data peserta pelatihan...
            $peserta = ProgramUsaha::join('usaha','program_usaha.usaha_id','=','usaha.id')->where('pelatihan_id','=',$id)->get();
            foreach($peserta as $data){
            	$data->pemilik_id = Pemilik::find($data->pemilik_id);
            }
            
            // Data UMKM...
            $usaha = Usaha::where('wilayah_id','=',$pelatihan->wilayah_id)->orderBy('nama_usaha','asc')->get();
        }
        
        // View...
        return view('/pelatihan/admin/detail', [
            'pelatihan' => $pelatihan,
            'peserta' => $peserta,
            'usaha' => $usaha
        ]);
    }

    /**
     * Menambah peserta baru ke pelatihan...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_participant(Request $request)
    {
        // Mengecek apakah UMKM sudah terdaftar sebagai peserta atau belum...
        $program_usaha = ProgramUsaha::where('pelatihan_id','=',$request->pelatihan)->where('usaha_id','=',$request->usaha)->first();
        
        // Jika tidak ada, maka akan menyimpan data...
        if(!$program_usaha){
            $pu = new ProgramUsaha;
            $pu->pelatihan_id = $request->pelatihan;
            $pu->usaha_id = $request->usaha;
            $pu->save();
        }

        // Redirect...
        return redirect('/admin/pelatihan/peserta/'.$request->pelatihan);
    }

    /**
     * Menghapus peserta dari pelatihan...
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_participant(Request $request)
    {
        // Data program usaha berdasarkan $id
        $program_usaha = ProgramUsaha::find($request->id);

        // Menghapus data...
        if($program_usaha->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }


    /**
     * Menampilkan form untuk mengedit data pelatihan...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data pelatihan berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $pelatihan = Pelatihan::find($id);
        }
        // Data pelatihan berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $pelatihan = Pelatihan::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }

        if(!$pelatihan){
            abort(404);
        }
        else{
            $pelatihan->jam_pelatihan = explode(' - ', $pelatihan->jam_pelatihan);
        }

        // Data wilayah...
        $wilayah = Wilayah::orderBy('nama_kota','asc')->get();

        // Data pelatihan jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $usaha = Usaha::orderBy('id','desc')->get();
        }
        // Data usaha jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $usaha = Usaha::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('id','desc')->get();
        }

        // View...
        return view('pelatihan/admin/edit', [
            'pelatihan' => $pelatihan,
            'usaha' => $usaha,
            'wilayah' => $wilayah,
        ]);  
    }

    /**
     * Mengupdate pelatihan ke database...
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
            'tanggal_pelatihan' => 'required',
            'jam_pelatihan_mulai' => 'required',
            'jam_pelatihan_selesai' => 'required',
            'lokasi_pelatihan' => 'required',
            'wilayah_id' => 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Mengatur tanggal dan jam pelatihan...
            $tanggal = explode('/', $request->tanggal_pelatihan);
            $tanggal = $tanggal[2].'-'.$tanggal[0].'-'.$tanggal[1];
            $jam = $request->jam_pelatihan_mulai.' - '.$request->jam_pelatihan_selesai;
            
            // Menyimpan data...
            $pelatihan = Pelatihan::find($request->id);
            $pelatihan->nama = $request->nama;
            $pelatihan->tanggal_pelatihan = $tanggal;
            $pelatihan->jam_pelatihan = $jam;
            $pelatihan->lokasi_pelatihan = $request->lokasi_pelatihan;
            $pelatihan->wilayah_id = $request->wilayah_id;
            $pelatihan->save();
        }

        // Redirect...
        return redirect('/admin/pelatihan');
    }


    /**
     * Menghapus data pelatihan...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Data pelatihan berdasarkan $id
        $pelatihan = Pelatihan::find($id);

        // Menghapus data...
        if($pelatihan->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }

}
