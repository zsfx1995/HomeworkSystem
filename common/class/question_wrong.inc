<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  ���
	 *Date   :2008-4-3
	 * Purpose:������(��,��,ɾ,��,��)
	 ***********************************************************************/

	class question_wrong extends BaseTable{
	     /*
	@���ƣ���������
	@���ܣ���������ͬʱ�趨��������ݿ��������
	*/ 
  function question_wrong(){
		$this->BaseTable();
		$this->setTableName('t_question_wrong');		
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

	   
	  /*����Uid �� Qid��ѯ
		��QidΪ�����ѯUID�µ�������
	  */
	 function  s_Search( $Uid = 0 , $Qid = 0  ) {
		
				
		$Str = " AND Uid = '$Uid' ";			
		if( $Qid > 0 ){
			$Str .= " AND Qid = '$Qid' ";
		}
		
		$strOrderby=" order by Qid desc";
		$strSQL="SELECT * FROM t_question_wrong  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_question_wrong Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   

  /*���ݴ���*/ 
		
		function getUid(){
			return $this-> getAttriValue('Uid');
		}
		function setUid($a){
			$this->setAttriValue('Uid',$a) ;
		}
		function getQid(){
			return $this-> getAttriValue('Qid');
		}
		function setQid($a){
			$this->setAttriValue('Qid',$a) ;
		}
		
		
	}