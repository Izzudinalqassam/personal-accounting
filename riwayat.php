<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Riwayat Absensi - SB Admin</title>
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
                    <h2 class="mt-4">Riwayat Absensi</h2>
                    
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="filter-date">Pilih Tanggal:</label>
                            <div class="input-group" style="max-width: 250px;">
                                <input type="date" class="form-control" id="filter-date" name="filter-date" value="<?php echo isset($_POST['filter-date']) ? htmlspecialchars($_POST['filter-date']) : ''; ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="filter-department">Pilih Departemen:</label>
                            <select class="form-control" id="filter-department" name="filter-department">
                                <option value="">Semua Departemen</option>
                                <?php
                                    include "koneksi.php";
                                    $departments = mysqli_query($konek, "SELECT DISTINCT departmen FROM karyawan");
                                    while ($dept = mysqli_fetch_assoc($departments)) {
                                        $selected = isset($_POST['filter-department']) && $_POST['filter-department'] == $dept['departmen'] ? 'selected' : '';
                                        echo "<option value=\"{$dept['departmen']}\" $selected>{$dept['departmen']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>

                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data Absensi
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Departmen</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filter_date = $_POST['filter-date'];
            $filter_department = $_POST['filter-department'];

            // Query untuk menampilkan data berdasarkan filter
            $sql = "SELECT a.tanggal, b.NIK, b.nama, b.departmen, a.jam_masuk, a.jam_pulang 
                    FROM absensi a 
                    JOIN karyawan b ON a.nokartu = b.nokartu 
                    WHERE 1=1";
            
            // Filter berdasarkan tanggal jika ada
            if (!empty($filter_date)) {
                $sql .= " AND a.tanggal = '$filter_date'";
            }

            // Filter berdasarkan departemen jika ada
            if (!empty($filter_department)) {
                $sql .= " AND b.departmen = '$filter_department'";
            }

            $result = mysqli_query($konek, $sql);
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$row['tanggal']}</td>";
                echo "<td>{$row['NIK']}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "<td>{$row['departmen']}</td>";
                echo "<td>{$row['jam_masuk']}</td>";
                echo "<td>{$row['jam_pulang']}</td>";
                echo "<td><a href='detail_profil.php?nik={$row['NIK']}' class='btn btn-info'>Detail</a></td>";
                echo "</tr>";
                $no++;
            }
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
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>
</html>
