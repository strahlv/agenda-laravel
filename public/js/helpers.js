function showEvent(event) {}

function showCreateForm(dateString, timeString, isAllDay, storeUrl) {
    $("#create-event").attr("action", storeUrl);

    $("#create-event #title").val("");
    $("#create-event #start-date").val(dateString);
    $("#create-event #end-date").val(dateString);
    $("#create-event #start-time").val(timeString);
    $("#create-event #end-time").val(timeString);

    setTimeInputsDisplay("#create-event", isAllDay);

    $("#create-event #title").focus();
}

function showEditForm(calendarEvent, updateUrl) {
    $("#edit-event").attr("action", updateUrl);

    $("#edit-event #title").val(calendarEvent.title);
    $("#edit-event #start-date").val(calendarEvent.start_date);
    $("#edit-event #end-date").val(calendarEvent.end_date);
    $("#edit-event #start-time").val(calendarEvent.start_time);
    $("#edit-event #end-time").val(calendarEvent.end_time);

    setTimeInputsDisplay("#edit-event", calendarEvent.is_all_day);
}

function hideForm() {
    $("#event-sidebar").addClass("hidden");
    $(".event-form").addClass("hidden");
}

// TODO: também alterar o tempo inicial, data?
function updateEndTimeConstraints(event, formId) {
    let startTime = $(formId + " #start-time");
    let endTime = event.target.value;

    let startDate = new Date();
    let split = startTime.val().split(":");
    startDate.setHours(split[0], split[1], 0);
    console.log(startDate);

    let endDate = new Date();
    split = endTime.split(":");
    endDate.setHours(split[0], split[1], 0);
    console.log(endDate);

    console.log(startDate.getTime() > endDate.getTime());

    if (startDate.getTime() > endDate.getTime()) {
        event.target.value = startTime.val();
    }
}

// TODO: usar alpinejs?
function toggleTimeInputs(formId) {
    $(formId + " #end-date-control").toggleClass("hidden");
    $(formId + " #time-control").toggleClass("hidden");
}

// TODO: usar alpinejs?
function setTimeInputsDisplay(formId, isHidden) {
    $(formId + " #is-all-day").prop("checked", isHidden);

    if (isHidden) {
        $(formId + " #end-date-control").removeClass("hidden");
        $(formId + " #time-control").addClass("hidden");
    } else {
        $(formId + " #end-date-control").addClass("hidden");
        $(formId + " #time-control").removeClass("hidden");
    }
}

function onSubmitForm(event) {
    $(event.target).children('button[type="submit"]').prop("disabled", true);
    // $('button[type="submit"]').prop("disabled", true);
    $("#loading-bar").removeClass("hidden");
    $("main").addClass("loading-content");
}

function stopPropagation(event) {
    event.stopPropagation();
}

function addOrRemoveById(array, value) {
    let sameId = (item) => item.id === value.id;

    if (!array.find(sameId)) {
        array.push(value);
    } else {
        array.splice(array.findIndex(sameId), 1);
    }
}

// User picker
function removeItem(itemToRemove, array) {
    return array.filter((item) => item != itemToRemove);
}

async function fetchEmails(data) {
    data.status = "pending";

    if (data.search === "") {
        data.options = [];
        data.status = "idle";
        return;
    }

    let responseData = await $.get(`/users?email=${data.search}`);
    data.options = responseData.filter((item) => !data.items.includes(item));

    data.status = "idle";
}

$(document).ready(function () {
    // Ler notificações ao abrir o menu de notificações
    $("#notifications").on("click", function () {
        $(this).removeClass("notification");

        let notificationIds = $("ul[data-notification-ids]")
            .data("notificationIds")
            .map((notif) => notif.id);

        if (notificationIds.length === 0) {
            return;
        }

        $.ajax("/notifications/markAsRead", {
            headers: {
                "X-CSRF-TOKEN": $("input[name=_token]").val(),
            },
            method: "PATCH",
            data: { ids: notificationIds },
        }).done((res) => console.log(res));
    });
});
