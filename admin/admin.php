<?php
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$pesan = "";

// Tambah Admin
if (isset($_POST['tambah'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $level = "admin";
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $foto);
    }

    mysqli_query($conn, "INSERT INTO admin (username, nama, password, level, foto) 
                         VALUES ('$username','$nama','$pass','$level','$foto')");
    $pesan = "✅ Admin berhasil ditambahkan!";
}

// Edit Admin
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    $sqlFoto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $foto);
        $sqlFoto = ", foto='$foto'";
    }

    $sqlPass = "";
    if (!empty($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sqlPass = ", password='$pass'";
    }

    mysqli_query($conn, "UPDATE admin SET username='$username', nama='$nama' $sqlFoto $sqlPass WHERE id=$id");
    $pesan = "✏️ Data admin berhasil diperbarui!";
}

// Hapus Admin
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = mysqli_query($conn, "SELECT foto FROM admin WHERE id=$id");
    $r = mysqli_fetch_assoc($q);
    if ($r && $r['foto'] && file_exists("../assets/img/" . $r['foto'])) {
        unlink("../assets/img/" . $r['foto']);
    }
    mysqli_query($conn, "DELETE FROM admin WHERE id=$id");
    header("Location: admin.php");
    exit;
}
?>

<?php include 'sidebar_header.php'; ?>

<div class="content">
    <h4 class="mb-3">Kelola Admin</h4>

    <?php if ($pesan): ?>
            <div class="alert alert-success"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        ➕ Tambah Admin
    </button>

    <!-- Data Admin -->
    <div class="card">
        <div class="card-header bg-dark text-white">Daftar Admin</div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $q = mysqli_query($conn, "SELECT * FROM admin ORDER BY nama");
                    while ($r = mysqli_fetch_assoc($q)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?php if ($r['foto']) { ?>
                                            <img src="../assets/img/<?= $r['foto'] ?>" width="50" height="50" class="rounded-circle">
                                    <?php } else { ?>
                                            <span class="text-muted">-</span>
                                    <?php } ?>
                                </td>
                                <td><?= $r['username'] ?></td>
                                <td><?= $r['nama'] ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $r['id'] ?>">✏ Edit</button>
                                    <a href="admin.php?hapus=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus admin ini?')">🗑 Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $r['id'] ?>" tabindex="-1">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form method="post" enctype="multipart/form-data">
                                    <div class="modal-header bg-warning">
                                      <h5 class="modal-title">Edit Admin</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                      <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" value="<?= $r['username'] ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= $r['nama'] ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Password (kosongkan jika tidak ganti)</label>
                                        <input type="password" name="password" class="form-control">
                                      </div>
                                      <div class="mb-3">
                                        <label>Foto (kosongkan jika tidak ganti)</label>
                                        <input type="file" name="foto" class="form-control">
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
      <form method="post" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah Admin/Pengelola</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Level</label>
            <select name="level" class="form-control" required>
              <option value="">-- Pilih Level --</option>
              <option value="admin">Admin</option>
              <option value="pengelola">Pengelola</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
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
