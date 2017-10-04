/*
 * The user can enter an address, but we would rather like the coordinates
 *
 * We use this API:
 *      http://ws.geonorge.no/adresse/dok/AdresseWS_sok.html#enkelt adressesøk
 */

var ADDR_ENDPOINT = 'http://ws.geonorge.no/AdresseWS/adresse/sok?sokestreng='
function queryAndSetAddressCoordinates(addrString, formName) {
    queryString = ADDR_ENDPOINT + addrString;
    $.ajax({
        url: queryString,
        type: 'GET',
        async: false,
        success: function(response) {
            processQueryResult({
                result: response,
                formName: formName
            });
        },
        error: function(res) {
            console.log("ERROR");
            console.log(res);
        }
    });
}

// Assume the first result is the best
function processQueryResult(data) {
    var res = data.result;
    if (res.sokStatus.ok !== "true") {
        console.log("Error from address API: " + res.sokStatus.melding);
    }
    console.log("lat:" + res.adresser[0].nord);
    console.log("long:" + res.adresser[0].aust);
    // The actual work
    document.getElementById(data.formName + "_coordLat").value = parseFloat(res.adresser[0].nord);
    document.getElementById(data.formName + "_coordLong").value = parseFloat(res.adresser[0].aust);
}

function prepareAddressTranslator(formName, addrFieldSelector) {
    // Update hidden fields before submitting form
    $('form[name="' + formName + '"]').submit(function() {
        addrString = $(addrFieldSelector).val();
        console.log("About to submit. The reported address is: " + addrString);
        queryAndSetAddressCoordinates(addrString, formName);
    });
}