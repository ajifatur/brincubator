@extends('template/template')

@section('title', 'Tambah Mentor')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Tambah Mentor</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Tambah Mentor</li>
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
								<h3><i class="fa fa-check-square-o"></i> Tambah Mentor</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/mentor/store">
								  {{ csrf_field() }}
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama Mentor</label>
									  <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" placeholder="Nama Mentor" value="{{ old('nama') }}">
									  @if($errors->has('nama'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Pekerjaan</label>
									  <input type="text" name="pekerjaan" class="form-control {{ $errors->has('pekerjaan') ? 'is-invalid' : '' }}" placeholder="Pekerjaan" value="{{ old('pekerjaan') }}">
									  @if($errors->has('pekerjaan'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('pekerjaan')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Tempat Lahir</label>
									  <input type="text" name="tempat_lahir" class="form-control {{ $errors->has('tempat_lahir') ? 'is-invalid' : '' }}" placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}">
									  @if($errors->has('tempat_lahir'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tempat_lahir')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Tanggal Lahir</label>
									  <input type="date" name="tanggal_lahir" class="form-control {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}" placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir') }}">
									  @if($errors->has('tanggal_lahir'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tanggal_lahir')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Alamat</label>
									  <input type="text" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}" placeholder="Alamat" value="{{ old('alamat') }}">
									  @if($errors->has('alamat'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('alamat')) }}
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
									  <label>Alamat Kantor</label>
									  <input type="text" name="alamat_kantor" class="form-control {{ $errors->has('alamat_kantor') ? 'is-invalid' : '' }}" placeholder="Alamat Kantor" value="{{ old('alamat_kantor') }}">
									  @if($errors->has('alamat_kantor'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('alamat_kantor')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Jabatan</label>
									  <input type="text" name="jabatan" class="form-control {{ $errors->has('jabatan') ? 'is-invalid' : '' }}" placeholder="Jabatan" value="{{ old('jabatan') }}">
									  @if($errors->has('jabatan'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('jabatan')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Pendidikan Terakhir</label>
									  <input type="text" name="pendidikan_terakhir" class="form-control {{ $errors->has('pendidikan_terakhir') ? 'is-invalid' : '' }}" placeholder="Pendidikan Terakhir" value="{{ old('pendidikan_terakhir') }}">
									  @if($errors->has('pendidikan_terakhir'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('pendidikan_terakhir')) }}
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
									  <label>Nama Usaha</label>
									  <input type="text" name="nama_usaha" class="form-control {{ $errors->has('nama_usaha') ? 'is-invalid' : '' }}" placeholder="Nama Usaha" value="{{ old('nama_usaha') }}">
									  @if($errors->has('nama_usaha'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama_usaha')) }}
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