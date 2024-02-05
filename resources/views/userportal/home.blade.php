@section('userhome-link')class="active" @stop

@extends('layout.adminlte.user_portal')



@section('contentheader_title')



@endsection



@section('additional_styles')

@endsection



@section('main-content')



    <?php
    
    $onGoing = 'public/images/icons/reunion.png';
    
    $cs = 'public/images/icons/customer-service.png';
    
    $report = 'public/images/icons/report.png';
    
    ?>



    <div class="row">

        <div class="col-md-12">

            <div class="box box-primary" style="border:none;">



                <!-- /.box-header -->

                <div class="box-body">

                    <div class="row padd_dashboard">

                        <div class="col-md-3">

                            <img src="{{ asset($report) }}" width="100">

                        </div>

                        <div class="col-md-9">

                            <p style="font-size: 1.5em;"><a href="{{ asset('new_tiket') }}">Pengajuan Permintaan</a></p>

                            <p>Untuk memulai permintaan pelayanan pada Diskominfo Jabar, klik menu ini maka akan muncul
                                pilihan layanan yang diinginkan.</p>

                        </div>

                    </div>

                </div>

                <!-- /.footer -->

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
