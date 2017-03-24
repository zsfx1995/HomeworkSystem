<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class admin_user extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function admin_user(){
		$this->BaseTable();
		$this->setTableName('t_admin_user');		
	}  
	
      /*增加数据*/
	function  addRecorded(){
 	   if($this->addRecord()){			
			 return true;
		 		}
		 	else{			
				return false;
					}
	   }
	  /*更新数据*/    
	 function  updateRecorded() {
			if($this->updateRecord()){
				return true;}
			else{
				return false;}
	   }
	   /*删除数据*/  	 
	  function  deleteRecorded() {
		if($this->deleteRecord())
			return true;
		else
			return false;
	   }

	   
	  /*根据UID进行查询*/
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

	  
	  /*身份校验*/
	 function  checkID ( $username , $password  ) {
		
		$Str =" AND UserName = '$username' AND Password = '$password' ";			
		
		$strOrderby=" order by UserName desc";

		$strSQL="SELECT * FROM t_admin_user  Where 1 ".$Str.$strOrderby;
	//	echo $strSQL;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_admin_user Error!','admin_user.inc','admin_user',$strSQL);
		}
		return $tmp_result;
   }    
	   	  
  /*数据传递*/ 
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