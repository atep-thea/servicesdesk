@section('pelayanan-link')class="active" @stop

@extends('layout.adminlte.app')



@section('htmlheader_title')

    Input pelayanan

@endsection



@section('contentheader_title')

    Input pelayanan

@endsection



@section('additional_styles')

    <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <link href="{{ asset('public/adminlte/css/select22.min.css') }}" rel="stylesheet" />

@endsection



@section('additional_scripts')

    <script src="{{ asset('public/adminlte/js/select2.full.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

    <script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

@endsection



@section('main-content')

    <div class="row">

        <div class="col-md-12">

            <div class="">

                <div class="box-header bg-title-form">

                    <h3 class="box-title">Formulir Tambah Pelayanan</h3>

                </div>

                <div class="box-body border-box">

                    @if ($errors)

                        @foreach ($errors->all() as $message)

                            <div class="alert alert-danger alert-dismissable">

                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>

                                <i class="icon fa fa-warning"></i>

                                {{ $message }}

                            </div>

                        @endforeach

                    @endif

                    <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>

                    <form role="form" method="POST" action="{{ route('jns_pelayanan.store') }}"
                        enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="row top-22">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>pelayanan <a class="text-red">*</a></label>

                                    <input type="text" class="form-control" name="pelayanan"
                                        value="{{ $jns_pelayanan->pelayanan }}" disabled>

                                </div>
                                <div class="form-group">
                                    <label>Eselon 3 Penanggung Jawab <a class="text-red">*</a></label>
                                    <select class="form-control" name="png_jawab" disabled>
                                        <option value="">{{ $jns_pelayanan->penanggungJawabEselon3->id }} -
                                            {{ $jns_pelayanan->penanggungJawabEselon3->nama_depan }}
                                            {{ $jns_pelayanan->penanggungJawabEselon3->nama_belakang }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Koordinator Agent <a class="text-red">*</a></label>
                                    <select class="form-control" name="koordinator_agent" disabled>
                                        <option value="">{{ $jns_pelayanan->koordinatorAgen->id }} -
                                            {{ $jns_pelayanan->koordinatorAgen->nama_depan }}
                                            {{ $jns_pelayanan->koordinatorAgen->nama_belakang }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Persyaratan (Formating bisa menggunakan Markdown
                                        https://www.markdownguide.org/cheat-sheet/</label>
                                    <textarea class="form-control" rows="3" name="syarat"
                                        readonly>{{ $jns_pelayanan->persyaratan }}</textarea>
                                </div>


                            </div>
                            <div class="col-md-12">
                                <h2>Flow Layanan</h2>
                                <div class="flow_pelayanan">
                                    @foreach ($jns_pelayanan->flowPelayanan as $flow)
                                        <div
                                            class="@if ($flow->team == null)
											col-sm-12
											@else
											col-sm-6
											
										@endif form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">{{ $loop->index + 1 }}</span>
                                                <input type="text" class="form-control" name="flow_layanan[]"
                                                    value="{{ $flow->name }}" disabled>
                                            </div>
                                        </div>
                                        @if ($flow->team != null)

                                            <div class="col-sm-6 form-group">
                                                <select class="form-control" name="team[]" disabled>
                                                    <option value="">{{ $flow->team->name_team }}</option>
                                                </select>
                                            </div>
                                        @endif

                                        
                                        @if (!$flow->checklist->isEmpty())
                                        <div class="col-md-12"><label>Checklist </label></div>
                                            @foreach ($flow->checklist as $checklist)
                                                <div class="col-md-12 checklist_pelayanan_4" id="4">
                                                    <div class="col-sm-12 form-group">
                                                        <input type="text" class="form-control" name="checklist_4[]"
                                                            value="{{ $checklist->checklist_name }}" disabled>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endif
                                    @endforeach
                                </div>

                            </div>



                        </div>

                        <hr class="border-hr">

                        <div class="row">

                            <div class="col-md-12">

                                <a href="{{ url()->previous() }}" class="btn btn-danger">Kembali ke halaman
                                    sebelumnya</a>

                            </div>

                        </div>



                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
