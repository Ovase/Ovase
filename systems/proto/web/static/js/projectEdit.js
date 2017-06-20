
function initEditProjectPage()
{
    // Init datepickers
    $("#editProjectStep1_startdate").datepicker($.datepicker.regional["no"]);
    $("#editProjectStep1_enddate").datepicker($.datepicker.regional["no"]);
}

// Disable enddate picker's dates (before startdate)
function disableDates() {
    $("#editProjectStep1_enddate").datepicker("option","minDate",$("#editProjectStep1_startdate").datepicker("getDate"));
}