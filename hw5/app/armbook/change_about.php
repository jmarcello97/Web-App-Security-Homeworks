<?php
include_once("common.php");
session_start();
$has_session = session_status() == PHP_SESSION_ACTIVE;
if($has_session){
	$destroy = false;
	if (!isset($_SESSION['login']) or !isset($_SESSION['user_id'])){
		session_regenerate_id(true);
		session_destroy();
		die("<script>window.location.href = '/index.php';</script>Invalid Session");
	}
	if($_SERVER['REMOTE_ADDR'] !== $_SESSION['login']['ip']){
		$destroy = true;
	}
	//if($_SESSION['login']['born'] < time() - 300){
	//	$destroy = true;	
	//}
	if($_SESSION['login']["valid"] !== true){
		$destroy = true;
	}
	if($destroy===true){
		session_destroy();
	}
	// Reset our counter
	$_SESSION['login']['born'] = time();
	$id_to_get = $_SESSION['user_id'];
	print_r($_POST);
	if(isset($_POST['name']) and isset($_POST['value'])){
		if($_POST['name'] === "school"){
			$prep = "UPDATE info SET School=? WHERE user_id=?";
		}
		if($_POST['name'] === "phone"){
			$prep = "UPDATE info SET Phone=? WHERE user_id=?";
		}
		if($_POST['name'] === "screen_name"){
			$prep = "UPDATE info SET ScreenName=? WHERE user_id=?";
		}
		if($_POST['name'] === "interests"){
			$prep = "UPDATE info SET Interest=? WHERE user_id=?";
		}
		if($stmt = $mysqli->prepare($prep)){
			if($stmt->bind_param("si",$_POST['value'], $_SESSION['user_id'])){
				if(!$stmt->execute()){
					die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
				}
			}else{
				die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
			}
			if($stmt->close()){
				echo "Value updated succesfully";
			}else{
				die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
			}
		}else{
			die("Error - Issue preparing statement: " . mysqli_error($mysqli));
		}
	}
		


}
?>	
