	<footer>
		<ul class="footer-nav hide logined">
			<li><a href="read.php?cat=wish">想读</a></li>
			<li><a href="read.php?cat=reading">在读</a></li>
			<li><a href="read.php?cat=read">已读</a></li>
		</ul>
		<ul class="footer-nav hide notLogin">
			<li><a href=""></a></li>
			<li><a href="" class="login-btn">登陆</a></li>
			<li><a href=""></a></li>
		</ul>
	</footer>
	<script>
		(function(window, $){
			$(function(){
				var db = window.localStorage;
				var loginUrl;

				if(window.location.host == "localhost"){
					loginUrl = "https://www.douban.com/service/auth2/auth?client_id=01c6485c1e6e80b30552d9145b4b8219&client_secret=ab455a25196154fa&redirect_uri=http://localhost/xampp/bonstu/douban/callback.php&response_type=token&scope=douban_basic_common,book_basic_r,book_basic_w";
				}else{
					loginUrl = "https://www.douban.com/service/auth2/auth?client_id=01c6485c1e6e80b30552d9145b4b8219&client_secret=ab455a25196154fa&redirect_uri=http://203.195.182.36/bonstu/project/douban/callback.php&response_type=token&scope=douban_basic_common,book_basic_r,book_basic_w"
				}

				$('.login-btn').attr('href', loginUrl);
				console.log(db.login);
				if(db.login){ $('.logined').show(); }else{ $('.notLogin').show(); }
			});
		})(window, Zepto);
	</script>
</body>
</html>