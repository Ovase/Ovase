function fixParentDivs () {

	arr = ["title","totalArea","costs","technicalFunctions","elaboration",
			"dimentionalDemands","additionalValues","geometricDesignElaboration",
			"constructionDetails","maintenance","experiencesGained"];

	for (var i = 0; i < arr.length; i++) {
		var input = document.getElementById("measure_"+arr[i]);
		
		if(!input){
			console.log("Missing: "+arr[i]);
		}

		input.parentNode.setAttribute('id',arr[i]+'Div');
	}

	addHelpText(arr);
}

	
function showHelpMsg(id) {
	var helpSpan = document.getElementById('help_'+id);

	if(helpSpan.style.display === "none"){
		helpSpan.style.display = "block";
	}
	else {
		helpSpan.style.display = "none";
	}
}

function addHelpText(ids) {

	for (var i = 0; i < ids.length; i++) {
		var element = document.getElementById('measure_'+ids[i]);
		if(element.getAttribute("help")) {
			var helpMsg = document.createElement('Span');
			var parentDiv = document.getElementById(ids[i]+'Div');
			helpMsg.setAttribute('class', 'help-block');
			helpMsg.setAttribute('id','help_'+ids[i])
			helpMsg.innerHTML = element.getAttribute("help");
			helpMsg.style.display = "none";
			parentDiv.appendChild(helpMsg);
			parentDiv.appendChild(document.createElement('BR'));

			var helpBtn = document.createElement('Button');
			helpBtn.setAttribute('class','btn btn-circle btn-primary btn-raised help-btn');
			helpBtn.type = "button";
			helpBtn.innerHTML = '?';
			helpBtn.setAttribute('onclick','showHelpMsg("'+ids[i]+'")');
			parentDiv.insertBefore(helpBtn, element);
			parentDiv.appendChild(document.createElement('BR'));
		}
	}
}
