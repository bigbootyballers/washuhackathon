<?php
require_once "util/sql_queries.php";

$event = null;

function main() {
    global $event;

    session_start();

    if (!isset($_GET["event_id"])) {
        header("Location:sign_in.php");
        exit;
    }

    $event = get_event(intval($_GET["event_id"]));
}

main();

include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php";
    ?>

    <div>
        <h1>
            <?php echo $event["name"];?>
        </h1>


        <form method="post" id="route_form">
            <input type="hidden" name="route" id="route" value="" />
            <input type="submit" value="Export path" />
        </form>
        <script>
            const formInfo = document.forms["route_form"];
            alert(myJSONString);
            formInfo.route.value = JSON.stringify(polyPoints);
        </script>

        <?php print_r($_POST); ?>
    </div>

    <div id="map"></div>
    <script type="text/javascript">
        var map = L.map('map', {
            center: [38.6488, -90.3108],
            zoom: 15
        });
        var polyPoints = [];
        map.on('click', function (e) {
            var marker = new L.marker(e.latlng).addTo(map);
            /*marker.bindPopup("Location: " + e.latlng.lat + ", " + e.latlng.lng).openPopup();*/
            polyPoints.push([e.latlng.lat.toFixed(4), e.latlng.lng.toFixed(4)]);
            var polyLine = L.polyline(polyPoints).addTo(map).openOn(map);
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    </script>
</body>

<?php
include "includes/tail.php";
?>
