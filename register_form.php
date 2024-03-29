<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $user_type = $_POST['user_type'];
    $dob = $_POST['dob'];

    // Check if the passwords match
    if ($pass !== $cpass) {
        $error[] = 'Passwords do not match!';
    } else {
        // Check if the user already exists
        $select = "SELECT * FROM user_form WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User already exists!';
        } else {
            // Hash the password using bcrypt
            $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

            // Insert the user data into the database
            $insert = "INSERT INTO user_form (name, email, user_type, dob, password) VALUES ('$name', '$email', '$user_type', '$dob', '$hashedPassword')";
            mysqli_query($conn, $insert);

            header('location:login_form.php');
        }
    }
}
?>


<!-- this is for HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
  

</head>
<body>
   <!-- Navbar -->
	<nav class="navbar navbar-expand-md text-white shadow">
		<a class="navbar-brand" href="homepage.php">UESS</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item" >
					<a class="nav-link active" href="register_form.php">Register</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="login_form.php">Login</a>
				</li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Nigeria
                    </a>
                    
                </li>
			</ul>
		</div>
	</nav>


   <!-- this is for login form-->
   <div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Enter Full Name">
      <input type="email" name="email" required placeholder="Enter Email Address">
      <select name="user_type">
         <option value="male">Male</option>
         <option value="female">Female</option>
      </select>
      <input type="date" name="dob" required placeholder="Enter your DOB">
      <input type="password" name="password" required placeholder="Enter password">
      <input type="password" name="cpassword" required placeholder="Confirm password">
      
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

<!-- Footer -->
<footer class="footer">
		<div class="footer-container">
			<div class="row">
				<div class="text-right">
					<p>&copy; 2023</p>
				</div>
				<div class="text-center">
					<p>DeeMerry TechVibe</p>
				</div>
				<div class="text-a">
					<a href="#">Terms | Privacy Policy</a>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>