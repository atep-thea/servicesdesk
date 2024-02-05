@section('jabatan-link')class="active" @stop

@extends('layout.adminlte.app')



@section('htmlheader_title')

Input Jabatan

@endsection



@section('contentheader_title')

Input Jabatan

@endsection



@section('additional_styles')

<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />

<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />

@endsection



@section('additional_scripts')

<script src="{{asset('public/adminlte/js/select2.full.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>

<script src="{{asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>


@endsection



@section('main-content')

<div class="row">

	<div class="col-md-12">

		<div class="">

			<div class="box-header bg-title-form">

				<h3 class="box-title">Formulir Tambah Golongan</h3>

			</div>

			<div class="box-body border-box">

				@if($errors)

		        @foreach ($errors->all() as $message)

		        <div class="alert alert-danger alert-dismissable">

		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		          <i class="icon fa fa-warning"></i>

		          {{ $message }}

		        </div>

		        @endforeach

		        @endif

		        <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>

		        <form role="form" method="POST" action="{{route('golongan.store')}}" enctype="multipart/form-data">

					{!! csrf_field() !!}

				<div class="row top-22">

					<div class="col-md-12">

					<div class="form-group">

							<label>Golongan <a class="text-red">*</a></label>

							<input type="text" class="form-control" name="golongan" value="{{ old('name') }}">

						</div>

					</div>

				</div>

				<hr class="border-hr">

				<div class="row">

					<div class="col-md-12">

						<button type="submit" class="btn btn-primary">Save</button>&nbsp;

						<a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>

					</div>

				</div>

					

				</form>

			</div>

		</div>

	</div>

</div>

@endsection

