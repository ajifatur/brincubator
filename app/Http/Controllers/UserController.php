<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Role;
use App\User;
use App\Wilayah;

class UserController extends Controller
{
    /**
     * Menampilkan data user...
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data user jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $user = User::orderBy('role_id','asc')->get();
        }
        // Data user jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $user = User::where('wilayah_id','=',Auth::user()->wilayah_id)->orderBy('role_id','asc')->get();
        }

        // Data user...
        foreach($user as $data){
        	$data->role_id = Role::find($data->role_id);
        	$data->wilayah_id = $data->wilayah_id != 0 ? Wilayah::find($data->wilayah_id) : null;
        }

        // View...
        return view('user/admin/index', [
            'user' => $user,
        ]);
    }

    /**
     * Menampilkan form untuk memasukkan data user...
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            // Data wilayah...
            $wilayah = Wilayah::orderBy('nama_kota','asc')->get();

            // Data role...
            $role = Role::all();
        }
        // Jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            // Data wilayah...
            $wilayah = array();

            // Data role...
            $role = Role::where('id','>',0)->get();
        }

        // View...
        return view('user/admin/create', [
            'wilayah' => $wilayah,
            'role' => $role,
        ]);  
    }

    /**
     * Menyimpan user ke database...
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
            'confirmed' => 'Konfirmasi password tidak sesuai.',
        ];

        // Validasi...
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|min:6|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:5',
            'role_id' => 'required',
            'wilayah_id' => $request->role_id == 0 ? '' : 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $user = new User;
            $user->full_name = $request->full_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->wilayah_id = $request->role_id == 0 ? 0 : $request->wilayah_id;
            $user->status = 1;
            $user->save();
        }

        // Redirect...
        return redirect('/admin/user');
    }

    /**
     * Menampilkan form untuk mengedit data user...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data user berdasarkan $id jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            $user = User::find($id);
        }
        // Data mentor berdasarkan $id jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            $user = User::where('id','=',$id)->where('wilayah_id','=',Auth::user()->wilayah_id)->first();
        }

        if(!$user){
            abort(404);
        }

        // Jika rolenya super admin...
        if(Auth::user()->role_id == 0){
            // Data wilayah...
            $wilayah = Wilayah::orderBy('nama_kota','asc')->get();

            // Data role...
            $role = Role::all();
        }
        // Jika rolenya admin...
        elseif(Auth::user()->role_id == 1){
            // Data wilayah...
            $wilayah = array();

            // Data role...
            $role = Role::where('id','>',0)->get();
        }

        // View...
        return view('user/admin/edit', [
            'user' => $user,
            'wilayah' => $wilayah,
            'role' => $role,
        ]);  
    }

    /**
     * Mengupdate data user...
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
            'confirmed' => 'Konfirmasi password tidak sesuai.',
        ];

        // Validasi...
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'username' => [
                'required', 'string', 'min:6', 'max:255', Rule::unique('users')->ignore($request->id, 'id')
            ],
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id, 'id')
            ],
            'password' => $request->password == '' ? '' : 'min:5',
            'role_id' => 'required',
            'wilayah_id' => $request->role_id == 0 ? '' : 'required',
        ], $messages);
        
        // Mengecek jika ada error...
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error...
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error...
        else{
            // Menyimpan data...
            $user = User::find($request->id);
            $user->full_name = $request->full_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = $request->password != null ? bcrypt($request->password) : $user->password;
            $user->role_id = $request->role_id;
            $user->wilayah_id = $request->role_id == 0 ? 0 : $request->wilayah_id;
            $user->save();
        }

        // Redirect...
        return redirect('/admin/user');
    }

    /**
     * Menghapus data user...
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Data user berdasarkan $id
        $user = User::find($id);

        // Menghapus data...
        if($user->delete()){
            echo "Berhasil menghapus data.";
        }
        else{
            echo "Terjadi masalah dalam menghapus data.";
        }
    }

}
