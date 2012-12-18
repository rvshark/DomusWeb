-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tempo de Geração: Jul 20, 2011 as 02:19 PM
-- Versão do Servidor: 5.0.45
-- Versão do PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Banco de Dados: `moodle`
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `course` bigint(10) unsigned NOT NULL default '0',
  `type` enum('single','news','general','social','eachuser','teacher','qanda') NOT NULL default 'general',
  `name` varchar(255) NOT NULL default '',
  `intro` text NOT NULL,
  `assessed` bigint(10) unsigned NOT NULL default '0',
  `assesstimestart` bigint(10) unsigned NOT NULL default '0',
  `assesstimefinish` bigint(10) unsigned NOT NULL default '0',
  `scale` bigint(10) NOT NULL default '0',
  `maxbytes` bigint(10) unsigned NOT NULL default '0',
  `forcesubscribe` tinyint(1) unsigned NOT NULL default '0',
  `trackingtype` tinyint(2) unsigned NOT NULL default '1',
  `rsstype` tinyint(2) unsigned NOT NULL default '0',
  `rssarticles` tinyint(2) unsigned NOT NULL default '0',
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  `warnafter` bigint(10) unsigned NOT NULL default '0',
  `blockafter` bigint(10) unsigned NOT NULL default '0',
  `blockperiod` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_foru_cou_ix` (`course`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Forums contain and structure discussion' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_discussions`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_discussions` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `course` bigint(10) unsigned NOT NULL default '0',
  `forum` bigint(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `firstpost` bigint(10) unsigned NOT NULL default '0',
  `userid` bigint(10) unsigned NOT NULL default '0',
  `groupid` bigint(10) NOT NULL default '-1',
  `assessed` tinyint(1) NOT NULL default '1',
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  `usermodified` bigint(10) unsigned NOT NULL default '0',
  `timestart` bigint(10) unsigned NOT NULL default '0',
  `timeend` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_forudisc_use_ix` (`userid`),
  KEY `mdl_forudisc_for_ix` (`forum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Forums are composed of discussions' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_posts`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_posts` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `discussion` bigint(10) unsigned NOT NULL default '0',
  `parent` bigint(10) unsigned NOT NULL default '0',
  `userid` bigint(10) unsigned NOT NULL default '0',
  `created` bigint(10) unsigned NOT NULL default '0',
  `modified` bigint(10) unsigned NOT NULL default '0',
  `mailed` tinyint(2) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `format` tinyint(2) NOT NULL default '0',
  `attachment` varchar(100) NOT NULL default '',
  `totalscore` smallint(4) NOT NULL default '0',
  `mailnow` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_forupost_use_ix` (`userid`),
  KEY `mdl_forupost_cre_ix` (`created`),
  KEY `mdl_forupost_mai_ix` (`mailed`),
  KEY `mdl_forupost_dis_ix` (`discussion`),
  KEY `mdl_forupost_par_ix` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All posts are stored in this table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_queue`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_queue` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `userid` bigint(10) unsigned NOT NULL default '0',
  `discussionid` bigint(10) unsigned NOT NULL default '0',
  `postid` bigint(10) unsigned NOT NULL default '0',
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_foruqueu_use_ix` (`userid`),
  KEY `mdl_foruqueu_dis_ix` (`discussionid`),
  KEY `mdl_foruqueu_pos_ix` (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='For keeping track of posts that will be mailed in digest for' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_ratings`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_ratings` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `userid` bigint(10) unsigned NOT NULL default '0',
  `post` bigint(10) unsigned NOT NULL default '0',
  `time` bigint(10) unsigned NOT NULL default '0',
  `rating` smallint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_forurati_use_ix` (`userid`),
  KEY `mdl_forurati_pos_ix` (`post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='forum_ratings table retrofitted from MySQL' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_read`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_read` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `userid` bigint(10) unsigned NOT NULL default '0',
  `forumid` bigint(10) unsigned NOT NULL default '0',
  `discussionid` bigint(10) unsigned NOT NULL default '0',
  `postid` bigint(10) unsigned NOT NULL default '0',
  `firstread` bigint(10) unsigned NOT NULL default '0',
  `lastread` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_foruread_usefor_ix` (`userid`,`forumid`),
  KEY `mdl_foruread_usedis_ix` (`userid`,`discussionid`),
  KEY `mdl_foruread_usepos_ix` (`userid`,`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tracks each users read posts' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_subscriptions`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_subscriptions` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `userid` bigint(10) unsigned NOT NULL default '0',
  `forum` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_forusubs_use_ix` (`userid`),
  KEY `mdl_forusubs_for_ix` (`forum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Keeps track of who is subscribed to what forum' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `mdl_myforum_track_prefs`
-- 

CREATE TABLE IF NOT EXISTS `mdl_myforum_track_prefs` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `userid` bigint(10) unsigned NOT NULL default '0',
  `forumid` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_forutracpref_usefor_ix` (`userid`,`forumid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tracks each users untracked forums' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mdl_myforum_biblio` (
  `id` int(11) NOT NULL auto_increment,
  `text` varchar(8000) NOT NULL,
  `discussion` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `forum` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `datetime` time NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `mdl_myforum_concepts` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `userid` int(11) NOT NULL,
  `forum` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `datetime` bigint(20) NOT NULL,
  `discussion` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `mdl_myforum_notes` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`text` TEXT NOT NULL ,
`userid` INT NOT NULL ,
`course` INT NOT NULL ,
`forum` INT NOT NULL ,
`datetime` BIGINT NOT NULL
) ENGINE = innodb;




