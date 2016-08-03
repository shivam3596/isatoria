<?php require_once 'include/session.php'; ?>
<?php require_once 'include/connection.php'; ?>
<?php require_once 'include/functions.php'; ?>
<?php require_once 'include/validation_function.php'; ?>
<?php //confirm_logged_in(); ?>
<?php
	if (!empty($_GET['user']) && ($_SESSION['username'] != $_GET['user'])) {
		redirect_to('logout.php');
	}
?>

<?php
	if (isset($_GET['user']) && !empty($_GET['user'])) {
		$username = $_GET['user'];
		$user = find_user_by_username($username);
	}
?>
<?php
	if (!isset($user) || empty($user)) {
		redirect_to('login.php');
	}
?>
<?php include 'include/layout/header.php'; ?>
<?php
  if (isset($_POST['submit'])) {
    $title = mysql_prep($_POST['title']);
		$discription = mysql_prep($_POST['discription']);
    $category = mysql_prep($_POST['category']);
    $story = mysql_prep($_POST['story']);
		$date = date("Y-m-d");

    $required_fields = array("title","discription","category","story");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("title" => 50,"discription" => 150 ,"category" => 20, "story" => 5000);
    validate_max_lengths($fields_with_max_lengths);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      redirect_to('write.php?user='. urlencode($username));
    }

    $query = "INSERT INTO `story`(`story_id`, `user_id`, `title`, `discription`, `category`, `story`, `date`) VALUES ('', {$user['user_id']}, '{$title}', '{$discription}', '{$category}', '{$story}', '{$date}' )";

    $result = mysqli_query($connection,$query);
    if ($result) {
      $_SESSION["message"] = "Story posted successfully";
      redirect_to('index.php?user='. urlencode($username));
    }else {
      $_SESSION["message"] = "something went wrong !";
      redirect_to('write.php?user='. urlencode($username));
    }
  }else {
    //redirect_to('manage_content.php');
  }
 ?>


<div id="content-reading-page" class="container">
  <?php echo message();?>
  <?php $errors = errors(); ?>
  <?php echo get_errors($errors); ?>
<div class="media">
<form action="write.php?user=<?php echo htmlentities($user['username']); ?>" method="post">
		<div class="media-body">
			<div class="writing-pad">
				<h2 class="media-heading">Title</h2>
				<input type="text" name="title" class="form-control" placeholder="Title of story..." required></input>
			</div>
			<div class="writing-pad">
				<h3 class="media-heading">Discription</h3>
				<input type="text" name="discription" class="form-control" placeholder="About story..." required></input>
			</div>
			<div class="writing-pad">
				<h4 class="media-heading">Select category</h4>
				<select class="form-control" name="category" required>
					<optgroup label="select category">
						<option >funny</option>
						<option >real-story</option>
						<option>shayari</option>
						<option>poem</option>
						<option>movie</option>
						<option>inspirational</option>
					</optgroup>
				</select>
			</div>
			<div class="writing-pad">
				<textarea style="height:150px;" name="story" class="form-control input-lg" placeholder="Add Text..." required></textarea>
			</div>
			<input type="submit" name="submit" class="btn btn-Success btn-md comment" ></input>
		</div>
</form>
	</div>
</div>

<?php include 'include/layout/footer.php'; ?>
