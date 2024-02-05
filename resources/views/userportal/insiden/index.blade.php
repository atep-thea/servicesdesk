@section('insiden-user-link')class="active" @stop
@extends('layout.adminlte.user_portal')

@section('contentheader_title')

@endsection

@section('additional_styles')
@endsection

@section('main-content')

@section('additional_scripts')
<script type="text/javascript">
$(function() {
	$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('reportuser.data') !!}',
        columns: [
            { data: 'kd_tiket', name: 'kd_tiket', searchable: true},
            { data: 'judul', name: 'judul', searchable: true},
            { data: 'deskripsi', name: 'deskripsi', searchable: true},
            { data: 'tgl_pelaporan', name: 'tgl_pelaporan' },
            { data: 'jns_insiden', name: 'jns_insiden', searchable: true},
            { data: 'lampiran', name: 'lampiran', searchable: true},
            { data: 'lampiran_balasan', name: 'lampiran_balasan', searchable: true},
            { data: 'status_tiket', name: 'status_tiket' }
            // { data: 'sjns', name: 'sjns' }
        ],
    });

    
	$('[data-remodal-id=delete]').remodal({});

	$('table').on('click', '.delete', function() {
		var deleteUrl = $(this).data('delete-url');

		$('#deleteForm').attr('action', deleteUrl);
	});


	$('[data-remodal-id=detailOrg]').remodal({});
	$('table').on('click', '.detailOrg', function() {
		var deleteUrl = $(this).data('detail-url');

		$('#orgForm').attr('action', deleteUrl);
	});

	$('#detailInsiden').on('show.bs.modal', function (event){ 
		var modal = $(this);
		var button = $(event.relatedTarget);
		var kdTiket = button.data('kdtiket').toString();
		var judul = button.data('judul').toString();
		var sts = button.data('sts').toString();
		var desk = button.data('desk').toString();
		var opd = button.data('opd').toString();
		var tgl_dft = button.data('tgl_dft').toString();
		var tgl_upd = button.data('tgl_upd').toString();
		var tp = button.data('tp').toString();
		var plynn = button.data('plynn').toString();
		var sjns = button.data('sjns').toString();
		var urgen = button.data('urgen').toString();
		var nm_dpn = button.data('nm_dpn').toString();
		var jnsInsiden = button.data('insiden').toString();
		var solusi = button.data('solusi').toString();
		var idTiket = button.data('idtiket').toString();
		var balasan = button.data('balasan').toString();
		// var dwnld = button.data('download').toString();


		// var countprog = button.data('countprog').toString();
		// var countfins = button.data('countfins').toString();

		// Pelayanan
		$("#kode").html(kdTiket);
		$("#kode3").val(kdTiket);
     	$("#jdl").html(judul);
     	$("#jdl3").val(judul);
     	$("#sts").html(sts);
     	$("#desk").html(desk);
     	$("#desk3").html(desk);
     	$("#opd").html(opd);
     	$("#tgl_dft").html(tgl_dft);
     	$("#tgl_upd").html(tgl_upd);
     	$("#tp").html(tp);
     	$("#plynn").html(plynn);
     	$("#sjns").html(sjns);
     	$("#urgen").html(urgen);
     	$("#nm_dpn").html(nm_dpn);
     	$("#jnsInsiden").html(jnsInsiden);
     	$("#solusi").html(solusi);
     	$("#solusi3").html(solusi);
     	// $("#dwnld").html(dwnld);
     	$("#idTiket").val(idTiket);
     	$("#balasan").html(balasan);
		
		/* Yang gue edit*/
     	
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
			        <script> $(document).ready(function(){ $('#sukses-modal').modal('show'); }); </script>
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
				    	<a data-toggle="tab" href="#progress">Insiden</a>
				    </li>
				</ul>
				<div class="tab-content">
				    <div id="progress" class="tab-pane fade in active">
				    	<br>
				     	<table class="table table-bordered table-hover table-striped" id="dataTable" style="width: 100%">
							<thead class="">
								<tr>
									<th>No. Tiket</th>
									<th>Judul Insiden</th>
									<th>Deskripsi</th>
									<th>Tanggal Laporan</th>
									<th>Jenis Insiden</th>
									<th>File Helpdesk</th>
									<th>File Balasan</th>
									<th>Status</th>
								</tr>
							</thead>
						</table>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>


@include('userportal.insiden.detail_insiden')
@endsection
