<?php require_once 'include/session.php'; ?>
<?php require_once 'include/connection.php'; ?>
<?php require_once 'include/functions.php'; ?>

<?php
  $story_id = $_GET['story'];
  $story = find_story_by_story_id($story_id);
  $user = find_user_by_user_id($story['user_id']);
?>

<?php
if (!$story_id) {
  redirect_to('profile.php?user='. urlencode($user['username']). "&username=" .urlencode($user['username']));
}
  $query = "DELETE FROM story WHERE story_id ={$story_id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION['message'] = "story deleted.";
    redirect_to('profile.php?user='. urlencode($user['username']). "&username=" .urlencode($user['username']));
  }else {
    $_SESSION['message'] = "deletion failed.";
    redirect_to('profile.php?user='. urlencode($user['username']). "&username=" .urlencode($user['username']));
  }
?>
