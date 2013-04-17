<!doctype html>
<html>
	<head>
    	<title>Gioco</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jquery.jrumble.1.3.js"></script>
        <style type="text/css">
		body
		{
			background-color: #E9E9E9;
		}
		#level
		{
			text-align: center;	
		}
		#images
		{
			text-align: center;
		}
		#user_reply_wrapper
		{
			text-align: center;
		}
		#user_reply_wrapper td
		{
			border: 1px black groove;
			width: 20px;
		}
		</style>
    </head>
    
    <body>
    	<?php
			if (isset($_COOKIE['level']) && !isset($_GET['restart'])) {
				$level = $_COOKIE['level'];
			}
			else {
				setcookie("level", "1");
				$level = 1;	
			}
			
			$json = json_decode(file_get_contents("tests.json"), true);
			
			if (!isset($json[$level])) {
				include "winner.html";
				die ();
			}
		?>
        <div id="level">
        	Your level: <?php echo $level; ?>
            <hr>
        </div>
        
        <div id="wrapper">
        	<div id="images">
            	<?php
            	echo '<img src="'.$json[$level]["img_1"].'" />
                <img src="'.$json[$level]["img_2"].'" />
                <br />
                <img src="'.$json[$level]["img_3"].'" />
                <img src="'.$json[$level]["img_4"].'" />';
				?>
            </div>
            
            <div id="user_reply_wrapper">
            	<!-- in base a quanto è lunga la parola !-->
                <table style="margin: auto">
                	<tr>
                    	<?php
							for ($i = 0, $k = strlen($json[$level]["word"]); $i < $k; $i++) {
								echo '<td onClick="deletecontent(this)" name="game_table" data-pos="0"></td>';	
							}
						?>
                    </tr>
                </table>
                <br />
                <table style="margin: auto">
                	<?php
						$lettere = str_split ($json[$level]["lettere"]);
						$x = 0;
						
						foreach($lettere as $lettera)
						{
							if ($x == 0) {
								echo '<tr>';	
							}
							
							echo '<td><a href="javascript:void()" onclick="addWord(\''.$lettera.'\')">'.$lettera.'</a></td>';
							
							$x ++;
							
							if($x > 3) {
								$x =  0;
								echo '</tr>';	
							}
						}
					?>
                                             
                </table>
            </div>
        </div>
        
        <script type="text/javascript">
		$('td[name*="game_table"]').jrumble({	
			x: 4,
			y: 0,
			rotation: 5
		});
		
		function addWord(word)
		{
			//può essere migliorata
			//var last_pos = 0;
			var word_length = document.getElementsByName("game_table").length;
			console.log("word length: " + word_length);
			var string = new String();//la stringa finale, da inviare al server in caso non ci siano più spazi
			var trovato = new Boolean(false);//indica se ha già trovato lo spazio vuoto non procedente ocn l'inserimento se vera
			var free = 0;//indica quante caselle sono ancora libere, se 0 procede con il controllo
			
			for (var i = 0; i < word_length; i++)//w.w
			{//v.v
				if (document.getElementsByName("game_table")[i].innerHTML == "")
				{
					if (trovato == false) {//e.e
						document.getElementsByName("game_table")[i].innerHTML = word;
						trovato = true;
					}
					
					free ++;
				}
				
				console.log("table: " + i + " contenuto: " + document.getElementsByName("game_table")[i].innerHTML);//debug
				string += document.getElementsByName("game_table")[i].innerHTML;//unisce la stringa
				console.log("Merge string: {" + i + "} {" + document.getElementsByName("game_table")[i].innerHTML + "} merge status: " + string);//debug
			}
			
			free = (free == 1 ? 0 : free);
			
			console.log("Free: " + free);
			
			if (free == 0) {
				console.log("Invio richiesta");
				// sono finiti i posti
				// controllo se ha indovinato la parola
				
				$.ajax({
					url: "controllo.php",
					dataType: "text",//aspetto  0 o 1 
					success: function(data) {
						if (data == 0) {//0 indica che è sbagliata
							// in futuro, si può migliorare comunicando magari dicendo quanto è vicina la parola
							// scritta con quella del sistema
							// o fornire aiuti di altro genere
							$("td").animate({ backgroundColor: "red" }, "fast");
							
							setTimeout(function() {
								$("td").animate({ backgroundColor: "trasparent" }, "medium");
								$('td[name*="game_table"]').trigger('stopRumble');
							}, 800);
							
							//rumble!
							$('td[name*="game_table"]').trigger('startRumble');
						}
						else {
							// 1 indica che è giusta
							$("td").animate({ backgroundColor: "lime" }, "fast");
							
							setTimeout(function() {
								$("td").animate({ backgroundColor: "trasparent" }, "medium");
								window.location.reload();
							}, 500);
						}
						
						console.log("success: " + data);
					},
					data: "parola=" + string
				});
				
				console.log("parola = " + string);//debug
			}
		}
		
		function deletecontent(dom)//dom=>viene passato l'elemento da cancellare
		{
			// se si preme su una casella il suo contenuto viene cancellato
			dom.innerHTML = "";
		}
		</script>
    </body>
</html>