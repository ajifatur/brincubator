@extends('template/template')

@section('title', 'Tambah Wilayah')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Tambah Wilayah</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Tambah Wilayah</li>
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
								<h3><i class="fa fa-check-square-o"></i> Tambah Wilayah</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/wilayah/store">
								  {{ csrf_field() }}
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama Kota</label>
									  <input type="text" name="nama_kota" class="form-control {{ $errors->has('nama_kota') ? 'is-invalid' : '' }}" placeholder="Nama Kota" value="{{ old('nama_kota') }}">
									  @if($errors->has('nama_kota'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama_kota')) }}
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