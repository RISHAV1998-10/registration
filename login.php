	
<?php
	
	include("connect.php");
	include("functions.php");
	
	if(logged_in())
	{
		header("location:profile.php");
		exit();
	}
	
	$error="";
	
	if(isset($_POST['submit']))
	{
		
		$email=$_POST['email'];
		$password=$_POST['password'];
		$checkBox=isset($_POST['keep']);
		
		
		if(email_exists($email,$con))
		{
			$result=mysqli_query($con,"SELECT password From users WHERE email='$email'");
			$retrievepassword=mysqli_fetch_assoc($result);
			
			
			if(md5($password) !== $retrievepassword['password'])
			{
				$error="Password is incorrect";
				
			}
			else
			{
				$_SESSION['email']=$email;
				
				
				if($checkBox=="on")
				{
					setcookie("email",$email, time()+3600);
					
				}
				header("location: profile.php");
				
			}
			
		}
		else
		{
			$error="Email does not Exist";
		}
			
	}



?>



<! doctype html>
<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
		<div id="error" style=" <?php   if($error!=""){?>  display:block  <?php } ?> ;margin-top:40px;">
			<?php echo $error;  ?>
		</div>
		<div id="wrapper">
		
			<div id="menu" class="menus">
				<a href="index.php" >Sign Up </a>
				<a href="login.php" id="onlink">Log In </a>
			</div>
			<div id="formDiv">
				<form method="POST" action="login.php" >
					
					<label>Email :</label><br>
					<input type="text" name="email"  class="inputfields" required /><br><br>
					
					<label>Password :</label><br>
					<input type="password" name="password"  class="inputfields" required /><br><br>
					
					
					<input type="checkbox" name="keep"><label> Keep Me Logged In</label><br><br>
					
					<input type="submit" class="theButtons" name="submit" value="Log In" /><br><br>
				
				
				
				
				
				
				</form>
			</div>
			
		
		</div>
	</body>
</html>