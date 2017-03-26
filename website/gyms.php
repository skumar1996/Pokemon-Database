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
<div id="search">
	<form method="get" id="GName">
	<b>Search a gym by name:<br></b>
	Name:&nbsp &nbsp &nbsp &nbsp
	<?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    $result = mysqli_query($server, "SELECT G.NAME FROM GYM G;");
    if (mysqli_num_rows($result) > 0) {
    ?>
	<select id="gyms" style="font-size: 90%; width: 169px">
		<?php while($row = mysqli_fetch_assoc($result)) { ?>
			<option value="<?php echo $row["NAME"] ?>"><?php echo $row["NAME"] ?></option>
		<?php } ?>
	</select>
	<?php } mysqli_close($server); ?>
	</form>
	&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp
	&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp
	&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp
	<button onclick="Gym_From_Name()">Submit</button>
	<form method="get" id="GBadge">
	<b><br>Search a gym by badge:<br></b>
	Badge:&nbsp &nbsp &nbsp &nbsp
	<?php
    $server = mysqli_connect("localhost", $db_user, $db_pass);
    if (!$server) {die("Connection failed: " . mysqli_connect_error());}
    mysqli_query($server, "USE pokedex;");

    $result = mysqli_query($server, "SELECT B.NAME FROM BADGE B;");
    if (mysqli_num_rows($result) > 0) {
    ?>
	<select id="badges" style="font-size: 90%; width: 169px">
		<?php while($row = mysqli_fetch_assoc($result)) { ?>
			<option value="<?php echo $row["NAME"] ?>"><?php echo $row["NAME"] ?></option>
		<?php } ?>
	</select>
	<?php } mysqli_close($server); ?>
	</form>
	&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp
	&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp
	&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp
	<button onclick="Gym_From_Badge()">Submit</button>
	<br><br>
	<a href="javascript:Gym_All();"><font color = "000000"><b>All gyms</b></font></a>
</div>
<script type="text/javascript" language="php">
	function createCookie(file,value) {
		var date = new Date();
		date.setTime(date.getTime() + 3600000);
		var expires = date.toUTCString();
		document.cookie = file + "=" + value + ";expires=" + expires + ";path=/;";
	}
	function Gym_From_Name() {
		var name = document.getElementById("GName").elements[0].value;
		createCookie("pokemon_inquiry_type",1);
		createCookie("pokemon_inquiry",name);
		window.location.href = "gyms_result.php";
	}
	function Gym_From_Badge() {
		var name = document.getElementById("GBadge").elements[0].value;
		createCookie("pokemon_inquiry_type",2);
		createCookie("pokemon_inquiry",name);
		window.location.href = "gyms_result.php";
	}
	function Gym_All() {
		createCookie("pokemon_inquiry_type",3);
		window.location.href = "gyms_result.php";
	}
</script>
</body>
</html>