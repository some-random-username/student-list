CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(300) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(300) CHARACTER SET utf8 NOT NULL,
  `groupnum` varchar(4) CHARACTER SET utf8 NOT NULL,
  `gender` enum('male','female') CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ege` int(3) NOT NULL,
  `birth` year(4) NOT NULL,
  `local` enum('local','foreign') CHARACTER SET utf8 NOT NULL,
  `salt` varchar(33) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
