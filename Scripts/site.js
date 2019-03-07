var GuestsCount = 0;

function FormateDate(Year, Month, Day) {
    return Year + '-' + ("0" + Month).slice(-2) + '-' + ("0" + Day).slice(-2);
}

function gotoView(viewId) {
    document.getElementById(viewId).scrollIntoView();
    window.location.hash = viewId;
}


var CurrentDate = new Date();
$(function () {
    var OptionSelected = false;
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        (!OptionSelected) ? $('#reportrange span').html("Arrival Date") : $('#reportrange span').html(start.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        minDate: CurrentDate,
        maxDate: moment().endOf('year'),
        startDate: start,
        endDate: end,
        singleDatePicker: true
    }, function (start, end) {
        OptionSelected = true;
        var DATE = new Date(start);
        cb(start, end);
        document.getElementById('calendarRange').value = DATE.getFullYear() + '-' + (DATE.getMonth() + 1) + '-' + DATE.getDate();
    });

    cb(start, end);

});

$('#GetList').on('submit', function () {
    var that = $(this), content = that.serialize();

    $.ajax({
        url: 'list.php',
        dataType: 'html',
        type: 'post',
        data: content,
        success: function (data) {
            $('#RoomsContent').html(data);
            GuestsCount = $("#GuestsCount").val();
            $("#Calendar").html("");
            gotoView("RoomsContent");
        }
    })

    return false;
});


$(document).on("click", '.card', function (event) {
    var evname = $(this).data("name");
    $(".SelectedRoom").removeClass("SelectedRoom");
    $(this).addClass("SelectedRoom");

    $.ajax({
        url: 'Calendar.php',
        dataType: 'html',
        type: 'post',
        data: "RoomName=" + evname + "&GuestsCount=" + GuestsCount,
        success: function (data) {
            $('#Calendar').html(data);
            LoadCalendar();
            gotoView("calendar_first");
        }
    })

    return false;
});

$('#GenList').on('submit', function () {
    // room_id --- rooms do not have id's on json file, unless i i create my own? 
    // This Post and Redirect is to get the exact json layout as per example
    // else i would have done a simple javascrpt alert array;

    // the price i'm not sure if the rooms are per guest or per room;
    // so the pricing is based on per room;

    var JsonToPost = {
        "room_id": 1234,
        "arrival_date": BookedFrom,
        "nights": selectedCount,
        "total-rate": TotalPrice,
        "guest_firstname": $("#guest_firstname").val(),
        "guest_lastname": $("#guest_lastname").val(),
        "guest_email": $("#guest_email").val()
    };

    $.ajax({
        type: "POST",
        url: "Enquire.php",
        data: JSON.stringify(JsonToPost),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function () {
            window.location.href = 'Enquire.php';
        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
    return false;
});