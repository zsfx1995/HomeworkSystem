<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class question extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function question(){
		$this->BaseTable();
		$this->setTableName('t_question');		
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
	 function  s_Search($Qid="") {
		
		$Str='';
		if(strlen($Qid)>0){			
			$Str.=" AND Qid='$Qid'";			
		}
		
		$strOrderby=" order by Qid desc";
		$strSQL="SELECT * FROM t_question  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_question Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /* ��ȡ����/ָ���/ָ��ѧ��/ָ���Ծ���������Ŀ*/
	    function  a_Search( $Aid = 0 ,$Sid = 0 , $Pid) {
		$strOrderby=" order by Qid desc";
		if( $Pid == 0 ){
			if( $Sid == 0 ){ 
				if( $Aid == 0 )
					//��ѯ���е���Ŀ
					$strSQL="SELECT * FROM t_question  Where 1 ".$strOrderby;
				else	
					//��ѯָ����µ���Ŀ
					$strSQL = "select q.* from t_question q join r_paper_ques rpq
						on q.qid = rpq.qid 
						join r_sub_paper rsp 
						on rsp.pid = rpq.pid 
						join r_activity_sub ras
						on ras.sid = rsp.sid and ras.aid = '$Aid' ";	
			}else{
				//��ѯָ��ѧ���µ���Ŀ
				$strSQL = "select q.* from t_question q join r_paper_ques rpq 
					on q.qid = rpq.qid
					join r_sub_paper rsp 
					on rsp.pid = rpq.pid and rsp.sid = '$Sid' ";		
			}
		}else{
			//��ѯָ���Ծ��µ���Ŀ
			$strSQL = "select q.* from t_question q join r_paper_ques r 
				on q.qid = r.qid and r.pid = '$Pid' ";	
		}
		
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_question Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
	   	  
  /*���ݴ���*/ 
		function getQid(){
			return $this-> getAttriValue('Qid');
		}
		function getType(){
			return $this-> getAttriValue('Qtype');
		}
		function getDetail(){
			return $this-> getAttriValue('Detail');
		}
		function getAns(){
			return $this-> getAttriValue('Ans');
		}
		function getTips(){
			return $this-> getAttriValue('Tips');
		}
		
		function setType($a){
			$this->setAttriValue('Qtype',$a) ;
		}
		 function setDetail($a){
			$this->setAttriValue('Detail',$a) ;
		}
		 function setAns($a){
			$this->setAttriValue('QAns',$a) ;
		}
		 function setTips($a){
			$this->setAttriValue('Tips',$a) ;
		}
		
	}