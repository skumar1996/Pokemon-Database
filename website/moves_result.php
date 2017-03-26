<!DOCTYPE html>
<html>
<head>
	<title>The Pokemon Database</title>
</head>
<link rel="stylesheet" type="text/css" href="pokemon_database.css">
<body background = "http://cdn.wallpapersafari.com/55/44/tvlMso.jpg">
<p>
	<b>Databases and Web Applications Project</b>
	<br><b>Generation One Pokedex</b>
</p>
<p1>
	<br><br><br><br> 
	<a href="homepage.html"><b>Home</b></a>
	<br> <br>
	<a href="pokemon.php"><b>Pokemon</b></a>
	<br> <br>
	<a href="types.php"><b>Types</b></a>
	<br> <br>
	<a href="stones.php"><b>Stones</b></a>
	<br> <br>
	<a href="gyms.php"><b>Gyms</b></a>
	<br> <br>
	<a href="pokeballs.php"><b>PokeBalls</b></a>
	<br> <br>
	<a href="moves.php"><b>Moves</b></a>
	<br> <br>
	<a href="imprint.html"><b>Imprint</b></a>
	<br><br><br><br><br><br><br><br><br><br><br>
	<i>
	By:<br>
	Inti Mendoza<br>Sagar Kumar<br>Ozan Kaya
	</i>
</p1>
<?php include("db_user.php") ?>
<div1 id="back">
    <h4><a href="moves.php"><font color = "000000">Go back...</font></a><br></h4>
</div1>
<div id="result" style="height: 350px; overflow-y:auto; overflow-x:hidden;">
    <?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    if ($_COOKIE["pokemon_inquiry_type"] == 1) {
        $result = mysqli_query($server, "SELECT M.* FROM MOVE M WHERE M.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 2) {
        $result = mysqli_query($server, "SELECT M.* FROM MOVE M JOIN TYPE T WHERE M.TYPE_ID = T.ID AND T.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");

        $resultCount = mysqli_query($server, "SELECT COUNT(M.ID) AS COUNTED FROM MOVE M JOIN TYPE T WHERE M.TYPE_ID = T.ID AND T.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " moves of type " . $_COOKIE["pokemon_inquiry"] . ".</b><br><br>";
        }
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 3) {
        $result = mysqli_query($server, "SELECT M.* FROM MOVE M JOIN CATEGORY C WHERE M.CATEGORY_ID = C.ID AND C.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");

        $resultCount = mysqli_query($server, "SELECT COUNT(M.ID) AS COUNTED FROM MOVE M JOIN CATEGORY C WHERE M.CATEGORY_ID = C.ID AND C.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " moves of category " . $_COOKIE["pokemon_inquiry"] . ".</b><br><br>";
        }
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 4) {
        $result = mysqli_query($server, "SELECT M.* FROM MOVE M;");

        $resultCount = mysqli_query($server, "SELECT COUNT(M.ID) AS COUNTED FROM MOVE M;");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " moves.</b><br><br>";
        }
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 5) {
        $result = mysqli_query($server, "SELECT M.* FROM MOVE M JOIN TM TM WHERE M.ID = TM.MOVE_ID ORDER BY TM.ID;");

        $resultCount = mysqli_query($server, "SELECT COUNT(TM.ID) AS COUNTED FROM TM TM;");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " moves that can be taught with TMs.</b><br><br>";
        }
    }
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<b>Name:</b> " . $row["NAME"] . "<br>";

            $resultT = mysqli_query($server, "SELECT T.NAME FROM MOVE M JOIN TYPE T WHERE T.ID = M.TYPE_ID AND M.ID = " . $row["ID"] . ";");
            $rowT = mysqli_fetch_assoc($resultT);
            echo "<b>Type:</b> " . $rowT["NAME"] . "<br>";

            $resultC = mysqli_query($server, "SELECT C.NAME FROM MOVE M JOIN CATEGORY C WHERE C.ID = M.CATEGORY_ID AND M.ID = " . $row["ID"] . ";");
            $rowC = mysqli_fetch_assoc($resultC);
            echo "<b>Category:</b> " . $rowC["NAME"] . "<br>";

            $resultTM = mysqli_query($server, "SELECT TM.ID FROM MOVE M JOIN TM TM WHERE M.ID = TM.MOVE_ID AND M.ID = " . $row["ID"] . ";");
            if ($rowTM = mysqli_fetch_assoc($resultTM))
            {echo "<b>Can be taught by TM</b> " . $rowTM["ID"] . "<br>";}

            echo "<br>";
        }
    } else {
        echo "No moves found.<br><br>";
    }

    mysqli_close($server);
    ?>
</div>
</body>
</html>