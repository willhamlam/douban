<?php 

session_start();
unset($_SESSION['login']);

 ?>

 <script>
 	window.localstorage = {};
 	window.location.href = "index.php";
 </script>