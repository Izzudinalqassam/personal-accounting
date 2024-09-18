<?php
error_reporting(0);
include "koneksi.php"; // Koneksi ke database

// Query to count the total number of employees
$totalKaryawanQuery = mysqli_query($konek, "SELECT COUNT(*) as total FROM karyawan");
$totalKaryawanData = mysqli_fetch_assoc($totalKaryawanQuery);
$totalKaryawan = $totalKaryawanData['total'];

// Query to count the total number of employees in the 'tamu' department
$totalTamuQuery = mysqli_query($konek, "SELECT COUNT(*) as total FROM karyawan WHERE departmen = 'tamu'");
$totalTamuData = mysqli_fetch_assoc($totalTamuQuery);
$totalTamu = $totalTamuData['total'];

// Query to count the total number of employees in the 'Magang' department
$totalmagangQuery = mysqli_query($konek, "SELECT COUNT(*) as total FROM karyawan WHERE departmen = 'Magang'");
$totalmagangData = mysqli_fetch_assoc($totalmagangQuery);
$totalmagang = $totalmagangData['total'];

// Query to count the total number of employees except in the 'tamu' department
$totalKaryawanNonTamuQuery = mysqli_query($konek, "SELECT COUNT(*) as total FROM karyawan WHERE departmen != 'tamu'");
$totalKaryawanNonTamuData = mysqli_fetch_assoc($totalKaryawanNonTamuQuery);
$totalKaryawanNonTamu = $totalKaryawanNonTamuData['total'];

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
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
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
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard Sistem EHS</h1>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Total Karyawan </div>
                                <h1 style="text-align: center; font-size: 2rem;"><?= $totalKaryawanNonTamu ?></h1>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Total Magang</div>
                                <h1 style="text-align: center; font-size: 2rem;"><?= $totalmagang ?></h1>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Total Tamu</div>
                                <h1 style="text-align: center; font-size: 2rem;"><?= $totalTamu ?></h1>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Total Semua Orang</div>
                                <h1 style="text-align: center; font-size: 2rem;"><?= $totalKaryawan ?></h1>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="tambah.php" class="btn btn-primary mb-3">Tambah Data Karyawan</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data Karyawan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Departmen/Tamu</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($konek, "SELECT * FROM karyawan"); // Query data
                                        $no = 1; // No. dimulai dari 1
                                        while ($data = mysqli_fetch_assoc($sql)) { // Mengambil data karyawan dari database
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $data['NIK']; ?></td>
                                                <td><?= $data['nama']; ?></td>
                                                <td><?= $data['departmen']; ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?= $data['id']; ?>" class="btn btn-warning">Edit</a>
                                                    <a href="hapus.php?id=<?= $data['id']; ?>" class="btn btn-danger">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2024</div>
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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // Initialize DataTables
        });
    </script>
</body>

</html>
