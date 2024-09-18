<?php
error_reporting(0);
include "koneksi.php";

// Baca tabel status untuk mode absensi
$sql = mysqli_query($konek, "SELECT * FROM status");
$data = mysqli_fetch_array($sql);
$mode_absen = $data['mode'];

// Tentukan mode absen
$mode = ($mode_absen == 1) ? "Masuk" : "Keluar";

// Baca tabel tmprfid
$baca_kartu = mysqli_query($konek, "SELECT * FROM tmprfid");
$nokartu = (mysqli_num_rows($baca_kartu) > 0) ? mysqli_fetch_array($baca_kartu)['nokartu'] : "";
?>

<div class="container-fluid" style="text-align: center;">
    <?php if ($nokartu == "") { ?>
        <h3>Absen : <?php echo $mode; ?> </h3>
        <h3>Silahkan Tempelkan Kartu RFID Anda</h3>
        <img src="images/rfid.png" style="width: 200px"> <br>
        <img src="images/animasi2.gif">
    <?php } else {
        // Cek apakah nomor kartu terdaftar di tabel karyawan
        $cari_karyawan = mysqli_query($konek, "SELECT * FROM karyawan WHERE nokartu='$nokartu'");
        $jumlah_data = mysqli_num_rows($cari_karyawan);

        if ($jumlah_data == 0) {
            echo "<h1>Maaf! Kartu Tidak Dikenali</h1>";
        } else {
            // Ambil nama karyawan
            $data_karyawan = mysqli_fetch_array($cari_karyawan);
            $nama = $data_karyawan['nama'];

            // Tanggal dan jam saat ini
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d');
            $jam = date('H:i:s');

            // Cek apakah kartu sudah absen pada tanggal ini
            $cari_absen = mysqli_query($konek, "SELECT * FROM absensi WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
            $jumlah_absen = mysqli_num_rows($cari_absen);

            if ($jumlah_absen == 0) {
                // Jika belum ada data absen, insert data baru
                echo "<h1>Selamat Datang <br> $nama</h1>";
                mysqli_query($konek, "INSERT INTO absensi(nokartu, tanggal, jam_masuk) VALUES ('$nokartu', '$tanggal', '$jam')");
            } else {
                // Update sesuai mode absen
                if ($mode_absen == 1) {
                    // Jika mode absen masuk, perbarui jam_masuk
                    echo "<h1>Welcome Back <br> $nama</h1>";
                    mysqli_query($konek, "UPDATE absensi SET jam_masuk='$jam' WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
                } elseif ($mode_absen == 2) {
                    // Jika mode absen keluar, perbarui jam_pulang
                    echo "<h1>Selamat Jalan <br> $nama</h1>";
                    mysqli_query($konek, "UPDATE absensi SET jam_pulang='$jam' WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
                }
            }
        }

        // Kosongkan tabel tmprfid
        mysqli_query($konek, "DELETE FROM tmprfid");
    } ?>
</div>
