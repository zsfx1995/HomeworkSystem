<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class sub extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function sub(){
		$this->BaseTable();
		$this->setTableName('t_sub');		
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

	   
	  /*����Sid���в�ѯ*/
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
   
   /* ��ȡ���е�����/��ȡ��µ�ѧ������*/
	    function  a_Search( $Aid = 0 ) {
		$strOrderby=" order by Sid desc";
		if( $Aid == 0 ){ 
			//��ѯ���е�ѧ��
			$strSQL="SELECT * FROM t_sub  Where 1 ".$strOrderby;
		}else{ 
			//��ѯָ����µ�ѧ��
			$strSQL = "select s.* from t_sub s join r_activity_sub r 
				on s.sid = r.sid and r.aid = '$Aid' ";	
		}
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_sub Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   	  
  /*���ݴ���*/ 
		function getSid(){
			return $this-> getAttriValue('Sid');
		}
		function getSname(){

			return $this-> getAttriValue('Sname');
		}
		 function setSname($a){
			$this->setAttriValue('Sname',$a) ;
		}
		
	}