<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"carteracobrador.csv\"" );

require("./session/libreria.php");

function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}


if( isset($_GET['sal_no']) )
{
	$Salesm_no = $_GET['sal_no'];

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
					WHERE      (C.curr_cd = 'PES') AND (C.collector = $Salesm_no)
					GROUP BY    C.par_cus_no, F.cus_no, C.cus_name, f.apply_to_no, C.ar_terms_cd
					HAVING      (SUM(f.amt_1 + f.amt_2) <> 0)
					ORDER BY C.par_cus_no, doc_dt
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
		Ferror("No se pudo establecer conexion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );

}//if isset...

echo "COD,CLIENTE,CP,FACTURA,F. DOC,F. VEN,D. MORA,SALDO,CORRIENTE,1 A 10,11 A 90,91 A 180,>180,\n";

for( $i=0; $i<$cont;$i++)
 {
//	echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Padre
	//echo "<td>".number_format($arc_par_cus_no[$i],0,'','')."</td>";
	//Código Hijo
    $registro_cxc = number_format($arc_cus_no[$i],0,'','');	
	//echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nombre del cliente
	//echo "<td>".$arc_cus_name[$i]."</td>";
	$registro_cxc .= ",".$arc_cus_name[$i];
	//Código Vendedor
//	echo "<td>".$arc_slspsn_no[$i]."</td>";
/*****************************  FIN ARCUSFIL  ****************************/
	
	$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
	$interval = dias_cartera($date_doc,date("Y-m-d"));
	$d_cartera = $interval-$arc_ar_terms_cd[$i];

/*****************************  INICIO AROPNFIL  ****************************/
	//Forma de Pago
	//echo "<td>".$arc_ar_terms_cd[$i]."</td>";
    $registro_cxc .= ",".$arc_ar_terms_cd[$i];
	//Factura
	//echo "<td>".$aro_apply_to_no[$i]."</td>";
	$registro_cxc .= ",".$aro_apply_to_no[$i];
	//Fecha documento
	//echo "<td>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
	$registro_cxc .= ",".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4);
	//Fecha Vencimiento
	//echo "<td>".date_format($fecha_new[$i], 'd/m/Y')."</td>";
	$registro_cxc .= ",".date_format($fecha_new[$i], 'd/m/Y');
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
//	echo "<td>".$aro_doc_type[$i]."</td>";
	//Días de Mora
//	if($d_cartera > 0)
//		echo "<td style='background-color:red;'>".$d_cartera."</td>";
//	else
//		echo "<td>".$d_cartera."</td>";	
    $registro_cxc .= ",".$d_cartera;
	//Moneda
//	echo "<td>".$aro_curr_cd[$i]."</td>";
	//Saldo
//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
    $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	//Corriente
	if( $d_cartera < 0 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	$corriente += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
	$registro_cxc .= ",0.00";

	}
	//1 a 10
	if( $d_cartera > 0 && $d_cartera < 11 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	$edad1 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
			$registro_cxc .= ",0.00";
	}
	//11 a 90
	if( $d_cartera > 10 && $d_cartera < 91 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	$edad2 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";

	}
	//91 a 180
	if( $d_cartera > 90 && $d_cartera < 181 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad3 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//Más de 180
	if( $d_cartera > 180 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	$edad4 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
	$registro_cxc .= ",0.00";

	}
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
	
//	echo "</tr>";
echo $registro_cxc.",\n";
 }//for

 if( !$total_cliente )
		$total_cliente = 0.001;

echo ",,,,,,".number_format($total_cliente,2,".","").",".number_format($corriente,2,".","").",".number_format($edad1,2,".","").",".number_format($edad2,2,".","").",".number_format($edad3,2,".","").",".number_format($edad4,2,".","").",\n";
echo ",,,,,,100%,".number_format($corriente/$total_cliente*100,2,".","")."%,".number_format($edad1/$total_cliente*100,2,".","")."%,".number_format($edad2/$total_cliente*100,2,".","")."%,".number_format($edad3/$total_cliente*100,2,".","")."%,".number_format($edad4/$total_cliente*100,2,".","")."%,\n"; 

?>