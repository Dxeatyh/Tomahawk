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
        url: 'calendar.php',
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
