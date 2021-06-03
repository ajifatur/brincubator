@extends('template/template')

@section('title', 'Grafik Omset')

@section('head-extra')

		<!-- BEGIN CSS for this page -->
		<link href="{{ asset('templates/pike-admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
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
										<h1 class="main-title float-left">Grafik Omset</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Grafik Omset</li>
										</ol>
										<div class="clearfix"></div>
								</div>
						</div>
				</div>
				<!-- end row -->

				<div class="row">

                    <div class="col-lg-4">						
						<div class="card mb-3">
							<div class="card-header">
								<i class="fa fa-hand-pointer-o"></i> UMKM
							</div>
								
							<div class="card-body">
								<form id="form-grafik" method="post" action="#">
									<div class="form-group">					
										<label for="umkm">UMKM:</label>
										<select class="form-control select2" id="usaha" name="usaha" required> 
											@foreach($usaha as $data)   
											<option value="{{ $data->id }}" {{ $usaha_id == $data->id ? 'selected' : '' }}>{{ $data->nama_usaha }}</option>
											@endforeach
										</select>	
									</div>
									<div class="form-group">
										<label for="tahun">Tahun: </label>
										<input type="number" name="tahun" value="{{ $tahun }}" class="form-control" id="tahun" required>
									</div>
									<button type="submit" class="btn btn-primary">Lihat Grafik</button>
								</form>
							</div>														
						</div><!-- end card-->					
                    </div>

				
					<div class="col-lg-8">				
						<div class="card mb-3">
							<div class="card-header">
								<i class="fa fa-area-chart"></i> Grafik Omset
							</div>
							<div class="card-body">
								<canvas id="comboBarLineChart"></canvas>
							</div>		
						    <div class="card-footer text-center text-muted">Total Omset Tahun Ini: Rp. {{ number_format(array_sum($data_omset),0,',',',') }}</div>					
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="{{ asset('templates/pike-admin/assets/plugins/select2/js/select2.min.js') }}"></script>

	<script>
	// UMKM...
	$(document).on("submit", "#form-grafik", function(e){
		e.preventDefault();
		 var usaha = $("#usaha").val();
		 var tahun = $("#tahun").val();
		 window.location.href = "/admin/omset/grafik/"+usaha+"/"+tahun;
	});

	// comboBarLineChart
	var ctx2 = document.getElementById("comboBarLineChart").getContext('2d');
	var comboBarLineChart = new Chart(ctx2, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nop", "Des"],
			datasets: [{
					label: 'Omset',
					backgroundColor: '#FF6B8A',
					fill: false,
					data: [<?php echo implode(', ', $data_omset) ?>],
					borderColor: '#FF6B8A',
					borderWidth: 0,
				}], 
				borderWidth: 1
		},
		options: {
		    tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                       return "Rp " + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
            },
			scales: {
				yAxes: [{
					ticks: {
					    callback: function(label, index, labels) {
                            var omset = [<?php echo implode(', ', $data_omset) ?>];
                            var total = omset.reduce(function(tot,num){
                                return tot + num; 
                            });
                            return total == 0 ? label.toFixed(1) : label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        },
						beginAtZero:true
					},
					scaleLabel: {
                        display: true,
                        labelString: 'Nominal Uang (Rp.)'
                    }
				}]
			}
		}
	});	

	$(document).ready(function() {
	    $('.select2').select2();
	});
	</script>	
<!-- END Java Script for this page -->

@endsection

@section('css-extra')

<style type="text/css">
	.select2-container--default .select2-selection--single {height: calc(2.25rem + 2px); line-height: 1.5; font-size: 1rem; padding-top: .3rem;}
	.select2-container--default .select2-selection--single .select2-selection__arrow {height: calc(2.25rem + 2px); }
</style>

@endsection