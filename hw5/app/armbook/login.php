<?php 
$email = $_POST['email'];
$password = $_POST['password'];
include_once("common.php");
if($stmt = $mysqli->prepare("SELECT password, user_id from users where email=?")){
	if($stmt->bind_param("s", $email)){
		if(!$stmt->execute()){
			die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
		}
		if($res = $stmt->get_result()){

			$row = $res->fetch_assoc();
			if($res->num_rows != 1){
				die("False - Username or password was invalid");
			}
			if($password === $row['password']){
				session_unset(); 
				session_destroy();
				$sess_id = session_start();
				session_regenerate_id(true);
				$_SESSION['login'] = ['born' => time(),'ip' => $_SERVER['REMOTE_ADDR'],'valid' => true];
				$_SESSION['user_id'] = $row['user_id'];
				die("True - login successful");
			}else{
				die('False - Username or password was invalid"');
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
?>
