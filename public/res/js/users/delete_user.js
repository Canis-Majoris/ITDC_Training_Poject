$(function() {
	    $('.scroll').jscroll({
	        autoTrigger: true,
	        nextSelector: '.pagination li.active + li a', 
	        contentSelector: 'div.scroll',
	        loadingHtml: '<div class="loadimagediv"><img class="loadimage" src="http://i.imgur.com/vj7hM7b.gif"/></div>',
	        callback: function() {
	            $('ul.pagination:visible:first').hide();
	       }
	    });
	});