<?php
  if (!isset($layout_context)) {
    $layout_context = "isatoria";
  }
?>
<!doctype.html>
<html>
<head>
	<title><?php  echo $layout_context ; ?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<!--body start from here-->
<body>
		<!-- navigation bar start-->

		<ul class="navbar navbar-default navbar-fixed-top " role="navigation">
			<div class="container-fluid">
			<!--toggle menu-->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand active"  href="index.php?user=<?php echo urlencode($username)?>">Isatoria</a>
			</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			</ul>
      <form class="navbar-form navbar-right">
        <?php $user = find_user_by_username($username); ?>
        <?php
          if ($user) { ?>
            <a href="profile.php?user=<?php echo urlencode($user['username']). "&username=". urlencode($user['username']);?>"><?php echo htmlentities($user['username']) ;?></a>&nbsp;
            <a href="logout.php"><button type="button" class="btn btn-success">Logout</button></a>
          <?php
        }else { ?>
          <a href="signup.php"><button type="button" class="btn btn-primary">Signup</button></a>
          <a href="login.php"><button type="button" class="btn btn-success">Login</button></a>
      <?php }?>
      </form>
		</div>
			</div>
	</ul>
