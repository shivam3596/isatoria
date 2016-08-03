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
<body>
		<ul class="navbar navbar-default navbar-fixed-top " role="navigation">
			<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand active" href="index.php">Isatoria</a>
			</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#content" >Categories</a></li>
				<li ><a href="https://w3chauhan.herokuapp.com">sudo su</a> </li>
			</ul>
				<form class="navbar-form navbar-right">
				<a href="signup.php"><button type="button" class="btn btn-primary">Signup</button></a>
        <a href="login.php"><button type="button" class="btn btn-success">Login</button></a>
				</form>
		</div>
			</div>
	</ul>
<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img class="cover" src="img/5.jpg"></img>
        <div class="carousel-caption"></div>
      </div>
      <div class="item ">
        <img class="cover" src="img/4.jpg"></img>
        <div class="carousel-caption"></div>
      </div>
      <div class="item ">
        <img class="cover" src="img/3.jpg"></img>
        <div class="carousel-caption"></div>
      </div>
    </div>
    </div>
  </div>
</div>
