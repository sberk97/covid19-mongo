var fields = "#fips, #admin2, #province-state, #country-region, #last-update, #latitude, #longitude, #confirmed, #deaths, #recovered, #active, #combined-key, #incidence-rate, #case-fatality-ratio";
var advFields = "#confirmed-advanced, #deaths-advanced, #recovered-advanced, #active-advanced, #incidence-rate-advanced, #case-fatality-ratio-advanced";
$(fields).change(changeVisibilityOfInput);
$(advFields).change(changeVisibilityOfInput);
$("#reset-btn").click(hideAllAdvanced);

function selectAll() {
    var checkboxes = document.querySelectorAll('input[name=column-checkbox]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != true)
            checkboxes[i].checked = true;
    }
    $(fields).each(changeVisibilityOfInput);
}

function deselect() {
    var checkboxes = document.querySelectorAll('input[name=column-checkbox]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
    $(fields).each(changeVisibilityOfInput);
    document.getElementById("covid-form").reset();
}

function changeVisibilityOfInput() {
    if($(this).is(':checked')){
        $("#" + this.id + "-div").show();
    } else {
        $("#" + this.id + "-div").hide();
        $("#" + this.id + "-input").val('');
        $("#" + this.id + "-display").prop('checked', true); 
        $("#" + this.id + "-exists").prop('checked', false);
        $(this).each(cleanAdvancedInputs);
    }
}

function cleanAdvancedInputs() {
    if ($("#" + this.id + "-advanced").length != 0) {
        $("#" + this.id + "-advanced").prop('checked', false);
        $("#" + this.id + "-advanced-div").hide();
        $("#" + this.id + "-gt-input").val('');
        $("#" + this.id + "-lt-input").val('');
    } 
}

function hideAllAdvanced() {
    var hasAdvanced = ["#confirmed-advanced", "#deaths-advanced", "#recovered-advanced", "#active-advanced", "#incidence-rate-advanced", "#case-fatality-ratio-advanced"];
    hasAdvanced.forEach(element => {
        $(element + "-div").hide();
    });
}