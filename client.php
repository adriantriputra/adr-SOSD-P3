<?php
require 'vendor/autoload.php';

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$namespace = str_replace('client.php','server.php', $namespace);
$client = new nusoap_client($namespace);

$response = $client->call('welcome_msg', array(
    'nama' => 'Adrian'
));
echo $response;

echo '<br>';

$response = $client->call('get_info_promo', array(
    'tipe_buku' => 'tipis',
    'hari' => 'minggu'
));
echo $response;

echo '<br>';

$response = $client->call('hitung_diskon', array(
    'diskon' => 0.1,
    'harga_buku' => 200000
));
echo $response;

echo '<br>';

$response = $client->call('best_seller', array(
    'genre' => "misteri"
));
echo $response;