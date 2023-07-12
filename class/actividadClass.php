<?php
  include_once('../cnx/connection.php');
  class Actividades
  {
    function Buscar_Actividad($usuario)
    {
        $objCnx=new Connection();
        $stmt  = $objCnx->obj_pgsql->prepare("
        SELECT a.ide_actividad,a.descripcion_actividad,a.fecha_inicio,a.fecha_fin,sum(
            CASE 
       
                 WHEN EXTRACT(DAY FROM(d.fecha_fin - now()))>2  THEN 0
                 WHEN EXTRACT(DAY FROM(d.fecha_fin - now()))<=2 and d.estado_detalle=0  THEN 1
                
                 ELSE 0
            END) as conta
       from actividad a
     left JOIN detalle d  on a.ide_actividad=d.ide_actividad 
     where   a.usuario=? group by a.ide_actividad,a.descripcion_actividad,
     a.fecha_inicio,a.fecha_fin  order by conta desc ");
        $stmt->execute([$usuario]);
        $stmt2  = $objCnx->obj_pgsql->prepare("select * from actividad order by ide_actividad desc limit 1");
        $stmt2->execute();
        return array($stmt->fetchAll(PDO::FETCH_OBJ));    
        $objCnx->CloseConnection();
    }

      function Buscar_Actividad_Fecha($inicio,$fin,$usuario)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare("select * from actividad where fecha_fin between ? and ? and usuario=?");
          $stmt->execute([$inicio,$fin,$usuario]);
          return array($stmt->fetchAll(PDO::FETCH_OBJ));   
          $objCnx->CloseConnection();
      }
    
      function Registrar_Actividad($descripcion_actividad, $fecha_inicio, $fecha_fin,$usuario)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare('insert INTO public.actividad(
                                                descripcion_actividad, fecha_inicio, fecha_fin,usuario)
                                                VALUES (?, ?, ?,?);');
          $stmt->execute([$descripcion_actividad, $fecha_inicio, $fecha_fin,$usuario]);
          $stmt2  = $objCnx->obj_pgsql->prepare("select * from actividad order by ide_actividad desc limit 1");
          $stmt2->execute();
          return array($stmt2->fetchAll(PDO::FETCH_OBJ));
          $objCnx->CloseConnection();
      }  
  }

?>