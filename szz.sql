-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Apr 03, 2024 at 08:26 AM
-- Wersja serwera: 8.2.0
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `szz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `statusy`
--

CREATE TABLE `statusy` (
  `id` int NOT NULL,
  `nazwa` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `statusy`
--

INSERT INTO `statusy` (`id`, `nazwa`) VALUES
(1, 'nierozpoczęte'),
(2, 'w trakcie'),
(3, 'wykonane');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uprawnienia`
--

CREATE TABLE `uprawnienia` (
  `id` int NOT NULL,
  `nazwa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `uprawnienia`
--

INSERT INTO `uprawnienia` (`id`, `nazwa`) VALUES
(1, 'user'),
(2, 'pracownik'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `login` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `upr` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`login`, `username`, `password`, `upr`) VALUES
('a', 'a', '0cc175b9c0f1b6a831c399e269772661', 1),
('admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 3),
('prac', 'pracownik', '598fe4e3dfb7a94fb94c1b0502ca3d1c', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `id` int NOT NULL,
  `tytul` text NOT NULL,
  `opis` text NOT NULL,
  `status` int NOT NULL,
  `user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pracownik` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `data` date NOT NULL,
  `archiwizowane` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `zadania`
--

INSERT INTO `zadania` (`id`, `tytul`, `opis`, `status`, `user`, `pracownik`, `data`, `archiwizowane`) VALUES
(2, 'test', 'bardzo długi opis', 1, 'a', 'admin', '2024-03-20', 0),
(3, 'abc', 'abc', 1, 'admin', 'admin', '2024-03-26', 1),
(4, 'test', '2', 1, 'admin', NULL, '2024-03-27', 0),
(5, 'test', 'd', 1, 'c', NULL, '2024-03-27', 0),
(6, 'test', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(7, 'test', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', 'admin', '2024-03-27', 0),
(8, 'nowe', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(9, 'nowe', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', 'admin', '2024-03-27', 0),
(10, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(11, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(12, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(13, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(14, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(15, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(16, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(17, 'a', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?', 1, 'admin', NULL, '2024-03-27', 0),
(21, 'h', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam qui velit autem neque atque! Dolorem eius quaerat, aperiam obcaecati repellat mollitia non, ad optio reiciendis iure pariatur omnis deleniti nihil?\n\n', 1, 'admin', 'c', '2024-04-03', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `statusy`
--
ALTER TABLE `statusy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uprawnienia`
--
ALTER TABLE `uprawnienia`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`);

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `statusy`
--
ALTER TABLE `statusy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uprawnienia`
--
ALTER TABLE `uprawnienia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zadania`
--
ALTER TABLE `zadania`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
