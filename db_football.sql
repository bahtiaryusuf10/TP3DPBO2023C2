-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2023 pada 07.56
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_football`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stadium_id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `coach` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `stadium_id`, `logo`, `coach`) VALUES
(1, 'Real Madrid', 1, 'Real_Madrid.jpg', 'Zinedine Zidane'),
(2, 'Manchester City', 2, 'Manchester_City.jpg', 'Pep Guardiola'),
(3, 'Manchester United', 3, 'Manchester_United.jpg', 'Sir Alex Ferguson'),
(4, 'Juventus F.C.', 4, 'Juventus.jpg', 'Massimiliano Allegri'),
(5, 'FC Bayern Munich', 5, 'Bayern_München.jpg', 'Carlo Ancelotti'),
(11, 'Borussia Dortmund', 9, 'Borussia_Dortmund.jpg', 'Jürgen Klopp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `home_club_id` int(11) NOT NULL,
  `away_club_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matches`
--

INSERT INTO `matches` (`id`, `home_club_id`, `away_club_id`, `date`) VALUES
(1, 2, 1, '2023-05-17'),
(2, 1, 5, '2024-08-10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `club_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `jersey_number` int(11) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `players`
--

INSERT INTO `players` (`id`, `name`, `photo`, `club_id`, `position_id`, `jersey_number`, `age`) VALUES
(1, 'Cristiano Ronaldo', 'Cristiano.jpg', 1, 11, 7, 28),
(2, 'Erling Haaland', 'Erling.jpg', 2, 13, 9, 22),
(3, 'Iker Casillas', 'Iker.jpg', 1, 1, 1, 34),
(4, 'Sergio Ramos', 'Ramos.jpeg', 1, 3, 4, 30),
(7, 'Kevin De Bruyne', 'Kdb.jpg', 2, 9, 17, 25),
(8, 'Joe Hart', 'Joe.jpg', 2, 1, 1, 26),
(9, 'Marcelo Vieira', 'Marcelo.jpg', 1, 2, 12, 27),
(10, 'João Cancelo', 'Cancelo.jpg', 2, 2, 7, 24),
(11, 'Gianluigi Buffon', 'Buffon.jpg', 4, 1, 1, 33),
(12, 'Paulo Dybala', 'Dybala.jpg', 4, 10, 10, 23),
(13, 'Giorgio Chiellini', 'Chiellini.jpg', 4, 3, 3, 33),
(14, 'Paul Pogba', 'Pogba.jpg', 4, 6, 6, 26),
(15, 'Edwin van der Sar', 'VanDerSar.jpg', 3, 1, 1, 35),
(16, 'Rio Ferdinand', 'Ferdinand.jpg', 3, 3, 5, 33),
(17, 'Wayne Rooney', 'Rooney.jpg', 3, 12, 10, 29),
(18, 'Park Ji-sung', 'ParkJiSung.png', 3, 5, 13, 28),
(19, 'Manuel Neuer', 'Neuer.jpg', 5, 1, 1, 30),
(20, 'Arjen Robben', 'Robben.jpg', 5, 11, 10, 30),
(21, 'David Alaba', 'Alaba.jpg', 5, 3, 27, 25),
(22, 'Thomas Müller', 'Müller.jpg', 5, 13, 25, 28);

-- --------------------------------------------------------

--
-- Struktur dari tabel `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `positions`
--

INSERT INTO `positions` (`id`, `name`) VALUES
(1, 'GK'),
(2, 'LB'),
(3, 'CB'),
(4, 'RB'),
(5, 'DM'),
(6, 'CM'),
(7, 'RMF'),
(8, 'LMF'),
(9, 'AM'),
(10, 'LW'),
(11, 'RW'),
(12, 'SS'),
(13, 'CF');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stadiums`
--

CREATE TABLE `stadiums` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stadiums`
--

INSERT INTO `stadiums` (`id`, `name`, `location`, `photo`) VALUES
(1, 'Santiago Bernabéu', ' Madrid', 'Santiago_Bernabeu.jpg'),
(2, 'Etihad Stadium', 'Manchester', 'Etihad_Stadium.jpg'),
(3, 'Old Trafford', 'Manchester', 'Old_Trafford.jpg'),
(4, 'Allianz Stadium', 'Turin', 'Allianz_Stadium.jpg'),
(5, 'Allianz Arena', 'Munich', 'Allianz_Arena.jpg'),
(6, 'Stamford Bridge', 'London', 'Stamford_Bridge.jpg'),
(7, 'Paris Le Parc des Princes', 'Paris', 'Paris_Le_Parc_des_Princes.jpg'),
(9, 'Signal Iduna Park', 'Dortmund', 'Signal_Iduna_Park.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stadium_id` (`stadium_id`);

--
-- Indeks untuk tabel `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_matches_home_club` (`home_club_id`),
  ADD KEY `fk_matches_away_club` (`away_club_id`);

--
-- Indeks untuk tabel `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indeks untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `stadiums`
--
ALTER TABLE `stadiums`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `stadiums`
--
ALTER TABLE `stadiums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `clubs`
--
ALTER TABLE `clubs`
  ADD CONSTRAINT `clubs_ibfk_1` FOREIGN KEY (`stadium_id`) REFERENCES `stadiums` (`id`);

--
-- Ketidakleluasaan untuk tabel `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `fk_matches_away_club` FOREIGN KEY (`away_club_id`) REFERENCES `clubs` (`id`),
  ADD CONSTRAINT `fk_matches_home_club` FOREIGN KEY (`home_club_id`) REFERENCES `clubs` (`id`);

--
-- Ketidakleluasaan untuk tabel `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  ADD CONSTRAINT `players_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
