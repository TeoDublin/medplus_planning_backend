<?php
include '../class/select.php';
echo json_encode((new Select('*'))->from('planning')->where('id_terapista = 11')->get());