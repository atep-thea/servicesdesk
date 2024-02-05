@section('slaba-link')class="active" @stop
@extends('layout.adminlte.user_portal')
@section('contentheader_title')
@endsection

@section('additional_scripts')

<script type="text/javascript">
$(function() {

	$('#dataTable').DataTable({
		processing: true,
		serverSide: true,
		ajax: '{!! route('slaba_data.data') !!}',
		columns: [
		    { data: 'kode_tiket', name: 'kode_tiket' },
		    { data: 'judul', name: 'judul' },
		    { data: 'tgl_pelaporan', name: 'tgl_pelaporan' },
		    { data: 'nama_agen', name: 'nama_agen' },
		    // { data: 'file_sla', name: 'file_sla' },
		    // { data: 'file_ba', name: 'file_ba' },
		    { data: 'status_tiket', name: 'status_tiket' },
		]
		,ordering: false
    });

});


</script>
<script> $(document).ready(function(){ $('#sukses-modal').modal('show'); }); </script>
@endsection

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

@section('main-content')

<div class="row">

	<div class="col-md-12">

		<div class="box" style="border:none;box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);">

			<div class="box-body">
				@if(Session::has('success'))
			        <div class="modal fade" id="sukses-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			          <div class="modal-dialog modal-dialog-centered" role="document">
			            <div class="modal-content" style="margin-left: 25%;margin-top: 20%;border-radius: 8px">
			            <button data-remodal-action="close" class="remodal-close"></button>
			              <div class="modal-body" style="text-align: center;padding-top:30px;">
			                <div class="row">
			                		<p style="margin-bottom: 21px;">
			                			<image style="width: 30%" src="{{asset('public/images/check-circle.gif')}}"></image>
			                		</p>
			                		<h2 class="success-alert">
			                			Berhasil!!
			                		</h2>
			                       <div class="session-alert">
			                       		{{ Session::get('success') }}
			                       </div>
			                </div>
			              </div>
			              <div class="modal-footer" style="text-align: center">
			                <button type="button" class="btn btn-primary" data-dismiss="modal" style="padding: 9px;width: 95px;font-size: 1.0625em;">OK</button>
			              </div>
			            </div>
			          </div>
			        </div>
			    @endif

					

				<table class="table table-bordered table-hover table-striped" id="dataTable" style="width: 100%">

					<thead class="">

						<tr>

							<th>No. Tiket</th>

							<th>Judul</th>

							<th>Tgl Laporan</th>

							<th>Agen</th>	

							<th>Status Tiket</th>
							<!-- <th>Pelapor</th> -->

						</tr>

					</thead>

				</table>

			</div>

		</div>

	</div>

</div>

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">

  Launch demo modal

</button> -->



<!-- Modal -->



@include('userportal.close.detail_close')



@endsection

