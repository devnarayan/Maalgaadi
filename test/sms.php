<?php
include '../includes/define.php';
$unicode = 1;
$mobileno = 8982479053;
$message = "आप इन्टरनेट क्षेत्र से बहार हैं, कृपया जांचे एवं इन्टरनेट क्षेत्र में आए |";
$senderid = "101010";
sendsms($mobileno, $message, $senderid, $unicode);
