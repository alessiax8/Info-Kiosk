<?php
	session_start(); 
				
		if(!isset($_SESSION['username']))
		{
			header('location:index.php');
			exit;
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
	<link rel="stylesheet" type="text/css" href="style/style_index.css" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
	<div id="main">
		<div id="header">
			<div id="menubar">
				<ul id="menu">
					<li><a href="page.php">Info Kiosk</a></li>
					<li class="current"><a href="sito/avvisi.php">Avvisi</a></li>
				</ul>
			</div>
		</div>
		<div id="site_content">
			<div id="content" >
				<form action="aggiungi.php" method="POST">
					<h2>Avvisi</h2>
					Aula:<br><input type="number" name="aula" max="423" min="417"><br><br>
					Avviso:<br><textarea name="avviso" rows="4" cols="50"></textarea><br><br>
					<button type="submit" class="button1 button">Aggiungi</button>
				</form>
				<?php
					//CREO LA TABELLA
					$row = 1;
					if (($handle = fopen("avvisi.csv", "r")) !== FALSE) {
								
						echo '<table border="1" id="tableAvvisi">';
								
						while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
								$num = count($data);
								if ($row == 1) {
										echo '<thead><tr>';
								}else{
										echo '<tr>';
								}
										
								for ($c=0; $c < $num; $c++) {
										if(empty($data[$c])) {
												$value = "&nbsp;";
										}else{
												$value = $data[$c];
										}
										if ($row == 1) {
												echo '<th>'.$value.'</th>';
										}else{
												echo '<td>'.$value.'</td>';
										}
								}
										
								if ($row == 1) {
										echo '</tr></thead><tbody>';
								}else{
										echo '</tr>';
								}
								$row++;
						}
						
							echo '</tbody></table>';
							fclose($handle);    
					} 
				?>
			</div>
		</div>
		<div id="footer">
			<p>Alessia Sarak e Diana Liloia</p>
			<p>Copyright &copy; simplestyle_7 | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
		</div>
	</div>

	</script>
</body>
</html>
