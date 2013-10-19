<?php 

session_start();
unset($_SESSION['login']);

 ?>

 <script>
 	window.localStorage.removeItem('login');
 	window.localStorage.removeItem('db_token');
 	window.location.href = "index.php";
 </script>