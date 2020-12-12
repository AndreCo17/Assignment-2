<?php

require_once 'api/config.inc.php';
require_once 'api/ASG2-classes.php';
include 'nav-header.php';

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));
    $artGateway = new ArtistDB($conn);
    $artists = $artGateway->getAll();
} catch (PDOException $e) {
    die($e->getMessage());
}

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));
    $galGateway = new GalleryDB($conn);
    $galleries = $galGateway->getAll();
} catch (PDOException $e) {
    die($e->getMessage());
}

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));
    $paintGateway = new PaintingDB($conn);
    $paintings = $paintGateway->getAll();
} catch (PDOException $e) {
    die($e->getMessage());
}

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <title>Browse Paintings</title>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='css/browse.css' rel='stylesheet' type='text/css'>
</head>

<body>
    <main id='container'>
        <!--Painting filter box where user sets filter setting-->
        <section id='outerbox1'>
            <form class="ui form" method="get" action="browse-paintings.php">
                <!--User selects a title, artist and gallery to search from-->
                <h2>Painting Filters</h2>
                <div class='field'>
                    <label for='title'>Title</label>
                    <input type='text' class='txtInput' id='title' name='title'><br><br><br>
                    <label>Artist</label>
                    <select id='artist' class='dropdown' name='artists'>
                        <option value='0'>Select Artist</option>
                        <!--Gets list of artists to choose from-->
                        <?php
                        foreach ($artists as $row) {
                            $name = $row['FirstName'] . ' ' . $row['LastName'];
                            echo '<option value ="' . $row['id'] . '">';
                            echo $name;
                            echo "</option>";
                        }
                        mysqli_close($conn);
                        ?>
                    </select><br><br><br>
                    <label>Gallery</label>
                    <select id='gallery' class='dropdown' name='gallery'>
                        <option value='0'>Select Gallery</option>
                        <!--Gets list of galleries to search from-->
                        <?php
                        foreach ($galleries as $row) {
                            echo '<option value ="' . $row['GalleryID'] . '">';
                            echo $row['GalleryName'];
                            echo "</option>";
                        }
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <!--User selects year or range of years for searching-->
                <h3>Year</h3>
                <div>
                    <input type='radio' id='before' name='year' value='before'>
                    <label for='before'>Before</label>
                    <input type='text' class='txtInput' id='beforeTxt' name='beforeTxt'><br><br><br>
                    <input type='radio' id='after' name='year' value='after'>
                    <label for='before'>After</label>
                    <input type='text' class='txtInput' id='afterTxt' name='afterTxt'><br><br><br>
                    <input type='radio' id='between' name='year' value='between'>
                    <label for='between'>Between</label>
                    <input type='text' class='txtInput' id='betweenStart' name='betweenStart' placeholder='1400'><br><br><br>
                    <input type='text' class='txtInput' id='betweenEnd' name='betweenEnd' placeholder='1500'><br><br><br>
                    <input type='submit' class='buttonForm' value='Filter'>
                    <input type='reset' class='buttonForm' value='Clear'>
                </div>
            </form>
        </section>
        <section id='outerbox2'>
            <h2>Paintings</h2>
            <table>
                <!--code for retrieved data from form-->
                <?php


                //here will be the generated table rows
                function checkName($row)
                {
                    if (is_null($row['FirstName'])) {
                        return $row['LastName'];
                    } else if (is_null($row['LastName'])) {
                        return $row['FirstName'];
                    } else {
                        return $row['LastName'] . ", " . $row['FirstName'];
                    }
                }
                ?>
                <!--Below is where the tables are generated-->
                <?php function generateTable($list)
                { ?>
                    <tr>
                        <th></th>
                        <th><a href="browse-paintings.php?sort=$_GET['year']&$_GET['title']=Port&$_GET['artist']=&$_GET['gallery']=&$_GET['artist']">Artist</a></th>
                        <th><a href="browse-paintings.php?sort=$_GET['year']&$_GET['title']=Port&$_GET['artist']=&$_GET['gallery']=&$_GET['title']=%$_GET['title']%">Title</a></th>
                        <th><a href="browse-paintings.php?sort=$_GET['year']&$_GET['title']=Port&$_GET['artist']=&$_GET['gallery']=&$_GET['year']=1500">Year</a></th>
                    </tr>
                    <?php
                    foreach ($list as $row) { ?>
                        <tr class="tempTr">
                            <td class="img">
                                <a href="single-painting.php?id=<?= $row['PaintingID'] ?>">
                                    <img src='../images/paintings/square-medium/<?= $row['ImageFileName'] ?>.jpg' />
                                </a>
                            </td>
                            <td class="artist"><?= checkName($row) ?></td>
                            <td class="title" id="<?= $row['ImageFileName'] ?>">
                                <a href="single-painting.php?id=<?= $row['PaintingID'] ?>"><?= $row['Title'] ?></a>
                            </td>
                            <td class="year"><?= $row['YearOfWork'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="addToFavorites">
                                    <input type="hidden" name="PaintingID" value="<?= $row['PaintingID'] ?>">
                                    <input type="hidden" name="ArtistID" value="<?= $row['ArtistID'] ?>">
                                    <input type="hidden" name="Title" value="<?= $row['Title'] ?>">
                                    <input type="hidden" name="ImageFileName" value="<?= $row['ImageFileName'] ?>">
                                    <input type="hidden" name="YearOfWork" value="<?= $row['YearOfWork'] ?>">
                                    <input type="hidden" value="Add to Favorites">
                                </form>
                            </td>
                            <td><button><a href="single-painting.php?id=<?= $row['PaintingID'] ?>">View</a></button></td>
                    <?php
                    }
                    mysqli_close($conn);
                } ?>
            </table>
        </section>
    </main>
</body>

</html>