<?php
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$pesan = "";

// Tambah Siswa
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO siswa (nis, nama, kelas, password) VALUES ('$nis','$nama','$kelas','$pass')");
    $pesan = "✅ Siswa berhasil ditambahkan!";
}

// Edit Siswa
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    $sqlPass = "";
    if (!empty($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sqlPass = ", password='$pass'";
    }

    mysqli_query($conn, "UPDATE siswa SET nis='$nis', nama='$nama', kelas='$kelas' $sqlPass WHERE id=$id");
    $pesan = "✏️ Data siswa berhasil diperbarui!";
}

// Hapus Siswa
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM siswa WHERE nis=$id");
    header("Location: siswa.php");
    exit;
}
?>

<?php include 'sidebar_header.php'; ?>

<div class="content">
    <h4 class="mb-3">Kelola Siswa</h4>

    <?php if ($pesan): ?>
            <div class="alert alert-success"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        ➕ Tambah Siswa
    </button>

    <!-- Data Siswa -->
    <div class="card">
        <div class="card-header bg-dark text-white">Daftar Siswa</div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $q = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama");
                    while ($r = mysqli_fetch_assoc($q)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $r['nis'] ?></td>
                                <td><?= $r['nama'] ?></td>
                                <td><?= $r['kelas'] ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $r['nis'] ?>">✏ Edit</button>
                                    <a href="siswa.php?hapus=<?= $r['nis'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus siswa ini?')">🗑 Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $r['id'] ?>" tabindex="-1">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form method="post">
                                    <div class="modal-header bg-warning">
                                      <h5 class="modal-title">Edit Siswa</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                      <div class="mb-3">
                                        <label>NIS</label>
                                        <input type="text" name="nis" class="form-control" value="<?= $r['nis'] ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= $r['nama'] ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Kelas</label>
                                        <input type="text" name="kelas" class="form-control" value="<?= $r['kelas'] ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Password (kosongkan jika tidak ganti)</label>
                                        <input type="password" name="password" class="form-control">
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" name="edit" class="btn btn-success">Simpan</button>
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>NIS</label>
            <input type="text" name="nis" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
