<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>&#65279;</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="bulma-0.7.2/css/bulma.min.css">
    <link rel="stylesheet" href="bulma-0.7.2/css/bulma-checkradio.min.css">
    <link rel="stylesheet" href="fontawesome-free-5.5.0-web/css/all.min.css">
	<link rel="stylesheet" href="roboto.css">
	<script type="text/javascript" src="jquery-3.3.1.js"></script>
	<script type="text/javascript" src="jquery.qrcode.min.js"></script>
	<style type="text/css">
		html
		{ 
  			background: url(back.png) no-repeat center center fixed; 
  			-webkit-background-size: cover;
  			-moz-background-size: cover;
  			-o-background-size: cover;
  			background-size: cover;
  			display: none;
		}
    	.navbar.is-warning
    	{
      		background-color: #FFFF56;
   		}
   		.box
   		{
   			background-color: #DDFFFD;
   		}
   		#share-buttons img
   		{
			width: 50px;
			padding: 5px;
			border: 0;
			box-shadow: 0;
			display: inline;
		}
		#pollDat
		{
			-webkit-touch-callout: none;
    		-webkit-user-select: none;
    		-khtml-user-select: none;
   			-moz-user-select: none;
    		-ms-user-select: none;
    		user-select: none;
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
			   	<a class="navbar-item" href="popular.php"><span class="icon"><i class="fab fa-hotjar"></i></span>&nbsp;Popular polls</a>
    	  		<a class="navbar-item" href="recent.php"><span class="icon"><i class="fas fa-history"></i></span>&nbsp;Recent polls</a>
    	  		<a class="navbar-item" href="stats.php"><span class="icon"><i class="fas fa-chart-bar"></i></span>&nbsp;Statistics</a>
			   	<a class="navbar-item" href="about.html"><span class="icon"><i class="fas fa-info-circle"></i></span>&nbsp;About</a>
			</div>
		</div>
		<div class="navbar-end"></div>
	</nav>
  <br><br>
  <div class="columns">
    <div class="column is-narrow"></div>
    <div class="column">
     	<?php
     	$servername = "localhost";
		$username = "root";
		$password = "";
		$database = "polls";

		$conn = mysqli_connect($servername, $username, $password, $database);

		if (!$conn)	die("Connection failed: ".mysqli_connect_error());

		$result=mysqli_query($conn,"SELECT CreationTime, Question, Options, ExpiryTime, Votes, Private, VoteLimit FROM polls WHERE ID= ".$_GET['id']);
		$poll_data=mysqli_fetch_array($result,MYSQLI_ASSOC);

		echo '<div id="pollDat">';
		foreach($poll_data as $key=>$value)
    	{
    		echo $value;
    		if($key!=="VoteLimit")
    			echo "\r\n";
    	}
		echo '</div>';
     	?>
     	<script type="text/javascript">
     		$(document).ready(function()
			{
				$("#voteButton").prop('disabled','disabled');
				$(".navbar-burger").click(function()
				{
      				$(".navbar-burger").toggleClass("is-active");
      				$(".navbar-menu").toggleClass("is-active");
  				});
			});
			var dat=document.getElementById('pollDat');
			var pollInfo=dat.innerHTML.split('\n');
			if(pollInfo[pollInfo.length-4]==0&&pollInfo[pollInfo.length-1]==0)
				$("html").show();
			if(pollInfo[pollInfo.length-3]==pollInfo[pollInfo.length-1]&&pollInfo[pollInfo.length-1]!=0)
				Results();
			var creationTime=new Date(pollInfo[0] * 1000);
			var currentTime=Date.now();
			document.title=pollInfo[1];
			dat.innerHTML='<p class="title is-4">'+pollInfo[1]+'</p>'+'<p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString();
			if(pollInfo[pollInfo.length-4]!=0)
			{
				var exp=(currentTime - creationTime.getTime())/(1000*60*60);
				exp=String(exp).substr(0,String(exp).indexOf("."));
				exp=Number(pollInfo[pollInfo.length-4])-Number(exp);
				if(exp<1)
				{
					var id=window.location.href.substr(window.location.href.lastIndexOf('='));
					window.location.href="/make-a-poll/results.php?id"+id+"&exp=1";
				}
				if(exp>=1&&(pollInfo[pollInfo.length-1]==0||(pollInfo[pollInfo.length-1]!=0&&pollInfo[pollInfo.length-3]!=pollInfo[pollInfo.length-1])))
					$("html").show();
				if(exp==1)
					dat.innerHTML='<p class="title is-4">'+pollInfo[1]+'</p>'+'<p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString()+' | Voting closes in less than '+exp+' hour</p>';
				else
					dat.innerHTML='<p class="title is-4">'+pollInfo[1]+'</p>'+'<p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString()+' | Voting closes in less than '+exp+' hours</p>';
			}
			else if(pollInfo[pollInfo.length-1]==0||(pollInfo[pollInfo.length-1]!=0&&pollInfo[pollInfo.length-3]!=pollInfo[pollInfo.length-1]))
			{
				$("html").show();
			}
			for(var i=1;i<=pollInfo[2];i++)
			{
				var poll=document.createElement('div');
				poll.className='field';
				var pollOption=document.createElement('input');
				pollOption.className='is-checkradio is-small';
				pollOption.type='radio';
				pollOption.name='radios';
				var pollLabel=document.createElement('label');
				pollOption.id='Option'+i;
				var labelfor=document.createAttribute('for');
				labelfor.value='Option'+i;
				pollLabel.setAttributeNode(labelfor);
				var onin=document.createAttribute('oninput');
				onin.value='voteValid()';
				pollOption.setAttributeNode(onin);
				pollLabel.innerHTML='<font size="3">'+pollInfo[2+i].substr(0,pollInfo[2+i].lastIndexOf("["))+'</font>';
				poll.append(pollOption);
				poll.append(pollLabel);
				dat.append(poll);
			}
			dat.innerHTML='<div class="box">'+dat.innerHTML+'</div>';
			function voteValid()
			{
				$("#voteButton").prop('disabled',false);
			}
			function Vote()
			{
				var id=window.location.href.substr(window.location.href.lastIndexOf('='));
				for(var i=1;i<=pollInfo[2];i++)
				{
					if($('#Option'+i).is(':checked'))
						break;
				}
				window.location.href="/make-a-poll/vote.php?id"+id+"&vote="+i;
			}
			function Results()
			{
				var id=window.location.href.substr(window.location.href.lastIndexOf('='));
				window.location.href="/make-a-poll/results.php?id"+id;
			}
			var qr_shown=0;
			function qr()
			{
				if(qr_shown==1)
          		{
            		$("html").animate({ scrollTop: 0 }, "fast",function(){qr_shown=0;
            		$('#qrcode').fadeOut();
            		$('#qrcode').empty();});            
            		return;         
          		}
				qr_shown=1;
				$('#qrcode').qrcode(window.location.href);
				$('#qrcode').fadeIn();
				$("html").animate({ scrollTop: document.body.scrollHeight }, "slow");
			}
     	</script>
     	<br>
     	<button class="button is-link" onclick="Vote()" id="voteButton"><font face="Roboto">Vote</font></button>
     	<button class="button is-warning" onclick="Results()"><font face="Roboto">View Results</font></button>
     	<br><br><p>Share:</p>
     	<div id="share-buttons"></div>
		<script>
			var sb=document.getElementById("share-buttons");
			var link=escape(window.location.href);
			var title=escape(document.title);
			sb.innerHTML='<!-- QR --><a><img src="qr.png" alt="QR" onclick="qr()"/></a><!-- Email --><a href="mailto:?Subject=Vote on: '+document.title+'&amp;Body='+window.location.href+'"><img src="email.png" alt="Email" /></a><!-- Facebook --><a href="http://www.facebook.com/sharer.php?u='+link+'" target="_blank"><img src="facebook.png" alt="Facebook" /></a><!-- Twitter --><a href="https://twitter.com/share?url='+link+'&amp;text=Vote on: '+title+'" target="_blank"><img src="twitter.png" alt="Twitter" /></a><!-- Google+ --><a href="https://plus.google.com/share?url='+link+'" target="_blank"><img src="google.png" alt="Google" /></a><!-- LinkedIn --><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='+link+'" target="_blank"><img src="linkedin.png" alt="LinkedIn" /></a><!-- Reddit --><a href="http://reddit.com/submit?url='+link+'&amp;title=Vote on%3A '+title+'" target="_blank"><img src="reddit.png" alt="Reddit" /></a>';
		</script>
    	<center><div id="qrcode" style="display: none"></div></center>
    </div>
    <div class="column is-narrow"></div>
  </div>
</body>