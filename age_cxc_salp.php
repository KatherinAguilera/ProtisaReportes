<!DOCTYPE html>
<html lang="es">
<head>
	<title>Edades de Cartera por Vendedor</title>
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
			if( formulario.sal_no.value.length == 0 )
			{
				alert("Debe ingresar un número de Vendedor Válido!");
				document.consulta.sal_no.focus(); return false;
			}
			else if( isNaN( eval("formulario.cus_no.value") ) )
			{
				alert("El código del Vendedor debe ser un valor numérico!");
				document.consulta.sal_no.focus(); return false;	
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
require("./session/libreriap.php");

function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}


if( isset($_POST['sal_no']) )
{
	$Salesm_no = $_POST['sal_no'];

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
					WHERE      (C.curr_cd = 'PES') AND (C.slspsn_no = $Salesm_no)
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
				//$aro_slspsn_no[$i] = $registro['slspsn_no2'];
				//$aro_curr_trx_rt[$i] = $registro['curr_trx_rt'];
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
		Ferror("No se pudo establecer conexión con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );
}//if isset...
?>
<div class="main_content">
<br>
<td><h6>Cartera Por Vendedor Drypers</h6>
<br>
<?
	$link = Fconectar();
	if( $link )
	{

		// Se define la consulta que va a ejecutarse, como en sql
		 $sql = 
				"
					SELECT slspsn_no, slspsn_name
					FROM  ARSLMFIL_SQL 
					WHERE  (slspsn_no <> 999) 
					ORDER BY slspsn_no
				";
		 // Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql) or die ( "Error en la conexion sql $sql" );;
		 $existe = odbc_num_rows ( $results );
		 if ( $existe )
		 {
			echo"
				<table width='80%' border='0' align='center'>
					<tr>
						<td align='left'>
						<form name='consulta' action='age_cxc_salp.php' method='post' onsubmit='return valida_envia(this);'>
						<select name='sal_no'>
							<option value=''></option>				
				";
				
			while($registro = odbc_fetch_array($results))
			{
				
				echo "<option value='".$registro['slspsn_no']."'>".$registro['slspsn_no']." - ".$registro['slspsn_name']."</option>";
				
			}//while
			
			echo "</select>	";
			
		}
		else
		{
			$mensaje = "Vendedor no encontrado!";
		}
	
	}//if( $link > 0 )
	else
	{
		Ferror("No se pudo establecer conexión con la Base de Datos!");
	}

?>
			<input type="submit" value="Consultar">
			</form>
		</td>
	</tr>
	<?
		if( isset($_POST['sal_no']) )
		{
			echo"
			
				<tr>
					<td colspan='2'><h3> Cartera por Vendedor: $Salesm_no, $ars_slspsn_name[0] </h3></td>
				</tr>
				
				<tr>
					<td colspan='2' align='center'><h4> Generado: ".date('d-m-Y H:i:s')."</h4></td>
				</tr>

				<tr>
					<td align='left'><h3><input type='button' value='Exportar a Excel' class='excel'onclick=\"location.href='./age_cxc_sal_excel.php?salp_no=".$_POST['sal_no']."'\" name='excel'/></h3>
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
<th>CLIENTE</th>
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
</div>
</div>
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
	echo "<td>".$arc_cus_name[$i]."</td>";
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
		<td colspan="7" align="right"> <b>Total Cartera Vendedor/Zona : </b></td>
		<td align='right'><b><?echo number_format($total_cliente,2);?></b></td>
		<td align='right'><b><?echo number_format($corriente,2);?></b></td>
		<td align='right'><b><?echo number_format($edad1,2);?></b></td>
		<td align='right'><b><?echo number_format($edad2,2);?></b></td>
		<td align='right'><b><?echo number_format($edad3,2);?></b></td>
		<td align='right'><b><?echo number_format($edad4,2);?></b></td>
		
	</tr>
	<tr>
		<td colspan="7" align="right"> <b>Total Cartera en % : </b></td>
		<td align='right'><b>100%</b></td>
		<td align='right'><b><?echo number_format($corriente/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad1/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad2/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad3/$total_cliente*100,2)."%";?></b></td>
		<td align='right'><b><?echo number_format($edad4/$total_cliente*100,2)."%";?></b></td>
		
	</tr>
</table>
<br>

</body>
</html>


