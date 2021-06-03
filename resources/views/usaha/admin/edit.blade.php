@extends('template/template')

@section('title', 'Edit UMKM')

@section('content')

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">
							
				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Edit UMKM</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active">Edit UMKM</li>
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
								<h3><i class="fa fa-check-square-o"></i> Edit UMKM</h3>
							</div>
								
							<div class="card-body">
								
								<form method="post" action="/admin/umkm/update">
								  {{ csrf_field() }}
								  <h5 class="mb-4">Profil UMKM</h5>
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama UMKM</label>
									  <input type="text" name="nama_usaha" class="form-control {{ $errors->has('nama_usaha') ? 'is-invalid' : '' }}" placeholder="Nama UMKM" value="{{ $usaha->nama_usaha }}">
									  @if($errors->has('nama_usaha'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama_usaha')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Tahun Berdiri</label>
									  <input type="number" name="tahun_berdiri" class="form-control {{ $errors->has('tahun_berdiri') ? 'is-invalid' : '' }}" placeholder="Tahun Berdiri" value="{{ $usaha->tahun_berdiri }}">
									  @if($errors->has('tahun_berdiri'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tahun_berdiri')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Alamat UMKM</label>
									  <input type="text" name="alamat_usaha" class="form-control {{ $errors->has('alamat_usaha') ? 'is-invalid' : '' }}" placeholder="Alamat UMKM" value="{{ $usaha->alamat_usaha }}">
									  @if($errors->has('alamat_usaha'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('alamat_usaha')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>No. Telepon</label>
									  <input type="text" name="notelp" class="form-control {{ $errors->has('notelp') ? 'is-invalid' : '' }}" placeholder="No. Telepon" value="{{ $usaha->notelp }}">
									  @if($errors->has('notelp'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('notelp')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Email</label>
									  <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email" value="{{ $usaha->email }}">
									  @if($errors->has('email'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('email')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Website</label>
									  <input type="text" name="website" class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" placeholder="Website" value="{{ $usaha->website }}">
									  @if($errors->has('website'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('website')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Besarnya Kredit Bank</label>
									  <input type="number" name="kredit_bank" class="form-control {{ $errors->has('kredit_bank') ? 'is-invalid' : '' }}" placeholder="Kredit Bank" value="{{ $usaha->kredit_bank }}">
									  @if($errors->has('kredit_bank'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('kredit_bank')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Jumlah Tenaga Kerja</label>
									  <input type="number" name="tenaga_kerja" class="form-control {{ $errors->has('tenaga_kerja') ? 'is-invalid' : '' }}" placeholder="Tenaga Kerja" value="{{ $usaha->tenaga_kerja }}">
									  @if($errors->has('tenaga_kerja'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tenaga_kerja')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Bidang Usaha</label>
									  <select name="bidang_id" class="form-control {{ $errors->has('bidang_id') ? 'is-invalid' : '' }}">
									  	<option value="0">--Pilih Bidang Usaha--</option>
									  	@foreach($bidang as $data)
								  		<option value="{{ $data->id }}" {{ $usaha->bidang_id == $data->id ? 'selected' : '' }}>{{ $data->nama }}</option>
									  	@endforeach
									  </select>
									  @if($errors->has('bidang_id'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('bidang_id')) }}
									  </div>
									  @endif
									</div>
									@if(Auth::user()->role_id == 0)
									<!--<div class="col-md-6 mb-3">-->
									<!--  <label>Wilayah</label>-->
									<!--  <select name="wilayah_id" class="form-control {{ $errors->has('wilayah_id') ? 'is-invalid' : '' }}">-->
									<!--  	<option value="" disabled selected>--Pilih Wilayah--</option>-->
									<!--  	@foreach($wilayah as $data)-->
								 <!-- 		<option value="{{ $data->id }}" {{ $usaha->wilayah_id == $data->id ? 'selected' : '' }}>{{ $data->nama_kota }}</option>-->
									<!--  	@endforeach-->
									<!--  </select>-->
									<!--  @if($errors->has('wilayah_id'))-->
									<!--  <div class="invalid-feedback">-->
									<!--	{{ ucfirst($errors->first('wilayah_id')) }}-->
									<!--  </div>-->
									<!--  @endif-->
									<!--</div>-->
									<input type="hidden" name="wilayah_id" value="{{ $usaha->wilayah_id }}">
									@elseif(Auth::user()->role_id == 1)
									<input type="hidden" name="wilayah_id" value="{{ Auth::user()->wilayah_id }}">
									@endif
									<div class="col-md-6 mb-3">
									  <label>Mentor</label>
									  <select name="mentor_id" class="form-control {{ $errors->has('mentor_id') ? 'is-invalid' : '' }}">
									  	<option value="0">--Pilih Mentor--</option>
									  	@foreach($mentor as $data)
								  		<option value="{{ $data->id }}" {{ $usaha->mentor_id == $data->id ? 'selected' : '' }}>{{ $data->nama }}</option>
									  	@endforeach
									  </select>
									  @if($errors->has('mentor_id'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('mentor_id')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <h5 class="my-4">Profil Pemilik UMKM</h5>
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Nama Pemilik</label>
									  <input type="text" name="nama_pemilik" class="form-control {{ $errors->has('nama_pemilik') ? 'is-invalid' : '' }}" placeholder="Nama Pemilik" value="{{ $pemilik ? $pemilik->nama : '' }}">
									  @if($errors->has('nama_pemilik'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('nama_pemilik')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Alamat</label>
									  <input type="text" name="alamat_pemilik" class="form-control {{ $errors->has('alamat_pemilik') ? 'is-invalid' : '' }}" placeholder="Alamat Pemilik" value="{{ $pemilik ? $pemilik->alamat : '' }}">
									  @if($errors->has('alamat_pemilik'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('alamat_pemilik')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>No. Telepon</label>
									  <input type="text" name="notelp_pemilik" class="form-control {{ $errors->has('notelp_pemilik') ? 'is-invalid' : '' }}" placeholder="No. Telepon Pemilik" value="{{ $pemilik ? $pemilik->notelp : '' }}">
									  @if($errors->has('notelp_pemilik'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('notelp_pemilik')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <h5 class="my-4">Izin Usaha</h5>
								  <div class="row">
									<div class="col-md-6 mb-3">
									  <label>Akte Notaris</label>
									  <input type="text" name="akte_notaris" class="form-control {{ $errors->has('akte_notaris') ? 'is-invalid' : '' }}" placeholder="Akte Notaris" value="{{ $izin ? $izin->akte_notaris : '' }}">
									  @if($errors->has('akte_notaris'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('akte_notaris')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Badan Hukum</label>
									  <input type="text" name="badan_hukum" class="form-control {{ $errors->has('badan_hukum') ? 'is-invalid' : '' }}" placeholder="Badan Hukum" value="{{ $izin ? $izin->badan_hukum : '' }}">
									  @if($errors->has('badan_hukum'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('badan_hukum')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>SIUP</label>
									  <input type="text" name="siup" class="form-control {{ $errors->has('siup') ? 'is-invalid' : '' }}" placeholder="SIUP" value="{{ $izin ? $izin->siup : '' }}">
									  @if($errors->has('siup'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('siup')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>NPWP</label>
									  <input type="text" name="npwp" class="form-control {{ $errors->has('npwp') ? 'is-invalid' : '' }}" placeholder="NPWP" value="{{ $izin ? $izin->npwp : '' }}">
									  @if($errors->has('npwp'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('npwp')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>TDP</label>
									  <input type="text" name="tdp" class="form-control {{ $errors->has('tdp') ? 'is-invalid' : '' }}" placeholder="SIUP" value="{{ $izin ? $izin->tdp : '' }}">
									  @if($errors->has('tdp'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('tdp')) }}
									  </div>
									  @endif
									</div>
									<div class="col-md-6 mb-3">
									  <label>Lain</label>
									  <input type="text" name="lain" class="form-control {{ $errors->has('lain') ? 'is-invalid' : '' }}" placeholder="Lain" value="{{ $izin ? $izin->lain : '' }}">
									  @if($errors->has('lain'))
									  <div class="invalid-feedback">
										{{ ucfirst($errors->first('lain')) }}
									  </div>
									  @endif
									</div>
								  </div>
								  <h5 class="my-4">Pelatihan yang Diikuti</h5>
								  <div class="row">
									<div class="col-md-12 mb-3">
									  <a class="btn btn-warning mb-3" href="#custom-modal" title="Edit" data-target="#customModal" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Pelatihan</a>
									  <div class="table-responsive">
									      <table class="table table-hover table-bordered" id="tabel-pelatihan">
									          <thead>
									          <tr>
									              <th>Pelatihan</th>
									              <th>Lokasi</th>
									              <th width="40">Hapus</th>
									          </tr>
									          </thead>
									          <tbody>
									          @if(count($pelatihan)>0)
									            @foreach($pelatihan as $data)
    									          <tr data-id="{{ $data->id_program_usaha }}">
    									              <td>{{ $data->nama }}</td>
    									              <td>{{ $data->lokasi_pelatihan }}</td>
    									              <td>
                                                	    <a href="#" title="Hapus" data-id="{{ $data->id_program_usaha }}" class="btn btn-danger btn-sm btn-block mb-2 delete"><i class="fa fa-trash"></i></a>
    									              </td>
    									          </tr>
    									        @endforeach
									          @else
									          <tr>
									              <td colspan="3" align="center" id="no-program"><span class="text-danger">Belum ada pelatihan yang diikuti.</span></td>
									          </tr>
									          @endif
									          </tbody>
									      </table>
									  </div>
									</div>
								  </div>
								  <input type="hidden" id="usaha_id" name="usaha_id" value="{{ $usaha->id }}">
								  <input type="hidden" name="pemilik_id" value="{{ $pemilik->id }}">
								  <input type="hidden" name="izin_id" value="{{ $izin->id }}">
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
	
	<!-- Modal -->
	<div class="modal fade custom-modal" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel2">Tambah Pelatihan</h5></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form id="add-program" method="post" action="#">
		  <div class="modal-body">
			  <label>Pelatihan</label>
			  <select name="pelatihan" id="pelatihan" class="form-control" required>
			      <option value="" disabled selected>--Pilih--</option>
			      @foreach($data_pelatihan as $data)
			      <option value="{{ $data->id }}">{{ $data->nama }}</option>
			      @endforeach
		      </select>
		  </div>
		  <div class="modal-footer">
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

<script type="text/javascript">
    // Menambahkan pelatihan usaha...
    $(document).on("submit", "#add-program", function(e){
        e.preventDefault();
        var program = $("#pelatihan").val(); 
        var id = $("#usaha_id").val();
        $.ajax({
            type: "post",
            url: "/admin/umkm/tambah-program",
            data: {_token: "{{ csrf_token() }}", program: program, id: id},
            success: function(response){
                var result = JSON.parse(response);
                if(result.status == 1){
                    alert("Sukses menambahkan data.");
                    var noprogram = $("#no-program").length;
                    var html = '';
                    html += '<tr data-id="' + result.id + '">';
                    html += '<td>' + result.pelatihan + '</td>';
                    html += '<td>' + result.lokasi + '</td>';
                    html += '<td><a href="#" title="Hapus" data-id="' + result.id + '" class="btn btn-danger btn-sm btn-block mb-2 delete"><i class="fa fa-trash"></i></a></td>';
                    html += '</tr>';
                    if(noprogram == 1) $("#no-program").remove();
                    $("#tabel-pelatihan tbody").append(html);
                }
                $("#customModal").modal("toggle");
                $("#pelatihan").val(null);
                console.log(result);
            }
        });
    });
    
    // Menghapus pelatihan usaha...
    $(document).on("click", ".delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var usaha_id = $("#usaha_id").val();
		var ask = confirm("Anda yakin ingin menghapus data ini?");
		if(ask){
            $.ajax({
                type: "post",
                url: "/admin/umkm/delete-program",
                data: {_token: "{{ csrf_token() }}", id: id},
                success: function(response){
                    if(response == "Berhasil menghapus data."){
    					alert(response);
    				    $("#tabel-pelatihan tbody tr[data-id='"+id+"']").remove();
    				}
    				else{
    					alert(response);
    				}
                }
            });
		}
    });
</script>

@endsection