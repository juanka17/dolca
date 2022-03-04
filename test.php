<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo 'hola mundo'.'<br>';


$datatime = new DateTime();

print $datatime->getTimestamp();
print $datatime->format('Y-m-d H:i:s');  
echo '<br>';



print crypt("123456", '');

echo '<br>';
$date =  date('m');

print  $date;