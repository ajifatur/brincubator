@extends('template/template')

@section('title', 'Foto Produk')

@section('head-extra')

		<!-- BEGIN CSS for this page -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
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
										<h1 class="main-title float-left">Foto Produk</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Foto Produk</li>
										</ol>
										<div class="clearfix"></div>
								</div>
						</div>
				</div>
				<!-- end row -->

				<div class="row">

                    <div class="col-lg-12">						
						<div class="card mb-3">
							<div class="card-header">
							    <div class="row">
    							    <div class="col">
    								    <h3><i class="fa fa-file-photo-o"></i> Foto Produk: {{ $usaha->nama_usaha }}</h3>
    							    </div>
    								<div class="col-auto">
    									<a href="#custom-modal" data-target="#customModal" data-toggle="modal" class="btn btn-sm btn-primary"><i class="fa fa-upload mr-2"></i> Upload Foto</a>
    								</div>
								</div>
							</div>
								
							<div class="card-body">
							   <div class="row">
					              <div class="col">
						          @if(count($usaha_photo)>0)
						            <div class="card-columns">
						                @foreach($usaha_photo as $key=>$data)
						                <div class="card border-secondary mb-2 p-0 rounded-0">
                                          <img class="card-img-top rounded-0" src="{{ asset('assets/images/foto-produk/'.$data->photo) }}" class="img-fluid">
                                          <div class="card-body p-2">
                                            @if($data->deskripsi != '')
                                            <p>{{ $data->deskripsi }}</p>
                                            @endif
                                            <a data-fancybox="gallery" href="{{ asset('assets/images/foto-produk/'.$data->photo) }}" class="btn btn-info btn-sm float-left mb-2 delete" title="Lihat Gambar"><i class="fa fa-file-photo-o"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm float-right mb-2 delete" data-id="{{ $data->id }}" title="Hapus Gambar"><i class="fa fa-trash"></i></a>
                                          </div>
                                        </div>
						                @endforeach
						            </div>
						          @else
						            <p>Belum ada foto produk.</p>
						          @endif
						          </div>
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
			<h5 class="modal-title" id="exampleModalLabel2">Upload Foto Produk</h5></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form id="upload-foto" method="post" action="/admin/umkm/upload-foto" enctype="multipart/form-data">
    		  {{ csrf_field() }}
    		  <div class="modal-body">
    		      <div class="form-group">
        			  <label>Foto Produk</label>
        			  <br>
                      <input type="file" id="file" accept="image/*">
                      <div class="image-field mt-2"></div>
                  </div>
    		      <div class="form-group">
        			  <label>Deskripsi</label>
        			  <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan Deskripsi Produk"></textarea>
        	      </div>
    		  </div>
    		  <div class="modal-footer">
    		    <input type="hidden" name="usaha" value="{{ $usaha->id }}">
    			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    			<button type="submit" class="btn btn-primary" id="btn-upload" disabled style="cursor:not-allowed;">Simpan</button>
    		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<!-- END Modal -->

@endsection

@section('js-extra')

<!-- BEGIN Java Script for this page -->
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

	<script type="text/javascript">
	    // Upload gambar...
    	function readURL(input) {
    		if(input.files && input.files[0]){
    			var reader = new FileReader();
    			reader.onload = function(e){
    			    var html = '';
    				html += '<img src="'+e.target.result+'" alt="title" class="img-fluid">';
    				html += '<input type="hidden" name="file" value="'+e.target.result+'">';
    				$(".image-field").html(html);
    			}
    			reader.readAsDataURL(input.files[0]);
    		}
    	}
    	$(document).on("change", "#file", function() {
    	 	readURL(this);
    	 	$(this).val(null);
    	 	$("#btn-upload").removeAttr("disabled").removeAttr("style");
    	});

    	// Menghapus data...
    	$(document).on("click", ".delete", function(e){
    		e.preventDefault();
    		var id = $(this).data("id");
    		var ask = confirm("Anda yakin ingin menghapus foto ini?");
    		if(ask){
    			$.ajax({
    				type: "post",
    				url: "/admin/umkm/delete-foto",
    				data: {_token: "{{ csrf_token() }}", id: id},
    				success: function(response){
    					if(response == "Berhasil menghapus foto."){
    						alert(response);
    						window.location.href = '/admin/umkm/foto/{{ $usaha->id }}';
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
    @media (min-width: 768px){ .card-columns {-webkit-column-count:4; -moz-column-count:4; column-count:4;} }
</style>

@endsection