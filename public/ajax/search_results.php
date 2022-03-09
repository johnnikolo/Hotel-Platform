<?php

require __DIR__. '/../../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

// Initialize Room service
$room = new Room();

// Get all cities
$cities = $room->getCities();

// Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

// Get page parameters
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$selectedCountofGuests = $_REQUEST['count_of_guests'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$minPrice = $_REQUEST['min_price'];
$maxPrice = $_REQUEST['max_price'];

// Search for room

$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $minPrice, $maxPrice);

?>

<section class="hotel-list box">
    <header class="page-title">
        <h2>Search Results</h2>
    </header>    
    <article class="hotel">
        <?php 
            foreach($allAvailableRooms as $availableRoom) {
        ?>
        <aside class="media">
            <img src="assets/images/rooms/<?php echo $availableRoom[photo_url]; ?>" width="30%" height="auto" id="hotel-img"/>
        </aside>
        <main class="info">                               
            <h2><?php echo $availableRoom[name]; ?></h2>
            <h1><?php echo $availableRoom[city]; ?>, <?php echo $availableRoom[area]; ?></h1>
            <p><?php echo $availableRoom[description_short]; ?></p>
            <div class="text-right">
                <button type="button" name="button" class="btn-primary">
                    <a href="room.php?room_id=<?php echo $availableRoom[room_id];?>&check_in_date=<?php echo $checkInDate;?>&check_out_date=<?php echo $checkOutDate;?>">Go to room page</a>
                </button>
            </div>
            <table class="property-info" id="property-info">
                <tr>
                    <td>Per Night: <?php echo $availableRoom[price]; ?></td>
                    <td>Count of Guests: <?php echo $availableRoom[count_of_guests]; ?></td>
                    <td>Type of Room: 
                    <?php
                    if ($availableRoom[type_id] == 1) 
                        echo 'Single Room'; 
                    elseif ($availableRoom[type_id] == 2) 
                        echo "Double Room"; 
                    elseif ($availableRoom[type_id] == 3) 
                        echo "Triple Room"; 
                    else 
                        echo "Fourfold Room"; 
                    ?>                                                                                                                            
                    </td>
                </tr>                           
            </table>
        </main>
        <div class="clear"></div>
        <hr>
        <?php
                } 
        ?>
    </article>
    <?php 
        if (count($allAvailableRooms) == 0) {   ?>                         
            <h2 style= "color:#FF0000"><strong>There are no available rooms matching your search criteria!</strong></h2>                       
    <?php } ?>        
</section>