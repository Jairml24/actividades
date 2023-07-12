<?php
session_start();
if(isset($_SESSION['usuario']))
{
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actividades</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
</head>
<style>
    *{
        margin:0;
        padding:0;
    }

    .div-btn{
        top: 27px;
        margin:0px;
    }

    label{
        font-size:12px
    }
    input{
        font-size:14px!important;
    }

    .pendiente{
           background-color:#FA8072;
       }
       .realizado{
            background-color:#28B463 ;
            

       }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] { -moz-appearance:textfield; }
    @media print{
        .no_print{
            display:none;
        }             
        #mensaje {
            background-color: yellow;
            -webkit-print-color-adjust: exact;
        }
        tr.row-coactiva, .msn-coactiva, .msn-captura{
            background-color: red !important;
            -webkit-print-color-adjust: exact;      
        }        
        .row-coactiva td {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;   
        }
        @page {
            size:landscape;
            margin:10mm 0mm 0mm 10mm;
        }
       
      
    }

</style>
<body>
<!-- ----------------------------------------------- -->
<!-- ENCABEZADO Y FORMUALARIO DE BUSQUEDA  -->
<!-- -------------------------------------------------------- -->
<div style='height:30px;background:#004892' class='row w-100 m-0 px-3'>
    <h6 class='text-white col-6 d-flex align-items-center '>Lista de Actividades</h6>
    <h6 class='text-white col-6 d-flex align-items-center justify-content-end '><?php echo $_SESSION['nombres'] ?>  <a href="logout.php"><img src="../img/flecha.png" width='20px' class='ml-2' alt=""></a></h6>
</div>
    <form id="frmConsultaActividad"  class='no_print pl-2 pt-1' style='border-bottom:1px solid #ccc'>
        <div class="row mr-0">   
            <div class="col-12 col-md-3">
                <div class="form-group mr-0">
                    <label for="dni_cnt" class="d-inline">DESDE</label>
                    <input type="date" class="form-control" id="fch_inf" name="fch_inf" >          
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="codigo_cnt" class="d-inline">HASTA</label>
                    <input type="date" class="form-control" id="fch_sup" name="fch_sup" >
                </div>
            </div>			 
            <div class="col-12 col-md-3 div-btn">
                <div class="form-group">
                    <button class="btn btn-success btn-sm mb-3 d-inline" type="button" id="btnConsulta" > <i class="fa fa-search"></i> Consultar</button>
                    <button class="btn btn-primary btn-sm mb-3 d-inline" type="button" id="btn_reg" > <i class="fa fa-search"></i> Nuevo Actividad</button>
                </div>
            </div>
        </div>
    </form>

<!-- ----------------------------------------------- -->
    <!-- RESULTADOS  DE CONSULTA PARA LISTAR ACTIVIDADES-->
<!-- ----------------------------------------------- -->
    <div CLASS='p-2' style='max-height:80vh;overflow-x:auto' id='resultado'></div>


<!-- ----------------------------------------------- -->
    <!-- FORMALARIO PARA REGISRAR ACTIVIDAD  -->
<!-- ----------------------------------------------- -->
    <div id='form_reg_act' class='px-4 py-3'  style='display:none; position:fixed;top:10%; left:10%;z-index:10;background:#fff; width:80%'>
        <form method='POST'  id='form_reg_actividad' action=""> 
            <div class='d-flex justify-content-between mb-3' style='border-bottom:1px solid #ccc'>
                <h5 for="">Nuevo Registro</h5>
                <div class="col-1">
                    <button type="button" class="close" aria-label="Close">
                        <span class='btn_cerrar' aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <input type="text" style='display:none' class="form-control" name='ide_ins' id="ide_ins"  readonly>
            <div class='row'>   
                <input type="number" class="form-control d-none" value='1' name='funcion' id="funcion" placeholder="">
                <div class="form-group col-12 col-md-12">
                    <label for="descripcion_actividad">Actividad</label>
                    <input type="text" class="form-control" name='descripcion_actividad' id="descripcion_actividad" placeholder="">
                    <small style='display:none' id="descripcion_actividad_error" class="error text-danger">*Ingrese  actividad</small>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="fecha_inicio_actividad">Inicio</label>
                    <input type="date" class="form-control" name='fecha_inicio_actividad' id="fecha_inicio_actividad" value="<?php echo date("Y-m-d") ?>" placeholder="">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="fecha_fin_actividad">Fin</label>
                    <input type="date" class="form-control" name='fecha_fin_actividad' id="fecha_fin_actividad" value="<?php echo date("Y-m-d") ?>" placeholder="">
                </div>
            </div><br>       
            <button type="submit" id='btn_env_reg' class="btn btn-primary w-100">Registrar</button>
        </form>  
    </div>


<!-- ----------------------------------------------- -->
    <!-- MODAL DE DETALLE  DE ACTIVIDADES  -->
<!-- ----------------------------------------------- -->
    <div id='div_detalle' class='px-4 py-3 '  style='display:none; position:fixed;top:5%; left:5%;z-index:10;background:#fff; width:90%;max-height:90%'>
        <form method='POST'  action="registro_papeleta.php">
            <div class='d-flex justify-content-between mb-3' style='border-bottom:1px solid #ccc'>
                <h5 for="">Actividad</h5>
                <div class="col-1">
                    <button type="button" class="close" aria-label="Close">
                        <span class='btn_cerrar' aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <!-- CONTENEDOR DE LA LISTA DE DETALLE DE UNA ACTIVIDAD  -->
            <div  id='res_detalle'>

            </div><br>
            <!-- ---------------------------------------------------------- -->
            <div style=' border-top:1px solid #ccc'>
                <label for="">Menos de dos dias para vencer</label>
                <label class='bg-danger text-danger mr-5' for="">-----------</label>
                <label for="">Realizado</label>
                <label class='bg-success text-success' for="">-----------</label>
                <button style='margin-left:50%' class="btn btn-info btn-sm d-inline detalle" type="button" id="btn_reg_nvo_det"><i class="fa fa-search"></i>Agregar Detalle</button>
            </div>
        </form>  
    </div>


<!-- ----------------------------------------------- -->
    <!-- FORMULARIO PARA REGISTAR EL DETALLE DE UNA ACTIVIDAD  -->
<!-- ----------------------------------------------- -->    
    <div id='form_reg_det' class='px-4 py-3'  style='display:none; position:fixed;top:10%; left:10%;z-index:10;background:#fff; width:80%'>
        <form method='POST'  id='form_reg_detalle' action="">        
            <div class='d-flex justify-content-between mb-3' style='border-bottom:1px solid #ccc'>
                <h5 for=""></h5>
                <div class="col-1">
                    <button type="button" class="close" aria-label="Close">
                        <span class='btn_cerrar' aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-md-12">
                    <label for="descripcion_actividad">Actividad</label>
                    <div id='act' class="estado alert alert-primary alert-dismissable"></div>
                </div>
            </div>

            <h6 for="">Detalle de Actividad</h6>
            <div class='row'>
                <input type="text" class="form-control d-none" name="ide_actividad" id="ide_actividad"  placeholder="">
                <div class="form-group col-12 col-md-4">
                    <label for="descripcion_detalle">Descripción</label>
                    <input type="text" class="form-control" name="descripcion_detalle" id="descripcion_detalle"  placeholder="">
                    <small style='display:none' id="descripcion_detalle_error" class="error text-danger">*Ingrese Descripcion</small>
                </div>  
                <div class="form-group col-12 col-md-2">
                    <label for="fecha_inicio">Inicio</label>
                    <input type="date" class="form-control" name='fecha_inicio' id="fecha_inicio"  value="<?php echo date("Y-m-d") ?>" placeholder="">
                </div>
                <div class="form-group col-12 col-md-2">
                    <label for="fecha_fin">Fin</label>
                    <input type="date" class="form-control" name='fecha_fin' id="fecha_fin"  value="<?php echo date("Y-m-d") ?>" placeholder="">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="responsable">Responsable</label>
                    <input type="text" class="form-control" name='responsable' id="responsable"  placeholder="">
                    <small style='display:none' id="responsable_error" class="error text-danger">*Ingrese responsable</small>

                    <label for="" id='data_nombre_1'><?php echo $_SESSION['nombres'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?></label>
                    <input type="checkbox" id='check_1'>
                </div>
                
                <div class="form-group col-12 col-md-5 ml-5">
                    <button type="submit" id='btn_env_det' class="btn btn-primary w-100">Registrar</button>
                </div>

                <div class="form-group col-12 col-md-5">
                    <button type="submit" id='btn_ter' class="btn btn-success w-100">Terminar</button>
                </div>
            </div> 
        </form>  
    </div>


 <!-- ----------------------------------------------- ------------------------------------>
    <!-- FORMULARIO PARA REGISTAR EL DETALLE DE UNA ACTIVIDAD DESDE MODAL DETALLE -->
<!-- ----------------------------------------------- -------------------------------------> 
    <div id='form_reg_nvo_det' class='px-4 py-3'  style='display:none; position:fixed;top:10%; left:10%;z-index:10;background:#fff; width:80%'>
        <form method='POST'  id='form_reg_detalle_det' action="">        
            <div class='d-flex justify-content-between mb-3' style='border-bottom:1px solid #ccc'>
                <h5 for=""></h5>
                <div class="col-1">
                    <button type="button" class="btn_cerrar_nvo_det close" aria-label="Close">
                        <span class='' aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
         
           <div class="row">
                <div class="form-group col-12 col-md-12">
                    <label for="descripcion_actividad">Actividad</label>
                    <div id='acti' class="estado alert alert-primary alert-dismissable"></div>
                </div>
           </div>

            <h6 for="">Detalle de Actividad</h6>
            <div class='row'>
                <input type="text" class="form-control d-none" name="ide_actividad_det" id="ide_actividad_det"  placeholder="">
                <div class="form-group col-12 col-md-4">
                    <label for="descripcion_detalle_det">Descripción</label>
                    <input type="text" class="form-control" name="descripcion_detalle_det" id="descripcion_detalle_det"  placeholder="">
                    <small style='display:none' id="descripcion_detalle_det_error" class="error text-danger">*Ingrese Descripción</small>
                </div>  
                <div class="form-group col-12 col-md-2">
                    <label for="fecha_inicio_det">Inicio</label>
                    <input type="date" class="form-control" name='fecha_inicio_det' id="fecha_inicio_det"  value="<?php echo date("Y-m-d") ?>" placeholder="">
                    <small style='display:none' id="fecha_inicio_error" class="error text-danger">*Ingrese Área</small>
                </div>
                <div class="form-group col-12 col-md-2">
                    <label for="fecha_fin_det">Fin</label>
                    <input type="date" class="form-control" name='fecha_fin_det' id="fecha_fin_det"  value="<?php echo date("Y-m-d") ?>" placeholder="">
                    <small style='display:none' id="fecha_fin_error" class="error text-danger">*Ingrese Área</small>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="responsable_det">Responsable</label>
                    <input type="text" class="form-control" name='responsable_det' id="responsable_det"  value ="" placeholder="">
                    <small style='display:none' id="responsable_det_error" class="error text-danger">*Ingrese responsable</small>

                    <label class="" for="" id='data_nombre'><?php echo $_SESSION['nombres'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?></label>
                    <input type="checkbox" id='check'>

                </div>
               
                <div class='row col-12'>
                    <div class="form-group col-12 col-md-5">
                        <button type="submit" id='btn_env_nvo_det' class="btn btn-primary w-100">Registrar</button>
                    </div>

                    <div class="form-group col-12 col-md-5">
                        <button type="submit" id='btn_nvo_ter' class="btn btn-success w-100">Terminar</button>
                    </div>
                </div>
                
            </div> 
        </form>  
    </div>


     <!-- ----------------------------------------------- ------------------------------------>
    <!-- FORMULARIO EDITAR DETALLE -->
<!-- ----------------------------------------------- -------------------------------------> 
<div id='form_reg_edi_det' class='px-4 py-3'  style='display:none; position:fixed;top:10%; left:10%;z-index:10;background:#fff; width:80%'>
        <form method='POST'  id='form_edi_detalle' action="">        
            <div class='d-flex justify-content-between mb-3' style='border-bottom:1px solid #ccc'>
                <h5 for="">Editar Detalle</h5>
                <div class="col-1">
                    <button type="button" class="btn_cerrar_nvo_det close" aria-label="Close">
                        <span class='' aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
         

            <h6 for="">Detalle de Actividad</h6>
            <div class='row'>
                <input type="text" class="form-control d-none" name="ide_actividad_edi" id="ide_actividad_edi"  placeholder="">
                <div class="form-group col-12 col-md-4">
                    <label for="descripcion_detalle_edi">Descripción</label>
                    <input type="text" class="form-control" name="descripcion_detalle_edi" id="descripcion_detalle_edi"  placeholder="">
                    <small style='display:none' id="descripcion_detalle_edi_error" class="error text-danger">*Ingrese Descripción</small>
                </div>  
                <div class="form-group col-12 col-md-2">
                    <label for="fecha_inicio_det">Inicio</label>
                    <input type="date" class="form-control" name='fecha_inicio_edi' id="fecha_inicio_edi"  value="" placeholder="">
                    <small style='display:none' id="fecha_inicio_error" class="error text-danger">*Ingrese Área</small>
                </div>
                <div class="form-group col-12 col-md-2">
                    <label for="fecha_fin_edi">Fin</label>
                    <input type="date" class="form-control" name='fecha_fin_edi' id="fecha_fin_edi"  value="" placeholder="">
                    <small style='display:none' id="fecha_fin_error" class="error text-danger">*Ingrese Área</small>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="responsable_edi">Responsable</label>
                    <input type="text" class="form-control" name='responsable_edi' id="responsable_edi"  value ="" placeholder="">
                    <small style='display:none' id="responsable_edi_error" class="error text-danger">*Ingrese responsable</small>

                
                </div>
               
                <div class='row col-12'>
                    <div class="form-group col-12 col-md-5">
                        <button type="submit" id='btn_edi_det' class="btn btn-primary w-100">Actualizar</button>
                    </div>
                </div>
                
            </div> 
        </form>  
    </div>

<!-- ----------------------------------------------- -->
<!-- FONDO TRANSPARENTE  -->
<!-- ----------------------------------------------- --> 
    <div id='fondo' style=" display:none;background-color: #000; position:fixed; z-index:1; opacity:0.5;width:100%;height:100%;top:0;left:0"></div> 
    <div id="resultado" style='margin:0;padding:0'> </div>
</body>


<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- SCRIPTS JS  -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->

<script>
// BOTON PARA CERRAR MODALES 
$(".btn_cerrar").click(e=>{
    $("#form_reg_act").hide()
    $("#form_reg_det").hide()
     $("#div_detalle").hide()
    $("#fondo").hide()
            
    $("#res_detalle").html('');
 })
    

// EVENTO PARA CARGAR LA LISTA DE ACTIVIDIDADES AL CARGAR LA PAGINA
document.addEventListener("DOMContentLoaded", function(){
    $.ajax({
        url: "actividad_ajax.php",     
        type: "POST",
        dataType:'json',
        beforeSend:function ()
        { 
            $("#resultado").html('Cargando...');  
        },
        success:function(data)
        {  
            $("#resultado").html(data);    
        }
    })
});


//EVENTO PARA CAMBIAR EL ESTADO DETALLE DE ACTIVIDAD
document.getElementById('div_detalle').addEventListener('click', e => {
    if(e.target.classList.contains('cambiar')){
        e.preventDefault()
        let ide_detalle=e.target.parentElement.parentElement.children[0].innerHTML,
            estado=e.target.parentElement.parentElement.children[6].innerHTML
            valor='',
            nuevo_estado='',
            clase='',
            clase2='';

        if(estado=='REALIZADO')
        {
            valor='0';
            nuevo_estado='PENDIENTE'
            if(e.target.parentElement.parentElement.children[7].innerText<=2){
                clase='pendiente';
                clase2='text-white';
            }
            else{
                clase='bg-white';
                clase2='text-dark';
            }
        }
        else{
            valor='1';
            nuevo_estado='REALIZADO'
            clase='realizado';
            clase2='text-white';
        }

        // MODIFICACION DE ESTADO DETALLE
        $.ajax({
            url: "estado_detalle.php",  
            data:{"ide_detalle":ide_detalle,"estado":valor},   
            type: "POST",
            dataType:'json',
            
            success:function(data)
            {  
              console.log(data)
                // SI SE REALIZA EL CAMBIO DE ESTADO EN LA BASE DE DATOS , SE ACTUALIZA LOS COLORES EN EL MODAL 
                if(data)
                {
                    e.target.parentElement.parentElement.children[6].innerText=nuevo_estado 
                    e.target.parentElement.parentElement.classList.remove('pendiente','realizado','bg-white','text-white','text-dark');
                    e.target.parentElement.parentElement.classList.add(clase,clase2);
                }  
            }
        })       
    }
});


// EVENTO PARA VER EL DETALLE DE UNA ACTIVIDAD 
$('#resultado').on('click', '.detalle', e =>{
    let ide=e.target.parentElement.parentElement.children[0].innerHTML
    $("#div_detalle").show()
    $("#fondo").show()

    // CONSULTA PARA LISTAR DETALLE 
    $.ajax({
        url: "detalle_ajax.php",  
        data:{"ide":ide},   
        type: "POST",
        dataType:'json',
        beforeSend:function ()
        { 
            $("#resultado_detalle").html('Cargando...');  
        },
        success:function(data)
        {  
            $("#res_detalle").html(data);  
        }
    })
});


//EVENTO PARA ABRIR MODAL DE REGISTAR ACTIVIDAD
$("#btn_reg").click(e=>{
    $("#form_reg_act").show()
    $("#fondo").show()
})

//EVENTO PARA ENVIAR DATOS PARA REGISTRO DE ACTIVIDAD
$("#btn_env_reg").click(e=>{
    e.preventDefault()
    if($("#descripcion_actividad").val()=='')
    {      
        $("#descripcion_actividad_error").show()
        return false
    }

    let values=$('#form_reg_actividad').serialize()
    $.ajax({
        url: "registrar_actividad.php",  
        data:values,   
        type: "POST",
        dataType:'json',

        // CUANDO SE REALIZA ELREGISTRO DE ACTIVIDAD SE TRAE EL IDE DE ACTIVIDAD Y SE ABRE EL MODAL DE REGISTRO DE DETALLE 
        success:function(data)
        {  
            $("#ide_actividad").val(data[0][0].ide_actividad)
            $("#act").html(data[0][0].descripcion_actividad)
            $("#form_reg_act").hide()
            $("#form_reg_det").show()
        }
    })
})


//EVENTO PARA ENVIAR DATOS PARA REGISTRO DE DETALLE
$("#btn_env_det").click(e=>{
    e.preventDefault()
    $("#descripcion_detalle_error").hide()
    $("#responsable_error").hide()

    if($("#descripcion_detalle").val()=='')
    {      
        $("#descripcion_detalle_error").show()
        return false
    }
    if($("#responsable").val()=='')
    {      
        $("#responsable_error").show()
        return false
    }

    let detalle=$('#form_reg_detalle').serialize()
    $.ajax({
        url: "registra_detalle.php",  
        data:detalle,   
        type: "POST",
        dataType:'json',
        success:function(data)
        {                
            $("#responsable").val('')
            $("#descripcion_detalle").val('')
        }
    })
})

//EVENTO PARA BOTON TERMINAR, (TERMINAR REGISTRO DE DETALLE)
$("#btn_ter").click(e=>{
    e.preventDefault()
    $("#form_reg_det").hide()
    $("#fondo").hide()
    location.reload();
})



//EVENTO PARA REALIZAR BUSQUEDA DE ACTIVIDADES POR FECHA 
$("#btnConsulta").click(e=>{
    if( $("#fch_inf").val()!='' && $("#fch_sup").val()!='')
    {
        let values = $("#frmConsultaActividad").serialize()
        $.ajax({
            url: "actividad_ajax.php",  
            data:values,   
            type: "POST",
            dataType:'json',

            beforeSend:function ()
            { 
                $("#resultado").html('Cargando...');  
            },
            success:function(data)
            {  
                $("#resultado").html(data);    
            }
        })
    }
})


// MODAL PARA REGISTRAR NUEVO DETALLE DESDE ELMODAL DE DETALLE
$("#btn_reg_nvo_det").click(e=>{
     let ide_actividad=e.target.parentElement.parentElement.children[1].children[0].innerText
     let des_actividad=e.target.parentElement.parentElement.children[1].children[1].innerText


    // console.log(ide_actividad)
    // console.log(des_actividad)
    $("#ide_actividad_det").val(ide_actividad)
    $("#acti").html(des_actividad)
    $("#div_detalle").css('z-index',1);  
    $("#form_reg_act").hide()
    $("#form_reg_nvo_det").show()               
})

//CERRAR MODAL 
$(".btn_cerrar_nvo_det").click(e=>{
    $("#form_reg_nvo_det").hide()
    $("#div_detalle").css('z-index',10);  
    $("#form_reg_edi_det").hide()

})


// REGISTAR DETALLE DE MODAL DETALLE
$("#btn_env_nvo_det").click(e=>{
    e.preventDefault()
    $("#descripcion_detalle_det_error").hide()
    $("#responsable_det_error").hide()

    if($("#descripcion_detalle_det").val()=='')
    {      
        $("#descripcion_detalle_det_error").show()
        return false
    }
    if($("#responsable_det").val()=='')
    {      
        $("#responsable_det_error").show()
        return false
    }
    let detalle=$('#form_reg_detalle_det').serialize()

    $.ajax({
        url: "registra_detalle.php",  
        data:detalle,   
        type: "POST",
        dataType:'json',
        success:function(data)
        {                
            $("#responsable_det").val('')
            $("#descripcion_detalle_det").val('')
        }
    })
})


// BOTON CERRAR 
$("#btn_nvo_ter").click(e=>{
    e.preventDefault()
    let ide=$("#ide_act_det").html()
                $("#form_reg_nvo_det").hide()
                // CONSULTA PARA LISTAR DETALLE 
                $.ajax({
                    url: "detalle_ajax.php",  
                    data:{"ide":ide},   
                    type: "POST",
                    dataType:'json',
                    beforeSend:function ()
                    { 
                       
                        $("#div_detalle").css('z-index',10); 
                        $("#res_detalle").html('Cargando...');  
                    },
                    success:function(data)
                    {  
                        $("#res_detalle").html(data);  
                    }
                })
})          

//EVETNO CHECK 
document.getElementById('check').addEventListener("change", e=>{
    if (document.getElementById('check').checked)
    {
        $('#responsable_det').val($('#data_nombre').html())
    }
    if (!document.getElementById('check').checked)
    {
        $('#responsable_det').val('')
    }    
});

document.getElementById('check_1').addEventListener("change", e=>{
    if (document.getElementById('check_1').checked)
    {
        $('#responsable').val($('#data_nombre_1').html())
    }
    if (!document.getElementById('check_1').checked)
    {
        $('#responsable').val('')
    }    
});


// EVENTO BOTO EDITAR 

$('#res_detalle').on('click', '.editar', e =>{
    e.preventDefault()

    let ide_detalle=e.target.parentElement.parentElement.children[0].innerText,
        detalle=e.target.parentElement.parentElement.children[2].innerText,
        inicio=e.target.parentElement.parentElement.children[3].innerHTML,
        fin=e.target.parentElement.parentElement.children[4].innerHTML,
        responsable=e.target.parentElement.parentElement.children[5].innerText;
    
        $('#ide_actividad_edi').val(ide_detalle)
        $('#descripcion_detalle_edi').val(detalle)

        let f_inicio = (inicio.split("/").reverse().join("/")).replace('/','-').replace('/','-');
        let f_fin = fin.split("/").reverse().join("/").replace('/','-').replace('/','-');

        console.log(f_inicio,f_fin)

        document.getElementById('fecha_inicio_edi').value=f_inicio
        document.getElementById('fecha_fin_edi').value=f_fin
        // $('#fecha_fin_edi').val(fin)
        $('#responsable_edi').val(responsable)
    $("#form_reg_edi_det").show()
    $("#div_detalle").css('z-index',1);  

  
});

$('#btn_edi_det').click(e=>{
    e.preventDefault()
    let detalle=$('#form_edi_detalle').serialize()

    $.ajax({
        url: "registra_detalle.php",  
        data:detalle,   
        type: "POST",
        dataType:'json',
        success:function(data)
        {                
            if(data)
            {
                let ide=$("#ide_act_det").html()
                $("#form_reg_edi_det").hide()
                // CONSULTA PARA LISTAR DETALLE 
                $.ajax({
                    url: "detalle_ajax.php",  
                    data:{"ide":ide},   
                    type: "POST",
                    dataType:'json',
                    beforeSend:function ()
                    { 
                       
                        $("#div_detalle").css('z-index',10); 
                        $("#res_detalle").html('Cargando...');  
                    },
                    success:function(data)
                    {  
                        $("#res_detalle").html(data);  
                    }
                })


                
            }
        }
    })
})


// EVENTO BOTO ELIMAR

$('#res_detalle').on('click', '.eliminar', e =>{
    e.preventDefault()

    let ide_eliminacion=e.target.parentElement.parentElement.children[0].innerText
    $.ajax({
        url: "registra_detalle.php",  
        data:{"ide_eliminacion":ide_eliminacion},   
        type: "POST",
        dataType:'json',
        success:function(data)
        {                
            if(data)
            {
                let ide=$("#ide_act_det").html()
                // CONSULTA PARA LISTAR DETALLE 
                $.ajax({
                    url: "detalle_ajax.php",  
                    data:{"ide":ide},   
                    type: "POST",
                    dataType:'json',
                    beforeSend:function ()
                    { 
                       
                        $("#div_detalle").css('z-index',10); 
                        $("#res_detalle").html('Cargando...');  
                    },
                    success:function(data)
                    {  
                        $("#res_detalle").html(data);  
                    }
                })


                
            }
        }
    })
});


</script>

<?php
}
else{
	header('location:../index.php');
}

?>