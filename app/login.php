<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link href="{{asset('public/css/login.css') }}" rel="stylesheet">   

    <style>
        *{
    margin:0;
    padding:0;
        }
        .contenedor-login{
            background:#008788;
            min-height:50vh;
        }
        body{
        background: #C7C6C8;
        }
        .contenedor-login label
        {
            padding:0;
            font-size:14px;
            font-weight:500;
        }
        .contenedor-login input
        {
            margin-bottom:20px;
            border:1px solid #ccc;
        }
        #mostrarContraseña{
            border:1px solid #ccc;
            border-left:0
        }

    </style>
</head>
<body>
    <div class="">
        <div class="contenedor-login d-flex justify-content-center row m-0">
            <div class=" row bg-white col-11 col-md-6 col-lg-3 " style="position:fixed;top:30vh">
                <form class="col-12 row p-4 m-0" method="post" action='controlador.php'>
                   
                    <div class="col-12">
                    <!-- <img src="src/img/icono-usuario.png" width='20px' alt=""> -->
                    <h5 class=" text-center " style="font-weight:bold; border-bottom:1px solid #ccc" for=""><i class="fas fa-user"></i> INICIAR SESIÓN</h5>
                    </div>
                    
                    <label class="col-12" for="usuario">USUARIO</label>
                    <input class="col-12" type="text" name="usuario" id="usuario" required placeholder='Usuario'>

                    <label class="col-12" for="password">CONTRASEÑA</label>
                    <input class="col-11" id="userPassword" type="password" name="password" id="password" placeholder='Password' style="border-right:0" required>
                    <i id="mostrarContraseña" style="cursor:pointer; height:26px;color:#bbb" class="col-1 m-0 p-0 fas fa-eye d-flex align-items-center "></i>
                    
                    <button id="ingresarLogin" class="btn btn-small text-white col-12" style="background:#008788; font-size:14px"><i class=" fas fa-sign-in-alt"></i> INICIAR SESIÓN</button>
                    
                    <!-- @if(isset($status))
                        <div class="alert alert-danger col-12 mt-2 mb-0 p-2" role="alert" >
                            <label for="">Contraseña o usuario incorrectos</label> 
                        </div>
                       
                    @endif -->
                    
                </form>
            </div>
        </div>
    </div>
  
<script>
    $('#mostrarContraseña').mousedown(e=>{
        $('#mostrarContraseña').css('color','#111')
        $('#userPassword').attr('type','text')
    })

    $('#mostrarContraseña').mouseup(e=>{
        $('#mostrarContraseña').css('color','#bbb')
        $('#userPassword').attr('type','password')

    })
</script>
</body>
</html>
