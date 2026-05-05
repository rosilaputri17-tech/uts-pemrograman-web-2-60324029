-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Bulan Mei 2026 pada 05.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uts_perpustakaan_60324029`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kode_kategori` varchar(10) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kode_kategori`, `nama_kategori`, `deskripsi`, `status`, `created_at`) VALUES
(1, 'RAP-011', 'Web Jaringan', 'Buku-buku tentang pemrograman web dan jaringan', 'Aktif', '2026-05-04 15:58:43'),
(2, 'RAP-012', 'Statistika', 'Buku-buku tentang pembelajaran statistik', 'Aktif', '2026-05-04 15:58:43'),
(3, 'RAP-013', 'Kecerdasan Buatan', 'Buku-buku yang membahas mengenai ilmu kecerdasan buatan', 'Aktif', '2026-05-04 15:58:43'),
(20, 'RAP-019', 'Web Jaringan', 'Buku-buku tentang pemrograman web dan jaringan', 'Aktif', '2026-05-04 16:03:09'),
(21, 'RAP-020', 'Statistika', 'Buku-buku tentang pembelajaran statistik', 'Aktif', '2026-05-04 16:03:09'),
(22, 'RAP-021', 'Kecerdasan Buatan', 'Buku-buku yang membahas mengenai ilmu kecerdasan buatan', 'Aktif', '2026-05-04 16:03:09'),
(23, 'RAP-022', 'Ilmu Komputer', 'Buku-buku yang membahas mengenai pengetahuan ilmu komputer', 'Aktif', '2026-05-04 16:03:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kode_kategori` (`kode_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
