@section('pelayanan-link')class="active" @stop

@extends('layout.adminlte.app')



@section('htmlheader_title')

    Edit Team

@endsection



@section('contentheader_title')

    Edit Team

@endsection



@section('additional_styles')

    <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <link href="{{ asset('public/adminlte/css/select22.min.css') }}" rel="stylesheet" />

@endsection



@section('additional_scripts')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('.js-example-basic-single').select2();

	   
	});
	
	function teamCheck(that) {
	    if (that.value == "3") {
	        document.getElementById("selectTeam").style.display = "block";
	    } else {
	        document.getElementById("selectTeam").style.display = "none";
	    }
	}
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

    

    <script type="text/javascript">
        $(document).ready(function() {

            var wrapper = $(".flow_pelayanan");
            var add_button = $(".add_flow_pelayanan_field");

            $(add_button).click(function(e) {
                e.preventDefault();
                $(wrapper).append(
                    `<div>
                                    <div class="col-md-6 form-group">
                                        <div class="input-group">
                                            <select class="form-control js-example-basic-single" name="team_member[]" required>
                                                <option value="">- Pilih Member Team -</option>
                                                @foreach ($allUser as $user)
                                                    <option value='{{ $user->id }}'>{{$user->id}} - {{$user->nama_depan}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button type="button" class="btn btn-block btn-danger hapus_flow_pelayanan_field">Hapus Member</button>
                                    </div>
                                    
                    </div>`); //add input box
                    
                    $('.js-example-basic-single').select2();
            });

            $(wrapper).on("click", ".hapus_flow_pelayanan_field", function(e) {
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

                    <h3 class="box-title">Formulir Edit Team</h3>

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

                    <form role="form" method="POST" action="{{ route('team.update') }}"
                        enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <input type="hidden" name="team_id" value="{{ $team->id_team }}"/>

                        <div class="row top-22">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <label>Nama Team<a class="text-red">*</a></label>

                                    <input type="text" class="form-control" name="team"
                                        value="{{ $team->name_team }}">

                                </div>
                                <div class="form-group">
                                    <label>Pilih Team Leader  <a class="text-red">*</a></label>
                                    <select class="form-control js-example-basic-single" name="team_leader" required>
                                        <option value="{{ $team_leader->userId }}">{{ $team_leader->userId }} - {{ $team_leader->nama_depan }} {{ $team_leader->nama_belakang }}</option>
                                        @foreach ($allUser as $user)
                                            <option value='{{ $user->id }}'>{{$user->id}} - {{$user->nama_depan}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                            <div class="col-md-12"><h2>Team Member</h2>
                                <div id="default_layanan">
                                <div class="flow_pelayanan">
                                   

                                    @foreach ($team->member as $member)
                                       @if($member->pivot->leader==0)
                                        @if($loop->index == 0)

                                        <div class="col-md-6 form-group">
                                            <div class="input-group">
                                                <select class="form-control js-example-basic-single" name="team_member[]" required>
                                                    <option value="{{ $member->id }}">{{ $member->id }} - {{ $member->nama_depan }} - </option>
                                                    @foreach ($allUser as $user)
                                                        <option value='{{ $user->id }}'>{{$user->id}} - {{$user->nama_depan}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 form-group">
                                            <button type="button" class="btn btn-block btn-primary add_flow_pelayanan_field">Tambahkan Member</button>
                                        </div>
                                            @else
                                            <div>
                                                <div class="col-md-6 form-group">
                                                    <div class="input-group">
                                                        <select class="form-control js-example-basic-single" name="team_member[]" required>
                                                            <option value="{{ $member->id }}">{{ $member->id }} - {{ $member->nama_depan }} - </option>
                                                            @foreach ($allUser as $user)
                                                                <option value='{{ $user->id }}'>{{$user->id}} - {{$user->nama_depan}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="col-md-3 form-group">
                                                    <button type="button" class="btn btn-block btn-danger hapus_flow_pelayanan_field">Hapus Member</button>
                                                </div>
                                                
                                            </div>
                                       @endif
                                       @endif
                                        
                                    @endforeach
                                </div>
                            </div>
                            
					

                        </div>

                        <hr class="border-hr">
                </div>
                <div class="box-footer clearfix">
                    <div class="row">

                        <div class="col-md-12">

                            <button type="submit" class="btn btn-primary">Save</button>&nbsp;

                            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>

                        </div>

                    </div>
                  </div>
                </form>


            </div>

        </div>

    </div>

@endsection
