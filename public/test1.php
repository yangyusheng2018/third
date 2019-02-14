<?php
echo "ferfgergt";

     $redis = new Redis();
$redis->connect('127.0.0.1', '6379')or die ("Could net connect redis server!");
    echo "Connection to server sucessfully <br/>";
    echo "Server is running: " . $redis->ping();
?>