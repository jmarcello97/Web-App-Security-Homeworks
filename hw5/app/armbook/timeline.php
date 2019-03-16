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
	// Get Posts
	$posts = "";
	if($stmt = $mysqli->prepare("
	SELECT posts.text,
			posts.post_id,
			profiles.picture_url, 
			posts.user_id_from,
			users.firstname, 
			users.lastname 
		FROM posts 
		INNER JOIN users 
			ON posts.user_id_from=users.user_id  
		INNER JOIN profiles 
			ON users.user_id=profiles.user_id 
		where user_id_to=? ORDER BY posts.post_id DESC;")){
		if($stmt->bind_param("i", $id_to_get)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($result = $stmt->get_result()){
				if($result->num_rows <= 0){
					$posts = "There are no posts :(";
				}else{
					while ($row = $result->fetch_assoc()) {
						$name = $row['firstname'] . ' ' .$row['lastname'];
						$posts .= "<img src='". $row['picture_url']."' width=40 height=40>";
						$posts .= "<a href='home.php?id=".$row['user_id_from']."'>".$name."</a>";
						$posts .= "<p>";
						$posts .= $row['text'];
						$posts .= "</p>";
					}
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
	
	// Get user information
	if($stmt = $mysqli->prepare("SELECT info.School, info.Phone, info.Interest, info.relationship, info.interested_in, info.ScreenName, users.firstname, users.lastname, users.sex, users.birthday_month, users.birthday_day, users.birthday_year FROM info INNER JOIN users ON info.user_id=users.user_id WHERE users.user_id=?")){
		if($stmt->bind_param("i",$id_to_get)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				if($res->num_rows !== 1){
					die("An error occurred contact your system administrator");		
				}else{
					if($id_to_get == $_SESSION['user_id']){
						$row = $res->fetch_assoc();
						$name = ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
						$birthday = $row['birthday_month'] . '/' .$row['birthday_day'] . '/' . $row['birthday_year'];
						$info = "No Information Available";
						$info  = "Name: " . $name .'<br>';
						$info .= 'School: <a href="#" id="school" data-type="text" data-url="change_about.php" data-pk="1" data-title="Enter School">' . $row['School'] .'</a><br>';
						$info .= 'Phone Number:  <a href="#" id="phone" data-type="text" data-url="change_about.php" data-pk="1" data-title="Enter Phone Number">' . $row['Phone'] .'</a><br>';
						$info .= 'Interests: <a href="#" id="interests" data-type="text" data-url="change_about.php" data-pk="1" data-title="Enter Interests">' . $row['Interest'] .'</a><br>';
						$info .= "Relationship Status: " . $row['relationship'] .'<br>';
						$info .= "Interested In: " . $row['interested_in'] .'<br>';
						$info .= 'Screen Name: <a href="#" id="screen_name" data-type="text" data-url="change_about.php" data-pk="1" data-title="Enter Screen Name">' . $row['ScreenName'] .'</a><br>';
						$info .= "Gender: " . $row['sex'] .'<br>';
						$info .= "Birthday: " . $birthday .'<br>';
					}else{
						$row = $res->fetch_assoc();
						$name = ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
						$birthday = $row['birthday_month'] . '/' .$row['birthday_day'] . '/' . $row['birthday_year'];
						$info = "No Information Available";
						$info  = "Name: " . $name .'<br>';
						$info .= 'School: ' . $row['School'] .'<br>';
						$info .= "Phone Number: " . $row['Phone'] .'<br>';
						$info .= "Interests: " . $row['Interest'] .'<br>';
						$info .= "Relationship Status: " . $row['relationship'] .'<br>';
						$info .= "Interested In: " . $row['interested_in'] .'<br>';
						$info .= "Screen Name: " . $row['ScreenName'] .'<br>';
						$info .= "Gender: " . $row['sex'] .'<br>';
						$info .= "Birthday: " . $birthday .'<br>';						
					}
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
	

	// Get user information
	if($stmt = $mysqli->prepare("SELECT picture_url from profiles WHERE user_id=?")){
		if($stmt->bind_param("i", $_SESSION['user_id'])){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				if($res->num_rows !== 1){
					die("An error occurred contact your system administrator");		
				}else{
					$row = $res->fetch_assoc();
					$picture = $row['picture_url'];
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
	
}
?>
	
		<script>
		$( document ).ready(function() {
			var f = 'jqueryui';
			$.fn.editable.defaults.mode = 'popup';     
			$('#school').editable();
			$('#phone').editable();
			$('#screen_name').editable();
			$('#interests').editable();			
			$('#statUpdate').keypress(function (e) {
			  if (e.which == 13) {
				$.get( "add_comment.php?id=<?php echo $id_to_get; ?>&comment="+$('#statUpdate').val(), function( data ) {
					location.reload();
				});	
				return false;
				
			  }
			});
		});
		</script>

			<div id="left">
				<div id="top_about"><a id="about" href="home.php">About</a></div>
				<div id="about_info"><?php echo $info; ?></div>
			</div>
			<div id="right">
				<div id="top_posts"><a id="about" href="home.php">Posts</a></div>
				<div id="updateStat">
					<img id="statPic" src="<?php echo $picture; ?>" width="40" height="40" />
					<div id="inner">
						<textarea id="statUpdate" class="statBox" placeholder="What's on your mind?" name="statUpdate"></textarea>
					</div>
				</div>
				<div id="posts">
					<?php
						if(is_string($posts)){
							echo $posts;
						}
					?>

				</div>
			</div>
