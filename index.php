<?PHP
$PageTitle = "Quisto Prins";
$PageHeading = "Property Website";

require_once(__DIR__ . '/Layout/Header.php');
require_once(__DIR__ . '/Layout/Menu.php');
?>
<div class="container body-content heading-content">
    <div class="TopContent"></div>
    <h2 class="PageHeading">
        <?=$PageHeading?>
    </h2>

    <nav class="SearchMenu">
        <div class="InnerContent">
            <h4>Availability Search</h4>
            <div class="form-horizontal AvailabilityBox context context--xs-show">
                <form id="GetList" class="Search" action="List.php" method="post">

                    <div class="container-fluid padding">
                        <div class="row padding">
                       
                            <div class="col-xs-12 col-sm-4 col-md-4"> 
                                <div id="reportrange" class="form-control" >
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                    <input id="calendarRange" name="calendarRange"/>
                                </div>
                            </div>
                    
                            <div class="col-xs-12 col-sm-4 col-md-4" style="position:relative">
                                <!-- 
                                        For this Test i'll Keep it Quick and Simple

                                        I would normally make this a popup box that you can click the number of Adults with a + or - button and Children with a + or - button
                                        and then maybe Pets 'Yes' or 'No' option.
                                    -->
                            
                                <select id="GuestsCount" name="GuestsCount" class="form-control">
                                    <option value="1">1 Guest</option>
                                    <option value="2">2 Guests</option>
                                    <option value="3">3 Guests</option>
                                    <option value="4">4 Guests</option>
                                    <option value="5">5 Guests</option>
                                    <option value="6">6 Guests</option>
                                    <option value="7">7 Guests</option>
                                </select>
                                <i class="fas fa-users"></i>
                            </div>

                            <div class="col-xs-12 col-sm-4" >
                                <input type="submit" value="Search" class="form-control btn btn-primary" />
                            </div>
                        
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <div class="InnerContent cn2">
        <div class="container-fluid padding">
            <div id="RoomsContent" class="row padding"></div>
        </div>
    </div>

     <div class="cn3">
        <div class="container-fluid padding">
            <div id="Calendar" class="row padding"></div>
        </div>
    </div>
    

</div>
<?PHP
require_once(__DIR__ . '/Layout/Footer.php');
?>




