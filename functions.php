<?php

	//functions.php
	
	//alustan sessiooni, et saks kasutada $_SESSION muutujaid
	session_start();
	
	//SIGNUP
	$database="if16_mariiviita";
	function signup ($Email, $password){
		
		//ühendus
		$mysqli=new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//käsk
		$stmt=$mysqli->prepare("INSERT INTO user_sample (Email, password) VALUES(?,?)");
		
		echo $mysqli->error;
		
		//asendan küsimärgi väärtustega
		//iga muutuja kohta üks täht, mis tüüpi muutuja on
		//s-stringi
		//i-integer
		//d-double/float
		$stmt->bind_param("ss",$Email, $password);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
			
		} else {
				echo "ERROR ".$stmt->error;
		
		}
			
	}
	
	function login($Email, $password){
		
		$error="";
		
		$mysqli=new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt=$mysqli->prepare("
		
			SELECT id, Email, password, created
			FROM user_sample
			WHERE Email=?
						
		");
			
		echo $mysqli->error;
		
		// asendan küsimärgi
		
		$stmt->bind_param("s", $Email);
		
		//määran tulpadele muutujad
		$stmt->bind_result($id, $EmailFromDB, $passwordFromDB, $created);
		
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()) {
			//oli rida
			//võrdlen paroole
			$hash=hash("sha512", $password);
			if ($hash==$passwordFromDB) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				$_SESSION["userId"]=$id;
				$_SESSION["Email"]=$EmailFromDB;
				
				//suunaks uuele lehele
				header("Location: data.php");
				
				
			} else {
				$error="parool vale";
			}
					
		} else {
			//ei olnud
			
			$error="sellise emailiga ".$Email." kasutajat ei olnud";
			
		}
		
		
		return $error;
		
		
	}
	
	
	/*function sum ($x,$y) {
		
		return $x+$y;
	}
	
	echo sum(4546278234,758349272);
	echo "<br>";
	$answer=sum(10,15);
	echo $answer;
	echo "<br>";
	
	function hello ($firstname,$lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
	echo hello("Marii", "V.");
	}
?>*/