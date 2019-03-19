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
	if(isset($_GET['id'])){
		$id_to_get = $_GET['id'];
	}
	
	if(isset($_GET['comment'])){
		$maxLength = 300;
		$comment = $_GET['comment'];
		$comment = substr ($comment,0,$maxLength);
		if($stmt = $mysqli->prepare("INSERT INTO posts (user_id_from, user_id_to, text)
VALUES (?, ?, ?)")){
			if($stmt->bind_param("iis", $_SESSION['user_id'], $id_to_get, $comment)){
				if(!$stmt->execute()){
					die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
				}
			}else{
				die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
			}
			if($stmt->close()){
				echo "Added Comment";
			}else{
				die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
			}
		}else{
			die("Error - Issue preparing statement: " . mysqli_error($mysqli));
		}					

	}else{
		die("There was an issue contact your administrator");
	}

}
?>	
