<?php
error_reporting(0);
include "koneksi.php"; // Koneksi ke database

// Ambil NIK dari URL
$nik = $_GET['nik'];

// Ambil tanggal dari input filter, jika ada
$filter_tanggal = isset($_POST['filter-date']) ? $_POST['filter-date'] : '';

// Query untuk mengambil data karyawan
$query = "SELECT * FROM karyawan WHERE NIK = '$nik'";
$result = mysqli_query($konek, $query);
$karyawan = mysqli_fetch_assoc($result);

// Query untuk mengambil histori absensi, dengan filter tanggal jika ada
$histori_query = "SELECT * FROM absensi WHERE nokartu = '{$karyawan['nokartu']}'";
if ($filter_tanggal) {
    $histori_query .= " AND tanggal = '$filter_tanggal'";
}
$histori_query .= " ORDER BY tanggal";
$histori_result = mysqli_query($konek, $histori_query);

// Variabel total masuk dan keluar
$masuktanggal = 0;
$keluartanggal = 0;

// Perhitungan total masuk dan keluar berdasarkan histori absensi
while ($row = mysqli_fetch_assoc($histori_result)) {
    if ($row['tanggal'] == $filter_tanggal) {
        $masuktanggal++;
        if (!empty($row['jam_pulang'])) {
            $keluartanggal++;
        }
    }
}
// Mengulang query untuk menampilkan data histori setelah kalkulasi
$histori_result = mysqli_query($konek, $histori_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Detail Profil - SB Admin</title>
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
                    <h2 class="mt-4">Detail Profil</h2>
                    
                    <?php
                        if ($karyawan) {
                            echo "<div class='card mb-4'>";
                            echo "<div class='card-header'>Informasi Profil</div>";
                            echo "<div class='card-body'>";
                            echo "<p><strong>NIK:</strong> {$karyawan['NIK']}</p>";
                            echo "<p><strong>Nama:</strong> {$karyawan['nama']}</p>";
                            echo "<p><strong>Nokartu:</strong> {$karyawan['nokartu']}</p>";
                            echo "<p><strong>Departmen:</strong> {$karyawan['departmen']}</p>";
                            echo "</div>";
                            echo "</div>";
                            
                            // Tambahkan bagian filter tanggal
                            echo "<form method='POST' action=''>";
                            echo "<div class='form-group'>";
                            echo "<label for='filter-date'>Pilih Tanggal:</label>";
                            echo "<div class='input-group' style='max-width: 250px;'>";
                            echo "<input type='date' class='form-control' id='filter-date' name='filter-date' value='" . htmlspecialchars($filter_tanggal) . "'>";
                            echo "<div class='input-group-append'>";
                         
                            echo "<button type='submit' class='btn btn-primary'>Filter</button>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "</form>";
                            
                            // Tambahkan total masuk dan keluar
                            echo "<div class='row mt-4'>";
                            echo "<div class='col-xl-3 col-md-6'>";
                            echo "<div class='card bg-success text-white mb-4'>";
                            echo "<div class='card-body'> Total Masuk Tanggal: </div>";
                            echo "<h1 style='text-align: center; font-size: 2rem;'>{$masuktanggal}</h1>";
                            echo "<div class='card-footer d-flex align-items-center justify-content-between'>";
                            echo "<a class='small text-white stretched-link' href='#'>View Details</a>";
                            echo "<div class='small text-white'><i class='fas fa-angle-right'></i></div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";

                            echo "<div class='col-xl-3 col-md-6'>";
                            echo "<div class='card bg-danger text-white mb-4'>";
                            echo "<div class='card-body'> Total Keluar Tanggal: </div>";
                            echo "<h1 style='text-align: center; font-size: 2rem;'>{$keluartanggal}</h1>";
                            echo "<div class='card-footer d-flex align-items-center justify-content-between'>";
                            echo "<a class='small text-white stretched-link' href='#'>View Details</a>";
                            echo "<div class='small text-white'><i class='fas fa-angle-right'></i></div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";

                            // Tabel histori absensi
                            echo "<div class='card mb-4'>";
                            echo "<div class='card-header'>Histori Absensi</div>";
                            echo "<div class='card-body'>";
                            echo "<table class='table table-bordered' id='historiTable'>";
                            echo "<thead><tr><th>Tanggal</th><th>Jam Masuk</th><th>Jam Pulang</th></tr></thead>";
                            echo "<tbody>";
                            
                            while ($row = mysqli_fetch_assoc($histori_result)) {
                                echo "<tr>";
                                echo "<td>{$row['tanggal']}</td>";
                                echo "<td>{$row['jam_masuk']}</td>";
                                echo "<td>{$row['jam_pulang']}</td>";
                                echo "</tr>";
                            }
                            
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                            echo "</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Data karyawan tidak ditemukan.</div>";
                        }
                    ?>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
