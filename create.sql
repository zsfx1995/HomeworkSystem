DROP DATABASE IF EXISTS D_HomeworkSystem;
CREATE DATABASE D_HomeworkSystem CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'; 
use D_HomeworkSystem;
-- ���û�������Ϣ��
CREATE TABLE T_UserInfo (
	Uid int not null primary key auto_increment,
	UserName CHAR(200) not null ,
	Password CHAR(200) not null,
	Mail CHAR(200) ,
	PhoneNum CHAR(200),
	AcitivityList text,
	SubList text,
	Score int not null DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 
-- �������
CREATE TABLE T_Question_Wrong (
	Uid INT	 ,
	Qid INT ,
	PRIMARY KEY( Uid , Qid )
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 
-- ���ղ����
CREATE TABLE T_Question_Mark (
	Uid INT	 ,
	Qid INT ,
	PRIMARY KEY( Uid , Qid ),
	Remark TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- �������
CREATE TABLE T_Question(
	Qid INT not null PRIMARY KEY AUTO_INCREMENT,
	Qtype INT NOT NULL DEFAULT 0,
	Detail text ,
	Ans TEXT,
	Tips TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- �Ծ��
CREATE TABLE T_Paper(
	Pid INT PRIMARY KEY AUTO_INCREMENT,
	Pname CHAR(200),
	LimitTime INT DEFAULT 0,
	Description TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ѧ�Ʊ�
CREATE TABLE T_Sub(
	Sid INT  PRIMARY KEY AUTO_INCREMENT,
	Sname CHAR(200),
	Description TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ���
CREATE TABLE T_Activity(
	Aid INT PRIMARY KEY AUTO_INCREMENT,
	Aname CHAR(200),
	Description TEXT,
	Data_create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PicUrl TEXT DEFAULT "http://119.23.132.163/image/activity/sysu.jpg"
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ��ǩ��
CREATE TABLE T_Tag(
	Tid INT PRIMARY KEY AUTO_INCREMENT,
	Tname CHAR(200)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- �Ծ���Ŀ������
CREATE TABLE R_Paper_Ques(
	Qid INT PRIMARY KEY NOT NULL,
	Pid INT 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ѧ���Ծ������
CREATE TABLE R_Sub_Paper (
	Pid INT PRIMARY KEY NOT NULL,
	Sid INT
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- �ѧ�ƹ�����
CREATE TABLE R_Activity_Sub (
	Sid  INT PRIMARY KEY NOT NULL,
	Aid INT
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ��Ŀ��ǩ������
CREATE TABLE R_Question_Tag (
	Qid INT NOT NULL,
	Tid INT NOT NULL,
	PRIMARY KEY( Qid , Tid)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- �Ծ��ǩ������
CREATE TABLE R_Paper_Tag (
	Pid INT NOT NULL,
	Tid INT NOT NULL,
	PRIMARY KEY( Pid , Tid)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ����¼��
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
-- ���ɼ���
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
-- �����¼��
CREATE TABLE T_Ques_Record(
	Uid INT NOT NULL ,
	Qid INT NOT NULL,
	PRIMARY KEY( Uid , Qid ),
	Data_lastchange_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Answer text
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ����Ա�˺ű�
CREATE TABLE T_Admin_User(
	Uid int not null primary key auto_increment,
	UserName CHAR(200) not null ,
	Password CHAR(200) not null,
	Role INT DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8;