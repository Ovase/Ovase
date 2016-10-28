function initCreateProjectPage() {
	$( "#project_startdate" ).datepicker( $.datepicker.regional[ "no" ] );
	$( "#project_enddate" ).datepicker( $.datepicker.regional[ "no" ] );
	$("#project_actors").select2({width: '25vw'});

	show(1);
}

function updatePageButtons(page){
	document.getElementById('page1').style.backgroundColor = "white";
	document.getElementById('page2').style.backgroundColor = "white";
	document.getElementById('page3').style.backgroundColor = "white";
	document.getElementById('page'+page).style.backgroundColor = "lightGreen";
}

var pageNumber = null;
var lastPage = 3;

function show(page) {
	if(parseInt(page)){
		pageNumber = page;
		updatePageButtons(pageNumber);
	}

	arr = ["name","images","startdate","enddate","description","soilConditions",
			"totalArea","cost","areaType","projectType","technicalSolutions","location",
			"actors","captcha","imageFiles","summary","waterArea","dimentionalDemands"]

	for (var i = 0; i < arr.length; i++) {
		if(!document.getElementById(arr[i]+"_label")){
			console.log(arr[i])
		}
		document.getElementById(arr[i]+"_label").style.display = "none";
		document.getElementById("project_"+arr[i]).style.display = "none";
	}
	document.getElementById('project_save').style.display = "none";
	document.getElementsByClassName("captcha_image")[0].style.display = "none";
	
	var showImages = document.getElementById('showImages');
	if(showImages) {
		showImages.style.display = "none";
	}


	var selectSpan = document.getElementsByClassName("selection")[0];
	if(selectSpan) { //The selection span is not defined on load
		document.getElementsByClassName("selection")[0].style.display = "none";
	}

	if(page === 1){
		displayBlock(["name","startdate","enddate","location","actors","cost","totalArea","waterArea"])
		if(selectSpan) {
			document.getElementsByClassName("selection")[0].style.display = "block";
		}	

		document.getElementById('next').disabled = false;
		document.getElementById('previous').disabled = true;
	}
	if(page === 2){
		//background,summary
		displayBlock(["areaType","projectType","description",
					  "dimentionalDemands","soilConditions","technicalSolutions"]);

		document.getElementById('next').disabled = false;
		document.getElementById('previous').disabled = false;
	}

	if(page === lastPage){
		if(showImages) {
			document.getElementById('showImages').style.display = "inline";
		}
		
		displayBlock(["captcha","imageFiles","summary"]);
		document.getElementsByClassName("captcha_image")[0].style.display = "block";
		document.getElementById('project_save').style.display = "block";

		document.getElementById('next').disabled = true;
		document.getElementById('previous').disabled = false;
	}

	if(page === "next" && pageNumber !== lastPage){
		pageNumber += 1;
		if(pageNumber === lastPage) {
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