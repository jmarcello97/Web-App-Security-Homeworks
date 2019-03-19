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
	if(!isset($_POST['query'])){
		die("invalid search");
	}else{
		// Check for space
		$search = $_POST['query'];
		$outArray = explode(" ", $search);
		if(count($outArray) > 1){
			$adj_search1 = $outArray[0];
			$adj_search2 = $outArray[1];
		}else{
			$adj_search1 = $search;
			$adj_search2 = $search;
		}
		$adj_search1 = "%" . $adj_search1 . "%";
		$adj_search2 = "%" . $adj_search2 . "%";
	}
	echo "<br>";
	// Get user information
	if($stmt = $mysqli->prepare("SELECT profiles.picture_url, users.user_id, users.firstname, users.lastname FROM profiles INNER JOIN users ON profiles.user_id=users.user_id WHERE users.firstname LIKE ? or users.lastname LIKE ?")){
		if($stmt->bind_param("ss", $adj_search1, $adj_search2)){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
			if($res = $stmt->get_result()){
				if($res->num_rows < 1){
					$no_results = true;
				}else{
					$no_results = false;				
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
	<!-- Add fancyBox -->
	<script type="text/javascript" src="js/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<link rel="stylesheet" type="text/css" href="js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript" src="js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>	
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
		<?php
			if($no_results === true){
				echo "Sorry there were no results";
			}else{
					echo "<table border='0'>";
					while ($row = $res->fetch_assoc()){
						if($row["user_id"] != $id_to_get){
							echo "<tr><td>";
							echo "<img src='".$row["picture_url"]."' width=100px height=100px>";
							$name = ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
							echo "<a href='home.php?id=".$row["user_id"]."'>". $name . "</a>";
							echo "</td></tr>";
						}
					}
					echo "</table>";
			}
		?>
	</div>

