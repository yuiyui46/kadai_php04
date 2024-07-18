-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql657.db.sakura.ne.jp
-- 生成日時: 2024 年 7 月 18 日 10:20
-- サーバのバージョン： 5.7.40-log
-- PHP のバージョン: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs1_kadai_php01`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `hashed_id` varchar(64) NOT NULL,
  `request_type` varchar(100) NOT NULL,
  `request_content` varchar(500) NOT NULL,
  `timestamp` timestamp(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user_data`
--

INSERT INTO `user_data` (`id`, `username`, `hashed_id`, `request_type`, `request_content`, `timestamp`) VALUES
(23, 'YO', '0', '2回目以降：からだの相談', 'めまいがする', '2024-07-16 13:45:33.000000'),
(24, 'YO', '0', '2回目以降：コーチング', 'あいうえお', '2024-07-16 15:11:44.000000'),
(28, '1234', '0', '2回目以降：からだの相談', '頭痛', '2024-07-16 15:36:41.000000'),
(29, 'mizukitest', '0', '新規：からだの相談', 'aaa', '2024-07-17 01:43:02.000000'),
(34, '山田', '0', '新規：コーチング', '123', '2024-07-17 09:23:00.000000'),
(35, '大山', '1', '2回目以降：こころの相談', '眠い', '2024-07-17 09:34:00.000000'),
(37, '山田', '0', '新規：からだの相談', 'a', '2024-07-17 09:53:00.000000'),
(38, '武田', '0', '2回目以降：からだの相談', '頭痛', '2024-07-17 09:55:00.000000'),
(39, '武田', '0', '新規：コーチング', '頭痛', '2024-07-17 09:55:00.000000'),
(42, '太田', 'ad48ff99415b2f007dc35b7eb553fd1eb35ebfa2f2f308acd9488eeb86f71fa8', '2回目以降：こころの相談', '悩み', '2024-07-17 10:08:00.000000'),
(46, '1234', '', '2回目以降：こころの相談', 'a', '2024-07-17 10:27:00.000000'),
(47, 'r', 'd6d824abba4afde81129c71dea75b8100e96338da5f416d2f69088f1960cb091', '2回目以降：からだの相談', 'b', '2024-07-17 10:29:00.000000'),
(48, '山田', '', '2回目以降：コーチング', '相談', '2024-07-17 10:36:00.000000'),
(55, 'TO', '454f63ac30c8322997ef025edff6abd23e0dbe7b8a3d5126a894e4a168c1b59b', '新規：コーチング', '相談業で起業しようと思っているが何から始めて良いのか分からない\r\n借金生活から抜け出したい\r\n親の介護生活で悩みがある\r\n仕事をやめようと思っているが先の計画や当てがない\r\n特定の選択肢で悩んでいる\r\n自分の納得いく答えが欲しい\r\n目標に向けて生産的に取り組んでいきたい', '2024-07-17 16:22:00.000000'),
(56, '竹田', 'f369cb89fc627e668987007d121ed1eacdc01db9e28f8bb26f358b7d8c4f08ac', '新規：こころの相談', '相談業で起業しようと思っているが何から始めて良いのか分からない 借金生活から抜け出したい 親の介護生活で悩みがある 仕事をやめようと思っているが先の計画や当てがない 特定の選択肢で悩んでいる 自分の納得いく答えが欲しい 目標に向けて生産的に取り組んでいきたい\r\n相談業で起業しようと思っているが何から始めて良いのか分からない 借金生活から抜け出したい 親の介護生活で悩みがある 仕事をやめようと思っているが先の計画や当てがない 特定の選択肢で悩んでいる 自分の納得いく答えが欲しい 目標に向けて生産的に取り組んでいきたい', '2024-07-17 18:32:00.000000');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
