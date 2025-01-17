<?php
include '../functions.php';
include '../class/select.php';
$_REQUEST['id_terapista']=11;
$_REQUEST['data']='2024-12-30';
echo json_encode((new Select('p.id,p.motivo as reason, p.origin, pr.ora as start, pe.ora as end'))
    ->from('planning','p')
    ->left_join('planning_row pr ON p.row_inizio = pr.ID')
    ->left_join('planning_row pe ON p.row_fine = pe.ID')
    ->where("p.id_terapista = {$_REQUEST['id_terapista']} AND p.data='{$_REQUEST['data']}'")
    ->get()
);