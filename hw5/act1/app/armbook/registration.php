<?php
include_once "common.php";

$inputs = array('firstname','lastname','reg_email','sex','reg_passwd','birthday_month','birthday_day','birthday_year');
$passedChecks = True;
foreach ($inputs as $input) {
    if(!isset($_POST[$input])){
		$passedChecks = False;
	}
}
if($passedChecks !== True){
	die('False - Please fill in all fields');
}
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['reg_email'];
$pass = $_POST['reg_passwd'];
$sex = $_POST['sex'];
$mon = $_POST['birthday_month'];
$day = $_POST['birthday_day'];
$year = $_POST['birthday_year'];

if(!filter_var($email, FILTER_VALIDATE_EMAIL) === True){
	$passedChecks = False;
}
if(!filter_var($mon, FILTER_VALIDATE_INT) === True){
	$passedChecks = False;
}
if(!filter_var($day, FILTER_VALIDATE_INT) === True){
	$passedChecks = False;
}
if(!filter_var($year, FILTER_VALIDATE_INT) === True){
	$passedChecks = False;
}
if(!filter_var($sex, FILTER_VALIDATE_INT) === True or $sex === 0){
	$passedChecks = False;
}

if($passedChecks !== True){
	die('False - There was a problem with your registration, please go back and examine it');
}else{
	#TODO: Check to make sure email doesn't exist.
	if($stmt = $mysqli->prepare("SELECT user_id from users where email=?")){
		if($stmt->bind_param("s", $email)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				$row = $res->fetch_assoc();
				if($res->num_rows != 0){
					die('False - The email you listed already has an account');
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
	$good = false;
	if($stmt = $mysqli->prepare("INSERT INTO users (email,password,firstname,lastname,sex,birthday_month,birthday_day,birthday_year) VALUES (?,?,?,?,?,?,?,?)")){
		if($stmt->bind_param("ssssiiii", $email,$pass,$fname,$lname, $sex, $mon, $day, $year)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}else{
				$id = $stmt->insert_id;
			}
		}else{
			die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
		}
		if($stmt->close()){
			$good = true;
		}else{
			die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
		}
	
	}else{
		die("Error - Issue preparing statement: " . mysqli_error($mysqli));
	}
	if($good === true){
		$default_img = "images/arm_stock.jpg";
		$default_friends = "2";
        if($stmt = $mysqli->prepare("INSERT INTO profiles (user_id,picture_url,Friends) VALUES (?,?,?)")){
    	        if($stmt->bind_param("iss",$id, $default_img, $default_friends)){
            		if(!$stmt->execute()){
                		die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
                	}
                }else{
    	                die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
               	}
    	        if($stmt->close()){
                    	
                }else{
    	                die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
            	}

        }else{
                die("Error - Issue preparing statement: " . mysqli_error($mysqli));
        }
	}
	if($good === true){
		$default = "None";
		$relationship = -1;
        if($stmt = $mysqli->prepare("INSERT INTO info (user_id,Workplace,School,Phone,Interest,Relationship,Interested_in,ScreenName) VALUES (?,?,?,?,?,?,?,?)")){
    	        if($stmt->bind_param("issssiss",$id,$default,$default,$default,$relationship,$default,$default,$default)){
            		if(!$stmt->execute()){
                		die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
                	}
                }else{
    	                die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
               	}
    	        if($stmt->close()){
                    	echo "True - account created successfully";
                }else{
    	                die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
            	}

        }else{
                die("Error - Issue preparing statement: " . mysqli_error($mysqli));
        }
	}	
}
	
	
?>
