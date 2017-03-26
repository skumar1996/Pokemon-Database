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
    <h4><a href="types.php"><font color = "000000">Go back...</font></a><br></h4>
</div1>
<div id="result" style="height: 500px; overflow-y:auto; overflow-x:hidden;">
    <?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    if ($_COOKIE["pokemon_inquiry_type"] == 1) {
    	echo "<b>Attack:</b> " . $_COOKIE["pokemon_inquiry1"] . "<br>";
    	echo "<b>Defense:</b> " . $_COOKIE["pokemon_inquiry2"] . "<br>";

    	$result1 = mysqli_query($server, "SELECT T1.NAME AS NAME1, T2.NAME AS NAME2 FROM TYPE T1 JOIN TYPE T2 JOIN NO_EFFECT_AGAINST VS WHERE VS.TYPE_ID_1 = T1.ID AND VS.TYPE_ID_2 = T2.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry1"] . "\" and T2.NAME = \"" . $_COOKIE["pokemon_inquiry2"] . "\";");
    	if (mysqli_num_rows($result1) > 0) {echo $_COOKIE["pokemon_inquiry1"] . " has no effect against " . $_COOKIE["pokemon_inquiry2"] . ".<br>";}
    	$result2 = mysqli_query($server, "SELECT T1.NAME AS NAME1, T2.NAME AS NAME2 FROM TYPE T1 JOIN TYPE T2 JOIN NOT_VERY_EFFECTIVE_AGAINST VS WHERE VS.TYPE_ID_1 = T1.ID AND VS.TYPE_ID_2 = T2.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry1"] . "\" and T2.NAME = \"" . $_COOKIE["pokemon_inquiry2"] . "\";");
    	if (mysqli_num_rows($result2) > 0) {echo $_COOKIE["pokemon_inquiry1"] . " is not very effective against " . $_COOKIE["pokemon_inquiry2"] . ".<br>";}
    	$result3 = mysqli_query($server, "SELECT T1.NAME AS NAME1, T2.NAME AS NAME2 FROM TYPE T1 JOIN TYPE T2 JOIN SUPER_EFFECTIVE_AGAINST VS WHERE VS.TYPE_ID_1 = T1.ID AND VS.TYPE_ID_2 = T2.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry1"] . "\" and T2.NAME = \"" . $_COOKIE["pokemon_inquiry2"] . "\";");
    	if (mysqli_num_rows($result3) > 0) {echo $_COOKIE["pokemon_inquiry1"] . " is super effective against " . $_COOKIE["pokemon_inquiry2"] . ".<br>";}
    	if (!(mysqli_num_rows($result1) > 0 || mysqli_num_rows($result2) > 0 || mysqli_num_rows($result3) > 0))
        {echo $_COOKIE["pokemon_inquiry1"] . " is normal against " . $_COOKIE["pokemon_inquiry2"] . ".<br>";}

    } elseif ($_COOKIE["pokemon_inquiry_type"] == 2) {
    	echo "<b>Attack:</b> " . $_COOKIE["pokemon_inquiry"] . "<br>";
        echo "<b>Defense:</b> " . "any" . "<br>";

        $result1 = mysqli_query($server, "SELECT T1.NAME AS NAME1, T2.NAME AS NAME2 FROM TYPE T1 JOIN TYPE T2 JOIN NO_EFFECT_AGAINST VS WHERE VS.TYPE_ID_1 = T1.ID AND VS.TYPE_ID_2 = T2.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
        if (mysqli_num_rows($result1) > 0) {
        	while($row1 = mysqli_fetch_assoc($result1)) {
        		echo $row1["NAME1"] . " has no effect against " . $row1["NAME2"] . ".<br>";
        	}
        }
        $result2 = mysqli_query($server, "SELECT T1.NAME AS NAME1, T2.NAME AS NAME2 FROM TYPE T1 JOIN TYPE T2 JOIN NOT_VERY_EFFECTIVE_AGAINST VS WHERE VS.TYPE_ID_1 = T1.ID AND VS.TYPE_ID_2 = T2.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
        if (mysqli_num_rows($result2) > 0) {
        	while($row2 = mysqli_fetch_assoc($result2)) {
        		echo $row2["NAME1"] . " is not very effective against " . $row2["NAME2"] . ".<br>";
        	}
        }
        $result3 = mysqli_query($server, "SELECT T1.NAME AS NAME1, T2.NAME AS NAME2 FROM TYPE T1 JOIN TYPE T2 JOIN SUPER_EFFECTIVE_AGAINST VS WHERE VS.TYPE_ID_1 = T1.ID AND VS.TYPE_ID_2 = T2.ID AND T1.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
        if (mysqli_num_rows($result3) > 0) {
        	while($row3 = mysqli_fetch_assoc($result3)) {
        		echo $row3["NAME1"] . " is super effective against " . $row3["NAME2"] . ".<br>";
        	}
        }
        if (!(mysqli_num_rows($result1) > 0 || mysqli_num_rows($result2) > 0 || mysqli_num_rows($result3) > 0))
            {echo "No type found.<br><br>";}
    }

	mysqli_close($server);
    ?>
</div>
</body>
</html>