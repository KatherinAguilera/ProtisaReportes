<?
//  Conexion Lib
//  Gestión de Usuarios & Conexion Lib PHP+Mysql
//  by CALL
//  callanos@aol.com
//  ------------------------------
$usr_session = "apl_xxx";
Function Fconectar ()
{
	$dsn = "protisa"; 
	$usuario = "reporte";
	$clave ="";
//  $server="procoldb02";
	//realizamos la conexion mediante odbc
	$conn=odbc_pconnect($dsn, $usuario, $clave);
   return $conn;
};
Function Ferror ( $mensaje_error )
{
 global $mensaje;
 global $color_texto;
 $mensaje = $mensaje_error;
 $color_texto = "Red";
};
Function Fmostar_mensaje ()
{
 global $mensaje;
 //global $color_texto;
  echo "<center>";
  echo "<font COLOR='RED' size='5'>";
  echo "$mensaje";
  echo "</font>";
  echo "</center>";
};
?>