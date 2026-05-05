<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once 'config/database.php';

$errors = [];

// =========================
// A. AMBIL ID DARI GET
// =========================
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=ID tidak ditemukan");
    exit;
}

$id = (int) $_GET['id'];

// =========================
// RETRIEVE DATA
// =========================
$stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?error=Data tidak ditemukan");
    exit;
}

$data = $result->fetch_assoc();

// default value (untuk prefill)
$kode = $data['kode_kategori'];
$nama = $data['nama_kategori'];
$deskripsi = $data['deskripsi'];
$status = $data['status'];

// =========================
// PROSES UPDATE (POST)
// =========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitasi
    $kode = htmlspecialchars(trim($_POST['kode']));
    $nama = htmlspecialchars(trim($_POST['nama']));
    $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
    $status = htmlspecialchars(trim($_POST['status']));

    // =========================
    // VALIDASI KODE
    // =========================
    if (empty($kode)) {
        $errors[] = "Kode kategori wajib diisi";
    } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
        $errors[] = "Kode kategori harus 4-10 karakter";
    } elseif (!preg_match("/^KAT-/", $kode)) {
        $errors[] = "Kode harus diawali 'KAT-'";
    }

    // =========================
    // VALIDASI NAMA
    // =========================
    if (empty($nama)) {
        $errors[] = "Nama kategori wajib diisi";
    } elseif (strlen($nama) < 3 || strlen($nama) > 50) {
        $errors[] = "Nama kategori harus 3-50 karakter";
    }

    // =========================
    // VALIDASI DESKRIPSI
    // =========================
    if (!empty($deskripsi) && strlen($deskripsi) > 200) {
        $errors[] = "Deskripsi maksimal 200 karakter";
    }

    // =========================
    // VALIDASI STATUS
    // =========================
    if ($status !== 'Aktif' && $status !== 'Nonaktif') {
        $errors[] = "Status tidak valid";
    }

    // =========================
    // CEK DUPLIKASI (EXCLUDE ID INI)
    // =========================
    if (empty($errors)) {
        $cek = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
        $cek->bind_param("si", $kode, $id);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $errors[] = "Kode kategori sudah digunakan";
        }
    }

    // =========================
    // UPDATE DATA
    // =========================
    if (empty($errors)) {
        $update = $conn->prepare("UPDATE kategori SET kode_kategori=?, nama_kategori=?, deskripsi=?, status=? WHERE id_kategori=?");
        $update->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

        if ($update->execute()) {
            header("Location: index.php?success=Data berhasil diupdate");
            exit;
        } else {
            $errors[] = "Gagal mengupdate data";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Kategori</h4>
                </div>
                <div class="card-body">

                    <!-- TAMPILKAN ERROR -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- FORM PREFILL -->
                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Kode Kategori</label>
                            <input type="text" name="kode" class="form-control" value="<?= $kode ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" class="form-control" value="<?= $nama ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"><?= $deskripsi ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label><br>
                            <input type="radio" name="status" value="Aktif" <?= ($status == 'Aktif') ? 'checked' : '' ?>> Aktif
                            <input type="radio" name="status" value="Nonaktif" <?= ($status == 'Nonaktif') ? 'checked' : '' ?>> Nonaktif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>