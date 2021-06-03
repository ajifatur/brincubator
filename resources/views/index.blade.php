@extends('template/template')

@section('title', 'Dashboard')

@section('head-extra')

<style type="text/css">
	.card-box {height: 140px!important;}
</style>

@endsection

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">

				<div class="row">
					<div class="col-xl-12">
							<div class="breadcrumb-holder">
									<h1 class="main-title float-left">Dashboard</h1>
									<ol class="breadcrumb float-right">
										<li class="breadcrumb-item">Home</li>
										<li class="breadcrumb-item active">Dashboard</li>
									</ol>
									<div class="clearfix"></div>
							</div>
					</div>
				</div>
				<!-- end row -->
				
				<div class="row">
				    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-pie-chart"></i> UMKM Go-Modern</h3>
								</div>
									
								<div class="card-body">
									<canvas id="chartGoModern"></canvas>
								</div>
								 <div class="card-footer text-center text-muted">Total UMKM Go-Modern: {{ Auth::user()->role_id == 0 ? number_format(array_sum($umkm_go_modern),0,',',',') : number_format(count($umkm_go_modern),0,',',',') }}</div> 
							</div><!-- end card-->					
						</div>
				    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-pie-chart"></i> UMKM Go-Digital</h3>
								</div>
									
								<div class="card-body">
									<canvas id="chartGoDigital"></canvas>
								</div>
								 <div class="card-footer text-center text-muted">Total UMKM Go-Digital: {{ Auth::user()->role_id == 0 ? number_format(array_sum($umkm_go_digital),0,',',',') : number_format(count($umkm_go_digital),0,',',',') }}</div> 
							</div><!-- end card-->					
						</div>
				    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-pie-chart"></i> UMKM Go-Online</h3>
								</div>
									
								<div class="card-body">
									<canvas id="chartGoOnline"></canvas>
								</div>
								 <div class="card-footer text-center text-muted">Total UMKM Go-Online: {{ Auth::user()->role_id == 0 ? number_format(array_sum($umkm_go_online),0,',',',') : number_format(count($umkm_go_online),0,',',',') }}</div> 
							</div><!-- end card-->					
						</div>
				    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-pie-chart"></i> UMKM Go-Global</h3>
								</div>
									
								<div class="card-body">
									<canvas id="chartGoGlobal"></canvas>
								</div>
								 <div class="card-footer text-center text-muted">Total UMKM Go-Global: {{ Auth::user()->role_id == 0 ? number_format(array_sum($umkm_go_global),0,',',',') : number_format(count($umkm_go_global),0,',',',') }}</div> 
							</div><!-- end card-->					
						</div>
				</div>
				<!-- end row -->

				<div class="row">
				
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9">						
							<div class="card mb-3">
								<div class="card-header">
									<div class="row">
										<div class="col-sm">
								            <h3><i class="fa fa-line-chart"></i> Grafik Omset Per Tahun</h3>
										</div>
										<div class="col-sm-auto mt-sm-0 mt-2">
											<select class="form-control form-control-sm" id="update-chart">
												@for($year=date('Y'); $year>=2015; $year--)
												<option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
												@endfor
											</select>
										</div>
									</div>
								</div>
									
								<div class="card-body">
									<canvas id="comboBarLineChart"></canvas>
								</div>							
								 <div class="card-footer text-center text-muted">Total Omset Keseluruhan: Rp. {{ number_format($overall_omset,0,',',',') }}</div>
							</div><!-- end card-->					
						</div>

						@if(Auth::user()->role_id == 0)
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">						
							<div class="card mb-3">
								<div class="card-header">
									<h3><i class="fa fa-pie-chart"></i> UMKM Terdaftar</h3>
								</div>
									
								<div class="card-body">
									<canvas id="pieChart"></canvas>
								</div>
								 <div class="card-footer text-center text-muted">Total UMKM Terdaftar: {{ number_format(count($usaha),0,',',',') }}</div> 
							</div><!-- end card-->					
						</div>
						@endif
						
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
	<!-- Counter-Up-->
	<script src="{{ asset('templates/pike-admin/assets/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('templates/pike-admin/assets/plugins/counterup/jquery.counterup.min.js') }}"></script>	

	<script>
		$(document).ready(function() {
			// counter-up
			$('.counter').counterUp({
				delay: 10,
				time: 600
			});
		} );	

		// comboBarLineChart
		var ctx1 = document.getElementById("comboBarLineChart").getContext('2d');
		var comboBarLineChart = new Chart(ctx1, {
			type: 'line',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nop", "Des"],
				datasets: [{
						label: 'Omset',
						backgroundColor: '#FF6B8A',
				    	fill: false,
						data: [<?php echo implode(', ', $omset_tahun_ini) ?>],
						borderColor: '#FF6B8A',
						borderWidth: 0
					}], 
					borderWidth: 1
			},
			options: {
			    tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return "Rp " + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        },
                    },
                },
				scales: {
					yAxes: [{
						ticks: {
						    callback: function(label, index, labels) {
                                var omset = [<?php echo implode(', ', $omset_tahun_ini) ?>];
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
		
    	// update chart omset tahun ini...
	    $(document).on("change", "#update-chart", function(e){
	        e.preventDefault();
	        var tahun = $(this).val();
	        $.ajax({
	            type: "post",
	            url: "/admin/omset-per-tahun",
	            data: {_token: "{{ csrf_token() }}", tahun: tahun},
	            success: function(response){
	                var result = JSON.parse(response);
        	        comboBarLineChart.data.datasets[0].data = result.omset;
        	        comboBarLineChart.options.scales.yAxes[0].ticks.callback =  function(label, index, labels) {
                                                                                    var total = result.total;
                                                                                    return total == 0 ? label.toFixed(1) : label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                                                };
	                comboBarLineChart.update();
	            }
	        });
	    });
	</script>

	@if(Auth::user()->role_id == 0)
	<script>
	    // pie chart total UMKM terdaftar...
		var ctx2 = document.getElementById("pieChart").getContext('2d');
		var pieChart = new Chart(ctx2, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo implode(',', $jumlah_umkm) ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: [<?php echo implode(',', $nama_wilayah) ?>]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Modern...
		var ctx3 = document.getElementById("chartGoModern").getContext('2d');
		var chartGoModern = new Chart(ctx3, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo implode(',', $umkm_go_modern) ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: [<?php echo implode(',', $nama_wilayah) ?>]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Digital...
		var ctx4 = document.getElementById("chartGoDigital").getContext('2d');
		var chartGoModern = new Chart(ctx4, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo implode(',', $umkm_go_digital) ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: [<?php echo implode(',', $nama_wilayah) ?>]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Online...
		var ctx5 = document.getElementById("chartGoOnline").getContext('2d');
		var chartGoModern = new Chart(ctx5, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo implode(',', $umkm_go_online) ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: [<?php echo implode(',', $nama_wilayah) ?>]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Global...
		var ctx6 = document.getElementById("chartGoGlobal").getContext('2d');
		var chartGoModern = new Chart(ctx6, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo implode(',', $umkm_go_global) ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: [<?php echo implode(',', $nama_wilayah) ?>]
				},
				options: {
					responsive: true
				}
		});
	</script>
	@elseif(Auth::user()->role_id == 1)
	<script>
		// pie chart UMKM Go-Modern...
		var ctx3 = document.getElementById("chartGoModern").getContext('2d');
		var chartGoModern = new Chart(ctx3, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo count($umkm_go_modern).", ".$umkm_tidak_go_modern ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: ["Modern", "Belum Modern"]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Digital...
		var ctx4 = document.getElementById("chartGoDigital").getContext('2d');
		var chartGoModern = new Chart(ctx4, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo count($umkm_go_digital).", ".$umkm_tidak_go_digital ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: ["Digital", "Belum Digital"]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Online...
		var ctx5 = document.getElementById("chartGoOnline").getContext('2d');
		var chartGoModern = new Chart(ctx5, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo count($umkm_go_online).", ".$umkm_tidak_go_online ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: ["Online", "Belum Online"]
				},
				options: {
					responsive: true
				}
		});
		
		// pie chart UMKM Go-Global...
		var ctx6 = document.getElementById("chartGoGlobal").getContext('2d');
		var chartGoModern = new Chart(ctx6, {
			type: 'pie',
			data: {
					datasets: [{
						data: [<?php echo count($umkm_go_global).", ".$umkm_tidak_go_global ?>],
						backgroundColor: [
							<?php
								foreach($random_warna as $warna):
									echo "'".$warna."',";
								endforeach;
							?>
						],
						label: 'Dataset 1'
					}],
					labels: ["Global", "Belum Global"]
				},
				options: {
					responsive: true
				}
		});
	</script>	
	@endif
<!-- END Java Script for this page -->

@endsection