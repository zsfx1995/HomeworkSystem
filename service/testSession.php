
<?php 
	session_start();
	if(!isset($_SESSION['sess_user_id'])) 
   { 
    echo "Session Error";
   }else{
	   echo "Session OK";
   }
?>