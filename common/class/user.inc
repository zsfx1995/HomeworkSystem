<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class user extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function user(){
		$this->BaseTable();
		$this->setTableName('t_userinfo');		
	}  
	
      /*��������*/
	function  addRecorded(){
 	   if($this->addRecord()){			
			 return true;
		 		}
		 	else{			
				return false;
					}
	   }
	  /*��������*/    
	 function  updateRecorded() {
			if($this->updateRecord()){
				return true;}
			else{
				return false;}
	   }
	   /*ɾ������*/  	 
	  function  deleteRecorded() {
		if($this->deleteRecord())
			return true;
		else
			return false;
	   }

	   
	  /*����UID���в�ѯ*/
	 function  s_Search($Uid="") {
		
		$Str='';
		if(strlen($Uid)>0){			
			$Str.=" AND Uid='$Uid'";			
		}
		
		$strOrderby=" order by Uid desc";

		$strSQL="SELECT * FROM t_userinfo  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_userinfo Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /*������֤��ѯ*/
   function  searchuser($type,$login_name,$login_pwd){	
		if( $type == 1 ){
			$strSQL="SELECT * FROM t_userinfo where 1=1 and mail ='$login_name'&&password='$login_pwd'";
		}else{
			$strSQL="SELECT * FROM t_userinfo where 1=1 and phoneNum ='$login_name'&&password='$login_pwd'";
		}
		
		$tmp_result=$this->openQuery($strSQL) ;
		
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Searche t_userinfo Error!','user.inc','user',$strSQL);
		    return false;
		}	
	
		return $tmp_result;	
	}
   
   
	    /*�˶��û����Ƿ�ʹ��*/
	function  CheckNewUserID($type , $mail , $phone ){		
		if( $type == 1 )
			$strSQL="SELECT * FROM t_userinfo where 1=1 and mail ='$mail'";
		else
			$strSQL="SELECT * FROM t_userinfo where 1=1 and phoneNum ='$phone'";
		$tmp_result=$this->openQuery($strSQL) ;
		
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Searche t_user_info Error!','user.inc','user',$strSQL);
		    return false;
		}	
		return $tmp_result;	
	   }
	   
	   	  
  /*���ݴ���*/ 
		function getUid(){
			return $this-> getAttriValue('Uid');
		}
		function getUserName(){
			return $this-> getAttriValue('userName');
		}
		function getPassword(){
		
			return $this-> getAttriValue('password');
		}
		function getMail(){
			return $this-> getAttriValue('mail');
		}
		function getPhoneNum(){
			return $this-> getAttriValue('phoneNum');
		}
		function getAcitivityList(){
			return $this-> getAttriValue('acitivityList');
		}
		function getSubList(){
			return $this-> getAttriValue('subList');
		}
		function getScore(){
			return $this-> getAttriValue('score');
		}
		
		 function setUserName($a){
			$this->setAttriValue('UserName',$a) ;
		}
		function setPassword($a){
			$this->setAttriValue('Password',$a) ;
		}
		function setMail($a){
			$this->setAttriValue('Mail',$a) ;
		}
		function setPhoneNum($a){
			$this->setAttriValue('PhoneNum',$a) ;
		}
		function setAcitivityList($a){
			$this->setAttriValue('AcitivityList',$a) ;
		}
		function setSubList($a){
			$this->setAttriValue('Sublist',$a) ;
		}
		function setScore($a){
			$this->setAttriValue('Score',$a) ;
		}
		}