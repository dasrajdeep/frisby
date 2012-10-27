<html>
	<head>
		<title>Frisby Test Stub</title>
		<style>
			body {
				background-color:#ebedee;
				color:#555555;
				text-align:center;
				font-family:arial,sans-seriff;
			}
			.notify {
				font-family:Arial;
				font-size:26;
			}
			td {
				border:solid;
				border-width:1px;
				padding:3px;
			}
			th {
				background-color:#555555;
				color:#ebedee;
				padding:7px;
			}
		</style>
	</head>
	<body>
		<div>
		<?php
		require_once('Frisby.php');

		$frisby=new Frisby();
		$data=array(
			'text'=>'wrong'
		);
		$result=$frisby->call('reg_getMethodNames');

		if($result[0]) {
			echo '<div class="notify" style="color:#ffffff;background-color:#00cd00">SUCCESS</div>';
			if($result[1]!=null) {
				echo '<div>Data Set Received</div>';
				//if(isset($result[1][0]['imgdata'])) echo '<img src="data:image/png;base64,'.base64_encode($result[1][0]['imgdata']).'" />';
				//$keys=array_keys($result[1][0]);
				//foreach($keys as $k) if($k!='imgdata') echo sprintf('<div>%s: %s</div>',$k,$result[1][0][$k]);
				echo '<br/>';
				echo sprintf('<div><b>%s Items in Set</b></div>',count($result[1]));
				foreach($result[1] as $r) {print_r($r);echo '<br/>';}
			}
		}
		else echo '<div class="notify" style="color:#ebedee;background-color:#cc0000">ERROR</div>';
		echo '<br/>';
		?>
		</div>
		<hr/>
		<table align="center">
			<tr>
				<th>COMPONENT</th>
				<th>DESCRIPTION</th>
			</tr>
		<?php
		if($result[1] && !$result[0]) {
			foreach($result[1] as $row) {
				echo sprintf('<tr><td>%s</td><td>%s</td></tr>',$row[0],$row[1]);
			}
		}
		?>
		</table>

	</body>
</html>
