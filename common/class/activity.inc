<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class activity extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function activity(){
		$this->BaseTable();
		$this->setTableName('t_activity');		
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

	   
	  /*����Aid���в�ѯ*/
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
   
   /* ��ȡ���е�����*/
	    function  a_Search() {
		
		
		$strOrderby=" order by Aid desc";
		$strSQL="SELECT * FROM t_activity  Where 1 ".$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_activity Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   	  
  /*���ݴ���*/ 
		function getAid(){
			return $this-> getAttriValue('Aid');
		}
		function getAname(){

			return $this-> getAttriValue('Aname');
		}
		 function setAname($a){
			$this->setAttriValue('Aname',$a) ;
		}
		
	}