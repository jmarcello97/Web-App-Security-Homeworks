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

	// Get Profile data
	$id_to_get = $_SESSION['user_id'];
	if(isset($_GET['id'])){
		$id_to_get = $_GET['id'];
	}
	if($stmt = $mysqli->prepare("SELECT * from profiles where user_id=?")){
		if($stmt->bind_param("i", $id_to_get)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				$row = $res->fetch_assoc();
				if($res->num_rows !== 1){
					die('Error - There is an issue with the database, contact your administrator');
				}else{
					$friends = $row['Friends'];
				}
			}else{
				die("Error - Getting results: " . mysqli_error($mysqli));
			}
		}else{
			die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
		}
	}else{
		die("Error - Issue preparing statement: " . mysqli_error($mysqli));
	}
	echo $friends . "<BR>";
	$friends = explode(',',$friends);
	if(count($friends) < 1){
		die("Sorry no friends");
	}
	foreach ($friends as &$value) {
		if(!is_numeric($value)){
			die("A problem has occurred contact your administrator");
		}
	}
	
	$ids = implode(', ',$friends);
	$query = "SELECT firstname, lastname FROM users WHERE user_id IN (";
	$query = $query . $ids . ");";
	$result = $mysqli->query($query);
	$query = "SELECT user_id, picture_url FROM profiles WHERE user_id IN (";
	$query = $query . $ids . ");";	
	$result2 = $mysqli->query($query);

	if($result and $result2){
		echo "<table border='1'>";
		while ($row = $result->fetch_assoc()){
			$row2 = $result2->fetch_assoc();
			echo "<td>";
			echo "<img src='".$row2["picture_url"]."' width=100px height=100px>";
			$name = $row["firstname"] . ' ' . $row["lastname"];
			echo "<a href='home.php?id=".$row2["user_id"]."'>". $name . "</a>";
			echo "</td>";
		}
		echo "</table>";
		$result->free();
		$result2->free();
	}else{
		die("Error - Making query: " . mysqli_error($mysqli));
	}

	
	
	
}
?>
