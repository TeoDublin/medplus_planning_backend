<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2025-01-18';
$busy=$ret=[];
$is_first=true;
function busy_row($busy_row){
    if(!$busy_row)return ['id'=>'-','origin'=>'-','motivo'=>'-'];
    else return [
        'id'=>"{$busy_row['origin']}_{$busy_row['id']}",
        'origin'=>$busy_row['origin'] ?? '-',
        'reason'=>$busy_row['motivo'] ?? '-'
    ];
}
$planning=(new Select('*'))->from('planning')->where("id_terapista = {$_REQUEST['id_terapista']} AND data='{$_REQUEST['data']}'")->get();
foreach($planning as $plan)for($i=$plan['row_inizio'];$i<=$plan['row_fine'];$i++)$busy[$i]=$plan;
foreach((new Select('id,DATE_FORMAT(ora,\'%H:%i\') as hour'))->from('planning_row')->get() as $row){
    $busy_row=busy_row($busy[$row['id']]);
    if($busy_row['id']=="-"){
        $ret[]=[
            'id'=>$row['id'],
            'related_id'=>$busy_row['id'],
            'hour'=>$row['hour'],
            'origin'=>$busy_row['origin'],
            'reason'=>$busy_row['reason'],
        ];
    }
    elseif($is_first){
        $row_span=0;$related_id=$busy_row['id'];(int)$row_id=$row['id'];
        while ($related_id==$busy_row['id']) {
            $related_id=busy_row($busy[++$row_id])['id'];
            $row_span++;
        }
        $ret[]=[
            'id'=>$row['id'],
            'related_id'=>$busy_row['id'],
            'hour'=>$row['hour'],
            'origin'=>$busy_row['origin'],
            'reason'=>$busy_row['reason'],
            'row_span'=>$row_span
        ];
        $is_first=false;
    }
    else {
        $ret[]=['id'=>$row['id'],'hour'=>$row['hour']];
        if(--$row_span==0)$is_first=true;
    }
}
echo json_encode((object)['planning_row'=>$ret]);