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
  <script type="text/javascript" src="Chart.min.js"></script>
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
		}
		body
		{
			font-family: 'Roboto', sans-serif;
		}
    .box
    {
      background-color: #DDFFFD;
    }
    .navbar.is-warning
    {
      background-color: #FFFF56;
    }
    #share-buttons img
      {
      width: 60px;
      padding: 5px;
      border: 0;
      box-shadow: 0;
      display: inline;
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
      <a class="navbar-item" href="/make-a-poll"><span class="icon"><i class="fas fa-home"></i></span>&nbsp;Make-a-Poll</a>
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

      $result=mysqli_query($conn,"SELECT CreationTime, Question, Options, ExpiryTime, Votes, Private, VoteLimit FROM polls WHERE ID= ".$_GET['id']);

      $poll_data=mysqli_fetch_array($result,MYSQLI_ASSOC);

      if(isset($_GET['exp']))
        echo '<div id="hasExpired">1</div>';
      else
        echo '<div id="hasExpired">0</div>';

      echo '<div id="pollDat">';
      foreach($poll_data as $key=>$value)
      {
        echo $value;
        if($key!=="VoteLimit")
          echo "\r\n";
      }
      echo '</div>';
      ?>
      <br>
      <div class="box">
      <center><div id="canvas-holder" style="max-width: 335px"><canvas id="myChart" width="400" height="400"></canvas></div></center>
      <div id="share-buttons" align="right"></div>
      <script type="text/javascript">
        $(document).ready(function()
        {
          $(".navbar-burger").click(function()
          {
                $(".navbar-burger").toggleClass("is-active");
                $(".navbar-menu").toggleClass("is-active");
            });
        });

        var expired=Number(document.getElementById('hasExpired').innerHTML);
        $("#hasExpired").remove();
        var dat=document.getElementById('pollDat');
        var pollInfo=document.getElementById('pollDat').innerHTML.split('\n');
        document.title=pollInfo[1];
        var sb=document.getElementById("share-buttons");
        var link=escape(window.location.href);
        var title=escape(document.title);
        sb.innerHTML='<!-- QR --><a><img src="qr.png" alt="QR" onclick="qr()"/></a><!-- Email --><a href="mailto:?Subject=Poll Results: '+document.title+'&amp;Body='+window.location.href+'"><img src="email.png" alt="Email" /></a><!-- Facebook --><a href="http://www.facebook.com/sharer.php?u='+link+'" target="_blank"><img src="facebook.png" alt="Facebook" /></a><!-- Twitter --><a href="https://twitter.com/share?url='+link+'&amp;text=Results: '+title+'" target="_blank"><img src="twitter.png" alt="Twitter" /></a><!-- Google+ --><a href="https://plus.google.com/share?url='+link+'" target="_blank"><img src="google.png" alt="Google" /></a><!-- LinkedIn --><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='+link+'" target="_blank"><img src="linkedin.png" alt="LinkedIn" /></a><!-- Reddit --><a href="http://reddit.com/submit?url='+link+'&amp;title=Poll Results%3A '+title+'" target="_blank"><img src="reddit.png" alt="Reddit" /></a>';
        dat.innerHTML='';
        var vl="";
        if(expired)
          vl="Voting has closed.";
        else if(Number(pollInfo[pollInfo.length-3])>=Number(pollInfo[pollInfo.length-1])&&Number(pollInfo[pollInfo.length-1])!=0)
          vl="Voting limit reached.";
        var creationTime=new Date(pollInfo[0] * 1000);
        var currentTime=Date.now();
        function poll()
        {
          var id=window.location.href.substr(window.location.href.lastIndexOf('='));
          window.location.href="/make-a-poll/poll.php?id"+id;
        }
        if(pollInfo[pollInfo.length-4]!=0)
        {
          var exp=(currentTime - creationTime.getTime())/(1000*60*60);
          exp=String(exp).substr(0,String(exp).indexOf("."));
          exp=Number(pollInfo[pollInfo.length-4])-Number(exp);
          if(vl=='')
            dat.innerHTML+='<p class="title is-4">'+pollInfo[1]+'<font color="#FA0000" size="2"> '+vl+'</font></p><p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString()+' | Voting closes in less than '+exp+' hours | <a onclick="poll()">Vote</a>';
          else
            dat.innerHTML+='<p class="title is-4">'+pollInfo[1]+'<font color="#FA0000" size="2"> '+vl+'</font></p><p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString();
        }
        else if(vl=='')
        {
          dat.innerHTML+='<p class="title is-4">'+pollInfo[1]+'</p>'+'<p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString()+' | <a onclick="poll()">Vote</a>';
        }
        else
        {
          dat.innerHTML+='<p class="title is-4">'+pollInfo[1]+'<font color="#FA0000" size="2"> '+vl+'</font></p><p class="subtitle is-7">Votes: '+pollInfo[pollInfo.length-3]+' | Created on '+creationTime.toDateString();
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
        if(pollInfo[pollInfo.length-3]!=0)
        {
          function addData(chart, label, data) {
          chart.data.labels.push(label);
          chart.data.datasets.forEach((dataset) => {
          dataset.data.push(data);
          var r=Math.floor(Math.random()*255+60);
          r=r>255?255:r;
          var b=Math.floor(Math.random()*255+60);
          b=b>255?255:b;
          var g=Math.floor(Math.random()*255+60);
          g=g>255?255:g;
          dataset.backgroundColor.push("rgb("+r+","+g+","+b+")");
          dataset.borderColor.push("rgb(0,0,0)");
          });
          chart.update();
          }
          var ctx = document.getElementById("myChart").getContext('2d');        
          data = {datasets: [{data: [],backgroundColor: [], borderColor: [], borderWidth: 1}], labels: []};
          var myPieChart = new Chart(ctx,{type: 'pie',data: data});
          Chart.defaults.global.defaultFontFamily = 'Roboto';
          Chart.defaults.global.defaultFontColor = '#000';
          for(var i=1;i<=pollInfo[2];i++)
            addData(myPieChart,pollInfo[2+i].substr(0,pollInfo[2+i].lastIndexOf("[")),Number(pollInfo[2+i].substr(pollInfo[2+i].lastIndexOf("[")+1,pollInfo[2+i].lastIndexOf("]")-pollInfo[2+i].lastIndexOf("[")-1)));
          dat.innerHTML='<h1 align="center" class="title is-6"><i>Results</i></h1><div class="box">'+dat.innerHTML+'</div>';
        }
        else
        {
          dat.innerHTML='<h1 align="center" class="title is-6"><i>Results</i></h1><div class="box">'+dat.innerHTML+'</div>';
          $("#canvas-holder").html("<b>There have been</b>");
        }
      </script>
    </div>
    <center><div id="qrcode" style="display: none"></div></center>
    </div>
    <div class="column is-narrow">
  </div>
  </div>
</body>
</html>