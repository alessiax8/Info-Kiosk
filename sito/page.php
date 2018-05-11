<!DOCTYPE HTML>
<html>

<head>
  <title>Info Kiosk</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />
  <link rel="stylesheet" type="text/css" href="style/style_index.css" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
  <?php
    session_start(); 
          
    if(!isset($_SESSION['username'])){
      header('location:index.php');
      exit;
    }
    
  ?>
  <div id="main">
    <div id="header">
      <div id="menubar">
        <ul id="menu">
          <li class="current"><a href="page.php">Info Kiosk</a></li>
          <li><a href="avvisi.php">Avvisi</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <!--    Orologio     -->
      <div id="sidebar_container">
        <div class="sidebar">
          <center><h3>Orario</h3>
          <h5 id="currentDate"></h5>
          <canvas id="clock" width="150" height="150"></center>
        </div>
        <img class="paperclip" src="style/paperclip.png" alt="paperclip" />
        <div class="sidebar">
          <center><h3>Avvisi</h3></center>
        </div>
        <form action="logout.php?logout" method="POST">
          <div class="sidebar" style="background: white; border: none;">
            <br>
            <center>
            <button type="submit" class="button" style="color:#F14E23;">Logout</button>
            </center>
          </div>
        </form>
      </div>
      <!-- - - - - - - - - -->
      <div id="content">
        <!--<iframe src="http://www.cpt-ti.ch/orario/invite?invite=true" id="webSiteCpt"></iframe><br>-->
        <!--<iframe src="http://www.tplsa.ch/8/0/newlinee-e-orari.html" id="webSiteTpl"></iframe>-->

        <h3 style="text-decoration: underline"> Aula selezionata:</h3>
        <form method="post" action="<?php echo$_SERVER['PHP_SELF'];?>">
          <select name="aula">
            <option value="A-417 lab">A-417 lab</option>
            <option value="A-418 lab">A-418 lab</option>
            <option value="A-419 lab">A-419 lab</option>
            <option value="A-420 lab">A-420 lab</option>
            <option value="A-421 lab">A-421 lab</option>
            <option value="A-422 lab">A-422 lab</option>
          </select>
          <input type="submit" value="Visualizza">
        </form>

        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $aula = $_POST['aula'];
            selectDay($aula);
          } 
        ?>

        <?php

          function visualizeTable($aula, $giorno){
            $db = mysqli_connect('localhost','root','root','orarioaule') or die('Errore');

            $query = "select lezione.giornoFK,lezione.inizioFK,lezione.fineFK,lezione.aulaFK,lezione.moduloFK,docente.nome,docente.cognome,classe_lezione.classeFK
                      FROM lezione 
                      inner join docente on lezione.idDocFK = docente.id
                      inner join classe_lezione on lezione.id = classe_lezione.idLezioneFK
                      where lezione.aulaFK = '" . $aula . "'
                      and lezione.giornoFK = '" . $giorno . "';";

            mysqli_query($db, $query) or die('Error querying database.');

            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_array($result);

            $table = "<table>";
            $table .= "<tr><td><b>Giorno</b></td>" . "<td><b>Inizio</b></td>" . "<td><b>Fine</b></td>" .  "<td><b>Aula</b></td>" . "<td><b>Modulo</b></td>" . "<td><b>Nome e cognome del docente</b></td>" . "<td><b>Classi</b></td></tr>";

            while ($row = mysqli_fetch_array($result)) {
              $table .= "<tr>";

              $table .= "<td>" . $row['giornoFK'] . "</td>";
              $table .= "<td>" . $row['inizioFK'] . "</td>";
              $table .= "<td>" . $row['fineFK'] . "</td>";
              $table .= "<td>" . $row['aulaFK'] . "</td>";
              $table .= "<td>" . $row['moduloFK'] . "</td>";
              $table .= "<td>" . $row['nome'] . " " . $row['cognome'] . "</td>";
              $table .= "<td>" . $row['classeFK'] . "</td>";

              $table .= "</tr>";
            }

            $table .= "</table>";
            echo $table;
          }

          function selectDay($aula){
            $gg = "";
            $day = date("l");
            if($day == "Monday") $gg = "Lunedì";
            else if($day == "Tuesday") $gg = "Martedì";
            else if($day == "Wednesday") $gg = "Mercoledì";
            else if($day == "Thursday") $gg = "Giovedì";
            else if($day == "Friday") $gg = "Venerdì";
            else if($day == "Saturday") $gg = "Sabato";
            else $gg = "Domenica";
            visualizeTable($aula, $gg);
          }
        ?>

      </div>
    </div>
    <div id="footer">
      <p>Alessia Sarak e Diana Liloia</p>
      <p>Copyright &copy; simplestyle_7 | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>

  <script>
    //Data corrente
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();

    if(dd<10) dd = '0' + dd;
    if(mm<10) mm = '0' + mm;

    document.getElementById("currentDate").innerHTML = mm + '/' + dd + '/' + yyyy;
    /**
    * Codice preso da www.w3schools.ch
    */
    var canvas = document.getElementById("clock");
    var ctx = canvas.getContext("2d");
    var radius = canvas.height / 2;
    ctx.translate(radius, radius);
    radius = radius * 0.90
    setInterval(drawClock, 1000);

    function drawClock() {
      drawFace(ctx, radius);
      drawNumbers(ctx, radius);
      drawTime(ctx, radius);
    }

    function drawFace(ctx, radius) {
      var grad;
      ctx.beginPath();
      ctx.arc(0, 0, radius, 0, 2*Math.PI);
      ctx.fillStyle = 'white';
      ctx.fill();
      grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
      grad.addColorStop(0, 'pink');
      grad.addColorStop(0.5, 'black');
      grad.addColorStop(1, 'pink');
      ctx.strokeStyle = grad;
      ctx.lineWidth = radius*0.1;
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
      ctx.fillStyle = 'black';
      ctx.fill();
    }

    function drawNumbers(ctx, radius) {
      var ang;
      var num;
      ctx.font = radius*0.15 + "px arial";
      ctx.textBaseline="middle";
      ctx.textAlign="center";
      for(num = 1; num < 13; num++){
        ang = num * Math.PI / 6;
        ctx.rotate(ang);
        ctx.translate(0, -radius*0.85);
        ctx.rotate(-ang);
        ctx.fillText(num.toString(), 0, 0);
        ctx.rotate(ang);
        ctx.translate(0, radius*0.85);
        ctx.rotate(-ang);
      }
    }

    function drawTime(ctx, radius){
        var now = new Date();
        var hour = now.getHours();
        var minute = now.getMinutes();
        var second = now.getSeconds();
        //hour
        hour=hour%12;
        hour=(hour*Math.PI/6)+
        (minute*Math.PI/(6*60))+
        (second*Math.PI/(360*60));
        drawHand(ctx, hour, radius*0.5, radius*0.07);
        //minute
        minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
        drawHand(ctx, minute, radius*0.8, radius*0.07);
        // second
        second=(second*Math.PI/30);
        drawHand(ctx, second, radius*0.9, radius*0.02);
    }

    function drawHand(ctx, pos, length, width) {
        ctx.beginPath();
        ctx.lineWidth = width;
        ctx.lineCap = "round";
        ctx.moveTo(0,0);
        ctx.rotate(pos);
        ctx.lineTo(0, -length);
        ctx.stroke();
        ctx.rotate(-pos);
    }
  </script>
</body>
</html>
