<!DOCTYPE html>
<html lang="es">
<head>
	<title>Edades de Cartera por Cliente</title>
	<meta name="viewport" content="width=device-width , maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jqusery-latest.min.js"></script>
    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="sty.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="estilos.css"/>

	<style>
    .floatingHeader {
      position: fixed;
      top: 0;
      visibility: hidden;
    }
	</style>
	
  <script src="./scripts/jquery.min.js"></script>
  
  <script>
    function UpdateTableHeaders() {
       $(".persist-area").each(function() {
       
           var el             = $(this),
               offset         = el.offset(),
               scrollTop      = $(window).scrollTop(),
               floatingHeader = $(".floatingHeader", this)
           
           if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
               floatingHeader.css({
                "visibility": "visible"
               });
           } else {
               floatingHeader.css({
                "visibility": "hidden"
               });      
           };
       });
    }
    
    // DOM Ready      
    $(function() {
    
       var clonedHeaderRow;
    
       $(".persist-area").each(function() {
           clonedHeaderRow = $(".persist-header", this);
           clonedHeaderRow
             .before(clonedHeaderRow.clone())
             .css("width", clonedHeaderRow.width())
             .addClass("floatingHeader");
             
       });
       
       $(window)
        .scroll(UpdateTableHeaders)
        .trigger("scroll");
       
    });
  </script>

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
         <li><a href="./age_cxc_cus.php"><span>1.Cartera Por Cliente</span></a></li>
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
         <li><a href='#'><span>Consulta1</span></a></li>
         <li class='last'><a href='#'><span>Consulta2</span></a></li>
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
		 $results = odbc_exec( $link, $sql_datos_cus ) or die ( "Error en instruccion SQL $sql_datos_cus" );
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
	<div class='edad'>
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


		<td align='left'><h3><input type='button' value='Exportar a Excel' class='excel'onclick=\"location.href='./age_cxc_cus_excel.php?cus_no=".$_POST['cus_no']."'\" name='excel'/></h3>
		</div>
		</div>
	
		";
}

if( isset($_POST['cus_no']) || isset($_GET['cus_no']) || isset($_GET['cut_date']) )
{
	$Customer_no = number_format($_GET['cus_no'],0,'','');
	$Fcorte = $_GET['cut_date'];
	
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
					WHERE      (C.curr_cd = 'PES') AND ((C.par_cus_no = $Customer_no) OR (C.cus_no = $Customer_no)) AND (doc_dt <= $Fcorte)
					GROUP BY    C.par_cus_no, F.cus_no, C.cus_name, f.apply_to_no, C.ar_terms_cd
					HAVING      (SUM(f.amt_1 + f.amt_2) <> 0)
					ORDER BY doc_dt
				";
		
			//echo $sql;
				
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
<div class="main_content">
<br>
<td><h6>Cartera Por Cliente</h6></td>
<br>
	<?
		if( isset($_POST['cus_no']) || isset($_GET['cus_no']) )
		{
			head_cus($arc_cus_no[0]);
		}
	?>


	
<br>
<div class='resultado'>
<div align='center'>
<table class="area" width="1000 px" border="3" cellpadding="0" cellspacing="10" bordercolor="#DCF3A4" align='center'>
<thead>
  <tr class="persist-header">

<!--<th>COD. PADRE</th>-->
<th width="40 px">CÓDIGO</th>
<!--<th>CLIENTE</th>-->
<th width="20 px">CP</th>
<th width="50 px">No. FACTURA</th>
<th width="80 px">F. DOC</th>
<th width="80 px">F. VEN</th>
<th width="60 px">DÍAS MORA</th>
<th width="20 px">SALDO</th>
<th width="140 px">CORRIENTE</th>
<th width="140 px">1 A 10</th>
<th width="140 px">11 A 90</th>
<th width="140 px">91 A 180</th>
<th width="140 px">MÁS DE 180</th>
  </tr>
</thead>
<tbody>
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
	echo "<td  width='40 px'>".number_format($arc_cus_no[$i],0,'','')."</td>";
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
	echo "<td  width='20 px'>".$arc_ar_terms_cd[$i]."</td>";
	//Factura
	echo "<td  width='80 px'>".$aro_apply_to_no[$i]."</td>";
	//Fecha documento
	echo "<td  width='80 px'>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
	//Fecha Vencimiento
	echo "<td  width='60 px'>".date_format($fecha_new[$i], 'd/m/Y')."</td>";
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
//	echo "<td>".$aro_doc_type[$i]."</td>";
	//Días de Mora
	if($d_cartera > 0)
		echo "<td  width='20 px' style='background-color:red;'>".$d_cartera."</td>";
	else
		echo "<td  width='20 px'>".$d_cartera."</td>";	
	//Moneda
//	echo "<td>".$aro_curr_cd[$i]."</td>";
	//Saldo
	echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
	//Corriente
	if( $d_cartera < 0 )
	{
		echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$corriente += $aro_amt[$i];
	}
	else
		echo "<td  width='140 px' align='right'>0.00</td>";
	//1 a 10
	if( $d_cartera > 0 && $d_cartera < 11 )
	{
		echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad1 += $aro_amt[$i];
	}
	else
		echo "<td  width='140 px' align='right'>0.00</td>";
	//11 a 90
	if( $d_cartera > 10 && $d_cartera < 91 )
	{
		echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad2 += $aro_amt[$i];
	}
	else
		echo "<td  width='140 px' align='right'>0.00</td>";
	//91 a 180
	if( $d_cartera > 90 && $d_cartera < 181 )
	{
		echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad3 += $aro_amt[$i];
	}
	else
		echo "<td  width='140 px' align='right'>0.00</td>";
	//Más de 180
	if( $d_cartera > 180 )
	{
		echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad4 += $aro_amt[$i];
	}
	else
		echo "<td  width='140 px' align='right'>0.00</td>";
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
		<td colspan="6" width="260 px" align="right"> <b>Total Cartera : </b></td>
		<td  width="140 px" align='right'><b><?echo number_format($total_cliente,2);?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($corriente,2);?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad1,2);?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad2,2);?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad3,2);?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad4,2);?></b></td>
		
	</tr>
	<tr>
		<td colspan="6" width="260 px" align="right"> <b>Total Cartera en % : </b></td>
		<td  width="140 px" align='right'><b>100%</b></td>
		<td  width="140 px" align='right'><b><?echo number_format($corriente/$total_cliente*100,2)."%";?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad1/$total_cliente*100,2)."%";?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad2/$total_cliente*100,2)."%";?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad3/$total_cliente*100,2)."%";?></b></td>
		<td  width="140 px" align='right'><b><?echo number_format($edad4/$total_cliente*100,2)."%";?></b></td>
		
	</tr>
</tbody>	
</table>
</div align='center'>
<br>
</body>
</html>


