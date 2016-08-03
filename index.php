<?php require_once 'include/session.php'; ?>
<?php require_once 'include/connection.php'; ?>
<?php require_once 'include/functions.php'; ?>
<?php //confirm_logged_in(); ?>
<?php require_once 'include/validation_function.php'; ?>

<?php
	if (!empty($_GET['user']) && ($_SESSION['username'] != $_GET['user'])) {
		redirect_to('logout.php');
	}
?>

<?php
  if (isset($_GET['user']) && !empty($_GET['user'])) {
    $username = $_GET['user'];
    $user = find_user_by_username($username);
    if (empty($user)) {
      redirect_to('index.php');
    }
    include 'include/layout/logged_header.php';
  }else {
    $username = null;
    $user = null;
    include 'include/layout/main_header.php';
  }
?>

<?php
	if (isset($_POST['search']) && !empty($_POST['search'])) {
		$user_query = $_POST['text'];
	}
 ?>

<div id="content">
	<div class="alert" role= "alert" >
		<form action= "index.php?user=<?php echo htmlentities($username); ?>" method="post">
				<input name="text" type="text" placeholder="search people , stories ..." required></input>
				<input name="search" type="submit" value="search" class="btn btn-sm btn-danger" ></input>
		</form>
		<?php
			if (!empty($user_query)) {
				echo "<br><b>search result</b>";
				$op_user = search_by_user($user_query,$username);
				echo $op_user;
				$op_story = search_by_title($user_query,$user,$username);
				echo $op_story;
				$op_story_by_category = search_by_category($user_query,$user,$username);
				echo $op_story_by_category;
			}
		?>
	</div>
	<div class="alert alert-info"  role= "alert" > Read Stories By Category </div>
<div role="tabpanel">
	<div class="menu" >
		<ul class="nav nav-default" role="tablist">
			<li role="presentation" class="active"><a href="#funny" aria-controles="funny" role="tab" data-toggle="tab">Funny</a></li>
			<li role="presentation" ><a href="#real-story" aria-controles="real-story" role="tab" data-toggle="tab">Real Story</a></li>
			<li role="presentation" ><a href="#shayari" aria-controles="shayari" role="tab" data-toggle="tab">Shayari</a></li>
			<li role="presentation" ><a href="#poem" aria-controles="poem" role="tab" data-toggle="tab">Poem</a></li>
			<li role="presentation" ><a href="#movie" aria-controles="movie" role="tab" data-toggle="tab">Movie</a></li>
			<li role="presentation" ><a href="#inspirational" aria-controles="inspirational" role="tab" data-toggle="tab">Inspirational</a></li>
		</ul>
	</div>

<div class="here">
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="funny" >
			<?php echo message();?>
			<?php $errors = errors(); ?>
			<?php echo get_errors($errors); ?>

			<?php
        if (isset($_GET['user']) && !empty($_GET['user'])) {
          $op = latest_story($user['user_id'],$user,$username);
          echo $op;
        }
        ?>
			<?php $category_wise_story = find_all_stories_by_category("funny",$user,$username);	?>
			<?php echo $category_wise_story; ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="real-story" >
			<?php $category_wise_story = find_all_stories_by_category("real-story",$user,$username);	?>
			<?php echo $category_wise_story; ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="shayari" >
			<?php $category_wise_story = find_all_stories_by_category("shayari",$user,$username);	?>
			<?php echo $category_wise_story; ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="poem" >
			<?php $category_wise_story = find_all_stories_by_category("poem",$user,$username);	?>
			<?php echo $category_wise_story; ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="movie" >
			<?php $category_wise_story = find_all_stories_by_category("movie",$user,$username);	?>
			<?php echo $category_wise_story; ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="inspirational" >
			<?php $category_wise_story = find_all_stories_by_category("inspirational",$user,$username);	?>
			<?php echo $category_wise_story; ?>
		</div>
	</div>
</div>
</div>
</div>

<?php include 'include/layout/footer.php'; ?>
