<?php
/*
 @���ƣ�	���ݿ������
 @���ܣ�	���������ݿ�����������ӣ���ѡ����Ҫ���������ݿ⡣	
		������ݿ�Ļ����Ĳ�ѯ�Ͳ�����������ѽ�����ء�
		��ɶԲ�ѯ�����ָ��Ĵ�����
		���ú���ʾ��ѯ�Ͳ����еĴ�����Ϣ
 
 @���ߣ�������
 @ʱ�䣺2005��2��1��
*/
class BaseDatabase {
	var $host_name;				// = "";
	var $database;				// = "";
	var $user_name;				// = "";
	var $password;				// = "";

	var $db_connection	=0;
	var $resourse		=false;
	var $record_count	=-1;	//	Open��¼����
	var $record_num		=-1;	//����ǰ��¼��
	var $EOF			=true;	//�P��ǰָ���Ƿ�ָ�����һ����¼
	var $BOF			=true;	//�P��ǰָ���Ƿ�ָ���һ����¼
	var $parent			=null;	//	ָ����
	var $auto_free		= 0;	//	set this to 1 to automatically free results
	var $Error			=null;

	var $insert_id		=0;			// ���һ��ʹ�� INSERT ָ��� ID
	var $error_string	= array();
	var $sql_string		='';		// Array
	var $sum_record		=0;

	/* 
	@���ƣ�BaseDataBase�๹����
	@���ܣ���ʼ�����ݿ�����������¼���ݿ�������Ļ�����Ϣ
	@�ص㣺ʹ����ϵͳ�Ķ���ĳ�������Ϊ��ʽ������Ĭ��ֵ
	*/
	function BaseDatabase(	$P_HostName = hostname,
							$P_Database = dbname,
							$P_UserName = dbuser,
							$P_Password = dbpass){

		$this->HostName = $P_HostName;
		$this->Database = $P_Database;
		$this->UserName = $P_UserName;
		$this->Password = $P_Password;		
	}

	/*
	@���ƣ��������ݿ������
	@���ܣ����������ݿ�����������ӣ���ѡ��Ҫ���в��������ݿ�
	*/
	function createConnect(){
		if($this->db_connection==0){
			$this->db_connection=@mysql_connect($this->HostName,
										$this->UserName,
										$this->Password);
			mysql_query("Set Names 'GB2312'");
			if (!$this->db_connection){
					$this->setError("Connect Database Error!",'','baseDatabase.php','BaseDatabase','');
					return false;
			} else { 
				if(!@mysql_select_db($this->Database, $this->db_connection)){
					$this->setError(@mysql_error($this->db_connection),'Select Database Error','baseDatabase.php','BaseDatabase','');
					return false;
				}else {
					return true;
				}
			}
		} else 
			return true;
	}

	
	/*
	@���ƣ�ִ��Select��ѯ���	@������ִ���з��ؽ������Select��ѯ���,����ò�ѯ����ļ�¼����,�����ݲ�ѯ����趨��¼ָ���λ�á�
	*/
	function openQuery($str_sql){
		if($this->db_connection == 0){
			$this->setError("Database hadn't be connected",'','baseDatabase.php','BaseDB','');
			return false;
		}else{
			if(strlen($str_sql) == 0){
				$this->setError("SQL is NULL",'','baseDatabase.php','BaseDB','');
				return false;
			} else {
				$this->resourse= @mysql_query($str_sql,$this->db_connection);
				if(!$this->resourse){
					$this->setError(@mysql_error($this->db_connection),'Query Error','baseDatabase.php','BaseDB',$str_sql);
					
					return false;
				}else{
					//��ò�ѯ�ļ�¼����
					
					$this->record_count = @mysql_num_rows($this->resourse);
					
					if($this->record_count>0){
						$this->EOF=false;
						$this->BOF=true;
						$this->record_num=0;
						return true;
					}else{
						$this->EOF=true;
						$this->BOF=true;
						$this->record_count=0;
						//$this->setError('No Record','No Record','baseDatabase.php','BaseDB',$str_sql);
						return true;
					}
				}
			}
		}
	}

	/*
	@���ƣ�ִ��SQL��������
	@���ܣ�ִ���޷��ؽ������SQL�������,����:UPDATE tb SET column='test'���ɹ�����True,���ɹ�����False��ͬʱ�趨������Ϣ��
	*/
	function executeOperation($str_sql){
		if($this->db_connection!=0){
			$tmp_res=@mysql_query($str_sql,$this->db_connection);
			if(!$tmp_res){
				$this->setError(@mysql_error($this->db_connection),'Database Operation Error','baseDatabase.php','BaseDatabase',$str_sql);
				return false;
			}
			//�����Insert���򷵻ظող���ļ�¼��ID��
			$this->insert_id = mysql_insert_id();
			return true;
		}else{
			$this->setError("Database hadn't be connected",'','baseDatabase.php','BaseDB');
			return false;
		}
	}
	
	//������һ�β������ݿ����м�¼��ID
	function getInsertId(){
		return $this->insert_id;
	}

	/*
	@���ƣ�ȡ�ò�ѯ����е�һ����¼��
	@���ܣ�ȡ�ò�ѯ����еĵ�ǰ��¼�������ü�¼���������У�Ȼ���䷵�ء�
	*/
	function getRecord(){
		if(!$this->isEOF()){
			$tmp_record		= array();
			$tmp_attri_count= @mysql_num_fields($this->resourse);

			for($i=0; $i<$tmp_attri_count; $i++){
				$tmp_record[strtolower(@mysql_field_name($this->resourse,$i))] = chop(mysql_result($this->resourse,$this->record_num,mysql_field_name($this->resourse,$i)) );
			}
			return	$tmp_record;
		} else {
			$this->setError('Now record is EOF!','Get Record Failed','baseDatabase.php','BaseDB','');
			return false;
		}

	}
	/*
	@���ƣ����ز�ѯ����ļ�¼��	@���ܣ�����ѯ�ṹ�ļ�¼������һ����ά���飬�����䷵�ء��˹���һ�㲻�ã����Ҫ�ã���Ҫ��һ���޸ġ�
	*/
	function getRecordSet(){
		$this->moveFirst();
		$temp_recordset = array();
		while(!$this->isEOF()){
			$temp_recordset[]=$this->getRecord();
			$this->moveNext();
		}
		$this->moveFirst();
		return $ar;
	}

	/*
	@���ƣ���ò�ѯ����ļ�¼����	
	@���ܣ����ز�ѯ����ļ�¼������
	*/
	function getRecordCount(){				 
		return $this->record_count;
	}

	/*
	@���ƣ�ȡ�����ִ��SQL����������ļ�¼����
	@���ܣ��������ִ��SQL����������ļ�¼������һ������Update��Delete�����С�
	@��ע��Not a supported function in PHP3/4.
	*/
	function getAffectedRecordCount() {		
		$rsRows = @mysql_affected_rows($this->db_connection);
		if ($rsRows >= 0) {
			return $rsRows;
		}
		else{
			$this->setError(@mysql_error($this->db_connection),'Get affected row number failed','baseDatabase.php','BaseDB','');
			return false;
		}
	}

	/*
	@���ƣ�ȡ��ǰ��¼��ĳһ��λֵ	
	@���ܣ�ȡ��ǰ��¼��ĳһ��λֵ,�����䷵�ء�
	*/
	function getFieldValue($feild_name){
		
		if(!$this->resourse){
			
			$this->setError('No record','Get Field failed','baseDatabase.php','BaseDB','');
			return false;
		}else{
			if($this->EOF) {
				$this->setError('Nonce record is EOF!','Get row failed','baseDatabase.php','BaseDB','');
				return false;
			}else{
				$tmp_feild_value=@mysql_result($this->resourse,$this->record_num,$feild_name) ;
				if(!$tmp_feild_value && $tmp_feild_value!=null){
					$this->setError(@mysql_error($this->db_connection),'Get Field failed','baseDatabase.php','BaseDB');
					return false;
				}else
					return $tmp_feild_value;
			}
		}
	}

	/*
	@���ƣ�ָ���Ƶ���һ����¼
	@���ܣ�ָ���Ƶ���һ����¼��
	*/
	function moveFirst(){					
		if(!$this->resourse){
			$this->setError('No record','','baseDatabase.php','BaseDB','');
			return false;
		}
		$this->record_num=0;
		
		if($this->record_count> 0){
			$this->EOF=false;
			$this->BOF=true;
		}
		return true;
	}

	/*
	@���ƣ�ָ���Ƶ����һ����¼
	@���ܣ�ָ���Ƶ����һ����¼��
	*/
	function moveLast(){					
		if(!$this->resourse){
			$this->setError('No record','','baseDatabase.php','BaseDB','');
			return false;
		}
		$this->record_num=$this->record_count;
		$this->BOF=false;
		$this->EOF=true;
		return true;
	}

	/*
	@���ƣ�ָ��ǰ��һ����¼
	@���ܣ�ָ��ǰ��һ����¼��
	*/
	function movePrevious(){
		if($this->record_num == 0){
			$this->setError('No record','Move Previous failed','baseDatabase.php','BaseDB','');
			return false;
		}
		$this->record_num=$this->record_num-1;
		if($this->record_num == 0){
			$this->BOF=true;
			$this->EOF=false;
		}
		if($this->record_count > 0){
			$this->EOF=false;
		}
		return true ;
	}

	/*
	@���ƣ�ָ������
	@���ܣ�ָ��ǰ��һ����¼��
	*/
	function moveNext(){					 
		if(!$this->resourse){
			$this->setError('No record','','baseDatabase.php','BaseDB','');
			return false;
		}
		if($this->record_num >= $this->record_count){
			$this->setError('Nonce record is EOF!','G','baseDatabase.php','BaseDB','');
			return false;
		}
		$this->record_num=$this->record_num+1;
		//mssql_data_seek($this->resourse,$this->record_num);
		if($this->record_num >= $this->record_count){
			$this->EOF=true;
			$this->BOF=false;
		}
		return true;
	}

	/*
	@���ƣ��ƶ�ָ�뵽ȷ��λ��
	@���ܣ���ָ���Ƶ�ָ��λ��,�������ܼ�¼����ָ�����һ����¼��
	*/
	function move($x){ 
		// echo $this->record_count;
		if(!$this->resourse){
			$this->setError('No record','','baseDatabase.php','BaseDB','');
			return false;
		}

		if($this->record_count <= $x){
			$this->setError("$x more than Count Records",'Move failed','baseDatabase.php','BaseDB');
			$this->MoveLast();
			return false;
		}else{
			$this->record_num=$x;
		}
		return true;
	}

	/*
	@���ƣ��ж�ָ���Ƿ�ָ�����һ����¼
	@���ܣ��ж�ָ���Ƿ�ָ�����һ����¼��
	*/
	function isEOF(){ 
		if($this->EOF)
			return true;
		else
			return false;
	}

	/*
	@���ƣ��ж�ָ���Ƿ�ָ���һ����¼
	@���ܣ��ж�ָ���Ƿ�ָ���һ����¼
	*/
	function isBOF(){
		if($this->BOF)
			return true;
		else
			return false;
	}

	/*
	@���ƣ����ó�����Ϣ	@���ܣ������������еĳ�������,���⣬�����ļ��������࣬����Ϊ�����Error��������ԣ�������True��
	*/
	function setError($err_info='',$err_msg='',$err_file='',$err_class='',$err_sql=''){		if(!is_object($this->Error))$this->Error=new Error();
		$this->Error->setErrorFile($err_file);
		$this->Error->setErrorClass($err_class);
		$this->Error->setErrorMsg($err_msg);
		$this->Error->setErrorInfo($err_info);
		$this->Error->setErrorSql($err_sql);				
		return $this->Error;
	}
	
	//���ص�ǰ���������Error����
	function getError(){
		return $this->Error;
	}
	
	/*
	@���ƣ��ر����Ͽ�����
	@���ܣ��ر����Ͽ����ӣ��ͷ����ݿ�������ռ���������ڴ�
	*/	
	function closeConnection(){
		if($this->db_connection){
			mysql_close($this->db_connection);
			$this->db_connection=0;
		}
	}


}
?>