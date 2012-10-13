<?php

require_once('Frisby.php');

echo 'testing stub<br/>';
$frisby=new Frisby();
$result=$frisby->call('stub',null);
if($result[0]) echo 'success';
else echo 'error';
echo '<br/>';
print_r($result);

?>