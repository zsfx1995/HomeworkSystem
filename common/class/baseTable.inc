<?php
/*****************************************************************
 @���ƣ����ݿ���ĳ����� 
 @���ܣ�	��1���趨���ݿ���Ļ�����Ϣ�������������ơ��ֶ����Ƽ����Ӧ�ֶε�ֵ����ѯ��������Ϣ��
 ��2��ִ�����ӡ����º�ɾ�������ݿ��ѯ�������
 ��3��������ݿ��ѯ����з���һ����¼����Ϣ

*/

class BaseTable extends BaseDatabase{

	var $fer="##@@##";
	var $table_name='';
	var $condition=array();
	var $attributes=array();

	/*
	@���ܣ���������
	*/
	function BaseTable(){
		$this->BaseDataBase();
	}

	/*
	@���ܣ��趨���ݿ��������
	*/
	function setTableName($param_table_name){
		$this->table_name=strtolower($param_table_name);
		return true;
	}

	/*
	@���ܣ�������ݿ��������
	*/
	function getTableName(){
		return $this->table_name;
	}

	/*
	@���ܣ������ֶ������趨�ֶε�ֵ�������趨���ݿ�����ֶε�ֵ
	*/
	function setAttriValue($param_attri_name,$param_attri_value){
		$this->attributes[$param_attri_name]=$param_attri_value;
		//echo 'baseTable -> setAttriValue debug : '. $param_attri_name . ' ' .$param_attri_value;
		return true;
	}

	/*
	@���ܣ������ֶ����ƻ���ֶε�ֵ
	*/
	function getAttriValue($param_attri_name){
		$param_attri_name = strtolower( $param_attri_name );
		if(!isset($this->attributes[$param_attri_name]))$this->attributes[$param_attri_name]="";
		return $this->attributes[$param_attri_name]; 
	}
	
	/*
	@���ܣ�������ݿ����ĳ����¼�������ֶ���Ϣ
	*/
	function getAttributes(){
		return $this->attributes;
	}
	
	/*
	@���ܣ��Ӳ�ѯ����л��һ����¼���÷�����Ҫ���ڴӲ�ѯ����л����Ϣ��
	*/
	function getOneRecord(){
		$this->attributes=$this->getRecord();
		return $this->attributes;
	}
	
	/*
	@���ܣ�����ǰ���ݿ���е�ĳ���ֶγ�ʼ��������ա�
	*/
	function freeAttributes(){
		$this->attributes=array();
		return true;
	}	

	/*
	@���ܣ��趨��ѯ�������������
	*/
	function setCondition($param_attri_name,$param_attri_value){
		$this->condition[$param_attri_name]=$param_attri_value;
		return true;
	}
	/*
	@���ܣ�����趨�Ĳ�ѯ������
	*/
	function getCondition(){
		return $this->condition;
	}

	/*	@���ܣ����ݵ�ǰ�趨�����ݿ�����ֶ����ƺ����Ӧ��ֵ�����������ӵ����ݿ��У�ʹ���Ϊ���ݿ��һ����¼��
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
				$this->setError($key.'���ݸ�ʽ����ȷ','�洢ʧ��','baseTable.php','BaseCollect','');
				return false;
			}
			$value=stripslashes($tmp_attri[$key]);
			$value=str_replace("'","''",$value);
			
			$sql2=$sql2."'".$value."',";
			
		}

		//ȥ�����һ������
		$sql1=substr($sql1,0,strlen($sql1)-1); 
		$sql2=substr($sql2,0,strlen($sql2)-1);
		$sql2=$sql2.")";
		$sql=$sql.$sql1.$sql2;
		
		//ִ�����ɵ�SQL���
		
		
		if(!$this->executeOperation($sql)){
			return false;
		}else{
			return true;
		}
	}

	/*	@���ܣ����ݵ�ǰ�趨�����ݿ�����ֶ����ƺ����Ӧ��ֵ�Լ��趨�ĸ�����������������µ����ݿ��С�
	*/
	function updateRecord(){		
		$tmp_table		=$this->getTableName();
		$tmp_attri		=$this->getAttributes();

		$tmp_condition	= $this->getCondition();		

		$sql="update ".$tmp_table." set ";		
		for(reset($tmp_attri); $key=key($tmp_attri); next($tmp_attri)){
			if(strcmp($tmp_attri[$key],$this->fer)==0){
				$this->setError($key.'���ݸ�ʽ����ȷ','�洢ʧ��','base_collect.php','BaseCollect');
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
				$this->setError($key.'���ݸ�ʽ����ȷ','�洢ʧ��','base_collect.php','BaseCollect');
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
	@���ܣ����ݵ�ǰ�趨��ɾ�������������������ļ�¼�����ݿ���ɾ����
	*/
	function deleteRecord(){	  
		$tmp_table		= $this->getTableName();
		$tmp_attri		=$this->getRecord();

		$tmp_condition	= $this->getCondition();

		$sql="delete from ".$tmp_table." where ";
		
		for(reset($tmp_condition); $key=key($tmp_condition); next($tmp_condition)){
			if(strcmp($tmp_condition[$key],$this->fer)==0){
				$this->setError($key.'���ݸ�ʽ����ȷ');
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