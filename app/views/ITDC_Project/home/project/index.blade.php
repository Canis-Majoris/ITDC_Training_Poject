@extends('layouts.home')
@section('ragac')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif
<script type="text/javascript">
	///send request/receive response w/o page reload
	function sortBy(btn){
		var a = btn.split(".");
		var b = "";
		(a[1] == "ASC") ? b = "DESC" : b = "ASC";
		var c = a[0]+"."+b;
		//$(btn)[0].attr('id', c);
		document.getElementById(btn).id = c;
		var hr = new XMLHttpRequest();
		var url = "{{ URL::route('project-sort') }}";
		hr.open("POST", url, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		$('#loadWait').html('<img src="/loading/Preloader_4.gif" class="loading_project_image"/>');
		$('#loadWait').addClass('showWait');
		hr.onreadystatechange = function(){
			if (hr.readyState == 4 && hr.status == 200) {
				var result = JSON.parse(hr.responseText);
				$('#loadWait').html('');
				$('#loadWait').removeClass('showWait');
				stateChanged("load_projects_tbody", result);
			}
		}
		hr.send("sorter="+btn);
	}
///populate table with response
	function stateChanged(id,text){
	    document.getElementById(id).innerHTML = text; 
	}
</script>


<div class="fixedheader1">
	<h3>Projects</h3>
	<hr>
</div>
<div class="scroll">
	<div id="loadWait"></div>

	<table class="table table-hover table-stripped table-bordered projects_table" >
		<thead>
			<th width="40%"><a class="sortbtn1", id="name.ASC" onClick="sortBy(this.id)">Project Name <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
			<th width="5%"><a class="sortbtn1", id="bid_count.ASC" onClick="sortBy(this.id)">Bids <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
			<th width="25%"><div class="sortbtn1">Skills</div></th>
			<th width="17%"><a class="sortbtn1", id="created_at.DESC" onClick="sortBy(this.id)">Started <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
			<th width="13%" align="center"><a class="sortbtn1", id="salary.ASC" onClick="sortBy(this.id)">Price <span class="glyphicon glyphicon-sort project_sort_gly"></span></a></th>
		</thead>
		<tbody id="load_projects_tbody">
			<!-- load conten here -->
		</tvody>
</table>
		
</div>
<a href="#" class="scrollToTop"></a>

<script type="text/javascript">

/// initial sorting by cretaion time (desc)
	window.onload = function(){
		var jump = 'created_at.DESC';
		sortBy(jump);
	}
/// show description on hover
	$('#load_projects_tbody').on({
		mouseenter: function () {
		    $(this).find('div').removeClass('hide_1');
		},
		mouseleave: function () {
		    $(this).find('div').addClass('hide_1');
		}
	}, '[id^=show_project_inline_]');
	
</script>
@stop
