function selectAll() {
    var checkboxes = document.querySelectorAll('input[name=column-checkbox]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != true)
            checkboxes[i].checked = true;
    }
}

function deselect() {
    var checkboxes = document.querySelectorAll('input[name=column-checkbox]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
}

// $("#fips").change(function(event){
//     console.log(this.id);
//     if($(this).is(':checked')){
//          $("#fips-div").show();
//      } else {
//          $("#fips-div").hide();
//      }
//  });

 $("#fips, #admin2").change(changeVisibilityOfInput);

 function changeVisibilityOfInput() {
    if($(this).is(':checked')){
        $("#" + this.id + "-div").show();
    } else {
        $("#" + this.id + "-div").hide();
    }
}