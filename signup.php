<?php require_once ('include/session.php'); ?>
<?php require_once ('include/connection.php'); ?>
<?php require_once ('include/functions.php'); ?>
<?php require_once ('include/validation_function.php'); ?>

<?php
  if (isset($_POST['submit'])) {
    $username = mysql_prep($_POST['username']);
		$email = mysql_prep($_POST['email']);
    $hashed_password = password_encrypt($_POST['password']);

    $required_fields = array("username","email","password");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("username" => 50,"email" => 50 ,"password" => 50);
    validate_max_lengths($fields_with_max_lengths);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      redirect_to('signup.php');
    }

    $query = "INSERT INTO `register`(`user_id`, `username`, `email`, `password`) VALUES ('','{$username}', '{$email}' ,'{$hashed_password}')";

    $result = mysqli_query($connection,$query);
    if ($result) {
      $_SESSION["message"] = "successfully signed up.";
      redirect_to('index.php?user='. urlencode($username));
    }else {
      $_SESSION["message"] = "something went wrong !";
      redirect_to('signup.php');
    }
  }else {
    //redirect_to('manage_content.php');
  }
 ?>

<?php include 'include/layout/simple_header.php'; ?>
<div id="content-reading-page" class="container" style="background-color:#e3e3e3;">
<center>
<div class="media">
  <div id="page">
    <?php echo message();?>
    <?php $errors = errors(); ?>
    <?php echo get_errors($errors); ?>
    <h2>sign up</h2>
    <form action="signup.php" method="post" class="input-group">
      <p>user name: <input class="form-control " type="text" name="username" value="" required></p>
      <p>email: <input class="form-control" type="email" name="email" value="" required></p>
      <p>password: <input class="form-control" type="password" name="password" value="" required></p>
      <input style="margin-top:10px;" class="btn btn-Success btn-md" type="submit" name="submit" value="signup">
    </form>
  </div>
</div>
</center>
</div>
<?php  include ('include/layout/footer.php'); ?>
