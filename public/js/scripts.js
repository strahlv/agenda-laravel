function showCreateForm(
    dateString,
    timeString = null,
    isAllDay = true,
    url = "/users/1/events"
) {
    console.log(dateString);
    console.log(timeString);
    var form = $(".event-form");
    form.removeClass("hidden");
    form.attr("action", url);
    $('.event-form > input[name="_method"]').val("POST");

    $("#form-title").html("Criar evento");
    $("#title").val("");
    $("#start-date").val(dateString);
    $("#end-date").val(dateString);
    $("#start-time").val(timeString);
    $("#end-time").val(timeString);

    setTimeInputsDisplay(isAllDay);

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
    $("#start-time").val(calendarEvent.start_time);
    $("#end-time").val(calendarEvent.end_time);

    setTimeInputsDisplay(calendarEvent.is_all_day);

    $("#title").focus();
}

function hideForm() {
    $(".event-form").addClass("hidden");
}

function updateEndTimeConstraints(event) {
    var startTime = event.target.value;
    var endTime = $("#end-time");
    console.log(endTime);

    endTime.attr("min", startTime);

    if (!endTime.value && new Date(startTime) > new Date(endTime.val)) {
        endTime.val(startTime);
    }
}

function toggleTimeInputs() {
    $("#end-date-control").toggleClass("hidden");
    $("#time-control").toggleClass("hidden");
}

function setTimeInputsDisplay(isHidden) {
    $("#is-all-day").prop("checked", isHidden);

    if (isHidden) {
        $("#end-date-control").removeClass("hidden");
        $("#time-control").addClass("hidden");
    } else {
        $("#end-date-control").addClass("hidden");
        $("#time-control").removeClass("hidden");
    }
}

function disableSubmitButton() {
    // TODO:
}
