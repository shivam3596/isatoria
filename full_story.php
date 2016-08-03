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
  $story = find_story_by_story_id($story_id);
?>

<?php
if (isset($_GET['username'])) {
  $username = $_GET['username'];
  $comment_user = find_user_by_username($username);
  $comment_user_id = $comment_user['user_id'];
}
?>
<?php include 'include/layout/header.php'; ?>
<?php
if (isset($_POST['submit'])) {
  $comment_user_name = mysql_prep($_GET['username']);
  $comment_user = find_user_by_username($username);
  $comment_user_id = $comment_user['user_id'];
  $comment = mysql_prep($_POST['comment']);
  $comment_date = date("Y-m-d");

  $required_fields = array("comment");
  validate_presences($required_fields);

  $fields_with_max_lengths = array("slogan" => 150 );
  validate_max_lengths($fields_with_max_lengths);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      redirect_to('full_story.php?story='. urlencode($story_id). "&username=" .urlencode($comment_user['username']));
    }
    $query = "INSERT INTO `comment`(`comment_id`,`story_id`, `user_id`, `comment`,`comment_date`) VALUES ('', {$story_id}, {$comment_user_id}, '{$comment}' ,'{$comment_date}')";
    $result = mysqli_query($connection,$query);

    if ($result) {
      $_SESSION["message"] = "comment added.";
      redirect_to('full_story.php?story='. urlencode($story_id). "&username=" .urlencode($comment_user['username']));
    }else {
      $_SESSION["message"] = "something went wrong.";
      redirect_to('full_story.php?story='. urlencode($story_id). "&username=" .urlencode($comment_user['username']));
    }
  }
else {
  //
  }
?>

<div id="content">
	<div class="alert alert-success" role= "alert" >isatoria</div>
	<div class="media">
		<?php echo message();?>
    <?php $errors = errors(); ?>
    <?php echo get_errors($errors); ?>
    <?php
      $user_id = $story['user_id'];
      $user = find_user_by_user_id($user_id);
    ?>
    <center>
		    <a class="media-left" href="profile.php?user=<?php echo htmlentities($user['username']. "&username=" .htmlentities($username)); ?>">
          <img class="blogger-img " src="upload/<?php echo htmlentities($user_id); ?>.jpg"></img><br><?php echo htmlentities($user['username']); ?>
        </a>
    </center>
      <br>
      <div class="media-body">
				<h4 class="media-heading blog-header"><?php echo htmlentities($story['title']); ?>
          <h6><?php echo htmlentities($story['category']) . " / " . $story['date']; ?></h6>
        </h4><br/>
				<div class="read-more">
					<?php echo nl2br($story['story']); ?>
				</div>
			</div>
	</div>
  <hr>
  <!-- comment will appear here... -->
  <?php $cmnt = comment($story_id,$username);?>
  <?php echo $cmnt; ?>

  <!-- comment box here...-->
  <?php
    $check_user = $_GET['username'];
    $check_it = find_user_by_username($check_user);
    if (isset($_GET['username']) && !empty($_GET['username']) && $check_it) {
    ?>
  <div class=" container" style="border-left:2px solid #d3d3d3;margin-top:15px; ">
    <a class="media-left" href="profile.php?user=<?php echo htmlentities($check_it['username'] ."&username=" .htmlentities($check_it['username'])); ?>">
      <img class="blogger-img " src="upload/<?php echo htmlentities($check_it['user_id']); ?>.jpg"></img><br><?php echo htmlentities($check_it['username']); ?>
    </a>
    <div class="media-body" style="background-color:#f2dede;border:1px solid #d3d3d3;">
      <form action="full_story.php?story=<?php echo htmlentities($story_id) ."&username=". htmlentities($check_it['username']);?>" method="post">
        <input style="height:50px;width:100%;" type="text" name="comment" placeholder="comment here..." value="" required></input>
        <input class="btn btn-default btn-sm" style="float:right;margin-top:5px;" type="submit" name="submit" value="comment"></input>
      </form>
    </div>
  </div>

<?php }?>
</div>

<?php include 'include/layout/footer.php'; ?>
