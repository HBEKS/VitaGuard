<title>Daftar Dokter</title>
<div>
    <h1>Daftar Dokter</h1>
    <hr>

    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">   
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Spesialisasi</th>
        <th>Tahun Pelayanan</th>
      </tr>
    </thead>
    <tbody>
        @foreach($doctors as $d)
      <tr>
        <td>{{ $d->user->name }}</td>
        <td>{{ $d->specialization->name }}</td>
        <td>{{ $d->experience_years }}</td>
      </tr>
        @endforeach
    </tbody>
  </table>
</div>

</body>
</html>

</div>