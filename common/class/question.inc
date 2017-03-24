<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class question extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function question(){
		$this->BaseTable();
		$this->setTableName('t_question');		
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
   
   /* 获取所有/指定活动/指定学科/指定试卷下所有题目*/
	    function  a_Search( $Aid = 0 ,$Sid = 0 , $Pid = 0 , $page = -1 ) {
			$limitStr = $page >= 1 ? 
				" limit " . NUM_OF_ONE_PAGE_PAPER* ( $page - 1) . "," . NUM_OF_ONE_PAGE_QUESTION
				: $limitStr = "";
			$strOrderby=" order by Qid ASC";
			if( $Pid == 0 ){
				if( $Sid == 0 ){ 
					if( $Aid == 0 )
						//查询所有的题目
						$strSQL="SELECT * FROM t_question  Where 1 ".$strOrderby;
					else	
						//查询指定活动下的题目
						$strSQL = "select q.* from t_question q join r_paper_ques rpq
							on q.qid = rpq.qid 
							join r_sub_paper rsp 
							on rsp.pid = rpq.pid 
							join r_activity_sub ras
							on ras.sid = rsp.sid and ras.aid = '$Aid' ";	
				}else{
					//查询指定学科下的题目
					$strSQL = "select q.* from t_question q join r_paper_ques rpq 
						on q.qid = rpq.qid
						join r_sub_paper rsp 
						on rsp.pid = rpq.pid and rsp.sid = '$Sid' ";		
				}
			}else{
				//查询指定试卷下的题目
				$strSQL = "select q.* from t_question q join r_paper_ques r 
					on q.qid = r.qid and r.pid = '$Pid' ";	
			}
			$strSQL .= $limitStr;
			$tmp_result=$this->openQuery($strSQL) ;
			if(!$tmp_result){
				$this->setError(@mysql_error($this->db_connection),'Search t_question Error!','user.inc','user',$strSQL);
			}
			return $tmp_result;
   }  
   
	   	  
  /*数据传递*/ 
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
		function getData_Create_time(){
			return $this-> getAttriValue('Data_Create_time');
		}
		function setType($a){
			$this->setAttriValue('Qtype',$a) ;
		}
		 function setDetail($a){
			$this->setAttriValue('Detail',$a) ;
		}
		 function setAns($a){
			$this->setAttriValue('Ans',$a) ;
		}
		 function setTips($a){
			$this->setAttriValue('Tips',$a) ;
		}
		
	}