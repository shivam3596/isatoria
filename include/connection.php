<?php
  // 1- create a database connection
  define("DB_SERVER","server38.000webhost.com");
  define("DB_USER","a9829148_root");
  define("DB_PASSWORD","*************");
  define("DB_NAME","a9829148_isatori");
  $connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);

  // check databse connection
  if (mysqli_connect_errno()) {
    die("connection failed ". mysqli_connect_error() . mysqli_connect_errno());
  }else {
    echo "";
  }
?>
