<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class paper extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function paper(){
		$this->BaseTable();
		$this->setTableName('t_paper');		
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

	   
	  /*根据Pid进行查询*/
	 function  s_Search($Pid="") {
		
		$Str='';
		if(strlen($Pid)>0){			
			$Str.=" AND Pid='$Pid'";			
		}
		
		$strOrderby=" order by Pid asc";
		$strSQL="SELECT * FROM t_paper  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_paper Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /* 获取所有的数据/获取活动下的试卷数据/获取指定学科下试卷*/
	    function  a_Search( $Aid = 0 ,$Sid = 0 , $page = -1 ) {
		$limitStr = $page >= 1 ? 
			" limit " . NUM_OF_ONE_PAGE_PAPER* ( $page - 1) . "," . NUM_OF_ONE_PAGE_PAPER
			: $limitStr = "";
		
		$strOrderby=" order by Pid asc";
		if( $Sid == 0 ){ 
			if( $Aid == 0 )
				//查询所有的学科
				$strSQL="SELECT * FROM t_paper  Where 1 ".$strOrderby;
			else	
				//查询指定活动下的试卷数据
				$strSQL = "SELECT p.* from t_paper p join r_sub_paper rsp on p.pid = rsp.pid 
							join r_activity_sub ras on ras.sid = rsp.sid and ras.aid = '$Aid' ";	
		}else{ 
			//查询指定学科下的试卷
			$strSQL = "SELECT p.* from t_paper p join r_sub_paper r
						on p.pid = r.pid and r.sid = '$Sid' ";		
		}
		$strSQL .= $limitStr;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_paper Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   	  
  /*数据传递*/ 
		function getPid(){
			return $this-> getAttriValue('Pid');
		}
		function getPname(){
			return $this-> getAttriValue('Pname');
		}
		
		function getDescription(){
			return $this-> getAttriValue('Description');
		}
		function getDataCreateTime(){
			return $this-> getAttriValue('Data_create_time');
		}
		
		function getLimitTime(){
			return $this-> getAttriValue('LimitTime');
		}
		 function setPname($a){
			$this->setAttriValue('Pname',$a) ;
		}
		 function setDescription($a){
			$this->setAttriValue('Description',$a) ;
		 }
		  function setLimitTime($a){
			$this->setAttriValue('LimitTime',$a) ;
		}
		
	}