<?php
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$pesan = "";

// Tambah Kandidat
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $visi = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi = mysqli_real_escape_string($conn, $_POST['misi']);

    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $foto);
    }

    mysqli_query($conn, "INSERT INTO kandidat (nama,kelas,jenis_kelamin,visi,misi,foto) 
                         VALUES ('$nama','$kelas','$jk','$visi','$misi','$foto')");
    $pesan = "✅ Kandidat berhasil ditambahkan!";
}

// Edit Kandidat
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $visi = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi = mysqli_real_escape_string($conn, $_POST['misi']);

    $sqlFoto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $foto);
        $sqlFoto = ", foto='$foto'";
    }

    mysqli_query($conn, "UPDATE kandidat SET 
        nama='$nama', kelas='$kelas', jenis_kelamin='$jk', visi='$visi', misi='$misi' $sqlFoto 
        WHERE id=$id");

    $pesan = "✏️ Data kandidat berhasil diperbarui!";
}

// Hapus Kandidat
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = mysqli_query($conn, "SELECT foto FROM kandidat WHERE id=$id");
    $r = mysqli_fetch_assoc($q);
    if ($r && file_exists("../assets/img/" . $r['foto'])) {
        unlink("../assets/img/" . $r['foto']);
    }
    mysqli_query($conn, "DELETE FROM kandidat WHERE id=$id");
    header("Location: kandidat.php");
    exit;
}
?>

<?php include 'sidebar_header.php'; ?>

<div class="content">
    <h4 class="mb-3">Kelola Kandidat</h4>

    <?php if ($pesan): ?>
            <div class="alert alert-success"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah Kandidat -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        ➕ Tambah Kandidat
    </button>

    <!-- Data Kandidat -->
    <div class="card">
        <div class="card-header bg-dark text-white">Daftar Kandidat</div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Visi</th>
                        <th>Misi</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $q = mysqli_query($conn, "SELECT * FROM kandidat ORDER BY jenis_kelamin, nama");
                    while ($r = mysqli_fetch_assoc($q)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="../assets/img/<?= $r['foto'] ?>" width="60" class="rounded"></td>
                                <td><?= $r['nama'] ?></td>
                                <td><?= $r['kelas'] ?></td>
                                <td><?= $r['jenis_kelamin'] ?></td>
                                <td><?= nl2br($r['visi']) ?></td>
                                <td><?= nl2br($r['misi']) ?></td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $r['id'] ?>">
                                        ✏ Edit
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <a href="kandidat.php?hapus=<?= $r['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin hapus kandidat ini?')">🗑 Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $r['id'] ?>" tabindex="-1">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <form method="post" enctype="multipart/form-data">
                                    <div class="modal-header bg-warning">
                                      <h5 class="modal-title">Edit Kandidat</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                      <div class="row mb-3">
                                        <div class="col-md-6">
                                          <label>Nama</label>
                                          <input type="text" name="nama" class="form-control" value="<?= $r['nama'] ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                          <label>Kelas</label>
                                          <input type="text" name="kelas" class="form-control" value="<?= $r['kelas'] ?>" required>
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <div class="col-md-6">
                                          <label>Jenis Kelamin</label>
                                          <select name="jk" class="form-control" required>
                                              <option value="Putra" <?= $r['jenis_kelamin'] == 'Putra' ? 'selected' : '' ?>>Putra</option>
                                              <option value="Putri" <?= $r['jenis_kelamin'] == 'Putri' ? 'selected' : '' ?>>Putri</option>
                                          </select>
                                        </div>
                                        <div class="col-md-6">
                                          <label>Foto (kosongkan jika tidak ganti)</label>
                                          <input type="file" name="foto" class="form-control">
                                        </div>
                                      </div>
                                      <div class="mb-3">
                                        <label>Visi</label>
                                        <textarea name="visi" class="form-control" required><?= $r['visi'] ?></textarea>
                                      </div>
                                      <div class="mb-3">
                                        <label>Misi</label>
                                        <textarea name="misi" class="form-control" required><?= $r['misi'] ?></textarea>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah Kandidat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Kelas</label>
              <input type="text" name="kelas" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Jenis Kelamin</label>
              <select name="jk" class="form-control" required>
                  <option value="">Pilih</option>
                  <option value="Putra">Putra</option>
                  <option value="Putri">Putri</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Foto</label>
              <input type="file" name="foto" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label>Visi</label>
            <textarea name="visi" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Misi</label>
            <textarea name="misi" class="form-control" required></textarea>
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
