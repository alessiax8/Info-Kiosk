<?php 
  
    if((isset($_POST['username']) && $_POST['pass'] !=''))
    {

      session_start();
      $a = "ciao";

      $ldap_dn = $_POST["username"] ."@cpt.local";
      $ldap_prova = $_POST["username"];
      $ldap_password = $_POST["pass"];

      $link = ldap_connect('cpt.local');

      if(! $link) {
          echo "Impossibile connettersi al dominio cpt.local";
      }

      ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3);

      if ($ldap_prova == "prova" && $ldap_password == "prova" || @ldap_bind($link, $ldap_dn, $ldap_password)){
        $_SESSION['username'] = $ldap_dn;
        $_SESSION['pass'] = $ldap_password;
        header('location: page.php');
        exit;
      }else{
        header('location:credenziali.php');
      }
    }

 ?>

<!DOCTYPE HTML>
<html>

<head>
  <title>Info Kiosk</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
  <link rel="stylesheet" type="text/css" href="style/style_PW.css" />
</head>

<script type="text/javascript">
	function mostraPassword() {
    var x = document.getElementById("mp");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

</script>

<body>
	<div id="main">
    	<div id="header">
      		<div id="logo">
        		<h1>Info Kiosk</h1>
     		</div>
      	</div>
    </div>
    <center>
	    <div id="site_content" align="center">

	    	<div id="content" >
				<h2>Login</h2>
			  	<form action="index.php" method="POST">
			    	<div class="imgcontainer">
			     	 	<img src="style/login-icon@3x.png" alt="Login" class="avatar">
			    	</div>

			    	<div class="container">
			     		<label for="uname"><b>Username</b></label>
			        <input type="text" placeholder="Enter Username" name="username" required>

					    <label for="psw"><b>Password</b></label>
					    <input type="password" placeholder="Enter Password" name="pass" id="mp" required><input type="checkbox" onclick="mostraPassword()">Show Password
					    <label name></label> 
					    <button type="submit">Login</button>
					  </div>
			    </form>
	     </div>
	   </div>
    </center>
    <div id="footer">
   		<p>Alessia Sarak e Diana Liloia</p>
      	<p>Copyright &copy; simplestyle_7 | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>
</body>
</html>
