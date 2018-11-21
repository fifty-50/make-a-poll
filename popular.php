<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Popular Polls</title>
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
    	.navbar.is-warning
    	{
      		background-color: #FFFF56;
   		}
   		.box
   		{
   			background-color: #DDFFFD;
   			-webkit-touch-callout: none;
    		-webkit-user-select: none;
    		-khtml-user-select: none;
   			-moz-user-select: none;
    		-ms-user-select: none;
    		user-select: none;
    		cursor: pointer;
   		}
   		.box:hover
   		{
   			background-color: #77fff7;
   		}
   		#share-buttons img
   		{
			width: 35px;
			padding: 5px;
			border: 0;
			box-shadow: 0;
			display: inline;
		}
		body
		{
			font-family: 'Roboto', sans-serif;
		}
		.header
		{
  			overflow: hidden;
  			background-color: #000;
  			padding: 10px 10px;
		}
		.header .logo
		{
  			font-size: 20px;
  			text-align: center;
  			color: yellow;
  			-webkit-touch-callout: none;
    		-webkit-user-select: none;
    		-khtml-user-select: none;
   			-moz-user-select: none;
    		-ms-user-select: none;
    		user-select: none;
		}
		#Up
		{
			opacity: 0.6;
    		display: none;
    		position: fixed;
    		bottom: 20px;
    		right: 30px;
    		z-index: 99;
    		border: 2px solid black;
    		background-color: yellow;
    		color: black;
    		cursor: pointer;
    		padding: 15px;
    		border-radius: 10px;
		}
		#Up:hover
		{
			opacity: 1;
		}
		.title:not(.is-spaced) + .subtitle
		{
			margin-bottom: 0.5rem;
		}
	</style>
</head>
<body>
	<div class="header"><center><div class="logo"><span class="icon"><i class="fas fa-poll-h"></i>&nbsp;</span>Make-a-Poll</div></center></div>
	<nav class="navbar is-warning" role="navigation" aria-label="main navigation">
    	<div class="navbar-brand">
			<a class="navbar-item" href="/make-a-poll/main.html"><span class="icon"><i class="fas fa-home"></i></span>&nbsp;Make-a-Poll</a>
			<a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbar">
			  <span aria-hidden="true"></span>
			  <span aria-hidden="true"></span>
			  <span aria-hidden="true"></span>
			</a>
		</div>
		<div id="navbar" class="navbar-menu">
			<div class="navbar-start">
			   	<a class="navbar-item" href="popular.php" style="background-color: #FBFBFB;color: red""><span class="icon"><i class="fab fa-hotjar"></i></span>&nbsp;Popular polls</a>
    	  		<a class="navbar-item" href="recent.php"><span class="icon"><i class="fas fa-history"></i></span>&nbsp;Recent polls</a>
    	  		<a class="navbar-item" href="stats.php"><span class="icon"><i class="fas fa-chart-bar"></i></span>&nbsp;Statistics</a>
			   	<a class="navbar-item" href="about.html"><span class="icon"><i class="fas fa-info-circle"></i></span>&nbsp;About</a>
			</div>
		</div>
	</nav>
	<br>
  	<div class="columns">
    	<div class="column is-narrow"></div>
    	<div class="column">
    		<?php
    			$servername = "localhost";
			    $username = "root";
			    $password = "";
			    $database = "polls";

			    $conn = mysqli_connect($servername, $username, $password, $database);

			    if (!$conn) die("Connection failed: ".mysqli_connect_error());

			    $result=mysqli_query($conn,"SELECT ID, CreationTime, Question, Options, ExpiryTime, Votes, Private, VoteLimit FROM polls WHERE Private=0 ORDER BY polls.Votes DESC, polls.CreationTime DESC");
    			while ($row=mysqli_fetch_assoc($result))
    				echo '<div class="box" onclick="goto('.$row['ID'].')"><p class="title is-4">'.$row['Question'].'</p><p class="subtitle is-7">Votes: '.$row['Votes'].'&nbsp;&nbsp;|&nbsp;&nbsp;Created on '.date('D, d M Y ', $row['CreationTime']).'at'.date(' h:i a', $row['CreationTime']).'</p></div>';
    		?>
    		<script type="text/javascript">
    			$(document).ready(function()
				{
					$(".navbar-burger").click(function()
					{
	      				$(".navbar-burger").toggleClass("is-active");
	      				$(".navbar-menu").toggleClass("is-active");
	  				});
				});

    			window.onscroll = function(){scrollFunction()};

				function scrollFunction()
				{
				    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20)
				        $("#Up").fadeIn();
				    else
				        $("#Up").fadeOut();
				}

				function topFunction()
				{
        			$("html").animate({ scrollTop: 0 }, "slow");
				}

				function goto(id)
				{
					window.location.href='/make-a-poll/poll.php?id='+id;
				}
    		</script>
   			<button onclick="topFunction()" id="Up"><font size="4"><span class="icon"><i class="fas fa-arrow-up"></i></span></font></button> 
    	</div>
    	<div class="column is-narrow"></div>
	</div>
</body>
</html>