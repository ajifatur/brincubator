@extends('template/template')

@section('title', 'Data Omset')

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
										<h1 class="main-title float-left">Data Omset</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Data Omset</li>
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
											<h3><i class="fa fa-table"></i> Data Omset</h3>
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
											<select class="form-control form-control-sm" name="tahun" id="tahun">
												@for($year=date('Y'); $year>=2015; $year--)
												<option value="{{ $year }}" {{ $year == $tahun ? 'selected' : '' }}>{{ $year }}</option>
												@endfor
											</select>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="table-responsive">
									<table id="example1" class="table table-bordered table-hover display">
										<thead>
											<tr>
                                                <th width="50">#</th>
												<th>Nama UMKM</th>
												<th width="65">Jan</th>
												<th width="65">Feb</th>
												<th width="65">Mar</th>
												<th width="65">Apr</th>
												<th width="65">Mei</th>
												<th width="65">Jun</th>
												<th width="65">Jul</th>
												<th width="65">Agu</th>
												<th width="65">Sep</th>
												<th width="65">Okt</th>
												<th width="65">Nop</th>
												<th width="65">Des</th>
												<th width="75">Total</th>
											</tr>
										</thead>										
										<tbody>
											<?php $i=1; ?>
                                            @foreach($usaha as $key=>$data)
											<tr>
												<td>{{ $i }}</td>
                                                <td><a href="/admin/omset/grafik/{{ $data->id }}/{{ $tahun }}">{{ $data->nama_usaha }}</a></td>
                                                @foreach($omset[$key] as $bulan=>$o)
                                            		<td align="right" style="font-size: .75rem;">
                                            			<a href="/admin/omset/edit/{{ $data->id }}/{{ ($bulan+1) }}/{{ $tahun }}">{{ number_format($o,0,',',',') }}</a>
                                            		</td>
                                                @endforeach
                                        		<td align="right" style="font-size: .75rem;">{{ number_format($total_omset[$key],0,',',',') }}</td>
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

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	// START CODE FOR BASIC DATA TABLE 
	$(document).ready(function() {
		$('#example1').DataTable();
	} );
	// END CODE FOR BASIC DATA TABLE

	// Redirect omset berdasarkan tahun...
	$(document).on("change", "#tahun", function(){
		var tahun = $(this).val();
		var wilayah = $("#wilayah");
		if(wilayah.length == 1){
    		if(wilayah.val() == 0){
        		window.location.href = "/admin/omset/tahun/"+tahun;
        	}
        	else{
        		window.location.href = "/admin/omset/tahun/"+tahun+"/wilayah/"+wilayah.val();
        	}
		}
		else{
        	window.location.href = "/admin/omset/tahun/"+tahun;
		}
	});
	
	// Redirect omset berdasarkan wilayah...
	$(document).on("change", "#wilayah", function(){
		var wilayah = $(this).val();
		var tahun = $("#tahun").val();
		if(wilayah == 0){
    		window.location.href = "/admin/omset/tahun/"+tahun;
    	}
    	else{
    		window.location.href = "/admin/omset/tahun/"+tahun+"/wilayah/"+wilayah;
    	}
	});
</script>

@endsection

@section('css-extra')

<style type="text/css">
	.table {width: max-content!important;}
	.table td, .table th {padding: .75rem!important;}
</style>

@endsection