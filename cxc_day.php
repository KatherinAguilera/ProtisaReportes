<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width , maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jqusery-latest.min.js"></script>
    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="sty.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="estilos.css"/>
	<title>Días Cartera</title>
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
				alert("El código del Cliente debe ser un valor numérico!");
				document.consulta.cus_no.focus(); return false;	
			}
			else
			{
				return true;
			}
		}
		function foco( )
		{
 			document.consulta.cugetElementsByTagName('')s_no.focus();
			return 0;
		}
	</script>		
</head>

<body bgcolor="#FFFFFF" text="#333334" link="#0000FF" topmargin="0" rightmargin="0" onLoad="foco()">
<div class="logo">
  <p><img src="images/LogoDrypersBlack2.png" alt="" width="92" height="130" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INFORMES CORPORATIVOS  <span class="frase"><span class="logp">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
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
         <li><a href='#'><span>4.Cartera Por Zona</span></a></li>
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
         <li><a href="/age_cxc_chilep.php"><span>9.Cartera Por Edades S.V Chile</span></a></li>
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
require("./session/libreria.php");
function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
if( isset($_POST['cus_no']))
{
	$Customer_no = $_POST['cus_no'];

	$link = Fconectar();

	if( $link )
	{
		//echo "ok";
		// Consulta sql
		 $sql = 
				"
				    SELECT C.cus_no, F.slspsn_name, H.tot_sls_amt
				    FROM
					ARCUSFIL_SQL AS C,
					ARSLMFIL_SQL AS F,
					OEHDRHST_SQL AS H
					WHERE
					C.cus_no = '$customer_no'
				";
		 // Se ejecuta la consulta 
		 $results = odbc_exec( $link, $sql ) or die ( "Error en instruccion SQL $orden" );;
		 $existe = odbc_num_rows ( $results );

		 if ( $existe )
		 {
			$i = 0;

			while($registro = odbc_fetch_array($results))
			{
				if( $registro['par_cus_no'] == NULL )
					$arc_par_cus_no[$i] = $registro['cus_no'];
				else	
					$arc_par_cus_no[$i] = $registro['par_cus_no'];
				$arc_cus_no[$i] = $registro['cus_no'];
				//$arc_cus_name[$i] = $registro['cus_name'];
				//$arc_slspsn_no[$i] = $registro['slspsn_no'];
				//$aro_cus_no[$i] = $registro['cus_no2'];
				//$aro_doc_dt[$i] = $registro['doc_dt'];
				//$aro_doc_no[$i] = $registro['doc_no'];
				//$aro_doc_type[$i] = $registro['doc_type'];
				//$aro_apply_to_no[$i] = $registro['apply_to_no'];
				//$aro_curr_cd[$i] = $registro['curr_cd'];
				//$aro_doc_due_dt[$i] = $registro['doc_due_dt'];
				//$aro_amt[$i] = $registro['VALOR'] + $registro['VALOR2'];
				//$aro_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				//$aro_slspsn_no[$i] = $registro['slspsn_no2'];
				//$aro_curr_trx_rt[$i] = $registro['curr_trx_rt'];
				//$ars_slspsn_name[$i] = $registro['slspsn_name'];
				$total_cliente += $aro_amt[$i]; 
				$tot_sls_amt= $registro['tot_sls_amt']; 
				$i++;
			}//while
			$cont=$i;
		}
		else
		{
			$mensaje = "Cliente no Existe!";
		}
	}//if( $link > 0 )
	else
	{
		Ferror("No se pudo establecer conexión con la Base de datos!");
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
		<td><h6>Días Cartera</h6>
		<br>
			<form name="consulta" action="cxc_day.php" method="post" onsubmit="return valida_envia(this);">
			<input type="text" size="6" maxlength="6" name="cus_no">
			<input type="submit" value="Consultar Cliente">
			</form>
		</td>
		</td>		
	</tr>
	<?
     if( isset($_POST['cus_no']))
		{
			echo"
				<tr>
					<td colspan='2'><h3> Días Cartera: $arc_cus_no[0] </h3></td>
				</tr>
				<tr>
					<td colspan='2' align='center'><h4>Generado: ".date('d-m-Y H:i:s')."</h4></td>
				</tr>
			<tr>
				<h3><td align='center'><h3><input type='button' value='Exportar a Excel' class='excel'onclick=\"location.href='./cus_invoiceh_excel.php?cus_no=".$_POST['cus_no']."'\" name='excel'/></h3>
                 </tr>
				";
		}
	?>
</table>
<br>
<div class="resultado">
<table width="90%" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<!--<th>COD. PADRE</th>-->
<th>CLIENTE</th>
<!--<th>CLIENTE</th>-->
<th>SALDO</th>
<th>VENTAM1</th>
<th>VENTAM2</th>
<th>VENTAM3</th>
<th>PROM VENTA</th>
<th>DÍAS</th>
</div>
</div>
<?
for( $i=0; $i<$cont;$i++)
 {
	echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Padre
	//echo "<td>".$arc_par_cus_no[$i]."</td>";
	//Código Hijo
	//echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nombre del cliente
	//echo "<td>".$arc_cus_name[$i]."</td>";
	//Código Vendedor
//	echo "<td>".$arc_slspsn_no[$i]."</td>";
/*****************************  FIN ARCUSFIL  ****************************/
/*****************************  INICIO AROPNFIL  ****************************/
	//Cód. Cliente
	echo "<td>".$aro_cus_no[$i]."</td>";
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
	//Documentos todos
	//echo "<td>".$aro_doc_no[$i]."</td>";
	//Factura
	//echo "<td>".$aro_apply_to_no[$i]."</td>";
	//Fecha documento
	//echo "<td>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
	//Moneda
//	echo "<td>".$aro_curr_cd[$i]."</td>";
	//Fecha Vencimiento
	//Valor Factura
//	echo "<td>".$aro_doc_due_dt[$i]."</td>";
//  SALDO
    echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
//	echo "<td align='right'>".number_format($aro_amt[$i])."</td>";
	//Términos de pago (Plazo)
//	echo "<td>".$aro_ar_terms_cd[$i]."</td>";
	//Venta
	echo "<td>".$tot_sls_amt[$i]."</td>";
	//???
	if($d_cartera > 0 && $aro_doc_type[$i]== 'I' && $total_cliente > 0 )
		echo "<td style='background-color:red;'>".$d_cartera."</td>";
	else
		echo "<td>N/A</td>";	
//	echo "<td>".$aro_curr_trx_rt[$i]."</td>";
/*****************************  FIN AROPNFIL  *******************************/	
/*****************************  INICIO ARSLMFIL  ****************************/
	//Nombre Vendedor
//	echo "<td>".$ars_slspsn_name[$i]."</td>";
/*****************************  FIN ARSLMFIL  ****************************/	
echo "</tr>";
 }//for
?>
<tr>
		<td colspan="1" align="right"> <b>Totales: </b></td>
		<td align='right'><b><?echo number_format($total_cliente);?></b></td>
	</tr>
</table>
<br>
</body>
</html>

