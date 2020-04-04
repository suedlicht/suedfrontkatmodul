<?php
//error_reporting( E_ALL );

$sMetadataVersion = '2.0';
$aModule = array(
    'id'           => 'suedfrontkatmodul',
    'title'        => 'Produkt Kategorie Auswahl',
    'description'  => array(
        'de' => 'Modul für Kategorie Hersteller Baujahr.',
        'en' => 'Module for Categoies Manufactors.',
    ),
   
    'thumbnail'    => '',
    'version'      => '1.3',
    'author'       => 'Suedlicht',
    'email'        => 'info@suedlicht.com',
    'extend'       => array(
       // 'oxutilsview'  => 'suedlicht/suedfrontkatmodul/Application/Controller/motrradselect',
        \OxidEsales\Eshop\Application\Controller\FrontendController::class => suedlicht\suedfrontkatmodul\Application\Controller\motrradselect::class,
  ), 
 );
//error_log( E_ALL );
//echo " mettatag";

