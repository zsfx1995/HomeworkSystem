<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class paper_record extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function paper_record(){
		$this->BaseTable();
		$this->setTableName('t_paper_record');		
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

	   
	  /*根据Uid Pid进行查询*/
	 function  s_Search( $Uid = 0 , $Pid= 0 ) {
		
		$Str='';
		if( $Pid >0 AND $Uid > 0 ){			
			$Str.=" AND Pid='$Pid' AND Uid = '$Uid' ";			
		}
		
		$strOrderby=" order by Pid desc";
		$strSQL="SELECT * FROM t_paper_record  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_paper_record Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   
  /*数据传递*/ 
		
		function getAns(){
			return $this-> getAttriValue('Answer');
		}
		function getTimePassed(){
			return $this-> getAttriValue('TimePassed');
		}
		function getAllCount(){
			return $this-> getAttriValue('AllCount');
		}
		function getFinishedCount(){
			return $this-> getAttriValue('FinishedCount');
		}
		function getData_lastchange_time(){
			return $this-> getAttriValue('Data_lastchange_time');
		}
		
		function setUid($a){
			$this->setAttriValue('Uid',$a) ;
		}
		function setPid($a){
			$this->setAttriValue('Pid',$a) ;
		}
		 function setAns($a){
			$this->setAttriValue('Answer',$a) ;
		}
		 function setTimePassed($a){
			$this->setAttriValue('TimePassed',$a) ;
		}
		 function setAllCount($a){
			$this->setAttriValue('AllCount',$a) ;
		}
		 function setFinishedCount($a){
			$this->setAttriValue('FinishedCount',$a) ;
		}
		 function setData_lastchange_time($a){
			$this->setAttriValue('Data_lastchange_time',$a) ;
		}
		
		
	}