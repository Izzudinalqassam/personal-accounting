<?php
include 'koneksi.php';

// Query untuk mendapatkan jumlah total orang yang keluar hari ini
$date_today = date('Y-m-d');
$sql_total_keluar_today = "SELECT COUNT(*) AS total_keluar_today FROM absensi WHERE jam_pulang != '00:00:00' AND DATE(jam_pulang) = '$date_today'";
$result_total_keluar_today = mysqli_query($konek, $sql_total_keluar_today);
$data_total_keluar_today = mysqli_fetch_assoc($result_total_keluar_today);
$total_keluar_today = $data_total_keluar_today['total_keluar_today'];
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
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">SISTEM EHS</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

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
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Data Karyawan
                        </a>
                        <a class="nav-link" href="absensi.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Rekapitulasi
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
                    <h1 class="mt-4">Detail Orang Keluar Hari Ini</h1>

                    <!-- Menampilkan total orang yang keluar hari ini -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Total Orang Masuk Hari Ini</div>
                                <h1 style="text-align: center; font-size: 2rem;"><?= $total_keluar_today ?></h1>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">
                                        <a class="small text-white stretched-link " href="absensi.php">Kembali</a>
                                    </div>
                                    <i class="fas fa-angle-right"></i>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menampilkan tabel data orang yang keluar hari ini -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data Orang Keluar Hari Ini
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Departemen</th>

                                            <th>Jam Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query data absensi orang keluar hari ini
                                        $sql = "SELECT b.NIK, b.nama, b.departmen, a.jam_pulang 
                                                    FROM absensi a 
                                                    JOIN karyawan b ON a.nokartu = b.nokartu
                                                    WHERE a.jam_pulang != '00:00:00' AND DATE(a.jam_pulang) = '$date_today'";
                                        $result = mysqli_query($konek, $sql);
                                        $no = 1;

                                        // Looping data hasil query
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $no . "</td>";
                                            echo "<td>" . htmlspecialchars($row['NIK']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['departmen']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jam_pulang']) . "</td>";
                                            echo "</tr>";
                                            $no++;
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

    <!-- Script untuk bootstrap dan DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "searching": true, // Mengaktifkan fitur pencarian
                "paging": true, // Mengaktifkan paging
                "info": true // Menampilkan informasi tabel
            });
        });
    </script>
</body>

</html>