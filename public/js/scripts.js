function focusForm(dateString) {
    console.log(dateString);
    $(".form-create-event").removeClass("hidden");
    $("#date").val(dateString);
    $("#title").focus();
}

function hideForm() {
    $(".form-create-event").addClass("hidden");
    $("#date").val("");
    $("#title").val("");
}
