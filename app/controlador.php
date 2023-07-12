<?php 
include_once('../class/usuarioClass.php');
session_start();
$objCan=new Usuario();


if(isset($_POST['usuario']) && isset($_POST['password']))
{
	$usuario=$_POST['usuario'];
	$password=md5($_POST['password']);

	$datos=$objCan->Validar_Usuario($usuario,$password);
	

	if($datos[0]>0)	
	{
		$_SESSION['usuario']=$usuario;
		$_SESSION['nombres']=($datos[1][0]->pers_nombres);
		$_SESSION['paterno']=($datos[1][0]->pers_apellpaterno);
		$_SESSION['materno']=($datos[1][0]->pers_apellmaterno);
		header('location:actividades.php');
	}
	
	else{
		header('location:../index.php');
	}

}

else{
	header('location:../index.php');
}

 ?>
