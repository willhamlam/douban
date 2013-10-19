<?php include('header.tpl'); ?>
<body data-cat="<?php echo $_GET['cat']; ?>">
	<header class="read search-list">
		<img src="img/read.png" alt="">
		<?php 
			$title = array(
				'reading' => "正在读的书",
				'read' => "已读的书",
				'wish' => "希望读的书"
			);
		 ?>
		<span><?php echo $title[$_GET['cat']]; ?></span>
		<?php include('form.php'); ?>
	</header>
	<div class="main">
		<img src="img/loader.gif" class="loader" height="16" width="16" alt="">
		<ul class="s-books-list">
		</ul>
	</div>
	<script  id="book" type="text/html">
		<% for(i=0; i < collections.length; i++) {%>
			<li>
				<a href="book.php?id=<%= collections[i]['book']['id'] %>">
					<img class="bookcover" src="<%= collections[i]['book']['images']['small'] %>" alt="<%= collections[i]['book']['alt']%>">
					<div class="bookinfo">
						<span class="bookname"><%= collections[i]['book']['title']%></span>
						<p class="bookauthor"><%= collections[i]['book']['author'][0]%></p>
					</div>
				</a>
			</li>
		<%}%>
	</script>
	<script src="js/zepto.js"></script>
	<script src="js/tpl.js"></script>
	<script src="js/douban.js"></script>
	<script>
		(function(window, $){

			$(function(){
				var renderBook = function(data){
					console.log(data.msg);
					if(data.msg && data.msg.indexOf('access_token_has_expired') !== -1 ){
						window.location.href = "logout.php";
						return false;
					}
					var html = template.render('book', data);
					$('.loader').hide();
					$('.s-books-list').append(html);
				}

				var douban = new DOUBAN();
				var userInfo = JSON.parse(window.localStorage.userInfo);
				// console.log()
				douban.book.getFavors({
					name: userInfo.uid,
					count: 20,
					status: $('body').data('cat'),
					callback: function(result){
						renderBook(result);
					}
				})
			});

		})(window, Zepto, DOUBAN);
	</script>
	<?php include('footer.tpl'); ?>