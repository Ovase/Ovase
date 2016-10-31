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

function deleteImage(event, index, url) {
	$(event.target).remove();
	$('#project_images_' + index).remove();
	$('img[src="' + url + '"]').remove();
}

function show(page) {
	if(parseInt(page)){
		pageNumber = page;
		updatePageButtons(pageNumber);
	}

	arr = ["name","images","startdate","enddate","description","soilConditions",
			"totalArea","cost","areaType","projectType","technicalSolutions","location",
			"actors","captcha","imageFiles","summary","waterArea","dimentionalDemands",
			"save"]

	for (var i = 0; i < arr.length; i++) {
		var input = document.getElementById("project_"+arr[i]);

		if(!input){
			console.log("Missing: "+arr[i]);
		}

		input.parentNode.setAttribute('id',arr[i]+'Div');
		document.getElementById(arr[i]+"Div").style.display = "none";
	}

	var showImages = document.getElementById('showImages');
	if(showImages) {
		showImages.style.display = "none";
	}

	var nextBtn = document.getElementById('next');
	var previousBtn = document.getElementById('previous');

	if(page === 1){
		displayBlock(["name","startdate","enddate","location","actors","cost","totalArea","waterArea"])

		nextBtn.disabled = false;
		previousBtn.disabled = true;
	}
	if(page === 2){
		displayBlock(["areaType","projectType","description",
					  "dimentionalDemands","soilConditions","technicalSolutions"]);

		nextBtn.disabled = false;
		previousBtn.disabled = false;
	}

	if(page === lastPage){
		if(showImages) {
			document.getElementById('showImages').style.display = "inline";
		}

		displayBlock(["captcha","imageFiles","summary","save"]);
		nextBtn.disabled = true;
		previousBtn.disabled = false;
	}

	if(page === "next" && pageNumber !== lastPage){
		pageNumber += 1;
		if(pageNumber === lastPage) {
			document.getElementById(page).disabled = true;
		}
		previousBtn.disabled = false;
		show(pageNumber)

	}
	if(page === "previous" && pageNumber !== 1){
		pageNumber -= 1;
		if(pageNumber === 1) {
			document.getElementById(page).disabled = true;
		}
		nextBtn.disabled = false;
		show(pageNumber)
	}
}

function displayBlock(idArray){
	for (var i = 0; i < idArray.length; i++) {
		document.getElementById(idArray[i]+"Div").style.display = "block";
	}
}

// Disable enddate picker's dates (before startdate)
function disableDates() {
	$("#project_enddate").datepicker("option","minDate",$("#project_startdate").datepicker("getDate"));
}