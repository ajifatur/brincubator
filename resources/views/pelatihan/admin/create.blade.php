@extends('template/template')

@section('title', 'Tambah Pelatihan')

@section('head-extra')

<link href="{{ asset('templates/pike-admin/assets/plugins/datetimepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendors/wickedpicker/css/wickedpicker.min.css') }}" rel="stylesheet" type="text/css">

@endsection

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Tambah Pelatihan</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Tambah Pelatihan</li>
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
								<h3><i class="fa fa-check-square-o"></i> Tambah Pelatihan</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/pelatihan/store">
								  {{ csrf_field() }}
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama Pelatihan</label>
									  <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" placeholder="Nama Pelatihan" value="{{ old('nama') }}">
									  @if($errors->has('nama'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Lokasi Pelatihan</label>
									  <input type="text" name="lokasi_pelatihan" class="form-control {{ $errors->has('lokasi_pelatihan') ? 'is-invalid' : '' }}" placeholder="Lokasi Pelatihan" value="{{ old('lokasi_pelatihan') }}">
									  @if($errors->has('lokasi_pelatihan'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('lokasi_pelatihan')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-3 mb-3">
									  <label>Tanggal Pelatihan</label>
									  <input type="text" name="tanggal_pelatihan" id="tanggal_pelatihan" class="form-control {{ $errors->has('tanggal_pelatihan') ? 'is-invalid' : '' }}" placeholder="Tanggal Pelatihan">
									  @if($errors->has('tanggal_pelatihan'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tanggal_pelatihan')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-3 mb-3">
									  <label>Jam Pelatihan</label>
									  <div class="row">
									      <div class="col-md-6">
        									  <input type="text" name="jam_pelatihan_mulai" id="jam_pelatihan_mulai" class="form-control {{ $errors->has('jam_pelatihan_mulai') ? 'is-invalid' : '' }}" placeholder="Jam Mulai">
        									  @if($errors->has('jam_pelatihan_mulai'))
        									  <div class="invalid-feedback">
        										{{ ucfirst($errors->first('jam_pelatihan_mulai')) }}
        									  </div>
        									  @endif
									      </div>
									      <div class="col-md-6">
        									  <input type="text" name="jam_pelatihan_selesai" id="jam_pelatihan_selesai" class="form-control {{ $errors->has('jam_pelatihan_selesai') ? 'is-invalid' : '' }}" placeholder="Jam Selesai">
        									  @if($errors->has('jam_pelatihan_selesai'))
        									  <div class="invalid-feedback">
        										{{ ucfirst($errors->first('jam_pelatihan_selesai')) }}
        									  </div>
        									  @endif
									      </div>
									  </div>
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

@section('js-extra')

<script type="text/javascript" src="{{ asset('templates/pike-admin/assets/plugins/datetimepicker/js/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/wickedpicker/js/wickedpicker.min.js') }}"></script>
<script>
    $(function() {
      // Plugin daterangepicker...
      $('#tanggal_pelatihan').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
      });
      
      // Plugin wickedpicker...
      $('#jam_pelatihan_mulai, #jam_pelatihan_selesai').wickedpicker({twentyFour: true});
    });
</script>

@endsection