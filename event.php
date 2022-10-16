<?php
require_once "util/sql_queries.php";

$event = null;

function main() {
    global $event;

    session_start();

    if (!isset($_POST["event_id"])) {
        header("Location:sign_in.php");
        exit;
    }

    $event = get_event(intval($_POST["event_id"]));
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
        <p>
            <button onclick="exportPath()">Export Path</button>
        </p>
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
            polyPoints.push([e.latlng.lat, e.latlng.lng]);
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
