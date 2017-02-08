<?php
  require_once('..\private\initialize.php');
  include(SHARED_PATH.'/header.php'); 
  ?>
  <?php $page_title = 'Register'; ?>
  <div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>
  
  <form action = "register.php" method ="post">
    First name: <input type="text" name = "first_name" value=""/>
    Last name: <input type="text" name="last_name" value=""/><br/>
    Email: <input type="text" name="email" value =""/><br/>
    Username:<input type="text" name="username" value=""/><br />
    <br />
    <input type="submit" name="submit" value="Submit" />
	
  
  </form>
</div>
<?php
if (isset($_POST['submit'])){ 
// Set default values for all variables the page needs.
  $firstname = '';
  $lastname = '';
  $email = '';
  $user = '';
  $errors = array();
  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $email = $_POST['email'];
    $user = $_POST['username'];
  }
    // Confirm that POST values are present before accessing them.
	$firstname = isset($_POST['first_name']) ? $_POST['first_name']: ''; 
	$lastname = isset($_POST['last_name']) ? $_POST['last_name']: '';
	$email = isset($_POST['email']) ? $_POST['email']: '';
	$user = isset($_POST['username']) ? $_POST['username'] : ''; 


    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    if (empty($firstname)){
      array_push($errors, "Enter your first name." );
    }elseif (!has_length($firstname, [2,255])) {
      array_push($errors, "first name should be between 2 and 255 characters.");
    }
    if (empty($lastname)){
      array_push($errors,"Enter your last name.");
    }elseif (!has_length($lastname, [2, 255])){
      array_push($errors, "last name should between 2 and 255 characters.");
    }
    if (empty($email)){
      array_push($errors, "Enter your email address.");
	  echo "email is empty"; 
    }elseif (!has_length($email, [8, 255])){
      array_push($errors,"email should be between 8 and 255 characters.");
    }elseif (!has_valid_email_format($email)){
      array_push($errors, "enter valid email address.");
    }
    if (empty($user)) {
      array_push($errors, "Enter a username.");
    }elseif (!has_length($user, [8,255])){
      array_push($errors, "username should be between 8 and 255 characters.");
    }
    // if there were no errors, submit data to database
	if (empty($errors)){
     // Write SQL INSERT statement
     $firstname = mysqli_real_escape_string($db, $firstname);
     $lastname = mysqli_real_escape_string($db, $lastname);
     $email = mysqli_real_escape_string($db, $email);
     $user = mysqli_real_escape_string($db, $user);
  
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO users(first_name, last_name, email, username, created_at) VALUES('$firstname','$lastname', '$email', '$user', '$date')";
    $result = db_query($db, $sql);
    if($result) {
        db_close($db);
        redirect_to('registration_success.php');
      } 
    else {
        echo db_error($db);
        db_close($db);
        exit;
     }
	}
  }
 
?>
	<?php if (!empty($errors)){
		echo display_errors($errors);
		exit; 
	}
	?>
<?php include(SHARED_PATH.'/footer.php'); ?>
