<?php
	include_once('../class/detalleClass.php');
	$objDetalle=new Detalle();
	$html='';
	$ide_actividad=$_POST['ide'];
	$detalles=$objDetalle->Buscar_Detalle($ide_actividad);
	$html.='
		<label class="d-none" id="ide_act_det">'.$detalles[1][0]->ide_actividad.'</label>
		<div class="estado alert alert-primary alert-dismissable">
			'.$detalles[1][0]->descripcion_actividad.'
			</div>';

	$html.=' <div style="max-height:350px;overflow-y:auto">
				<table class="table" style="font-size:13px">
				<thead class="thead-light">
					<tr>
					<th scope="col">#</th>
					<th scope="col">Detalle</th>
					<th scope="col">Inicio</th>
					<th scope="col">Fin</th>
					<th scope="col">Responsable</th>
					<th scope="col">Estado</th>
					<th scope="col"></th>
					<th scope="col"></th>
					<th scope="col"></th>
					</tr>
				</thead>
				<tbody>';
	$i=1;



	foreach ($detalles[0] as $detalle) {
		if($detalle->estado_detalle==0){$estado='PENDIENTE';$check='';$c='';}
		else{$estado='REALIZADO';$check='checked';$c='realizado';}

		if($detalle->diff<=2 && $detalle->estado_detalle==0 )
		{
			$class='pendiente text-white';
		}
		else if($detalle->estado_detalle==1){
			$class='realizado text-white';
		}
		else{
			$class='';
		}

		$html.='<tr class="info '.$class.'">
					<td class="p-1 d-none" >'. $detalle->ide_detalle .'</td>
					<td class="p-1 " >'.$i++.'</td>	
					<td class="p-1 ">'. $detalle->descripcion_detalle .'</td>
					<td class="p-1 ">' .$detalle->fecha_inicio .'</td>
					<td class="p-1 " id="fecha_fin">' .$detalle->fecha_fin .'</td>
					<td class="p-1 ">' .$detalle->responsable .'</td>
					<td class="p-1 ">' .$estado .'</td>
					<td class="p-1 d-none">' .$detalle->diff .'</td>
					<td class="p-1 m-0 bg-white"><a class="cambiar btn btn-sm btn-outline-primary" href="">Cambiar Estado</a></td>
					<td class="p-1 m-0 bg-white"><button class="btn btn-sm btn-outline-warning editar">Editar</button></td>
					<td class="p-1 m-0 bg-white"><button class="btn btn-sm btn-outline-danger eliminar">Eliminar</button></td>
					<td class="p-1 d-none" >'. $detalle->ide_actividad .'</td>
					<td class="p-1 d-none" >'. $detalle->descripcion_actividad .'</td>
				</tr>	';
	}  

	$html.='
			</tbody>
		</table>
	</div>';
	
	$data=$html;
	print json_encode($data);
?>


