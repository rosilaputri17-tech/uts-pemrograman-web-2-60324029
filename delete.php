<?php
require_once 'config/database.php';

// =========================
// A. VALIDASI ID
// =========================
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=ID tidak ditemukan");
    exit;
}

$id = $_GET['id'];

// cek harus angka
if (!is_numeric($id)) {
    header("Location: index.php?error=ID tidak valid");
    exit;
}

// =========================
// CEK DATA ADA / TIDAK
// =========================
$cek = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$cek->bind_param("i", $id);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?error=Data tidak ditemukan");
    exit;
}

// =========================
// B. DELETE DATA
// =========================
$delete = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$delete->bind_param("i", $id);
$delete->execute();

// cek berhasil atau tidak
if ($delete->affected_rows > 0) {
    // =========================
    // C. REDIRECT SUKSES
    // =========================
    header("Location: index.php?success=Data berhasil dihapus");
} else {
    header("Location: index.php?error=Gagal menghapus data");
}

exit;
?>