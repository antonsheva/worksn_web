<?php

$DIR = new \structsPhp\Dir();
$ROOT = $_SERVER['DOCUMENT_ROOT'];
$A_file_log = fopen('my_log.txt', 'a');
$A_err = new \classesPhp\ClassError();
$A_db = new \classesPhp\ClassDb();
$S = new \classesPhp\ClassSession();
$G = new \structsPhp\G();

$A_return = new \classesPhp\ClassReturn();
$P = new \classesPhp\ClassPost();
new \classesPhp\ClassChpu();

$M = new \classesPhp\ClassMsg();
$A = new \classesPhp\ClassAds();
$U  = new \classesPhp\ClassUser();
//$AU = new \classesPhp\ClassAndroidUser();
$O = new \classesPhp\ClassOwner();
$U_review = new \classesPhp\ClassUserReview();
$AC_img = new \classesPhp\ClassImg();
$LOG = new \classesPhp\ClassLog();


$A_context = new \classesPhp\ClassContext();
new \classesPhp\ClassController();


$G->act = 'full_page';
$A_context->APrintContext();

//register_shutdown_function('shutdownFunc');