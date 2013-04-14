<?php 	//include 'getobsval.php'; 
		include 'chartform.php';
		include 'chkbox.php';
		include 'getobsval.php';
		include 'chartdisopts.php';

/* for $_GET */
		$g_foi = getVar("foiid");
		$g_startdate = getVar("starting");
		$g_enddate = getVar("ending");
		

		//$observation = getVar("observation");
/* if $foi, startdate, enddate and observation != '', then override $_POST */		
		if ($g_foi != ''){
			$_POST['foi'] = $_GET['foiid'];
		}
		
		if ($g_startdate != ''){
			$_POST['startdate'] = $_GET['starting'];
		}
		
		if ($g_enddate != ''){
			$_POST['enddate'] = $_GET['ending'];
		}
		
		
/*		if ($observation != ''){
			$_POST['observation'] = $_GET['observation'];
		} */
		
		?>

<!DOCTYPE HTML>
<head>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="https://www.google.com/jsapi"></script>
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script src="../js/ger_dpicker.js"></script>
	<link rel="shortcut icon" href="../images/egg_v1.png">
	<link rel="stylesheet" type="text/css" href="../css/styles.css" />

	
<script>
$(function() {
var numchked = $(":checkbox").filter(":checked").size();
if (numchked > 3){
	alert("Es wurden mehr als 3 Messwerte ausgew�hlt");
}
else {
}
	
}
)
</script>	
	
		
<script>
// ----------------------------------- DATEPICKER -----------------------------------
 // Create the datepickers
$(function() {
	// Settings for both datepickers
	<?php date_default_timezone_set('Europe/Berlin');?>
	$( "#datepicker" ).datepicker( {required: true, 
									dpDate: true,
									maxDate: new Date ( (new Date()).getTime()), 
									onClose: chkdates,
									dateFormat: 'yy-mm-dd' });
	$( "#datepicker2" ).datepicker( {required: true,
									dpDate: true, 
									maxDate: new Date ( (new Date()).getTime()),
									onClose: chkdates,
									dateFormat: 'yy-mm-dd' });

// If start- and enddate were set, get the dates and show it. If not: date = today
	var startdate = "<?php 
		if (isset($_POST['startdate']))
			{echo  $_POST['startdate'];} 
		else {echo date("Y-m-d",time());} ?>";

	var enddate = "<?php   
		if (isset($_POST['enddate']))
			{echo $_POST['enddate'];} 
		else {echo date("Y-m-d",time());}?>";
// set the dates		
		$ ( "#datepicker").datepicker('setDate', startdate);
	
		$ ( "#datepicker2").datepicker('setDate', enddate);

//check the dates
		function chkdates(){
			var dateStart = $("#datepicker").datepicker("getDate");
			var dateEnd = $("#datepicker2").datepicker("getDate");
			var submit = document.getElementById("submit");
			// miliseconds
			var difference = (dateEnd - dateStart) / (86400 * 1000 *7);

// startdate > enddate
			if (difference < 0){
				alert("Das Anfangsdatum muss vor dem Enddatum liegen!");
				submit.disabled = true;
			}
// enddate - startdate > 7 days
			if (difference > 1){
				alert("Der Zeitraum darf maximal 7 Tage betragen!");
				submit.disabled = true;
			}
			if (difference >= 0 && difference <= 1){
				submit.disabled = false;
			}
		}	
}
)
;

</script>   
 	
	
   
<script>
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
     
    //get the data
	var jsonData = <?php getValues()  ?>;
	var jsonData2 = <?php getValues("TEMPERATURE")  ?>;
	var jsonData3 = <?php getValues("AIR_HUMIDITY") ?>;
	var foi = "<?php if (isset($_POST['foi'])){ echo $_POST['foi']; } ?>";

//function to draw the chart
    function drawChart() {

	if (!(foi == "Geist" || foi == "Weseler")){		
    	
    	// Create our data table out of JSON data loaded from server.
          var data = new google.visualization.DataTable(jsonData);
          var data2 = new google.visualization.DataTable(jsonData2);
          var data3 = new google.visualization.DataTable(jsonData3);

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
          var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
          var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div'));

    <?php AQEChartOptions();?>
}
	else {
    	// Create our data table out of JSON data loaded from server.
   		// Instantiate and draw our chart, passing in some options.
    	
		<?php 
		//Number of offerings
		if (isset($_POST['observation'])){
			$numoff = count($_POST['observation']);
			switch($numoff){
				case 1: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div')); <?php
		        break;
		        
				case 2: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				var data2 = new google.visualization.DataTable(<?php getValues($_POST['observation']['1'])?>);
				var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div')); <?php
				break;
				
				case 3: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				var data2 = new google.visualization.DataTable(<?php getValues($_POST['observation']['1'])?>);
				var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
				var data3 = new google.visualization.DataTable(<?php getValues($_POST['observation']['2'])?>);
				var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div')); <?php
				break;
				
				case 4: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				var data2 = new google.visualization.DataTable(<?php getValues($_POST['observation']['1'])?>);
				var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
				var data3 = new google.visualization.DataTable(<?php getValues($_POST['observation']['2'])?>);
				var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div'));
				var data4 = new google.visualization.DataTable(<?php getValues($_POST['observation']['3'])?>);
				var chart4 = new google.visualization.LineChart(document.getElementById('chart4_div')); <?php
				break;				
		        
		}
}
?>


        <?php
        //PM 10 checked?
        if (isset($_POST['PM10'])){ if($_POST['PM10'] == "PM10_CONCENTRATION"){ ?>
		var data3 = new google.visualization.DataTable(<?php getValues("PM10_CONCENTRATION")?>);
        var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div'));
		<?php }}?>
        <?php lanuvChartOptions();	?>
        
	}
}
	


	// json-object are empty, do nothing	
	if (jsonData == "" || jsonData2 == "" || jsonData3 == ""){
	}
	// else draw the charts
	else {
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
   	}
</script>       

</head>

<body onload = "changeForm(document.getElementById('foi').value);">
	<div id="wrapper">
		<div id="headerwrap">
			<div id="header">
				<img class="logo" src="../images/egg_logo.png" width=70 height=55 align="left">
				<p>SkyEagle<p>
			</div>
        </div>
		<div id="navigationwrap">
            <ul id="menu-bar">
				<li><a href="Home.php">Home</a></li>
				<li><a href="Karte.php">Karte</a></li>
				<li class="current"><a href="Diagramme.php">Diagramme</a></li>
				<li><a href="Tabelle.php">Tabelle</a></li>
				<li><a href="SOS.php">SOS</a></li>
				<li><a href="Hilfe.php">Hilfe</a></li>
				<li><a href="Impressum.php">Impressum</a></li>
				<li><a href="../mobile/homemobile.php">Mobile Ansicht</a></li>
			</ul>
		</div>
		<div id="contentwrap">
			<div id="content">
				<form action = "Diagramme.php" method ="post" id = "form" name="form">
					<fieldset>
						<legend>Bitte w&auml;hlen Sie eine Messstation</legend>
						<p>
							<label>Messstation</label>
							<?php createOptionList();?>
						</p>
					</fieldset>
					<fieldset>
						<legend>Bitte w&auml;hlen Sie ein Zeitintervall</legend>
						<p>
						<label for = "datepicker">von:</label>			
						<input type = "text" 
							id="datepicker"
							name = "startdate"
							readonly = "true"
							/>

						<label for = "datepicker2">bis:</label>
						<input type = "text"
							id="datepicker2"
							name = "enddate"
							readonly = "true"
							/>		
						</p>
					</fieldset>
					<fieldset>
						<legend>Bitte w&auml;hlen Sie aus, ob das Diagramm Ausrei&szlig;er beinhalten soll oder nicht</legend>
						<p>
						<?php 
							createRadioButtons();
						?>

						</p>
					</fieldset>
					<fieldset>
						<legend>Bitte w&auml;hlen Sie aus, welche Messwerte sie im Diagramm anzeigen wollen</legend>
						<p>
						<?php 
							createCheckboxes();
						?>						
						</p>
					</fieldset>

					<fieldset>
						<input 	class = "searchButton"
								type = "submit"
								id = "submit"
								value = "Diagramm anzeigen"
						/>
					</fieldset>		
				</form>
				<br>
				<?php 
				if (isset($_POST['foi'])){
					if ($_POST['foi'] != "Geist" OR $_POST['foi'] != "Weseler"){
						echo '
						<div id="chart_div"></div>
						<div id="chart2_div"></div>
						<div id="chart3_div"></div> ';
						}
					else { 
						switch($numoff){
							case 1: echo '<div id="chart_div"></div>';
							break;
							
							case 2: echo '<div id="chart_div"></div>
									<div id="chart2_div"></div>';
							break;
							
							case 3: echo '<div id="chart_div"></div>
									<div id="chart2_div"></div>
									<div id="chart3_div"></div>';
							break;
							
							case 4: echo '<div id="chart_div"></div>
									<div id="chart2_div"></div>
									<div id="chart3_div"></div>
									<div id="chart4_div"></div>';
							
							
						}
								//PM10 checked
								if(isset($_POST['PM10'])){ if($_POST['PM10'] == "PM10_CONCENTRATION"){
								echo '
								<div id="chart5_div"></div>';}}
								}
								} ?>
		</div>
	</div>
  </body>

</html>