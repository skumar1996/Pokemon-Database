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
    <h4><a href="gyms.php"><font color = "000000">Go back...</font></a><br></h4>
</div1>
<div id="result" style="height: 350px; overflow-y:auto; overflow-x:hidden;">
    <?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    if ($_COOKIE["pokemon_inquiry_type"] == 1) {
        $result = mysqli_query($server, "SELECT G.* FROM GYM G WHERE G.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 2) {
        $result = mysqli_query($server, "SELECT G.* FROM GYM G JOIN GYM_LEADER L JOIN BADGE B WHERE G.ID = L.GYM_ID AND L.BADGE_ID = B.ID AND B.NAME = \"" . $_COOKIE["pokemon_inquiry"] . "\";");
    } elseif ($_COOKIE["pokemon_inquiry_type"] == 3) {
        $result = mysqli_query($server, "SELECT G.* FROM GYM G;");
    }
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $resultT = mysqli_query($server, "SELECT T.NAME FROM TOWN T JOIN GYM G WHERE T.ID = G.TOWN_ID AND G.ID = " . $row["ID"] . ";");
            $rowT = mysqli_fetch_assoc($resultT);
            $resultL = mysqli_query($server, "SELECT L.* FROM GYM_LEADER L JOIN GYM G WHERE L.GYM_ID = G.ID AND G.ID = " . $row["ID"] . ";");
            $rowL = mysqli_fetch_assoc($resultL);
            $resultL2 = mysqli_query($server, "SELECT L2.* FROM TRAINER L2 JOIN GYM_LEADER L WHERE L2.ID = L.ID AND L.ID = " . $rowL["ID"] . ";");
            $rowL2 = mysqli_fetch_assoc($resultL2);
            $resultB = mysqli_query($server, "SELECT B.* FROM BADGE B JOIN GYM_LEADER L WHERE B.ID = L.BADGE_ID AND L.ID = " . $rowL["ID"] . ";");
            $rowB = mysqli_fetch_assoc($resultB);
            $resultBT  = mysqli_query($server, "SELECT T.NAME FROM BADGE B JOIN TYPE T WHERE T.ID = B.TYPE_ID AND B.TYPE_ID = " . $rowB["TYPE_ID"] . ";");
            $rowBT = mysqli_fetch_assoc($resultBT);

            switch($rowB["ID"]) {
             case 1: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/d/dd/Boulder_Badge.png/75px-Boulder_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 2: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/9/9c/Cascade_Badge.png/75px-Cascade_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 3: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/a/a6/Thunder_Badge.png/75px-Thunder_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 4: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/b/b5/Rainbow_Badge.png/75px-Rainbow_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 5: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/7/7d/Soul_Badge.png/75px-Soul_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 6: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/6/6b/Marsh_Badge.png/75px-Marsh_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 7: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/1/12/Volcano_Badge.png/75px-Volcano_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
             case 8: echo "<img src=\"http://cdn.bulbagarden.net/upload/thumb/7/78/Earth_Badge.png/75px-Earth_Badge.png\" alt=\"" . $rowB["NAME"] . "\" height=\"80\">"; break;
            }
            echo "<br>";
            echo "<b>Name:</b> " . $row["NAME"] . "<br>";
            echo "<b>Location:</b> " . $rowT["NAME"] . "<br>";
            echo "<b>Leader:</b> " . $rowL2["NAME"] . "<br>";
            echo "<b>Badge given:</b> " . $rowB["NAME"] . "<br>";
            echo "<b>Represents type:</b> " . $rowBT["NAME"] . "<br>";

            $resultP = mysqli_query($server, "SELECT P.NAME,M.FIGHT_ORDER FROM POKEMON P JOIN MEMBER M JOIN ROSTER R JOIN TRAINER L2 WHERE P.POKEDEX_NO = M.POKEDEX_NO AND M.ROSTER_ID = R.ID AND R.ID = L2.ROSTER_ID AND L2.ID = " . $rowL2["ID"] . " ORDER BY M.FIGHT_ORDER;");
            echo "<b>Pokemon:</b><br>";
            while ($rowP = mysqli_fetch_assoc($resultP)) {
            	echo "<b>" . $rowP["FIGHT_ORDER"]. ".</b> " . $rowP["NAME"] . "<br>";
            }
            echo "<br><br>";
        }
    } else {
        echo "No gym found.<br><br>";
    }

    mysqli_close($server);
    ?>
</div>
</body>
</html>