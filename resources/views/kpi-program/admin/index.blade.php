@extends('template/template')

@section('title', 'KPI Program')

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
										<h1 class="main-title float-left">KPI Program</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">KPI Program</li>
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
											<h3><i class="fa fa-table"></i> KPI Program</h3>
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
									</div>
								</div>

								<div class="card-body">
									<div class="table-responsive">
									<table id="example1" class="table table-bordered table-hover display">
										<thead>
											<tr>
                                                <th width="50">#</th>
												<th>Nama UMKM</th>
												<th width="120">GO-Modern</th>
												<th width="120">GO-Digital</th>
												<th width="120">GO-Online</th>
												<th width="120">GO-Global</th>
											</tr>
										</thead>										
										<tbody>
											<?php $i=1; ?>
                                            @foreach($usaha as $key=>$data)
											<tr>
												<td>{{ $i }}</td>
                                                <td>{{ $data->nama_usaha }}</td>
                                                <td align="center"><input type="checkbox" class="kpi" data-id="{{ $data->id }}" data-column="go_modern" {{ $data->go_modern == 1 ? 'checked' : '' }}></td>
                                                <td align="center"><input type="checkbox" class="kpi" data-id="{{ $data->id }}" data-column="go_digital" {{ $data->go_digital == 1 ? 'checked' : '' }}></td>
                                                <td align="center"><input type="checkbox" class="kpi" data-id="{{ $data->id }}" data-column="go_online" {{ $data->go_online == 1 ? 'checked' : '' }}></td>
                                                <td align="center"><input type="checkbox" class="kpi" data-id="{{ $data->id }}" data-column="go_global" {{ $data->go_global == 1 ? 'checked' : '' }}></td>
											</tr>
											<?php $i++; ?>
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

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	// START CODE FOR BASIC DATA TABLE 
	$(document).ready(function() {
		$('#example1').DataTable();
	} );
	// END CODE FOR BASIC DATA TABLE
	
	// Redirect KPI Program berdasarkan wilayah...
	$(document).on("change", "#wilayah", function(){
		var wilayah = $(this).val();
		if(wilayah == 0){
    		window.location.href = "/admin/kpi-program";
    	}
    	else{
    		window.location.href = "/admin/kpi-program/wilayah/"+wilayah;
    	}
	});
	
	// Mengganti KPI Program pada UMKM...
	$(document).on("change", ".kpi", function(){
	   var elem = $(this);
	   var checked = $(this).is(":checked");
	   var val = checked ? 1 : 0;
	   var id = $(this).data("id");
	   var column = $(this).data("column");
	   $.ajax({
	       type: "post",
	       url: "/admin/kpi-program/update",
	       data: {val: val, id: id, column: column, _token: "{{ csrf_token() }}"},
	       success: function(response){
	           if(response == 'Sukses'){
	               alert("Berhasil mengganti data.");
	           }
	           else{
	               alert("Tidak berhasil mengganti data.");
	               val == 1 ? elem.prop("checked", false) : elem.prop("checked", true);
	           }
	       }
	   })
	});
</script>

@endsection

@section('css-extra')

<style type="text/css">
	/*.table {width: max-content!important;}*/
	.table td, .table th {padding: .75rem!important;}
</style>

@endsection