<?php
require_once 'config.inc.php';
require_once 'ASG2-classes.php';
include 'nav-header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galleries</title>
    <link rel="stylesheet" href="css/galleries.css">

</head>

<body>
    <main id="main">

        <!-- this section initially displayed for the user to select
        a gallery of their choice. This section can be toggled off
        by a button to make more space for the other sections -->
        <section id="galleryList">
            <h2>Gallery List</h2>
            <ul id="galleries"></ul>

        </section>

        <section id="galleryInfo">
            <!-- for gallery info -->
            <h2>Gallery Information</h2>
            <div class="info">
                <h3 id="galleryName"></h3>
                <label>Native Name:</label>
                <span id="galleryNative"></span>
                <label>City:</label>
                <span id="galleryCity"></span>
                <label>Address:</label>
                <span id="galleryAddress"></span>
                <label>Country:</label>
                <span id="galleryCountry"></span>

                <a id="website">Visit Website</a>
            </div>
        </section>

        <!-- this section is populated with information from the API depending
        on which gallery from galleryList section is selected by user click -->
        <section id="paintingsList">
            <!-- for paintings -->
            <h2>Paintings</h2>
            <div id="paintings">

                <table id="table">
                    <thead>
                        <tr>

                            <th></th>
                            <th id="artist">Artist</th>
                            <th id="title">Title</th>
                            <th id="year">Year</th>

                        </tr>

                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </section>

        <!--for map  -->
        <div id="map"></div>
    </main>
    <script src="galleriesJS.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzKtg9zVIqY-SrEfnsFS50glx-eBLZN9Q&callback=initMap" async defer></script>
</body>

</html>