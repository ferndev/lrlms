CREATE TABLE classroom (
  `id` int(11) NOT NULL auto_increment,
  `courseid` int(11) NOT NULL,
  `cname` varchar(50) NULL,
  `modptr` int(11) NOT NULL COMMENT 'ptr to course_modules',
  `lessonptr` int(11) NOT NULL COMMENT 'ptr to module_lessons',
  `creatorid` int(11) NOT NULL,
  `isopen` tinyint(1) NOT NULL default '1',
  `nextdate` datetime default NULL,
  `creatorptr` int(11) NOT NULL default '0',
  `ctype` tinyint(4) NOT NULL default '2' COMMENT 'course type/style',
  `schoolclassid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE classroom_users (
  `id` int(11) NOT NULL auto_increment,
  `classroomid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `roleid` int(11) NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE course (
  `id` int(11) NOT NULL auto_increment,
  `coursename` varchar(100) NOT NULL,
  `scriptname` varchar(20) default NULL,
  `subjectid` int(11) NOT NULL,
  `descr` text NOT NULL,
  `duration` float NOT NULL default '0' COMMENT 'weeks',
  `price` float NOT NULL default '0',
  `currency` varchar(15) NOT NULL default 'USD',
  `course_type` tinyint(4) NOT NULL default '1' COMMENT '1=self-paced,2=instructor led,3=product',
  `location_type` tinyint(4) NOT NULL default '1' COMMENT '1=online,2=offline,3=onl_and_offl',
  `content_type` tinyint(4) NOT NULL default '2' COMMENT '1=db,2=script',
  `country` varchar(25) default NULL,
  `city` varchar(40) default NULL,
  `address` varchar(250) default NULL,
  `thumb` varchar(35) default NULL,
  `package` varchar(60) default NULL,
  `trial` varchar(60) default NULL,
  `emailsupport` tinyint(1) NOT NULL default '0',
  `incl_assigm` tinyint(1) NOT NULL default '0',
  `visibility` tinyint(4) NOT NULL default '1' COMMENT '1=public,2=group,3=private',
  `createdby` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

CREATE TABLE course_users (
  `id` int(11) NOT NULL auto_increment,
  `courseid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `reg_type` tinyint(4) NOT NULL default '1' COMMENT '1=trial,2=full,3=pending',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE course_assessment (
  `id` int(11) NOT NULL auto_increment,
  `aname` varchar(30) NOT NULL,
  `courseid` int(11) NOT NULL,
  `classroomid` int(11) NOT NULL,
  `assessmentid` int(11) NOT NULL default '-1',
  `userid` int(11) NOT NULL,
  `score` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE course_assignments (
  `id` int(11) NOT NULL auto_increment,
  `assigname` varchar(50) NOT NULL,
  `descr` varchar(255) default NULL,
  `apath` varchar(100) default NULL,
  `courseid` int(11) default NULL,
  `moduleid` int(11) NOT NULL default '0',
  `delivtype` tinyint(4) NOT NULL COMMENT '1=print,2=email,3=upload',
  `assigndate` datetime NOT NULL,
  `completedate` datetime NOT NULL,
  `assignedby` int(11) NOT NULL,
  `schoolclassid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE courseinstance (
  `id` int(11) NOT NULL auto_increment,
  `classroomid` int(11) NOT NULL,
  `coursename` varchar(30) NOT NULL,
  `currlesson` varchar(30) NOT NULL,
  `userid` int(11) NOT NULL,
  `score` float NOT NULL default '0',
  `vars` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE lesson (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL,
  `descr` varchar(200) default NULL,
  `lessontype` tinyint(4) NOT NULL,
  `content` text,
  `quiztype` tinyint(11) NOT NULL default '0',
  `creatorid` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE lesson_media (
  `id` int(11) NOT NULL auto_increment,
  `lessonid` int(11) NOT NULL,
  `media` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE course_lesson (
  `id` int(11) NOT NULL auto_increment,
  `courseid` int(11) NOT NULL,
  `lessonid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE qoption (
  `id` int(11) NOT NULL auto_increment,
  `qid` int(11) default NULL,
  `text` varchar(100) default NULL,
  `iscorrect` tinyint(4) default NULL,
  `value` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE question (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(30) default NULL,
  `qtype` varchar(4) default NULL,
  `header` varchar(100) default NULL,
  `cfb` varchar(100) default NULL,
  `wfb` varchar(100) default NULL,
  `creatorid` int(11) default NULL,
  `accesstype` tinyint(4) default NULL,
  `langid` int(11) NOT NULL default '0',
  `datecreated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE course_question (
  `id` int(11) NOT NULL auto_increment,
  `courseid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
