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
				<li ><a href="https://w3chauhan.herokuapp.com">sudo su</a> </li>
			</ul>
				<form class="navbar-form navbar-right">
				</form>
		</div>
			</div>
	</ul>
