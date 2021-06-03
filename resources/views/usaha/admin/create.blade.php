@extends('template/template')

@section('title', 'Tambah UMKM')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Tambah UMKM</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Tambah UMKM</li>
										</ol>
										<div class="clearfix"></div>
								</div>
						</div>
				</div>
				<!-- end row -->

				<div class="row">
					
					<div class="col-12">						
						<div class="card mb-3">
							<div class="card-header">
								<h3><i class="fa fa-check-square-o"></i> Tambah UMKM</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/umkm/store">
								  {{ csrf_field() }}
								  <h5 class="mb-4">Profil UMKM</h5>
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama UMKM</label>
									  <input type="text" name="nama_usaha" class="form-control {{ $errors->has('nama_usaha') ? 'is-invalid' : '' }}" placeholder="Nama UMKM" value="{{ old('nama_usaha') }}">
									  @if($errors->has('nama_usaha'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama_usaha')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Tahun Berdiri</label>
									  <input type="number" name="tahun_berdiri" class="form-control {{ $errors->has('tahun_berdiri') ? 'is-invalid' : '' }}" placeholder="Tahun Berdiri" value="{{ old('tahun_berdiri') }}">
									  @if($errors->has('tahun_berdiri'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tahun_berdiri')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Alamat UMKM</label>
									  <input type="text" name="alamat_usaha" class="form-control {{ $errors->has('alamat_usaha') ? 'is-invalid' : '' }}" placeholder="Alamat UMKM" value="{{ old('alamat_usaha') }}">
									  @if($errors->has('alamat_usaha'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('alamat_usaha')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>No. Telepon</label>
									  <input type="text" name="notelp" class="form-control {{ $errors->has('notelp') ? 'is-invalid' : '' }}" placeholder="No. Telepon" value="{{ old('notelp') }}">
									  @if($errors->has('notelp'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('notelp')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Email</label>
									  <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}">
									  @if($errors->has('email'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('email')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Website</label>
									  <input type="text" name="website" class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" placeholder="Website" value="{{ old('website') }}">
									  @if($errors->has('website'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('website')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Besarnya Kredit Bank</label>
									  <input type="number" name="kredit_bank" class="form-control {{ $errors->has('kredit_bank') ? 'is-invalid' : '' }}" placeholder="Kredit Bank" value="{{ old('kredit_bank') }}">
									  @if($errors->has('kredit_bank'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('kredit_bank')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Jumlah Tenaga Kerja</label>
									  <input type="number" name="tenaga_kerja" class="form-control {{ $errors->has('tenaga_kerja') ? 'is-invalid' : '' }}" placeholder="Tenaga Kerja" value="{{ old('tenaga_kerja') }}">
									  @if($errors->has('tenaga_kerja'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tenaga_kerja')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Bidang Usaha</label>
									  <select name="bidang_id" class="form-control {{ $errors->has('bidang_id') ? 'is-invalid' : '' }}">
									  	<option value="0" selected>--Pilih Bidang Usaha--</option>
									  	@foreach($bidang as $data)
								  		<option value="{{ $data->id }}" {{ old('bidang_id') == $data->id ? 'selected' : '' }}>{{ $data->nama }}</option>
									  	@endforeach
									  </select>
									  @if($errors->has('bidang_id'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('bidang_id')) }}
									  </div>
									  @endif
									</div>
									@if(Auth::user()->role_id == 0)
									<div class="col-md-6 mb-3">
									  <label>Wilayah</label>
									  <select name="wilayah_id" class="form-control {{ $errors->has('wilayah_id') ? 'is-invalid' : '' }}">
									  	<option value="" disabled selected>--Pilih Wilayah--</option>
									  	@foreach($wilayah as $data)
								  		<option value="{{ $data->id }}" {{ old('wilayah_id') == $data->id ? 'selected' : '' }}>{{ $data->nama_kota }}</option>
									  	@endforeach
									  </select>
									  @if($errors->has('wilayah_id'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('wilayah_id')) }}
									  </div>
									  @endif
									</div>
									@elseif(Auth::user()->role_id == 1)
									<input type="hidden" name="wilayah_id" value="{{ Auth::user()->wilayah_id }}">
									@endif
									<div class="col-md-6 mb-3">
									  <label>Mentor</label>
									  <select name="mentor_id" class="form-control {{ $errors->has('mentor_id') ? 'is-invalid' : '' }}">
									  	<option value="0" selected>--Pilih Mentor--</option>
									  	@foreach($mentor as $data)
								  		<option value="{{ $data->id }}" {{ old('mentor_id') == $data->id ? 'selected' : '' }}>{{ $data->nama }}</option>
									  	@endforeach
									  </select>
									  @if($errors->has('mentor_id'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('mentor_id')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <h5 class="my-4">Profil Pemilik UMKM</h5>
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama Pemilik</label>
									  <input type="text" name="nama_pemilik" class="form-control {{ $errors->has('nama_pemilik') ? 'is-invalid' : '' }}" placeholder="Nama Pemilik" value="{{ old('nama_pemilik') }}">
									  @if($errors->has('nama_pemilik'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama_pemilik')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Alamat</label>
									  <input type="text" name="alamat_pemilik" class="form-control {{ $errors->has('alamat_pemilik') ? 'is-invalid' : '' }}" placeholder="Alamat Pemilik" value="{{ old('alamat_pemilik') }}">
									  @if($errors->has('alamat_pemilik'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('alamat_pemilik')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>No. Telepon</label>
									  <input type="text" name="notelp_pemilik" class="form-control {{ $errors->has('notelp_pemilik') ? 'is-invalid' : '' }}" placeholder="No. Telepon Pemilik" value="{{ old('notelp_pemilik') }}">
									  @if($errors->has('notelp_pemilik'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('notelp_pemilik')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <h5 class="my-4">Izin Usaha</h5>
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Akte Notaris</label>
									  <input type="text" name="akte_notaris" class="form-control {{ $errors->has('akte_notaris') ? 'is-invalid' : '' }}" placeholder="Akte Notaris" value="{{ old('akte_notaris') }}">
									  @if($errors->has('akte_notaris'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('akte_notaris')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Badan Hukum</label>
									  <input type="text" name="badan_hukum" class="form-control {{ $errors->has('badan_hukum') ? 'is-invalid' : '' }}" placeholder="Badan Hukum" value="{{ old('badan_hukum') }}">
									  @if($errors->has('badan_hukum'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('badan_hukum')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>SIUP</label>
									  <input type="text" name="siup" class="form-control {{ $errors->has('siup') ? 'is-invalid' : '' }}" placeholder="SIUP" value="{{ old('siup') }}">
									  @if($errors->has('siup'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('siup')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>NPWP</label>
									  <input type="text" name="npwp" class="form-control {{ $errors->has('npwp') ? 'is-invalid' : '' }}" placeholder="NPWP" value="{{ old('npwp') }}">
									  @if($errors->has('npwp'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('npwp')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>TDP</label>
									  <input type="text" name="tdp" class="form-control {{ $errors->has('tdp') ? 'is-invalid' : '' }}" placeholder="SIUP" value="{{ old('tdp') }}">
									  @if($errors->has('tdp'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tdp')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Lain</label>
									  <input type="text" name="lain" class="form-control {{ $errors->has('lain') ? 'is-invalid' : '' }}" placeholder="Lain" value="{{ old('lain') }}">
									  @if($errors->has('lain'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('lain')) }}
									  </div>
									  @endif
									</div>
								  </div>

								  <button class="btn btn-primary" type="submit">Simpan</button>
								</form>

							</div>							
						</div><!-- end card-->					
                    </div>

				</div>		

            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

@endsection