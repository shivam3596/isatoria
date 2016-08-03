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
	if ( isset($_GET['user']) && isset($_GET['username'])) {
		$profile_username = $_GET['user'];
		$username = $_GET['username'];
	}else {
		redirect_to('index.php');
	}
?>

<?php include 'include/layout/header.php'; ?>
<?php
	$user = find_user_by_username($profile_username);
	$slogan = find_slogan_by_id($user['user_id']);
	if ($slogan['slogan'] == "") {
		insert_default_slogan($user['user_id']);
	}
	$slogan = find_slogan_by_id($user['user_id']);
	$story_count = count_stories_by_user_id($user['user_id']);
?>

<div class="cover bg">
	<div class="profile-info">
		<div class="dp-change">
			<img class="dp" <?php echo "src=\"upload/{$user['user_id']}.jpg\" alt=\"$user[username]\""; ?> ></img>
		</div>
		<div class="bio">
			<?php
	    	if ($profile_username === $username) {   ?>
			<div class="detail"><a href="edit_profile.php?user=<?php echo htmlentities($username);?>">Edit Profile</a></div>
				<?php } ?>

			<div class="detail"><?php echo htmlentities($user['username']); ?></div>
			<div class="email-info"><?php echo htmlentities($user['email']); ?></div>
			<div class="detail">Story published
				<div class="value"><?php echo htmlentities($story_count); ?></div>
			</div>
			<?php
	    	if ($profile_username === $username) {   ?>
			<div class="detail">
				<a href="write.php?user=<?php echo htmlentities($user['username']); ?>">Write a story</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class=" slogan">
		<?php echo htmlentities($slogan['slogan']); ?>
	</div>
	<?php echo message();?>
</div>

<?php
	if($story_count == 0){
		echo "<div class=\"alert alert-danger\" role =\"alert\">No stories to display...</div>";
	}else{
		echo "<div class=\"alert alert-success\" role =\"alert\">Top Stories</div>";
		$op = stories_by_id($user['user_id'], $user,$username);
		echo $op;
	}
?>

<?php include 'include/layout/footer.php'; ?>
