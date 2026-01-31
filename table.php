<?php

include_once "../config.php";
$db = mysqli_connect('localhost', $databaseUser, $databasePass, $databaseName);
#==# table creaator #==#
mysqli_multi_query($db,"CREATE TABLE `user` (
    `row` int(11) AUTO_INCREMENT PRIMARY KEY,
    `from_id` varchar(20) NOT NULL,
    `step` varchar(50) NOT NULL DEFAULT 'none',
    `downloads` int(20) NOT NULL DEFAULT 0,
    `getFile` varchar(255) NOT NULL,
    `spam` text NULL,
    `update_at` bigint NULL
)CHARSET = utf8mb4 COLLATE = utf8mb4_bin
");
mysqli_multi_query($db,"CREATE TABLE `file` (
  `row` int(11) AUTO_INCREMENT PRIMARY KEY,
  `id` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `file_id` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `user_id` varchar(20) NOT NULL,
  `file_size` varchar(20) NOT NULL DEFAULT '',
  `downloads` int(11) NOT NULL DEFAULT 0,
  `date` char(200) NOT NULL,
  `time` char(200) NOT NULL
)CHARSET = utf8mb4 COLLATE = utf8mb4_bin
"); 
mysqli_multi_query($db,"CREATE TABLE `send` (
  `row` int(11) AUTO_INCREMENT PRIMARY KEY,
  `step` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `from` varchar(20) NOT NULL,
  `user` int(11) NOT NULL DEFAULT 0
)CHARSET = utf8mb4 COLLATE = utf8mb4_bin
");
mysqli_multi_query($db,"CREATE TABLE `settings` (
    `id` int(11) AUTO_INCREMENT PRIMARY KEY,
    `type` varchar(50) NOT NULL,
    `type_id` longtext NULL,
    `columnOne` longtext NULL,
    `columnTwo` longtext NULL
)CHARSET = utf8mb4 COLLATE = utf8mb4_bin
");
mysqli_multi_query($db,"CREATE TABLE `del` (
    `row` int(11) AUTO_INCREMENT PRIMARY KEY,
    `id` varchar(11) NOT NULL DEFAULT '',
    `from_id` varchar(15) NOT NULL DEFAULT '',
    `message_id` varchar(20) NOT NULL DEFAULT '',
    `timeDel` bigint NOT NULL
  )CHARSET = utf8mb4 COLLATE = utf8mb4_bin
");