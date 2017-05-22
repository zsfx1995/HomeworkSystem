DROP DATABASE IF EXISTS D_HomeworkSystem;
CREATE DATABASE D_HomeworkSystem CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'; 
use D_HomeworkSystem;
-- 建用户基础信息表
CREATE TABLE T_UserInfo (
	Uid int not null primary key auto_increment,
	UserName CHAR(200) not null ,
	Password CHAR(200) not null,
	Mail CHAR(200) ,
	PhoneNum CHAR(200),
	AcitivityList text,
	SubList text,
	PicUrl CHAR(200) DEFAULT "http://119.23.150.38/image/user/0.jpg",
	Score int not null DEFAULT 0,
	RandomText CAHR(200)
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 
-- 建错题表
CREATE TABLE T_Question_Wrong (
	Uid INT	 ,
	Qid INT ,
	PRIMARY KEY( Uid , Qid )
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 
-- 建收藏题表
CREATE TABLE T_Question_Mark (
	Uid INT	 ,
	Qid INT ,
	PRIMARY KEY( Uid , Qid ),
	Remark TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 基础题表
CREATE TABLE T_Question(
	Qid INT not null PRIMARY KEY AUTO_INCREMENT,
	Qtype INT NOT NULL DEFAULT 0,
	Detail text ,
	Ans TEXT,
	Tips TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 试卷表
CREATE TABLE T_Paper(
	Pid INT PRIMARY KEY AUTO_INCREMENT,
	Pname CHAR(200),
	LimitTime INT DEFAULT 0,
	Description TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 学科表
CREATE TABLE T_Sub(
	Sid INT  PRIMARY KEY AUTO_INCREMENT,
	Sname CHAR(200),
	Description TEXT,
	PicUrl CHAR(200) DEFAULT "http://119.23.150.38/image/sub/sysu.jpg",
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 活动表
CREATE TABLE T_Activity(
	Aid INT PRIMARY KEY AUTO_INCREMENT,
	Aname CHAR(200),
	Description TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PicUrl CHAR(200) DEFAULT "http://119.23.150.38/image/activity/sysu.jpg"
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 标签表
CREATE TABLE T_Tag(
	Tid INT PRIMARY KEY AUTO_INCREMENT,
	Tname CHAR(200)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 试卷题目关联表
CREATE TABLE R_Paper_Ques(
	Qid INT  NOT NULL,
	Pid INT ,
	PRIMARY KEY( Pid , Qid ),
	foreign key(Qid) references T_Question(Qid) on delete cascade,
	foreign key(Pid) references T_Paper(Pid) on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 学科试卷关联表
CREATE TABLE R_Sub_Paper (
	Pid INT NOT NULL,
	Sid INT,
	PRIMARY KEY( Sid , Pid ),
	foreign key(Sid) references T_Sub(Sid) on delete cascade,
	foreign key(Pid) references T_Paper(Pid) on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 活动学科关联表
CREATE TABLE R_Activity_Sub (
	Sid  INT  NOT NULL,
	Aid INT,
	PRIMARY KEY( Aid , Sid ),
	foreign key(Sid) references T_Sub(Sid) on delete cascade,
	foreign key(Aid) references T_Activity(Aid) on delete cascade
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 题目标签关联表
CREATE TABLE R_Question_Tag (
	Qid INT NOT NULL,
	Tid INT NOT NULL,
	PRIMARY KEY( Qid , Tid)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 试卷标签关联表
CREATE TABLE R_Paper_Tag (
	Pid INT NOT NULL,
	Tid INT NOT NULL,
	PRIMARY KEY( Pid , Tid)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 答卷记录表
CREATE TABLE T_Paper_Record(
	Uid INT NOT NULL ,
	Pid INT NOT NULL,
	PRIMARY KEY( Uid , Pid ),
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Data_lastchange_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	AllCount INT,
	FinishedCount INT,
	Answer text,
	TimePassed INT DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 答卷成绩表
CREATE TABLE T_Paper_Finished(
	Uid INT NOT NULL ,
	Pid INT NOT NULL,
	PRIMARY KEY( Uid , Pid ),
	Data_lastchange_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	AllCount INT DEFAULT 0,
	FinishedCount INT DEFAULT 0,
	RightCount INT DEFAULT 0,
	TimeUsed INT DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 答题记录表
CREATE TABLE T_Ques_Record(
	Uid INT NOT NULL ,
	Qid INT NOT NULL,
	PRIMARY KEY( Uid , Qid ),
	Data_lastchange_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Answer text
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 管理员账号表
CREATE TABLE T_Admin_User(
	Uid int not null primary key auto_increment,
	UserName CHAR(200) not null ,
	Password CHAR(200) not null,
	Role INT DEFAULT 0,
	RandomText CAHR(200)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 默认管理员账号
INSERT INTO T_Admin_User ( UserName , Password ) VALUES ( "admin" , "admin ");


-- 用户收藏学科关联表
CREATE TABLE R_User_Sub(
	Uid INT NOT NULL ,
	Sid INT NOT NULL,
	PRIMARY KEY( Uid , Sid ),
	foreign key(Sid) references T_Sub(Sid) on delete cascade,
	foreign key(Uid) references T_UserInfo(Uid) on delete cascade,
	Data_lastchange_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
