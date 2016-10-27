function initCreateProjectPage() {
	show(1);
	$( "#project_startdate" ).datepicker( $.datepicker.regional[ "no" ] );
	$( "#project_enddate" ).datepicker( $.datepicker.regional[ "no" ] );
	$("#project_actors").select2({width: '25vw'});
}

function updatePageButtons(page){
	document.getElementById('page1').style.backgroundColor = "lightGrey";
	document.getElementById('page2').style.backgroundColor = "lightGrey";
	document.getElementById('page3').style.backgroundColor = "lightGrey";
	document.getElementById('page4').style.backgroundColor = "lightGrey";
	document.getElementById('page'+page).style.backgroundColor = "lightGreen";
}

var pageNumber = null;

function show(page) {
	if(parseInt(page)){
		pageNumber = page;
		updatePageButtons(pageNumber);
	}
	

	arr = ["name","field","images","startdate","enddate","description","soilConditions",
			"totalArea","cost","areaType","projectType","technicalSolutions","location",
			"actors","measures","captcha","save"]

	for (var i = 0; i < arr.length-1; i++) {
		document.getElementById(arr[i]+"_label").style.display = "none";
		document.getElementById("project_"+arr[i]).style.display = "none";
	}
	document.getElementById('project_save').style.display = "none";
	document.getElementsByClassName("captcha_image")[0].style.display = "none";

	var selectSpan = document.getElementsByClassName("selection")[0];
	if(selectSpan) { //The selection span is not defined on load
		document.getElementsByClassName("selection")[0].style.display = "none";
	}

	if(page === 1){
		displayBlock(["name","startdate","enddate","location","actors",
						"areaType","projectType","cost","totalArea"])
		if(selectSpan) {
			document.getElementsByClassName("selection")[0].style.display = "block";
		}	

		document.getElementById('next').disabled = false;
		document.getElementById('previous').disabled = true;
	}
	if(page === 2){
		//background,summary
		displayBlock(["images"]);

		document.getElementById('next').disabled = false;
		document.getElementById('previous').disabled = false;
	}

	if(page === 3){
		displayBlock(["measures"]);
		document.getElementById('next').disabled = false;
		document.getElementById('previous').disabled = false;
	}

	if(page === 4){
		displayBlock(["field","description","soilConditions","technicalSolutions","captcha"]);
		document.getElementsByClassName("captcha_image")[0].style.display = "block";
		document.getElementById('project_save').style.display = "block";

		document.getElementById('next').disabled = true;
		document.getElementById('previous').disabled = false;
	}

	if(page === "next" && pageNumber !== 4){
		pageNumber += 1;
		if(pageNumber === 4) {
			document.getElementById(page).disabled = true;
		}
		document.getElementById('previous').disabled = false;
		show(pageNumber)
		
	}
	if(page === "previous" && pageNumber !== 1){
		pageNumber -= 1;
		if(pageNumber === 1) {
			document.getElementById(page).disabled = true;
		}
		document.getElementById('next').disabled = false;
		show(pageNumber)
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