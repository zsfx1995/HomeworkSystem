use D_HomeworkSystem;
-- �����û�����
insert into T_userinfo( UserName , PassWord , Mail , PhoneNum ) VALUES ( 'xushuang' , '12345678' , '123@qq.com' , '1234567899'  );
-- �����������
insert into T_Activity( Aname ) VALUES ( '��ɽ��ѧ');
-- ����ѧ������
insert into  T_Sub ( Sname ) VALUES ( '���˼ԭ��' );
insert into  T_Sub ( Sname ) VALUES ( '����ʷ(����ѧ��)' );
-- �����Ծ�����
insert into T_Paper ( Pname , LimitTime ) VALUES ( '���˼ԭ���Ծ�1' , 180 );
insert into T_Paper ( Pname , LimitTime ) VALUES ( '����ʷ�Ծ�1' , 180 );
-- ������Ŀ����
insert into T_Question ( Qtype , Detail , Ans ) VALUES ( 1 , '���˼��Ŀ1' , 'A' );
insert into T_Question ( Qtype , Detail , Ans ) VALUES ( 1 , '����ʷ��Ŀ1' , 'B' );
insert into T_Question ( Qtype , Detail , Ans ) VALUES ( 1 , '������Ŀ1' , 'B' );
-- ���� ��Ŀ - �Ծ�
insert into R_Paper_Ques ( Qid , Pid ) VALUES ( 1 , 1 );
insert into R_Paper_Ques ( Qid , Pid ) VALUES ( 2 , 2 );
-- ���� �Ծ� - ѧ��
insert into R_sub_paper ( Pid , Sid ) VALUES ( 1 , 1 );
insert into R_sub_paper ( Pid , Sid ) VALUES ( 2 , 2 );
-- ���� ѧ��- ����
insert into R_Activity_Sub( Sid , Aid ) VALUES ( 1 , 1 );

-- �������Ա�˺�
insert into T_Admin_User( UserName , Password  ) VALUES ( "admin" , "admin" );


