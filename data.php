<?php
	require("functions.php");
	
	//kas on sisse loginud, kui pole, siis suunata login lehele
	
	
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login4_tund.php");
	}
	
	//kas ?logout on aadressireal
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login4_tund.php");
		
	}



?>
<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["Name"];?>!
	<a href="?logout=1">Logi välja</a>
</p>