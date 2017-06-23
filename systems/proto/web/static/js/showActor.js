/* Remembers what type of actor was last viewed */

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
        setCookie("actor", "person", 100);
    }
}

function show(id) { 
	 document.getElementById("person-list").style.display = "none";
	 document.getElementById("company-list").style.display = "none";

     document.getElementById("person-button").style.removeProperty('background-color');
     document.getElementById("company-button").style.removeProperty('background-color');

	 document.getElementById(id + "-list").style.display = "block";
     document.getElementById(id + "-button").style.backgroundColor = "#136F63";

	 setCookie("actor", id, 100);
}

