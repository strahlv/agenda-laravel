function showCreateForm(dateString, url) {
    var form = $(".event-form");
    form.removeClass("hidden");
    form.attr("action", url);
    $('input[name="_method"]').val("POST");

    $("#form-title").html("Criar evento");
    $("#title").val("");
    $("#date").val(dateString);
    $("#title").focus();
}

function showEditForm(event, calendarEvent, url) {
    event.stopPropagation();

    var form = $(".event-form");
    form.removeClass("hidden");
    form.attr("action", url);
    $('input[name="_method"]').val("PUT");

    $("#form-title").html("Editar evento");
    $("#title").val(calendarEvent.title);
    $("#date").val(calendarEvent.date);
    $("#title").focus();
}

function hideForm() {
    $(".event-form").addClass("hidden");
}
