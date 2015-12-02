<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validación en servidor LDAP con PHP</title>
</head>
<body>

<?php
  //desactivamos los erroes por seguridad
  error_reporting(0);
  //error_reporting(E_ALL); //activar los errores (en modo depuración)

  $servidor_LDAP = "PROCOLDC00";
  $servidor_dominio = "drypers.com.co";
  $dn = $ldap_dn = "dc=DRYPERS,dc=com";
  $usuario_LDAP = "cllanos";
  $contrasena_LDAP = "Sanpedro1";

  $usr = $usuario_LDAP . "@" . $servidor_dominio;
  
  echo "<h3>Validar en servidor LDAP desde PHP</h3>";
  echo "Conectando con servidor LDAP desde PHP...";

  $ad = $conectado_LDAP = ldap_connect($servidor_LDAP);
  ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);

  if ($conectado_LDAP) 
  {
    echo "<br>Conectado correctamente al servidor LDAP " . $servidor_LDAP;

	   echo "<br><br>Comprobando usuario y contraseña en Servidor LDAP";
    $autenticado_LDAP = ldap_bind($conectado_LDAP, 
	       $usuario_LDAP . "@" . $servidor_dominio, $contrasena_LDAP);
    if ($autenticado_LDAP)
    {
	     echo "<br>Autenticación en servidor LDAP desde Apache y PHP correcta.";
 /******************************************************************************************************************/
    $attrs = array("displayname","mail","samaccountname","telephonenumber","givenname");
     
    // Creo el filtro para la busqueda
    $filter = "(samaccountname=$usr)";
	//echo "<br>".$usr;
     
    $search = ldap_search($ad, $dn, $filter, $attrs) 
    or die ("Error!!!");
     
    $entries = ldap_get_entries($ad, $search);
     
    if ($entries["count"] > 0)
        {   
        for ($i=0; $i<$entries["count"]; $i++)
                { 
            echo "<p>Nombre: ".$entries[$i]["displayname"][0]."<br />"; 
            echo "Email: <a href=mailto:".$entries[$i]["mail"][0].">".$entries[$i]["mail"][0]."</a><br />"; 
            echo "Nombre de Usuario: ".$entries[$i]["samaccountname"][0]."<br />"; 
            echo "Telefono: ".$entries[$i]["telephonenumber"][0]."</p>";          
            }
    } else { 
        echo "<p>No se ha encontrado ningun resultado</p>"; 
    }   
/******************************************************************************************************************/
	}
    else
    {
      echo "<br><br>No se ha podido autenticar con el servidor LDAP: " . 
	      $servidor_LDAP .
	      ", verifique el usuario y la contraseña introducidos";
    }
  }
  else 
  {
    echo "<br><br>No se ha podido realizar la conexión con el servidor LDAP: " .
        $servidor_LDAP;
  }
?>
</body>
</html>
<?
/*
$usuario = "cllanos";//$_GET["user"];
 
        //Asigno variables para accesar al servidor LDAP
    $host = "DRYPERS.LOCAL"; 
    $user = "DRYPERS\cllanos"; 
    $pswd = "Sanpedro1";
     
    $ad = ldap_connect($host) 
    or die("Imposible Conectar");
     
    // Especifico la versión del protocolo LDAP
    ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) 
    or die ("Imposible asignar el Protocolo LDAP");
     
    // Valido las credenciales para accesar al servidor LDAP
    $bd = ldap_bind($ad, $user, $pswd) 
    or die ("Imposible Validar en el Servidor LDAP");
     
    // Creo el DN 
    $dn = "OU=Admin,DC=DRYPERS,DC=local";
     
    // Especifico los parámetros que quiero que me regrese la consulta
    $attrs = array("displayname","mail","samaccountname","telephonenumber","givenname");
     
    // Creo el filtro para la busqueda
    $filter = "(samaccountname=$usuario)";
     
    $search = ldap_search($bd, $dn, $filter, $attrs) 
    or die ("");
     
    $entries = ldap_get_entries($ad, $search);
     
    if ($entries["count"] > 0)
        {   
        for ($i=0; $i<$entries["count"]; $i++)
                { 
            echo "<p>Nombre: ".$entries[$i]["displayname"][0]."<br />"; 
            echo "Email: <a href=mailto:".$entries[$i]["mail"][0].">".$entries[$i]["mail"][0]."</a><br />"; 
            echo "Nombre de Usuario: ".$entries[$i]["samaccountname"][0]."<br />"; 
            echo "Telefono: ".$entries[$i]["telephonenumber"][0]."</p>";          
            }
    } else { 
        echo "<p>No se ha encontrado ningun resultado</p>"; 
    }   
    ldap_unbind($ad);
*/
?>