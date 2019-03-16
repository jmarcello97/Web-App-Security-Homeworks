<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Welcome to Armbook - Log In, Sign Up or Learn More</title>
<link rel="stylesheet" type="text/css" href="background.css" />
<?php 
include("common.php"); 

if(isset($_SESSION['login'])){
	header("Location: http://localhost/home.php");
}
?>
<script type="text/javascript" src="js/jquery.js"></script>  
<script type="text/javascript">                                         
	$(document).ready(function() {
		// Registration validation
		$('#regForm').submit(function(event) {
			event.preventDefault();
			var valid = true;
			if($('#reg_email').val()!=$('#reg_email_confirmation').val()){
				valid=false;
			}
			if($('#email').val()==""){
				valid=false;
			}
			if(($('#email').val()).search("@")==-1){
				valid=false;
			}
			if($('#password').val()==""){
				valid=false;
			}
		  	if(valid == false){
				$("#message").css( "color", "red" )
				$("#message").html("The credentials you inserted were not valid");	
			}			
			var data = $('#regForm').serialize();
			$.post( "registration.php", data)
				.done(function( data ) {
					if(data.search("False - ") != -1){
						$("#message").css( "color", "red" )
						$("#message").html(data.substring(data.search(" - ")+3,data.length));
					}else if(data.search("True - ") != -1){
						$("#message").css( "color", "green" )
						$("#message").html(data.substring(data.search(" - ")+3,data.length));					
					}else{
						$("#message").css( "color", "red" )
						$("#message").html("There was an error adding your user, contact the administrator");					
					}
			});		
		});
		$('#loginForm').submit(function(event) {
			event.preventDefault();		
			var data = $('#loginForm').serialize();
			$.post( "login.php", data)
				.done(function( data ) {
					if(data.search("False - ") != -1){
						$("#loginMsg").css( "color", "red" )
						$("#loginMsg").html(data.substring(data.search(" - ")+3,data.length));
					}else if(data.search("True - ") != -1){
						window.location.href = '/home.php';
					}else{
						$("#loginMsg").css( "color", "red" )
						$("#loginMsg").html("There was an error logging you in, contact the administrator");					
					}
			});		
		});			
	});                                    
</script>    
</head>
<body>
<a href="index.php"><img border=0 id="logo" src="images/logo.png" /></a></div>
<div id="login">
<table>
<tr><td>Email</td><td>Password</td></tr>
</font>
<form id=loginForm action="login.php" method="post">
<tr><td><input type="text" id="email" name="email" /></td><td><input type="password" id="password" name="password" /></td><td><input type="submit" name="submit" value="login" /></td></tr>
</form>
</table>
<div id="loginMsg"></div>
</div>

<div id="banter">Armbook helps you connect and share with the people in your life.</div>



<div id="signSlogan"><b>Sign Up</b> <br> It's free and always will be.<br><div id="message"></div></div>

<div id="regInfo">
<form id=regForm action="registration.php" method="post">
<table cellspacing="0" cellpadding="1"><tbody><tr>
<td>First Name:</td><td>
<input type="text" name="firstname" id="firstname" /></td></tr><tr>
<td>Last Name:</td><td>
<input type="text" name="lastname" id="lastname" /></td></tr><tr>

<td>Your Email:</td><td><input type="text" name="reg_email" id="reg_email" /></td></tr><tr>
<td>Re-enter Email:</td><td>
<input type="text" id="reg_email_confirmation"/></td></tr><tr>
<td>
New Password:</td><td>
<input type="password" name="reg_passwd" id="reg_passwd" value="" /></td></tr><tr>
<td>I am:</td><td>
<select id="sex" name="sex">
<option value="0">Select Sex:</option>
<option value="1">Female</option>
<option value="2">Male</option>
</select>
</td></tr><tr>
<td>Birthday:</td><td>
<select id="birthday_month" name="birthday_month"><option value="-1">Month:</option>
<option value="1">Jan</option>
<option value="2">Feb</option>
<option value="3">Mar</option>
<option value="4">Apr</option>
<option value="5">May</option>
<option value="6">Jun</option>
<option value="7">Jul</option>
<option value="8">Aug</option>
<option value="9">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
<select id="birthday_day" name="birthday_day" autocomplete="off"><option value="-1">Day:</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select> 
<select id="birthday_year" name="birthday_year" autocomplete="off"><option value="-1">Year:</option>
<option value="2011">2011</option>
<option value="2010">2010</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
<option value="2007">2007</option>
<option value="2006">2006</option>
<option value="2005">2005</option>
<option value="2004">2004</option>
<option value="2003">2003</option>
<option value="2002">2002</option>
<option value="2001">2001</option>
<option value="2000">2000</option>
<option value="1999">1999</option>
<option value="1998">1998</option>
<option value="1997">1997</option>
<option value="1996">1996</option>
<option value="1995">1995</option>
<option value="1994">1994</option>
<option value="1993">1993</option>
<option value="1992">1992</option>
<option value="1991">1991</option>
<option value="1990">1990</option>
<option value="1989">1989</option>
<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>
<option value="1979">1979</option>
<option value="1978">1978</option>
<option value="1977">1977</option>
<option value="1976">1976</option>
<option value="1975">1975</option>
<option value="1974">1974</option>
<option value="1973">1973</option>
<option value="1972">1972</option>
<option value="1971">1971</option>
<option value="1970">1970</option>
<option value="1969">1969</option>
<option value="1968">1968</option>
<option value="1967">1967</option>
<option value="1966">1966</option>
<option value="1965">1965</option>
<option value="1964">1964</option>
<option value="1963">1963</option>
<option value="1962">1962</option>
<option value="1961">1961</option>
<option value="1960">1960</option>
<option value="1959">1959</option>
<option value="1958">1958</option>
<option value="1957">1957</option>
<option value="1956">1956</option>
<option value="1955">1955</option>
<option value="1954">1954</option>
<option value="1953">1953</option>
<option value="1952">1952</option>
<option value="1951">1951</option>
<option value="1950">1950</option>
</select>
</td></tr>
</tbody></table>

<input type="submit" name="submit" value="Sign Up" />
</form>
</div>

</body>
</html>
