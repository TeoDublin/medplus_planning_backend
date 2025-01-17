<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2024-12-30';
$busy=$ret=[];
$select=new Select('*');

$row_planning=$select->from('planning_row')->get();
echo "test2";
