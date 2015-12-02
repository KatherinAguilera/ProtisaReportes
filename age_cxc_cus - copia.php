<html>
<head>
	<title>Edades de Cartera por Cliente</title>
	<link href="./css/principal.css" type="text/css" rel="stylesheet">
	<link href="./css/fixed_css.css" type="text/css" rel="stylesheet">	
	<script src="./scripts/fixed_script.js"></script>
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
<?
date_default_timezone_set('America/Bogota');

require("./session/libreria.php");

function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

function head_cus( $customer_no )
{
	
	$link = Fconectar();

	if( $link )
	{
	
		// Se define la consulta que va a ejecutarse, como en sql
		 $sql_datos_cus = 
				"
					SELECT C.par_cus_no, C.cus_no, C.cus_name, V1.slspsn_name AS Vendedor, V2.slspsn_name AS Cobrador, C.ar_terms_cd 
					FROM
					ARCUSFIL_SQL AS C,
					ARSLMFIL_SQL AS V1,
					ARSLMFIL_SQL AS V2
					WHERE
					C.slspsn_no = V1.slspsn_no AND
					C.collector = V2.slspsn_no AND
					C.cus_no = '$customer_no'
				";
		 // Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql_datos_cus ) or die ( "Error en instruccion SQL $sql_datos_cus" );;
		 $existe = odbc_num_rows ( $results );

		 if ( $existe )
		 {

			$registro = odbc_fetch_array($results);
				
				$head_cus_no = $registro['cus_no'];
				$head_cus_name = $registro['cus_name'];
				$head_ar_terms_cd = $registro['ar_terms_cd'];
				$head_slspsn_name = $registro['Vendedor'];
				$head_collector = $registro['Cobrador'];				
		}
		else
		{
			$mensaje = "No existen registros!";
		}
	
	}//if( $link > 0 )
	else
	{
		Ferror("No se pudo establecer coneccion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );

	
	echo"
		<div align='center'>
		<table width='40%' border='3' cellpadding='0' cellspacing='10' bordercolor='#DCF3A4' align='center'>
			<th colspan='2'>EDADES DE CARTERA POR CLIENTE (Datos hasta: ".date('d-m-Y').")</th>	
			<tr>
				<td>Cliente:</td>
				<td>(".number_format($head_cus_no,0,'','').") - $head_cus_name</td>
			</tr>
			<tr>
				<td>Vendedor:</td>
				<td>$head_slspsn_name</td>
			</tr>
			<tr>
				<td>Cobrador:</td>
				<td>$head_collector</td>
			</tr>
			<tr>
				<td>Condición de Pago:</td>
				<td>$head_ar_terms_cd</td>
			</tr>
			<tr>
				<td colspan='2' align='center'>Generado: ".date('d-m-Y H:i:s')."</td>
			</tr>
		</table>
		</div>
		";
}


if( isset($_POST['cus_no']) || isset($_GET['cus_no']) )
{
	if( isset($_POST['cus_no']) )
		$Customer_no = $_POST['cus_no'];
	else	
		$Customer_no = number_format($_GET['cus_no'],0,'','');
		
	$link = Fconectar();

	if( $link )
	{
	
		// Se define la consulta que va a ejecutarse, como en sql
		 $sql = 
				"
					SELECT     C.par_cus_no, F.cus_no, C.cus_name, f.apply_to_no, C.ar_terms_cd, 
					dbo.get_ar_doc_dt(f.cus_no, f.apply_to_no) as doc_dt, 
					dbo.get_ar_doc_due(f.cus_no, f.apply_to_no) as doc_due_dt, 
					dbo.get_ar_slspsn_no(f.cus_no, f.apply_to_no) as slspsn_no, 
					( select slspsn_name from ARSLMFIL_SQL where slspsn_no = dbo.get_ar_slspsn_no(f.cus_no, f.apply_to_no)) as slspsn_name,
					SUM(f.amt_1 + f.amt_2) AS VALOR 
					FROM         AROPNFIL_SQL AS F  INNER JOIN
								 ARCUSFIL_SQL AS C ON F.cus_no = C.cus_no 
					WHERE      (C.curr_cd = 'PES') AND (C.par_cus_no = $Customer_no) OR (C.cus_no = $Customer_no)
					GROUP BY    C.par_cus_no, F.cus_no, C.cus_name, f.apply_to_no, C.ar_terms_cd
					HAVING      (SUM(f.amt_1 + f.amt_2) <> 0)
					ORDER BY doc_dt
				";
		 // Se ejecuta la consulta y se guardan los resultados
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
				$arc_cus_name[$i] = $registro['cus_name'];
				//$arc_slspsn_no[$i] = $registro['slspsn_no'];
				//$aro_cus_no[$i] = $registro['cus_no2'];
				$aro_doc_dt[$i] = $registro['doc_dt'];
				//$aro_doc_no[$i] = $registro['doc_no'];
				//$aro_doc_type[$i] = $registro['doc_type'];
				$aro_apply_to_no[$i] = $registro['apply_to_no'];
				//$aro_curr_cd[$i] = $registro['curr_cd'];
				//$aro_doc_due_dt[$i] = $registro['doc_due_dt'];
				$aro_amt[$i] = $registro['VALOR'];
				$fp = $arc_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				$ars_slspsn_name[$i] = $registro['slspsn_name'];
				$total_cliente += $aro_amt[$i]; 
				$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
				
				$fecha_new[$i] = date_create($date_doc);
				$fp .= " days";
				
				date_add($fecha_new[$i], date_interval_create_from_date_string($fp));
				//echo date_format($fecha_new[$i], 'Y/m/d');
				
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

<br>
<table width="80%" border="0" align="center">
	<tr>
		<td align='left'>
			<form name="consulta" action="age_cxc_cus.php" method="post" onsubmit="return valida_envia(this);">
			<input type="text" size="6" maxlength="6" name="cus_no">
			<input type="submit" value="Código Cliente">
			</form>
		</td>
		<td align='right'>
<a href="javascript:history.back(1)">&laquo; Regresar</a>
		</td>
	</tr>
</table>
<br>

	<?
		if( isset($_POST['cus_no']) || isset($_GET['cus_no']) )
		{
			head_cus($arc_cus_no[0]);
		}
	?>

<br>
<div id="tableContainer" class="tableContainer" align='center'>
<table width="80%" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<thead class="fixedHeader">
 <tr>
<!--<th>COD. PADRE</th>-->
<th>CÓDIGO</th>
<!--<th>CLIENTE</th>-->
<th>CP</th>
<th>No. FACTURA</th>
<th>F. DOC</th>
<th>F. VEN</th>
<th>DÍAS MORA</th>
<th>SALDO</th>
<th>CORRIENTE</th>
<th>1 A 10</th>
<th>11 A 90</th>
<th>91 A 180</th>
<th>MÁS DE 180</th>
</tr>
 </thead>
 <tbody class="scrollContent">
<?

$corriente=$edad1=$edad2=$edad3=$edad4=0;

for( $i=0; $i<$cont;$i++)
 {
	echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Padre
	//echo "<td>".number_format($arc_par_cus_no[$i],0,'','')."</td>";
	//Código Hijo
	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nombre del cliente
	//echo "<td>".$arc_cus_name[$i]."</td>";
	//Código Vendedor
//	echo "<td>".$arc_slspsn_no[$i]."</td>";
/*****************************  FIN ARCUSFIL  ****************************/
	
	$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
	$interval = dias_cartera($date_doc,date("Y-m-d"));
	$d_cartera = $interval-$arc_ar_terms_cd[$i];

/*****************************  INICIO AROPNFIL  ****************************/
	//Forma de Pago
	echo "<td>".$arc_ar_terms_cd[$i]."</td>";
	//Factura
	echo "<td>".$aro_apply_to_no[$i]."</td>";
	//Fecha documento
	echo "<td>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
	//Fecha Vencimiento
	echo "<td>".date_format($fecha_new[$i], 'd/m/Y')."</td>";
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
//	echo "<td>".$aro_doc_type[$i]."</td>";
	//Días de Mora
	if($d_cartera > 0)
		echo "<td style='background-color:red;'>".$d_cartera."</td>";
	else
		echo "<td>".$d_cartera."</td>";	
	//Moneda
//	echo "<td>".$aro_curr_cd[$i]."</td>";
	//Saldo
	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	//Corriente
	if( $d_cartera < 0 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$corriente += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//1 a 10
	if( $d_cartera > 0 && $d_cartera < 11 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad1 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//11 a 90
	if( $d_cartera > 10 && $d_cartera < 91 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad2 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//91 a 180
	if( $d_cartera > 90 && $d_cartera < 181 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad3 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//Más de 180
	if( $d_cartera > 180 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad4 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//Términos de pago (Plazo)
//	echo "<td>".$aro_ar_terms_cd[$i]."</td>";
	//Código Vendedor
//	echo "<td>".$aro_slspsn_no[$i]."</td>";
	//???
//	echo "<td>".$aro_curr_trx_rt[$i]."</td>";
/*****************************  FIN AROPNFIL  ****************************/	

/*****************************  INICIO ARSLMFIL  ****************************/
	//Nombre Vendedor
//	echo "<td>".$ars_slspsn_name[$i]."</td>";
/*****************************  FIN ARSLMFIL  ****************************/	
	
	echo "</tr>";
 }//for

 
	if( !$total_cliente )
		$total_cliente = 0.001;
 
?>
	
	<tr>
		<td colspan="6" align="right"> <b>Total Cartera : </b></td>
		<td align='right'><b><?echo number_format($total_cliente,2);?></b></td>
		<td align='right'><b><?echo number_format($corriente,2);?></b></td>
		<td align='right'><b><?echo number_format($edad1,2);?></b></td>
		<td align='right'><b><?echo number_format($edad2,2);?></b></td>
		<td align='right'><b><?echo number_format($edad3,2);?></b></td>
		<td align='right'><b><?echo number_format($edad4,2);?></b></td>
		
	</tr>
	<tr>
		<td colspan="6" align="right"> <b>Total Cartera en % : </b></td>
		<td align='right'><b>100%</b></td>
		<td align='right'><b><?echo number_format($corriente/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad1/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad2/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad3/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad4/$total_cliente*100,2)."%";?></b></td>
		
	</tr>
</tbody>
</table>
</div align='center'>
<br>


</body>
</html>


