jQuery(function($){
	var page = 0;
	var loading = true;
	var loaderImg = loadMoreJS.pluginsUrl + "/webbiz-loadmore/img/loading.gif";
	var $window = $(window);
	var $content = $('body.blog #content, body.archive #content');
	var load_posts = function(){
	      $.ajax({
	          type       : "GET",
	          dataType   : "html",
	          url:  loadMoreJS.ajaxurl,
	          data       : {
	          	action: 'wb_load_more',
	          	numPosts : 2, 
	          	pageNumber: page
	          },
	          beforeSend : function(){
	              if(page != 1){
	                  $content.append('<div id="temp_load" style="text-align:center" class="animated fadeIn"><img src=" '+loaderImg+' " /></div>');
	              }
	          },
	          success    : function(data){
	              $data = $(data);
	              $("#more_posts").attr("disabled", false);
	              if($data.length){
	                  $data.hide();
	                  $content.append($data);
	                  $("#temp_load").remove();
	                  $data.fadeIn(400, function(){
	                      loading = false;
	                  });
	              } else {
	                  $("#temp_load").hide(500);
	              }
	          },
	          error     : function(jqXHR, textStatus, errorThrown) {
	              $("#temp_load").hide(500);
	              alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	          }
	  });
	}
	/**
	* Scroll Load Posts
	*/
	$window.scroll(function() {

		var content_offset = $content.offset();
		// console.log( 'WINDOW: ' + ( $window.scrollTop() + $window.height() ) + ' CONTENT: ' + ($content.scrollTop() + $content.height() + content_offset.top ));

		if (	!loading && ( $window.scrollTop() + $window.height() ) > ( $content.scrollTop() + $content.height() + content_offset.top ) ) {
			loading = true;
			page++;
			load_posts();
		}

	});

	/**
	* Initial Load posts
	*/
	load_posts();














});