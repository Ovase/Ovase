function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var actor = getCookie("actor");
    if (actor!="") {
        show(actor)
    } else {
        setCookie("actor", "persons", 100);
    }
}

function show(id) { 
	 document.getElementById("persons").style.display="none";
	 document.getElementById("companies").style.display="none";

     document.getElementById("btn-persons").style.backgroundColor="white";
     document.getElementById("btn-companies").style.backgroundColor="white";

	 document.getElementById(id).style.display="block";
     document.getElementById("btn-"+id).style.backgroundColor="lightGreen";

	 setCookie("actor", id, 100);
}

