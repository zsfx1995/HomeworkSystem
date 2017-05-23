<?php

/*
 @名称：	数据库抽象类
 @功能：	建立与数据库服务器的连接，并选择所要操作的数据库。	
		完成数据库的基本的查询和操作，并负责把结果返回。
		完成对查询结果的指针的错作。
		设置和显示查询和操作中的错误信息
 
 @作者：王永固
 @时间：2005年2月1日
*/

include_once("../../common/include/log.inc");

class BaseDatabase {
	var $host_name;				// = "";
	var $database;				// = "";
	var $user_name;				// = "";
	var $password;				// = "";

	var $db_connection	=0;
	var $resourse		=false;
	var $record_count	=-1;	//	Open记录总数
	var $record_num		=-1;	//当前记录数
	var $EOF			=true;	//当前指针是否指向最后一条记录
	var $BOF			=true;	//当前指针是否指向第一条记录
	var $parent			=null;	//	指向父类
	var $auto_free		= 0;	//	set this to 1 to automatically free results
	var $Error			=null;

	var $insert_id		=0;			// 最后一次使用 INSERT 指令的 ID
	var $error_string	= array();
	var $sql_string		='';		// Array
	var $sum_record		=0;

	/* 
	@名称：BaseDataBase类构造器
	@功能：初始化数据库服务器及其登录数据库服务器的基本信息
	@特点：使用了系统的定义的常数，作为形式参数的默认值
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
	@名称：连接数据库服务器
	@功能：建立与数据库服务器的连接，并选择要进行操作的数据库
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
	@名称：执行Select查询语句	@描述：执行有返回结果集的Select查询语句,并获得查询结果的记录条数,并根据查询结果设定记录指针的位置。
	*/
	function openQuery($str_sql){
	
		$manager = new logManager();
		$manager -> sqlLog($str_sql);
		
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
					//获得查询的记录总数
					
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
	@名称：执行SQL操作命令
	@功能：执行无返回结果集的SQL操作语句,例如:UPDATE tb SET column='test'，成功返回True,不成功返回False的同时设定错误信息。
	*/
	function executeOperation($str_sql){
	
		$manager = new logManager();
		$manager -> sqlLog($str_sql);
		
		
		if($this->db_connection!=0){
			$tmp_res=@mysql_query($str_sql,$this->db_connection);
			if(!$tmp_res){
				$this->setError(@mysql_error($this->db_connection),'Database Operation Error','baseDatabase.php','BaseDatabase',$str_sql);
				return false;
			}
			//如果是Insert，则返回刚刚插入的记录的ID号
			$this->insert_id = mysql_insert_id();
			return true;
		}else{
			$this->setError("Database hadn't be connected",'','baseDatabase.php','BaseDB');
			return false;
		}
	}
	
	//返回上一次插入数据库中中记录的ID
	function getInsertId(){
		return $this->insert_id;
	}

	/*
	@名称：取得查询结果中的一条记录。
	@功能：取得查询结果中的当前记录，并将该记录放入数组中，然后将其返回。
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
	@名称：返回查询结果的记录集	@功能：将查询结构的记录集放入一个二维数组，并将其返回。此功能一般不用，如果要用，需要进一步修改。
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
	@名称：获得查询结果的记录条数	
	@功能：返回查询结果的记录条数。
	*/
	function getRecordCount(){				 
		return $this->record_count;
	}

	/*
	@名称：取得最近执行SQL语句所操作的记录条数
	@功能：返回最近执行SQL语句所操作的记录条数，一般用在Update、Delete命令中。
	@备注：Not a supported function in PHP3/4.
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
	@名称：取当前记录的某一栏位值	
	@功能：取当前记录的某一栏位值,并将其返回。
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
	@名称：指针移到第一条记录
	@功能：指针移到第一条记录。
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
	@名称：指针移到最后一条记录
	@功能：指针移到最后一条记录。
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
	@名称：指针前移一条记录
	@功能：指针前移一条记录。
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
	@名称：指针下移
	@功能：指针前移一条记录。
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
	@名称：移动指针到确定位置
	@功能：将指针移到指定位置,若超出总记录数则指向最后一条记录。
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
	@名称：判断指针是否指向最后一条记录
	@功能：判断指针是否指向最后一条记录。
	*/
	function isEOF(){ 
		if($this->EOF)
			return true;
		else
			return false;
	}

	/*
	@名称：判断指针是否指向第一条记录
	@功能：判断指针是否指向第一条记录
	*/
	function isBOF(){
		if($this->BOF)
			return true;
		else
			return false;
	}

	/*
	@名称：设置出错信息	@功能：将程序运行中的出错描述,标题，出错文件，出错类，设置为该类的Error对象的属性，并返回True。
	*/
	function setError($err_info='',$err_msg='',$err_file='',$err_class='',$err_sql=''){		if(!is_object($this->Error))$this->Error=new Error();
		$this->Error->setErrorFile($err_file);
		$this->Error->setErrorClass($err_class);
		$this->Error->setErrorMsg($err_msg);
		$this->Error->setErrorInfo($err_info);
		$this->Error->setErrorSql($err_sql);				
		return $this->Error;
	}
	
	//返回当前对象产生的Error对象
	function getError(){
		return $this->Error;
	}
	
	/*
	@名称：关闭资料库连接
	@功能：关闭资料库连接，释放数据库连接所占服务器的内存
	*/	
	function closeConnection(){
		if($this->db_connection){
			mysql_close($this->db_connection);
			$this->db_connection=0;
		}
	}


}
?>