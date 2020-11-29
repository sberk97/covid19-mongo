var fields = "#fips, #admin2, #province-state, #country-region, #last-update, #latitude, #longitude, #confirmed, #deaths, #recovered, #active, #combined-key, #incidence-rate, #case-fatality-ratio";
var displayCheckbox = "#fips-display, #admin2-display, #province-state-display, #country-region-display, #last-update-display, #latitude-display, #longitude-display, #confirmed-display, #deaths-display, #recovered-display, #active-display, #combined-key-display, #incidence-rate-display, #case-fatality-ratio-display";
var existsCheckbox = "#fips-exists, #admin2-exists, #province-state-exists, #country-region-exists, #last-update-exists, #latitude-exists, #longitude-exists, #confirmed-exists, #deaths-exists, #recovered-exists, #active-exists, #combined-key-exists, #incidence-rate-exists, #case-fatality-ratio-exists";
var notEmptyCheckbox = "#fips-notempty, #admin2-notempty, #province-state-notempty, #country-region-notempty, #last-update-notempty, #latitude-notempty, #longitude-notempty, #confirmed-notempty, #deaths-notempty, #recovered-notempty, #active-notempty, #combined-key-notempty, #incidence-rate-notempty, #case-fatality-ratio-notempty";
var advFields = "#confirmed-advanced, #deaths-advanced, #recovered-advanced, #active-advanced, #incidence-rate-advanced, #case-fatality-ratio-advanced";

$(fields).change(changeVisibilityOfInput);
$(displayCheckbox).change(changeStateOfFieldInSort);
$(existsCheckbox).change(disableFieldWhenShouldNotExists);
$(notEmptyCheckbox).change(changeStateOfNotExist);
$(advFields).change(changeVisibilityOfAdvancedInput);
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
    if ($(this).is(':checked')){
        $("#" + this.id + "-div").show();
        enableFieldWithGivenId(this.id);
    } else {
        $("#" + this.id + "-div").hide();
        $(this).each(setInputToDefault);
        disableFieldWithGivenId(this.id);
    }
}

function setInputToDefault() {
    $("#" + this.id + "-input").val('');
    $("#" + this.id + "-display").prop('checked', true); 
    $("#" + this.id + "-exists").prop('checked', false);
    $("#" + this.id + "-notempty").prop('checked', false);
    if ($("#" + this.id + "-advanced").length != 0) {
        $("#" + this.id + "-advanced").prop('checked', false);
        changeVisibilityOfAdvancedInputWithGivenId(this.id);
        $("#" + this.id + "-advanced-gt-input").val('');
        $("#" + this.id + "-advanced-lt-input").val('');
    } 
}

function changeVisibilityOfAdvancedInput() {
    var id = getIdOutOfString(this.id);
    changeVisibilityOfAdvancedInputWithGivenId(id);
}

function changeVisibilityOfAdvancedInputWithGivenId(id) {
    if ($("#" + id + "-advanced").is(':checked')){
        $("#" + id + "-advanced-div").show();
        enableAdvancedInput(id);
    } else {
        $("#" + id + "-advanced-div").hide();
        disableAdvancedInput(id);
    }
}

function enableAdvancedInput(id) {
    $("#" + id + "-advanced-gt-input").prop("disabled", false);
    $("#" + id + "-advanced-lt-input").prop("disabled", false);
}

function disableAdvancedInput(id) {
    $("#" + id + "-advanced-gt-input").prop("disabled", true);
    $("#" + id + "-advanced-lt-input").prop("disabled", true);
}

function resetForm() {
    document.getElementById("covid-form").reset();
    $(advFields).each(changeVisibilityOfAdvancedInput);
    $(fields).each(enableFields);
}

function disableFieldWhenShouldNotExists() {
    var id = getIdOutOfString(this.id);
    if ($(this).is(':checked')){
        disableFieldWithGivenId(id);
        $("#" + id + "-exists").prop("disabled", false);
    } else {
        enableFieldWithGivenId(id);
        if ($("#" + id + "-advanced").is(':checked')) { 
            changeVisibilityOfAdvancedInputWithGivenId(id);
        }
    }
}

function disableFieldWithGivenId(id) {
    $("#" + id + "-input").prop("disabled", true);
    $("#" + id + "-display").prop("disabled", true);
    $("#" + id + "-exists").prop("disabled", true);
    $("#" + id + "-notempty").prop("disabled", true);
    disableOptionInSortWithGivenId(id);

    if ($("#" + id + "-advanced").length != 0) {
        $("#" + id + "-advanced").prop("disabled", true);
        disableAdvancedInput(id);
    }
}

function enableFields() {
    enableFieldWithGivenId(this.id);
}

function enableFieldWithGivenId(id) {
    $("#" + id + "-input").prop("disabled", false);
    $("#" + id + "-display").prop("disabled", false);
    $("#" + id + "-exists").prop("disabled", false);
    $("#" + id + "-notempty").prop("disabled", false);
    enableOptionInSortWithGivenId(id);

    if ($("#" + id + "-advanced").length != 0) {
        $("#" + id + "-advanced").prop("disabled", false);
    }
}

function changeStateOfFieldInSort() {
    var id = getIdOutOfString(this.id);
    if ($(this).is(':checked')){
        enableOptionInSortWithGivenId(id);
    } else {
        disableOptionInSortWithGivenId(id);
    }
}

function enableOptionInSortWithGivenId(id) {
    $('#sort-by').children('option[value="' + id + '"]').prop('disabled', false)
}

function disableOptionInSortWithGivenId(id) {
    $('#sort-by').children('option[value="' + id + '"]').prop('disabled', true)
    if($('option[value="' + id + '"]').is(':selected')) {
        $("#sort-by").prop("selectedIndex", 0);
    }
}

function changeStateOfNotExist() {
    var id = getIdOutOfString(this.id);
    if ($(this).is(':checked')){
        $("#" + id + "-exists").prop("disabled", true);
    } else {
        $("#" + id + "-exists").prop("disabled", false);
    }
}

function getIdOutOfString(string) {
    var id = string.substr(0, string.lastIndexOf('-'));
    return id;
}



$(function() {
// Variable to hold request
var request;

// Bind to the submit event of our form
$("#covid-form").submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    //var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    //$inputs.prop("disabled", true);

    // Fire off the request to /get-data.php
    request = $.ajax({
        url: "/get-data.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        document.getElementById("results").innerHTML = response;
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        //$inputs.prop("disabled", false);
    });

});
});