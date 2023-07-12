<?php
	include_once('../class/detalleClass.php');
	include_once('../class/actividadClass.php');

    session_start();
	$objActividad=new Actividades();
    $descripcion_actividad=$_POST['descripcion_actividad'];
    $fecha_inicio=$_POST['fecha_inicio_actividad'];
    $fecha_fin=$_POST['fecha_fin_actividad'];
    $fecha_fin=$_POST['fecha_fin_actividad'];
    $usuario=$_SESSION['usuario'];

    
    $registro=$objActividad->Registrar_Actividad($descripcion_actividad, $fecha_inicio, $fecha_fin,$usuario);
    $data=$registro;
    print json_encode($data);
	
?>