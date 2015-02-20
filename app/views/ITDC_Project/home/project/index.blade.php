@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
<script type="text/javascript">
	var current_page = 0;
	var sorter = null;
</script>

<div class="fixedheader1">
	<h3>Projects</h3>
	<hr>
</div>
<div class="" id="sorting_options">
	<div id="sort_timespan" class="form-group form-inline">
		<label for="s1">Duration:</label>
		<select id="s1" onchange="sortBy(this);" class="form-control">
			<!-- select options -->
		</select>
	</div>
</div>
<div class="scroll">
	<div id="loadWait"></div>

	<table class="table table-hover table-stripped table-bordered projects_table_sorted" >
		<thead>
			<th width="40%"><a class="sortbtn1", id="btn.name.ASC" onClick="sortBy(this.id)">Project Name <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
			<th width="5%"><a class="sortbtn1", id="btn.bid_count.ASC" onClick="sortBy(this.id)">Bids <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
			<th width="25%"><div class="sortbtn1">Skills</div></th>
			<th width="17%"><a class="sortbtn1", id="btn.created_at.DESC" onClick="sortBy(this.id)">Started <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
			<th width="13%" align="center"><a class="sortbtn1", id="btn.salary.ASC" onClick="sortBy(this.id)">Price <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
		</thead>
		<tbody id="load_projects_tbody">
			<!-- load conten here -->
		</tvody>
	</table>
</div>

<div class="pager">
	<button id="load-more-photos" class="btn btn-block btn-sm btn-primary">Load More <span class="glyphicon glyphicon-chevron-down"></span></button>
</div>

<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

	$(function () {
	  $('.skill_level_tooltip').tooltip({placement: 'bottom', html: true, trigger: 'hover focus'})
	});
/// show description on hover
	$('#load_projects_tbody').on({
		mouseenter: function () {
		    $(this).find('div').removeClass('hide_1');
		},
		mouseleave: function () {
		    $(this).find('div').addClass('hide_1');
		}
	}, '[id^=show_project_inline_]');

////////////////////////////////////////////////////////////////////////////////////////////////////////
	function fillSorter(timespan, sorter){
		
		$('select#s1 option').remove();
        $.each(timespan, function(index, item){
            $('select#s1').append('<option value="s.'+item+'">'+item+'</option>"');
        });
        if (sorter !== null) {
        	var a = sorter.split(".");
	        if (a[0] == 's') {
        		//console.log(sorter);
	       	 	$("select#s1").val(sorter);
	        };
        };
	}

	// Sorting Projects
	function sortBy(arg){
		var c = "";
		if (typeof arg.value !== 'undefined') {
			//console.log(arg.value[0]);
			var a = arg.value.split(".");
			if (a[0] === 's') {
				c = a[0]+'.'+a[1];
			};
		}else{
			var a = arg.split(".");
			//console.log(arg);
			if (a[0] == 'btn') {
				var b = "";
				(a[2] == "ASC") ? b = "DESC" : b = "ASC";
				c = a[0]+'.'+a[1]+"."+b;
				document.getElementById(arg).id = c;
			};
		}
		
		window.sorter = c;
		$('#load_projects_tbody').html('');
		window.current_page = 0;
		if(window.current_page != projects.last_page){
	        $('#load-more-photos').show();
	    }
		getProjects(function(projectObj){
	        displayProjects(projectObj);
	    });
	}
	// Projects Onload
	$(document).ready(function () {
	    getProjects(function(projectObj){
	        displayProjects(projectObj);
	    });
	});

	// Paginating Projects
	function getProjects(callback) {
		var newPage = window.current_page;
        newPage = window.current_page + 1
	    $.ajax({
	        type: "POST",
	        dataType: 'json',
	        url: "{{ URL::route('project-sort') }}",
	        data:{
	            'page': newPage,
	            'sorter': window.sorter
	        }
	    })
        .done(function( response ) {
	       // console.log(window.sorter);

            var projectObj =  response;
	    	projects = $.parseJSON(projectObj['projects']);
	    	timespan = projectObj['timespan'];
	    	sorter = projectObj['sorter'];

	    	fillSorter(timespan, sorter);

            window.current_page = projects.current_page;
            if(window.current_page == projects.last_page){
                $('#load-more-photos').hide();
            }
            callback(projectObj);
        })
        .fail(function( response ) {
            console.log( "Error: " + response );
        });
	}

	/**
	* @param projectObj
	*/
	function displayProjects(projectObj)
	{
	    var options = '';
	    
	    projects = $.parseJSON(projectObj['projects']);
        skills = projectObj['skills'];
	    $.each(projects.data, function(key, value){
    		var d = new Date(value.created_at);
    		var r = 0;
	    	var g = 0;
    		var b = 0;
    		var elapsed = Date.now() - d;
    		elapsed /= 60000;
    		if (elapsed > 87658){
    			r = 100;
    		}else{
    			r = (100*elapsed)/87658;
    		}
    		g = 100 - r;
    		if (value.active == 2) {
    			r = 0;
    			g = 0;
    			b = 100;
    		};
    		var id = value.id; 
			options = options + '<tr id="show_project_inline_" class="project_description" >' +
				'<td style="border-left: 5px solid rgba('+ r +'%, '+ g +'%, '+b+'%, 0.5) !important;">' +
					'<a href="http://localhost:8000/project/show/' + id + '">'+ value.name +'</a>' +
					'<div class="hide_1 hover_show_description">'+ value.description +'</div>' +
				'</td>' +
				'<td>'+ value.bid_count +'</td>' +
				'<td>';
				$.each(skills[id], function(k, v){
					options += '<span class="label label-default skill_level_tooltip" data-toggle="tooltip" title="minimum LVL <span>'+v.pivot.level+'</span>">'+v.name+'</span>';

				});
				options += '</td>' +
				'<td>'+ value.created_at +'<br>';
				if (value.active == 1) {
					options += '<p class="good">Active</p>';
				} else if(value.active == 0){
					options += '<p class="bad">Expired or Removed</p>';
				} else if(value.active == 2){
					options += '<p class="orange">Taken</p>';
				};
				options += '</td>' +
				'<td>'+ value.salary +' '+ value.currency +'</td>'+
			'</tr>';
	    });
	    $('#load_projects_tbody').append(options);
	}

	// listener to the [load more] button
	$('#load-more-photos').on('click', function(e){
	    e.preventDefault();

	    getProjects(function(projectsObj){
	        displayProjects(projectsObj);
	    }, sorter);

	});

</script>
@stop
