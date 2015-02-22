
		$('homebutton').click(function(){
			$('div.all').hide();
		})

		$(function () {
		  $('#logout').tooltip({'title':'Sign Out', 'placement':'bottom'})
		})
	
		$(window).scroll(function(){
	       $("#navbar").css({"top": ($(window).scrollTop()) + "px"});
	        
	       if ($(window).scrollTop() > 105){
			    $(".fixedheader1").css({"top": ($(window).scrollTop()) -105 + "px"});
			} else {
	        $(".fixedheader1").css("top", "0px");
	    }
	    });

	    $('.users_skills_data').on("click", "form.delete_user", function(e){
			if(confirm("Do you really want to delete user?")){

			}else{
				e.preventDefault();
			}	
		});

	  	var url = window.location;
		// Will only work if string in href matches with location
		$('ul.nav a[href="'+ url +'"]').parent().addClass('active');

		// Will also work for relative and absolute hrefs
		$('ul.nav a').filter(function() {
		    return this.href == url;
		}).parent().addClass('active');
		
		$(function () {
		  $('[data-toggle="popover"]').popover()
		});