<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search-List</title>
	<link rel="stylesheet" href="css/style.css">
	<meta name="viewport" content="initial-scale=1">
</head>
<body data-id="<?php echo $_GET['id']; ?>">
	<header class="search-list">
		<?php include('form.php'); ?>
	</header>
	<div class="main">
		
	</div>
	<script  id="book" type="text/html">
		<div class="book-main">
			<img class="bookcover" src="<%= book['image'] %>" alt="">
			<div class="bookinfo">
				<span class="bookname"><%= book['title'] %></span>
				<p class="bookauthor"><%= book['author'][0] %></p>
				<div class="read-btns">
					<a class="btn read-btn toread" href="">想读</a>
					<a class="btn read-btn reading" href="">在读</a>
					<a class="btn read-btn read" href="">已读</a>
				</div>
			</div>
		</div>
		<div class="book-des">
			<div class="title">内容简介</div>
			<p class="describe"><%= book['summary'] %></p>
		</div>
		<div class="book-content">
			<div class="title">目录</div>
			<ul class="contents">
				<%= book['catalog'] %>
			</ul>
		</div>
	</script>
	<script src="js/zepto.js"></script>
	<script src="js/tpl.js"></script>
	<script src="js/douban.js"></script>
	<script>
		(function(window, $){

			$(function(){
				var user;
				var renderBook = function(data){
					var html = template.render('book', {book:data});
					$('.main').append(html);
				}

				var douban = new DOUBAN();

				douban.user.getCurrent(function(info){
					user = info;
				});
				douban.book.getById($('body').data('id'), function(book){
					console.log(book);
					renderBook(book);
				});
			});

		})(window, Zepto, DOUBAN);
	</script>
	<?php include('footer.tpl'); ?>
</body>
</html>