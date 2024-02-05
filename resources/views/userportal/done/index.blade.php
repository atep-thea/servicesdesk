@section('userhome-link')class="active" @stop

@extends('layout.adminlte.user_portal')



@section('contentheader_title')

@endsection



@section('additional_scripts')

<script type="text/javascript">

$(function() {

	$('#dataTable').DataTable({

        processing: true,

        serverSide: true,

        stateSave: true,

        ajax: '{!! route('request_done.data') !!}',

        columns: [

            { data: 'kode_tiket', name: 'kode_tiket' },

            { data: 'judul', name: 'judul' },

            { data: 'tgl_pelaporan', name: 'tgl_pelaporan' },

            { data: 'status_tiket', name: 'status_tiket' },

            { data: 'nama_agen', name: 'nama_agen' },

            { data: 'sjns_def', name: 'sjns_def' },

            { data: 'priority', name: 'priority' },

            // { data: 'sjns', name: 'sjns' }

        ]

    });





	$('#reqDetail').on('show.bs.modal', function (event){ 

		

		var modal = $(this);

		var button = $(event.relatedTarget);

		var idtiket = button.data('idtiket').toString();

		var kdTiket = button.data('kdtiket2').toString();

		var judul = button.data('judul2').toString();

		var sts = button.data('sts2').toString();

		var desk = button.data('desk2').toString();

		var opd = button.data('opd2').toString();

		var tgl_dft = button.data('tgl_dft2').toString();

		var tgl_upd = button.data('tgl_upd2').toString();

		var tp = button.data('tp2').toString();

		var plynn = button.data('plynn2').toString();

		var sjns = button.data('sjns2').toString();

		var urgen = button.data('urgen2').toString();

		var nm_dpn = button.data('nm_dpn2').toString();

		var nm_blkg = button.data('nm_blkg2').toString();

		var solusi = button.data('solusi2').toString();



		alert(idtiket);

		// Pelayanan

		$("#idtiket").val(idtiket);

		$("#kode2").html(kdTiket);

     	$("#jdl2").html(judul);

     	$("#sts2").html(sts);

     	$("#desk2").html(desk);

     	$("#opd2").html(opd);

     	$("#tgl_dft2").html(tgl_dft);

     	$("#tgl_upd2").html(tgl_upd);

     	$("#tp2").html(tp);

     	$("#plynn2").html(plynn);

     	$("#sjns2").html(sjns);

     	$("#urgen2").html(urgen);

     	$("#nm_dpn2").html(nm_dpn);

     	$("#nm_blkg2").html(nm_blkg);

     	$("#solusi2").html(solusi);

	});



	$('#orgDetail').on('show.bs.modal', function (event){ 

		var modal = $(this);

		var button = $(event.relatedTarget);

		// organisasi

		var nm_org = button.data('nm_org').toString();

		var induk_org = button.data('induk_org').toString();

		var nm_peng = button.data('nm_peng').toString();

		var hp_peng = button.data('hp_peng').toString();

		var email_org = button.data('email_org').toString();



		// Organisasi

     	$("#nm_org").html(nm_org);

     	if(induk_org == ""){

     		$("#induk_org").html('-');

     	}else{

     		$("#induk_org").html(induk_org);

     	}

     	

     	$("#nm_peng").html(nm_peng);

     	$("#hp_peng").html(hp_peng);

     	$("#email_org").html(email_org);

	});	

});





  /**

   * for showing edit item popup

   */



  

</script>



@endsection

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

@section('main-content')

<div class="row">

	<div class="col-md-12">

		<div class="box" style="border:none;box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);">

			<div class="box-body">

				@if(Session::has('success'))

				<div class="alert alert-success alert-dismissable">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

					<i class="icon fa fa-check"></i>

					{{ Session::get('success') }}

				</div>

				@endif

					

				<table class="table table-bordered table-hover table-striped" id="dataTable" style="width: 100%">

					<thead class="">

						<tr>

							<th>No. Tiket</th>

							<th>Judul</th>

							<th>Tanggal Laporan</th>

							<th>Status</th>

							<th>Agen</th>

							<th>Kategori</th>

							<th>Proritas</th>

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



@include('userportal.done.detail_done')

@include('userportal.done.detail_org')



@endsection

