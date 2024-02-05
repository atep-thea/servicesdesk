@section('pelayanan-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Pelayanan
@endsection

@section('contentheader_title')
Pelayanan
@endsection

@section('additional_styles')
@endsection

@section('additional_scripts')
<script type="text/javascript">    
$(function() {
	$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: '{!! route('pelayanan.data',['status'=>$status]) !!}',
        search: {
		    caseInsensitive: false
		},
		// ajax: {
  //           url: '{!! route('pelayanan.data') !!}',
  //       },
        columns: [
            { data: 'kd_tiket', name: 'kd_tiket', searchable: true},
            { data: 'judul', name: 'judul', searchable: true},
            { data: 'nama_opd', name: 'nama_opd', searchable: true},
            { data: 'tgl_pelaporan', name: 'tgl_pelaporan' },
            { data: 'nama_agen', name: 'nama_agen', searchable: true},
            { data: 'status_tiket', name: 'status_tiket' },
			{ data: 'proses_name', name: 'proses_name'},
        ],
        order:[3,'desc']
    });

	$('[data-remodal-id=modal]').remodal({});
	$('[data-remodal-id=delete]').remodal({});

	$('table').on('click', '.image', function() {
		var imageUrl = $(this).data('image-url');

		$('#featureImage').attr('src', imageUrl); 
	});

	$('table').on('click', '.delete', function() {
		var deleteUrl = $(this).data('delete-url');

		$('#deleteForm').attr('action', deleteUrl);
	});
});
</script>
<script> $(document).ready(function(){ $('#sukses-modal').modal('show'); }); </script>
@endsection

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header bg-title-box">
				<h3 class="box-title">Data Pelayanan</h3>
			</div>
			<div class="box-body border-box">
				@if(Session::has('error'))
		        <div class="alert alert-danger alert-dismissable">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		          <image style="width: 2%;margin-right: 8px;" src="{{asset('public/images/warningg.gif')}}"></image>
		          {{ Session::get('error') }}
		        </div>
		        @endif
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
			    		
				
				<table class="table table-hover table-striped" id="dataTable" style="width: 100%">
					<thead class="bg-head-table">
						<tr>
							<th>No. Tiket</th>
							<th>Judul</th>
							<th>Perangkat Daerah</th>
							<th>Tanggal Laporan</th>
							<th>Agen</th>
							<th>Status</th>
							<th>Proses Detail</th>
							@if(Auth::user()->role_user == 'Admin')
							<th>Action</th>
							@else
							<th></th>
							@endif
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<div data-remodal-id="modal">
  <button data-remodal-action="close" class="remodal-close"></button>
  <p>
    <img id="featureImage" src="" class="img-responsive" alt="Responsive image">
  </p>
  <br>
  <button data-remodal-action="cancel" class="remodal-cancel">Close</button>
</div>

<div class="remodal" data-remodal-id="delete">
	<form id="deleteForm" action="" method="POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<button data-remodal-action="close" class="remodal-close"></button>
	    <h2>Apakah anda yakin?</h2>
	    <p>

	    </p>
	    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	    <button type="submit" class="remodal-confirm">Yes</button>
	</form>
</div>


@endsection
