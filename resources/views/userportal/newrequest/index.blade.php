@section('userhome-link')class="active" @stop
@extends('layout.adminlte.user_portal')

@section('contentheader_title')
@endsection

@section('additional_styles')
    <style type="text/css">
        .modal {
            -webkit-animation-duration: 3s !important;
        }

        /* Modal Content */
        .modal-content {
            -webkit-animation-duration: 3s !important;
        }

    </style>
@endsection

@section('additional_scripts')
    <script type="text/javascript">
        $(function() {

            $('#dataTable').DataTable({
				'iDisplayLength': 100,
                processing: true,
                serverSide: true,
                stateSave: true,
                paging: true,
                ajax: '{!! route('new_tiket.data') !!}',
                columns: [{
                        data: 'pelayanan',
                        name: 'pelayanan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                "search": {
                    "caseInsensitive": false
                },
                order: [0, 'asc'],
            });
        });

        $('#addNew').on('show.bs.modal', function(event) {
            var modal = $(this);
            var button = $(event.relatedTarget);
            // organisasi
            var jns = button.data('jns').toString();
            var persyaratan = button.data('syarat').toString();
            console.log(persyaratan)
            $('[name=jns_pelayanan]').val(jns);
            $('#syarat').html(marked.parse(persyaratan));

        });
    </script>
    <script src="{{ asset('public/adminlte/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/js/select_dependent.js') }}"></script>
    <script src="{{ asset('public/js/select_team.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box"
                style="border:none;box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);">
                <div class="box-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <i class="icon fa fa-check"></i>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="alert alert-info"
                        style="background: #ffffb3 !important; color: #4d4949 !important; border: 1px solid #ccc !important;font-size: 13px;"
                        role="alert">

                        <img style="width: 1.5%" src="{{ asset('public/images/warning.png') }}" alt="">&nbsp;&nbsp;
                        <b>Petunjuk Pelayanan</b> Pilih jenis layanan yang tersedia, klik tombol plus untuk memulai.
                        Lampirkan gambar atau file agar memperjelas pelaporan Khusus untuk Jenis <b>Layanan
                            Infrastruktur</b> Harus melampirkan <b>Surat permohonan</b> pada form pelayanan.
                        Cek secara berkala perkembangan status permintaan/pengaduan pada aplikasi, dan cek email notifikasi
                        dari tim admin servicedesk.
                    </div>
                    <table class="table table-bordered table-hover table-striped" id="dataTable" style="width: 100%">
                        <thead class="">
                            <tr>
                                <th>Pelayanan</th>
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

    @include('userportal.newrequest.addNew')

@endsection
