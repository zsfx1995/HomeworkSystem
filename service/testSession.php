
<?php 
	session_start();
	if(!isset($_SESSION['sess_user_id'])) 
   { 
    echo "Session is not Registered";
   }else{
	   echo "Session is Registered";
   }
?>