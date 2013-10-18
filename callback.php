 <script src="js/zepto.js"></script>
 <script src="js/douban.js"></script>
 <script>
	var test = window.location.hash.replace('#access_token=', '');
	var token = test.split('&')[0];
	// console.log(token);
	var db = localStorage;
	db.db_token = token;
	var douban = new DOUBAN();

	douban.user.getCurrent(function(info){
		db.userInfo = JSON.stringify(info);
		window.location.href = 'token.php?token=' + token;
	});
 </script>