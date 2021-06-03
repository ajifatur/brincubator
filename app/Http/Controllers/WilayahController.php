<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Wilayah;

class WilayahController extends Controller
{
    /**
     * Menampilkan data wilayah...
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data wilayah...
        $wilayah = Wilayah::all();

        // View...
    	return view('wilayah/admin/index', ['wilayah' => $wilayah]);
    }

    /**
     * Menampilkan form untuk memasukkan data wilayah...
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // View...
        return view('wilayah/admin/create');  
    }

    /**
     * Menyimpan wilayah ke database...
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
            'nama_kota' => 'required|string|min:3|max:120',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $wilayah = new Wilayah;
            $wilayah->nama_kota = $request->nama_kota;
            $wilayah->save();
        }

        // Redirect...
        return redirect('/admin/wilayah');
    }

    /**
     * Menampilkan form untuk mengedit data wilayah...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data wilayah berdasarkan $id
        $wilayah = wilayah::find($id);

        // View...
        return view('wilayah/admin/edit', [
            'wilayah' => $wilayah,
        ]);  
    }

    /**
     * Mengupdate data wilayah...
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
            'nama_kota' => 'required|string|min:3|max:120',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $wilayah = Wilayah::find($request->id);
            $wilayah->nama_kota = $request->nama_kota;
            $wilayah->save();
        }

        // Redirect...
        return redirect('/admin/wilayah');
    }

    /**
     * Menghapus data wilayah...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Data wilayah berdasarkan $id
        $wilayah = Wilayah::find($id);

        // Menghapus data...
        if($wilayah->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }
}
