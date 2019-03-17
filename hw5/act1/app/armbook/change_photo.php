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
	if($_SESSION['login']['born'] < time() - 300){
		$destroy = true;	
	}
	if($_SESSION['login']["valid"] !== true){
		$destroy = true;
	}
	if($destroy===true){
		session_destroy();
	}
	// Reset our counter
	$_SESSION['login']['born'] = time();
	$id_to_get = $_SESSION['user_id'];
	if(isset($_GET['type']) and $_GET['type'] === "profile"){
		$validImage = false;
		if(isset($_GET['url'])){
			$url = $_GET['url'];
			if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			   $pos = strrpos( $url, ".");
				if ($pos === false)
					die("You did not enter a valid URL");
				$ext = strtolower(trim(substr( $url, $pos)));
				$imgExts = array(".gif", ".jpg", ".jpeg", ".png"); // this is far from complete but that's always going to be the case...
				if ( in_array($ext, $imgExts) ){
				  $validImage = true;
				}else{	
					die("You did not enter a valid URL");
				}
			} else {
				die("You did not enter a valid URL");
			}		
		}else{
			die("There was an issue contact your administrator");
		}
		if($validImage === true){
			if($stmt = $mysqli->prepare("UPDATE profiles SET picture_url=? WHERE user_id=?")){
				if($stmt->bind_param("si", $_GET['url'], $_SESSION['user_id'])){
					if(!$stmt->execute()){
						die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
					}
				}else{
					die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
				}
				if($stmt->close()){
					echo "Image updated successfully";
				}else{
					die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
				}
			}else{
				die("Error - Issue preparing statement: " . mysqli_error($mysqli));
			}		
		}
	}else{
		die("There was an issue contact your administrator");
	}

}
?>	