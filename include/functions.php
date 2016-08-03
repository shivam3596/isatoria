<?php

function redirect_to($link){
  header("Location: " .$link);
  exit;
}

function mysql_prep($string){
  global $connection;
  $escaped_string = mysqli_real_escape_string($connection,$string);
  return $escaped_string;
}

function check_query($result_set){
  if(!$result_set){
  die("can't perform query");
  }
}

function get_errors($errors = array()){
  $op = "";
  if (!empty($errors)) {
  $op .= "<ul class=\" message\" >";
  foreach ($errors as $key => $error) {
    $op .= "<li class=\"error-list\">";
    $op .= htmlentities($error);
    $op .= "</li>";
  }
    $op .= "</ul>";
  }
  return $op;
}

function find_user_by_username($username){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$username);
  $query = "SELECT * FROM register where username='{$safe}' LIMIT 1";
  $user_set = mysqli_query($connection,$query);
  check_query($user_set);
  if ($user = mysqli_fetch_assoc($user_set)) {
    return $user;
  }else {
    return null;
  }
}

function find_current_user(){
  global $current_user;
  if (isset($_GET['username'])) {
    $current_user = find_user_by_username($_GET['username']);
  }else {
    $current_user = null;
  }
}

function find_user_by_user_id($user_id){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$user_id);
  $query = "SELECT * FROM register where user_id={$safe} LIMIT 1";
  $user_set = mysqli_query($connection,$query);
  check_query($user_set);
  if ($user = mysqli_fetch_assoc($user_set)) {
    return $user;
  }else {
    return null;
  }
}

function insert_default_slogan($user_id){
  global $connection;
  $default_slogan = "Hey there ... i am using isatoria !";
  $safe = mysqli_real_escape_string($connection,$user_id);
  $query = "INSERT INTO `updated`(`id`, `user_id`, `slogan`) VALUES ('','$user_id', '{$default_slogan}')";
  $result = mysqli_query($connection,$query);
  if (!$result) {
    die('something went wrong...');
  }
}

function find_slogan_by_id($user_id){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$user_id);
  $query = "SELECT * FROM updated where user_id={$safe} LIMIT 1";
  $user_set = mysqli_query($connection,$query);
  check_query($user_set);
  if ($slogan = mysqli_fetch_assoc($user_set)) {
    return $slogan;
  }else {
    return null;
  }
}

function img($image,$user_id,$extension){

 $image_size=getimagesize($image);
 $image_width  = $image_size[0];

 $image_height = $image_size[1];

 $new_size = 3*($image_width + $image_height)/($image_width*($image_height/45));

 $new_width=$image_width*$new_size;
 $new_height=$image_height*$new_size;

 $new_image=imagecreatetruecolor($new_width,$new_height);

 if ($extension=='jpg'|| $extension=='jpeg') {
	$old_image=imagecreatefromjpeg($image);
  }elseif ($extension='png') {
	   $old_image=imagecreatefrompng($image);
  }else{
	   return false;
  }
  imagecopyresized($new_image,$old_image,0,0,0,0,$new_width,$new_height,$image_width,$image_height);
  if(imagejpeg($new_image,"upload/$user_id.jpg")){
	   return true;
  }else{
	   return false;
  }
}

function find_story_by_id($user_id){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$user_id);
  $query = "SELECT * FROM story where user_id={$safe} LIMIT 1";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  if ($story = mysqli_fetch_assoc($story_set)) {
    return $story;
  }else {
    return null;
  }
}

function find_story_by_story_id($story_id){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$story_id);
  $query = "SELECT * FROM story where story_id={$safe} LIMIT 1";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  if ($story = mysqli_fetch_assoc($story_set)) {
    return $story;
  }else {
    return null;
  }
}

function find_all_users(){
  global $connection;
  $query = "SELECT * FROM register LIMIT 10";
  $user_set = mysqli_query($connection,$query);
  check_query($user_set);
  return $user_set;
}

function latest_posted_story_by_user_id($user_id){
  global $connection;
  $query = "SELECT * FROM story where user_id ={$user_id} order by story_id desc limit 1 ";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  return $story_set;
}

function latest_story($user_id,$user,$username){

  $op  = "<ul class=\"story-set\">";
  $story_set = latest_posted_story_by_user_id($user_id);
  while ($story = mysqli_fetch_assoc($story_set)) {
    $op .= "<div class=\"media\">";
    $op .= "<a class=\"media-left\" href=\"profile.php?user=$user[username]&username=$username\"><img class=\"blogger-img \" src=\"upload/{$user['user_id']}.jpg\" ></img><br>{$user['username']}</a>";
    $op .= "<div class=\"media-body \">";
    $op .= "<h4 class=\"media-heading blog-header\">";
    $op .= $story['title'];
    $op .= "<h6>". $story['category'] . " / " .$story['date']."</h6>";
    $op .= "</h4><br/>";
    $op .= "<div class=\"read-more \">";
    $op .= nl2br($story['discription']);
    $op .= "<a href=\"full_story.php?story=";
    $op .= htmlentities($story['story_id']) ."&username=" .$username;
    $op .= "\">";
    $op .= " Read more ";
    $op .= "</a>";
    $op .= "</div></div></div>";
    }
      mysqli_free_result($story_set);
      $op .= "</ul>";
      return $op;
}

function find_all_stories_by_user_id($user_id){
  global $connection;
  $query = "SELECT * FROM story where user_id ={$user_id}";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  return $story_set;
}

function stories_by_id($user_id,$user,$username){
  $op  = "<ul class=\"story-set\">";
  $story_set = find_all_stories_by_user_id($user_id);
  while ($story = mysqli_fetch_assoc($story_set)) {
    $op .= "<div class=\"media\">";
    $op .= "<a class=\"media-left\" href=\"profile.php?user=$user[username]&username=$username\"><img class=\"blogger-img \" src=\"upload/{$user['user_id']}.jpg\" ></img><br>{$user['username']}</a>";
    $op .= "<div class=\"media-body \">";
    $op .= "<h4 class=\"media-heading blog-header\">";
    $op .= $story['title'];
    $op .= "<h6>". $story['category'] . " / " . $story['date'] ;
    if ($user['username'] === $username) {
      $op .= " / <a href=\"edit_story.php?story=$story[story_id]&username=$username\"> Edit </a>";
      $op .= " / <a href=\"delete_story.php?story=$story[story_id] \" onclick=\"return confirm('You really want to delete this ?');\"> Delete </a>";
    }
    $op .= "</h6></h4><br/>";
    $op .= "<div class=\"read-more \">";
    $op .= nl2br($story['discription']);
    $op .= "<a href=\"full_story.php?story=";
    $op .= htmlentities($story['story_id']) ."&username=" .$username ;
    $op .= "\">";
    $op .= " Read more ";
    $op .= "</a>";
    $op .= "</div></div></div>";
    }
      mysqli_free_result($story_set);
      $op .= "</ul>";
      return $op;
}

function find_all_stories(){
  global $connection;
  $query = "SELECT * FROM story LIMIT 3";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  return $story_set;
}

function all_stories(){
  $output  = "<ul class=\"story-set\">";
  $story_set = find_all_stories();
  $user_set = find_all_users();
  while (($story = mysqli_fetch_assoc($story_set)) && ($user = mysqli_fetch_assoc($user_set))) {
    $output .= "<div class=\"media\">";
    $output .= "<a class=\"media-left\" href=\"profile.php?user=$user[username]\"><img class=\"blogger-img \" src=\"upload/{$user['user_id']}.jpg\" ></img><br>{$user['username']}</a>";
    $output .= "<div class=\"media-body \">";
    $output .= "<h4 class=\"media-heading blog-header\">";
    $output .= $story['title'];
    $output .= "<h6>" . $story['category'] . " / " .$story['date']."</h6>";
    $output .= "</h4><br/>";
    $output .= "<div class=\"read-more \">";
    $output .= nl2br($story['discription']);
    $output .= "<a href=\"full_story.php?story=";
    $output .= htmlentities($story['story_id']) ."&username=" .$user['username'] ;
    $output .= "\">";
    $output .= " Read more ";
    $output .= "</a>";
    $output .= "</div></div></div>";
    }
      mysqli_free_result($story_set);
      mysqli_free_result($user_set);
      $output .= "</ul>";
      return $output;
}

function count_stories_by_user_id($user_id){
  global $connection;
  $query = "select count(user_id) from story where user_id = {$user_id}";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  $story_count = mysqli_fetch_row($story_set);
  $count = $story_count[0];
  return $count;
}

function find_all_stories_by_category($category,$user,$username){
  global $connection;
  $query = "SELECT * FROM story where  category='{$category}' ";
  $category_set = mysqli_query($connection,$query);
  check_query($category_set);
  $output  = "<ul class=\"story-set\">";
  while ($category = mysqli_fetch_assoc($category_set)) {
    $user_id = $category['user_id'];
    $story_user = find_user_by_user_id($user_id);
    $output .= "<div class=\"media\">";
    $output .= "<a class=\"media-left\" href=\"profile.php?user=$story_user[username]&username=$username \"><img class=\"blogger-img \" src=\"upload/{$story_user['user_id']}.jpg\" ></img><br>{$story_user['username']}</a>";
    $output .= "<div class=\"media-body \">";
    $output .= "<h4 class=\"media-heading blog-header\">";
    $output .= $category['title'];
    $output .= "<h6>" . $category['category'] . " / " .$category['date']."</h6>";
    $output .= "</h4><br/>";
    $output .= "<div class=\"read-more \">";
    $output .= nl2br($category['discription']);
    $output .= "<a href=\"full_story.php?story=";
    $output .= htmlentities($category['story_id']) ."&username=" .$username ;
    $output .= "\">";
    $output .= " Read more ";
    $output .= "</a>";
    $output .= "</div></div></div>";
    }
      mysqli_free_result($category_set);
      $output .= "</ul>";
      return $output;
}

function search_user_by_username($username){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$username);
  $query = "SELECT * FROM register where username like '%".$safe."%' LIMIT 3" ;
  $user_set = mysqli_query($connection,$query);
  check_query($user_set);
  return $user_set;
}

function search_story_by_title($title){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$title);
  $query = "SELECT * FROM story where title like '%".$safe."%' LIMIT 3";
  $story_set = mysqli_query($connection,$query);
  check_query($story_set);
  return $story_set;
}

function search_story_by_category($category){
  global $connection;
  $safe = mysqli_real_escape_string($connection,$category);
  $query = "SELECT * FROM story where category like '%".$safe."%' LIMIT 3";
  $category_set = mysqli_query($connection,$query);
  check_query($category_set);
  return $category_set;
}

function search_by_user($search_query,$username){
  $user_result = search_user_by_username($search_query);
  $user_op = "<br><ul>";
  if (!empty($user_result)) {
    while ($user = mysqli_fetch_assoc($user_result) ) {
      $user_op .= "<a class=\"media-left\" href=\"profile.php?user=$user[username]&username=$username \"><img class=\"blogger-img \" src=\"upload/{$user['user_id']}.jpg\" ></img><br>{$user['username']}</a>";
    }
    $user_op .= "</ul>";
    return $user_op;
  }
}

function search_by_title($search_query,$user,$username){
  $story_result = search_story_by_title($search_query);
  $story_op = "<br><ul>";
  if (!empty($story_result)) {
    while ($story = mysqli_fetch_assoc($story_result)) {
      $story_op .= "<li>";
      $story_op .= "<div class=\"media-body \">";
      $story_op .= "<h4 class=\"media-heading blog-header\">";
      $story_op .= $story['title'];
      $story_op .= "<h6>" . $story['category'] . " / " .$story['date']."</h6>";
      $story_op .= "</h4><br/>";
      $story_op .= "<div class=\"read-more \">";
      $story_op .= nl2br($story['discription']);
      $story_op .= "<a href=\"full_story.php?story=";
      $story_op .= htmlentities($story['story_id']) ."&username=" .$username ;
      $story_op .= "\">";
      $story_op .= " Read more ";
      $story_op .= "</a>";
      $story_op .= "</div>";
      $story_op .= "</li>";
    }
    $story_op .= "</ul>";
    return $story_op;
  }
}

function search_by_category($search_query,$user,$username){
  $category_set = search_story_by_category($search_query);
  $story_op = "<br><ul>";
  if (!empty($category_set)) {
    while ($story = mysqli_fetch_assoc($category_set)) {
      $story_op .= "<li>";
      $story_op .= "<div class=\"media-body \">";
      $story_op .= "<h4 class=\"media-heading blog-header\">";
      $story_op .= $story['title'];
      $story_op .= "<h6>" . $story['category'] . " / " .$story['date']."</h6>";
      $story_op .= "</h4><br/>";
      $story_op .= "<div class=\"read-more \">";
      $story_op .= nl2br($story['discription']);
      $story_op .= "<a href=\"full_story.php?story=";
      $story_op .= htmlentities($story['story_id'])."&username=" .$username ;
      $story_op .= "\">";
      $story_op .= " Read more ";
      $story_op .= "</a>";
      $story_op .= "</div>";
      $story_op .= "</li>";
    }
    $story_op .= "</ul>";
    return $story_op;
  }
}

function find_all_comments_by_story_id($story_id){
  global $connection;
  $query = "SELECT * FROM comment where story_id={$story_id}";
  $comment_set = mysqli_query($connection,$query);
  check_query($comment_set);
  return $comment_set;
}

function comment($story_id,$comment_user_name){
  $comment_set = find_all_comments_by_story_id($story_id);
  $cmnt = "<ul>";
  while ($comment = mysqli_fetch_assoc($comment_set)) {
    $user = find_user_by_user_id($comment['user_id']);
    $cmnt .= "<li>";
    $cmnt .= "<div class=\"container\" style=\"border-left:2px solid #d3d3d3;\">";
    $cmnt .= "<a class=\"media-left\" href=\"profile.php?user=$user[username]&username=$comment_user_name \"><img class=\"blogger-img \" src=\"upload/{$user['user_id']}.jpg\" ></img><br>{$user['username']}</a>";
    $cmnt .= "<div class=\"media-body\" style=\"background-color:#dff0d8;border:1px solid #d3d3d3;\">";
    $cmnt .= nl2br($comment['comment']);
    $cmnt .= "<br><h6>". $comment['comment_date'] ."</h6>";
    $cmnt .= "</div></div>";
    $cmnt .= "</li>";

  }if ($cmnt) {
    return $cmnt;
  }
}

function generate_salt($length){
  $unique_random_string = md5(uniqid(mt_rand(), true));
  $base64_string =base64_encode($unique_random_string);
  $modified_base64_string = str_replace('+', '.', $base64_string);
  $salt = substr($modified_base64_string, 0 ,$length);
  return $salt;

}

function password_encrypt($password){
    $hash_format = "$2y$10$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $salt = "123422charactersormore";
    $format_and_salt = $hash_format . $salt;
    $hash = crypt($password, $format_and_salt);
    return $hash;
}

function password_check($password,$existing_hash){
  $hash = crypt($password, $existing_hash);
  if ($hash === $existing_hash) {
    return true;
  }else {
    return false;
  }
}

function attempt_login($username,$password){
  $user = find_user_by_username($username);
  if ($user) {
    //check password for user
    if (password_check($password,$user['password'])) {
      return $user;
    }else {
      return false;
    }

  }else {
    return false;
  }
}

function logged_in(){
  return isset($_SESSION['username']);
}

function confirm_logged_in(){
  if (!logged_in()) {
    redirect_to('login.php');
  }
}

?>