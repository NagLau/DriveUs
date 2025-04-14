-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3307
-- Létrehozás ideje: 2025. Már 24. 13:02
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

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

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(50) NOT NULL,
  `jelszo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `arlista`
--

CREATE TABLE `arlista` (
  `arId` int(11) NOT NULL,
  `jarmuAz` int(11) DEFAULT NULL,
  `kezdet` datetime DEFAULT NULL,
  `vege` datetime DEFAULT NULL,
  `ar` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `arlista`
--

INSERT INTO `arlista` (`arId`, `jarmuAz`, `kezdet`, `vege`, `ar`) VALUES
(1, 1, '2025-04-01 00:00:00', '2025-04-30 23:59:59', 12000),
(2, 2, '2025-05-01 00:00:00', '2025-05-31 23:59:59', 20000),
(3, 3, '2025-06-01 00:00:00', '2025-06-30 23:59:59', 10000),
(4, 4, '2025-07-01 00:00:00', '2025-07-31 23:59:59', 18000),
(5, 5, '2025-08-01 00:00:00', '2025-08-31 23:59:59', 20000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `auto_allapot`
--

CREATE TABLE `auto_allapot` (
  `jarmuAz` int(11) NOT NULL,
  `ELOTTE_allapot` text DEFAULT NULL,
  `UTANA_allapot` text DEFAULT NULL,
  `idopont` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `auto_allapot`
--

INSERT INTO `auto_allapot` (`jarmuAz`, `ELOTTE_allapot`, `UTANA_allapot`, `idopont`) VALUES
(1, 'Tiszta, sérülésmentes', 'Kis karcolás az ajtón', '2025-03-30 18:00:00'),
(2, 'Tiszta, sérülésmentes', 'Tiszta, sérülésmentes', '2025-04-05 17:00:00'),
(3, 'Tiszta, sérülésmentes', 'Tiszta, sérülésmentes', '2025-04-15 16:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `berlok`
--

CREATE TABLE `berlok` (
  `felhAz` char(8) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `szemelyiigszam` varchar(8) NOT NULL,
  `jogositvanyszam` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `berlok`
--

INSERT INTO `berlok` (`felhAz`, `nev`, `szemelyiigszam`, `jogositvanyszam`) VALUES
('A001', 'Kovács Péter', '123456AB', 'HU123456'),
('A002', 'Nagy Anna', '654321CD', 'HU654321'),
('A003', 'Szabó István', '987654EF', 'HU987654');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fizetesek`
--

CREATE TABLE `fizetesek` (
  `fizetesId` int(11) NOT NULL,
  `felhAz` char(8) DEFAULT NULL,
  `fizetesi_mod` varchar(20) DEFAULT NULL,
  `osszeg` double DEFAULT NULL,
  `fizetes_datum` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `fizetesek`
--

INSERT INTO `fizetesek` (`fizetesId`, `felhAz`, `fizetesi_mod`, `osszeg`, `fizetes_datum`) VALUES
(1, 'A001', 'Bankkártya', 15000, '2025-03-22 10:00:00'),
(2, 'A002', 'Készpénz', 25000, '2025-03-23 14:30:00'),
(3, 'A003', 'Bankkártya', 12000, '2025-04-01 09:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `foglaltautok`
--

CREATE TABLE `foglaltautok` (
  `foglalt_auto` int(11) NOT NULL,
  `foglalo` char(8) NOT NULL,
  `foglalas_kezdete` datetime DEFAULT NULL,
  `foglalas_vege` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `foglaltautok`
--

INSERT INTO `foglaltautok` (`foglalt_auto`, `foglalo`, `foglalas_kezdete`, `foglalas_vege`) VALUES
(1, 'A001', '2025-03-25 08:00:00', '2025-03-30 18:00:00'),
(2, 'A002', '2025-04-01 09:00:00', '2025-04-05 17:00:00'),
(3, 'A003', '2025-04-10 10:00:00', '2025-04-15 16:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `karbantartas`
--

CREATE TABLE `karbantartas` (
  `utolso_szervizeles` datetime NOT NULL,
  `jarmuAZ` int(11) DEFAULT NULL,
  `allapota` text DEFAULT NULL,
  `muszaki_vizsga_lejarat` datetime DEFAULT NULL,
  `biztositas` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `karbantartas`
--

INSERT INTO `karbantartas` (`utolso_szervizeles`, `jarmuAZ`, `allapota`, `muszaki_vizsga_lejarat`, `biztositas`) VALUES
('2024-12-01 09:00:00', 1, 'Kiváló', '2026-12-01 00:00:00', '2025-12-01 00:00:00'),
('2024-11-15 08:00:00', 2, 'Jó', '2026-11-15 00:00:00', '2025-11-15 00:00:00'),
('2024-10-20 10:00:00', 3, 'Kiváló', '2026-10-20 00:00:00', '2025-10-20 00:00:00'),
('2024-09-05 09:00:00', 4, 'Jó', '2026-09-05 00:00:00', '2025-09-05 00:00:00'),
('2024-08-15 08:00:00', 5, 'Kiváló', '2026-08-15 00:00:00', '2025-08-15 00:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kolcsonozhetoautok`
--

CREATE TABLE `kolcsonozhetoautok` (
  `jarmuAz` int(11) NOT NULL,
  `rendszam` varchar(10) NOT NULL,
  `marka` varchar(255) NOT NULL,
  `modell` varchar(255) NOT NULL,
  `evjarat` int(4) NOT NULL,
  `uzemanyag` varchar(20) NOT NULL,
  `szin` varchar(20) DEFAULT NULL,
  `hengerur` double NOT NULL,
  `kolcsonzesiAr` double NOT NULL,
  `telephelyId` int(11) DEFAULT NULL,
  `ulesekSzama` int(2) DEFAULT NULL,
  `tipus` varchar(50) DEFAULT NULL,
  `kategoria` varchar(50) DEFAULT NULL,
  `statusz` enum('szabad','foglalt','karbantartas') DEFAULT 'szabad',
  `kep_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kolcsonozhetoautok`
--

INSERT INTO `kolcsonozhetoautok` (`jarmuAz`, `rendszam`, `marka`, `modell`, `evjarat`, `uzemanyag`, `szin`, `hengerur`, `kolcsonzesiAr`, `telephelyId`, `ulesekSzama`, `tipus`, `kategoria`, `statusz`, `kep_url`) VALUES
(1, 'ABC123', 'Toyota', 'Corolla', 2020, 'Benzin', 'Fehér', 1.8, 15000, 1, 5, 'Sedan', 'Személyautó', 'szabad', 'https://drive.google.com/file/d/1cRQqGvNtPpNBYZCQgE_7em7Q4SVEzJ2M/view?usp=sharing'),
(2, 'XYZ789', 'BMW', 'X5', 2022, 'Dízel', 'Fekete', 3, 25000, 2, 7, 'SUV', 'Személyautó', 'foglalt', 'https://drive.google.com/file/d/1TDSbuEFB0LSmnM228hvXGTzSWW50iLvO/view?usp=sharing'),
(3, 'DEF456', 'Volkswagen', 'Golf', 2019, 'Benzin', 'Kék', 1.4, 12000, 1, 5, 'Hatchback', 'Személyautó', 'szabad', 'https://drive.google.com/file/d/1HSkMZX7aT-tGw4S8f-zTrG7epmfxMx7n/view?usp=sharing'),
(4, 'GHI789', 'Audi', 'A4', 2021, 'Dízel', 'Ezüst', 2, 20000, 3, 5, 'Sedan', 'Személyautó', 'szabad', 'https://drive.google.com/file/d/1iUuTSH0nb53-7Sj_UK7o0Nd-c3wi6xiE/view?usp=sharing'),
(5, 'JKL012', 'Mercedes', 'C-Class', 2023, 'Benzin', 'Fekete', 2, 22000, 2, 5, 'Sedan', 'Személyautó', 'foglalt', 'https://drive.google.com/file/d/1afRNbvARIxkfnTQOixZHK_KjFkzRCHEW/view?usp=sharing'),
(6, 'MNO345', 'Ford', 'Focus', 2018, 'Benzin', 'Piros', 1.6, 11000, 1, 5, 'Hatchback', 'Személyautó', 'szabad', 'https://drive.google.com/file/d/1xuSqlvpoVpjRQFFIlvzh5jIzZYga8ccq/view?usp=sharing'),
(7, 'PQR678', 'Hyundai', 'Tucson', 2020, 'Dízel', 'Fehér', 1.6, 18000, 3, 5, 'SUV', 'Személyautó', 'foglalt', 'https://drive.google.com/file/d/1KwW3ZuYbpoM7LtBH8mH2AbSylGxzLEQK/view?usp=sharing'),
(8, 'STU901', 'Skoda', 'Octavia', 2021, 'Benzin', 'Zöld', 1.5, 14000, 2, 5, 'Sedan', 'Személyautó', 'szabad', 'https://drive.google.com/file/d/1cZs0MrsJpqxA1_8avTTiIuRjte3iLlrh/view?usp=sharing'),
(9, 'VWX234', 'Kia', 'Sportage', 2022, 'Hibrid', 'Szürke', 1.6, 19000, 1, 5, 'SUV', 'Személyautó', 'szabad', 'https://drive.google.com/file/d/1MPpt2hbXgznf1emU4-rzKFdQgVZjQtIo/view?usp=sharing'),
(10, 'YZA567', 'Tesla', 'Model 3', 2023, 'Elektromos', 'Fekete', 0, 30000, 3, 5, 'Sedan', 'Személyautó', 'foglalt', 'https://drive.google.com/file/d/1jJhzStSRySpuwJvcnEU5nWmpt_sUzVzZ/view?usp=sharing');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `regisztraltfelhasznalok`
--

CREATE TABLE `regisztraltfelhasznalok` (
  `felhAz` char(8) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `telefonszam` varchar(15) NOT NULL,
  `e_mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `regisztraltfelhasznalok`
--

INSERT INTO `regisztraltfelhasznalok` (`felhAz`, `nev`, `jelszo`, `telefonszam`, `e_mail`) VALUES
('A001', 'Kovács Péter', 'titkos123', '+36701234567', 'kovacs.peter@email.com'),
('A002', 'Nagy Anna', 'jelszo456', '+36709876543', 'nagy.anna@email.com'),
('A003', 'Szabó István', 'pass789', '+36701112233', 'szabo.istvan@email.com');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `telephelyek`
--

CREATE TABLE `telephelyek` (
  `telephelyId` int(11) NOT NULL,
  `nev` varchar(255) DEFAULT NULL,
  `cim` varchar(255) DEFAULT NULL,
  `telefonszam` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `telephelyek`
--

INSERT INTO `telephelyek` (`telephelyId`, `nev`, `cim`, `telefonszam`) VALUES
(1, 'Budapest', '1051 Budapest, Kossuth tér 1.', '+3612345678'),
(2, 'Debrecen', '4024 Debrecen, Piac utca 10.', '+3652123456'),
(3, 'Szeged', '6720 Szeged, Tisza Lajos krt. 1.', '+3662123456');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `arlista`
--
ALTER TABLE `arlista`
  ADD PRIMARY KEY (`arId`),
  ADD KEY `jarmuAz` (`jarmuAz`);

--
-- A tábla indexei `auto_allapot`
--
ALTER TABLE `auto_allapot`
  ADD PRIMARY KEY (`jarmuAz`);

--
-- A tábla indexei `berlok`
--
ALTER TABLE `berlok`
  ADD PRIMARY KEY (`felhAz`);

--
-- A tábla indexei `fizetesek`
--
ALTER TABLE `fizetesek`
  ADD PRIMARY KEY (`fizetesId`),
  ADD KEY `felhAz` (`felhAz`);

--
-- A tábla indexei `foglaltautok`
--
ALTER TABLE `foglaltautok`
  ADD KEY `foglalt_auto` (`foglalt_auto`),
  ADD KEY `fk_foglaltautok_berlok` (`foglalo`);

--
-- A tábla indexei `karbantartas`
--
ALTER TABLE `karbantartas`
  ADD KEY `jarmuAZ` (`jarmuAZ`);

--
-- A tábla indexei `kolcsonozhetoautok`
--
ALTER TABLE `kolcsonozhetoautok`
  ADD PRIMARY KEY (`jarmuAz`),
  ADD KEY `telephelyId` (`telephelyId`);

--
-- A tábla indexei `regisztraltfelhasznalok`
--
ALTER TABLE `regisztraltfelhasznalok`
  ADD PRIMARY KEY (`felhAz`),
  ADD UNIQUE KEY `telefonszam` (`telefonszam`),
  ADD UNIQUE KEY `e_mail` (`e_mail`);

--
-- A tábla indexei `telephelyek`
--
ALTER TABLE `telephelyek`
  ADD PRIMARY KEY (`telephelyId`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `arlista`
--
ALTER TABLE `arlista`
  MODIFY `arId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `auto_allapot`
--
ALTER TABLE `auto_allapot`
  MODIFY `jarmuAz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `fizetesek`
--
ALTER TABLE `fizetesek`
  MODIFY `fizetesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `kolcsonozhetoautok`
--
ALTER TABLE `kolcsonozhetoautok`
  MODIFY `jarmuAz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `telephelyek`
--
ALTER TABLE `telephelyek`
  MODIFY `telephelyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `arlista`
--
ALTER TABLE `arlista`
  ADD CONSTRAINT `arlista_ibfk_1` FOREIGN KEY (`jarmuAz`) REFERENCES `kolcsonozhetoautok` (`jarmuAz`);

--
-- Megkötések a táblához `auto_allapot`
--
ALTER TABLE `auto_allapot`
  ADD CONSTRAINT `auto_allapot_ibfk_1` FOREIGN KEY (`jarmuAz`) REFERENCES `foglaltautok` (`foglalt_auto`);

--
-- Megkötések a táblához `berlok`
--
ALTER TABLE `berlok`
  ADD CONSTRAINT `fk_berlok_felhasznalo` FOREIGN KEY (`felhAz`) REFERENCES `regisztraltfelhasznalok` (`felhAz`);

--
-- Megkötések a táblához `fizetesek`
--
ALTER TABLE `fizetesek`
  ADD CONSTRAINT `fizetesek_ibfk_1` FOREIGN KEY (`felhAz`) REFERENCES `berlok` (`felhAz`);

--
-- Megkötések a táblához `foglaltautok`
--
ALTER TABLE `foglaltautok`
  ADD CONSTRAINT `fk_foglaltautok_berlok` FOREIGN KEY (`foglalo`) REFERENCES `berlok` (`felhAz`),
  ADD CONSTRAINT `foglaltautok_ibfk_1` FOREIGN KEY (`foglalt_auto`) REFERENCES `kolcsonozhetoautok` (`jarmuAz`),
  ADD CONSTRAINT `foglaltautok_ibfk_2` FOREIGN KEY (`foglalo`) REFERENCES `berlok` (`felhAz`);

--
-- Megkötések a táblához `karbantartas`
--
ALTER TABLE `karbantartas`
  ADD CONSTRAINT `karbantartas_ibfk_1` FOREIGN KEY (`jarmuAZ`) REFERENCES `kolcsonozhetoautok` (`jarmuAz`);

--
-- Megkötések a táblához `kolcsonozhetoautok`
--
ALTER TABLE `kolcsonozhetoautok`
  ADD CONSTRAINT `kolcsonozhetoautok_ibfk_1` FOREIGN KEY (`telephelyId`) REFERENCES `telephelyek` (`telephelyId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
