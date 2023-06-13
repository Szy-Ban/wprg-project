-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 13, 2023 at 11:58 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wprg_project`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `agent_property`
--

CREATE TABLE `agent_property` (
  `agents_property_ID` int(11) NOT NULL,
  `Property_ID` int(11) NOT NULL,
  `Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`Client_ID`, `Password`, `First_name`, `Last_name`, `Email`, `Phone_number`, `role`, `Notes`) VALUES
(5, '$2y$10$EsZhX7fkkhFi2A.Jn7m4SuBsbYaKOUEPupvBJLKw3ywLMkyjdvqZ.', 'test2', 'test2', 'test2@szy.bani', 502502502, 'user', 'test2'),
(9, '$2y$10$pitfqAQD3ljOAgLnUtUHw.BGW2H7H0D08HFJv5mECpMUCVAUL74mW', 'Szymon', 'Baniewicz', 'test@szy.bani', 501501501, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client_property`
--

CREATE TABLE `client_property` (
  `client_property_ID` int(11) NOT NULL,
  `Property_ID` int(11) NOT NULL,
  `Client_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `commissions_rent`
--

CREATE TABLE `commissions_rent` (
  `Comission_ID` int(11) NOT NULL,
  `Rent_ID` int(11) NOT NULL,
  `Comission_rate` float(2,2) NOT NULL,
  `Profit` float(6,2) NOT NULL,
  `Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `commissions_sale`
--

CREATE TABLE `commissions_sale` (
  `Comission_ID` int(11) NOT NULL,
  `Sale_ID` int(11) NOT NULL,
  `Comission_rate` float(2,2) NOT NULL,
  `Profit` float(6,2) NOT NULL,
  `Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `features`
--

CREATE TABLE `features` (
  `Feature_ID` int(11) NOT NULL,
  `Feature_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`Feature_ID`, `Feature_type`) VALUES
(1, 'No additional features'),
(2, 'Dishwasher');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `features_description`
--

CREATE TABLE `features_description` (
  `ID` int(11) NOT NULL,
  `Property_Property_ID` int(11) NOT NULL,
  `Features_Feature_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features_description`
--

INSERT INTO `features_description` (`ID`, `Property_Property_ID`, `Features_Feature_ID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2);

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
  `Feature` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`Property_ID`, `Type`, `PType`, `City`, `Address`, `ZIP_Code`, `Square_meters`, `nr_rooms`, `nr_bedrooms`, `nr_bathrooms`, `Feature`, `Description`, `Price`) VALUES
(1, b'0', 'Apartment', 'Sopot', 'Malarzy 3/14', '84-204', 57, 6, 2, 1, 1, 'Testowe mieszkanie', 51000),
(2, b'1', 'Apartment', 'Warszawa', 'Kliniczna 11', '85-302', 87, 6, 4, 2, 1, 'Warszawski apartament', 5000.5),
(3, b'0', 'House', 'Sopot', 'Chlebowa 13', '85-310', 123, 8, 3, 2, 2, 'Testowy domek', 320000);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `Agent_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_property`
--
ALTER TABLE `agent_property`
  MODIFY `agents_property_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `Client_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `client_property`
--
ALTER TABLE `client_property`
  MODIFY `client_property_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commissions_rent`
--
ALTER TABLE `commissions_rent`
  MODIFY `Comission_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commissions_sale`
--
ALTER TABLE `commissions_sale`
  MODIFY `Comission_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `Feature_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `features_description`
--
ALTER TABLE `features_description`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `Property_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `Rent_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `Sale_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent_property`
--
ALTER TABLE `agent_property`
  ADD CONSTRAINT `Agent_property_Agents` FOREIGN KEY (`Agent_ID`) REFERENCES `agents` (`Agent_ID`),
  ADD CONSTRAINT `Agent_property_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`);

--
-- Constraints for table `client_property`
--
ALTER TABLE `client_property`
  ADD CONSTRAINT `Client_property_Clients` FOREIGN KEY (`Client_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `Client_property_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`);

--
-- Constraints for table `commissions_rent`
--
ALTER TABLE `commissions_rent`
  ADD CONSTRAINT `Comissions_Agents` FOREIGN KEY (`Agent_ID`) REFERENCES `agents` (`Agent_ID`),
  ADD CONSTRAINT `Comissions_Rent` FOREIGN KEY (`Rent_ID`) REFERENCES `rent` (`Rent_ID`);

--
-- Constraints for table `commissions_sale`
--
ALTER TABLE `commissions_sale`
  ADD CONSTRAINT `Commissions_Rent_Agents` FOREIGN KEY (`Agent_ID`) REFERENCES `agents` (`Agent_ID`),
  ADD CONSTRAINT `Commissions_Sale_Sale` FOREIGN KEY (`Sale_ID`) REFERENCES `sale` (`Sale_ID`);

--
-- Constraints for table `features_description`
--
ALTER TABLE `features_description`
  ADD CONSTRAINT `Feature_test_Features` FOREIGN KEY (`Features_Feature_ID`) REFERENCES `features` (`Feature_ID`),
  ADD CONSTRAINT `Feature_test_Property` FOREIGN KEY (`Property_Property_ID`) REFERENCES `property` (`Property_ID`);

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `Rent_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`),
  ADD CONSTRAINT `Renter_ID` FOREIGN KEY (`Tenant_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `Tenat_ID` FOREIGN KEY (`Renter_ID`) REFERENCES `clients` (`Client_ID`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `Sale_Buyer` FOREIGN KEY (`Seller_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `Sale_Property` FOREIGN KEY (`Property_ID`) REFERENCES `property` (`Property_ID`),
  ADD CONSTRAINT `Sale_Seller` FOREIGN KEY (`Buyer_ID`) REFERENCES `clients` (`Client_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
