function focusForm(dateString) {
    $(".form-create-event").removeClass("hidden");
    // $("#title").val(null);
    $("#date").val(dateString);
    $("#title").focus();
}

function hideForm() {
    $(".form-create-event").addClass("hidden");
    $("#date").val("");
    $("#title").val("");
}

function showEditForm(e, event) {
    console.log(e);
    console.log(event);
    e.stopPropagation();
    $(".form-create-event").removeClass("hidden");
    $(".form-create-event form-header h1").val("Editar evento");
    $("#title").val(event.title);
    $("#date").val(event.date);
    $("#title").focus();
}
