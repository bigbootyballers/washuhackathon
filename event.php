<?php
require_once "util/sql_queries.php";

$event = null;
$users = null;

function main() {
    global $event;
    global $users;

    session_start();

    if (!isset($_GET["event_id"])) {
        header("Location:sign_in.php");
        exit;
    }
    if (!isset($_SESSION["username"])) {
        header("Location:sign_in.php");
        exit;
    }

    $event = get_event(intval($_GET["event_id"]));
    $users = get_event_users(intval($_GET["event_id"]));
}

main();

include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php";
    ?>

    <main>
        <div>
            <h1>
                <?php echo $event["name"];?>
            </h1>
            <h2>
                People
            </h2>
            <?php
            if (!user_in_event($_SESSION["username"], $_GET["event_id"])) {
                printf("<a href='util/event_join.php?event_id={$_GET["event_id"]}'>Join event</a>");
            }
            ?>
            <ul>
                <?php
                foreach ($users as $user) {
                    printf("<li>%s</li>", $user["username"]);
                }
                ?>
            </ul>

            <form method="post" id="route_form" onsubmit="onDownload()"
                  action="<?php echo "util/export_path.php?event_id={$_GET['event_id']}"; ?>">
                <input type="hidden" name="route" id="route" value="" />
                <input type="submit" value="Save path"/>
            </form>
            <script>
                function onDownload(){
                    const formInfo = document.forms["route_form"];
                    formInfo.route.value = JSON.stringify(polyPoints);
                }
            </script>
        </div>

        <div id="map"></div>
        <script type="text/javascript">
            var map = L.map('map', {
                center: [38.6488, -90.3108],
                zoom: 15
            });
            <?php
            if (is_null($event["route"])) {
                printf("var polyPoints = [];");
            } else {
                printf("var polyPoints = JSON.parse('%s');", $event["route"]);
            }
            ?>
            var polyLine = L.polyline(polyPoints).addTo(map);
            map.on('click', function (e) {
                var marker = new L.marker(e.latlng).addTo(map);
                polyPoints.push([e.latlng.lat.toFixed(4), e.latlng.lng.toFixed(4)]);
                var polyLine = L.polyline(polyPoints).addTo(map).openOn(map);
            });
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        </script>
    </main>
</body>

<?php
include "includes/tail.php";
?>
