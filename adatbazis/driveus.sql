-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 06. 18:17
-- Kiszolgáló verziója: 8.0.39
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `driveus`
--
CREATE DATABASE IF NOT EXISTS `driveus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
USE `driveus`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `adminFelhAz` int NOT NULL,
  `felhasznaloNev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `jelszo` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `admin`
--

INSERT INTO `admin` (`adminFelhAz`, `felhasznaloNev`, `jelszo`) VALUES
(1, 'admin', '$2y$12$kP2mW5qT8uY3eL9nJ5xY2kQ6mR3tU7vW4xY8zA0bC1dF6gH9iJ');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `berlesi_elozmenyek`
--

DROP TABLE IF EXISTS `berlesi_elozmenyek`;
CREATE TABLE `berlesi_elozmenyek` (
  `Az` int NOT NULL,
  `felhAz` int NOT NULL,
  `jarmuAz` int NOT NULL,
  `berles_kezd` datetime NOT NULL,
  `berles_vege` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `berlesi_elozmenyek`
--

INSERT INTO `berlesi_elozmenyek` (`Az`, `felhAz`, `jarmuAz`, `berles_kezd`, `berles_vege`) VALUES
(1, 1, 1, '2025-03-01 09:00:00', '2025-03-03 17:00:00'),
(2, 2, 2, '2025-03-05 10:00:00', '2025-03-07 18:00:00'),
(3, 3, 3, '2025-03-10 08:00:00', '2025-03-12 16:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalofiokok`
--

DROP TABLE IF EXISTS `felhasznalofiokok`;
CREATE TABLE `felhasznalofiokok` (
  `felhAz` int NOT NULL,
  `teljesNev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `szemIgSzam` varchar(8) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `jogositvanySzam` varchar(8) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `eMail` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `telSzam` varchar(20) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `felhaszNev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `jelszo` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `tagsag` enum('új tag','arany','ezüst','bronz') COLLATE utf8mb3_hungarian_ci DEFAULT 'új tag'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalofiokok`
--

INSERT INTO `felhasznalofiokok` (`felhAz`, `teljesNev`, `szemIgSzam`, `jogositvanySzam`, `eMail`, `telSzam`, `felhaszNev`, `jelszo`, `tagsag`) VALUES
(1, 'Kovács Péter', '123456AB', '789012CD', 'kovacs.peter@email.com', '+36201234567', 'peterk', '$2y$12$z8e5X9v2k5Q7mP0rT3uW8e2bXjY9kL5nM4qR8tU2vW3xY9zA1bC', 'arany'),
(2, 'Nagy Anna', '654321BA', '210987DC', 'nagy.anna@email.com', '+36309876543', 'annan', '$2y$12$a4bR7vX9kP2mW5qT8uY3eL9nJ5xY2kQ6mR3tU7vW4xY8zA0bC', 'ezüst'),
(3, 'Szabó Tamás', '987654CB', '456789EF', 'szabo.tamas@email.com', '+36701231234', 'tamassz', '$2y$12$x9kP2mW5qT8uY3eL9nJ5xY2kQ6mR3tU7vW4xY8zA0bC1dF6gH', 'új tag');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fizetesi_mod`
--

DROP TABLE IF EXISTS `fizetesi_mod`;
CREATE TABLE `fizetesi_mod` (
  `Az` int NOT NULL,
  `nev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `fizetesi_mod` varchar(20) COLLATE utf8mb3_hungarian_ci DEFAULT NULL,
  `osszeg` double DEFAULT NULL,
  `fizetes_datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `felhAz` int NOT NULL,
  `teljesNev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `kartyaSzam` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `fizetesi_mod`
--

INSERT INTO `fizetesi_mod` (`Az`, `nev`, `fizetesi_mod`, `osszeg`, `fizetes_datum`, `felhAz`, `teljesNev`, `kartyaSzam`) VALUES
(1, 'Kovács Péter', 'Kártya', 300000, '2025-03-01 09:00:00', 1, 'Kovács Péter', 123456789),
(2, 'Nagy Anna', 'Kártya', 160000, '2025-03-05 10:00:00', 2, 'Nagy Anna', 65432109),
(3, 'Szabó Tamás', 'Készpénz', 400000, '2025-03-10 08:00:00', 3, 'Szabó Tamás', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmuvek`
--

DROP TABLE IF EXISTS `jarmuvek`;
CREATE TABLE `jarmuvek` (
  `jarmuAz` int NOT NULL,
  `rendszam` varchar(10) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `marka` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `modell` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `evjarat` int NOT NULL,
  `uzemanyag` varchar(20) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `szin` varchar(20) COLLATE utf8mb3_hungarian_ci DEFAULT NULL,
  `hengerur` double NOT NULL,
  `kolcsonzesiAr` double NOT NULL,
  `ulesekSzama` int NOT NULL,
  `kategoria` varchar(50) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `allapot` enum('rendben','sérült','piszkos') COLLATE utf8mb3_hungarian_ci DEFAULT 'rendben',
  `telephelyAz` int NOT NULL,
  `kep_url` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `jarmuvek`
--

INSERT INTO `jarmuvek` (`jarmuAz`, `rendszam`, `marka`, `modell`, `evjarat`, `uzemanyag`, `szin`, `hengerur`, `kolcsonzesiAr`, `ulesekSzama`, `kategoria`, `allapot`, `telephelyAz`, `kep_url`) VALUES
(1, 'ABC123', 'Lamborghini', 'Huracán STO', 2021, 'Benzin', 'Kék', 5.2, 150000, 2, 'Kupé', 'rendben', 1, 'image1.jpg'),
(2, 'DEF456', 'Toyota', 'GR Supra Tuned', 2020, 'Benzin', 'Fehér', 3, 80000, 2, 'Kupé', 'rendben', 1, 'image2.jpg'),
(3, 'GHI789', 'Mercedes-Maybach', 'S-Class Brabus', 2021, 'Benzin', 'Fekete', 4, 200000, 5, 'Szedán', 'rendben', 1, 'image3.jpg'),
(4, 'JKL012', 'Acura', 'TLX Type S Tuned', 2021, 'Benzin', 'Ezüst', 3, 60000, 5, 'Szedán', 'rendben', 1, 'image4.jpg'),
(5, 'MNO345', 'Mercedes-Benz', 'SLC 43 AMG Tuned', 2017, 'Benzin', 'Fekete', 3, 70000, 2, 'Kabrió', 'rendben', 1, 'image5.jpg'),
(6, 'PQR678', 'Fiat', '124 Spider Abarth', 2017, 'Benzin', 'Fehér', 1.4, 40000, 2, 'Kabrió', 'rendben', 1, 'image6.jpg'),
(7, 'STU901', 'Aston Martin', 'Valkyrie AMR Pro', 2022, 'Benzin', 'Ezüst', 6.5, 300000, 2, 'Kupé', 'rendben', 1, 'image7.jpg'),
(8, 'VWX234', 'Jeep', 'Grand Cherokee Trackhawk Tuned', 2022, 'Benzin', 'Fehér', 6.2, 90000, 5, 'SUV', 'rendben', 1, 'image8.jpg'),
(9, 'YZA567', 'Rolls-Royce', 'Phantom V Modernized', 1965, 'Benzin', 'Ezüst', 6.2, 250000, 5, 'Szedán', 'rendben', 1, 'image9.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmuvek_elerhetosegi_allapot`
--

DROP TABLE IF EXISTS `jarmuvek_elerhetosegi_allapot`;
CREATE TABLE `jarmuvek_elerhetosegi_allapot` (
  `Az` int NOT NULL,
  `jarmuAz` int NOT NULL,
  `statusz` enum('szabad','foglalt','karbantartas') COLLATE utf8mb3_hungarian_ci DEFAULT 'szabad',
  `foglaltsag_kezd` datetime NOT NULL,
  `foglaltsag_vege` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `jarmuvek_elerhetosegi_allapot`
--

INSERT INTO `jarmuvek_elerhetosegi_allapot` (`Az`, `jarmuAz`, `statusz`, `foglaltsag_kezd`, `foglaltsag_vege`) VALUES
(1, 1, 'szabad', '2025-03-03 17:00:00', '2025-03-03 17:00:00'),
(2, 2, 'szabad', '2025-03-07 18:00:00', '2025-03-07 18:00:00'),
(3, 3, 'szabad', '2025-03-12 16:00:00', '2025-03-12 16:00:00'),
(4, 4, 'szabad', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
(5, 5, 'szabad', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
(6, 6, 'szabad', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
(7, 7, 'szabad', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
(8, 8, 'szabad', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
(9, 9, 'szabad', '2025-01-01 00:00:00', '2025-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `karbantartas`
--

DROP TABLE IF EXISTS `karbantartas`;
CREATE TABLE `karbantartas` (
  `Az` int NOT NULL,
  `karbantartoAz` int NOT NULL,
  `allapot` enum('kész','javítás alatt','várakozik') COLLATE utf8mb3_hungarian_ci DEFAULT 'várakozik',
  `javitas_ok` text COLLATE utf8mb3_hungarian_ci NOT NULL,
  `cim` varchar(255) COLLATE utf8mb3_hungarian_ci DEFAULT NULL,
  `utolso_szervizeles` datetime NOT NULL,
  `jarmuAZ` int DEFAULT NULL,
  `muszaki_vizsga_lejarat` datetime DEFAULT NULL,
  `biztositas` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `karbantartas`
--

INSERT INTO `karbantartas` (`Az`, `karbantartoAz`, `allapot`, `javitas_ok`, `cim`, `utolso_szervizeles`, `jarmuAZ`, `muszaki_vizsga_lejarat`, `biztositas`) VALUES
(1, 1, 'kész', 'Olajcsere és fékellenőrzés', '1149 Budapest, Egressy út 17.', '2025-02-15 14:00:00', 1, '2026-02-15 00:00:00', '2025-12-31 00:00:00'),
(2, 2, 'javítás alatt', 'Kipufogó csere', '1149 Budapest, Egressy út 17.', '2025-03-20 09:00:00', 2, '2026-03-20 00:00:00', '2025-12-31 00:00:00'),
(3, 1, 'várakozik', 'Festés javítás', '1149 Budapest, Egressy út 17.', '2025-03-25 11:00:00', 3, '2026-03-25 00:00:00', '2025-12-31 00:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `karbantarto`
--

DROP TABLE IF EXISTS `karbantarto`;
CREATE TABLE `karbantarto` (
  `Az` int NOT NULL,
  `teljesNev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `szemIgSzam` varchar(8) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `telSzam` varchar(20) COLLATE utf8mb3_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `karbantarto`
--

INSERT INTO `karbantarto` (`Az`, `teljesNev`, `szemIgSzam`, `telSzam`) VALUES
(1, 'Horváth István', '111222CC', '+36207654321'),
(2, 'Tóth László', '333444DD', '+36301239876');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepek`
--

DROP TABLE IF EXISTS `kepek`;
CREATE TABLE `kepek` (
  `Az` int NOT NULL,
  `kep_url` varchar(255) COLLATE utf8mb3_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `kepek`
--

INSERT INTO `kepek` (`Az`, `kep_url`) VALUES
(1, 'https://drive.google.com/file/d/19fW6Gl8a6-lGm9jQfgEP5mWRtKyfaJ4Y/view?usp=drive_link'),
(2, 'https://drive.google.com/file/d/1ybKW2B0HUwRyP0Hmi95vHbrXJmnbQ8G0/view?usp=drive_link'),
(3, 'https://drive.google.com/file/d/1VG9HGj1jHx9RvFxIIZ-LZMWf0UEfsz_I/view?usp=drive_link'),
(4, 'https://drive.google.com/file/d/1nXMpyLS4HMx3VTUGihRLR2YQBoDn132V/view?usp=drive_link'),
(5, 'https://drive.google.com/file/d/1N4kvH91mrCDppMIKa8iF2xhlwsgZ1nJw/view?usp=drive_link'),
(6, 'https://drive.google.com/file/d/1Yw3xCSufLjbPr6NG29K1kQ46Gp93z4-X/view?usp=drive_link'),
(7, 'https://drive.google.com/file/d/1ZjO-yg5-sFFwj102KWyO60IQ6laINDIU/view?usp=drive_link'),
(8, 'https://drive.google.com/file/d/18XxBDfec4Mk7AxfDvgz-hflKlUQ_v6wI/view?usp=drive_link'),
(9, 'https://drive.google.com/file/d/19O1Jrdqd6yAKToC8L63tVxZyt5ieMckF/view?usp=drive_link'),
(10, 'https://drive.google.com/file/d/1tnEyYf2rg-wcEyNxxX0r64D2aaHNJpUo/view?usp=drive_link'),
(11, 'https://drive.google.com/file/d/1M_TSMtc9YL12N1vE7mEPIfYi8P4J2Cb3/view?usp=drive_link'),
(12, 'https://drive.google.com/file/d/16yRuThDI14RcE75IiwbNrYRE0ImMaXNi/view?usp=drive_link'),
(13, 'https://drive.google.com/file/d/1vhAM8Wf6N-ZlgnouZQC_4dhG42LMOoul/view?usp=drive_link'),
(14, 'https://drive.google.com/file/d/1Zz6HgKeWrpESYTApBhkEjxQSXGcx2CEV/view?usp=drive_link'),
(15, 'https://drive.google.com/file/d/1kNdinnw09gF4lkEWXVmJFLoF4hPgv6RN/view?usp=drive_link'),
(16, 'https://drive.google.com/file/d/1auTPiEnrmLNx_nCVAYwJiEWxLip72x4m/view?usp=drive_link'),
(17, 'https://drive.google.com/file/d/1fCdqyxVEcovX4uPMXMN6ZZI_wEYctsTh/view?usp=drive_link'),
(18, 'https://drive.google.com/file/d/1BqHmrBWg6YPokzecKyPfYN0qOtUWGEql/view?usp=drive_link'),
(19, 'https://drive.google.com/file/d/1coKVZ3ahqtd46G__m1-kSOT5Gg7CzJf_/view?usp=drive_link'),
(20, 'https://drive.google.com/file/d/1Q3OIUx1b5sxRphj3c23YFUdNSHGYZJKl/view?usp=drive_link'),
(21, 'https://drive.google.com/file/d/1TLndPhQ84SzfV3LCxcvxOEQ9VHCshZmb/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `telephelyek`
--

DROP TABLE IF EXISTS `telephelyek`;
CREATE TABLE `telephelyek` (
  `Az` int NOT NULL,
  `nev` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `cim` varchar(255) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `telSzam` varchar(20) COLLATE utf8mb3_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `telephelyek`
--

INSERT INTO `telephelyek` (`Az`, `nev`, `cim`, `telSzam`) VALUES
(1, 'DriveUs Budapest', '1149 Budapest, Egressy út 17.', '+3612345678');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminFelhAz`);

--
-- A tábla indexei `berlesi_elozmenyek`
--
ALTER TABLE `berlesi_elozmenyek`
  ADD PRIMARY KEY (`Az`),
  ADD KEY `felhAz` (`felhAz`),
  ADD KEY `jarmuAz` (`jarmuAz`);

--
-- A tábla indexei `felhasznalofiokok`
--
ALTER TABLE `felhasznalofiokok`
  ADD PRIMARY KEY (`felhAz`),
  ADD UNIQUE KEY `szemIgSzam` (`szemIgSzam`),
  ADD UNIQUE KEY `jogositvanySzam` (`jogositvanySzam`),
  ADD UNIQUE KEY `felhaszNev` (`felhaszNev`);

--
-- A tábla indexei `fizetesi_mod`
--
ALTER TABLE `fizetesi_mod`
  ADD PRIMARY KEY (`Az`),
  ADD KEY `felhAz` (`felhAz`);

--
-- A tábla indexei `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD PRIMARY KEY (`jarmuAz`),
  ADD KEY `telephelyAz` (`telephelyAz`);

--
-- A tábla indexei `jarmuvek_elerhetosegi_allapot`
--
ALTER TABLE `jarmuvek_elerhetosegi_allapot`
  ADD PRIMARY KEY (`Az`),
  ADD KEY `jarmuAz` (`jarmuAz`);

--
-- A tábla indexei `karbantartas`
--
ALTER TABLE `karbantartas`
  ADD PRIMARY KEY (`Az`),
  ADD KEY `karbantartoAz` (`karbantartoAz`),
  ADD KEY `jarmuAZ` (`jarmuAZ`);

--
-- A tábla indexei `karbantarto`
--
ALTER TABLE `karbantarto`
  ADD PRIMARY KEY (`Az`),
  ADD UNIQUE KEY `szemIgSzam` (`szemIgSzam`);

--
-- A tábla indexei `kepek`
--
ALTER TABLE `kepek`
  ADD PRIMARY KEY (`Az`);

--
-- A tábla indexei `telephelyek`
--
ALTER TABLE `telephelyek`
  ADD PRIMARY KEY (`Az`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `admin`
--
ALTER TABLE `admin`
  MODIFY `adminFelhAz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `berlesi_elozmenyek`
--
ALTER TABLE `berlesi_elozmenyek`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `felhasznalofiokok`
--
ALTER TABLE `felhasznalofiokok`
  MODIFY `felhAz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `fizetesi_mod`
--
ALTER TABLE `fizetesi_mod`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  MODIFY `jarmuAz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `jarmuvek_elerhetosegi_allapot`
--
ALTER TABLE `jarmuvek_elerhetosegi_allapot`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `karbantartas`
--
ALTER TABLE `karbantartas`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `karbantarto`
--
ALTER TABLE `karbantarto`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `kepek`
--
ALTER TABLE `kepek`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `telephelyek`
--
ALTER TABLE `telephelyek`
  MODIFY `Az` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `berlesi_elozmenyek`
--
ALTER TABLE `berlesi_elozmenyek`
  ADD CONSTRAINT `berlesi_elozmenyek_ibfk_1` FOREIGN KEY (`felhAz`) REFERENCES `felhasznalofiokok` (`felhAz`),
  ADD CONSTRAINT `berlesi_elozmenyek_ibfk_2` FOREIGN KEY (`jarmuAz`) REFERENCES `jarmuvek` (`jarmuAz`);

--
-- Megkötések a táblához `fizetesi_mod`
--
ALTER TABLE `fizetesi_mod`
  ADD CONSTRAINT `fizetesi_mod_ibfk_1` FOREIGN KEY (`felhAz`) REFERENCES `felhasznalofiokok` (`felhAz`);

--
-- Megkötések a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD CONSTRAINT `jarmuvek_ibfk_1` FOREIGN KEY (`telephelyAz`) REFERENCES `telephelyek` (`Az`);

--
-- Megkötések a táblához `jarmuvek_elerhetosegi_allapot`
--
ALTER TABLE `jarmuvek_elerhetosegi_allapot`
  ADD CONSTRAINT `jarmuvek_elerhetosegi_allapot_ibfk_1` FOREIGN KEY (`jarmuAz`) REFERENCES `jarmuvek` (`jarmuAz`);

--
-- Megkötések a táblához `karbantartas`
--
ALTER TABLE `karbantartas`
  ADD CONSTRAINT `karbantartas_ibfk_1` FOREIGN KEY (`karbantartoAz`) REFERENCES `karbantarto` (`Az`),
  ADD CONSTRAINT `karbantartas_ibfk_2` FOREIGN KEY (`jarmuAZ`) REFERENCES `jarmuvek` (`jarmuAz`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
