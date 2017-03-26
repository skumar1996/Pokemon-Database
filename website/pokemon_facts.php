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
<div id="result" style="height: 315px; width: 550px; overflow-y:auto; overflow-x:hidden;">
    <?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    $result = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED FROM POKEMON P;");
    $row = mysqli_fetch_assoc($result);
    echo "<b>There are " . $row["COUNTED"] . " Pokemon.</b><br><br>";

    $result2 = mysqli_query($server, "SELECT COUNT(DISTINCT P.POKEDEX_NO) AS COUNTED FROM POKEMON P JOIN NEXT_EVO E WHERE P.POKEDEX_NO = E.POKEDEX_NO;");
    $row2 = mysqli_fetch_assoc($result2);
    echo "<b>There are " . $row2["COUNTED"] . " Pokemon with evolutions.</b><br>";
    echo "<b>There are " . ($row["COUNTED"]-$row2["COUNTED"]) . " Pokemon without evolutions.</b><br>";

    $result2 = mysqli_query($server, "SELECT COUNT(DISTINCT P.POKEDEX_NO) AS COUNTED FROM POKEMON P JOIN NEXT_EVO E WHERE P.POKEDEX_NO = E.POKEDEX_NO AND E.STONE_ID IS NOT NULL;");
    $row2 = mysqli_fetch_assoc($result2);
    echo "<b>There are " . $row2["COUNTED"] . " Pokemon with evolutions that require evolutionary stones.</b><br>";
    $result2 = mysqli_query($server, "SELECT COUNT(DISTINCT P.POKEDEX_NO) AS COUNTED FROM POKEMON P JOIN NEXT_EVO E WHERE P.POKEDEX_NO = E.POKEDEX_NO AND E.TRADE_EVO = 1;");
    $row2 = mysqli_fetch_assoc($result2);
    echo "<b>There are " . $row2["COUNTED"] . " Pokemon with evolutions that require trading.</b><br><br>";

    $result = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED, T.NAME FROM POKEMON P JOIN TYPE T WHERE (P.TYPE1_ID = T.ID) OR (P.TYPE2_ID = T.ID) GROUP BY T.NAME;");
    while($row = mysqli_fetch_assoc($result)) {
        echo "<b>There are " . $row["COUNTED"] . " Pokemon of type " . $row["NAME"] . ".</b><br>";
    }
    echo "<br>";

    $result = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED FROM POKEMON P WHERE P.TYPE2_ID IS NULL;");
    $row = mysqli_fetch_assoc($result);
    echo "<b>There are " . $row["COUNTED"] . " Pokemon with only one type.</b><br>";
    $result = mysqli_query($server, "SELECT COUNT(P.POKEDEX_NO) AS COUNTED FROM POKEMON P WHERE P.TYPE2_ID IS NOT NULL;");
    $row = mysqli_fetch_assoc($result);
    echo "<b>There are " . $row["COUNTED"] . " Pokemon with two types.</b><br><br>";

    $result = mysqli_query($server, "SELECT ROUND(AVG(P.WEIGHT),2) AS AVGW FROM POKEMON P;");
    $row = mysqli_fetch_assoc($result);
    echo "<b>Average Pokemon weight is " . $row["AVGW"] . " kg.</b><br>";
    $result2 = mysqli_query($server, "SELECT ROUND(AVG(P.WEIGHT),2) AS AVGW,T.NAME FROM POKEMON P JOIN TYPE T WHERE (P.TYPE1_ID = T.ID) OR (P.TYPE2_ID = T.ID) GROUP BY T.NAME;");
    while($row2 = mysqli_fetch_assoc($result2)) {
        echo "<b>Average Pokemon weight of type " . $row2["NAME"] . " is " . $row2["AVGW"] . " kg.</b><br>";
    }
    echo "<br>";

    $result = mysqli_query($server, "SELECT ROUND(AVG(P.HEIGHT),2) AS AVGH FROM POKEMON P;");
    $row = mysqli_fetch_assoc($result);
    echo "<b>Average Pokemon height is " . $row["AVGH"] . " m.</b><br>";
    $result2 = mysqli_query($server, "SELECT ROUND(AVG(P.HEIGHT),2) AS AVGH,T.NAME FROM POKEMON P JOIN TYPE T WHERE (P.TYPE1_ID = T.ID) OR (P.TYPE2_ID = T.ID) GROUP BY T.NAME;");
    while($row2 = mysqli_fetch_assoc($result2)) {
        echo "<b>Average Pokemon height of type " . $row2["NAME"] . " is " . $row2["AVGH"] . " m.</b><br>";
    }
    echo "<br>";

    mysqli_close($server);
    ?>
</div>
</body>
</html>