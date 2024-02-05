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
                  <th>Nama</th>
                  <th>Organisasi</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Jabatan</th>
                  <th>Role User</th>
                  <th>Team</th>
                  <th>Status</th>
                  <th>Username</th>
                  <th>Password</th>
              </tr>
      
            </thead>
            <tbody>
              <?php
                $no = 1;
              ?>
            @foreach($org as $data)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $data->nama_depan  }}&nbsp;{{ $data->nama_belakang  }}</td>
                <td>{{ $data->opd}}</td>
                <td>{{ $data->phone}}</td>
                <td>{{ $data->email}}</td>
                <td>{{ $data->jabatan}}</td>
                <td>{{ $data->role}}</td>
                <td>{{ $data->name_team}}</td>
                <td>{{ $data->status_user}}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->passwd }}</td>
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
