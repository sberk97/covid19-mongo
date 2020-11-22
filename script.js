var fields = "#fips, #admin2, #province-state, #country-region, #last-update, #latitude, #longitude, #confirmed, #deaths, #recovered, #active, #combined-key, #incidence-rate, #case-fatality-ratio";
$(fields).change(changeVisibilityOfInput);

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
    }
}