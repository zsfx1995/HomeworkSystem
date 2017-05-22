<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class r_user_sub extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function r_user_sub(){
		$this->BaseTable();
		$this->setTableName('r_user_sub');		
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

	   
	 function  s_Search($Uid=0) {
		
		$Str='';
		if(strlen($Uid)>0){			
			$Str.=" AND Uid='$Uid'";			
		}
		
		$strOrderby=" order by Sid desc";
		$strSQL="SELECT * FROM r_user_sub  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search r_user_sub Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
    
   
	   	  
  /*数据传递*/ 
		function getSid(){
			return $this-> getAttriValue('Sid');
		}
		function getUid(){
			return $this-> getAttriValue('Uid');
		}
		 function setSid($a){
			$this->setAttriValue('Sid',$a) ;
		}
		 function setUid($a){
			$this->setAttriValue('Uid',$a) ;
		}
		 
		
	}