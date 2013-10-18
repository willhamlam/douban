	<footer>
		<?php 
			session_start();
			if(isset($_SESSION['login'])){
				?>
				<ul class="footer-nav">
					<li><a href="read.php?cat=wish">想读</a></li>
					<li><a href="read.php?cat=reading">在读</a></li>
					<li><a href="read.php?cat=read">已读</a></li>
				</ul>
				<?php
			}else{
				?>
				<ul class="footer-nav">
					<li><a href=""></a></li>
					<li><a href="https://www.douban.com/service/auth2/auth?client_id=01c6485c1e6e80b30552d9145b4b8219&client_secret=ab455a25196154fa&redirect_uri=http://localhost/xampp/bonstu/douban/callback.php&response_type=token&scope=douban_basic_common,book_basic_r,book_basic_w">登陆</a></li>
					<li><a href=""></a></li>
				</ul>
				<?php
			}
		 ?>
		
	</footer>
</body>
</html>