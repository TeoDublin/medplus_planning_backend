<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2025-01-18';
$planning_row=(new Select('id,DATE_FORMAT(ora,\'%H:%m\') as ora'))->from('planning_row')->get();
$planning=(new Select('*'))->from('planning')->where("id_terapista = {$_REQUEST['id_terapista']} AND data='{$_REQUEST['data']}'")->get();
echo json_encode((object)[
    'planning'=>$planning,
    'planning_row'=>$planning_row
]);