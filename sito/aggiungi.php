<?php 

	$nome_file = "avvisi.csv";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(file_exists($nome_file)){
			//$fileCSV = fopen($nome_file, "w");
			if (!(empty($_POST["avviso"]) or empty($_POST["aula"]))){
				$aula = $_POST["aula"];
				$avviso = $_POST["avviso"];
				$data = date("Y.m.d");
				$ora = date("h:i:sa");
				$txt = "$aula;$avviso;$data;$ora;<a>x</a>";
			 	
				$myfile = file_put_contents($nome_file, $txt. PHP_EOL, FILE_APPEND);
				
			}
		}	
	}
	header("location: http://localhost/sito/avvisi.php");


	/*CREO LA TABELLA 	
	$row = 1;
	if (($handle = fopen($nome_file, "r")) !== FALSE) {
		    
		echo '<table border="1" id="tbDati">';
		    
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
    		
	}*/ 
?>