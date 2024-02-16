function showCreateForm(dateString, url) {
    var form = $(".event-form");
    form.removeClass("hidden");
    form.attr("action", url);
    $('.event-form > input[name="_method"]').val("POST");

    $("#form-title").html("Criar evento");
    $("#title").val("");
    $("#start-date").val(dateString);
    $("#end-date").val(dateString);
    $("#title").focus();
}

function showEditForm(event, calendarEvent, url) {
    event.stopPropagation();

    var form = $(".event-form");
    form.removeClass("hidden");
    form.attr("action", url);
    $('.event-form > input[name="_method"]').val("PUT");

    $("#form-title").html("Editar evento");
    $("#title").val(calendarEvent.title);
    $("#start-date").val(calendarEvent.start_date);
    $("#end-date").val(calendarEvent.end_date);
    $("#title").focus();
}

function hideForm() {
    $(".event-form").addClass("hidden");
}

function submitForm() {
    // TODO:
}
