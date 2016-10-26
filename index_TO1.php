<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Kontrola odrzutow</title>
    <meta name="Description" content="Hala TO" />
    <meta name="Keywords" content="test" />
	
    <link rel="stylesheet" href="style.css" type="text/css" />
	<script src="script.js"></script>
	<script src="jquery-2.1.3.min.js"></script>
	
	<?php require('run.php'); 
		$kam_1 = odczytCam("Kamera_1");
		$kam_2 = odczytCam("Kamera_2");
		$kam_3 = odczytCam("Kamera_3");
		$kam_4 = odczytCam("Kamera_4");
		$kam_5 = odczytCam("Kamera_5");
		$kam_6 = odczytCam("Kamera_6");
	?>
	<script>	
		function alarmTime(zegar, czas) {
		  	countdown(new Date(czas), document.getElementById(zegar), function() {
				let ciacho = localStorage.getItem(zegar).split(';');
				let alarm = ciacho[1];
				if(alarm =="alarm_zolty"){
					localStorage.setItem(zegar, newDate("03:30:01")+';'+"alarm_czerwony");
				}
				ciacho = localStorage.getItem(zegar).split(';');
				let czas = ciacho[0];
				alarm = ciacho[1];
				
				countdown(new Date(czas), document.getElementById(zegar),function(){
					localStorage.setItem(zegar, czas+';'+"STOP");
				});
				$('#'+zegar).css('color', "red");
				$('#'+zegar).prev
				let wiersz = $('#'+zegar).siblings();
				wiersz.eq(4).attr('class',alarm);
				wiersz.slice(6).text('STOP Linii').css('color', "red").attr('class', "");
				
            });
		}		
		
	</script>
    <style>
		
				
    </style>
</head>
    <body>
			<h1>Hala TO</h1>
			<div id="test"></div>
			<div class="logo"><img src=".\image\logo.gif" alt="Logo" onclick="reset()"/></div>   
			<div class="floater"></div> 
							
        <table>
            <tr>
                <th>Linia</th>
                <th>Data</th>
				<th>Godzina</th>
				<th>Ilość</th>
				<th>%kam wewn.</th>
				<th>Trend</th>
				<th>Informacje</th>
				<th>Czas</th>
            </tr>
            <tr>
                <td>CP01</td>
				<td><?php echo $kam_1[0];?></td>
                <td><?php echo $kam_1[1];?></td>
				<td><?php echo $kam_1[2];?></td>
                <td class="cell"><?php echo $kam_1[3];?></td>
				<td class="trend"><?php echo $kam_1[4];?></td> 
				<td></td>
				<td></td>
            </tr>
            <tr>
                <td>CP02</td>
				<td><?php echo $kam_2[0];?></td>
                <td><?php echo $kam_2[1];?></td>
				<td><?php echo $kam_2[2];?></td>
                <td class="cell"><?php echo $kam_2[3];?></td>
				<td class="trend"><?php echo $kam_2[4];?></td> 
				<td></td>
				<td></td>
            </tr>
			<tr>
                <td>CP03</td>
				<td><?php echo $kam_3[0];?></td>
                <td><?php echo $kam_3[1];?></td>
				<td><?php echo $kam_3[2];?></td>
                <td class="cell"><?php echo $kam_3[3];?></td>
				<td class="trend"><?php echo $kam_3[4];?></td> 
				<td></td>
				<td></td>
            </tr>
			<tr>
                <td>CP04</td>
				<td><?php echo $kam_4[0];?></td>
                <td><?php echo $kam_4[1];?></td>
				<td><?php echo $kam_4[2];?></td>
                <td class="cell"><?php echo $kam_4[3];?></td>
				<td class="trend"><?php echo $kam_4[4];?></td> 
				<td></td>
				<td></td>
            </tr>
			<tr>
                <td>CP05</td>
				<td><?php echo $kam_5[0];?></td>
                <td><?php echo $kam_5[1];?></td>
				<td><?php echo $kam_5[2];?></td>
                <td class="cell"><?php echo $kam_5[3];?></td>
				<td class="trend"><?php echo $kam_5[4];?></td> 
				<td></td>
				<td></td>
            </tr>
			<tr>
                <td>CP06</td>
				<td><?php echo $kam_6[0];?></td>
                <td><?php echo $kam_6[1];?></td>
				<td><?php echo $kam_6[2];?></td>
                <td class="cell"><?php echo $kam_6[3];?></td>
				<td class="trend"><?php echo $kam_6[4];?></td> 
				<td></td>
				<td></td>
            </tr>
        </table>
				
		<script>
			$("td.trend").each(function() {
				let cell = ($(this).html());
				$(this).html(strzalka (cell));
			});
			
			var prog = 1.6
			$("td.cell").each(function() {
				let cell = ($(this).html());
				let wiersz = $(this).siblings();
				var nazwaKamery = wiersz[0].innerText;
					
				if (cell > prog){
					if(!localStorage.getItem(nazwaKamery)){
						localStorage.setItem(nazwaKamery, newDate("00:30:00")+';'+"alarm_zolty");
					}
					let ciacho = localStorage.getItem(nazwaKamery).split(';');;
					let czas = ciacho[0];
					let alarm = ciacho[1];
					if (alarm == "alarm_zolty"){
						$(this).attr('class',alarm);
						$(this).siblings().eq(5).text('ALARM').attr('class',alarm);
						$(this).siblings().eq(6).attr('id', nazwaKamery).html(alarmTime(nazwaKamery, czas));
						
					} else if(alarm == "alarm_czerwony"){
						$(this).attr('class',alarm);
						$(this).siblings().eq(5).text('STOP Linii').css('color', "red").css('background', "");
						$(this).siblings().eq(6).css('color', "red");
						$(this).siblings().eq(6).attr('id', nazwaKamery).html(alarmTime(nazwaKamery, czas));
					} else{
						$(this).attr('class',"alarm_czerwony");
						$(this).siblings().eq(5).text('STOP Linii').css('color', "red").css('background', "");
						$(this).siblings().eq(6).css('color', "red");
						$(this).siblings().eq(6).attr('id', nazwaKamery).html("00:00:00");
					}
					
					
				} else  {
					localStorage.removeItem(nazwaKamery);
					
					
				}
			});
			setInterval(function() { window.location.reload(); }, 300000);	
		</script>
		
    </body>
</html>
