<!DOCTYPE html>
<html lang="es">
<head>
<title>Ingreso Usuarios</title>
   <meta name="viewport" content="width=device-width , maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jqusery-latest.min.js"></script>
    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="sty.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
   <div class="logo">
  <p><img src="images/LogoDrypersBlack2.png" alt="" width="92" height="130" align="left">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INFORMES CORPORATIVOS <span class="frase"><span class="logp">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
    <span class="frase"><span class="logp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/LogoTic.jpg" alt="" width="70" height="64"></span></span></span>
  <p><span class="frase"> &quot;El sentido de pertenencia fortalece el sentimiento de que todos somos uno&quot;<span class="logp"> &nbsp;</span></span>  
  <p><br>
</div>
   <div class="wrap">
    <div class="content">
    <div class="wrap">
    <form id="form" name="form" method="post" action="" align="center" width="60%">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table width="55%" border="0"align="center">
        <tr>
        <td width="26%" rowspan="2" align="center" bgcolor="#FFF"><img src="images/business_user_next.png" width="121" height="128"></td>
        <td width="34%" height="83" bgcolor="#FFF" align="center"></p>
        <strong>Usuario</strong></td>
        <td height="83" colspan="2" align="center" bgcolor="#FFF"><p>&nbsp;</p>      
           <p><strong>
             <input name="txtusuario" type="text" class="input" id="txtusuario" placeholder="ID Usuario" onclick="this.value=''" value=" "/>
           </strong></p>
           <p><strong><br>
           </strong></p>
           <p>&nbsp;</p> <p>
             <label for="txtusuario5"></label>
           </p></td>
          </tr>
       <tr>
         <td width="34%" bgcolor="#FFF"><p><strong><br>
           Contraseña </strong></p></td>
          <td width="40%"><p>
            <label for="clave"><br>
            </label>
            <input name="txtclave" type="password" class="input" id="txtclave" placeholder="Digite la Clave" onClick="this.value=''" value=" "/>
          </p></td>
        </tr>
        <tr>
        <td colspan="3" align="right"><p>
          &nbsp;&nbsp;&nbsp;<input name="ingresar" type="submit" id="guardar" value="Ingresar" align="center"/>
        </p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>
         <p>&nbsp;</p>
    <div class="clear"></div>
  </div>
  <div class="footer">
  </div>
    <div class="clear"></div></div></div>
</div>
</body>
</html>
<?
$conexion=mysql_connect("127.0.0.1","root", "");
if(!$conexion){
  echo"Error de conexion";
              } else{
  echo "";
        }
//seleccion de la Bd   
if (!mysql_select_db("autenticacion",$conexion)){
    echo "Error al seleccionar la bases de datos";
  } else{
   
    echo"";
  }
$usuario=$_POST['txtusuario'];
$clave=$_POST['txtclave'];
if(isset($_POST['ingresar']))
{
$sSQL=mysql_query("SELECT id_perfil FROM usuarios WHERE id_usuario='$usuario' AND clave='$clave'");
while($consulta=mysql_fetch_row($sSQL)){
 if($consulta[0]=='01')
  {
  echo "<meta http-equiv= 'refresh' content = '0; url=./index.php'>";
  echo"<script type=\"text/javascript\">alert('Ingreso Correcto');window.location='index.php';</script>";
  }  
  else{
      echo"<script type=\"text/javascript\">alert('Datos Incorrectos');window.location='index.php';</script>";
      }
  //if($consulta!='01'){
    // }
  }
}
?>