@section('home-link')class="active" @stop



@extends('layout.adminlte.app')



@section('htmlheader_title')

    BERANDA

@endsection



@section('contentheader_title')

    BERANDA

@endsection



@section('additional_styles')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });

        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var record = {!! json_encode($pieDiagram) !!};
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Source');
            data.addColumn('number', 'Total_Signup');

            for (var k in record) {
                var v = record[k];
                data.addRow([k, v]);
            }

            var options = {
                title: 'Status Tiket',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);

            // BULANAN

            var record = {!! json_encode($statMonth) !!};
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Source');
            data.addColumn('number', 'Total_Signup');

            for (var k in record) {
                var v = record[k];
                data.addRow([k, v]);
            }

            var options = {
                title: 'Status Tiket',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('status_bulanan'));
            chart.draw(data, options);

            // Chart Persentase Pelayanan
            var record = {!! json_encode($statTotalPelayanan) !!};
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'jenis_pelayanan');
            data.addColumn('number', 'total_request');

            for (var k in record) {
                var v = record[k];
                data.addRow([k, v]);
            }

            var options = {
                title: 'Jenis Pelayanan',
                is3D: true,
                chartArea: {
                    left: 20,
                    top: 0,
                    width: '100%',
                    height: '100%'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('jns_pelayanan_percentage'));
            chart.draw(data, options);
            // End chart persentasi pelayanan

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('myChart');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [@foreach ($rating as $r)@if ($r->survey_rate == null)"Belum Diisi", @else'{{ $r->survey_rate }}', @endif @endforeach],
                    datasets: [{
                        label: 'Tiket',
                        data: [@foreach ($rating as $r){{ $r->count }}, @endforeach],
                        backgroundColor: [
                            'orange',
                            'orange',
                            'orange',
                            'orange',
                            'orange',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {

                    maintainAspectRatio: false,
                    responsive: true,

                    scales: {
                        y: {
                            beginAtZero: true
                        },
                    }
                }
            });
        }, false);
    </script>
    
@endsection



@section('main-content')

    <!-- COUNT PERSENTAGE -->
    @if (Auth::user()->role_user == 'Verifikator PD')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" style="border:none;">
                    <div class="box-body">
                        <div class="row padd_dashboard">
                            <div class="col-md-3">
                                <img src="public/images/icons/report.png" width="100">
                            </div>
                            <div class="col-md-9">
                                <p style="font-size: 1.5em;"><a
                                        href="{{ route('pelayanan.validatorpd', ['status' => 'Open']) }}">Validasi
                                        Pelayanan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($current_logged_user->role_user != 'Verifikator PD')
        <!-- PIE CHART -->
        @if (Auth::user()->role_user == 'Agen')
        <div class="row">
          <div class="col-md-12">
                <div class="box box-primary" style="border:none;">
                    <div class="box-body">
                        <div class="row padd_dashboard">
                            <div class="col-md-3">
                                <img src="public/images/icons/report.png" width="100">
                            </div>
                            <div class="col-md-9">
                                <p style="font-size: 1.5em;"><a
                                        href="{{ route('pelayanan.agen', ['status' => 'Diproses']) }}">Pemenuhan Layanan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                <div class="box box-primary">

                    <div class="box-header with-border">

                        <h3 class="box-title">Presetase Progress Keseluruhan</h3>



                        <div class="box-tools pull-right">

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>

                            </button>

                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>

                        </div>

                    </div>

                    <!-- /.box-header -->

                    <div class="box-body">

                        <div id="piechart_3d" style="width: 330px;height: 220px"></div>

                    </div>

                    <!-- /.footer -->

                </div>

            </div>
            <div class="col-md-6">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Presetase Progress Bulan Ini</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="status_bulanan" style="width: 330px;height: 220px"></div>
                    </div>
                    <!-- /.footer -->
                </div>

            </div>
        </div>
        @elseif (Auth::user()->role_user == 'Koordinator Agen')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary" style="border:none;">
                    <div class="box-body">
                        <div class="row padd_dashboard">
                            <div class="col-md-3">
                                <img src="public/images/icons/report.png" width="100">
                            </div>
                            <div class="col-md-9">
                                <p style="font-size: 1.5em;"><a href="{{ route('pelayanan.koordinatorAgen', ['status' => 'Diproses']) }}">Verifikasi Permintaan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary" style="border:none;">
                    <div class="box-body">
                        <div class="row padd_dashboard">
                            <div class="col-md-3">
                                <img src="public/images/icons/report.png" width="100">
                            </div>
                            <div class="col-md-9">
                                <p style="font-size: 1.5em;"><a
                                        href="{{ route('pelayananDataUnverifiedPage',['status_task' => 0]) }}">Verifikasi Pemenuhan Layanan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                <div class="box box-primary">

                    <div class="box-header with-border">

                        <h3 class="box-title">Presetase Progress Keseluruhan</h3>



                        <div class="box-tools pull-right">

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>

                            </button>

                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>

                        </div>

                    </div>

                    <!-- /.box-header -->

                    <div class="box-body">

                        <div id="piechart_3d" style="width: 330px;height: 220px"></div>

                    </div>

                    <!-- /.footer -->

                </div>

            </div>
            <div class="col-md-6">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Presetase Progress Bulan Ini</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="status_bulanan" style="width: 330px;height: 220px"></div>
                    </div>
                    <!-- /.footer -->
                </div>

            </div>
        </div>
        
        @elseif (Auth::user()->role_user == 'Helpdesk')
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary" style="border:none;">
                        <div class="box-body">
                            <div class="row padd_dashboard">
                                <div class="col-md-3">
                                    <img src="public/images/icons/report.png" width="100">
                                </div>
                                <div class="col-md-9">
                                    <p style="font-size: 1.5em;"><a href="{{ route('pelayanan.create') }}">Pengajuan
                                            Permintaan</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary" style="border:none;">
                        <div class="box-body">
                            <div class="row padd_dashboard">
                                <div class="col-md-3">
                                    <img src="public/images/icons/report.png" width="100">
                                </div>
                                <div class="col-md-9">
                                    <p style="font-size: 1.5em;"><a
                                            href="{{ route('pelayanan.helpdesk', ['status' => 'Open']) }}">
                                            Permintaan Baru</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary" style="border:none;">
                        <div class="box-body">
                            <div class="row padd_dashboard">
                                <div class="col-md-3">
                                    <img src="public/images/icons/report.png" width="100">
                                </div>
                                <div class="col-md-9">
                                    <p style="font-size: 1.5em;"><a
                                            href="{{ route('pelayanan.helpdesk', ['status' => 'Diproses']) }}">
                                            Permintaan Diproses</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary" style="border:none;">
                        <div class="box-body">
                            <div class="row padd_dashboard">
                                <div class="col-md-3">
                                    <img src="public/images/icons/report.png" width="100">
                                </div>
                                <div class="col-md-9">
                                    <p style="font-size: 1.5em;"><a
                                            href="{{ route('pelayanan.helpdesk', ['status' => 'Close']) }}">
                                            Permintaan Layanan Ditutup</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                            <h3 class="box-title">Presetase Progress Keseluruhan</h3>



                            <div class="box-tools pull-right">

                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>

                                </button>

                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>

                            </div>

                        </div>

                        <!-- /.box-header -->

                        <div class="box-body">

                            <div id="piechart_3d" style="width: 330px;height: 220px"></div>

                        </div>

                        <!-- /.footer -->

                    </div>

                </div>
                <div class="col-md-6">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Presetase Progress Bulan Ini</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="status_bulanan" style="width: 330px;height: 220px"></div>
                        </div>
                        <!-- /.footer -->
                    </div>

                </div>
            </div>

        @else

            <div class="row">

                <div class="col-md-3">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                            <h3 class="box-title">Presetase Progress Keseluruhan</h3>



                            <div class="box-tools pull-right">

                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>

                                </button>

                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>

                            </div>

                        </div>

                        <!-- /.box-header -->

                        <div class="box-body">

                            <div id="piechart_3d" style="width: 330px;height: 220px"></div>

                        </div>

                        <!-- /.footer -->

                    </div>

                </div>
                <div class="col-md-3">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Presetase Progress Bulan Ini</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="status_bulanan" style="width: 330px;height: 220px"></div>
                        </div>
                        <!-- /.footer -->
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Persentase Request Jenis Pelayanan</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="jns_pelayanan_percentage"></div>
                        </div>
                        <!-- /.footer -->
                    </div>

                </div>
                <div class="col-md-12">

                    <div class="box box-warning">

                        <div class="box-header with-border">

                            <h3 class="box-title">Chart Penilaian Pelayanan Service Desk</h3>



                            <div class="box-tools pull-right">

                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>

                                </button>

                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>

                            </div>

                        </div>

                        <!-- /.box-header -->

                        <div class="box-body">

                            <canvas id="myChart" width="200" height="200"></canvas>

                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer clearfix">

                        </div>

                        <!-- /.box-footer -->

                    </div>
                </div>

            </div>
        @endif
        <!-- END PIE CHART -->



        <!-- TABLE BY STATUS -->
    @endif


    {{-- <div class="row">

        <div
            class="col-md-6">
            @if (in_array(Auth::user()->role_user, ['Admin', 'Koordinator PD', 'Eselon 3']))

                <div class="box box-warning">

                    <div class="box-header with-border">

                        <h3 class="box-title">Pelayanan</h3>



                        <div class="box-tools pull-right">

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>

                            </button>

                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>

                        </div>

                    </div>

                    <!-- /.box-header -->

                    <div class="box-body">

                        <div class="table-responsive">

                            <table class="table no-margin">

                                <thead>

                                    <tr>

                                        <th>Judul</th>

                                        <th>Organisasi</th>

                                        <th>Agen</th>

                                        <th>Tgl Pelaporan</th>

                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($tiket as $datatiket)

                                        <tr>

                                            <!-- <td><a href="pages/examples/invoice.html">{{ $datatiket->kd_tiket }}</a></td> -->

                                            <td><a
                                                    href="{{ route('pelayanan.show', $datatiket->id_) }}">{{ $datatiket->judul }}</a>
                                            </td>

                                            <td>{{ $datatiket->nama_opd }}</td>

                                            <td>{{ $datatiket->nama_agen }}</td>

                                            <td>{{ $datatiket->tgl_pelaporan }}</td>

                                            @if ($datatiket->status_tiket == 'Selesai')

                                                <td>
                                                    <h5><span class="label label-success"
                                                            style="padding:3px 8px;">{{ $datatiket->status_tiket }}</span>
                                                    </h5>
                                                </td>

                                            @elseif($datatiket->status_tiket == 'Baru')

                                                <td>
                                                    <h5><span class="label label-primary"
                                                            style="padding:3px 13px;">{{ $datatiket->status_tiket }}</span>
                                                    </h5>
                                                </td>

                                            @elseif($datatiket->status_tiket == 'Ditunda')

                                                <td>
                                                    <h5><span
                                                            class="label label-danger">{{ $datatiket->status_tiket }}</span>
                                                    </h5>
                                                </td>

                                            @endif

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                    </div>
                    <div class="box-footer clearfix">

                        <a href="{{ route('pelayanan.create') }}" class="btn btn-sm btn-info btn-flat pull-left">Tambah
                            Tiket</a>

                        <a href="{{ route('pelayanan.index') }}"
                            class="btn btn-sm btn-default btn-flat pull-right">Tampilkan
                            Seluruh Tiket</a>

                    </div>
                </div>
            @endif
        </div>
    </div> --}}
    </div>

    </div>

    <script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
@endsection
