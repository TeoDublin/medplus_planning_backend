<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2025-01-18';
$busy=$ret=[];
$skip=$id=0;
function busy_row($busy_row){
    if(!$busy_row)return ['id'=>'-','reason'=>'LIBERO'];
    else return [
        'id'=>"{$busy_row['origin']}_{$busy_row['id']}",
        'reason'=>strtoupper($busy_row['motivo'] ?? '-')
    ];
}
$planning_row=(new Select('id,DATE_FORMAT(ora,\'%H:%i\') as hour'))->from('planning_row')->get();
$total=count($planning_row)-1;
$planning=(new Select('*'))->from('planning')->where("id_terapista = {$_REQUEST['id_terapista']} AND data='{$_REQUEST['data']}'")->get();
foreach($planning as $plan)for($i=$plan['row_inizio'];$i<=$plan['row_fine'];$i++)$busy[$i]=$plan;
for( $i=0;$i<$total;$i++){
    if($skip==0){
        $row=$planning_row[$i];
        $busy_row=busy_row($busy[$row['id']]);
        $related_id=$busy_row['id'];
        while ($related_id==$busy_row['id']&&$id<$total) {
            $related_id=busy_row($busy[++$row_id])['id'];
            $skip++;
            $id = (int)$row['id']+$skip;
        }
        
        $ret[]=[
            'id'=>$busy_row['id'],
            'hour'=>"{$row['hour']} - {$planning_row[$id]['hour']}",
            'reason'=>$busy_row['reason']
        ];
    }
    else --$skip;
}
echo json_encode((object)['planning_row'=>$ret]);