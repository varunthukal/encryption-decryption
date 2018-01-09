<?php
	try{
	$stmt =  new PDO("mysql:host=localhost;dbname=nits", "root", "");
	$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();
			
		}
if ($_SERVER["REQUEST_METHOD"] === "POST"){

	
	$Pword = trim(isset($_POST['word']) ? strtolower($_POST['word']) : null );
	$md = md5(strtolower($Pword));
	
	
	
	$result = $stmt->query("SELECT word FROM enc where word = '$Pword'");
	$result = $result->fetch(PDO::FETCH_ASSOC);

	if($result['word'] == ""){
		$resultt = $stmt->exec("INSERT INTO enc(id,word,encrypted) VALUES(null,'$Pword','$md')");	
		$last_id = $stmt->lastInsertId();
		echo $last_id;
	}
	

} else if ($_GET) {
	$md = trim($_GET['mdd']);
	$result = $stmt->query("SELECT word FROM enc where encrypted = '$md'");
	$result = $result->fetch(PDO::FETCH_ASSOC);
} 

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Form | Enc-Dec </title>
	</head>
<body><br /><br/>
<div class="conrainer">
	<form action="index.php" method="POST" name="library">
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
			
			echo "MD5 for word ". $Pword. " is   " . $md ;	
			}
		}

	 ?>
 <br /> <br />
<div class="container">
	<!-- For md5 string -->
	<form action="index.php" method="GET" name="library">
		<div class="">
			<label for="md5">MD5:</label>
			<input type="text" name="mdd" placeholder="Enter md5" />
		</div>
		<div class="">
			<button type="submit">Check MD5</button>
		</div>
	</form>
</div>

<p>
<?php 
if(isset($_GET['mdd'])){
if($result['word'] == ""){
		echo "No word found";
	} else{
		echo "word for " . $md. " is " . $result['word'];		
	}
}
?>
</p>
</body>
</html>