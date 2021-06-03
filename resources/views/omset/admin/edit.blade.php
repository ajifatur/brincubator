@extends('template/template')

@section('title', 'Edit Omset')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Edit Omset</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Edit Omset</li>
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
								<h3><i class="fa fa-check-square-o"></i> Edit Omset</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/omset/update">
								  {{ csrf_field() }}
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Omset</label>
									  <input type="number" name="omset" class="form-control {{ $errors->has('omset') ? 'is-invalid' : '' }}" placeholder="Total Omset" value="{{ $omset ? $omset->omset : '0' }}">
									  @if($errors->has('omset'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('omset')) }}
									  </div>
									  @endif
									</div>
									<input type="hidden" name="penjualan" value="0">
									<div class="col-md-6 mb-3">
									  <label>Bulan</label>
									  <select name="bulan" class="form-control {{ $errors->has('bulan') ? 'is-invalid' : '' }}">
									  	<option value="1" {{ $bulan == 1 ? 'selected' : '' }}>Januari</option>
									  	<option value="2" {{ $bulan == 2 ? 'selected' : '' }}>Februari</option>
									  	<option value="3" {{ $bulan == 3 ? 'selected' : '' }}>Maret</option>
									  	<option value="4" {{ $bulan == 4 ? 'selected' : '' }}>April</option>
									  	<option value="5" {{ $bulan == 5 ? 'selected' : '' }}>Mei</option>
									  	<option value="6" {{ $bulan == 6 ? 'selected' : '' }}>Juni</option>
									  	<option value="7" {{ $bulan == 7 ? 'selected' : '' }}>Juli</option>
									  	<option value="8" {{ $bulan == 8 ? 'selected' : '' }}>Agustus</option>
									  	<option value="9" {{ $bulan == 9 ? 'selected' : '' }}>September</option>
									  	<option value="10" {{ $bulan == 10 ? 'selected' : '' }}>Oktober</option>
									  	<option value="11" {{ $bulan == 11 ? 'selected' : '' }}>Nopember</option>
									  	<option value="12" {{ $bulan == 12 ? 'selected' : '' }}>Desember</option>
									  </select>
									  @if($errors->has('bulan'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('bulan')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Tahun</label>
									  <input type="number" name="tahun" class="form-control {{ $errors->has('tahun') ? 'is-invalid' : '' }}" placeholder="Tahun" value="{{ $tahun }}" readonly>
									  @if($errors->has('tahun'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tahun')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <input type="hidden" name="usaha_id" value="{{ $omset ? $omset->usaha_id : $usaha_id }}">
								  <button class="btn btn-primary" type="submit">Simpan</button>
								  <a href="#" id="delete" class="btn btn-danger">Hapus</a>
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