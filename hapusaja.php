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