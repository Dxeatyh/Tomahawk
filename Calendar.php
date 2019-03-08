<?PHP
$RoomNameRequested = $_POST['RoomName'];

if(isset($RoomNameRequested)){
    $i = 0;

    $jsondata = file_get_contents("json/Code-Test-Input.json");
    $json = json_decode($jsondata,true);

    $currency = $json['property']['currency'];
    $tax = $json['property']['tax'];
    $taxinclusive = $json['property']['tax-inclusive'];


    foreach($json['rooms'] as $rooms){
        $RoomName = $rooms['name'];

        if ($RoomName == $RoomNameRequested ){
            $bedrooms = $rooms['bedrooms'];
            $maxguests = $rooms['maxguests'];
            $taxinclusive = $rooms['tax-inclusive'] ? true : false;
            break;
        }
    }

    $RoomJson = '[';
    foreach($json['rates'] as $rates){
        $RoomName = $rates['room_name'];

        if ($RoomName == $RoomNameRequested){
            $RoomJson .= '{';
            $RoomJson .= '  "start_date" : "' . $rates['start_date'] . '",';
            $RoomJson .= '  "end_date" : "' . $rates['end_date'] . '",';
            $RoomJson .= '  "rate" : "' . $rates['rate'] . '"';
            $RoomJson .= '},';
        }
    }
    $RoomJson = substr($RoomJson, 0, -1);
    $RoomJson .= ']';


    $AvalJson = '[';
    foreach($json['availability'] as $availability){
        $RoomName = $availability['room_name'];
        $RoomAvail = $availability['available'] ? "Yes" : "No";

        if ($RoomName == $RoomNameRequested){
            $AvalJson .= '{';
            $AvalJson .= '  "start_date" : "' . $availability['start_date'] . '",';
            $AvalJson .= '  "end_date" : "' . $availability['end_date'] . '",';
            $AvalJson .= '  "available" : "' . $RoomAvail . '"';
            $AvalJson .= '},';
        }
    }
    $AvalJson = substr($AvalJson, 0, -1);
    $AvalJson .= ']';

    echo "<script>
            var currency = '$currency';
            var taxinclusive = '$taxinclusive';
            var RoomJson = $RoomJson;
            var AvalJson = $AvalJson;
          </script>";
?>

<div class="container">
    <div class="calendar-section">
        <div class="row">
            <div class="col-sm-6">
                <div class="calendar calendar-first" id="calendar_first">
                    <div class="calendar_header">
                    <button class="switch-month switch-left">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                    </button>
                    <h2></h2>
                    <button class="switch-month switch-right">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                    </div>
                    <div class="calendar_weekdays"></div>
                    <div class="calendar_content"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="calendar calendar-second" id="calendar_second">
                    <div class="calendar_header">
                    <button class="switch-month switch-left">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                    </button>
                    <h2></h2>
                    <button class="switch-month switch-right">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                    </div>
                    <div class="calendar_weekdays"></div>
                    <div class="calendar_content"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="BookingDetails" style="width:100%;text-align:center">
    <table>
        <tr>
            <td>Check-in</td>
            <td>Checkout</td>
            <td>Guests</td>
        </tr>
        <tr>
            <td style="width:33%">
                <b>
                    <span id="Checkin">0</span>
                </b>
            </td>
            <td style="width:33%">
                <b>
                    <span id="Checkout">0</span>
                </b>
            </td>
            <td style="width:33%" nowrap>
                <b>
                    <span>
                        <?=$_POST["GuestsCount"]; ?> <?=$_POST["GuestsCount"] > 1 ? "guests" :"guest" ;?>
                    </span>
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span id="DaysSelected">0</span>
                Day/s selected
            </td>
        </tr>
        <?PHP if ($taxinclusive){?>
        <tr>
            <td align="right" nowrap>Tax Rate:</td>
            <td colspan="2">
                <span>
                    <?= $tax?>%
                </span>
            </td>
        </tr>
        <?PHP }?>
        <tr>
            <td align="right">Total:</td>
            <td colspan="2">
                <span id="TotalPrice">0</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="text-center" style="margin-top:10px;">
                    <a href="" class="form-control btn btn-primary btn btn-default btn-rounded mb-4 waves-effect waves-light" data-toggle="modal" data-target="#modalLoginForm">
                        Enquire
                    </a>
                </div>
            </td>
        </tr>

    </table>
</div>

<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title w-100 font-weight-bold">Booking</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="GenList" class="Search" action="enquire.php" method="post">

                <div class="modal-body mx-3">

                    <div class="md-form form-details">
                        <table>
                            <tr>
                                <th>Booked From</th>
                                <td>
                                    <span id="Form_BookedFrom"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Nights</th>
                                <td>
                                    <span id="Form_TotalNights"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Totat Price</th>
                                <td>
                                    <span id="Form_TotatPrice"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br />

                    <div class="md-form">
                        <label data-error="wrong" data-success="right" for="guest_firstname">First Name</label>
                        <input type="text" id="guest_firstname" class="form-control validate" placeholder="First Name" value="FirstName" />
                    </div>

                    <div class="md-form">
                        <label data-error="wrong" data-success="right" for="guest_lastname">Last Name</label>
                        <input type="text" id="guest_lastname" class="form-control validate" placeholder="Last Name" value="LastName"/>
                    </div>

                    <div class="md-form">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label>
                        <input type="email" id="guest_email" class="form-control validate" placeholder="Your email" value="email@address.com" />
                    </div>
                    
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-default" id="Submit_Enquire">Enquire now</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
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
        url: "enquire.php",
        data: JSON.stringify(JsonToPost),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function () {
            window.location.href = 'enquire.php';
        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
    return false;
});
</script>
<?PHP
}

