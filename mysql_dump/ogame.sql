-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2007 at 04:30 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `razio_ogame`
--

-- --------------------------------------------------------

--
-- Table structure for table `ugml_alliance`
--

CREATE TABLE `ugml_alliance` (
  `id` int(11) NOT NULL auto_increment,
  `ally_name` varchar(32) default '',
  `ally_tag` varchar(8) default '',
  `ally_owner` int(11) NOT NULL default '0',
  `ally_register_time` int(11) NOT NULL default '0',
  `ally_description` text,
  `ally_web` varchar(255) default '',
  `ally_text` text,
  `ally_image` varchar(255) default '',
  `ally_request` text,
  `ally_request_waiting` text,
  `ally_request_notallow` tinyint(4) NOT NULL default '0',
  `ally_owner_range` varchar(32) default '',
  `ally_ranks` text,
  `ally_members` int(11) NOT NULL default '0',
  `ally_points` bigint(20) NOT NULL default '0',
  `ally_points_builds` int(11) NOT NULL default '0',
  `ally_points_fleet` int(11) NOT NULL default '0',
  `ally_points_tech` int(11) NOT NULL default '0',
  `ally_points_builds_old` int(11) NOT NULL default '0',
  `ally_points_fleet_old` int(11) NOT NULL default '0',
  `ally_points_tech_old` int(11) NOT NULL default '0',
  `ally_members_points` int(11) NOT NULL default '0',
  `ally_points_fleet2` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `ugml_alliance`
--

INSERT INTO `ugml_alliance` VALUES(131, 'Lolz', 'Lol', 910, 1193687478, NULL, '', NULL, '', NULL, NULL, 0, 'Kurucu', NULL, 1, 0, 82000, 0, 0, 0, 216500, 1000, 0, 142);

-- --------------------------------------------------------

--
-- Table structure for table `ugml_banned`
--

CREATE TABLE `ugml_banned` (
  `id` int(11) NOT NULL auto_increment,
  `who` varchar(11) NOT NULL default '',
  `theme` text NOT NULL,
  `who2` varchar(11) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  `longer` int(11) NOT NULL default '0',
  `author` varchar(11) NOT NULL default '',
  `email` varchar(20) NOT NULL default '',
  KEY `ID` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ugml_banned`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_buddy`
--

CREATE TABLE `ugml_buddy` (
  `id` int(11) NOT NULL auto_increment,
  `sender` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `active` tinyint(3) NOT NULL default '0',
  `text` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `ugml_buddy`
--

INSERT INTO `ugml_buddy` VALUES(60, 910, 909, 0, 'lolz');

-- --------------------------------------------------------

--
-- Table structure for table `ugml_config`
--

CREATE TABLE `ugml_config` (
  `config_name` varchar(64) NOT NULL default '',
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugml_config`
--

INSERT INTO `ugml_config` VALUES('users_amount', '9');
INSERT INTO `ugml_config` VALUES('fleet_speed', '10000');
INSERT INTO `ugml_config` VALUES('flota_na_zlom', '30');
INSERT INTO `ugml_config` VALUES('obrona_na_zlom', '30');
INSERT INTO `ugml_config` VALUES('game_name', 'Ogame.uk.yo');
INSERT INTO `ugml_config` VALUES('resource_multiplier', '5');
INSERT INTO `ugml_config` VALUES('debug', '0');
INSERT INTO `ugml_config` VALUES('initial_fields', '163');
INSERT INTO `ugml_config` VALUES('metal_basic_income', '500');
INSERT INTO `ugml_config` VALUES('crystal_basic_income', '350');
INSERT INTO `ugml_config` VALUES('deuterium_basic_income', '200');
INSERT INTO `ugml_config` VALUES('energy_basic_income', '0');
INSERT INTO `ugml_config` VALUES('COOKIE_NAME', 'ugamela');
INSERT INTO `ugml_config` VALUES('allow_invetigate_while_lab_is_update', '0');
INSERT INTO `ugml_config` VALUES('copyright', 'Powered by Zoran.');
INSERT INTO `ugml_config` VALUES('id_g', '1');
INSERT INTO `ugml_config` VALUES('id_s', '4');
INSERT INTO `ugml_config` VALUES('id_p', '3');
INSERT INTO `ugml_config` VALUES('max_position', '15');
INSERT INTO `ugml_config` VALUES('game_speed', '10000');
INSERT INTO `ugml_config` VALUES('stats', 'Mon Jul 9 0:45:49 EEST 2007');
INSERT INTO `ugml_config` VALUES('max_galaxy', '9');
INSERT INTO `ugml_config` VALUES('max_system', '499');

-- --------------------------------------------------------

--
-- Table structure for table `ugml_errors`
--

CREATE TABLE `ugml_errors` (
  `error_id` int(11) NOT NULL auto_increment,
  `error_sender` varchar(32) NOT NULL default '0',
  `error_time` int(11) NOT NULL default '0',
  `error_type` varchar(32) NOT NULL default 'unknown',
  `error_text` text,
  PRIMARY KEY  (`error_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=162 ;

--
-- Dumping data for table `ugml_errors`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_fleets`
--

CREATE TABLE `ugml_fleets` (
  `fleet_id` int(11) NOT NULL auto_increment,
  `fleet_owner` int(11) NOT NULL default '0',
  `fleet_mission` int(11) NOT NULL default '0',
  `fleet_amount` int(11) NOT NULL default '0',
  `fleet_array` text,
  `fleet_start_time` int(11) NOT NULL default '0',
  `fleet_start_galaxy` int(11) NOT NULL default '0',
  `fleet_start_system` int(11) NOT NULL default '0',
  `fleet_start_planet` int(11) NOT NULL default '0',
  `fleet_start_type` int(11) NOT NULL default '0',
  `fleet_end_time` int(11) NOT NULL default '0',
  `fleet_end_galaxy` int(11) NOT NULL default '0',
  `fleet_end_system` int(11) NOT NULL default '0',
  `fleet_end_planet` int(11) NOT NULL default '0',
  `fleet_end_type` int(11) NOT NULL default '0',
  `fleet_resource_metal` int(11) NOT NULL default '0',
  `fleet_resource_crystal` int(11) NOT NULL default '0',
  `fleet_resource_deuterium` int(11) NOT NULL default '0',
  `fleet_ofiara` int(11) NOT NULL default '0',
  `fleet_mess` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fleet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=10704 ;

--
-- Dumping data for table `ugml_fleets`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_flota`
--

CREATE TABLE `ugml_flota` (
  `fleet_owner` varchar(11) NOT NULL default '',
  `fleet_amount` text NOT NULL,
  `fleet_array` text NOT NULL,
  `query` text NOT NULL,
  `fleet_list` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugml_flota`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_forum_cat`
--

CREATE TABLE `ugml_forum_cat` (
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `cat_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_name` varchar(150) default NULL,
  `forum_desc` text,
  `forum_status` tinyint(4) NOT NULL default '0',
  `forum_order` mediumint(8) unsigned NOT NULL default '1',
  `forum_posts` mediumint(8) unsigned NOT NULL default '0',
  `forum_topics` mediumint(8) unsigned NOT NULL default '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `prune_next` int(11) default NULL,
  `prune_enable` tinyint(1) NOT NULL default '0',
  `auth_view` tinyint(2) NOT NULL default '0',
  `auth_read` tinyint(2) NOT NULL default '0',
  `auth_post` tinyint(2) NOT NULL default '0',
  `auth_reply` tinyint(2) NOT NULL default '0',
  `auth_edit` tinyint(2) NOT NULL default '0',
  `auth_delete` tinyint(2) NOT NULL default '0',
  `auth_sticky` tinyint(2) NOT NULL default '0',
  `auth_announce` tinyint(2) NOT NULL default '0',
  `auth_vote` tinyint(2) NOT NULL default '0',
  `auth_pollcreate` tinyint(2) NOT NULL default '0',
  `auth_attachments` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugml_forum_cat`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_forum_categories`
--

CREATE TABLE `ugml_forum_categories` (
  `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_order` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ugml_forum_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_forum_posts`
--

CREATE TABLE `ugml_forum_posts` (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `poster_id` mediumint(8) NOT NULL default '0',
  `post_time` int(11) NOT NULL default '0',
  `poster_ip` varchar(8) NOT NULL default '',
  `post_username` varchar(25) default NULL,
  `enable_bbcode` tinyint(1) NOT NULL default '1',
  `enable_html` tinyint(1) NOT NULL default '0',
  `enable_smilies` tinyint(1) NOT NULL default '1',
  `enable_sig` tinyint(1) NOT NULL default '1',
  `post_edit_time` int(11) default NULL,
  `post_edit_count` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ugml_forum_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_forum_posts_text`
--

CREATE TABLE `ugml_forum_posts_text` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `bbcode_uid` varchar(10) NOT NULL default '',
  `post_subject` varchar(60) default NULL,
  `post_text` text,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugml_forum_posts_text`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_forum_topics`
--

CREATE TABLE `ugml_forum_topics` (
  `topic_id` mediumint(8) unsigned NOT NULL auto_increment,
  `forum_id` smallint(8) unsigned NOT NULL default '0',
  `topic_title` char(60) NOT NULL default '',
  `topic_poster` mediumint(8) NOT NULL default '0',
  `topic_time` int(11) NOT NULL default '0',
  `topic_views` mediumint(8) unsigned NOT NULL default '0',
  `topic_replies` mediumint(8) unsigned NOT NULL default '0',
  `topic_status` tinyint(3) NOT NULL default '0',
  `topic_vote` tinyint(1) NOT NULL default '0',
  `topic_type` tinyint(3) NOT NULL default '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ugml_forum_topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_galaxy`
--

CREATE TABLE `ugml_galaxy` (
  `galaxy` int(2) NOT NULL default '0',
  `system` int(3) NOT NULL default '0',
  `planet` int(2) NOT NULL default '0',
  `id_planet` int(11) NOT NULL default '0',
  `metal` int(11) NOT NULL default '0',
  `crystal` int(11) NOT NULL default '0',
  `id_luna` int(11) NOT NULL default '0',
  `luna` int(2) NOT NULL default '0',
  KEY `galaxy` (`galaxy`),
  KEY `system` (`system`),
  KEY `planet` (`planet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugml_galaxy`
--

INSERT INTO `ugml_galaxy` VALUES(1, 2, 4, 1971, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 2, 8, 1972, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 2, 12, 1973, 160345000, 127033000, 7, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 3, 12, 1979, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 2, 1, 1975, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 2, 2, 1976, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 3, 9, 1977, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 2, 9, 1978, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 3, 5, 1980, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 4, 12, 1981, 0, 0, 0, 0);
INSERT INTO `ugml_galaxy` VALUES(1, 4, 8, 1982, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ugml_lunas`
--

CREATE TABLE `ugml_lunas` (
  `id` int(11) NOT NULL auto_increment,
  `id_luna` int(11) NOT NULL default '0',
  `name` varchar(11) NOT NULL default 'Moon',
  `image` varchar(11) NOT NULL default 'mond',
  `destruyed` int(11) NOT NULL default '0',
  `id_owner` int(11) default NULL,
  `galaxy` int(11) default NULL,
  `system` int(11) default NULL,
  `lunapos` int(11) default NULL,
  `temp_min` int(11) NOT NULL default '0',
  `temp_max` int(11) NOT NULL default '0',
  `diameter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ugml_lunas`
--

INSERT INTO `ugml_lunas` VALUES(7, 1193698511, 'moon', 'mond', 0, 910, 1, 2, 12, -84, -57, 5818);

-- --------------------------------------------------------

--
-- Table structure for table `ugml_messages`
--

CREATE TABLE `ugml_messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `message_owner` int(11) NOT NULL default '0',
  `message_sender` int(11) NOT NULL default '0',
  `message_time` int(11) NOT NULL default '0',
  `message_type` int(11) NOT NULL default '0',
  `message_from` varchar(32) default NULL,
  `message_subject` varchar(32) default NULL,
  `message_text` text,
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33002 ;

--
-- Dumping data for table `ugml_messages`
--

INSERT INTO `ugml_messages` VALUES(32991, 910, 0, 1193698821, 0, 'Filo Lideri', 'Transport Raporu', 'Filo Hedefe Vardi hahah napadnite me [1:2:12] ve sukadar hammadde getirdi [Metal: 0 Kristal: 0 Deuterium: 7437]');
INSERT INTO `ugml_messages` VALUES(32979, 913, 0, 1193694687, 0, 'Filo Lideri', 'Casus Raporu', '<table width=440><tr><td class=c colspan=4> Casusluk: hahah napadnite me[1:2:12]29-10-2007 23:51:27</td></tr><tr><td>Metal:</td><td>109.512</td><td>Kristal:</td><td>94.003</td></tr> <tr><td>Deuterium:</td><td>994.638</td> <td>Enerji:</td><td>62.679</td></tr> </table><table width=440><tr><td class=c colspan=6>Filo</td></tr><td>Kucuk Tasima Gemisi</td><td>1</td><td>Buyuk Tasima Gemisi</td><td>50</td></tr><td>Kruvazor</td><td>50</td><td>Komuta Gemisi</td><td>50</td></tr><td>Koloni Gemisi</td><td>6</td><td>Geri Donusumcu</td><td>10</td></tr><td>Bombardiman Gemisi</td><td>50</td></tr><td>Savas Gemisi</td><td>50</td></tr> </table> <table width=440><tr><td class=c colspan=4>Savunma</td></tr><td>Roketatar</td><td>100</td><td>Kucuk Lazer</td><td>100</td></tr><td>Buyuk Lazer</td><td>100</td><td>Iyon Topu</td><td>50</td><td>Plazma Silahi</td><td>10</td></tr> </table> <table width=440><tr><td class=c colspan=6>Binalar</td></tr></tr><td>Metal Madeni</td><td>22</td><td>Kristal Madeni</td><td>22</td><td>Deuter Sentezleyici</td><td>22</td></tr><td>Solar Enerrji Santari</td><td>22</td><td>Fizyo Enerji Santrali</td><td>22</td><td>Robot Fabrikasi</td><td>22</td></tr><td>Nanit Fabrikasi</td><td>22</td><td>Tersane</td><td>22</td><td>Metal Deposu</td><td>22</td></tr><td>Kristal Deposu</td><td>22</td><td>Deuter Deposu</td><td>22</td><td>Laboratuar</td><td>22</td></tr><td>Terraformer</td><td>22</td><td>Firkateyn</td><td>10</td></tr></table><table width=440><tr><td class=c colspan=4>Arastirma   </td></tr></tr><td>Casus Teknolojisi</td><td>30</td><td>Bilgisayar Teknolojisi</td><td>30</td></tr><td>Silah Teknigi</td><td>30</td><td>Savunma Teknigi</td><td>30</td></tr><td>Zirhlanma</td><td>30</td><td>Enerji Teknigi</td><td>30</td></tr><td>Hiperuzay Teknigi</td><td>30</td><td>Motor Enerjisi Teknigi</td><td>30</td></tr><td>Yanmali Motor Takimi</td><td>30</td><td>Hiperuzay iticisi</td><td>30</td></tr><td>Lazer Teknigi</td><td>30</td><td>Iyon Teknigi</td><td>30</td></tr><td>Plazma Teknigi</td><td>30</td><td>Galaksiler Arasi Arastirma</td><td>30</td></tr><td>Gravitasyon Tekngi</td><td>30</td></table><br>  <center> Yok Etme Sansi: 39% <br><b><font color="red">Yok Edildi</font></b></center> </td> </tr>');
INSERT INTO `ugml_messages` VALUES(32992, 910, 0, 1193699059, 0, 'Filo Lideri', 'Transport Raporu', 'Filo Hedefe Vardi hahah napadnite me [1:2:12] ve sukadar hammadde getirdi [Metal: 1 Kristal: 0 Deuterium: 0]');
INSERT INTO `ugml_messages` VALUES(32981, 913, 0, 1193696490, 0, 'Filo Lideri', 'Savas', '<a class="thickbox" href="rw.php?raport=6a2d43fb0d64ad2826bf4d98d68f8c75&keepThis=true&TB_iframe=true&height=400&width=500"><font color="red">Filo Raporu [1:2:12] (V:394000,A:3500000)</font></a>');
INSERT INTO `ugml_messages` VALUES(32993, 910, 0, 1193699072, 0, 'Filo Lideri', 'Transport Raporu', 'Filo Hedefe Vardi hahah napadnite me [1:2:12] Fakat Hammmadde Getirmedi');
INSERT INTO `ugml_messages` VALUES(32983, 913, 0, 1193697028, 0, 'Filo Lideri', 'Savas', '<a class="thickbox" href="rw.php?raport=58fe874e67309dcb5bf9c516e8a43928&keepThis=true&TB_iframe=true&height=400&width=500"><font color="red">Filo Raporu [1:2:12] (V:22000,A:500000)</font></a>');
INSERT INTO `ugml_messages` VALUES(32995, 910, 0, 1193918414, 0, 'Filo Lideri', 'Filo (Casusluk)', 'Diger Gezegenin Filosu hehehe [1:4:12] hedefe vardi: hahah napadnite me [1:2:12] ,Filo Yok Edildi!');
INSERT INTO `ugml_messages` VALUES(32996, 914, 0, 1193921385, 0, 'Filo Lideri', 'Casusluk Raporu', '<table width=440><tr><td class=c colspan=4> Casusluk: hahah napadnite me[1:2:12]01-11-2007 14:49:45</td></tr><tr><td>Metal:</td><td>334.005</td><td>Kristal:</td><td>84.275</td></tr> <tr><td>Deuterium:</td><td>974.150</td> <td>Enerji:</td><td>2.060.434</td></tr> </table><br>  <center> Yok Etme Sansi: 92% <br><b><font color="red">Yok Edildi</font></b></center> </td> </tr>');
INSERT INTO `ugml_messages` VALUES(32985, 913, 0, 1193697028, 0, 'Filo Lideri', 'Savas', '<a class="thickbox" href="rw.php?raport=4e64803b2b107fe7de2591dbffcdd3fc&keepThis=true&TB_iframe=true&height=400&width=500"><font color="red">Filo Raporu [1:2:12] (V:59000,A:1350000)</font></a>');
INSERT INTO `ugml_messages` VALUES(32994, 914, 0, 1193918414, 0, 'Filo Lideri', 'Casusluk Raporu', '<table width=440><tr><td class=c colspan=4> Casusluk: hahah napadnite me[1:2:12]01-11-2007 14:00:14</td></tr><tr><td>Metal:</td><td>334.005</td><td>Kristal:</td><td>84.275</td></tr> <tr><td>Deuterium:</td><td>974.150</td> <td>Enerji:</td><td>2.060.434</td></tr> </table><br>  <center> Yok Etme Sansi: 36% <br><b><font color="red">Yok Edildi</font></b></center> </td> </tr>');
INSERT INTO `ugml_messages` VALUES(32989, 913, 0, 1193698516, 0, 'Filo Lideri', 'Savas', '<a class="thickbox" href="rw.php?raport=a18f129d0e329336d8667fe9fe9295a7&keepThis=true&TB_iframe=true&height=400&width=500"><font color="red">Filo Raporu [1:2:12] (V:10967000,A:465900000)</font></a>');
INSERT INTO `ugml_messages` VALUES(32997, 910, 0, 1193921385, 0, 'Filo Lideri', 'Filo (Casusluk)', 'Diger Gezegenin Filosu hehehe [1:4:12] hedefe vardi: hahah napadnite me [1:2:12] ,Filo Yok Edildi!');
INSERT INTO `ugml_messages` VALUES(32998, 914, 0, 1193925871, 0, 'Filo Lideri', 'Casusluk Raporu', '<table width=440><tr><td class=c colspan=4> Casusluk: hahah napadnite me[1:2:12]01-11-2007 16:04:31</td></tr><tr><td>Metal:</td><td>334.005</td><td>Kristal:</td><td>84.275</td></tr> <tr><td>Deuterium:</td><td>974.150</td> <td>Enerji:</td><td>2.060.434</td></tr> </table><br>  <center> Yok Etme Sansi: 44% <br><b><font color="red">Yok Edildi</font></b></center> </td> </tr>');
INSERT INTO `ugml_messages` VALUES(32999, 910, 0, 1193925871, 0, 'Filo Lideri', 'Filo (Casusluk)', 'Diger Gezegenin Filosu hehehe [1:4:12] hedefe vardi: hahah napadnite me [1:2:12] ,Filo Yok Edildi!');
INSERT INTO `ugml_messages` VALUES(33000, 914, 0, 1198152132, 0, 'Filo Lideri', 'Savas', '<a class="thickbox" href="rw.php?raport=02800861bc10f8337b97e942e9174f9e&keepThis=true&TB_iframe=true&height=400&width=500"><font color="red">Filo Raporu [1:3:9] (V:0,A:0)</font></a>');
INSERT INTO `ugml_messages` VALUES(33001, 912, 0, 1198152132, 0, 'Filo Lideri', 'Savas', '<a class="thickbox" href="rw.php?raport=02800861bc10f8337b97e942e9174f9e&keepThis=true&TB_iframe=true&height=400&width=500"><font color="red">Filo Raporu [1:3:9] (V:0,A:0)</font></a>');

-- --------------------------------------------------------

--
-- Table structure for table `ugml_notes`
--

CREATE TABLE `ugml_notes` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) default NULL,
  `time` int(11) default NULL,
  `priority` tinyint(1) default NULL,
  `title` varchar(32) default NULL,
  `text` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ugml_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_planets`
--

CREATE TABLE `ugml_planets` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `id_owner` int(11) default NULL,
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `last_update` int(11) default NULL,
  `planet_type` int(11) NOT NULL default '1',
  `destruyed` int(11) NOT NULL default '0',
  `b_building` int(11) NOT NULL default '0',
  `b_building_id` int(11) NOT NULL default '0',
  `b_tech` int(11) NOT NULL default '0',
  `b_tech_id` int(11) NOT NULL default '0',
  `b_hangar` int(11) NOT NULL default '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) NOT NULL default '0',
  `image` varchar(32) NOT NULL default 'normaltempplanet01',
  `diameter` int(11) NOT NULL default '12800',
  `points` bigint(20) default '0',
  `ranks` bigint(20) default '0',
  `field_current` int(11) NOT NULL default '0',
  `field_max` int(11) NOT NULL default '163',
  `temp_min` int(3) NOT NULL default '-17',
  `temp_max` int(3) NOT NULL default '23',
  `metal` double(16,6) NOT NULL default '0.000000',
  `metal_perhour` int(11) NOT NULL default '0',
  `metal_max` bigint(20) default '100000',
  `crystal` double(16,6) NOT NULL default '0.000000',
  `crystal_perhour` int(11) NOT NULL default '0',
  `crystal_max` bigint(20) default '100000',
  `deuterium` double(16,6) NOT NULL default '0.000000',
  `deuterium_perhour` int(11) NOT NULL default '0',
  `deuterium_max` bigint(20) default '100000',
  `energy_used` int(11) NOT NULL default '0',
  `energy_max` int(11) NOT NULL default '0',
  `metal_mine` int(11) NOT NULL default '0',
  `crystal_mine` int(11) NOT NULL default '0',
  `deuterium_sintetizer` int(11) NOT NULL default '0',
  `solar_plant` int(11) NOT NULL default '0',
  `fusion_plant` int(11) NOT NULL default '0',
  `robot_factory` int(11) NOT NULL default '0',
  `nano_factory` int(11) NOT NULL default '0',
  `hangar` int(11) NOT NULL default '0',
  `metal_store` int(11) NOT NULL default '0',
  `crystal_store` int(11) NOT NULL default '0',
  `deuterium_store` int(11) NOT NULL default '0',
  `laboratory` int(11) NOT NULL default '0',
  `terraformer` int(11) NOT NULL default '0',
  `ally_deposit` int(11) NOT NULL default '0',
  `silo` int(11) NOT NULL default '0',
  `small_ship_cargo` int(11) NOT NULL default '0',
  `big_ship_cargo` int(11) NOT NULL default '0',
  `light_hunter` int(11) NOT NULL default '0',
  `heavy_hunter` int(11) NOT NULL default '0',
  `crusher` int(11) NOT NULL default '0',
  `battle_ship` int(11) NOT NULL default '0',
  `colonizer` int(11) NOT NULL default '0',
  `recycler` int(11) NOT NULL default '0',
  `spy_sonde` int(11) NOT NULL default '0',
  `bomber_ship` int(11) NOT NULL default '0',
  `solar_satelit` int(11) NOT NULL default '0',
  `destructor` int(11) NOT NULL default '0',
  `dearth_star` int(11) NOT NULL default '0',
  `battleship` int(11) NOT NULL default '0',
  `misil_launcher` int(11) NOT NULL default '0',
  `small_laser` int(11) NOT NULL default '0',
  `big_laser` int(11) NOT NULL default '0',
  `gauss_canyon` int(11) NOT NULL default '0',
  `ionic_canyon` int(11) NOT NULL default '0',
  `buster_canyon` int(11) NOT NULL default '0',
  `small_protection_shield` int(11) NOT NULL default '0',
  `big_protection_shield` int(11) NOT NULL default '0',
  `interceptor_misil` int(11) NOT NULL default '0',
  `interplanetary_misil` int(11) NOT NULL default '0',
  `metal_mine_porcent` int(11) NOT NULL default '10',
  `crystal_mine_porcent` int(11) NOT NULL default '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL default '10',
  `solar_plant_porcent` int(11) NOT NULL default '10',
  `fusion_plant_porcent` int(11) NOT NULL default '10',
  `solar_satelit_porcent` int(11) NOT NULL default '10',
  `b_building_queue` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1983 ;

--
-- Dumping data for table `ugml_planets`
--

INSERT INTO `ugml_planets` VALUES(1975, 'Kostolac', 910, 1, 2, 1, 1195154272, 1, 0, 1194826233, 0, 0, 0, 0, '', 0, 'trockenplanet03', 11025, 0, 0, 5, 154, 11, 51, 1331317.604170, 165, 1000000, 913885.402776, 110, 1000000, 405957.500000, 0, 1000000, 110, 242, 2, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1972, 'MaticnaPloca', 909, 1, 2, 8, 1193777018, 1, 0, 1193760612, 44, 1193777042, 115, 0, '', 0, 'normaltempplanet06', 12750, 15400, 0, 12, 163, 5, 45, 65603.303888, 165, 1000000, 56163.804448, 110, 1000000, 59744.842777, 65, 1000000, 275, 1062, 1, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1973, 'hahah napadnite me', 910, 1, 2, 12, 1196545786, 1, 0, 1193689238, 0, 1193689473, 2, 0, '', 0, 'wasserplanet03', 12750, 368032, 0, 751, 163, -74, -34, 341346.786350, 880431, 6, 89766.101565, 658562, 6, 975002.956925, 102129, 6, 1503192, 2054339, 50, 51, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 0, 0, 0, 0, 17, 25, 1, 0, 0, 32, 0, 50, 50, 42, 4952, 9931, 81, 83, 74, 100, 100, 100, 100, 100, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1974, 'Mitozis', 911, 1, 2, 13, 1193690920, 1, 0, 1193690593, 0, 1193690416, 0, 0, '', 0, 'wasserplanet03', 12750, 1000, 0, 10, 163, -18, 22, 558.444444, 0, 1000000, 973.222224, 0, 1000000, 495.555556, 0, 1000000, 0, 0, 2, 2, 1, 2, 0, 1, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1976, 'Pozarevac', 910, 1, 2, 2, 1194811825, 1, 0, 1194826225, 44, 0, 0, 0, '', 0, 'trockenplanet08', 19050, 0, 0, 4, 247, 61, 101, 758280.000001, 20, 100000, 1069691.000000, 10, 100000, 621959.999999, 0, 100000, 0, 0, 1, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1977, 'uros', 912, 1, 3, 9, 1193692046, 1, 0, 0, 0, 0, 0, 0, '', 0, 'normaltempplanet01', 12750, 0, 0, 0, 163, -12, 28, 342.027778, 20, 100000, 378.638890, 10, 100000, 323.222222, 0, 100000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1978, 'ALAH', 911, 1, 2, 9, 1193692121, 1, 0, 1193692135, 4, 0, 0, 0, '', 0, 'normaltempplanet02', 24075, 0, 0, 0, 328, 2, 42, 563.194443, 20, 100000, 663.472224, 10, 100000, 610.555557, 0, 100000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1982, 'DMX lolz', 915, 1, 4, 8, 1199050120, 1, 0, 0, 0, 0, 0, 0, '', 0, 'normaltempplanet04', 12750, 0, 0, 0, 163, 20, 60, 564.583333, 20, 100000, 590.416667, 10, 100000, 551.666667, 0, 100000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);
INSERT INTO `ugml_planets` VALUES(1981, 'hehehe', 914, 1, 4, 12, 1198980467, 1, 0, 1198982490, 3, 1198379637, 0, 2, '212,3351;212,5;', 0, 'wasserplanet04', 12750, -13988031, 0, 122, 163, 21, 61, 22212837.008900, 17430, 17085937, 3045390.222540, 8592, 11390625, 4269.912689, 7790, 1000000, 30291, 309644, 19, 17, 20, 23, 0, 10, 4, 7, 7, 6, 0, 9, 0, 0, 0, 0, 0, 6, 640, 0, 295, 3, 0, 0, 0, 1642, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ugml_rw`
--

CREATE TABLE `ugml_rw` (
  `id_owner1` int(11) NOT NULL default '0',
  `id_owner2` int(11) NOT NULL default '0',
  `rid` varchar(32) NOT NULL default '',
  `raport` text NOT NULL,
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugml_rw`
--

INSERT INTO `ugml_rw` VALUES(913, 910, '6a2d43fb0d64ad2826bf4d98d68f8c75', '<center><table><tr><td>Savas Mon, 29 Oct 2007 18:21:24 -0400 filolar::<br><table border=1 width=100%><tr><th><br><center>Saldiran lolz (1:2:13)<br>Silahlanma: 5100% Savunma: 5100% Korunma: 5100% <table border=1><tr><th>Tur</th><th>Oklopna krstarica</th></tr><tr><th>Il.</th><th>50</th></tr><tr><th>Silahlanma:</th><th>41769</th></tr><tr><th>Savunma</th><th>18360</th></tr><tr><th>Korunma</th><th>357000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>10</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>308</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th></tr><tr><th>Silahlanma:</th><th>450</th><th>490</th><th>4448</th><th>15468</th><th>39631</th><th>115254</th><th>5207</th><th>117</th><th>0</th><th>102111</th><th>109</th><th>161760</th><th>16782600</th><th>84216</th><th>7684</th><th>11525</th><th>20220</th><th>103425</th><th>16530</th><th>297234</th><th>90</th><th>101</th></tr><tr><th>Savunma</th><th>1102</th><th>2148</th><th>1112</th><th>2477</th><th>4499</th><th>19007</th><th>9402</th><th>829</th><th>0</th><th>49034</th><th>1021</th><th>55100</th><th>5762700</th><th>33970</th><th>1698</th><th>2907</th><th>10514</th><th>18198</th><th>44990</th><th>35183</th><th>173892</th><th>186024</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><br><center>Saldiran Filo Butun Gucuyle 2088450 vurdu.Saldirilanin Korunmasi 1925742.61275 kadarini etkisiz kildi<br>\r\n									Korunan Taraf Saldiriya Gecti ve 893645657.61 kadar vurdu.Saldiranin Korunmasi  918000 kadarini etkisiz kildi.</center><table border=1 width=100%><tr><th><br><center>Saldiran lolz (1:2:13)<br>Silahlanma: 5100% Savunma: 5100% Korunma: 5100% <table border=1><br>Yýkýldý</table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>47</th><th>48</th><th>49</th><th>48</th><th>47</th><th>46</th><th>50</th><th>10</th><th>45</th><th>50</th><th>46</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>308</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th></tr><tr><th>Silahlanma:</th><th>602</th><th>465</th><th>4903</th><th>17743</th><th>35587</th><th>95034</th><th>5864</th><th>117</th><th>0</th><th>103122</th><th>103</th><th>232530</th><th>22444200</th><th>80678</th><th>9463</th><th>10616</th><th>28561</th><th>132340</th><th>12739</th><th>269937</th><th>83</th><th>110</th></tr><tr><th>Savunma</th><th>950</th><th>2047</th><th>839</th><th>2199</th><th>4044</th><th>17591</th><th>9807</th><th>900</th><th>0</th><th>43979</th><th>910</th><th>59649</th><th>5914350</th><th>32756</th><th>1820</th><th>2806</th><th>11728</th><th>23657</th><th>44990</th><th>35183</th><th>186024</th><th>210288</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><p>SALDIRIYA UGRAYAN TARAF KAZANDI!<br><p><br>Bu Kordinattaki Harabede 1063800 metal ve 1272600 Kristal bulunuyor. <br>Ay Olusma Sansi 20 %  <br><br>Simulasyon 0.00168800354004 saniyede yapildi.<br>Savas Raporu ve Savas Simulasyonu By OgameTr</table>');
INSERT INTO `ugml_rw` VALUES(913, 910, '58fe874e67309dcb5bf9c516e8a43928', '<center><table><tr><td>Savas Mon, 29 Oct 2007 18:30:14 -0400 filolar::<br><table border=1 width=100%><tr><th><br><center>Saldiran lolz (1:2:13)<br>Silahlanma: 110% Savunma: 110% Korunma: 110% <table border=1><tr><th>Tur</th><th>Veliki lovac</th></tr><tr><th>Il.</th><th>50</th></tr><tr><th>Silahlanma:</th><th>147</th></tr><tr><th>Savunma</th><th>27</th></tr><tr><th>Korunma</th><th>1100</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>47</th><th>48</th><th>49</th><th>48</th><th>47</th><th>46</th><th>50</th><th>10</th><th>45</th><th>50</th><th>46</th><th>50</th><th>50</th><th>50</th><th>5000</th><th>10000</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Silahlanma:</th><th>596</th><th>581</th><th>4448</th><th>18046</th><th>42462</th><th>117276</th><th>6066</th><th>95</th><th>0</th><th>96045</th><th>102</th><th>200178</th><th>23050800</th><th>82093</th><th>8573</th><th>10110</th><th>22495</th><th>104537</th><th>13952</th><th>345762</th><th>108</th><th>107</th></tr><tr><th>Savunma</th><th>1072</th><th>2148</th><th>1132</th><th>2982</th><th>4853</th><th>19007</th><th>11020</th><th>1102</th><th>0</th><th>56111</th><th>809</th><th>54594</th><th>6015450</th><th>35183</th><th>2305</th><th>2123</th><th>10413</th><th>19209</th><th>49539</th><th>28207</th><th>236574</th><th>220398</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><br><center>Saldiran Filo Butun Gucuyle 7342.5 vurdu.Saldirilanin Korunmasi 7322.14939024 kadarini etkisiz kildi<br>\r\n									Korunan Taraf Saldiriya Gecti ve 1372957831.78 kadar vurdu.Saldiranin Korunmasi  1347.5 kadarini etkisiz kildi.</center><table border=1 width=100%><tr><th><br><center>Saldiran lolz (1:2:13)<br>Silahlanma: 110% Savunma: 110% Korunma: 110% <table border=1><br>Yýkýldý</table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>44</th><th>48</th><th>49</th><th>48</th><th>47</th><th>46</th><th>50</th><th>10</th><th>41</th><th>50</th><th>43</th><th>50</th><th>50</th><th>50</th><th>5000</th><th>10000</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Silahlanma:</th><th>465</th><th>596</th><th>4752</th><th>13042</th><th>44484</th><th>109188</th><th>5055</th><th>108</th><th>0</th><th>112221</th><th>108</th><th>238596</th><th>24061800</th><th>77847</th><th>8735</th><th>11627</th><th>20726</th><th>100089</th><th>17743</th><th>315432</th><th>108</th><th>120</th></tr><tr><th>Savunma</th><th>991</th><th>2528</th><th>910</th><th>2123</th><th>4448</th><th>18198</th><th>9402</th><th>829</th><th>0</th><th>40440</th><th>920</th><th>50550</th><th>4650600</th><th>47719</th><th>1941</th><th>2578</th><th>12132</th><th>22646</th><th>48528</th><th>29420</th><th>214332</th><th>186024</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><p>SALDIRIYA UGRAYAN TARAF KAZANDI!<br><p><br>Bu Kordinattaki Harabede 183600 metal ve 129600 Kristal bulunuyor. <br>Ay Olusma Sansi 3.132 %  <br><br>Simulasyon 0.00164079666138 saniyede yapildi.<br>Savas Raporu ve Savas Simulasyonu By OgameTr</table>');
INSERT INTO `ugml_rw` VALUES(913, 910, '4e64803b2b107fe7de2591dbffcdd3fc', '<center><table><tr><td>Savas Mon, 29 Oct 2007 18:29:08 -0400 filolar::<br><table border=1 width=100%><tr><th><br><center>Saldiran lolz (1:2:13)<br>Silahlanma: 110% Savunma: 110% Korunma: 110% <table border=1><tr><th>Tur</th><th>Krstarice</th></tr><tr><th>Il.</th><th>50</th></tr><tr><th>Silahlanma:</th><th>493</th></tr><tr><th>Savunma</th><th>52</th></tr><tr><th>Korunma</th><th>2970</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>44</th><th>48</th><th>49</th><th>48</th><th>47</th><th>46</th><th>50</th><th>10</th><th>41</th><th>50</th><th>43</th><th>50</th><th>50</th><th>50</th><th>5000</th><th>10000</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Silahlanma:</th><th>596</th><th>521</th><th>4954</th><th>14558</th><th>36396</th><th>80880</th><th>4651</th><th>85</th><th>0</th><th>97056</th><th>85</th><th>212310</th><th>19209000</th><th>82093</th><th>8573</th><th>11525</th><th>23253</th><th>114546</th><th>13800</th><th>257805</th><th>120</th><th>100</th></tr><tr><th>Savunma</th><th>1051</th><th>2679</th><th>1213</th><th>2881</th><th>4752</th><th>24264</th><th>11930</th><th>1213</th><th>0</th><th>44484</th><th>930</th><th>49034</th><th>5105550</th><th>36396</th><th>1820</th><th>2704</th><th>10413</th><th>19613</th><th>56111</th><th>36093</th><th>206244</th><th>171870</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><br><center>Saldiran Filo Butun Gucuyle 24640 vurdu.Saldirilanin Korunmasi 24577.7394305 kadarini etkisiz kildi<br>\r\n									Korunan Taraf Saldiriya Gecti ve 1185766749.55 kadar vurdu.Saldiranin Korunmasi  2612.5 kadarini etkisiz kildi.</center><table border=1 width=100%><tr><th><br><center>Saldiran lolz (1:2:13)<br>Silahlanma: 110% Savunma: 110% Korunma: 110% <table border=1><br>Yýkýldý</table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>42</th><th>48</th><th>44</th><th>48</th><th>47</th><th>46</th><th>50</th><th>10</th><th>34</th><th>50</th><th>37</th><th>50</th><th>50</th><th>50</th><th>4994</th><th>10000</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Silahlanma:</th><th>521</th><th>445</th><th>4600</th><th>16530</th><th>47315</th><th>87957</th><th>5308</th><th>118</th><th>0</th><th>113232</th><th>92</th><th>181980</th><th>22848600</th><th>74309</th><th>9301</th><th>9099</th><th>29319</th><th>115658</th><th>12587</th><th>266904</th><th>121</th><th>99</th></tr><tr><th>Savunma</th><th>950</th><th>3008</th><th>869</th><th>2654</th><th>4095</th><th>21635</th><th>9908</th><th>930</th><th>0</th><th>50550</th><th>880</th><th>41957</th><th>4448400</th><th>47719</th><th>2366</th><th>2957</th><th>9908</th><th>20018</th><th>43473</th><th>27904</th><th>161760</th><th>192090</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><p>SALDIRIYA UGRAYAN TARAF KAZANDI!<br><p><br>Bu Kordinattaki Harabede 611400 metal ve 226800 Kristal bulunuyor. <br>Ay Olusma Sansi 8.382 %  <br><br>Simulasyon 0.00176095962524 saniyede yapildi.<br>Savas Raporu ve Savas Simulasyonu By OgameTr</table>');
INSERT INTO `ugml_rw` VALUES(913, 910, 'a18f129d0e329336d8667fe9fe9295a7', '<center><table><tr><td>Savas Mon, 29 Oct 2007 18:55:11 -0400 filolar::<br><table border=1 width=100%><tr><th><br><center>Saldiran  (1:2:13)<br>Silahlanma: 100% Savunma: 100% Korunma: 100% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Recikler</th><th>Bombarder</th><th>Razaraci</th><th>Zvijezda smrti</th></tr><tr><th>Il.</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th><th>50</th></tr><tr><th>Silahlanma:</th><th>4</th><th>5</th><th>43</th><th>138</th><th>420</th><th>990</th><th>1</th><th>1000</th><th>1640</th><th>160000</th></tr><tr><th>Savunma</th><th>12</th><th>23</th><th>11</th><th>22</th><th>42</th><th>190</th><th>11</th><th>490</th><th>490</th><th>48000</th></tr><tr><th>Korunma</th><th>400</th><th>1200</th><th>400</th><th>1000</th><th>2700</th><th>6000</th><th>1600</th><th>7500</th><th>11000</th><th>900000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Mali transporter</th><th>Veliki transporter</th><th>Mali lovac</th><th>Veliki lovac</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Kolonijalni brodovi</th><th>Recikler</th><th>Sonde za spijunazu</th><th>Bombarder</th><th>Solarni satelit</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Ionski top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>42</th><th>48</th><th>44</th><th>48</th><th>47</th><th>46</th><th>50</th><th>10</th><th>34</th><th>50</th><th>106</th><th>50</th><th>50</th><th>50</th><th>4998</th><th>10000</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Silahlanma:</th><th>591</th><th>591</th><th>6066</th><th>15923</th><th>46910</th><th>82902</th><th>4600</th><th>107</th><th>0</th><th>101100</th><th>93</th><th>186024</th><th>19613400</th><th>77139</th><th>7117</th><th>11627</th><th>29319</th><th>101201</th><th>13800</th><th>357894</th><th>116</th><th>84</th></tr><tr><th>Savunma</th><th>950</th><th>2174</th><th>880</th><th>2528</th><th>4196</th><th>23860</th><th>11829</th><th>1102</th><th>0</th><th>59649</th><th>1031</th><th>60155</th><th>4600050</th><th>45697</th><th>2022</th><th>2780</th><th>8492</th><th>22444</th><th>58133</th><th>35486</th><th>173892</th><th>161760</th></tr><tr><th>Korunma</th><th>40440</th><th>121320</th><th>40440</th><th>101100</th><th>272970</th><th>606600</th><th>303300</th><th>161760</th><th>10110</th><th>758250</th><th>20220</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>80880</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><br><center>Saldiran Filo Butun Gucuyle 8212052 vurdu.Saldirilanin Korunmasi 8194894.14539 kadarini etkisiz kildi<br>\r\n									Korunan Taraf Saldiriya Gecti ve 1208306236.3 kadar vurdu.Saldiranin Korunmasi  2464532.5 kadarini etkisiz kildi.</center><table border=1 width=100%><tr><th><br><center>Saldiran  (1:2:13)<br>Silahlanma: 100% Savunma: 100% Korunma: 100% <table border=1><br>Yýkýldý</table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Saldirilan Zoran (1:2:12)<br>Silahlanma: 10110% Savunma: 10110% Korunma: 10110% <table border=1><tr><th>Tur</th><th>Krstarice</th><th>Borbeni brodovi</th><th>Bombarder</th><th>Razaraci</th><th>Zvijezda smrti</th><th>Oklopna krstarica</th><th>Raketobacaci</th><th>Mali laser</th><th>Veliki laser</th><th>Gausov top</th><th>Plazma top</th><th>Mala stitna kupola</th><th>Duża Velika stitna kupola</th></tr><tr><th>Il.</th><th>17</th><th>25</th><th>32</th><th>50</th><th>50</th><th>42</th><th>4827</th><th>9823</th><th>15</th><th>57</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Silahlanma:</th><th>40036</th><th>98067</th><th>93012</th><th>218376</th><th>21837600</th><th>72185</th><th>7117</th><th>10514</th><th>28814</th><th>120107</th><th>348795</th><th>103</th><th>106</th></tr><tr><th>Savunma</th><th>5914</th><th>21029</th><th>52067</th><th>53078</th><th>5661600</th><th>40036</th><th>1961</th><th>2730</th><th>11121</th><th>22242</th><th>35789</th><th>228486</th><th>184002</th></tr><tr><th>Korunma</th><th>272970</th><th>606600</th><th>758250</th><th>1112100</th><th>90990000</th><th>707700</th><th>20220</th><th>20220</th><th>80880</th><th>353850</th><th>1011000</th><th>202200</th><th>1011000</th></tr></table></center></th></tr></table><p>SALDIRIYA UGRAYAN TARAF KAZANDI!<br><p><br>Bu Kordinattaki Harabede 158506200 metal ve 125405400 Kristal bulunuyor. <br>Ay Olusma Sansi 20 %  <br>Tebrikler!! hahah napadnite me [1:2:12] Yeni Bir Ay Olusturdunuz!<br>Simulasyon 0.00224494934082 saniyede yapildi.<br>Savas Raporu ve Savas Simulasyonu By OgameTr</table>');
INSERT INTO `ugml_rw` VALUES(914, 912, '02800861bc10f8337b97e942e9174f9e', '<center><table><tr><td>Savas Thu, 20 Dec 2007 06:56:15 -0500 filolar::<br><p>SALDIRAN TARAF KAZANDI!<br>Ganimet:<br>Metal: 342<br>Kristal: 379<br>Deuterium: 324<br><p><br>Bu Kordinattaki Harabede 0 metal ve 0 Kristal bulunuyor. <br> <br><br>Simulasyon 0.000255107879639 saniyede yapildi.<br>Savas Raporu ve Savas Simulasyonu By OgameTr</table>');

-- --------------------------------------------------------

--
-- Table structure for table `ugml_themes`
--

CREATE TABLE `ugml_themes` (
  `themes_id` mediumint(8) NOT NULL auto_increment,
  `template_name` varchar(30) default NULL,
  `style_name` varchar(30) default NULL,
  `head_stylesheet` varchar(100) default NULL,
  PRIMARY KEY  (`themes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ugml_themes`
--


-- --------------------------------------------------------

--
-- Table structure for table `ugml_users`
--

CREATE TABLE `ugml_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(64) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `email_2` varchar(64) NOT NULL default '',
  `lang` varchar(8) NOT NULL default 'en',
  `authlevel` tinyint(4) NOT NULL default '0',
  `sex` char(1) default NULL,
  `avatar` varchar(255) NOT NULL default '',
  `sign` text,
  `id_planet` int(11) NOT NULL default '0',
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `current_planet` int(11) NOT NULL default '0',
  `user_lastip` varchar(16) NOT NULL default '',
  `register_time` int(11) NOT NULL default '0',
  `onlinetime` int(11) NOT NULL default '0',
  `dpath` varchar(255) NOT NULL default '',
  `design` tinyint(4) NOT NULL default '1',
  `noipcheck` tinyint(4) NOT NULL default '1',
  `spio_anz` tinyint(4) NOT NULL default '1',
  `settings_tooltiptime` tinyint(4) NOT NULL default '5',
  `settings_fleetactions` tinyint(4) NOT NULL default '0',
  `settings_allylogo` tinyint(4) NOT NULL default '0',
  `settings_esp` tinyint(4) NOT NULL default '1',
  `settings_wri` tinyint(4) NOT NULL default '1',
  `settings_bud` tinyint(4) NOT NULL default '1',
  `settings_mis` tinyint(4) NOT NULL default '1',
  `settings_rep` tinyint(4) NOT NULL default '0',
  `urlaubs_modus` tinyint(4) NOT NULL default '0',
  `db_deaktjava` tinyint(4) NOT NULL default '0',
  `points_builds` bigint(20) NOT NULL default '0',
  `points_tech` bigint(20) NOT NULL default '0',
  `points_fleet` bigint(20) NOT NULL default '0',
  `points_builds2` bigint(20) NOT NULL default '0',
  `points_tech2` bigint(20) NOT NULL default '0',
  `points_fleet2` bigint(20) NOT NULL default '0',
  `points_builds_old` bigint(20) NOT NULL default '0',
  `points_tech_old` bigint(20) NOT NULL default '0',
  `points_fleet_old` bigint(20) NOT NULL default '0',
  `points_points` bigint(20) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `new_message` int(11) NOT NULL default '0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) NOT NULL default '0',
  `spy_tech` int(11) NOT NULL default '0',
  `computer_tech` int(11) NOT NULL default '0',
  `military_tech` int(11) NOT NULL default '0',
  `defence_tech` int(11) NOT NULL default '0',
  `shield_tech` int(11) NOT NULL default '0',
  `energy_tech` int(11) NOT NULL default '0',
  `hyperspace_tech` int(11) NOT NULL default '0',
  `combustion_tech` int(11) NOT NULL default '0',
  `impulse_motor_tech` int(11) NOT NULL default '0',
  `hyperspace_motor_tech` int(11) NOT NULL default '0',
  `laser_tech` int(11) NOT NULL default '0',
  `ionic_tech` int(11) NOT NULL default '0',
  `buster_tech` int(11) NOT NULL default '0',
  `intergalactic_tech` int(11) NOT NULL default '0',
  `graviton_tech` int(11) NOT NULL default '0',
  `ally_id` int(11) NOT NULL default '0',
  `ally_name` varchar(32) default '',
  `ally_request` int(11) NOT NULL default '0',
  `ally_rank_id` int(11) NOT NULL default '0',
  `ally_request_text` text,
  `ally_register_time` int(11) NOT NULL default '0',
  `current_luna` int(11) NOT NULL default '0',
  `kolorminus` varchar(11) NOT NULL default 'red',
  `kolorplus` varchar(11) NOT NULL default '#00FF00',
  `kolorpoziom` varchar(11) NOT NULL default 'yellow',
  `rank_old` int(11) NOT NULL default '0',
  `bana` varchar(11) NOT NULL default '0',
  `banaday` varchar(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_planet` (`id_planet`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=916 ;

--
-- Dumping data for table `ugml_users`
--

INSERT INTO `ugml_users` VALUES(915, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'dark.mnax@hotmail.com', 'dark.mnax@hotmail.com', 'en', 5, 'M', '', NULL, 1982, 1, 4, 8, 1982, '77.46.240.62', 1199050027, 1199050120, '', 1, 1, 1, 5, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, NULL, 0, 0, 'red', '#00FF00', 'yellow', 0, '0', '0');
