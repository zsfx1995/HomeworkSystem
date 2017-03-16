<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class question_mark extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function question_mark(){
		$this->BaseTable();
		$this->setTableName('t_question_mark');		
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

	   
	  /*根据Uid 和 Qid查询
		若Qid为空则查询UID下的所有题
	  */
	 function  s_Search( $Uid = 0 , $Qid = 0  ) {
		
				
		$Str = " AND Uid = '$Uid' ";			
		if( $Qid > 0 ){
			$Str .= " AND Qid = '$Qid' ";
		}
		
		$strOrderby=" order by Qid desc";
		$strSQL="SELECT * FROM t_question_mark  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_question_mark Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   

  /*数据传递*/ 
		
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
		function getRemark(){
			return $this-> getAttriValue('Remark');
		}
		function setRemark($a){
			$this->setAttriValue('Remark',$a) ;
		}
		
	}