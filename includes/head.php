<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
          integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
          crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
            integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
            crossorigin=""></script>

 
    <script type="text/javascript">
        function exportPath() {
            const myJSONString = JSON.stringify(polyPoints);
            alert(myJSONString);
            return myJSONString;
        }
    </script> 


    <?php
    # This path is in the perspective of the file that includes, so it should not have ../
    ?>
    <!--suppress HtmlUnknownTarget -->
    <link rel=stylesheet href="master.css" type="text/css" media="all">
    <!--suppress HtmlUnknownTarget -->
    <link rel=stylesheet href="navbar.css" type="text/css" media="all">
    <link rel=stylesheet href="interactives.css" type="text/css" media="all">
</head>
