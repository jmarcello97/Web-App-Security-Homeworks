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
	if(isset($_GET['id'])){
		$id_to_get = $_GET['id'];
	}	
	// Get Data
	if($stmt = $mysqli->prepare("SELECT * from info where user_id=?")){
		if($stmt->bind_param("i", $_SESSION['user_id'])){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				$row = $res->fetch_assoc();
				if($res->num_rows != 1){
					die('Error - There is an issue with the database, contact your administrator');
				}else{
					#print_r($row);
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
	
	// Get Profile data
	if($stmt = $mysqli->prepare("SELECT picture_url from profiles where user_id=?")){
		if($stmt->bind_param("i", $id_to_get)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				$row = $res->fetch_assoc();
				if($res->num_rows !== 1){
					die('Error - There is an issue with the database, contact your administrator');
				}else{
					$profPic = $row['picture_url'];
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
	// Get friends data
	if($stmt = $mysqli->prepare("SELECT Friends from profiles where user_id=?")){
		if($stmt->bind_param("i", $_SESSION['user_id'])){
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

	// Get user information
	if($stmt = $mysqli->prepare("SELECT * from users where user_id=?")){
		if($stmt->bind_param("i", $id_to_get)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				$row = $res->fetch_assoc();
				if($res->num_rows !== 1){
					die('Error - There is an issue with the database, contact your administrator');
				}else{
					$name = ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
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
	<link rel="stylesheet" type="text/css" href="background2.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
	<!-- Add fancyBox -->
	<script type="text/javascript" src="js/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	<script src="js/jquery-ui-1.10.1.custom.min.js"></script>
	<link href="js/jquery-ui-1.10.1.custom.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>
	<script>
	$( document ).ready(function() {
		$('.fancybox').fancybox();
		
		$('#search').keypress(function (e) {
		  if (e.which == 13) {
			$('#search_form').submit();
			return false;
		  }
		});		
		$.get( "timeline.php?id=<?php echo $id_to_get; ?>", function( data ) {
		  $( "#botcont" ).html( data );
		});		
	
		$( "#friends" ).click(function() {
			$.get( "friends.php?id=<?php echo $id_to_get; ?>", function( data ) {
			  $( "#botcont" ).html( data );
			  event.preventDefault();
			});
		});
		$( "#add_friend" ).click(function() {
			$.get( "add_friend.php?id=<?php echo $id_to_get; ?>", function( data ) {
			  event.preventDefault();
			});
			location.reload();
		});
		$( "#del_friend" ).click(function() {
			$.get( "del_friend.php?id=<?php echo $id_to_get; ?>", function( data ) {	
			  event.preventDefault();
			});
			location.reload();
		});		
	});
	</script>
	<div id="bluebar">
		<div id="logo"><a href="home.php"><img id="logo_img" src="images/logo.png"></a></div>
		<div id="search_div">
			<form id="search_form" action="search.php" method="post">
			<input id="search" name="query" type="text" placeholder="search">
			</form>
		</div>
		<div id="logout_div">
			<a id="logout" href="/logout.php">Logout</a>
		</div>
	</div>
	<div id="global">
			<div id="basic_profile">
				<img id="fb-image-lg" src="images/timeline.png"/>
				<div id="profpic">
				<a class="fancybox" href="<?php echo $profPic; ?>"><img align="left" class="fb-image-profile" src="<?php echo $profPic; ?>" width="180" height="180"/></a>
				<?php
				if($_SESSION['user_id'] == $id_to_get){
					echo '
						<script>
						$( document ).ready(function() {
							$( "#update_prof" ).submit(function( event ) {
								if($("#url").val() == ""){
									$("#update").html("Please insert a value");
								}else{
									$.get( "change_photo.php?type=profile&url=" + $("#url").val(), function( data ) {
										$("#update").html(data);
										if(data.indexOf("successfully") >= 0){
											location.reload();
										}
									});
								}
								event.preventDefault();
							});
						});
						</script>
					';
					echo '<a class="fancybox" href="#change_profile"><img id="edit" src="images/edit.png"></a>';
					echo '<div id="change_profile" style="height:150px;width:400px;display: none;">
						<h3>Change your Profile Picture</h3>
						<div id="update"> </div>
						<form id="update_prof">
							url to image: <input id="url" placeholder="http://www.example.com/image.png" style="width: 300px;" type="text" />
							<br>
							<input style="float: right;" type="submit" />
						</form>
					</div>
					';
				}
				?>
				</div>
				<div id="info">
				<span id="name"><?php echo $name; ?></span>
				<?php

				if($_SESSION['user_id'] != $id_to_get){
					// make sure friend is not already in friends list
					$friends = explode(',',$friends);
					$found = false;
					foreach ($friends as &$value) {
						if(is_numeric($value)){
							if($id_to_get == $value){
								$found = true;
							}
						}
					}
					if($found === false){
						echo '<button class="friend" id="add_friend" type="button">Add Friend</button>';
					}
					if($found === true){
						echo '<button class="friend" id="del_friend" type="button">Remove Friend</button>';
					}
					
					
				}
				?>
				</div>
				<div id="nav"><div id="navcont">
				<a class="links" id="timeline" href="home.php">Home<span></span></a>
				<a class="links" id="friends" href="#"">Friends<span></a>
				<a class="links" href="#">Photos<span></span></a>
				</div></div>
				<!--<div class="fb-profile-text">
					<h1><?php echo $name; ?></h1>
					<p><?php echo $status; ?></p>
				</div>-->
				
			</div>
			<div id="padding"></div>
			<div id="botcont">
				
			</div>
	</div>

