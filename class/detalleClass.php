<?php
  include_once('../cnx/connection.php');
  class Detalle
  {
      function Buscar_Detalle($ide_actividad)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare("select a.ide_actividad,a.descripcion_actividad, d.ide_detalle,d.descripcion_detalle,d.fecha_inicio,d.fecha_fin,  EXTRACT(DAY FROM(d.fecha_fin - now())) as diff,d.responsable,d.estado_detalle from detalle d inner join actividad a on a.ide_actividad=d.ide_actividad where d.ide_actividad=? order by d.ide_detalle");
          $stmt2  = $objCnx->obj_pgsql->prepare("select * from actividad where ide_actividad=?");
          $stmt->execute([$ide_actividad]);
          $stmt2->execute([$ide_actividad]);
          return array($stmt->fetchAll(PDO::FETCH_OBJ),$stmt2->fetchAll(PDO::FETCH_OBJ));   
          $objCnx->CloseConnection();
      }

      function Registrar_Detalle($ide_actividad, $descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare('insert INTO public.detalle(
                                            ide_actividad, descripcion_detalle, fecha_inicio, 
                                            fecha_fin, responsable)
                                            VALUES (?, ?, ?, ?,  ?);');
          $stmt->execute([$ide_actividad, $descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable]);
          
          if($stmt)
          {
            return true;
          }        
          $objCnx->CloseConnection();
      }

      function Actualizar_Detalle($ide_detalle,$estado)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare('update detalle
                                                SET  estado_detalle=? WHERE ide_detalle=?;');
          $stmt->execute([$estado,$ide_detalle]);
          return true;          
          $objCnx->CloseConnection();
      }

      function Actualizar_Detalle_C($descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable,$ide_detalle)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare('update detalle
          SET  descripcion_detalle=?, fecha_inicio=?, 
          fecha_fin=?, responsable=? WHERE ide_detalle=?;');
          $stmt->execute([$descripcion_detalle, $fecha_inicio, $fecha_fin, $responsable,$ide_detalle]);
          return true;          
          $objCnx->CloseConnection();
      }

      function Eliminar_Detalle($ide_detalle)
      {
          $objCnx=new Connection();
          $stmt  = $objCnx->obj_pgsql->prepare('delete from detalle WHERE ide_detalle=?;');
          $stmt->execute([$ide_detalle]);
          return true;          
          $objCnx->CloseConnection();
      }
  }

?>