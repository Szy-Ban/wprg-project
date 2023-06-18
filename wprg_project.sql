-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Cze 2023, 01:39
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wprg_project`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `agents`
--

CREATE TABLE `agents` (
  `Agent_ID` int(11) NOT NULL,
  `First_name` varchar(255) NOT NULL,
  `Last_name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `agents`
--

INSERT INTO `agents` (`Agent_ID`, `First_name`, `Last_name`, `Email`, `Phone_number`) VALUES
(1, 'Janusz', 'Kowalski', 'januszK@szy.bani', '601601601'),
(2, 'Borys', 'Maslel', 'borysM@szy.bani', '602602602'),
(6, 'Mariusz', 'Kolanowski', 'mariuszK@szy.bani', '987402382'),
(7, 'Piotr', 'Grusza', 'piotrG@szy.bani', '786893783');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `agent_property`
--

CREATE TABLE `agent_property` (
  `agents_property_ID` int(11) NOT NULL,
  `Property_ID` int(11) NOT NULL,
  `Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `agent_property`
--

INSERT INTO `agent_property` (`agents_property_ID`, `Property_ID`, `Agent_ID`) VALUES
(3, 1, 1),
(4, 3, 2),
(5, 4, 6),
(7, 6, 7),
(8, 7, 7);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `clients`
--

CREATE TABLE `clients` (
  `Client_ID` int(11) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `First_name` varchar(255) NOT NULL,
  `Last_name` varchar(255) NOT NULL,
  `Email` text NOT NULL,
  `Phone_number` int(11) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `Notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `clients`
--

INSERT INTO `clients` (`Client_ID`, `Password`, `First_name`, `Last_name`, `Email`, `Phone_number`, `role`, `Notes`) VALUES
(9, '$2y$10$pitfqAQD3ljOAgLnUtUHw.BGW2H7H0D08HFJv5mECpMUCVAUL74mW', 'Szymon', 'Baniewicz', 'test@szy.bani', 501501501, 'admin', 'admin'),
(10, '$2y$10$XWVv8s82Z0UahXgs6o2.EeEZpb/xV5wI14FwLpxHpD3uOm5yLmP9y', 'Szymon', 'Baniewicz', 'admin@szy.bani', 111111111, 'admin', 'Szymon Baniewicz'),
(11, '$2y$10$IsEMM4fFDed6aCzhHJdEgOzt/TQVpWXxa1sWme41o654cGApcbhBW', 'Katarzyna', 'Sowa', 'katarzynaS@szy.bani', 440390290, 'user', 'Lubie domki'),
(12, '$2y$10$PHsQPkHf7HEWMQrS1pX2o.9XZckk5uCuPDHh6ajIJCyVthmjeGDxy', 'Czesiu', 'Drut', 'czesiuD@szy.bani', 470200293, 'user', 'Lubie apartamenty'),
(13, '$2y$10$pLShTYyubCk5205cDt461uUnSZsBkuD3bZ/iAdY0V8kvYKoKsaM8a', 'Dobromir', 'Czartoryski', 'dobromirC@szy.bani', 480303020, 'user', 'Sprzedaje domy'),
(14, '$2y$10$VSRxnbC2nkEq082QN3W2uOsbjQHutLza0aBXQy74VeBwXATE3ZtKa', 'Kazik', 'Rzeka', 'kazikR@szy.bani', 123456789, 'user', 'Sprzedaje apartamenty'),
(16, '$2y$10$dJx1JUfSr6/OMwKWH7ZNfesQX6a0RFTmrQKvB3JkZwn8SE1jmXmlu', 'Mariusz', 'Koleczko', 'mariuszK@szy.bani', 444444444, 'user', 'Wynajmuje domy i apartamenty'),
(17, '$2y$10$Vgld0yy55eDZKKZEipCDPOTM91eZBOj4pM3Uy.xJUXS8UFdSNU4nS', 'Ryszard', 'Bala', 'RyszardB@szy.bani', 333333333, 'user', 'Chce gdzies mieszkac'),
(18, '$2y$10$l37J9YjnomhyduLlKK16Ue4CAEuoqgtIrXDfAjQSaBU.41YWAdOla', 'Maria', 'Rock', 'mariaR@szy.bani', 555555555, 'user', 'Szuka domu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client_property`
--

CREATE TABLE `client_property` (
  `client_property_ID` int(11) NOT NULL,
  `Property_ID` int(11) NOT NULL,
  `Client_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `client_property`
--

INSERT INTO `client_property` (`client_property_ID`, `Property_ID`, `Client_ID`) VALUES
(1, 1, 14),
(2, 2, 16),
(3, 3, 13),
(4, 4, 16),
(5, 5, 14),
(6, 6, 16),
(7, 7, 13);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `commissions_rent`
--

CREATE TABLE `commissions_rent` (
  `Comission_ID` int(11) NOT NULL,
  `Rent_ID` int(11) NOT NULL,
  `Comission_rate` float(4,2) NOT NULL,
  `Profit` float(6,2) NOT NULL,
  `Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `commissions_rent`
--

INSERT INTO `commissions_rent` (`Comission_ID`, `Rent_ID`, `Comission_rate`, `Profit`, `Agent_ID`) VALUES
(2, 3, 10.00, 500.00, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `commissions_sale`
--

CREATE TABLE `commissions_sale` (
  `Comission_ID` int(11) NOT NULL,
  `Sale_ID` int(11) NOT NULL,
  `Comission_rate` float(4,2) NOT NULL,
  `Profit` float(6,2) NOT NULL,
  `Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `commissions_sale`
--

INSERT INTO `commissions_sale` (`Comission_ID`, `Sale_ID`, `Comission_rate`, `Profit`, `Agent_ID`) VALUES
(6, 3, 10.00, 4500.00, 7),
(7, 4, 13.00, 6700.00, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `features`
--

CREATE TABLE `features` (
  `Feature_ID` int(11) NOT NULL,
  `Feature_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `features`
--

INSERT INTO `features` (`Feature_ID`, `Feature_type`) VALUES
(2, 'Dishwasher'),
(3, 'Stunning location'),
(4, 'Garage'),
(5, 'Pool'),
(6, 'Balcony'),
(7, 'Patio'),
(8, 'Solar pannels');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `features_description`
--

CREATE TABLE `features_description` (
  `ID` int(11) NOT NULL,
  `Property_Property_ID` int(11) NOT NULL,
  `Features_Feature_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `features_description`
--

INSERT INTO `features_description` (`ID`, `Property_Property_ID`, `Features_Feature_ID`) VALUES
(3, 3, 2),
(4, 3, 3),
(5, 2, 5),
(6, 6, 7),
(7, 3, 6),
(8, 1, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `property`
--

CREATE TABLE `property` (
  `Property_ID` int(11) NOT NULL,
  `Type` bit(1) NOT NULL,
  `PType` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ZIP_Code` varchar(255) NOT NULL,
  `Square_meters` float NOT NULL,
  `nr_rooms` int(11) NOT NULL,
  `nr_bedrooms` int(11) NOT NULL,
  `nr_bathrooms` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `property`
--

INSERT INTO `property` (`Property_ID`, `Type`, `PType`, `City`, `Address`, `ZIP_Code`, `Square_meters`, `nr_rooms`, `nr_bedrooms`, `nr_bathrooms`, `Description`, `Price`) VALUES
(1, b'0', 'Apartment', 'Sopot', 'Malarzy 3/14', '84-204', 57, 6, 2, 1, 'Testowe mieszkanie', 51000),
(2, b'1', 'Apartment', 'Warszawa', 'Kliniczna 11', '85-302', 87, 6, 4, 2, 'Warszawski apartament', 5000.5),
(3, b'0', 'House', 'Sopot', 'Chlebowa 13', '85-310', 123, 8, 3, 2, 'Testowy domek', 320000),
(4, b'0', 'House', 'Gdynia', 'Józefa 15', '76-393', 45, 3, 1, 1, 'Maly domek. Ladna okolica', 120000),
(5, b'1', 'Apartment', 'Bojano', 'Boska 18/3', '79-392', 65, 4, 1, 1, 'Duzy apartament na wsi', 7400),
(6, b'1', 'House', 'Warszawa', 'Górnicza 4', '54-493', 98, 7, 2, 2, 'Duzy dom w centrum Warszawy', 9230),
(7, b'0', 'House', 'Warszawa', 'Hutnicza 10', '54-302', 150, 9, 3, 3, 'Willa w centrum', 430000);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rent`
--

CREATE TABLE `rent` (
  `Rent_ID` int(11) NOT NULL,
  `Property_ID` int(11) NOT NULL,
  `Renter_ID` int(11) NOT NULL,
  `Tenant_ID` int(11) NOT NULL,
  `Monthly_rent` varchar(255) NOT NULL,
  `Lease_term` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `rent`
--

INSERT INTO `rent` (`Rent_ID`, `Property_ID`, `Renter_ID`, `Tenant_ID`, `Monthly_rent`, `Lease_term`) VALUES
(3, 2, 16, 18, '5000.5', '3 months');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE `sale` (
  `Sale_ID` int(11) NOT NULL,
  `Property_ID` int(11) NOT NULL,
  `Sale_price` varchar(255) NOT NULL,
  `Date` varchar(255) NOT NULL,
  `Buyer_ID` int(11) NOT NULL,
  `Seller_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `sale`
--

INSERT INTO `sale` (`Sale_ID`, `Property_ID`, `Sale_price`, `Date`, `Buyer_ID`, `Seller_ID`) VALUES
(3, 7, '430000', '19.06.2023', 11, 13),
(4, 4, '120000', '17.06.2023', 18, 16);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`Agent_ID`);

--
-- Indeksy dla tabeli `agent_property`
--
ALTER TABLE `agent_property`
  ADD PRIMARY KEY (`agents_property_ID`),
  ADD KEY `Agent_property_Agents` (`Agent_ID`),
  ADD KEY `Agent_property_Property` (`Property_ID`);

--
-- Indeksy dla tabeli `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`Client_ID`);

--
-- Indeksy dla tabeli `client_property`
--
ALTER TABLE `client_property`
  ADD PRIMARY KEY (`client_property_ID`),
  ADD KEY `Client_property_Clients` (`Client_ID`),
  ADD KEY `Client_property_Property` (`Property_ID`);

--
-- Indeksy dla tabeli `commissions_rent`
--
ALTER TABLE `commissions_rent`
  ADD PRIMARY KEY (`Comission_ID`),
  ADD KEY `Comissions_Agents` (`Agent_ID`),
  ADD KEY `Comissions_Rent` (`Rent_ID`);

--
-- Indeksy dla tabeli `commissions_sale`
--
ALTER TABLE `commissions_sale`
  ADD PRIMARY KEY (`Comission_ID`),
  ADD KEY `Commissions_Rent_Agents` (`Agent_ID`),
  ADD KEY `Commissions_Sale_Sale` (`Sale_ID`);

--
-- Indeksy dla tabeli `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`Feature_ID`);

--
-- Indeksy dla tabeli `features_description`
--
ALTER TABLE `features_description`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Feature_test_Features` (`Features_Feature_ID`),
  ADD KEY `Feature_test_Property` (`Property_Property_ID`);

--
-- Indeksy dla tabeli `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`Property_ID`);

--
-- Indeksy dla tabeli `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`Rent_ID`),
  ADD KEY `Rent_Property` (`Property_ID`),
  ADD KEY `Renter_ID` (`Tenant_ID`),
  ADD KEY `Tenat_ID` (`Renter_ID`);

--
-- Indeksy dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`Sale_ID`),
  ADD KEY `Sale_Buyer` (`Seller_ID`),
  ADD KEY `Sale_Property` (`Property_ID`),
  ADD KEY `Sale_Seller` (`Buyer_ID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `agents`
--
ALTER TABLE `agents`
  MODIFY `Agent_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `agent_property`
--
ALTER TABLE `agent_property`
  MODIFY `agents_property_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `clients`
--
ALTER TABLE `clients`
  MODIFY `Client_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `client_property`
--
ALTER TABLE `client_property`
  MODIFY `client_property_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `commissions_rent`
--
ALTER TABLE `commissions_rent`
  MODIFY `Comission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `commissions_sale`
--
ALTER TABLE `commissions_sale`
  MODIFY `Comission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `features`
--
ALTER TABLE `features`
  MODIFY `Feature_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `features_description`
--
ALTER TABLE `features_description`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `property`
--
ALTER TABLE `property`
  MODIFY `Property_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `rent`
--
ALTER TABLE `rent`
  MODIFY `Rent_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `sale`
--
ALTER TABLE `sale`
  MODIFY `Sale_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `agent_property`
--
ALTER TABLE `agent_property`
  ADD CONSTRAINT `Agent_property_Agents` FOREIGN KEY (`Agent_ID`) REFERENCES `agents` (`Agent_ID`),
  ADD CONSTRAINT `Agent_property_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`);

--
-- Ograniczenia dla tabeli `client_property`
--
ALTER TABLE `client_property`
  ADD CONSTRAINT `Client_property_Clients` FOREIGN KEY (`Client_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `Client_property_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`);

--
-- Ograniczenia dla tabeli `commissions_rent`
--
ALTER TABLE `commissions_rent`
  ADD CONSTRAINT `Comissions_Agents` FOREIGN KEY (`Agent_ID`) REFERENCES `agents` (`Agent_ID`),
  ADD CONSTRAINT `Comissions_Rent` FOREIGN KEY (`Rent_ID`) REFERENCES `rent` (`Rent_ID`);

--
-- Ograniczenia dla tabeli `commissions_sale`
--
ALTER TABLE `commissions_sale`
  ADD CONSTRAINT `Commissions_Rent_Agents` FOREIGN KEY (`Agent_ID`) REFERENCES `agents` (`Agent_ID`),
  ADD CONSTRAINT `Commissions_Sale_Sale` FOREIGN KEY (`Sale_ID`) REFERENCES `sale` (`Sale_ID`);

--
-- Ograniczenia dla tabeli `features_description`
--
ALTER TABLE `features_description`
  ADD CONSTRAINT `Feature_test_Features` FOREIGN KEY (`Features_Feature_ID`) REFERENCES `features` (`Feature_ID`),
  ADD CONSTRAINT `Feature_test_Property` FOREIGN KEY (`Property_Property_ID`) REFERENCES `property` (`Property_ID`);

--
-- Ograniczenia dla tabeli `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `Rent_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`),
  ADD CONSTRAINT `Renter_ID` FOREIGN KEY (`Tenant_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `Tenat_ID` FOREIGN KEY (`Renter_ID`) REFERENCES `clients` (`Client_ID`);

--
-- Ograniczenia dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `Sale_Buyer` FOREIGN KEY (`Seller_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `Sale_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`),
  ADD CONSTRAINT `Sale_Seller` FOREIGN KEY (`Buyer_ID`) REFERENCES `clients` (`Client_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
