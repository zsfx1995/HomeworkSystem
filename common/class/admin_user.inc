<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class admin_user extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function admin_user(){
		$this->BaseTable();
		$this->setTableName('t_admin_user');		
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
	 function  s_Search($Uid="" ) {
		
		$Str='';
		if(strlen($Uid)>0){			
			$Str.=" AND Uid='$Uid'";			
		}
		
		$strOrderby=" order by Uid desc";

		$strSQL="SELECT * FROM t_admin_user  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_admin_user Error!','admin_user.inc','admin_user',$strSQL);
		}
		return $tmp_result;
   }  

	  
	  /*����У��*/
	 function  checkID ( $username , $password  ) {
		
			
		$Str.=" AND username = '$username' AND password = '$password' ";			
		
		
		$strOrderby=" order by UserName desc";

		$strSQL="SELECT * FROM t_admin_user  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_admin_user Error!','admin_user.inc','admin_user',$strSQL);
		}
		return $tmp_result;
   }    
	   	  
  /*���ݴ���*/ 
		function getUid(){
			return $this-> getAttriValue('Uid');
		}
		function getUserName(){
			return $this-> getAttriValue('UserName');
		}
		function getPassword(){
		
			return $this-> getAttriValue('password');
		}
		function getRole(){
			return $this-> getAttriValue('Role');
		}
		
		
		 function setUserName($a){
			$this->setAttriValue('UserName',$a) ;
		}
		function setPassword($a){
			$this->setAttriValue('Password',$a) ;
		}
		function setRole($a){
			$this->setAttriValue('Role',$a) ;
		}
	}