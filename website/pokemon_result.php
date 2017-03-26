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
    <h4><a href="pokemon.php"><font color = "000000">Go back...</font></a><br></h4>
</div1>
<div id="result" style="height: 400px; overflow-y:auto; overflow-x:hidden;">
    <?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    if ($_COOKIE["pokemon_inquiry_type"] == 1) {
        $result = mysqli_query($server, "SELECT P.* FROM POKEMON P WHERE P.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 2) {
        $result = mysqli_query($server, "SELECT DISTINCT P.* FROM POKEMON P JOIN TYPE T1 JOIN TYPE T2 WHERE (P.TYPE1_ID = T1.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\") OR (P.TYPE2_ID = T2.ID AND T2.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\");");

        $resultCount = mysqli_query($server, "SELECT COUNT(DISTINCT P.POKEDEX_NO) AS COUNTED FROM POKEMON P JOIN TYPE T1 JOIN TYPE T2 WHERE (P.TYPE1_ID = T1.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\") OR (P.TYPE2_ID = T2.ID AND T2.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\");");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " Pokemon of type " . $_COOKIE["pokemon_inquiry"] . ".</b><br><br>";
        }
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 3) {
        $result = mysqli_query($server, "SELECT P.* FROM POKEMON P ORDER BY P.POKEDEX_NO;");

        $resultCount = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED FROM POKEMON P;");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " Pokemon.</b><br><br>";
        }
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 4) {
        $result = mysqli_query($server, "SELECT P.* FROM POKEMON P WHERE P.TYPE2_ID IS NULL;");

        $resultCount = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED FROM POKEMON P WHERE P.TYPE2_ID IS NULL;");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " Pokemon with only one type.</b><br><br>";
        }
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 5) {
        $result = mysqli_query($server, "SELECT P.* FROM POKEMON P WHERE P.TYPE2_ID IS NOT NULL;");

        $resultCount = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED FROM POKEMON P WHERE P.TYPE2_ID IS NOT NULL;");
        if (mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            echo "<b>Found " . $rowCount["COUNTED"] . " Pokemon with two types.</b><br><br>";
        }
    }
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            ?><img src="http://pokedream.com/pokedex/images/sugimori/<?php
                if ($row["POKEDEX_NO"] < 10) {echo "00".$row["POKEDEX_NO"];}
                elseif ($row["POKEDEX_NO"] < 100) {echo "0".$row["POKEDEX_NO"];}
                else {echo $row["POKEDEX_NO"];}
                ?>.jpg" alt="<?php echo $row["NAME"] ?>" height="100"><br><?php
            echo "<b>No:</b> " . $row["POKEDEX_NO"] . "<br>";
            echo "<b>Name:</b> " . $row["NAME"] . "<br>";

            $resultT1 = mysqli_query($server, "SELECT T.NAME FROM POKEMON P JOIN TYPE T WHERE T.ID = P.TYPE1_ID AND P.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            $rowT1 = mysqli_fetch_assoc($resultT1);
            $resultT2 = mysqli_query($server, "SELECT T.NAME FROM POKEMON P JOIN TYPE T WHERE T.ID = P.TYPE2_ID AND P.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            if($rowT2 = mysqli_fetch_assoc($resultT2)) {
                echo "<b>Type 1:</b> " . $rowT1["NAME"] . "<br>";
                echo "<b>Type 2:</b> " . $rowT2["NAME"] . "<br>";
            } else {
                echo "<b>Type:</b> " . $rowT1["NAME"] . "<br>";
            }

            echo "<b>Weight:</b> " . $row["WEIGHT"] . " kg<br>";
            echo "<b>Height:</b> " . $row["HEIGHT"] . " m<br>";

            $resultE1 = mysqli_query($server, "SELECT E.*,P1.NAME FROM POKEMON P1 JOIN POKEMON P2 JOIN NEXT_EVO E WHERE E.POKEDEX_NO = P1.POKEDEX_NO AND E.POKEDEX_NO_NEXT = P2.POKEDEX_NO AND P2.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            if($rowE1 = mysqli_fetch_assoc($resultE1)) {
                echo "<b>Evolved from</b> " . $rowE1["NAME"] . "<br>";
                if($rowE1["LEVEL"] != NULL) {echo "<b>Evolved at level</b> " . $rowE1["LEVEL"] . "<br>";}
                if($rowE1["STONE_ID"] != NULL) {
                    $resultES1 = mysqli_query($server, "SELECT S.NAME FROM STONE S WHERE S.ID = " . $rowE1["STONE_ID"] .";");
                    $rowES1 = mysqli_fetch_assoc($resultES1);
                    echo "<b>Evolved with</b> " . $rowES1["NAME"] . "<br>";
                }
                if($rowE1["TRADE_EVO"]) {echo "<b>Evolved with trade</b><br>";}
            }

            $resultE2 = mysqli_query($server, "SELECT E.*,P2.NAME FROM POKEMON P1 JOIN POKEMON P2 JOIN NEXT_EVO E WHERE E.POKEDEX_NO = P1.POKEDEX_NO AND E.POKEDEX_NO_NEXT = P2.POKEDEX_NO AND P1.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            if($rowE2 = mysqli_fetch_assoc($resultE2)) {
                echo "<b>Evolves to</b> " . $rowE2["NAME"] . "<br>";
                if($rowE2["LEVEL"] != NULL) {echo "<b>Evolves at level</b> " . $rowE2["LEVEL"] . "<br>";}
                if($rowE2["STONE_ID"] != NULL) {
                    $resultES2 = mysqli_query($server, "SELECT S.NAME FROM STONE S WHERE S.ID = " . $rowE2["STONE_ID"] .";");
                    $rowES2 = mysqli_fetch_assoc($resultES2);
                    echo "<b>Evolves with</b> " . $rowES2["NAME"] . "<br>";
                }
                if($rowE2["TRADE_EVO"]) {echo "<b>Evolves with trade</b><br>";}
            }

            $resultX1 = mysqli_query($server, "SELECT P.POKEDEX_NO FROM POKEMON P JOIN STARTER_POKEMON X WHERE P.POKEDEX_NO = X.POKEDEX_NO AND X.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            if (mysqli_num_rows($resultX1) > 0) {echo "<b>Starter</b><br>";}

            $resultX2 = mysqli_query($server, "SELECT P.POKEDEX_NO FROM POKEMON P JOIN LEGENDARY_POKEMON X WHERE P.POKEDEX_NO = X.POKEDEX_NO AND X.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            if (mysqli_num_rows($resultX2) > 0) {echo "<b>Legendary</b><br>";}

            $resultX3 = mysqli_query($server, "SELECT P.POKEDEX_NO FROM POKEMON P JOIN ENGINEERED_POKEMON X WHERE P.POKEDEX_NO = X.POKEDEX_NO AND X.POKEDEX_NO = " . $row["POKEDEX_NO"] . ";");
            if (mysqli_num_rows($resultX3) > 0) {echo "<b>Engineered</b><br>";}

            echo "<br><br>";
        }
    } else {
        echo "No Pokemon found.<br><br>";
    }

    mysqli_close($server);
    ?>
</div>
</body>
</html>