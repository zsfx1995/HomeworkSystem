<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class paper_finished extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function paper_finished(){
		$this->BaseTable();
		$this->setTableName('t_paper_finished');		
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

	   
	  /*����Uid Pid���в�ѯ*/
	 function  s_Search( $Uid = 0 , $Pid= 0 ) {
		
		$Str='';
		if(  $Uid > 0 ){			
			$Str.=" AND Uid = '$Uid' ";			
		}
		if(  $Pid > 0 ){			
			$Str.=" AND Pid = '$Pid' ";			
		}
		
		$strOrderby=" order by Pid desc";
		$strSQL="SELECT * FROM t_paper_finished  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_paper_finished Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   
  /*���ݴ���*/ 
		
		function getUid(){
			return $this-> getAttriValue('Uid');
		}
		function getPid(){
			return $this-> getAttriValue('Pid');
		}
		function getTimeUsed(){
			return $this-> getAttriValue('TimePassed');
		}
		function getAllCount(){
			return $this-> getAttriValue('AllCount');
		}
		function getFinishedCount(){
			return $this-> getAttriValue('FinishedCount');
		}
		function getRightCount(){
			return $this-> getAttriValue('RightCount');
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
		 function setTimeUsed($a){
			$this->setAttriValue('TimeUsed',$a) ;
		}
		 function setAllCount($a){
			$this->setAttriValue('AllCount',$a) ;
		}
		 function setRightCount($a){
			$this->setAttriValue('RightCount',$a) ;
		}
		 function setFinishedCount($a){
			$this->setAttriValue('FinishedCount',$a) ;
		}
		 function setData_lastchange_time($a){
			$this->setAttriValue('Data_lastchange_time',$a) ;
		}
		
		
	}