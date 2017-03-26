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
    <h4><a href="pokeballs.php"><font color = "000000">Go back...</font></a><br></h4>
</div1>
<div id="result" style="height: 250px; overflow-y:auto; overflow-x:hidden;">
    <?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    if ($_COOKIE["pokemon_inquiry_type"] == 1) {
    	$result = mysqli_query($server, "SELECT B.* FROM POKEBALL B WHERE B.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 2) {
    	$result = mysqli_query($server, "SELECT B.* FROM POKEBALL B;");
    }
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
	        switch($row["ID"]) {
	         case 1: echo "<img src=\"http://cdn.bulbagarden.net/upload/9/93/Bag_Pok%C3%A9_Ball_Sprite.png\" alt=\"" . $row["NAME"] . "\" height=\"40\">"; break;
	         case 2: echo "<img src=\"http://cdn.bulbagarden.net/upload/c/ca/Bag_Great_Ball_Sprite.png\" alt=\"" . $row["NAME"] . "\" height=\"40\">"; break;
	         case 3: echo "<img src=\"http://cdn.bulbagarden.net/upload/0/03/Bag_Ultra_Ball_Sprite.png\" alt=\"" . $row["NAME"] . "\" height=\"40\">"; break;
	         case 4: echo "<img src=\"http://cdn.bulbagarden.net/upload/6/6d/Bag_Master_Ball_Sprite.png\" alt=\"" . $row["NAME"] . "\" height=\"40\">"; break;
	         case 5: echo "<img src=\"http://cdn.bulbagarden.net/upload/e/eb/Bag_Safari_Ball_Sprite.png\" alt=\"" . $row["NAME"] . "\" height=\"40\">"; break;
	        }
	        echo "<br>";
	        echo "<b>Name:</b> " . $row["NAME"] . "<br>";
	        echo "<b>Catch rate:</b> " . $row["CATCH_RATE"] . "x<br>";
	        echo "<br><br>";
	    }
    } else {
        echo "No PokeBall found.<br><br>";
    }

    mysqli_close($server);
    ?>
</div>
</body>
</html>