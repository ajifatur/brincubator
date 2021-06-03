@extends('template/template')

@section('title', 'Edit Bidang Usaha')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Edit Bidang Usaha</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Edit Bidang Usaha</li>
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
								<h3><i class="fa fa-check-square-o"></i> Edit Bidang Usaha</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/bidang/update">
								  {{ csrf_field() }}
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama Bidang Usaha</label>
									  <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" placeholder="Nama Bidang Usaha" value="{{ $bidang->nama }}">
									  @if($errors->has('nama'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <input type="hidden" name="id" value="{{ $bidang->id }}">
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