<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search-List</title>
	<link rel="stylesheet" href="css/style.css">
	<meta name="viewport" content="initial-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

</head>
<body data-id="<?php echo $_GET['id']; ?>">
	<header class="search-list">
		<?php include('form.php'); ?>
	</header>
	<div class="main">
		
	</div>
	<script  id="book" type="text/html">
		<div class="book-main" data-id="<%= book['id'] %>" data-relation=" <% if (!book['current_user_collection']) {%>0<%}else{%>1<%}%>">
			<img class="bookcover" src="<%= book['image'] %>" alt="">
			<div class="bookinfo">
				<span class="bookname"><%= book['title'] %></span>
				<p class="bookauthor"><%= book['author'][0] %></p>
				<div class="read-btns">
					<a class="btn read-btn toread <% if (book['current_user_collection'] && book['current_user_collection']['status'] == 'wish') {%>disabled<%}%>" data-status="wish" href="">想读</a>
					<a class="btn read-btn reading  <% if (book['current_user_collection'] && book['current_user_collection']['status'] == 'reading') {%>disabled<%}%>" href="" data-status="reading">在读</a>
					<a class="btn read-btn read  <% if (book['current_user_collection'] && book['current_user_collection']['status'] == 'read') {%>disabled<%}%>" href="" data-status="read">已读</a>
					<% if (book['current_user_collection']) {%>
						<a class="btn read-btn delete"  href="">删除</a>
					<%}%>

				</div>
			</div>
		</div>
		<div class="book-des">
			<div class="title">内容简介</div>
			<p class="describe"><%= book['summary'] %></p>
		</div>
		<div class="book-content">
			<div class="title">目录</div>
			<pre class="contents ">
				<%= book['catalog'] %>
			</pre>
		</div>
	</script>
	<script src="js/zepto.js"></script>
	<script src="js/tpl.js"></script>
	<script src="js/douban.js"></script>
	<script>
		(function(window, $){

			$(function(){
				$('body').on('click', '.disabled', function(e){
					e.preventDefault();
				});

				var user;
				var renderBook = function(data){
					if(data.msg && data.msg == 'access_token_has_expired'){
						window.location.href = "logout.php";
					}
					data.catalog = $.trim(data.catalog);
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

				$('body').on('click', '.read-btn', function(e){
					e.preventDefault();
					if($(this).hasClass('delete')){
						douban.book.deleteFavor($('body').find('.book-main').data('id'), function(result){
							console.log(result);
							window.location.reload();
						});
					}
					var status = $(this).data('status');
					if(!$('.book-main').data('relation')){
						douban.book.addFavor({
							id: $('body').find('.book-main').data('id'),
							status: status,
							callback: function(result){
								console.log(result);
								window.location.reload();
							}
						});
					}else{
						douban.book.editFavor({
							id: $('body').find('.book-main').data('id'),
							status: status,
							callback: function(result){
								console.log(result);
								window.location.reload();
							}
						});
					}

					$('body').on('click', '.book-content .title', function(){
						console.log('hello');
						$('.contents').show();
					});

				});

			});

		})(window, Zepto, DOUBAN);
	</script>
	<?php include('footer.tpl'); ?>
</body>
</html>