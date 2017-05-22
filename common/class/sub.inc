<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class sub extends BaseTable{
	 /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function sub(){
		$this->BaseTable();
		$this->setTableName('t_sub');		
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

	   
	  /*根据Sid进行查询*/
	 function  s_Search($Sid="") {
		
		$Str='';
		if(strlen($Sid)>0){			
			$Str.=" AND Sid='$Sid'";			
		}
		
		$strOrderby=" order by Sid desc";
		$strSQL="SELECT * FROM t_sub  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_sub Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /* 获取所有的数据/获取活动下的学科数据*/
	    function  a_Search( $Aid = 0, $page = -1 ) {
			$limitStr = $page >= 1 ? 
				" limit " . NUM_OF_ONE_PAGE_SUB * ( $page - 1) . "," . NUM_OF_ONE_PAGE_SUB
				: $limitStr = "";
			$strOrderby=" order by Sid ASC";
			
			$strSQL = $Aid == 0 ? "SELECT * FROM t_sub  Where 1 "
					: "select s.* from t_sub s join r_activity_sub r on s.sid = r.sid and r.aid = '$Aid' ";	
			
			$strSQL .= $strOrderby .= $limitStr;
			//echo $strSQL;
			
			$tmp_result=$this->openQuery($strSQL) ;
			if(!$tmp_result){
				$this->setError(@mysql_error($this->db_connection),'Search t_sub Error!','user.inc','user',$strSQL);
			}
			return $tmp_result;
   } 
   
   /* 获取指定Uid收藏的学科数据*/
	    function  u_Search( $Uid = 0, $page = -1 ) {
			$limitStr = $page >= 1 ? 
				" limit " . NUM_OF_ONE_PAGE_SUB * ( $page - 1) . "," . NUM_OF_ONE_PAGE_SUB
				: $limitStr = "";
			$strOrderby=" order by Sid ASC";
			
			$strSQL = $Uid == 0 ? "SELECT * FROM t_sub  Where 1 "
					: "select s.* from t_sub s join r_user_sub r on s.sid = r.sid and r.uid = '$Uid' ";	
			
			$strSQL .= $strOrderby .= $limitStr;
			
			
			$tmp_result=$this->openQuery($strSQL) ;
			if(!$tmp_result){
				$this->setError(@mysql_error($this->db_connection),'Search t_sub Error!','user.inc','user',$strSQL);
			}
			return $tmp_result;
   }  
   
	   	  
  /*数据传递*/ 
		function getSid(){
			return $this-> getAttriValue('Sid');
		}
		function getSname(){

			return $this-> getAttriValue('Sname');
		}
		function getDescription(){

			return $this-> getAttriValue('Description');
		}
		function getDataCreateTime(){

			return $this-> getAttriValue('Data_create_time');
		}
		function getPicUrl(){

			return $this-> getAttriValue('PicUrl');
		}
		
		 function setSname($a){
			$this->setAttriValue('Sname',$a) ;
		}
		 
		 function setName($a){
			$this->setAttriValue('Sname',$a) ;
		}
		 function setDescription($a){
			$this->setAttriValue('Description',$a) ;
		 }
		 
		  function setPicUrl($a){
			$this->setAttriValue('PicUrl',$a) ;
		}
		
	}