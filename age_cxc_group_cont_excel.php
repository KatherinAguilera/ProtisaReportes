<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"carteracontinental.csv\"" );

require("./session/libreria.php");


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
		Ferror("No se pudo establecer coneccion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );

}//if isset...


echo "COD,CLIENTE,NIT,SALDO,CUPOCOP,CUPOUSD,CALIF,\n";

for( $i=0; $i<$cont;$i++)
 {
//	echo "<tr>";

	//Código
//	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
    $registro_cxc = number_format($arc_cus_no[$i],0,'','');	
	//Nombre del cliente
//	echo "<td><a class='customer_link' href='./age_cxc_cus.php?cus_no=".$arc_cus_no[$i]."'>".$arc_cus_name[$i]."</a></td>";
     $registro_cxc .= ",".$arc_cus_name[$i];
	//Nit
//	echo "<td>".number_format($arc_cus_nit[$i],0,'','')."</td>";
     $registro_cxc .= ",".number_format($arc_cus_nit[$i],0,'','');	

//	echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";
    $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
	//Cupo Drypers
//	echo "<td align='right'>".number_format($arc_cr_dry[$i],2)."</td>";
      $lineac += $arc_cr_dry[$i];
     $registro_cxc .= ",".number_format($arc_cr_dry[$i],2,".","");

	//Cupo Continental (USD)
//	echo "<td align='right'>".number_format($arc_cr_usd[$i],2)."</td>";
     $seguro += $arc_cr_usd[$i];
     $registro_cxc .= ",".number_format($arc_cr_usd[$i],2,".","");
	//Calificación de riesgo
//	echo "<td align='right'>".$arc_cr_risk[$i]."</td>";	
     $registro_cxc .= ",".$arc_cr_risk[$i];
	

  echo $registro_cxc.",\n";

 }//for

 if( !$total_cliente )
		$total_cliente = 0.001;
	echo ",,,".number_format($total_cliente,2,".","").",".number_format($lineac,2,".","").",".number_format($seguro,2,".","").",\n";
	?>

