<?php  
		$konekcija = mysql_connect('localhost', 'root', '0454527676842');
		$database = mysql_select_db('meda_forum') or die( "Database in unavailable!"); 
		if (!$konekcija) {
			die('Database connection has timed out! '.mysql_error());
		}
		
	if(isset($_REQUEST['btnRegister2'])) {
		$email = trim($_REQUEST['tbEmail2']); 
		$username = trim($_REQUEST['tbUsername2']); 
		$password = trim($_REQUEST['tbPassword2']);
		$remail = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/"; 
		$rusername = "/^[A-z0-9_.]{3,40}$/"; 
		$rpassword = "/^[A-z0-9_.]{3,40}$/";
		$greske = array(); 
		
		if(!preg_match($remail, $email)){
			$greske[] = "Enter valid email address.";
		}
		if(!preg_match($rusername, $username)){
			$greske[] = "Username can contain only letters, numbers and _. ."; 
		} 
		if(!preg_match($rpassword, $password)){
			$greske[] = " Password can contain only letters, numbers and _. ."; 
		}

		

		if(empty($greske)){ 
			$password = sha1($password); 
			$upit = "SELECT * FROM users WHERE email='".$email."' OR username = '".$username."' ";
			$rezultat = mysql_query($upit, $konekcija); 
			if(mysql_num_rows($rezultat) == 0){
				$upit = "INSERT INTO users (id_users, username, password, email, user_mod, active) VALUES (NULL, '".$username."', '".$password."', '".$email."', '2', '0')";
				$rezultat = mysql_query($upit, $konekcija); 
				header("location:register.php?message= <div id='uspesno'>Registration was successful, you can login now.</div><br/>");
			}else {
				header("location:register.php?message=User with that email or username is registered, try with another email or username!");
			}
		}else{
			foreach($greske as $value){
				header("location:register.php?message= <div id='erori'>".$value."</div><br/>");
			} 
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Meda - Forum</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<meta name="description" content=""/>
		<meta name="keywords" content=""/>
		<meta name="author" content=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<script type="text/javascript" src=""></script>
</head>
	<body>
		<?php
			include("header.php");
		?>
		<?php
			
		?>
		<div id="registerpage">
		<h2>Register: </h2><br/>
		<header><?php if(isset($_REQUEST['message'])) echo $_REQUEST["message"]; ?></header><br/>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
				<input type="text" name="tbEmail2" id="tbEmail2" placeholder="email"/><br/><br/>
				<input type="text" name="tbUsername2" id="tbUsername2" placeholder="username"/><br/><br/>
				<input type="password" name="tbPassword2" id="tbPassword2" placeholder="password"/><br/><br/>
				<input type="submit" name="btnRegister2" id="btnRegister2" value="Register"/><br/><br/>
			</form>
		</div><br/><br/><br/><br/>
        <?php
			include("footer.php");
		?>
	</body>
</html>