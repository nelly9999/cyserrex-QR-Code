-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03 Jun 2018 pada 15.07
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `presensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
`id_bar` int(6) NOT NULL,
  `id_peg` int(6) NOT NULL,
  `qr_code` varchar(100) NOT NULL,
  `qr_level` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data untuk tabel `barcode`
--

INSERT INTO `barcode` (`id_bar`, `id_peg`, `qr_code`, `qr_level`) VALUES
(1, 1, 'sman1mandastana-jaya123', 1),
(2, 2, 'sman1mandastana-jaya321', 1),
(3, 3, 'sman1mandastana-tes123', 1),
(5, 5, 'sman1mandastana-yeah123', 2),
(6, 6, 'sman1mandastana-yahooo', 1),
(7, 7, 'sman1mandastana-soekranoeu', 1),
(20, 20, 'sman1mandastana-kepsek123', 1),
(21, 21, 'sman1mandastana-abdulw', 1),
(22, 22, 'sman1mandastana-khairullah', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jbt` tinyint(1) NOT NULL,
  `nama_jbt` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jbt`, `nama_jbt`) VALUES
(1, 'Kepala Sekolah'),
(2, 'Wakil'),
(3, 'Guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jam`
--

CREATE TABLE IF NOT EXISTS `jam` (
`id` int(1) NOT NULL,
  `j_msk` time NOT NULL,
  `j_keluar` time NOT NULL,
  `j_keluar_msk` time NOT NULL,
  `j_plg` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `jam`
--

INSERT INTO `jam` (`id`, `j_msk`, `j_keluar`, `j_keluar_msk`, `j_plg`) VALUES
(1, '07:43:00', '12:00:00', '13:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

CREATE TABLE IF NOT EXISTS `kehadiran` (
  `id_khd` tinyint(1) NOT NULL,
  `nama_khd` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`id_khd`, `nama_khd`) VALUES
(1, 'Hadir'),
(2, 'Izin'),
(3, 'Sakit'),
(4, 'Alfa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
`id_peg` int(6) NOT NULL,
  `id_sts` tinyint(1) NOT NULL,
  `id_jbt` tinyint(1) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` char(1) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_peg`, `id_sts`, `id_jbt`, `nip`, `nama`, `tgl_lahir`, `jk`, `alamat`, `no_telp`, `foto`) VALUES
(1, 1, 3, '19729612', 'Edi Suroso, S. Pd', '1994-11-08', 'L', 'Jl. Surga', '0793493479', 'Edi_Suroso,_S._Pd-1994-11-08.JPG'),
(2, 1, 3, '2147483647', 'Nana', '1990-11-30', 'P', 'Jl. Buaya Krokodil', '08347394', 'Nana-1899-11-30.jpg'),
(3, 1, 3, '78788712', 'Alhdlka', '2000-02-09', 'L', 'Jl. Apajaa', '09732487', 'Alhdlka-1899-11-30.jpg'),
(5, 1, 2, '87876876182', 'Selamat R, S. Pd', '2017-08-09', 'L', 'Kolaskalsk', '089239823', 'Selamat_R,_S._Pd-2017-08-09.JPG'),
(6, 1, 3, '45464546', 'Satria', '2017-08-01', 'L', 'Jl. askjaksjas', '097347834', 'Tazkia-2017-08-01.gif'),
(7, 1, 3, '50505050', 'Soekarno Hatta', '2017-08-09', 'L', 'Jl. Jamaika', '0893748374', 'Sukarno_Hatta-2017-08-09.jpg'),
(20, 1, 1, '78926321938', 'H. Abdul Khair', '2007-08-15', 'L', 'akljsla', '038493', 'H._Abdul_Khair-2007-08-15.jpg'),
(21, 1, 3, '196308142015011001', 'Abdul Wahid Maktub', '1963-08-14', 'L', 'Jl. Sultan Adam', '0858859919012', 'Abdul_Wahid_Maktub-1963-08-14.JPG'),
(22, 1, 3, '1130038101', 'Khairullah', '1981-03-30', 'L', 'Jl. Jalan', '', 'Khairullah-1981-03-30.JPG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE IF NOT EXISTS `presensi` (
`id_pres` int(10) NOT NULL,
  `id_peg` int(6) NOT NULL,
  `tgl` date NOT NULL,
  `jam_msk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `jam_keluar_msk` time NOT NULL,
  `jam_plg` time NOT NULL,
  `id_khd` tinyint(1) NOT NULL,
  `ket` varchar(250) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id_pres`, `id_peg`, `tgl`, `jam_msk`, `jam_keluar`, `jam_keluar_msk`, `jam_plg`, `id_khd`, `ket`) VALUES
(1, 20, '2018-02-12', '07:21:12', '12:02:00', '13:04:00', '14:25:38', 1, ''),
(2, 1, '2018-02-12', '07:29:39', '12:00:00', '13:35:00', '14:31:21', 1, ''),
(3, 1, '2018-02-08', '08:32:41', '12:07:00', '13:00:00', '13:34:14', 1, ''),
(9, 1, '2018-02-18', '16:51:14', '16:51:24', '16:51:36', '16:51:47', 1, ''),
(10, 1, '2018-02-01', '07:43:00', '12:00:00', '13:00:00', '16:00:00', 2, 'Cuti pada tanggal 1 Februari s/d 4 Februari'),
(11, 1, '2018-02-02', '07:43:00', '12:00:00', '13:00:00', '16:00:00', 2, 'Cuti pada tanggal 1 Februari s/d 4 Februari'),
(12, 1, '2018-02-03', '07:43:00', '12:00:00', '13:00:00', '16:00:00', 2, 'Cuti pada tanggal 1 Februari s/d 4 Februari'),
(13, 1, '2018-02-04', '07:43:00', '12:00:00', '13:00:00', '16:00:00', 2, 'Cuti pada tanggal 1 Februari s/d 4 Februari');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_sts` tinyint(1) NOT NULL,
  `nama_sts` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_sts`, `nama_sts`) VALUES
(0, 'Tidak Aktif'),
(1, 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id_user` int(6) NOT NULL,
  `id_peg` int(6) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_peg`, `username`, `password`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barcode`
--
ALTER TABLE `barcode`
 ADD PRIMARY KEY (`id_bar`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
 ADD PRIMARY KEY (`id_jbt`);

--
-- Indexes for table `jam`
--
ALTER TABLE `jam`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
 ADD PRIMARY KEY (`id_khd`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
 ADD PRIMARY KEY (`id_peg`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
 ADD PRIMARY KEY (`id_pres`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`id_sts`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
MODIFY `id_bar` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `jam`
--
ALTER TABLE `jam`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
MODIFY `id_peg` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
MODIFY `id_pres` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
