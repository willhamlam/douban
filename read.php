<?php include('header.tpl'); ?>
<body data-cat="<?php echo $_GET['cat']; ?>">
	<header class="read">
		<img src="img/read.png" alt="">
		<span>我读过的书</span>
	</header>
	<div class="main">
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
					console.log(data);
					var html = template.render('book', data);
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