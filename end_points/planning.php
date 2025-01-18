<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2025-01-18';
$busy=$ret=[];
$planning=(new Select('*'))->from('planning')->where("id_terapista = {$_REQUEST['id_terapista']} AND data='{$_REQUEST['data']}'")->get();
foreach($planning as $plan)for($i=$plan['row_inizio'];$i<=$plan['row_fine'];$i++)$busy[$i]=$plan;
foreach((new Select('id,DATE_FORMAT(ora,\'%h:%m\') as ora'))->from('planning_row')->get() as $row){
    $ret[$row['id']]=[
        'id'=>$row['id'],
        'hour'=>$row['ora'],
        'origin'=>$busy[$row['id']]['origin']??'-',
        'reason'=>$busy[$row['id']]['motivo']??'-',
    ];
}
echo json_encode($ret);