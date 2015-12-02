<!DOCTYPE html>
<html lang="es">
<head>
	<title>Maestra de Clientes (Activos)</title>
    <meta name="viewport" content="width=device-width , maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jqusery-latest.min.js"></script>
    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="sty.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="estilos.css"/>

	<script languaje="JavaScript1.2" type="text/javascript">


		function valida_envia( formulario )
		{
			if( formulario.cus_no.value.length == 0 )
			{
				alert("Debe ingresar un número de Cliente Válido!");
				document.consulta.cus_no.focus(); return false;
			}
			else if( isNaN( eval("formulario.cus_no.value") ) )
			{
				alert("El código del Clietne debe ser un valor numérico!");
				document.consulta.cus_no.focus(); return false;	
			}
			else
			{
				return true;
			}
		}

		function foco( )
		{
 			document.consulta.cus_no.focus();
			return 0;
		}

	</script>		
</head>

<body bgcolor="#FFFFFF" text="#333334" link="#0000FF" topmargin="0" rightmargin="0" onLoad="foco()">

<div class="logo">
  <p><img src="images/LogoDrypersBlack2.png" alt="" width="92" height="130" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INFORMES CORPORTIVOS  <span class="frase"><span class="logp">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
    <span class="frase"><span class="logp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <img src="images/LogoTic.jpg" alt="" width="68" height="62"></span></span>
  <p><span class="frase"> &quot;El sentido de pertenencia fortalece el sentimiento de que todos somos uno&quot;<span class="logp"> &nbsp;</span></span>  
  <p><br>
</div>
   <div id='cssmenu'> 
<ul>
   <li class='active'><a><span>Áreas</span></a></li>
   <li class='has-sub'><a href='#'><span>Finanzas Drypers</span></a>
      <ul>
         <li><a><div class='has-sub'>CARTERA DRYPERS</div></a></li>
     <li><a href="./age_cxc_cus.php"><span>1.Cartera Por Cliente</span></a></li>
         <li><a href="./age_cxc_sal.php"><span>2.Cartera Por Vendedor</span></a></li>
         <li><a href="./age_cxc_collector.php"><span>3.Cartera Por Cobrador</span></a></li>
         <li><a href="./age_cxc_zone.php"><span>4.Cartera Por Zona</span></a></li>
         <li><a href="./cus_invoiceh.php"><span>5.Cartera Por Cliente (Historico de archivos)</span></a></li>
         <li><a href="./cus_documentos.php"><span>6.Detalle de Facturas</span></a></li>
         <li><a href="./age_cxc_group_cus.php"><span>7.Cartera Agrupada por Cliente</span></a></li>
         <li><a href="./age_cxc.php"><span>8.Cartera Por Edades</span></a></li>
         <li><a href="./age_cxc_chile.php"><span>9.Cartera Por Edades S.V Chile</span></a></li>
         <li><a href="./active_cus.php"><span>10.Clientes Activos</span></a></li>
         <li class='last'><a href="./age_cxc_group_cont.php"><span>11.Cartera Continental(Pruebas)</span></a></li>
      </ul>
   </li>

  <li class='has-sub'><a href='#'><span>Finanzas Protisa</span></a>
      <ul>
       <li><a><div class='has-sub'>CARTERA PROTISA</div></a></li>
         <li><a href="./age_cxc_cusp.php"><span>1.Cartera Por Cliente</span></a></li>
         <li><a href="./age_cxc_salp.php"><span>2 .Cartera Por Vendedor</span></a></li>
         <li><a href="./age_cxc_collectorp.php"><span>3.Cartera Por Cobrador</span></a></li>
         <li><a href="./age_cxc_zonep.php"><span>4.Cartera Por Zona</span></a></li>
         <li><a href="./cus_invoicehp.php"><span>5.Cartera Por Cliente (Historico de archivos)</span></a></li>
         <li><a href="./cus_documentosp.php"><span>6.Detalle de Facturas</span></a></li>
         <li><a href="./age_cxc_group_cusp.php"><span>7.Cartera Agrupado por Cliente</span></a></li>
         <li><a href="./age_cxcp.php"><span>8.Cartera Por Edades</span></a></li>
         <li><a href="./age_cxc_chilep.php"><span>9.Cartera Por Edades S.V Chile</span></a></li>
         <li><a href="./active_cusp.php"><span>10.Clientes Activos</span></a></li>
         <li class='last'><a href="./age_cxc_group_contp.php"><span>11.Cartera Continental(Pruebas)</span></a></li>
      </ul>
   </li>


   <li class='has-sub'><a href='#'><span>Comercial</span></a>
      <ul>
         <li><a href='#'><span>Consulta1</span></a></li>
         <li class='last'><a href='#'><span>Consulta2</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Logística</span></a>
      <ul>
         <li><a href='#'><span>Consulta1</span></a></li>
         <li class='last'><a href='#'><span>Consulta2</span></a></li>
         </li>
      </ul>
 <br><h2><div class="inicio">Inicio</div><li class='active'><a href="./index.php"><img src="images/home.png" alt="" width="58" height="52"></a></li></h2>	
</ul>   
</div>

<?
date_default_timezone_set('America/Bogota');

require("./session/libreriap.php");

/*
function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
*/

if( isset($_POST['cus_no']) )
{
		
	$link = Fconectar();

	if( $link )
	{
	
		// Se define la consulta que va a ejecutarse, como en sql
		 $sql = 
				"
					SELECT     A.cus_no, A.cus_name, A.slspsn_no, B.slspsn_name AS vendedor, C.slspsn_name AS cobrador, A.ar_terms_cd, 
							   A.last_sale_dt, A.last_sale_amt, A.last_pay_dt, A.last_pay_amt,A.nit, A.cus_type_cd, A.start_dt, A.vend_no
					FROM         ARCUSFIL_SQL AS A INNER JOIN
								 ARSLMFIL_SQL AS B ON A.slspsn_no = B.slspsn_no INNER JOIN
								 ARSLMFIL_SQL AS C ON A.slspsn_no = C.slspsn_no
					WHERE     (A.slspsn_no <> 999) AND (A.slspsn_no <> 132) AND (A.slspsn_no <> 300) AND 
							  (A.slspsn_no <> 108) AND (A.slspsn_no <> 100) AND (A.slspsn_no <> 110) AND 
							  (A.slspsn_no <> 107) AND (A.slspsn_no <> 109) AND (A.slspsn_no <> 106) AND
							  (A.cus_no < 10000) AND (A.curr_cd = 'PES')
					ORDER BY   A.cus_name
				";
		 // Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql ) or die ( "Error en instruccion SQL $orden" );;
		 $existe = odbc_num_rows ( $results );

		 if ( $existe )
		 {
			$i = 0;

			while($registro = odbc_fetch_array($results))
			{
				$arc_cus_no[$i] = $registro['cus_no'];
				$arc_cus_name[$i] = $registro['cus_name'];
				$arc_slspsn_no[$i] = $registro['slspsn_no'];
				$arc_nit[$i] = $registro['nit'];
				$ars_slspsn_name[$i] = $registro['vendedor'];
				$ars_slspsn_collector[$i] = $registro['cobrador'];
				$arc_start_dt[$i] = $registro['start_dt'];
				$arc_last_sale_dt[$i] = $registro['last_sale_dt'];
				$arc_last_sale_amt[$i] = $registro['last_sale_amt'];
				$arc_last_pay_dt[$i] = $registro['last_pay_dt'];
				$arc_last_pay_amt[$i] = $registro['last_pay_amt'];
				$arc_cus_type_cd[$i] = $registro['cus_type_cd'];
				$arc_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				$arc_vend_no[$i] = $registro['vend_no'];
/*
				$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
				
				$fecha_new[$i] = date_create($date_doc);
				$fp .= " days";
				
				date_add($fecha_new[$i], date_interval_create_from_date_string($fp));
				//echo date_format($fecha_new[$i], 'Y/m/d');
*/				
				$i++;
			}//while
			$cont=$i;
		}
		else
		{
			$mensaje = "Cobrador no encontrado!";
		}
	
	}//if( $link > 0 )
	else
	{
		Ferror("No se pudo establecer coneccion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );

}//if isset...

?>
<div class="main_content">
<br>
<table width="80%" border="0" align="center">
	<tr>
		<td align='left'>
			<td><h6>Clientes Activos Protisa</h6>
			<form name="consulta" action="active_cusp.php" method="post" onsubmit="return valida_envia(this);">
			<input type="hidden" size="6" maxlength="6" name="cus_no" value="1">
			<td><input type="submit" value="Generar Consulta"></td>
			</form>
		</td>
	</tr>
	<?
		if( isset($_POST['cus_no']) || isset($_GET['cus_no']) )
		{
			echo"
				<tr>
					<td colspan='2'><h3> Maestra de Clientes Activos</h3></td>
				</tr>
				<tr>
					<h3><td colspan='2' align='center'>Generado: ".date('Y-m-d H:i')."</td></h3>
				</tr>
				<tr>
				<td align='right'><h3><input type='button' value='Exportar a Excel' class='excel' onclick=\"location.href='./active_cusp_excel.php?cus_no=".$_POST['cus_no']."'\" name='excel'/></h3></td>
				</tr>
				";
		}
	?>
</table>
<br>
<div class="resultado">
<table width="80%" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<!--<th>COD. PADRE</th>-->
<th>CÓDIGO</th>
<th>NIT</th>
<th>CLIENTE</th>
<th>TIPO CLIENTE</th>
<th>F. CREACIÓN</th>
<th>FP</th>
<th>VENDEDOR</th>
<th>COBARDOR</th>
<th>ZONA</th>
<th>F. ULT. VTA.</th>
<th>VLR. ULT. VTA.</th>
<th>F. ULT. PAGO.</th>
<th>VLR. ULT. PAGO.</th>
</div>
<?

$corriente=$edad1=$edad2=$edad3=$edad4=0;

for( $i=0; $i<$cont;$i++)
 {
	echo "<tr>";

	//Código Hijo
	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nit
	echo "<td>".$arc_nit[$i]."</td>";
	//Nombre del cliente
	echo "<td>".$arc_cus_name[$i]."</td>";
	//T. Cliente
	echo "<td>".$arc_cus_type_cd[$i]."</td>";
	//F. Creación
	echo "<td>".substr($arc_start_dt[$i],6,2)."/".substr($arc_start_dt[$i],4,2)."/".substr($arc_start_dt[$i],0,4)."</td>";
	//Forma de Pago
	echo "<td>".$arc_ar_terms_cd[$i]."</td>";
	//Vendedor
	echo "<td>".$ars_slspsn_name[$i]."</td>";
	//Cobrador
	echo "<td>".$ars_slspsn_collector[$i]."</td>";
	//Zona
	echo "<td>".$arc_vend_no[$i]."</td>";
	//F. Última Venta
	echo "<td>".substr($arc_last_sale_dt[$i],6,2)."/".substr($arc_last_sale_dt[$i],4,2)."/".substr($arc_last_sale_dt[$i],0,4)."</td>";
	//Vlr. Última Venta
	echo "<td>".number_format($arc_last_sale_amt[$i],0,'',',')."</td>";
	//F. Último Pago
	echo "<td>".substr($arc_last_pay_dt[$i],6,2)."/".substr($arc_last_pay_dt[$i],4,2)."/".substr($arc_last_pay_dt[$i],0,4)."</td>";
	//Vlr. Último Pago
	echo "<td>".number_format($arc_last_pay_amt[$i],0,'',',')."</td>";
	
	
	echo "</tr>";
 }//for

 
?>
	
</table>
<br>


</body>
</html>


