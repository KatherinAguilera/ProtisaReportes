<!DOCTYPE html>
<html lang="es">
<head>
	<title>Detalle de Factura</title>
	 <meta name="viewport" content="width=device-width , maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jqusery-latest.min.js"></script>
    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="sty.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="estilos.css"/>
	<script type="text/javascript" language="JavaScript1.2" src="../scripts/param_menu.js"></script>	
	<script languaje="JavaScript1.2" type="text/javascript">

		function valida_envia( formulario )
		{
			if( formulario.doc_no.value.length == 0 )
			{
				alert("Debe ingresar un número de Documento Válido!");
				document.consulta.doc_no.focus(); return false;
			}
			else if( isNaN( eval("formulario.doc_no.value") ) )
			{
				alert("El Documento debe ser un valor numérico!");
				document.consulta.doc_no.focus(); return false;	
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
require("./session/libreriap.php");

function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
if( isset($_POST['doc_no']) )
{
	$Doc_no = $_POST['doc_no'];
	$link = Fconectar();

	if( $link )
	{
		// Se define la consulta que va a ejecutarse, como en sql
		 $sql = 
				"
					SELECT
						ARCUSFIL.cus_no, ARCUSFIL.cus_name, ARCUSFIL.slspsn_no, ARCUSFIL.par_cus_no,
						AROPNFIL.doc_dt, AROPNFIL.doc_no, AROPNFIL.doc_type, AROPNFIL.apply_to_no, 
						AROPNFIL.curr_cd, AROPNFIL.doc_due_dt, AROPNFIL.amt_1, AROPNFIL.amt_2, AROPNFIL.ar_terms_cd, 
						ARSLMFIL.slspsn_name
					FROM
						ARCUSFIL_SQL ARCUSFIL,
						AROPNFIL_sql AROPNFIL,
						ARSLMFIL_SQL ARSLMFIL
					WHERE
						ARCUSFIL.cus_no = AROPNFIL.cus_no AND
						AROPNFIL.slspsn_no = ARSLMFIL.slspsn_no AND
						AROPNFIL.apply_to_no = $Doc_no AND
						AROPNFIL.curr_cd = 'PES'
					ORDER BY
						ARCUSFIL.slspsn_no ASC,
						ARCUSFIL.cus_no ASC,
						AROPNFIL.apply_to_no ASC
				";
		 // Se ejecuta la consulta y se guardan los resultados en el recordset rs
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
				$arc_slspsn_no[$i] = $registro['slspsn_no'];
				//$arc_par_cus_no[$i] = $registro['par_cus_no'];
				$aro_doc_dt[$i] = $registro['doc_dt'];
				$aro_doc_no[$i] = $registro['doc_no'];
				$aro_doc_type[$i] = $registro['doc_type'];
				$aro_apply_to_no[$i] = $registro['apply_to_no'];
				$aro_curr_cd[$i] = $registro['curr_cd'];
				$aro_doc_due_dt[$i] = $registro['doc_due_dt'];
				$aro_amt[$i] = $registro['amt_1'] + $registro['amt_2'];
				$fp = $arc_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				$aro_slspsn_no[$i] = $registro['slspsn_no2'];
				$aro_curr_trx_rt[$i] = $registro['curr_trx_rt'];
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
			$mensaje = "Cliente no Existe!";
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
		<td><h6>Detalle de Factura Protisa</h6>
			<form name="consulta" action="cus_documentosp.php" method="post" onsubmit="return valida_envia(this);">
			<input type="text" size="6" maxlength="6" name="doc_no">
			<input type="submit" value="No. Documento">
			</form>
		</td>
	</tr>
	<?
		if( isset($_POST['doc_no']) )
		{
			echo"
				<tr>
					<td colspan='2'><h3> Detalle de Documentos: $arc_cus_name[0] ($arc_cus_no[0] - Forma de pago: $arc_ar_terms_cd[0]) </h3></td>
				</tr>
				<tr>
					<td colspan='2'><h3> Vendedor Asignado: $ars_slspsn_name[0] </h3></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>Generado: ".date('Y-m-d H:i')."</td>
				</tr>
				<tr>
				<td align='left'><h3><input type='button' value='Exportar a Excel' class='excel'onclick=\"location.href='./cus_documentosp_excel.php?doc_no=".$_POST['doc_no']."'\" name='excel'/></h3>
                 </tr>
				";
		}
	?>
</table>
<div class="resultado">
<br>
<table width="80%" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<th>No. DOCUMENTO</th>
<th>TIPO DOC</th>
<th>DOC. AFECTADO</th>
<th>F. DOC</th>
<th>F. VEN</th>
<th>DÍAS MORA</th>
<th>VALOR DOC</th>
</div>
<?
for( $i=0; $i<$cont;$i++)
 {
	echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Hijo
	//echo "<td>".$arc_cus_no[$i]."</td>";
	//Nombre del cliente
	//echo "<td>".$arc_cus_name[$i]."</td>";
	//Código Vendedor
	//echo "<td>".$arc_slspsn_no[$i]."</td>";
	//Código Padre
	//echo "<td>".$arc_par_cus_no[$i]."</td>";
/*****************************  FIN ARCUSFIL  ****************************/
	$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
	$interval = dias_cartera($date_doc,date("Y-m-d"));
	$d_cartera = $interval-$arc_ar_terms_cd[$i];

/*****************************  INICIO AROPNFIL  ****************************/
	//
	//echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//
	//echo "<td>".substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],6,2)."</td>";
	//
	echo "<td>".$aro_doc_no[$i]."</td>";
	//
	if( $aro_doc_type[$i]== 'I' )
		echo "<td>FACTURA</td>";
	else if( $aro_doc_type[$i]== 'C' )
		echo "<td>N. CRÉDITO</td>";
	else if( $aro_doc_type[$i]== 'D' )
		echo "<td>N. DÉBITO</td>";
	else if( $aro_doc_type[$i]== 'P' )
		echo "<td>PAGO</td>";
	else
		echo "<td>Otro</td>";
	//
	echo "<td>".$aro_apply_to_no[$i]."</td>";
	//
	//echo "<td>".$aro_curr_cd[$i]."</td>";
	//F. documento / F. Vencimiento
	echo "<td>".substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],6,2)."</td>";
	echo "<td>".date_format($fecha_new[$i], 'Y/m/d')."</td>";
	//Días de Mora
	if($d_cartera > 0 && $aro_doc_type[$i]== 'I' && $total_cliente > 0 )
		echo "<td style='background-color:blue;'>".$d_cartera."</td>";
	else
		echo "<td>N/A</td>";	
	//Saldo	
	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	//
	//echo "<td>".$aro_ar_terms_cd[$i]."</td>";
	//Código Vendedor
	//echo "<td>".$aro_slspsn_no[$i]."</td>";
	//
	//echo "<td>".$aro_curr_trx_rt[$i]."</td>";
/*****************************  FIN AROPNFIL  ****************************/	

/*****************************  INICIO ARSLMFIL  ****************************/
	//Nombre Vendedor
	//echo "<td>".$ars_slspsn_name[$i]."</td>";
/*****************************  FIN ARSLMFIL  ****************************/	
	echo "</tr>";
 }//for
?>
	<tr>
		<td colspan="6" align="right"> <b>Saldo Documento : </b></td>
		<td align='right'><b><?echo number_format($total_cliente,2);?></b></td>
	</tr>
</table>

<br>
</div>
</body>
</html>


