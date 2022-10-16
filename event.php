<?php
include "includes/head.php";
?>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="event.php">Map</a></li>
        </ul>
    </nav>
    <div id="map"></div>
    <script type="text/javascript">
        var map = L.map('map', {
            center: [38.6488, -90.3108],
            zoom: 15
        });
        map.on('click', function (e) {
            var marker = new L.marker(e.latlng).addTo(map);
            marker.bindPopup("Location: " + e.latlng.lat + ", " + e.latlng.lng).openPopup();
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    </script>
</body>

<?php
include "includes/tail.php";
?>
