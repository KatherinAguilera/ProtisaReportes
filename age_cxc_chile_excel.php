<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"carterachile.csv\"" );

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
					SELECT     C.par_cus_no, F.cus_no, C.cus_name, f.apply_to_no, C.ar_terms_cd, 
					dbo.get_ar_doc_dt(f.cus_no, f.apply_to_no) as doc_dt, 
					dbo.get_ar_doc_due(f.cus_no, f.apply_to_no) as doc_due_dt, 
					dbo.get_ar_slspsn_no(f.cus_no, f.apply_to_no) as slspsn_no, 
					( select slspsn_name from ARSLMFIL_SQL where slspsn_no = dbo.get_ar_slspsn_no(f.cus_no, f.apply_to_no)) as slspsn_name,
					SUM(f.amt_1 + f.amt_2) AS VALOR 
					FROM         AROPNFIL_SQL AS F  INNER JOIN
								 ARCUSFIL_SQL AS C ON F.cus_no = C.cus_no 
					WHERE      (F.doc_dt <= $Fcorte) AND (C.curr_cd = 'PES') AND (C.cus_no <> '000000003487')
					GROUP BY    C.par_cus_no, F.cus_no, C.cus_name, f.apply_to_no, C.ar_terms_cd
					HAVING      (SUM(f.amt_1 + f.amt_2) <> 0)
					ORDER BY C.cus_name, F.cus_no
				";
		// Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql ) or die ( "Error en instruccion SQL $orden" );
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
				$arc_cus_no[$i] = $registro['cus_no'];
				$arc_cus_name[$i] = $registro['cus_name'];
				//$arc_slspsn_no[$i] = $registro['slspsn_no'];
				//$aro_cus_no[$i] = $registro['cus_no2'];
				//$aro_doc_dt[$i] = $registro['inv_doc_dt'];
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

echo "COD,CLIENTE,FACTURA,F. DOC,F. VEN,D. MORA,SALDO,CORRIENTE,1 A 30,31 A 60,61 A 90,91 A 120,121 A 150,151 A 180,181 A 210,211 A 250,>250,\n";

for( $i=0; $i<$cont;$i++)
 {
//	echo "<tr>";
/*****************************  INICIO ARCUSFIL  ****************************/
	//Código Padre
//	echo "<td>".number_format($arc_par_cus_no[$i],0,'','')."</td>";
	//Código Hijo
//	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
    $registro_cxc = number_format($arc_cus_no[$i],0,'','');	

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
	//Factura
	//echo "<td>".$aro_apply_to_no[$i]."</td>";
     $registro_cxc .= ",".$aro_apply_to_no[$i];
     
	//Fecha documento
//	echo "<td>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
     $registro_cxc .= ",".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4);

	//Fecha Vencimiento
//	echo "<td>".date_format($fecha_new[$i], 'd/m/Y')."</td>";
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
	if( $d_cartera <= 0 || $arc_cus_no[$i] == 1289 || $arc_cus_no[$i] == 1029 || $arc_cus_no[$i] == 1280 || $arc_cus_no[$i] == 1003 || $arc_cus_no[$i] == 1292 || $arc_cus_no[$i] == 1294 || $arc_cus_no[$i] == 9997 || $arc_cus_no[$i] == 1006 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
	 $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	 $corriente += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//1 a 30
	if( $d_cartera > 0 && $d_cartera < 31 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad1 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//31 a 60
	if( $d_cartera > 30 && $d_cartera < 61 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad2 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//61 a 90
	if( $d_cartera > 60 && $d_cartera < 91 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad3 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
      }
	//91 a 120
	if( $d_cartera > 90 && $d_cartera < 121 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad4 += $aro_amt[$i];
	}
	else{
	//	echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//121 a 150
	if( $d_cartera > 120 && $d_cartera < 151 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad5 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//151 a 180
	if( $d_cartera > 150 && $d_cartera < 181 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad6 += $aro_amt[$i];
	}
	else{
	//	echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//181 a 210
	if( $d_cartera > 180 && $d_cartera < 211 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad7 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//211 a 250
	if( $d_cartera > 210 && $d_cartera < 251 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
		//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad8 += $aro_amt[$i];
	}
	else{
		//echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
	}
	//Más de 250
	if( $d_cartera > 250 && $arc_cus_no[$i] != 1289 && $arc_cus_no[$i] != 1029 && $arc_cus_no[$i] != 1280 && $arc_cus_no[$i] != 1003 && $arc_cus_no[$i] != 1292 && $arc_cus_no[$i] != 1294 && $arc_cus_no[$i] != 9997 && $arc_cus_no[$i] != 1006 )
	{
	//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
		$registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
		$edad9 += $aro_amt[$i];
	}
	else{
	//	echo "<td align='right'>0.00</td>";
		$registro_cxc .= ",0.00";
    }


echo $registro_cxc.",\n";
 }//for

 
	if( !$total_cliente )
		$total_cliente = 0.001;
  echo ",,,,,,".number_format($total_cliente,2,".","").",".number_format($corriente,2,".","").",".number_format($edad1,2,".","").",".number_format($edad2,2,".","").",".number_format($edad3,2,".","").",".number_format($edad4,2,".","").",".number_format($edad5,2,".","").",".number_format($edad6,2,".","").",".number_format($edad7,2,".","").",".number_format($edad8,2,".","").",".number_format($edad9,2,".","").",\n";
  echo ",,,,,,100%,".number_format($corriente/$total_cliente*100,2,".","")."%,".number_format($edad1/$total_cliente*100,2,".","")."%,".number_format($edad2/$total_cliente*100,2,".","")."%,".number_format($edad3/$total_cliente*100,2,".","")."%,".number_format($edad4/$total_cliente*100,2,".","")."%,".number_format($edad5/$total_cliente*100,2,".","")."%,".number_format($edad6/$total_cliente*100,2,".","")."%,".number_format($edad7/$total_cliente*100,2,".","")."%,".number_format($edad8/$total_cliente*100,2,".","")."%,".number_format($edad9/$total_cliente*100,2,".","")."%,\n"; 
 
?>