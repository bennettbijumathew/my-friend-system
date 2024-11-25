CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `friend_email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `profile_name` varchar(30) NOT NULL,
  `date_started` date NOT NULL,
  `num_of_friends` int(10) UNSIGNED DEFAULT NULL
);

ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`);

ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

CREATE TABLE `myfriends` (
  `friend_id1` int(11) NOT NULL,
  `friend_id2` int(11) NOT NULL
);

ALTER TABLE `myfriends`
  ADD KEY `friend_id1` (`friend_id1`),
  ADD KEY `friend_id2` (`friend_id2`);

ALTER TABLE `myfriends`
  ADD CONSTRAINT `myfriends_ibfk_1` FOREIGN KEY (`friend_id1`) REFERENCES `friends` (`friend_id`),
  ADD CONSTRAINT `myfriends_ibfk_2` FOREIGN KEY (`friend_id2`) REFERENCES `friends` (`friend_id`);
COMMIT;

