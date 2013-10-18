<?php 

session_start();

$_SESSION['login'] = true;

 ?>

<script>
	window.location.href = "index.php";
</script>