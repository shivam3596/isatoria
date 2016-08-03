<?php require_once 'include/session.php'; ?>
<?php require_once 'include/connection.php'; ?>
<?php require_once 'include/functions.php'; ?>
<?php //confirm_logged_in(); ?>
<?php require_once 'include/validation_function.php'; ?>

<?php
	if (!empty($_GET['username']) && ($_SESSION['username'] != $_GET['username'])) {
		redirect_to('logout.php');
	}
?>

<?php
	$story_id = $_GET['story'];
	$username = $_GET['username'];
  $story_set = find_story_by_story_id($story_id);
?>

<?php
  if (isset($_POST['submit'])) {

    $required_fields = array("title","discription","category","story");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("title" => 50,"discription" => 150 ,"category" => 20, "story" => 5000);
    validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)) {
      $user_id = mysql_prep($story_set['user_id']);
      $title = mysql_prep($_POST['title']);
  		$discription = mysql_prep($_POST['discription']);
      $category = mysql_prep($_POST['category']);
      $story = mysql_prep($_POST['story']);
  		$date = date("Y-m-d");

    $query = "UPDATE story SET user_id ={$user_id}, title='{$title}', discription = '{$discription}', category = '{$category}', story = '{$story}',  date = '{$date}' WHERE story_id ={$story_id} LIMIT 1";

    $result = mysqli_query($connection,$query);
    if ($result && mysqli_affected_rows($connection) >= 0) {
      $_SESSION["message"] = "Story updated.";
      redirect_to('full_story.php?story='. urlencode($story_id). "&username=" .urlencode($username));
    }else {
      $_SESSION["message"] = "something went wrong !";
      redirect_to('edit_story.php?user='. urlencode($story_id). "&username=" .urlencode($username));
    }
  }
  }else {
    //redirect_to('manage_content.php');
  }

 ?>

<?php include 'include/layout/header.php'; ?>
<div id="content-reading-page" class="container">
  <?php
      if (!empty($message)) {
        echo  $message ;
      }
    ?>
  <?php echo get_errors($errors); ?>
<div class="media">
<form action="edit_story.php?story=<?php echo htmlentities($story_id). "&username=" . htmlentities($username); ?>" method="post">
		<div class="media-body">
			<div class="writing-pad">
				<h2 class="media-heading">Title</h2>
				<input type="text" name="title" class="form-control" value="<?php echo htmlentities($story_set['title'])?>" required></input>
			</div>
			<div class="writing-pad">
				<h3 class="media-heading">Discription</h3>
				<input type="text" name="discription" class="form-control" value="<?php echo htmlentities($story_set['discription'])?>" required></input>
			</div>
			<div class="writing-pad">
				<h4 class="media-heading">Select category</h4>
				<select class="form-control" name="category" value="<?php echo htmlentities($story_set['category'])?>" required>
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
				<textarea style="height:150px;" name="story" class="form-control input-lg" required><?php echo htmlentities($story_set['story']);?></textarea>
			</div>
			<input type="submit" name="submit" class="btn btn-Success btn-md comment" ></input>
		</div>
</form>
	</div>
</div>

<?php include 'include/layout/footer.php'; ?>
