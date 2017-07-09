	
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
		$firstName=$_POST['fname'];
		$lastName=$_POST['lname'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$passwordConfirm=$_POST['passwordConfirm'];
		
		$image=$_FILES['image']['name'];
		$tmp_image=$_FILES['image']['tmp_name'];
		$imageSize=$_FILES['image']['size'];
		
		$conditions=isset($_POST['conditions']);
		
		$date=date("F, d y");
		
		
		if(strlen($firstName)<3)
		{
			$error="First Name is too short";
		}
		else if(strlen($lastName)<3)
		{
			$error="Last Name is too short";
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error="Please enter Valid Email Address";
		}
		else if(email_exists($email,$con))
		{
			$error="Someone is already registered with the same email";
		}
		else if(strlen($password)<8)
		{
			$error="Password must be of atleast 8 characters";	
		}	
		else if($password !==$passwordConfirm)
		{
			$error="Password does not match";
		}
		else if($image=="")
		{
			$error="Please upload your Image";
		}
		else if($imageSize>3145728)
		{
			$error="Image size must be less than 3 MB";
		}
		else if(!$conditions)
		{
			
			$error="You must agree with the terms and conditions";
			
		}
		else
		{
			$password=md5($password);
			
			$imageExt=explode(".",$image);
			$imageExtension=$imageExt[1];
			
			if($imageExtension=='png' || $imageExtension=='PNG' || $imageExtension=='jpg' || $imageExtension=='JPG')
			{
			$image=rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
			
			$insertQuery="INSERT INTO users(firstName, lastName, email, password, image, date) VALUES('$firstName', '$lastName', '$email', '$password', '$image' , '$date') ";
			if(mysqli_query($con, $insertQuery))
			{
				if(move_uploaded_file($tmp_image,"images/$image"))
				{
					$error="You are Successfully Registered";
				}
				else
				{
					$error="Image is not uploaded";
				}
			}
			}
			else
			{
				$error="File must be Image";
			}
		}
			
	}



?>












<! doctype html>
<html>
	<head>
		<title>Registration Page</title>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
		<div id="error" style=" <?php   if($error!=""){?>  display:block;  <?php } ?> ">
			<?php echo $error;  ?>
		</div>
		<div id="wrapper" style=" <?php   if($error!=""){?>  margin:0px auto;  <?php } ?> ">
			<div id="menu" class="menus" >
				<a href="index.php" id="onlink">Sign Up </a>
				<a href="login.php" >Log In </a>
			</div>
			<div id="formDiv" >
				<form method="POST" action="index.php" enctype="multipart/form-data">
					<label>First Name :</label><br>
					<input type="text" name="fname" class="inputfields" required /><br><br>
					
					<label>Last Name :</label><br>
					<input type="text" name="lname"  class="inputfields" required /><br><br>
					
					<label>Email :</label><br>
					<input type="text" name="email"  class="inputfields" required /><br><br>
					
					<label>Password :</label><br>
					<input type="password" name="password"  class="inputfields" required /><br><br>
					
					<label>Re-enter Password :</label><br>
					<input type="password" name="passwordConfirm"  class="inputfields" required /><br><br>
					
					<label>Image :</label><br>
					<input type="file" name="image" id="imageupload" /><br><br>
					
					<input type="checkbox" name="conditions"/>
					<label>  I agree with Terms and Condition</label>
					<br><br>
					
					
					<input type="submit" class="theButtons" name="submit"/><br><br>
				
				
				
				
				
				
				</form>
			</div>
			
		
		</div>
	</body>
</html>