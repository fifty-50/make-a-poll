<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Statistics</title>
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
    .fig
    {
      color: #000;
      background: #DDFFFD;
      text-align: center;
      border: 2px solid #e1e1e1;
      border-radius: 30px;
      display: inline-block;
      padding: 15px;
      width: 250px;
      -webkit-transition: all 1s ease;
      transition: all 0.2s ease;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .fig.link
    {
      cursor: pointer;
    }
    .fig.link:hover
    {
      background: #77fff7;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(function()
    {
      $(".navbar-burger").click(function()
      {
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");
      });
    });
    function topPoll(url)
    {
      window.location.href='poll.php?id='+url;
    }
  </script>
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
			   	<a class="navbar-item" href="popular.php"><span class="icon"><i class="fab fa-hotjar"></i></span>&nbsp;Popular polls</a>
    	  		<a class="navbar-item" href="recent.php"><span class="icon"><i class="fas fa-history"></i></span>&nbsp;Recent polls</a>
    	  		<a class="navbar-item" href="stats.php" style="background-color: #FBFBFB;color: red"><span class="icon"><i class="fas fa-chart-bar"></i></span>&nbsp;Statistics</a>
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

          echo '<div class="fig" style="width: 100%"><font size="30%">'.mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM polls"))[0].'</font><span><br>POLLS CREATED</span></div><br><br>';
          echo '<div class="fig" style="width: 49%"><font size="30%">'.mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM polls WHERE Private=0"))[0].'</font><span><br>PUBLIC POLLS</span></div>';
          echo '<div class="fig" style="width: 49%;float:right"><font size="30%">'.mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM polls  WHERE Private=1"))[0].'</font><span><br>PRIVATE POLLS</span></div><br><br>';
          echo '<div class="fig" style="width: 100%"><font size="30%">'.mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(Votes) FROM polls"))[0].'</font><span><br>VOTES CAST</span></div><br><br>';
          $topPoll=mysqli_fetch_array(mysqli_query($conn,"SELECT Question, Votes, ID FROM polls WHERE Private=0 ORDER BY polls.Votes DESC"));
          echo '<div class="fig link" style="width: 100%" onclick="topPoll('.$topPoll[2].')"><p class="title is-4">'.$topPoll[0].'</p><p class="subtitle is-7">'.$topPoll[1].' votes</p><span>MOST POPULAR POLL</span></div>';          
        ?>
    	</div>
    	<div class="column is-narrow"></div>
	</div>
</body>
</html>