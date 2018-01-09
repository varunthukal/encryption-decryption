<?php
	try{
	$stmt =  new PDO("mysql:host=localhost;dbname=nits", "root", "");
	$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();
			
		}
if ($_SERVER["REQUEST_METHOD"] === "POST"){

	$Pword = trim(isset($_POST['word']) ? strtolower($_POST['word']) : null );
	$md = sha1(strtolower($Pword));	
	
	$result = $stmt->query("SELECT word FROM sha where word = '$Pword'");
	$result = $result->fetch(PDO::FETCH_ASSOC);

	if($result['word'] == ""){
		$resultt = $stmt->exec("INSERT INTO sha(id,word,encrypted) VALUES(null,'$Pword','$md')");	
		$last_id = $stmt->lastInsertId();
		echo $last_id;
	}
} else if ($_GET) {
	if(isset($_GET['sha'])){

	$sha1 = trim($_GET['sha']);
	
	$result = $stmt->query("SELECT word FROM sha where encrypted = '$sha1'");
	$result = $result->fetch(PDO::FETCH_ASSOC);
	}
} 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Enc-Dec | Sha1 </title>
	</head>
<body><br /><br/>
<div class="conrainer">
	<form action="sha.php" method="POST" name="library">
		<div class="">
			<label for="word">Word</label>
			<input type="text" name="word" placeholder="Enter Word.." />
		</div>
		<div class="">
			<button type="submit" class="btn">Check</button>
		</div>
	</form>
</div><br /> 
	<?php 
		if($_POST){

			if($Pword != null || $Pword != ""){			
			echo "Sha1 for word ". $Pword. " is   " . $md ;	
			}
		}
	 ?>
 <br /> <br />
<div class="container">
	<!-- For sha1 string -->
	<form action="sha.php" method="GET" name="library">
		<div class="">
			<label for="md5">Sha1:</label>
			<input type="text" name="sha" placeholder="Enter sha1" />
		</div>
		<div class="">
			<button type="submit">Check Sha1</button>
		</div>
	</form>
</div>

<p>
<?php 
if(isset($_GET['sha'])){
if($result['word'] == ""){
		echo "No word found";
	} else{
		echo "word for " . $sha1. " is " . $result['word'];		
	}
}
?>
</p>
</body>
</html>

<!--
if(isset($_GET['mdd'])){
	$md = trim($_GET['mdd']);
	
	} 
	if(isset($_GET['sha1'])){
	$sha1 = trim($_GET['sha1']);
	
	}
	$md = trim($_GET['mdd']);
	-->