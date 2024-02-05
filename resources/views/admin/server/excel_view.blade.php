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
                  <th>No</th>
                  <th>Nama Perangkat</th>
                  <th>Model</th>
                  <th>Merek</th>
                  <th>Lisensi</th>
                  <th>Nomer Serial</th>
                  <th>Nomer Aset</th>
                  <th>Ip Manajemen</th>
                  <th>No Rak</th>
              </tr>
      
            </thead>
            <tbody>
              <?php
                $no = 1;
              ?>
            @foreach($server as $data)
            <tr>
                <td align="left">{{ $no }}</td>
                <td align="left">{{ $data->nama_perangkat}}</td>
                <td align="left">{{ $data->model}}</td>
                <td align="left">{{ $data->merek}}</td>
                <td align="left">{{ $data->lisensi}}</td>

                <td align="left">{{ $data->nomer_serial}}</td>
                <td align="left">{{ $data->nomer_aset}}</td>
                <td align="left">{{ $data->ip_manajemen}}</td>
                <td align="left">{{ $data->no_rak }}</td>
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
