<?php
	include_once('../class/detalleClass.php');
	$objDetalle=new Detalle();
    $ide_detalle=$_POST['ide_detalle'];
    $estado=$_POST['estado'];
    $actualizacion=$objDetalle->Actualizar_Detalle($ide_detalle,$estado);
		
	if($actualizacion)
    {
        print json_encode(true);
    }
    else{
        print json_encode(false);
    }
?>