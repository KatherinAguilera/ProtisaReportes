<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"agrupadocliente.csv\"" );

require("./session/libreria.php");

function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

if( isset($_GET['cut_date']) )
{
	$link = Fconectar();
	
	
	
	$cut_date_explode = explode("/", $_GET['cut_date']);
	
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
/*				
				if( $registro['par_cus_no'] == NULL )
					$arc_par_cus_no[$i] = $registro['cus_no'];
				else	
					$arc_par_cus_no[$i] = $registro['par_cus_no'];
*/				
				$arc_par_cus_no[$i]=$registro['nit'];
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
				$fp = $arc_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				//$aro_slspsn_no[$i] = $registro['slspsn_no2'];
				//$aro_curr_trx_rt[$i] = $registro['curr_trx_rt'];
				//$ars_slspsn_name[$i] = $registro['slspsn_name'];
				$total_cliente += $aro_amt[$i]; 

				 $sql2 = 
						"
							SELECT	cus_no
							FROM	ARCUSFIL_SQL 
							WHERE	cus_name = '$arc_cus_name[$i]'
						";

				// Se ejecuta la consulta y se guardan los resultados
				$results2 = odbc_exec( $link, $sql2 ) or die ( "Error en instruccion SQL $orden" );
				$registro2 = odbc_fetch_array($results2);

				$arc_cus_no[$i] = $registro2['cus_no'];				 
				
				//$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
				
				//$fecha_new[$i] = date_create($date_doc);
				//$fp .= " days";
				
				//date_add($fecha_new[$i], date_interval_create_from_date_string($fp));
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

echo "NIT,CLIENTE,SALDO,\n";

for( $i=0; $i<$cont;$i++)
 {
	//echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Padre

//	echo "<td>".number_format($arc_par_cus_no[$i],0,'','')."</td>";
	$registro_cxc = number_format($arc_par_cus_no[$i],0,'','');	

	//Código Hijo
	//echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nombre del cliente

//	echo "<td><a class='customer_link' href='./age_cxc_cus.php?cus_no=".$arc_cus_no[$i]."'>".$arc_cus_name[$i]."</a></td>";  
     $registro_cxc .= ",".$arc_cus_name[$i];	
	//Código Vendedor
//	echo "<td>".$arc_slspsn_no[$i]."</td>";
/*****************************  FIN ARCUSFIL  ****************************/
	
	//$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
	//$interval = dias_cartera($date_doc,date("Y-m-d"));
	//$d_cartera = $interval-$arc_ar_terms_cd[$i];
	//Nombre Vendedor
	//echo "<td>".$ars_slspsn_name[$i]."</td>";

/*****************************  INICIO AROPNFIL  ****************************/
	//Forma de Pago
	//echo "<td>".$arc_ar_terms_cd[$i]."</td>";
	//Fecha documento
	//echo "<td>".substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],6,2)."</td>";
	//Fecha Vencimiento
	//echo "<td>".date_format($fecha_new[$i], 'Y/m/d')."</td>";
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
//	echo "<td>".$aro_doc_type[$i]."</td>";
	//Factura
	//echo "<td>".$aro_apply_to_no[$i]."</td>";
	//Moneda
//	echo "<td>".$aro_curr_cd[$i]."</td>";
	//Saldo

    	$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");

	//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
/*
	//Corriente
	if( $d_cartera <= 0 || $arc_cus_no[$i] == 1289 || $arc_cus_no[$i] == 1029 || $arc_cus_no[$i] == 1280 || $arc_cus_no[$i] == 1003 || $arc_cus_no[$i] == 1292 || $arc_cus_no[$i] == 1294 || $arc_cus_no[$i] == 9997 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$corriente += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//1 a 10
	if( $d_cartera > 0 && $d_cartera < 11 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad1 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//11 a 90
	if( $d_cartera > 10 && $d_cartera < 91 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad2 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//91 a 180
	if( $d_cartera > 90 && $d_cartera < 181 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad3 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
	//Más de 180
	if( $d_cartera > 180 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 )
	{
		echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$edad4 += $aro_amt[$i];
	}
	else
		echo "<td align='right'>0.00</td>";
*/
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
	
	//echo "</tr>";

echo $registro_cxc.",\n";
 }//for

 
	if( !$total_cliente )
		$total_cliente = 0.001;
	echo ",".number_format($total_cliente,2,".","").",\n";

?>