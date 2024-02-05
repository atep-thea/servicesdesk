@section('pelayanan-link')class="active" @stop

@extends('layout.adminlte.app')



@section('htmlheader_title')

    Input Layanan

@endsection



@section('contentheader_title')

    Input Layanan

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

    <script type="text/javascript">
        $(document).ready(function() {

            var wrapper = $(".flow_pelayanan");
            var add_button = $(".add_flow_pelayanan_field");

            var x = 4;
            $(add_button).click(function(e) {
                e.preventDefault();
                $(wrapper).append(
                    `<div>
                        <div class="col-sm-3 form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">`+x+`</span>
                                            <input type="text" class="form-control" name="flow_layanan[]"  placeholder="Masukan Nama Flow" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <select class="form-control js-example-basic-single" name="team[]" required>
                                            <option value="">- Pilih Penanggung Jawab -</option>
                                            @foreach ($team as $team_bidang)
                                                <option value='{{ $team_bidang->id_team }}'>{{ $team_bidang->name_team }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <button type="button" class="btn btn-block btn-danger hapus_flow_pelayanan_field">Hapus Flow</button>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                       
                                    </div>
                                    <div class="col-md-12"><label>Checklist </label></div>
                                    <div class="col-md-12 checklist_pelayanan_`+x+`" id="`+x+`">
                                        <div class="col-sm-6 form-group">
                                            <input type="text" class="form-control" name="checklist_`+x+`[]" placeholder="Masukan Nama Checklist">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <button type="button" class="btn btn-block btn-primary add_checklist_field">Tambahkan
                                                Checklist</button>
                                        </div>
                                    </div>
                    </div>`); //add input box
                    x=x+1;
                    $('.js-example-basic-single').select2();

            });

            $(wrapper).on("click", ".hapus_flow_pelayanan_field", function(e) {
                e.preventDefault();
                $(this).parent('div').parent('div').remove();
                x=x-1;
            })


			var wrapper2 = $(".checklist_pelayanan");
            var add_button2 = $(".add_checklist_field");

            $('body').on('click','.add_checklist_field',function(e) {
                e.preventDefault();
                var checklist_id = $(this).parent().parent().attr('id');
                $('.checklist_pelayanan_'+checklist_id).append(
                    `<div>	<div class="col-sm-6 form-group">
						<input type="text" class="form-control" name="checklist_`+checklist_id+`[]" placeholder="Masukan Nama Checklist">
					</div>
					<div class="col-sm-6 form-group">
						<button type="button" class="delete_checklist_field btn btn-block btn-danger" id="`+checklist_id+`">Hapus Checklist</button>
					</div></div>`); //add input box
            });

            $('body').on("click", ".delete_checklist_field", function(e) {
                e.preventDefault();
                $(this).parent('div').parent('div').remove();
            })
        });
    </script>

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

                                    <label>Layanan <a class="text-red">*</a></label>

                                    <input type="text" class="form-control" name="pelayanan"
                                        value="{{ old('pelayanan') }}">

                                </div>
                                <div class="form-group">
                                    <label>Pilih Eselon 3 Penanggung Jawab <a class="text-red">*</a></label>
                                    <select class="form-control js-example-basic-single" name="png_jawab" required>
                                        <option value="">Pilih User Dengan Golongan Eselon 3</option>
                                        @foreach ($user_eselon_3 as $user)
                                            <option value='{{ $user->id }}'>{{$user->id}} - {{$user->nama_depan}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Koordinator Agent <a class="text-red">*</a></label>
                                    <select class="form-control js-example-basic-single" name="koordinator_agent" required>
                                        <option value="">Pilih Penanggung Jawab</option>
                                        @foreach ($user_koordinator as $user)
                                            <option value='{{ $user->id }}'>{{$user->id}} - {{$user->nama_depan}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input name="notif_eselon3" type="checkbox" value="1" checked>Notifikasi Eselon 3
                                      </label>
                                      <label class="checkbox-inline">
                                        <input name="notif_koordinator_agen" type="checkbox" value="1" checked>Notifikasi Koordinator Agen
                                      </label>
                                      <label class="checkbox-inline">
                                        <input name="notif_team_leader" type="checkbox" value="1" checked>Notifikasi Team Leader
                                      </label>
                                      <label class="checkbox-inline">
                                        <input name="notif_team_leader" type="checkbox" value="1" checked>Notifikasi User
                                      </label>
                                </div>

                                <div class="form-group">
                                    <label>Persyaratan (Formating bisa menggunakan Markdown https://www.markdownguide.org/basic-syntax/)</label>
                                    <textarea class="form-control" rows="20" placeholder="Enter ..." name="syarat"></textarea>
                                </div>
                                
                            </div>
                            <div class="col-md-12"><h2>Flow Layanan</h2>
                                <div id="default_layanan">
                                <label>Default Flow Layanan</label>
                                    <div class="flow_pelayanan_default">
                                        <div class="col-sm-12 form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">1</span>
                                                   <input type="text" class="form-control" name="flow_layanan[]" value="Permintaan Masuk" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flow_pelayanan_default">
                                        <div class="col-sm-12 form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">2</span>
                                                <input type="text" class="form-control" name="flow_layanan[]" value="Validasi Permintaan Layanan" readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6 form-group">
                                            <select class="form-control" name="verifikator_pd_id" required>
                                                <option value="">- Pilih Penanggung Jawab -</option>
                                                @foreach ($user_verifikator_pd as $verifikator_pd)
                                                    <option value='{{ $verifikator_pd->id }}'>{{ $verifikator_pd->name }} 
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="flow_pelayanan_default">
                                        <div class="col-sm-12 form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">3</span>
                                                <input type="text" class="form-control" name="flow_layanan[]" value="Validasi Helpdesk" readonly>
                                            </div>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="flow_pelayanan_default">
                                        <div class="col-sm-12 form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">3</span>
                                                <input type="text" class="form-control" name="flow_layanan[]" value="Verifikasi Permintaan Layanan" readonly>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <h3>Custom Flow  Pelayanan</h3>
                                <div class="flow_pelayanan">
                                    <div class="col-sm-3 form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">3</span>
                                            <input type="text" class="form-control" name="flow_layanan[]"  placeholder="Masukan Nama Flow" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <select class="form-control js-example-basic-single" name="team[]" required>
                                            <option value="">- Pilih Penanggung Jawab -</option>
                                            @foreach ($team as $team_bidang)
                                                <option value='{{ $team_bidang->id_team }}'>{{ $team_bidang->name_team }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <button type="button" class="btn btn-block btn-primary add_flow_pelayanan_field">Tambahkan Flow</button>
                                    </div>
                                    <div class="col-md-12"><label>Checklist </label></div>
                                    <div class="col-md-12 checklist_pelayanan_3" id="3">
                                        <div class="col-sm-6 form-group">
                                            <input type="text" class="form-control" name="checklist_3[]" placeholder="Masukan Nama Checklist">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <button type="button" class="btn btn-block btn-primary add_checklist_field">Tambahkan
                                                Checklist</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
					

                        </div>

                        <hr class="border-hr">

                        <div class="row">

                            <div class="col-md-12">

                                <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;

                                <a href="{{ url()->previous() }}" class="btn btn-danger">Kembali</a>

                            </div>

                        </div>



                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
