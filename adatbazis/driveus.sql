-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Már 27. 11:54
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
  `adminFelhAz` int(8) NOT NULL,
  `felhasznaloNev` varchar(255) NOT NULL,
  `jelszo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `berlesi_elozmenyek`
--

CREATE TABLE `berlesi_elozmenyek` (
  `Az` int(11) NOT NULL,
  `felhAz` int(8) NOT NULL,
  `jarmuAz` int(11) NOT NULL,
  `berles_kezd` datetime NOT NULL,
  `berles_vege` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalofiokok`
--

CREATE TABLE `felhasznalofiokok` (
  `felhAz` int(8) NOT NULL,
  `teljesNev` varchar(255) NOT NULL,
  `szemIgSzam` varchar(8) NOT NULL,
  `jogositvanySzam` varchar(8) NOT NULL,
  `eMail` varchar(255) NOT NULL,
  `telSzam` varchar(20) NOT NULL,
  `felhaszNev` varchar(255) NOT NULL,
  `jelszo` varchar(20) NOT NULL,
  `tagsag` enum('új tag','arany','ezüst','bronz') DEFAULT 'új tag'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fizetesi_mod`
--

CREATE TABLE `fizetesi_mod` (
  `Az` int(11) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `fizetesi_mod` varchar(20) DEFAULT NULL,
  `osszeg` double DEFAULT NULL,
  `fizetes_datum` datetime NOT NULL DEFAULT current_timestamp(),
  `felhAz` int(8) NOT NULL,
  `teljesNev` varchar(255) NOT NULL,
  `kartyaSzam` int(19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmuvek`
--

CREATE TABLE `jarmuvek` (
  `jarmuAz` int(11) NOT NULL,
  `rendszam` varchar(10) NOT NULL,
  `marka` varchar(255) NOT NULL,
  `modell` varchar(255) NOT NULL,
  `evjarat` int(4) NOT NULL,
  `uzemanyag` varchar(20) NOT NULL,
  `szin` varchar(20) DEFAULT NULL,
  `hengerur` double NOT NULL,
  `kolcsonzesiAr` double NOT NULL,
  `ulesekSzama` int(2) NOT NULL,
  `tipus` varchar(50) NOT NULL,
  `kategoria` varchar(50) NOT NULL,
  `allapot` enum('rendben','sérült','piszkos') DEFAULT 'rendben',
  `telephelyAz` int(11) NOT NULL,
  `kep_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmuvek_elerhetosegi_allapot`
--

CREATE TABLE `jarmuvek_elerhetosegi_allapot` (
  `Az` int(11) NOT NULL,
  `jarmuAz` int(11) NOT NULL,
  `statusz` enum('szabad','foglalt','karbantartas') DEFAULT 'szabad',
  `foglaltsag_kezd` datetime NOT NULL,
  `foglaltsag_vege` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `karbantartas`
--

CREATE TABLE `karbantartas` (
  `Az` int(11) NOT NULL,
  `karbantartoAz` int(11) NOT NULL,
  `allapot` enum('kész','javítás alatt','várakozik') DEFAULT 'várakozik',
  `javitas_ok` text NOT NULL,
  `cim` varchar(255) DEFAULT NULL,
  `utolso_szervizeles` datetime NOT NULL,
  `jarmuAZ` int(11) DEFAULT NULL,
  `muszaki_vizsga_lejarat` datetime DEFAULT NULL,
  `biztositas` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `karbantarto`
--

CREATE TABLE `karbantarto` (
  `Az` int(11) NOT NULL,
  `teljesNev` varchar(255) NOT NULL,
  `szemIgSzam` varchar(8) NOT NULL,
  `telSzam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepek`
--

CREATE TABLE `kepek` (
  `Az` int(11) NOT NULL,
  `kep_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `telephelyek`
--

CREATE TABLE `telephelyek` (
  `Az` int(11) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `cim` varchar(255) NOT NULL,
  `telSzam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

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
  MODIFY `adminFelhAz` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `berlesi_elozmenyek`
--
ALTER TABLE `berlesi_elozmenyek`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `felhasznalofiokok`
--
ALTER TABLE `felhasznalofiokok`
  MODIFY `felhAz` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `fizetesi_mod`
--
ALTER TABLE `fizetesi_mod`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  MODIFY `jarmuAz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `jarmuvek_elerhetosegi_allapot`
--
ALTER TABLE `jarmuvek_elerhetosegi_allapot`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `karbantartas`
--
ALTER TABLE `karbantartas`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `karbantarto`
--
ALTER TABLE `karbantarto`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kepek`
--
ALTER TABLE `kepek`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `telephelyek`
--
ALTER TABLE `telephelyek`
  MODIFY `Az` int(11) NOT NULL AUTO_INCREMENT;

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
