<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class r_act_sub extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function r_act_sub(){
		$this->BaseTable();
		$this->setTableName('r_activity_sub');		
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

	   
	  /*根据Aid进行查询*/
	 function  s_Search($Aid=0) {
		
		$Str='';
		if(strlen($Aid)>0){			
			$Str.=" AND Aid='$Aid'";			
		}
		
		$strOrderby=" order by Aid desc";
		$strSQL="SELECT * FROM r_activity_sub  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search r_activity_sub Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
    
   
	   	  
  /*数据传递*/ 
		function getAid(){
			return $this-> getAttriValue('Aid');
		}
		function getSid(){
			return $this-> getAttriValue('Sid');
		}
		 function setAid($a){
			$this->setAttriValue('Aid',$a) ;
		}
		 function setSid($a){
			$this->setAttriValue('Sid',$a) ;
		}
		 
		
	}