function add(type, arg){
	var element=document.createElement("input");
	element.setAttribute("type",type);
	element.setAttribute("class","form-control phoneinput");
	element.setAttribute("name",arg);
	var foo=document.getElementById("fooBar");
	foo.appendChild(element);
}