<?php
error_reporting(0);
include "koneksi.php"; // Koneksi ke database

// Baca ID data yang akan di-edit
$id = $_GET['id'];

// Baca data karyawan berdasarkan ID
$query = mysqli_query($konek, "SELECT * FROM karyawan WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Jika tombol simpan diklik
if (isset($_POST['btnSimpan'])) {
    // Baca isi inputan form
    $nokartu = $_POST['nokartu'];
    $nama = $_POST['nama'];
    $departmen = $_POST['departmen'];

    // Simpan ke tabel karyawan
    $update = mysqli_query($konek, "UPDATE karyawan SET nokartu='$nokartu', nama='$nama', departmen='$departmen' WHERE id='$id'");

    if ($update) {
        echo "<script>
                alert('Tersimpan');
                window.location.href = 'datakaryawan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Tersimpan');
                window.location.href = 'datakaryawan.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">SISTEM EHS</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Home
                        </a>
                        <a class="nav-link" href="datakaryawan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Data Karyawan
                        </a>
                        <a class="nav-link" href="absensi.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Rekapitulasi Karyawan
                        </a>
                        <a class="nav-link" href="absensi_tamu.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Rekapitulasi Tamu
                        </a>
                        <a class="nav-link" href="absensi_magang.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
                            Rekapitulasi Magang
                        </a>
                        <a class="nav-link" href="riwayat.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Riwayat Absen
                        </a>
                        <a class="nav-link" href="scan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                            Scan Kartu
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <div class="container-fluid">
                <h3>Edit Data Karyawan</h3>

                <!-- Form input -->
                <form method="POST">
                    <div class="form-group">
                        <label>No. Kartu</label>
                        <input type="text" name="nokartu" id="nokartu" placeholder="Nomor kartu RFID" class="form-control" style="width: 200px" value="<?= htmlspecialchars($data['nokartu']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Nama Karyawan</label>
                        <input type="text" name="nama" id="nama" placeholder="Nama karyawan" class="form-control" style="width: 400px" value="<?= htmlspecialchars($data['nama']); ?>">
                    </div>

                    <div class="form-group">
                        <label>Departemen</label>
                        <textarea class="form-control" name="departmen" id="departmen" placeholder="Departemen" style="width: 400px"><?= htmlspecialchars($data['departmen']); ?></textarea>
                    </div>

                    <button class="btn btn-primary" name="btnSimpan" id="btnSimpan">Simpan</button>
                </form>
            </div>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>