<?php
//error_reporting( E_ALL );

$sMetadataVersion = '2.0';
$aModule = [
    'id'           => 'suedfrontkatmodul',
    'title'        => 'Produkt Kategorie Auswahl',
    'description'  => ['de' => 'Modul für Kategorie Hersteller Baujahr.','en' => 'Module for Categoies Manufactors.'],
    'thumbnail'    => '',
    'version'      => '1.2',
    'author'       => 'Suedlicht',
    'email'        => 'info@suedlicht.com',
    'extend'       => [
       // 'oxutilsview'  => 'suedlicht/suedfrontkatmodul/Application/Controller/motrradselect',
        \OxidEsales\Eshop\Application\Controller\FrontendController::class => suedlicht\suedfrontkatmodul\Application\Controller\motrradselect::class,
        ],
      //  'alist'             => 'suedlicht/suedkatmodul/Application/Controller/produkt',
       //  \OxidEsales\Eshop\Application\Controller\Admin\ArticleAttribute::class => \OxidEsales\KatModul\Application\Controller\Admin\ArticleAttribute::class,
     // \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController::class => \OxidEsales\KatModul\Application\Controller\Admin\ArticleAttributeKat::class,
    // ),
    // 'controllers' => array(
     //   'ArticleAttributeKat' => \OxidCommunity\hdiReport\Controller\Admin\ArticleAttributeKat::class,
    
  ];  
 
//error_log( E_ALL );
//echo " mettatag";

