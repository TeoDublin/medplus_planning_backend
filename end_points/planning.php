<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2025-01-18';
$busy=$ret=[];
$skip=$id=1;
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
    $row=$planning_row[$i];
    $row_id=$i+1;
    if(--$skip<=0){
        $busy_row=busy_row($busy[$row_id]);
        $related_id=$busy_row['id'];
        if($related_id==busy_row($busy[$row_id+1])['id']){
            $row_id++;
            while ($related_id==$busy_row['id']&&$row_id<$total) {
                $related_id=busy_row($busy[$row_id])['id'];
                $skip++;
                $row_id++;
            }
            $id=$skip+$i;
        }
        else $id=$row_id;
        
        $ret[]=[
            'id'=>$busy_row['id'],
            'plan'=>"{$row['hour']}-{$planning_row[$id]['hour']}: {$busy_row['reason']}"
        ];
        $skip=1;
    }
}
echo json_encode((object)['planning_row'=>$ret]);