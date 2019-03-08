<?PHP
if(isset($_POST['calendarRange'], $_POST['GuestsCount'])){
    $i = 0;
    $CalendarRange = $_POST['calendarRange'];
    $GuestsCount = (int)$_POST['GuestsCount'];

    $jsondata = file_get_contents("json/Code-Test-Input.json");
    $json = json_decode($jsondata,true);

    echo "<h1 style='margin:15px'>".$json['property']['name']."</h1>";
    $currency = $json['property']['currency']."</h1>";

    $output = "";
    foreach($json['rooms'] as $rooms){

        $RoomName = $rooms['name'];
        $bedrooms = $rooms['bedrooms'];
        $bedrooms .= ($rooms['bedrooms'] > 1) ? ' Beds' : ' Bed';
        $maxguests = $rooms['maxguests'];

        if ($GuestsCount <= $maxguests){
            $i++;
            echo "
            <div class='col-xs-12 col-sm-6 col-md-4'>
                <div class='card' data-name='$RoomName'>
                    <h4>$RoomName</h4>
                    <div class='img' style=\"background-image:url('/Images/Rooms/$RoomName.jpg')\"></div>
                    <h5>Private Rooms $bedrooms</h5>
                    <h5>Max Guests: $maxguests</h5>
                </div>
            </div>
           ";
        }
    }

    if ($i == 0){
        echo "Sorry! No rooms available with your current selection";
    }
 }
