@extends('template/template')

@section('title', 'Data User')

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
										<h1 class="main-title float-left">Data User</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Data User</li>
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
										<div class="col">
											<h3><i class="fa fa-table"></i> Data User</h3>
										</div>
										<div class="col-auto">
											<a href="/admin/user/tambah" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah User</a>
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
												<th>Username</th>
												<th>Email</th>
												<th width="100">Role</th>
												<th>Wilayah</th>
												<th width="70">Opsi</th>
											</tr>
										</thead>										
										<tbody>
											<?php $i = 1; ?>
                                            @foreach($user as $data)
											<tr>
												<td>{{ $i }}</td>
                                                <td>{{ $data->full_name }}</td>
                                                <td>{{ $data->username }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->role_id->name }}</td>
                                                <td>{{ $data->role_id->id == 0 ? '-' : $data->wilayah_id->nama_kota }}</td>
                                                <td>
                                                	<a href="/admin/user/edit/{{ $data->id }}" title="Edit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-edit"></i></a>
                                                	@if(Auth::user()->id != $data->id)
                                                	<a href="#" title="Hapus" data-id="{{ $data->id }}" class="btn btn-danger btn-sm mb-2 delete"><i class="fa fa-trash"></i></a>
                                                	@else
                                                	<a href="#" title="Tidak bisa menghapus akun sendiri" class="btn btn-dark btn-sm mb-2" onclick="event.preventDefault();" style="cursor: default;"><i class="fa fa-trash"></i></a>
                                                	@endif
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
				url: "/admin/user/delete/"+id,
				data: {id: id},
				success: function(response){
					if(response == "Berhasil menghapus data."){
						alert(response);
						window.location.href = '/admin/user';
					}
					else{
						alert(response);
					}
				}
			});
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