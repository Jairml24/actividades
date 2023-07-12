<?php
include_once('../class/actividadClass.php');
session_start();
$usuario=$_SESSION['usuario'];
$objActividades=new Actividades();
$html='';
	
if(isset($_POST['fch_inf']))
{
	$actividades=$objActividades->Buscar_Actividad_Fecha($_POST['fch_inf'],$_POST['fch_sup'],$usuario);
}

else{
	$actividades=$objActividades->Buscar_Actividad($usuario);
}
		
$html.=' <table class="table" style="font-size:13px">
            <thead class="thead-light">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Actividad</th>
                <th scope="col">Inicio</th>
                <th scope="col">Fin</th>
                <th scope="col">Detalle</th>
                <th style="width:200px" scope="col">Actividades por vencer (menos de 2 dias)</th>
                </tr>
            </thead>
            <tbody>';
			$i=1;

foreach ($actividades[0] as $actividad) {
    if($actividad->conta==0)
    {
        $alerta='success';
    }
    else if($actividad->conta<3)
    {
        $alerta='warning';

    }
    else if($actividad->conta>2)
    {
        $alerta='danger';

    }
	$html.='<tr class="info">
				<td class="d-none p-2" >'. $actividad->ide_actividad .'</td>
				<td class="p-2" >'.$i++.'</td>	
				<td  class="p-2">'. $actividad->descripcion_actividad .'</td>
				<td  class="p-2">' .$actividad->fecha_inicio .'</td>
				<td  class="p-2">' .$actividad->fecha_fin .'</td>
				<td  class="p-1">  <button class="btn btn-info btn-sm d-inline detalle" type="button" id="btnConsulta" > <i class="fa fa-search"></i>Detalle</button></td>
				<td  class="p-1"><div class="m-0 p-1 alert alert-'.$alerta.' text-center" role="alert"><span class="m-0 p-1 px-3 badge badge-'.$alerta.'">
                ' .$actividad->conta .'</span>
                </div></td>

            </tr>	';
}  

$html.='</tbody>
    </table>';
		
$data=$html;
print json_encode($data);	
?>