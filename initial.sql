use D_HomeworkSystem;
-- 插入用户数据
insert into T_userinfo( UserName , PassWord , Mail , PhoneNum ) VALUES ( 'xushuang' , '12345678' , '123@qq.com' , '1234567899'  );
-- 插入分区数据
insert into T_Activity( Aname ) VALUES ( '中山大学');
-- 插入学科数据
insert into  T_Sub ( Sname ) VALUES ( '马克思原理' );
insert into  T_Sub ( Sname ) VALUES ( '近代史(独立学科)' );
-- 插入试卷数据
insert into T_Paper ( Pname , LimitTime ) VALUES ( '马克思原理试卷1' , 180 );
insert into T_Paper ( Pname , LimitTime ) VALUES ( '近代史试卷1' , 180 );
-- 插入题目数据
insert into T_Question ( Qtype , Detail , Ans ) VALUES ( 1 , '马克思题目1' , 'A' );
insert into T_Question ( Qtype , Detail , Ans ) VALUES ( 1 , '近代史题目1' , 'B' );
insert into T_Question ( Qtype , Detail , Ans ) VALUES ( 1 , '独立题目1' , 'B' );
-- 关联 题目 - 试卷
insert into R_Paper_Ques ( Qid , Pid ) VALUES ( 1 , 1 );
insert into R_Paper_Ques ( Qid , Pid ) VALUES ( 2 , 2 );
-- 关联 试卷 - 学科
insert into R_sub_paper ( Pid , Sid ) VALUES ( 1 , 1 );
insert into R_sub_paper ( Pid , Sid ) VALUES ( 2 , 2 );
-- 关联 学科- 分区
insert into R_Activity_Sub( Sid , Aid ) VALUES ( 1 , 1 );

-- 插入管理员账号
insert into T_Admin_User( UserName , Password  ) VALUES ( "admin" , "admin" );


