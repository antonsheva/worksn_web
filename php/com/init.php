<?php
$A_db = new \classesPhp\ClassDb();
$G = new \structsPhp\G();
$P = new \classesPhp\ClassPost();
$S = new \classesPhp\ClassSession();

new \classesPhp\ClassChpu();

$M = new \classesPhp\ClassMsg();
$A = new \classesPhp\ClassAds();
$U  = new \classesPhp\ClassUser();
$O = new \classesPhp\ClassOwner();
$U_review = new \classesPhp\ClassUserReview();
$AC_img = new \classesPhp\ClassImg();
$LOG = new \classesPhp\ClassLog();
$A_context = new \classesPhp\ClassContext();
new \classesPhp\ClassController();

$G->act = ACT_FULL_PAGE;
$A_context->APrintContext();