<?php
/*****************************************************************
 @名称：数据库表的抽象类 
 @功能：	（1）设定数据库表的基本信息，包括表的名称、字段名称及其对应字段的值，查询条件等信息。
 （2）执行添加、更新和删除等数据库查询与操作。
 （3）完成数据库查询结果中返回一个记录的信息

*/

class BaseTable extends BaseDatabase{

	var $fer="##@@##";
	var $table_name='';
	var $condition=array();
	var $attributes=array();

	/*
	@功能：建构函数
	*/
	function BaseTable(){
		$this->BaseDataBase();
	}

	/*
	@功能：设定数据库表的名称
	*/
	function setTableName($param_table_name){
		$this->table_name=strtolower($param_table_name);
		return true;
	}

	/*
	@功能：获得数据库表的名称
	*/
	function getTableName(){
		return $this->table_name;
	}

	/*
	@功能：根据字段名称设定字段的值，用于设定数据库表的字段的值
	*/
	function setAttriValue($param_attri_name,$param_attri_value){
		$this->attributes[$param_attri_name]=$param_attri_value;
		//echo 'baseTable -> setAttriValue debug : '. $param_attri_name . ' ' .$param_attri_value;
		return true;
	}

	/*
	@功能：根据字段名称获得字段的值
	*/
	function getAttriValue($param_attri_name){
		$param_attri_name = strtolower( $param_attri_name );
		if(!isset($this->attributes[$param_attri_name]))$this->attributes[$param_attri_name]="";
		return $this->attributes[$param_attri_name]; 
	}
	
	/*
	@功能：获得数据库表的某个记录的所有字段信息
	*/
	function getAttributes(){
		return $this->attributes;
	}
	
	/*
	@功能：从查询结果中获得一个记录，该方法主要用于从查询结果中获得信息。
	*/
	function getOneRecord(){
		$this->attributes=$this->getRecord();
		return $this->attributes;
	}
	
	/*
	@功能：将当前数据库表中的某个字段初始化，即清空。
	*/
	function freeAttributes(){
		$this->attributes=array();
		return true;
	}	

	/*
	@功能：设定查询或操作的条件。
	*/
	function setCondition($param_attri_name,$param_attri_value){
		$this->condition[$param_attri_name]=$param_attri_value;
		return true;
	}
	/*
	@功能：获得设定的查询条件。
	*/
	function getCondition(){
		return $this->condition;
	}

	/*	@功能：根据当前设定的数据库表的字段名称和其对应的值，并将其添加到数据库中，使其成为数据库的一个记录。
	*/
	function addRecord(){
		$tmp_table		=$this->getTableName();
		$tmp_attri		=$this->getAttributes();

		$sql="insert into ".$tmp_table." ";
		$sql1="(";
		$sql2=") values(";
		//$arr=$tmp_attri;

		for(reset($tmp_attri); $key=key($tmp_attri); next($tmp_attri)){
			$sql1=$sql1.$key.",";
			
			if(strcmp($tmp_attri[$key],$this->fer)==0){
				$this->setError($key.'数据格式不正确','存储失败','baseTable.php','BaseCollect','');
				return false;
			}
			$value=stripslashes($tmp_attri[$key]);
			$value=str_replace("'","''",$value);
			
			$sql2=$sql2."'".$value."',";
			
		}

		//去掉最后一个逗号
		$sql1=substr($sql1,0,strlen($sql1)-1); 
		$sql2=substr($sql2,0,strlen($sql2)-1);
		$sql2=$sql2.")";
		$sql=$sql.$sql1.$sql2;
		
		//执行生成的SQL语句
		
		
		if(!$this->executeOperation($sql)){
			return false;
		}else{
			return true;
		}
	}

	/*	@功能：根据当前设定的数据库表的字段名称和其对应的值以及设定的更新条件，并将其更新到数据库中。
	*/
	function updateRecord(){		
		$tmp_table		=$this->getTableName();
		$tmp_attri		=$this->getAttributes();

		$tmp_condition	= $this->getCondition();		

		$sql="update ".$tmp_table." set ";		
		for(reset($tmp_attri); $key=key($tmp_attri); next($tmp_attri)){
			if(strcmp($tmp_attri[$key],$this->fer)==0){
				$this->setError($key.'数据格式不正确','存储失败','base_collect.php','BaseCollect');
				return false;
			}
			
			$value=stripslashes($tmp_attri[$key]);
			$value=str_replace("'","''",$value);
						
			$sql=$sql.$key."='".$value."', ";
					
		}
		$sql=substr($sql,0,strlen($sql)-2);
		$sql=$sql." where ";

		for(reset($tmp_condition); $key=key($tmp_condition); next($tmp_condition)){
			if(strcmp($tmp_condition[$key],$this->fer)==0){
				$this->setError($key.'数据格式不正确','存储失败','base_collect.php','BaseCollect');
					return false;
			}
			
			$sql=$sql.$key."='".$tmp_condition[$key]."' and ";
			
		}
		$sql=substr($sql,0,strlen($sql)-4);

        //echo $sql;		
		if(!$this->executeOperation($sql)){
			return false;
		}else
			return true;
	}

	/*
	@功能：根据当前设定的删除条件，将符合条件的记录从数据库中删除。
	*/
	function deleteRecord(){	  
		$tmp_table		= $this->getTableName();
		$tmp_attri		=$this->getRecord();

		$tmp_condition	= $this->getCondition();

		$sql="delete from ".$tmp_table." where ";
		
		for(reset($tmp_condition); $key=key($tmp_condition); next($tmp_condition)){
			if(strcmp($tmp_condition[$key],$this->fer)==0){
				$this->setError($key.'数据格式不正确');
				return false;
			}
			
			$sql=$sql.$key."='".$tmp_condition[$key]."' and ";
			
		}
		$sql=substr($sql,0,strlen($sql)-4);
		
		if(!$this->executeOperation($sql)){
			return false;
		}else
			return true;
	}

}

?>