<!DOCTYPE html>
<html lang="es">
<head>
	<title>Cartera Continental</title>
	<meta name="viewport" content="width=device-width , maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jqusery-latest.min.js"></script>
    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="sty.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="estilos.css"/>
	<script languaje="JavaScript1.2" type="text/javascript">

		function valida_envia( formulario )
		{
			if( formulario.cut_date.value.length == 0 )
			{
				alert("Debe ingresar la fecha de corte (DD/MM/AAAA)!");
				document.consulta.cut_date.focus(); return false;
			}
			else
			{
				return true;
			}
		}
	</script>		

	<script src="./scripts/scw.js" type="text/javascript"></script>
</head>
<body bgcolor="#FFFFFF" text="#333334" link="#0000FF" topmargin="0" rightmargin="0">
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
         <li><a href="./age_cxc_group_cont.php"><span>11.Cartera Continental(Pruebas)</span></a></li>
         <li><a><div class='has-sub'>CONTABILIDAD DRYPERS</div></a></li>
         <li class='last'><a href="./gastosfijos.php"><span>1.Gastos Fijos</span></a></li>
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

require("./session/libreria.php");


if( isset($_POST['cut_date']) )
{
	$link = Fconectar();
	
	$cut_date_explode = explode("/", $_POST['cut_date']);
	
	$Fcorte = $cut_date_explode[2].$cut_date_explode[1].$cut_date_explode[0];
	
	if( $link )
	{
		// Se define la consulta que va a ejecutarse, como en sql
		 $sql = 
				"
					SELECT     C.nit, C.cus_name, 
					SUM(f.amt_1 + f.amt_2) AS VALOR 
					FROM         ARSLMFIL_SQL AS V,
								 AROPNFIL_SQL AS F  INNER JOIN
								 ARCUSFIL_SQL AS C ON F.cus_no = C.cus_no 
					WHERE      (F.doc_dt <= $Fcorte) AND (C.curr_cd = 'PES') AND (C.cus_no <> '000000003487') AND (C.collector = V.slspsn_no)
					GROUP BY   C.nit, C.cus_name
					HAVING      (SUM(f.amt_1 + f.amt_2) <> 0)
					ORDER BY VALOR DESC
				";

		// Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql ) or die ( "Error en instruccion SQL $sql" );
		 $existe = odbc_num_rows ( $results );

		 if ( $existe )
		 {
			$i = 0;

			while($registro = odbc_fetch_array($results))
			{
				$arc_cus_nit[$i]=$registro['nit'];
				//$arc_cus_no[$i] = $registro['cus_no'];
				$arc_cus_name[$i] = $registro['cus_name'];
				//$arc_slspsn_no[$i] = $registro['slspsn_no'];
				//$aro_cus_no[$i] = $registro['cus_no2'];
				//$aro_doc_dt[$i] = $registro['inv_doc_dt'];
				//$aro_doc_dt[$i] = $registro['doc_dt'];
				//$aro_doc_no[$i] = $registro['doc_no'];
				//$aro_doc_type[$i] = $registro['doc_type'];
				//$aro_apply_to_no[$i] = $registro['apply_to_no'];
				//$aro_curr_cd[$i] = $registro['curr_cd'];
				//$aro_doc_due_dt[$i] = $registro['doc_due_dt'];
				$aro_amt[$i] = $registro['VALOR'];
				//$fp = $arc_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				//$aro_slspsn_no[$i] = $registro['slspsn_no2'];
				//$aro_curr_trx_rt[$i] = $registro['curr_trx_rt'];
				//$ars_slspsn_name[$i] = $registro['slspsn_name'];
				$total_cliente += $aro_amt[$i]; 

				 $sql2 = 
						"
							SELECT	cus_no, cr_lmt, cr_card_1_desc, cr_card_2_desc
							FROM	ARCUSFIL_SQL 
							WHERE	cus_name = '$arc_cus_name[$i]'
						";

				// Se ejecuta la consulta y se guardan los resultados
				$results2 = odbc_exec( $link, $sql2 ) or die ( "Error en instruccion SQL $orden" );
				$registro2 = odbc_fetch_array($results2);

				$arc_cus_no[$i] = $registro2['cus_no'];
				$arc_cr_dry[$i] = $registro2['cr_lmt'];
				$arc_cr_usd[$i] = $registro2['cr_card_1_desc'];
				$arc_cr_risk[$i] = $registro2['cr_card_2_desc'];
							
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
		Ferror("No se pudo establecer conexion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );

}//if isset...

?>
<div class="main_content">
<br>
<table width="80%" border="0" align="center">
	<tr>
	<tr>
	<td><h6>Cartera Continental Drypers</h6><td>
	</tr>
		<td align='left'> <h5> Selecione fecha de corte:</h5></td>
			<form name="consulta" action="age_cxc_group_cont.php" method="post" onsubmit="return valida_envia(this);">
			<td width="5%"><input name="cut_date" type="text" title="DD/MM/YYYY" onclick="scwShow(this,this);" /></td>
			<td width="2%"><input type="submit" class="cal" value="Generar Consulta" /></td>		
			</form>
		</td>
	</tr>
	<?
		if( isset($_POST['cut_date']) )
		{
			echo"
				<tr>
					<td colspan='2'><br><h3>Cartera Agrupado por Cliente - Continental: ".$_POST['cut_date']."</h3></td>
				</tr>
				<tr>
					<td colspan='2'><h3> Fecha de Generación: ".date('d/m/Y h:i:s')."</h3></td>
				</tr>
				<tr>
				<td align='right'><h3><input type='button' value='Exportar a Excel' class='excel' onclick=\"location.href='./age_cxc_group_cont_excel.php?cut_date=".$_POST['cut_date']."'\" name='excel'/></h3></td>
				</tr>
				";
		}
	?>
</table>
<div class="resultado">
<br>
<table width="80%" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<th>CÓDIGO</th>
<th>CLIENTE</th>
<th>NIT</th>
<th>SALDO</th>
<th>CUPO LINEA DE CRÉDITO</th>
<th>CUPO ASEGURADO</th>
<th>CALIFIC.</th>
</div>
</div>
<?
$lineac=0;
$seguro=0;
for( $i=0; $i<$cont;$i++)
 {
	echo "<tr>";

	//Código
	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nombre del cliente
	echo "<td><a class='customer_link' href='./age_cxc_cus.php?cus_no=".$arc_cus_no[$i]."'>".$arc_cus_name[$i]."</a></td>";
	//Nit
	echo "<td>".number_format($arc_cus_nit[$i],0,'','')."</td>";
	//Saldo
	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	//Cupo Drypers
	echo "<td align='right'>".number_format($arc_cr_dry[$i],2)."</td>";
	$lineac += $arc_cr_dry[$i];
	//Cupo Continental (USD)
	echo "<td align='right'>".number_format($arc_cr_usd[$i],2)."</td>";
	$seguro += $arc_cr_usd[$i];
	//Calificación de riesgo
	echo "<td align='right'>".$arc_cr_risk[$i]."</td>";	
	
	echo "</tr>";
 }//for

?>
	<tr>
		<td colspan="3" align="right"> <b>Total Cartera : </b></td>
		<td align='right'><b><?echo number_format($total_cliente,2);?></b></td>
		<td align='right'><b><?echo number_format($lineac,2);?></b></td>
		<td align='right'><b><?echo number_format($seguro,2);?></b></td>		
		<td align='right'></td>		
	</tr>
</table>
<br>
</table>
</body>
</html>


