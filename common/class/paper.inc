<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class paper extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function paper(){
		$this->BaseTable();
		$this->setTableName('t_paper');		
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

	   
	  /*����Pid���в�ѯ*/
	 function  s_Search($Pid="") {
		
		$Str='';
		if(strlen($Pid)>0){			
			$Str.=" AND Pid='$Pid'";			
		}
		
		$strOrderby=" order by Pid desc";
		$strSQL="SELECT * FROM t_paper  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_paper Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /* ��ȡ���е�����/��ȡ��µ��Ծ�����/��ȡָ��ѧ�����Ծ�*/
	    function  a_Search( $Aid = 0 ,$Sid = 0 ) {
		$strOrderby=" order by Pid desc";
		if( $Sid == 0 ){ 
			if( $Aid == 0 )
				//��ѯ���е�ѧ��
				$strSQL="SELECT * FROM t_paper  Where 1 ".$strOrderby;
			else	
				//��ѯָ����µ��Ծ�����
				$strSQL = "SELECT p.* from t_paper p join r_sub_paper rsp on p.pid = rsp.pid 
							join r_activity_sub ras on ras.sid = rsp.sid and ras.aid = '$Aid' ";	
		}else{ 
			//��ѯָ��ѧ���µ��Ծ�
			$strSQL = "SELECT p.* from t_paper p join r_sub_paper r
						on p.pid = r.pid and r.sid = '$Sid' ";		
		}
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_paper Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   	  
  /*���ݴ���*/ 
		function getPid(){
			return $this-> getAttriValue('Pid');
		}
		function getPname(){
			return $this-> getAttriValue('Pname');
		}
		function getLimitTime(){
			return $this-> getAttriValue('LimitTime');
		}
		 function setPname($a){
			$this->setAttriValue('Pname',$a) ;
		}
		  function setLimitTime($a){
			$this->setAttriValue('LimitTime',$a) ;
		}
		
	}