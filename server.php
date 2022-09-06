<?php
require 'vendor/autoload.php';
$server = new soap_server();

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$server->configureWSDL('Bookstore');
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'Books',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'ID' => array('name' => 'ID', 'type' => 'xsd:string'),
        'author' => array('name' => 'author', 'type' => 'xsd:string'),
        'judul' => array('name' => 'judul', 'type' => 'xsd:string'),
        'jml_halaman' => array('name' => 'jml_halaman', 'type' => 'xsd:int'),
        'genre' => array('name' => 'genre', 'type' => 'xsd:string'),
    ));

function welcome_msg($nama) {
    return "Welcome bro/sis $nama!";
}

$server->register('welcome_msg',
    array('nama' => 'xsd:string'),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Welcoming Messages'
);

function get_info_promo($tipe_buku, $hari) {
    if ($tipe_buku == "tebal" and $hari == "minggu"){
        return "Ada diskon untuk kamu sebesar 20% nih di hari $hari kamu!";
    } 
    elseif ($tipe_buku == "tipis" and $hari == "minggu"){
        return "Ada diskon untuk kamu sebesar 10% nih di hari $hari kamu!";
    }
    else {
        return "Yah :( tidak ada diskon untuk kamu hari ini.";
    }
}

$server->register('get_info_promo',
    array(
        'tipe_buku' => 'xsd:string',
        'hari' => 'xsd:string'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Mencari informasi promo untuk client'
);

function hitung_diskon($diskon, $harga_buku){
    $harga_diskon = $harga_buku-($harga_buku*$diskon);
    return "Yeay! Setelah diskon, harga bukumu menjadi Rp.$harga_diskon saja!";
}

$server->register('hitung_diskon',
    array(
        'diskon' => 'xsd:float',
        'harga_buku' => 'xsd:int'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Mencari hasil harga diskon buku'
);

function best_seller($genre){
    if($genre == 'misteri') {
        $m_bestseller = join(', ', array(
            "Twenty Years Later: A Riveting New Thriller.", "City Dark: A Thriller.", "Does It Hurt?: An Enemies to Lovers Romance."
        ));
        return "Buku misteri yang best seller minggu ini yaitu: <br>$m_bestseller";
    }
    elseif($genre == 'romantis'){
        $r_bestseller = $m_bestseller = join(', ', array(
            "The Roughest Draft", "Twisted Hate", "Delilah Green Doesn't Care"
        ));
        return "Buku romantis yang best seller minggu ini yaitu: <br>$r_bestseller";
    }
    else {
        return "Genre yang dimasukkan saat ini tidak memiliki best selling books.";
    }
}

$server->register('best_seller',
    array('genre' => 'xsd:string',),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Melihat buku best selling'
);

$server->service(file_get_contents("php://input"));
exit();