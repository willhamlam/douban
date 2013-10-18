<?php include('header.tpl'); ?>
<?php if(!isset($_POST['keyword']) || $_POST['keyword'] == ''){ 

	header("Location:index.php");

} ?>
<body data-keyword="<?php echo $_POST['keyword'];?>">
	<header class="search-list">
		<?php include('form.php'); ?>
	</header>
	<div class="main">
		<ul class="s-books-list">
			
		</ul>
	</div>
	<script  id="book" type="text/html">
		<% for(i=0; i < books.length; i++) {%>
			<li>
				<a href="book.php?id=<%= books[i]['id'] %>">
					<img class="bookcover" src="<%= books[i]['images']['small'] %>" alt="<%= books[i]['alt']%>">
					<div class="bookinfo">
						<span class="bookname"><%= books[i]['title']%></span>
						<p class="bookauthor"><%= books[i]['author'][0]%></p>
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
				var user;
				var renderBook = function(data){
					console.log(data);
					var html = template.render('book', data);
					$('.s-books-list').append(html);
				}

				var douban = new DOUBAN();
				douban.book.search({
					q: $('body').data('keyword'),
					count: 20,
					callback: function(result){
						renderBook(result);
					}
				})
			});

		})(window, Zepto, DOUBAN);
	</script>
	<?php include('footer.tpl'); ?>