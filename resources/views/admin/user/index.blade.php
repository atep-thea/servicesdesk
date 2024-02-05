@section('user-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
User
@endsection

@section('contentheader_title')
User
@endsection

@section('additional_styles')
		<!-- DATA TABLES -->
<link href="{{asset('public/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('additional_scripts')
<script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
{{--<script src="https://code.jquery.com/jquery-1.12.3.js" type="text/javascript"></script>--}}
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js" type="text/javascript"></script>
{{--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript"></script>--}}

<script type="text/javascript">
$(function() {
	$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: '{!! route('user.data') !!}',
        search: {
		    "caseInsensitive": false
		},
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama_depan', name: 'nama_depan' },
            { data: 'nama_belakang', name: 'nama_belakang' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'opd', name: 'opd' },
            { data: 'status_user', name: 'status_user' },
			{ data: 'action', name: 'action'},
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
@if(Session::has('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-check"></i>
            {{ Session::get('success') }}
        </div>
    </div>
</div>
@endif
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header bg-title-box">
				<h3 class="box-title">Daftar Pengguna</h3>
				<div class="box-tools pull-right">
					<a href="{{ route('user.create') }}" role="button" class="add-button btn btn-xs btn-success"><i class="fa fa-plus-circle"> Tambah</i></a>
				</div>
			</div>
			<div class="box-body border-box">
				<table class="table table-bordered table-hover table-striped" id="dataTable">
					<thead>
					<tr>
						<th>Id</th>
						<th>Nama Depan</th>
						<th>Nama Belakang</th>
						<th>Jabatan</th>
						<th>Organisasi</th>
						<th>Status</th>
						<th></th>
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
