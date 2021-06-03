@extends('template/template')

@section('title', 'Edit User')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Edit User</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Edit User</li>
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
								<h3><i class="fa fa-check-square-o"></i> Edit User</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/user/update">
								  {{ csrf_field() }}
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama User</label>
									  <input type="text" name="full_name" class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" placeholder="Nama User" value="{{ $user->full_name }}">
									  @if($errors->has('full_name'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('full_name')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Username</label>
									  <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="Username" value="{{ $user->username }}">
									  @if($errors->has('username'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('username')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Email</label>
									  <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email" value="{{ $user->email }}">
									  @if($errors->has('email'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('email')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Password</label>
									  <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password">
									  <small class="text-muted">Kosongi saja jika tidak ingin mengganti password.</small>
									  @if($errors->has('password'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('password')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Role</label>
									  <select name="role_id" class="form-control {{ $errors->has('role_id') ? 'is-invalid' : '' }}">
									  	<option value="" disabled selected>--Pilih Role--</option>
									  	@foreach($role as $data)
								  		<option value="{{ $data->id }}" {{ $user->role_id == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
									  	@endforeach
									  </select>
									  @if($errors->has('role_id'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('role_id')) }}
									  </div>
									  @endif
									</div>
									@if(Auth::user()->role_id == 0)
									<div class="col-md-6 mb-3">
									  <label>Wilayah</label>
									  <select name="wilayah_id" class="form-control {{ $errors->has('wilayah_id') ? 'is-invalid' : '' }}">
									  	<option value="" disabled selected>--Pilih Wilayah--</option>
									  	@foreach($wilayah as $data)
								  		<option value="{{ $data->id }}" {{ $user->wilayah_id == $data->id ? 'selected' : '' }}>{{ $data->nama_kota }}</option>
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
								  <input type="hidden" name="id" value="{{ $user->id }}">
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