<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2024-12-30';
$busy=$ret=[];
$select=new Select('*');
$planning=$select->from('planning')->where("id_terapista = {$_REQUEST['id_terapista']} AND data='{$_REQUEST['data']}'")->get();

echo "test";
