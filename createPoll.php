<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creating poll...</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="bulma-0.7.2/css/bulma.min.css">
    <link rel="stylesheet" href="bulma-0.7.2/css/bulma-checkradio.min.css">
    <link rel="stylesheet" href="fontawesome-free-5.5.0-web/css/all.min.css">
	<link rel="stylesheet" href="roboto.css">
	<script type="text/javascript" src="jquery-3.3.1.js"></script>
	<style type="text/css">
		html
		{
  			background: url(back.png) no-repeat center center fixed; 
  			-webkit-background-size: cover;
  			-moz-background-size: cover;
  			-o-background-size: cover;
  			background-size: cover;
		}
		body
		{
			font-family: 'Roboto', sans-serif;
		}
		.center
		{
			display: block;
    		margin-left: auto;
    		margin-right: auto;
    		width: 30%;
		}
	</style>
</head>
<body>
	<?php
	echo '<br><br><img src="loading.svg" class="center">';

	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "polls";

	$conn = mysqli_connect($servername, $username, $password, $database);

	if (!$conn)	die("Connection failed: ".mysqli_connect_error());

	$question = $_POST["question"];
	$options=0;
	$op_data="";
	foreach ($_POST as $key=>$value)
	{
		if(substr($key,0,6)==="option" && trim($value))
		{
			$options=$options+1;
			$op_data=$op_data.$value."[0]\r\n";
		}
	}
	$op_data=(string)$options."\r\n".$op_data;
	$op_data=substr($op_data,0,-2);

	if(!trim($question) && $options<2)
	{
		echo '<p style="color:red">Please fill out the question and atleast two options. Redirecting...</p>';
		header("refresh:2;url=/make-a-poll");
	}

	$creation_time=time();
	$expiry=0;
	$limit=0;
	$private=0;
	if(isset($_POST["private"]))
		$private=1;
	if(isset($_POST["expiry"]) && $_POST["expiry"]==="on")
		$expiry=$_POST["expiryHours"];
	if(isset($_POST["limit"]) && $_POST["limit"]==="on")
		$limit=$_POST["limitValue"];

	mysqli_query($conn, "INSERT INTO polls(ID,CreationTime, Question, Options, ExpiryTime, Votes, Private, VoteLimit) VALUES (NULL, ".$creation_time.",\"".$question."\",\"".$op_data."\",".$expiry.",0,".$private.",".$limit.")");

	$id = mysqli_query($conn,'SELECT * FROM polls');
	header("refresh:1;url=/make-a-poll/poll.php?id=".$id->num_rows);

	mysqli_close($conn);
	?>
<br>
</body>
</html>