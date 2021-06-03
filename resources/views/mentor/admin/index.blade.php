@extends('template/template')

@section('title', 'Data Mentor')

@section('head-extra')

        <!-- BEGIN CSS for this page -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>    
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
										<h1 class="main-title float-left">Data Mentor</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Data Mentor</li>
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
											<h3><i class="fa fa-table"></i> Data Mentor</h3>
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
											<a href="/admin/mentor/tambah" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah Mentor</a>
										</div>
									</div>
								</div>
									
								<div class="card-body">
									<div class="table-responsive">
									<table id="example1" class="table table-bordered table-hover display">
										<thead>
											<tr>
                                                <th width="50">#</th>
												<th>Nama</th>
												<th>Email</th>
												<th>No. Telepon</th>
												<th>Wilayah</th>
												<th width="70">Mentee</th>
                                                <th width="120">Opsi</th>
											</tr>
										</thead>										
										<tbody>
											<?php $i = 1; ?>
                                            @foreach($mentor as $data)
											<tr>
												<td>{{ $i }}</td>
                                                <td>{{ $data->nama }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->notelp }}</td>
                                                <td>{{ $data->wilayah_id->nama_kota }}</td>
                                                <td>{{ number_format($data->total,0,',',',') }}</td>
                                                <td>
                                                	<a href="/admin/mentor/mentee/{{ $data->id }}" title="Lihat Mentee" class="btn btn-success btn-sm mb-2"><i class="fa fa-eye"></i></a>
                                                	<a href="/admin/mentor/edit/{{ $data->id }}" title="Edit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-edit"></i></a>
                                                	<a href="#" title="Hapus" data-id="{{ $data->id }}" class="btn btn-danger btn-sm mb-2 delete"><i class="fa fa-trash"></i></a>
                                                </td>
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

@endsection

@section('js-extra')

<!-- BEGIN Java Script for this page -->
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

	<script>
	// START CODE FOR BASIC DATA TABLE 
	$(document).ready(function() {
		$('#example1').DataTable();
	} );
	// END CODE FOR BASIC DATA TABLE

	// Menghapus data...
	$(document).on("click", ".delete", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		var ask = confirm("Anda yakin ingin menghapus data ini?");
		if(ask){
			$.ajax({
				type: "get",
				url: "/admin/mentor/delete/"+id,
				data: {id: id},
				success: function(response){
					if(response == "Berhasil menghapus data."){
						alert(response);
						window.location.href = '/admin/mentor';
					}
					else{
						alert(response);
					}
				}
			});
		}
	});
	
	// Redirect mentor berdasarkan wilayah...
	$(document).on("change", "#wilayah", function(){
		var wilayah = $(this).val();
		if(wilayah != 0){
    		window.location.href = "/admin/mentor/wilayah/"+wilayah;
    	}
    	else{
    		window.location.href = "/admin/mentor/";
    	}
	});
	</script>	
<!-- END Java Script for this page -->

@endsection

@section('css-extra')

<style type="text/css">
	.table td, .table th {padding: .75rem!important;}
</style>

@endsection