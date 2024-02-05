@section('onprogress-link')class="active" @stop
@extends('layout.adminlte.user_portal')
@section('contentheader_title')
@endsection
@section('additional_scripts')
<script type="text/javascript">
$(function() {
	$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: '{!! route('request_progress.data',"Close") !!}',
        columns: [
			{ data: 'tgl_pelaporan', name: 'tgl_pelaporan' },
            { data: 'kd_tiket', name: 'kd_tiket' },
            { data: 'judul', name: 'judul' },

            // { data: 'status_tiket', name: 'status_tiket' },
            { data: 'nama_agen', name: 'nama_agen' },
			{ data: 'proses_name',name:'proses_name'}
        ],
		ordering: false
    });
});
</script>
<script src="{{asset('public/js/select_team.js')}}"></script>
<script> $(document).ready(function(){ $('#sukses-modal').modal('show'); }); </script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="box" style="border:none;">
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
				<ul class="nav nav-tabs">
				    <li class="active">
				    	<a data-toggle="tab" href="#progress">On Progress</a>
				    </li>
				    <!-- <li><a data-toggle="tab" href="#selesai">Selesai</a></li> -->
				</ul>

				<div class="tab-content">
				    <div id="progress" class="tab-pane fade in active">
				    	<br>
				     	<table class="table table-bordered table-hover table-striped" id="dataTable" style="width: 100%">
							<thead class="">
								<tr>
									<th>Tanggal Laporan</th>
									<th>No. Tiket</th>
									<th>Judul</th>
									
									{{-- <th>Status</th> --}}
									<th>Agen</th>
									<th>Detail Proses</th>
								</tr>
							</thead>
						</table>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
