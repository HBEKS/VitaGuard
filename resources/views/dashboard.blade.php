<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Dashboard</h1>

    <h3>Menu Member</h3>
    <a href="{{ route('artikel') }}"><button>Artikel</button></a>
    <a href="{{ route('dokter') }}"><button>Daftar Dokter</button></a>
    <a href="{{ route('riwayat') }}"><button>Riwayat Konsultasi</button></a>
    <a href="{{ route('profile') }}"><button>Profile</button></a>

    <hr>

    <h3>Menu Doctor</h3>
    <a href="{{ route('artikel') }}"><button>Artikel</button></a>
    <a href="{{ route('tambah.artikel') }}"><button>Tambah Artikel</button></a>
    <a href="{{ route('my.artikel') }}"><button>My Artikel</button></a>
    <a href="{{ route('chat') }}"><button>Chat Member</button></a>
    <a href="{{ route('konsultasi') }}"><button>Daftar Konsultasi</button></a>
    <a href="{{ route('laporan') }}"><button>List Laporan</button></a>
    <a href="{{ route('profile') }}"><button>Profile</button></a>

    <hr>

    <h3>Menu Admin</h3>
    <a href="{{ route('member') }}"><button>Daftar Member</button></a>
    <a href="{{ route('dokter') }}"><button>Kelola Dokter</button></a>
    <a href="{{ route('artikel') }}"><button>Kelola Artikel</button></a>
    <a href="{{ route('laporan') }}"><button>Daftar Laporan</button></a>
</body>

</html>
