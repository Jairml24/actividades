<?php
	include_once('../class/detalleClass.php');

	$objDetalle=new Detalle();

    if(isset($_POST['ide_actividad']))
    {
        $ide_actividad=$_POST['ide_actividad'];
        $descripcion_detalle=$_POST['descripcion_detalle'];
        $fecha_inicio=$_POST['fecha_inicio'];
        $fecha_fin=$_POST['fecha_fin'];
        $responsable=$_POST['responsable'];
    $registro=$objDetalle->Registrar_Detalle($ide_actividad, $descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable);

    }
    if(isset($_POST['ide_actividad_det']))
    {
        $ide_actividad=$_POST['ide_actividad_det'];
        $descripcion_detalle=$_POST['descripcion_detalle_det'];
        $responsable=$_POST['responsable_det'];
        $fecha_inicio=$_POST['fecha_inicio_det'];
        $fecha_fin=$_POST['fecha_fin_det'];
    $registro=$objDetalle->Registrar_Detalle($ide_actividad, $descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable);

    }

    if(isset($_POST['ide_actividad_edi']))
    {
        $ide_detalle=$_POST['ide_actividad_edi'];
        $descripcion_detalle=$_POST['descripcion_detalle_edi'];
        $responsable=$_POST['responsable_edi'];
        $fecha_inicio=$_POST['fecha_inicio_edi'];
        $fecha_fin=$_POST['fecha_fin_edi'];

        $registro=$objDetalle->Actualizar_Detalle_C( $descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable,$ide_detalle);

    }
    
    if(isset($_POST['ide_eliminacion']))
    {
        $ide_detalle=$_POST['ide_eliminacion'];
        $registro=$objDetalle->Eliminar_Detalle($ide_detalle);

    }
		
	if($registro)
    {
        print json_encode(true);
    }
    else{
        print json_encode(false);
    }
	
?>