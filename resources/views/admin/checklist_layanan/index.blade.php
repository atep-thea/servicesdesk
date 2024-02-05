@section('switch-link')class="active" @stop

@extends('layout.adminlte.app')



@section('htmlheader_title')

Checklist Layanan

@endsection



@section('contentheader_title')

Checklist Layanan

@endsection



@section('additional_styles')

@endsection



@section('additional_scripts')

<script type="text/javascript">

$(function() {

	$('#dataTable').DataTable({

        processing: true,

        serverSide: true,

        stateSave: true,

        ajax: '{!! route('checklist-layanan.data') !!}',

        columns: [

        	{ data: 'checklist_name', name: 'nama_opd' },

            { data: 'id_jns_pelayanan', name: 'jenis_pelayanan' },


        ]

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

@endsection



@section('main-content')

<div class="row">

	<div class="col-md-12">

		<div class="box box-primary">

			<div class="box-header bg-title-box">

				<h3 class="box-title">Checklist Pelayanan</h3>

				<div class="box-tools pull-right">

					<a href="{{ route('checklist.create') }}" role="button" class="add-button btn btn-xs btn-success"><i class="fas fa-plus-circle"> Tambah</i></a>

				</div>

			</div>

			<div class="box-body border-box">

				@if(Session::has('success'))

				<div class="alert alert-success alert-dismissable">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

					<i class="icon fa fa-check"></i>

					{{ Session::get('success') }}

				</div>

				@endif

				<form class="form-horizontal" action="#"  method="post" enctype="multipart/form-data">

		                @csrf

		            <div class="row">

		            	<div class="col-md-3" style="padding-top:15px;"><input type="file" name="import_file" /></div>

						<div class="col-md-2" style="padding-top:12px"><button class="btn btn-success">Upload</button></div>

		            	<div class="col-md-7" style="text-align:right"><a href="{{URL::to('export-org')}}"> <img src="{{asset('public/images/icon_excel.png')}}" width="70px" height="70px"></a></div>

		            </div>

					</form>

				<table class="table table-hover table-striped" id="dataTable" style="width: 100%">

					<thead class="bg-head-table">

						<tr>

							<th >Nama Checklist</th>

							<th >Nama Jenis Pelayanan</th>

						    <th >Action</th>

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

	    <br>

	    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>

	    <button type="submit" class="remodal-confirm">Yes</button>

	</form>

</div>











@endsection

