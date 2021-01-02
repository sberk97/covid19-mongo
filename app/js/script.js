// Generate string with IDs of fields
var fieldsArr = document.querySelectorAll('[id $= "-tr"]');
var fields = "";
function addFieldToString(element) {
    if(fields !== "") {
        fields += ", ";
    }
    fields += "#";
    fields += element.id.substr(0, element.id.lastIndexOf('-'));
}
Array.prototype.forEach.call(fieldsArr, addFieldToString);

// Generate string with ids of checkboxes
function addIdToString(element, str) {
    if(str !== "") {
        str += ", ";
    }
    str += "#";
    str += element.id;
    return str;
}

var displayCheckboxArr = document.querySelectorAll('[id $= "-display"]');
var existsCheckboxArr = document.querySelectorAll('[id $= "-exists"]');
var notEmptyCheckboxArr = document.querySelectorAll('[id $= "-notempty"]');
var advFieldsCheckbox = document.querySelectorAll('[id $= "-advanced"]');

var displayCheckbox = "";
var existsCheckbox = "";
var notEmptyCheckbox = "";
var advFields = ""

displayCheckboxArr.forEach((element) => {
    displayCheckbox = addIdToString(element, displayCheckbox);
})

existsCheckboxArr.forEach((element) => {
    existsCheckbox = addIdToString(element, existsCheckbox);
})

notEmptyCheckboxArr.forEach((element) => {
    notEmptyCheckbox = addIdToString(element, notEmptyCheckbox);
})

advFieldsCheckbox.forEach((element) => {
    advFields = addIdToString(element, advFields);
})

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
        $("#" + id + "-advanced-td").show();
        enableAdvancedInput(id);
        $("#" + id + "-input").prop("disabled", true);
    } else {
        $("#" + id + "-advanced-td").hide();
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