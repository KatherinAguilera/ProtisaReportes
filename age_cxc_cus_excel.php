<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"carteraporcliente.csv\"" );
 
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



//	echo "CLiente,Vendedor,Cobrador,CondicionDePago,\n";
//	echo"
//	<div class='edad'>
//		<div align='center'>
//		<table width='40%' border='3' cellpadding='0' cellspacing='10' bordercolor='#DCF3A4' align='center'>
//			<th colspan='2'>EDADES DE CARTERA POR CLIENTE (Datos hasta: ".date('d-m-Y').")</th>	
//			<tr>
//				<td>Cliente:</td>
	  //  $registro_cxc = number_format($head_cus_no,0,'','');	
				//<td>(".number_format($head_cus_no,0,'','').") - $head_cus_name</td>
			//</tr>
			//<tr>
			//	<td>Vendedor:</td>
	  //  $registro_cxc .= ",".$head_slspsn_name;
			//	<td>$head_slspsn_name</td>
			//</tr>
			//<tr>
				//<td>Cobrador:</td>
	   //  $registro_cxc .= ",".$head_collector;
				//<td>$head_collector</td>
			//</tr>
			//<tr>
				//<td>Condición de Pago:</td>
	   //  $registro_cxc .= ",".$head_ar_terms_cd;

			//	<td>$head_ar_terms_cd</td>
		//	</tr>
		//	<tr>
	   //  $registro_cxc .= ",".date_format($fecha_new[$i], 'd/m/Y');
	        	//$registro_cxc .= ",".date,('d/m/Y');
			//	<td colspan='2' align='center'>Generado: ".date('d-m-Y H:i:s')."</td>
//			</tr>
//			<td align='right'><h3><input type='button' value='Exportar a Excel' class='excel'onclick=\"location.href='http://localhost/reportesc/ace_cxc_excel.php?cut_date=".$_POST['cut_date']."'\" name='excel'/></h3>
//		</table>
//		</div>
//		</div>
	
//		";
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
		Ferror("No se pudo establecer conexion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );

}//if isset...


	if( isset($_POST['cus_no']) || isset($_GET['cus_no']) )
		{
			head_cus($arc_cus_no[0]);
		}

echo "COD,CP,FACTURA,F. DOC,F. VEN,D. MORA,SALDO,CORRIENTE,1 A 10,11 A 90,91 A 180,>180,\n";

for( $i=0; $i<$cont;$i++)
 {
	//echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Padre
	//echo "<td>".number_format($arc_par_cus_no[$i],0,'','')."</td>";
	//Código Hijo


    $registro_cxc = number_format($arc_cus_no[$i],0,'','');	
	//echo "<td  width='40 px'>".number_format($arc_cus_no[$i],0,'','')."</td>";
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
    	$registro_cxc .= ",".$arc_ar_terms_cd[$i];

	//Factura

    	$registro_cxc .= ",".$aro_apply_to_no[$i];

	//Fecha documento
     $registro_cxc .= ",".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4);
   //	$registro_cxc .= ",".$aro_doc_dt[$i];

//	echo "<td  width='80 px'>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
	//Fecha Vencimiento

	 $registro_cxc .= ",".date_format($fecha_new[$i], 'd/m/Y');
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
//	echo "<td>".$aro_doc_type[$i]."</td>";

//Días de Mora
//	if($d_cartera > 0)

	$registro_cxc .= ",".$d_cartera;
	//	echo "<td  width='20 px' style='background-color:red;'>".$d_cartera."</td>";
	//else
	//	echo "<td  width='20 px'>".$d_cartera."</td>";
	//Saldo
	$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");

//	echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
	//Corriente
	if( $d_cartera < 0 )
	{
        $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$corriente += $aro_amt[$i];
	}
	else
	{
		//echo "<td  width='140 px' align='right'>0.00</td>";
       $registro_cxc .= ",0.00";
   }

	//1 a 10
	if( $d_cartera > 0 && $d_cartera < 11 )
	{
        $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	//	echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad1 += $aro_amt[$i];
	}
	else
	{
		//echo "<td  width='140 px' align='right'>0.00</td>";
		  $registro_cxc .= ",0.00";
	}
	//11 a 90
	if( $d_cartera > 10 && $d_cartera < 91 )
	{
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		//echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad2 += $aro_amt[$i];
	}
	else 
	{	
		$registro_cxc .= ",0.00";
		//echo "<td  width='140 px' align='right'>0.00</td>";
	}	
	//91 a 180
	if( $d_cartera > 90 && $d_cartera < 181 )
	{
        $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		//echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad3 += $aro_amt[$i];
	}
	else
	{
		$registro_cxc .= ",0.00";
	}
	//	echo "<td  width='140 px' align='right'>0.00</td>";
	//Más de 180
	if( $d_cartera > 180 )
	{
	    $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	//	echo "<td  width='140 px' align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad4 += $aro_amt[$i];
	}
	else
	{
	$registro_cxc .= ",0.00";
	
		//echo "<td  width='140 px' align='right'>0.00</td>";
	}		
	

 //   $registro_cxc = number_format($head_cus_no,0,'','');	
	//$registro_cxc .= ",".$head_slspsn_name;
	//$registro_cxc .= ",".$head_collector;
    //$registro_cxc .= ",".$head_ar_terms_cd;
    
	echo $registro_cxc.",\n";
 }

 //for

 
	if( !$total_cliente )
		$total_cliente = 0.001;

echo ",,,,,,".number_format($total_cliente,2,".","").",".number_format($corriente,2,".","").",".number_format($edad1,2,".","").",".number_format($edad2,2,".","").",".number_format($edad3,2,".","").",".number_format($edad4,2,".","").",\n";
echo ",,,,,,100%,".number_format($corriente/$total_cliente*100,2,".","")."%,".number_format($edad1/$total_cliente*100,2,".","")."%,".number_format($edad2/$total_cliente*100,2,".","")."%,".number_format($edad3/$total_cliente*100,2,".","")."%,".number_format($edad4/$total_cliente*100,2,".","")."%,\n"; 


?>