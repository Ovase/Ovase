/*
 * The user can enter an address, but we would rather like the coordinates
 *
 * We use this API:
 *      http://ws.geonorge.no/adresse/dok/AdresseWS_sok.html#enkelt adressesøk
 */

var ADDR_ENDPOINT = 'http://ws.geonorge.no/AdresseWS/adresse/sok?sokestreng='
function queryAndSetAddressCoordinates(addrString) {
    queryString = ADDR_ENDPOINT + addrString;
    $.ajax({
        url: queryString,
        type: 'GET',
        async: false,
        success: function(res) {
            processQueryResult(res);
        },
        error: function(res) {
            console.log("ERROR");
            console.log(res);
        }
    });
}

// Assume the first result is the best
function processQueryResult(res) {
    if (res.sokStatus.ok !== "true") {
        console.log("Error from address API: " + res.sokStatus.melding);
    }
    prettyAddr = 
        res.adresser[0].adressenavn + ' ' +
        res.adresser[0].husnr;
    if (res.adresser[0].bokstav != null) {
        prettyAddr += res.adresser[0].bokstav;
    }
    prettyAddr += ', ' +
        res.adresser[0].postnr + ' ' +
        res.adresser[0].poststed;

    console.log("Found: " + prettyAddr);
    console.log("lat:" + res.adresser[0].nord);
    console.log("long:" + res.adresser[0].aust);
    // The actual work
    document.getElementById("project_coordLat").value = parseFloat(res.adresser[0].nord);
    document.getElementById("project_coordLong").value = parseFloat(res.adresser[0].aust);
    // document.getElementById("project_coordLat").value = res.adresser[0].nord.substring(0, 10);
    // document.getElementById("project_coordLong").value = res.adresser[0].aust.substring(0, 10);
    // document.getElementById("project_coordLat").value = "a";
    // document.getElementById("project_coordLong").value = "a";
}

function prepareAddressTranslator() {
    $('form[name="project"]').submit(function(event) {
        addrString = document.getElementById("project_location").value;
        queryAndSetAddressCoordinates(addrString);
        return true;
    });
}