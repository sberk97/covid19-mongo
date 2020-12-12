var fields = "#fips, #admin2, #province-state, #country-region, #last-update, #latitude, #longitude, #confirmed, #deaths, #recovered, #active, #combined-key, #incidence-rate, #case-fatality-ratio";
var displayCheckbox = "#fips-display, #admin2-display, #province-state-display, #country-region-display, #last-update-display, #latitude-display, #longitude-display, #confirmed-display, #deaths-display, #recovered-display, #active-display, #combined-key-display, #incidence-rate-display, #case-fatality-ratio-display";
var existsCheckbox = "#fips-exists, #admin2-exists, #province-state-exists, #country-region-exists, #last-update-exists, #latitude-exists, #longitude-exists, #confirmed-exists, #deaths-exists, #recovered-exists, #active-exists, #combined-key-exists, #incidence-rate-exists, #case-fatality-ratio-exists";
var notEmptyCheckbox = "#fips-notempty, #admin2-notempty, #province-state-notempty, #country-region-notempty, #last-update-notempty, #latitude-notempty, #longitude-notempty, #confirmed-notempty, #deaths-notempty, #recovered-notempty, #active-notempty, #combined-key-notempty, #incidence-rate-notempty, #case-fatality-ratio-notempty";
var advFields = "#last-update-advanced, #confirmed-advanced, #deaths-advanced, #recovered-advanced, #active-advanced, #incidence-rate-advanced, #case-fatality-ratio-advanced";

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
    $("#covid-form").hide();
    $(fields).each(changeVisibilityOfInput);
    document.getElementById("covid-form").reset();
}

function checkIfFormShouldBeHidden() {
    var checkboxes = document.querySelectorAll('input[name=column-checkbox]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked == true) {
            return;
        }
    }
    $("#covid-form").hide();
}

function changeVisibilityOfInput() {
    if ($(this).is(':checked')){
        if (!$("#covid-form").is(":visible")) {
            $("#covid-form").show();
        }
        $("#" + this.id + "-tr").show();
        enableFieldWithGivenId(this.id);
    } else {
        if ($("#covid-form").is(":visible")) {
            checkIfFormShouldBeHidden();
        }
        $("#" + this.id + "-tr").hide();
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
        $("#" + id + "-advanced-tr").show();
        enableAdvancedInput(id);
        $("#" + id + "-input").prop("disabled", true);
    } else {
        $("#" + id + "-advanced-tr").hide();
        disableAdvancedInput(id);
        $("#" + id + "-input").prop("disabled", false);
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
var request;

$("#covid-form").submit(function(event){

    event.preventDefault();

    if (request) {
        request.abort();
    }

    var $form = $(this);
    var serializedData = $form.serialize();

    request = $.ajax({
        url: "app/php/get-data.php",
        type: "post",
        data: serializedData,
        beforeSend: function(){
            document.getElementById("results").innerHTML = '<div class="lds-dual-ring"></div>';
        },
    });

    request.done(function (response, textStatus, jqXHR){
        document.getElementById("results").innerHTML = response;
        $("#results").find("script").each(function(i) {
            eval($(this).text());
        });
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown, jqXHR
        );
    });
});
});