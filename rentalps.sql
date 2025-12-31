-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Des 2025 pada 07.42
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
-- Database: `rentalps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `ps_id` int(11) DEFAULT NULL,
  `nama_customer` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status` enum('pending','approved','selesai') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `ps_id`, `nama_customer`, `no_hp`, `alamat`, `tanggal_mulai`, `tanggal_selesai`, `total_harga`, `status`) VALUES
(4, 3, 'cemongs', '089601687798', 'jl manggis 8 no 19', '2025-12-27', '2025-12-28', 50000, ''),
(5, 4, 'iwan', '089765437890', 'jl pepaya 10 no 19c', '2025-12-27', '2025-12-28', 10000, ''),
(6, 3, 'andri', '089765436789', 'jl semangka no 19', '2025-12-27', '2025-12-27', 25000, 'selesai'),
(7, 3, 'ucup', '089676543245', 'jl semangka v no .16c', '2025-12-29', '2025-12-30', 50000, 'selesai'),
(8, 1, 'awan', '089654326789', 'jl nangka v no 19 c', '2025-12-27', '2025-12-29', 30000, 'selesai'),
(9, 1, 'awan', '089765435678', 'jl nangka v', '2025-12-30', '2025-12-31', 20000, 'selesai'),
(11, 3, 'aji', '089532457896', 'jl markisa 8. no.32', '2025-12-31', '2025-12-31', 25000, 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `playstations`
--

CREATE TABLE `playstations` (
  `id` int(11) NOT NULL,
  `nama_ps` varchar(50) DEFAULT NULL,
  `harga_per_hari` int(11) DEFAULT NULL,
  `status` enum('tersedia','dibooking') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `playstations`
--

INSERT INTO `playstations` (`id`, `nama_ps`, `harga_per_hari`, `status`) VALUES
(1, 'PS4 Slim', 10000, 'tersedia'),
(3, 'PS5', 25000, 'tersedia'),
(4, 'PS 3', 5000, 'tersedia'),
(5, 'PS 3 Slim', 7000, 'tersedia'),
(6, 'PS 5 PRO', 30000, 'tersedia');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ps_id` (`ps_id`);

--
-- Indeks untuk tabel `playstations`
--
ALTER TABLE `playstations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `playstations`
--
ALTER TABLE `playstations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`ps_id`) REFERENCES `playstations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
