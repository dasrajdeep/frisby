<?php

require_once('Frisby.php');

echo 'testing stub<br/>';
$frisby=new Frisby();
$result=$frisby->call('stub',null);
if($result[0]) echo 'success';
else echo 'error';
echo '<br/>';
?>
<table>
	<tr>
		<th>COMPONENT</th>
		<th>DESCRIPTION</th>
	</tr>
<?php
foreach($result[1] as $row) {
	echo sprintf('<tr><td>%s</td><td>%s</td></tr>',$row[0],$row[1]);
}
?>
</table>
