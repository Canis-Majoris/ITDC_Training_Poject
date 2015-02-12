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
		hr.onreadystatechange = function(){
			if (hr.readyState == 4 && hr.status == 200) {
				var result = JSON.parse(hr.responseText);
				//$('#loadWait').html('');
				stateChanged("load_projects_tbody", result);
			}else{
				//$('#loadWait').html('Please Wait...');
			}

		}
		hr.send("sorter="+btn);
	}
///populate table with response
	function stateChanged(id,text){
	    document.getElementById(id).innerHTML = text; 
	}