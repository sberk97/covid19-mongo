var fields = "#fips, #admin2, #province-state, #country-region, #last-update, #latitude, #longitude, #confirmed, #deaths, #recovered, #active, #combined-key, #incidence-rate, #case-fatality-ratio";
var advFields = "#confirmed-advanced, #deaths-advanced, #recovered-advanced, #active-advanced, #incidence-rate-advanced, #case-fatality-ratio-advanced";
var existsCheckbox = "#fips-exists, #admin2-exists, #province-state-exists, #country-region-exists, #last-update-exists, #latitude-exists, #longitude-exists, #confirmed-exists, #deaths-exists, #recovered-exists, #active-exists, #combined-key-exists, #incidence-rate-exists, #case-fatality-ratio-exists";
$(fields).change(changeVisibilityOfInput);
$(advFields).change(changeVisibilityOfInput);
$(existsCheckbox).change(emptyAndLockInputField);
$("#reset-btn").click(resetForm);

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

function resetForm() {
    hideAllAdvanced();
    $(existsCheckbox).each(enableFields);
}

function hideAllAdvanced() {
    var hasAdvanced = ["#confirmed-advanced", "#deaths-advanced", "#recovered-advanced", "#active-advanced", "#incidence-rate-advanced", "#case-fatality-ratio-advanced"];
    hasAdvanced.forEach(element => {
        $(element + "-div").hide();
    });
}

function emptyAndLockInputField() {
    var id = this.id.substr(0, this.id.lastIndexOf('-')); 
    if($(this).is(':checked')){
        $("#" + id + "-input").val('');
        $("#" + id + "-input").prop("disabled", true);
        $('#sort-by').children('option[value="' + id + '"]').prop('disabled', true)
        $("#sort-by").prop("selectedIndex", 0)

        if ($("#" + id + "-advanced").length != 0) {
            $("#" + id + "-advanced").prop('checked', false);
            $("#" + id + "-advanced-div").hide();
            $("#" + id + "-gt-input").val('');
            $("#" + id + "-lt-input").val('');
            $("#" + id + "-advanced").prop("disabled", true);
        }
    } else {
        $(this).each(enableFields);
    }
}

function enableFields() {
    var id = this.id.substr(0, this.id.lastIndexOf('-')); 

    $("#" + id + "-input").prop("disabled", false);
    $('#sort-by').children('option[value="' + id + '"]').prop('disabled', false)

    if ($("#" + id + "-advanced").length != 0) {
        $("#" + id + "-advanced").prop("disabled", false);
    }
}