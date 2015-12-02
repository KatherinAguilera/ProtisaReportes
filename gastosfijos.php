<!DOCTYPE html>
<html lang="es">
<head>
	<title>Gastos Fijos</title>
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
				SELECT GLTRXHST_SQL.mn_no, GLTRXHST_SQL.sb_no, GLTRXHST_SQL.dp_no, SYACTFIL_SQL.acct_desc, GLTRXHST_SQL.trx_amt, GLTRXHST_SQL.trx_dt, CMCURRAT_SQL.curr_rt 
                    FROM GLTRXHST_SQL 
                    INNER JOIN SYACTFIL_SQL ON GLTRXHST_SQL.mn_no = SYACTFIL_SQL.mn_no  
                    AND GLTRXHST_SQL.sb_no = SYACTFIL_SQL.sb_no  
                    AND GLTRXHST_SQL.dp_no = SYACTFIL_SQL.dp_no  
                    INNER JOIN CMCURRAT_SQL ON GLTRXHST_SQL.trx_dt = CMCURRAT_SQL.curr_rt_eff_dt  
                    WHERE CMCURRAT_SQL.curr_cd = 'usd' 
                    AND GLTRXHST_SQL.mn_no BETWEEN '51050000' AND '73959999' 
                    AND GLTRXHST_SQL.trx_dt BETWEEN 20131001 AND 20131031 
                    ORDER BY GLTRXHST_SQL.mn_no
				";
				
		// Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql ) or die ( "Error en instruccion SQL $sql" );
		 $existe = odbc_num_rows ( $results );

		 if ( $existe )
		 {
			$i = 0;

			while($registro = odbc_fetch_array($results))
			{
				$gasto_fijo;
				$mn_no[$i]=$registro['mn_no'];
				$sb_no[$i] = $registro['sb_no'];
   				$dp_no[$i] = $registro['dp_no'];
				$acct_desc[$i] = $registro['acct_desc'];
				$trx_amt[$i] = $registro['trx_amt'];
		//		$trx_dt[$i] = $registro['trx_dt'];
				$curr_rt[$i]=$registro['curr_rt'];

			}//while
			
				$i++;
			}
			$cont=$i;
		
	
	}//if( $link > 0 )
	else
	{
		Ferror("No se pudo establecer conexión con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close($link);
}

//if isset...

?>
<div class="main_content">
<br>
<table width="80%" border="0" align="center">
	<tr>
	<tr>
	<td><h6>Gastos Fijos</h6></td>
	</tr>
		<td align='left'> <h5>Selecione fecha: </h5></td>
			<form name="consulta" action="gastosfijos.php" method="post" onsubmit="return valida_envia(this);">
			<td width="5%"><input name="cut_date" type="text" title="DD/MM/YYYY" onclick="scwShow(this,this);" /></td>
			<td width="2%"><input type="submit" class="cal" value="Generar Consulta" /></td>		
			</form>
			</tr>
	<?
		if( isset($_POST['cut_date']) )
		{
			echo"
				<tr>
					<td colspan='2'><br><h3>Gastos Fijos - : Generación".$_POST['cut_date']."</h3></td>
				</tr>
				<tr>
					<td colspan='2'><h3> Fecha de Generación: ".date('d/m/Y h:i:s')."</h3></td>
				</tr>
				<tr>
				</tr>
				";
		}
	?>
</table>
<div class="resultado">
<br>
<table width="80%" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<th>GASTO</th>
<th>CUENTA</th>
<th>CC1</th>
<th>CC2</th>
<th>DESCRIPCIÓN</th>
<th>VALOR</th>
</div>
 </div>
<?
/*****************************  INICIO  MOSTRAR CONSULTAS ****************************/
for($i=0; $i<$cont;$i++)
 {
	echo "<tr>";

if( $mn_no[$i]== 5110 || $mn_no[$i]== 5115 || $mn_no[$i] == 5120 || $mn_no[$i] == 5125 || $mn_no[$i] ==5130 || $mn_no[$i] == 5135 || $mn_no[$i] == 5140 || 
	$mn_no[$i] == 5150 || $mn_no[$i] == 5155 $mn_no[$i]==5165 || $mn_no[$i] == 5195 || $mn_no[$i] == 5210 || $mn_no[$i] == 5215 || $mn_no[$i] == 5220 ||
	$mn_no[$i] == 5225 || $mn_no[$i] == 5230 || $mn_no[$i] == 5235 || $mn_no[$i] == 51240 $mn_no[$i] == 5250|| $mn_no[$i] == 5255 || $mn_no[$i] == 5265 || 
	$mn_no[$i] == 5295 || $mn_no[$i] == 7310 || $mn_no[$i] == 7315 || $mn_no[$i] == 7320 || $mn_no[$i] == 7325 || $mn_no[$i] == 7330 $mn_no[$i] == 7335 || 
	$mn_no[$i] == 7340 || $mn_no[$i] == 7350 || $mn_no[$i] == 7355 || $mn_no[$i] == 7365 || $mn_no[$i] == 7395)
{

   echo "<td>GENERALES</td>";
}

if( $mn_no[$i] == 5145 || $mn_no[$i] == 5245 || $mn_no[$i] == 7345)
{
	echo"<td>MANTENIMIENTO</td>";
}

if( $mn_no[$i] == 5105 || $mn_no[$i] == 5205 || $mn_no[$i] == 7305)
{
	echo"<td>REMUNERACIÓN</td>";
}
//	if( $gasto_fijo[$i]==73959505)
  //   {
	//	echo "<td>GENERALES</td>";
	 //}
	//else if( $aro_doc_type[$i]== 'C' )
	//	echo "<td>N. CRÉDITO</td>";
	//else if( $aro_doc_type[$i]== 'D' )
	//	echo "<td>N. DÉBITO</td>";
	//else if( $aro_doc_type[$i]== 'P' )
	//	echo "<td>PAGO</td>";
	//else
	//	echo "<td>Otro</td>";
	echo "<td>".$mn_no[$i]."</td>";
	//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
    echo "<td>".$sb_no[$i]."</td>";
    echo "<td>".$dp_no[$i]."</td>";
    echo "<td>".$acct_desc[$i]."</td>";
 //   echo "<td>".$trx_amt[$i]."</td>";
//  echo "<td>".$trx_dt[$i]."</td>";
    echo "<td>".$curr_rt[$i]."</td>";
	echo "</tr>";
 }//for
?>
</table>
<br>
</table>
</body>
</html>