(function(exports, document, undefined){

	if(localStorage){
		var DB = function(){};

		DB.prototype = {
			get: function(key){
				return localStorage.getItem(key);
			},
			set: function(key, value){
				return localStorage.setItem(key, value);
			},
			delete: function(key){
				return void localStorage.removeItem(key);
			}
		};
	}

	exports.DB = DB;

})(window, document, undefined);

(function(window, document, undefined){

	$ = window.jQuery || window.Zepto || undefined;
	var DOUBAN = window.DOUBAN || function(){};
	var db = window.db || new DB();

	DOUBAN.prototype = {
		url: {
			api: "https://api.douban.com/v2/"
		},
		api: function(url, callback, data, type, tokenUrl){
			if(!type) type = 'GET';
			var param = {
				action: 'db_action',
				type  : type,
				url   : tokenUrl || this.url.api + url,
				data  : data || {},
				token : db.get('db_token') || ''
			};
			console.log(param);
			$.ajax({
				type: 'POST',
				url: '../douban_webapp/lib/handle.php',
				data: param,
				dataType: 'json',
				success: function(res){
					callback(res);
				},
				error: function(err){console.log(err)}
			});

		},
		handleObj: function(obj, rid){
			if(rid) delete obj[rid];
			delete obj['callback'];
			return obj;
		}
	};
	
	var THIS = DOUBAN.prototype;
	
	THIS.user = {
		getByName: function(name, fn){
			THIS.api('user/'+name, fn);
		},
		getCurrent: function(fn){
			THIS.api('user/~me', fn)
		},
		search: function(obj){
			THIS.api('user?q='+obj.q+'&start='+obj.start+'&count='+obj.count, obj.callback);
		}
	};

	THIS.book = {
		getById: function(id, fn){
			THIS.api('book/'+id, fn);
		},
		getByIsbn: function(isbn, fn){
			THIS.api('book/'+isbn, fn);
		},
		search: function(obj){
			THIS.api('book/search?q='+obj.q+'&start='+obj.start+'&count='+obj.count, obj.callback);
		},
		topTag: function(bookId, fn){
			THIS.api('book/'+bookId+'/tags', fn);
		},
		addReview: function(obj){
			THIS.api('book/reviews', obj.callback, THIS.handleObj(obj), 'POST');
		},
		editReview: function(obj){
			THIS.api('book/review/'+obj.book, obj.callback, THIS.handleObj(obj, 'book'), 'PUT');
		},
		deleteReview: function(book, fn){
			THIS.api('book/review'+book, fn, {}, 'DELETE');
		},
		getTagsById: function(id, fn){
			THIS.api('book/user_tags/'+id, fn);
		},
		getTagsByName: function(name, fn){
			THIS.api('book/user/'+name+'/tags', fn);
		},
		getFavors: function(obj){
			THIS.api('book/user/'+obj.name+'/collections?count='+obj.count+'&status='+obj.status+'&start='+obj.start, obj.callback);
		},
		getRelation: function(id, fn){
			THIS.api('book/'+id+'/collection?', fn);
		},
		addFavor: function(obj){
			THIS.api('book/'+obj.id+'/collection', obj.callback, THIS.handleObj(obj, 'id'), 'POST');
		},
		editFavor: function(obj){
			THIS.api('book/'+obj.id+'/collection', obj.callback, THIS.handleObj(obj, 'id'), 'PUT');
		},
		deleteFavor: function(id, fn){
			THIS.api('book/'+id+'/collection', fn, {}, 'DELETE');
		}
	}

	window.DOUBAN = DOUBAN;

})(window, document, undefined);