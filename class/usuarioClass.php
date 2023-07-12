<?php
include_once('../cnx/connection.php');

class Usuario
{	
	function Validar_Usuario($usuario,$password)
    {
        $objCnx = new ConnectionSisadmin();
        $stmt  = $objCnx->obj_pgsql->prepare(" select * from admin.usuario u inner join personal.persona_datos_laborales pl on u.pdla_id=pl.pdla_id  
        inner join personal.persona p on pl.pers_id=p.pers_id
        where usua_login=? and usua_password=?");
        $stmt->execute([$usuario,$password]);
        return array($nro_datos= $stmt->rowCount(),$stmt->fetchAll(PDO::FETCH_OBJ));
        $objCnx->CloseConnectionMpch_New();
    }

  
   
    
}