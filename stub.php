<html>
	<head>
		<title>Frisby Test Stub</title>
		<style>
			body {
				background-color:#ebedee;
				text-align:center;
			}
			.notify {
				font-family:Arial;
				font-size:26;
			}
			table {
				border:solid;
			}
		</style>
	</head>
	<body>
		<div>
		<?php
		require_once('Frisby.php');

		$frisby=new Frisby();
		$data=array(
			''
		);
		$result=$frisby->call('setup_installDB');

		if($result[0]) {
			echo '<div class="notify" style="color:#ffffff;background-color:#00cd00">SUCCESS</div>';
			if($result[1]) {
				echo '<img width="500px" src="data:image/png;base64,'.base64_encode($result[1][0]['imgdata']).'" />';
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
