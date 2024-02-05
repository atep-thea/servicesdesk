<!doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Document</title>

</head>

<body>

<div class="page page-dashboard">



  <div class="col-md-12">      

    <!-- tile -->

    <section class="tile">



      <!-- tile body -->

      <div class="tile-body">

        <div class="table-responsive">

          <table class="table table-custom" id="basic-usage" border='1' align='center' style="border">

            <thead class="bg-thead" >

              

              <tr>

                <th colspan="7" style="border-bottom: none; text-align: center;"><h2 class="margin_left"><b>{{$title}}</b></h2></th>

              </tr>

             <tr style="background-color: #1E90FF; border: 1px solid; color:#fff;">
                  <th>NO</th>

                  <th>Kode Tiket</th>

                  <th>Judul</th>

                  <th>Perangkat Daerah</th>

                  <th>Jenis Layanan</th>

                  <th>Tanggal Laporan</th>

                  <th>Agen</th>

                  <th>Status</th>

                  <th>Link Lampiran</th>

              </tr>

      

            </thead>

            <tbody>

              <?php

                $no = 1;

              ?>

            @foreach($pelayanan as $data)

            <tr>

                <td>{{ $no }}</td>

                <td>{{ $data->kd_tiket }}</td>

                <td>{{ $data->judul}}</td>

                <td>{{ $data->nama_opd}}</td>

                <td>{{ $data->sub_pelynn}}</td>

                <td>{{ $data->tgl_pelaporan}}</td>

                <td>{{ $data->nama_agen}}</td>

                <td>{{ $data->status_tiket}}</td>

                <td><a href="servicedesk.jabarprov.go.id/downloadLampiran/{{$data->ids}}">servicedesk.jabarprov.go.id/downloadLampiran/{{$data->ids}}</a></td>

            <?php

              $no++;

            ?>

            @endforeach

          </tbody>

        </table>



      </div>

    </div>



</div>

<!-- /tile body -->



</section>

</div>

</body>

</html>

