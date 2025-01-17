<?php
include '../class/select.php';
include '../functions.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2024-12-30';
$busy=$ret=[];
$planning=(new Select('*'))->from('planning')->where("id_terapista = {$_REQUEST['id_terapista']} AND data='{$_REQUEST['data']}'")->get();
foreach($planning as $plan)for($i=$plan['row_inizio'];$i<=$plan['row_fine'];$i++)$busy[$i]=$plan;
foreach((new Select('*'))->from('planning_row')->get() as $row){
    $ret[$row['id']]=[
        'id'=>$row['id'],
        'ora'=>$row['ora'],
        'origin'=>$busy[$row['id']]['origin']??'free',
        'motivo'=>$busy[$row['id']]['motivo']??'free',
    ];
}
echo json_encode($ret); 