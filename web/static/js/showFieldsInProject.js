function initCreateProjectPage() {
	show(1);
	$( "#project_startdate" ).datepicker( $.datepicker.regional[ "no" ] );
	$( "#project_enddate" ).datepicker( $.datepicker.regional[ "no" ] );
	$("#project_actors").select2({width: '25vw'});


}

function show(page) {

	arr = ["name","field","images","startdate","enddate","description","soilConditions",
			"totalArea","cost","areaType","projectType","technicalSolutions","location",
			"actors","measures","captcha","save"]

	for (var i = 0; i < arr.length-1; i++) {
		document.getElementById(arr[i]+"_label").style.display = "none";
		document.getElementById("project_"+arr[i]).style.display = "none";
	}
	document.getElementById('project_save').style.display = "none";
	document.getElementsByClassName("captcha_image")[0].style.display = "none";

	if(page === 1){
		displayBlock(["name","startdate","enddate","location","actors",
						"areaType","projectType","cost","totalArea"])
	}
	if(page === 2){
		//background,summary
		displayBlock(["images"]);
	}

	if(page === 3){
		displayBlock(["measures"]);
	}

	if(page === 4){
		displayBlock(["field","description","soilConditions","technicalSolutions","captcha"]);
		document.getElementsByClassName("captcha_image")[0].style.display = "block";
		document.getElementById('project_save').style.display = "block";

	}

}

function displayBlock(idArray){
	for (var i = 0; i < idArray.length; i++) {
		idArray[i]
		document.getElementById(idArray[i]+"_label").style.display = "block";
		document.getElementById("project_"+idArray[i]).style.display = "block";
	}
}

function disableDates() {
	$("#project_enddate").datepicker("option","minDate",$("#project_startdate").datepicker("getDate"));
}