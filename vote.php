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

      if (!$conn) die("Connection failed: ".mysqli_connect_error());

      $result=mysqli_query($conn,"SELECT CreationTime, Question, Options, ExpiryTime, Votes, Private, VoteLimit FROM polls WHERE ID= ".$_GET['id']);

      $poll_data=mysqli_fetch_array($result,MYSQLI_ASSOC);

      if(isset($_GET['vote']))
      {
        if((intval($poll_data['Votes'])<intval($poll_data['VoteLimit']))||intval($poll_data['VoteLimit'])==0)
        {
          $poll_data['Votes']=$poll_data['Votes']+1;
          $ops=explode("\n",$poll_data['Options']);
          $len=strrpos($ops[$_GET['vote']],']')-strrpos($ops[$_GET['vote']],'[')-1;
          $cur_votes=(int)substr($ops[$_GET['vote']],strrpos($ops[$_GET['vote']],'[')+1,$len)+1;
          $ops[$_GET['vote']]=substr($ops[$_GET['vote']],0,strrpos($ops[$_GET['vote']],'[')).'['.$cur_votes.']';
          $poll_data['Options']=implode("\n",$ops);
          mysqli_query($conn,"UPDATE polls SET Options='".$poll_data['Options']."' WHERE ID=".$_GET['id']);
          mysqli_query($conn,"UPDATE polls SET Votes='".$poll_data['Votes']."' WHERE ID=".$_GET['id']);
        }
      }
      header("refresh:0.75;url=/make-a-poll/results.php?id=".$_GET['id']);
      ?>
</body>
</html>