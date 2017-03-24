<?php
	 session_start();
	include_once("../../common/include/common.inc");
	include_once("../../common/class/baseDatabase.inc");
	include_once("../../common/class/baseTable.inc");
	include_once("../../common/class/admin_user.inc");
	include_once("../../common/class/error.inc");

	unset($_SESSION['sess_user_id']);
	header("location:" . P_HOMEPAGE_URL ."admin/login.html");	
		
?>
