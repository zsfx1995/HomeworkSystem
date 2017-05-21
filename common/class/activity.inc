<?php
	
	include_once("../../common/include/common.inc");

	class activity extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function activity(){
		$this->BaseTable();
		$this->setTableName('t_activity');		
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
	 function  s_Search($Aid="") {
		
		$Str='';
		if(strlen($Aid)>0){			
			$Str.=" AND Aid='$Aid'";			
			
		}
		
		$strOrderby=" order by Aid desc";
		$strSQL="SELECT * FROM t_activity  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_activity Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /* 获取所有的数据*/
	    function  a_Search( $page = -1 ) {
		$limitStr = $page >= 1 ? 
			" limit " . NUM_OF_ONE_PAGE_ACTIVITY * ( $page - 1) . "," . NUM_OF_ONE_PAGE_ACTIVITY
			: $limitStr = "";
		$strOrderby=" order by Aid asc";
		$strSQL="SELECT * FROM t_activity  Where 1 ".$strOrderby .$limitStr ;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_activity Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /* 按页获取所有的数据*/
	    function  a_SearchByPage( $page ) {
		
		$limitStr = " limit " . NUM_OF_ONE_PAGE_ACTIVITY * $page . "," . NUM_OF_ONE_PAGE_ACTIVITY ;
		$strOrderby=" order by Aid asc";
		$strSQL="SELECT * FROM t_activity  Where 1 ".$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_activity Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   	  
  /*数据传递*/ 
		function getAid(){
			return $this-> getAttriValue('Aid');
		}
		function getAname(){
			return $this-> getAttriValue('Aname');
		}
		function getDescription(){
			return $this-> getAttriValue('Description');
		}
		 function getDataCreateTime(){
			return $this-> getAttriValue('Data_create_time');
		}
		 function setPicUrl($a){
			$this->setAttriValue('PicUrl',$a) ;
		}
		 function getPicUrl(){
			return $this-> getAttriValue('PicUrl');
		}
		 function setAname($a){
			$this->setAttriValue('Aname',$a) ;
		}
		 function setDescription($a){
			$this->setAttriValue('Description',$a) ;
		}
		 
		
	}