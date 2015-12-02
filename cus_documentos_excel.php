<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"detallefactura.csv\"" );

require("./session/libreria.php");

function dias_cartera($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}


if( isset($_GET['doc_no']) )
{
	$Doc_no = $_GET['doc_no'];

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

echo "No. DOC,TIPO DOC,DOCAFECTADO,F.DOC,F.VEN,D.MORA,VALOR.DOC,\n";


for( $i=0; $i<$cont;$i++)
 {
	//echo "<tr>";
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

	//echo "<td>".substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],6,2)."</td>";
	//
	//echo "<td>".$aro_doc_no[$i]."</td>";
	$registro_cxc =$aro_doc_no[$i];
	
	if( $aro_doc_type[$i]== 'I' ){

		//echo "FACTURA,\n";
	$registro_cxc .= ",FACTURA";

	}
	//	echo "<td>FACTURA</td>";

	else if( $aro_doc_type[$i]== 'C' )
	{
		$registro_cxc .= ",CREDITO";
	}
	//	echo "<td>N. CRÉDITO</td>";
	else if( $aro_doc_type[$i]== 'D' ){

		$registro_cxc .= ",DEBITO";

	}
	//	echo "<td>N. DÉBITO</td>";
	else if( $aro_doc_type[$i]== 'P' ){
		$registro_cxc .= ",PAGO";
	}
	//	echo "<td>PAGO</td>";
	else{
		
		$registro_cxc .= ",OTRO";

	//echo "FACTURA,\n";
	}
	//
//	echo "<td>".$aro_apply_to_no[$i]."</td>";
	$registro_cxc .= ",".$aro_apply_to_no[$i];
	//
	//echo "<td>".$aro_curr_cd[$i]."</td>";
	//F. documento / F. Vencimiento
//	echo "<td>".substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],6,2)."</td>";
	$registro_cxc .= ",".substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],6,2);
//	echo "<td>".date_format($fecha_new[$i], 'Y/m/d')."</td>";

    $registro_cxc .= ",".date_format($fecha_new[$i], 'd/m/Y');

	//Días de Mora
if($d_cartera > 0 && $aro_doc_type[$i]== 'I' && $total_cliente > 0 )
{
	    $registro_cxc .= ",".$d_cartera;
}
//		echo "<td style='background-color:red;'>".$d_cartera."</td>";
else{

			$registro_cxc .= ",N/A";

//echo "N/A,\n";

}
//		echo "<td>N/A</td>";

 	
	//Saldo	
	//echo "<td align='right'>".number_format($aro_amt[$i],2)."</td>";

     $registro_cxc .= ",".number_format($aro_amt[$i],2,".","");
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
	
	//echo "</tr>";

echo $registro_cxc.",\n";

 }//for

echo ",,,,,,".number_format($total_cliente,2,".","").",\n";

?>