@extends('template/template')

@section('title', 'Data UMKM Bidang '.$bidang->nama)

@section('head-extra')

        <!-- BEGIN CSS for this page -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/> 
		<link href="{{ asset('templates/pike-admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>   
        <style> 
        td.details-control {
        background: url('{{ asset('templates/pike-admin/assets/plugins/datatables/img/details_open.png') }}') no-repeat center center;
        cursor: pointer;
        }
        tr.shown td.details-control {
        background: url('{{ asset('templates/pike-admin/assets/plugins/datatables/img/details_close.png') }}') no-repeat center center;
        }
        </style>        
        <!-- END CSS for this page -->

@endsection

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Data UMKM (Bidang {{ $bidang->nama }})</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Data UMKM (Bidang {{ $bidang->nama }})</li>
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
									<div class="row">
										<div class="col-sm">
											<h3><i class="fa fa-table"></i> Data UMKM (Bidang {{ $bidang->nama }})</h3>
										</div>
										@if(Auth::user()->role_id == 0)
										<div class="col-sm-auto mt-sm-0 mt-2">
											<select class="form-control form-control-sm" name="wilayah" id="wilayah">
											    <option value="0" {{ $wil == 0 ? 'selected' : '' }}>Semua Wilayah</option>
												@foreach($wilayah as $data)
												<option value="{{ $data->id }}" {{ $wil == $data->id ? 'selected' : '' }}>{{ $data->nama_kota }}</option>
												@endforeach
											</select>
										</div>
										@endif
										<div class="col-sm-auto mt-sm-0 mt-2">
											<a href="#custom-modal" data-target="#customModal" data-toggle="modal" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah UMKM</a>
										</div>
									</div>
								</div>
									
								<div class="card-body">
									<div class="table-responsive">
									<table id="example1" class="table table-bordered table-hover display">
										<thead>
											<tr>
                                                <th width="50">#</th>
												<th>Nama Usaha</th>
												<th>Nama Pemilik</th>
												<th>Alamat</th>
												<th width="150">Wilayah</th>
                                                <th width="40">Opsi</th>
											</tr>
										</thead>										
										<tbody>
											<?php $i = 1; ?>
                                            @foreach($umkm as $data)
											<tr>
												<td>{{ $i }}</td>
                                                <td>{{ $data->nama_usaha }}</td>
                                                <td>{{ $data->pemilik_id->nama }}</td>
                                                <td>{{ $data->alamat_usaha }}</td>
                                                <td>{{ $data->wilayah_id->nama_kota }}</td>
                                                <td>
                                                	<a href="#" title="Hapus" data-id="{{ $data->id }}" class="btn btn-danger btn-sm btn-block mb-2 delete"><i class="fa fa-trash"></i></a>
                                                </td></td>
                                                <?php $i++ ?>
											</tr>
                                            @endforeach
										</tbody>
									</table>
									</div>
									
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
	
	<!-- Modal -->
	<div class="modal fade custom-modal" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel2">Tambah UMKM</h5></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form id="tambah-peserta" method="post" action="/admin/bidang/tambah-umkm">
		      {{ csrf_field() }}
		  <div class="modal-body">
			  <label>UMKM</label>
			  <select name="usaha" id="usaha" class="form-control select2" required>
			      <option value="" disabled selected>--Pilih--</option>
			      @foreach($usaha as $data)
			      <option value="{{ $data->id }}">{{ $data->nama_usaha }}</option>
			      @endforeach
		      </select>
		  </div>
		  <div class="modal-footer">
		    <input type="hidden" name="bidang" value="{{ $bidang->id }}">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<!-- END Modal -->

@endsection

@section('js-extra')

<!-- BEGIN Java Script for this page -->
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
	<script src="{{ asset('templates/pike-admin/assets/plugins/select2/js/select2.min.js') }}"></script>

	<script>
	// START CODE FOR BASIC DATA TABLE 
	$(document).ready(function() {
		$('#example1').DataTable();
	} );
	// END CODE FOR BASIC DATA TABLE
	
	// Select2..
// 	$(document).ready(function() {
// 	    $('.select2').select2();
// 	});

	// Menghapus data...
	$(document).on("click", ".delete", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		var ask = confirm("Anda yakin ingin menghapus data ini?");
		if(ask){
			$.ajax({
				type: "post",
				url: "/admin/bidang/delete-umkm",
				data: {_token: "{{ csrf_token() }}", id: id},
				success: function(response){
					if(response == "Berhasil menghapus data."){
						alert(response);
						window.location.href = '/admin/bidang/umkm/{{ $bidang->id }}';
					}
					else{
						alert(response);
					}
				}
			});
		}
	});
	
	// Redirect UMKM berdasarkan wilayah...
	$(document).on("change", "#wilayah", function(){
		var wilayah = $(this).val();
		if(wilayah != 0){
    		window.location.href = "/admin/bidang/umkm/{{ $bidang->id }}/wilayah/"+wilayah;
    	}
    	else{
    		window.location.href = "/admin/bidang/umkm/{{ $bidang->id }}";
    	}
	});
	</script>	
<!-- END Java Script for this page -->

@endsection

@section('css-extra')

<style type="text/css">
	.table td, .table th {padding: .75rem!important;}
	.select2-container--default .select2-selection--single {height: calc(2.25rem + 2px); line-height: 1.5; font-size: 1rem; padding-top: .3rem;}
	.select2-container--default .select2-selection--single .select2-selection__arrow {height: calc(2.25rem + 2px); }
</style>

@endsection