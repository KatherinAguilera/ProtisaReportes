<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"clientesactivos.csv\"" );

require("./session/libreriap.php");

/*
function dias_cartera($fecha_i,$fecha_f)
{hhhhh
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
*/

if( isset($_GET['cus_no']) )
{
		
	$link = Fconectar();

	if( $link )
	{
	
		// Se define la consulta que va a ejecutarse, como en sql
		 $sql = 
				"
					SELECT     A.cus_no, A.cus_name, A.slspsn_no, B.slspsn_name AS vendedor, C.slspsn_name AS cobrador, A.ar_terms_cd, 
							   A.last_sale_dt, A.last_sale_amt, A.last_pay_dt, A.last_pay_amt,A.nit, A.cus_type_cd, A.start_dt, A.vend_no
					FROM         ARCUSFIL_SQL AS A INNER JOIN
								 ARSLMFIL_SQL AS B ON A.slspsn_no = B.slspsn_no INNER JOIN
								 ARSLMFIL_SQL AS C ON A.slspsn_no = C.slspsn_no
					WHERE     (A.slspsn_no <> 999) AND (A.slspsn_no <> 132) AND (A.slspsn_no <> 300) AND 
							  (A.slspsn_no <> 108) AND (A.slspsn_no <> 100) AND (A.slspsn_no <> 110) AND 
							  (A.slspsn_no <> 107) AND (A.slspsn_no <> 109) AND (A.slspsn_no <> 106) AND
							  (A.cus_no < 10000) AND (A.curr_cd = 'PES')
					ORDER BY   A.cus_name
				";
		 // Se ejecuta la consulta y se guardan los resultados
		 $results = odbc_exec( $link, $sql ) or die ( "Error en instruccion SQL $orden" );;
		 $existe = odbc_num_rows ( $results );

		 if ( $existe )
		 {
			$i = 0;

			while($registro = odbc_fetch_array($results))
			{
				$arc_cus_no[$i] = $registro['cus_no'];
				$arc_cus_name[$i] = $registro['cus_name'];
				$arc_slspsn_no[$i] = $registro['slspsn_no'];
				$arc_nit[$i] = $registro['nit'];
				$ars_slspsn_name[$i] = $registro['vendedor'];
				$ars_slspsn_collector[$i] = $registro['cobrador'];
				$arc_start_dt[$i] = $registro['start_dt'];
				$arc_last_sale_dt[$i] = $registro['last_sale_dt'];
				$arc_last_sale_amt[$i] = $registro['last_sale_amt'];
				$arc_last_pay_dt[$i] = $registro['last_pay_dt'];
				$arc_last_pay_amt[$i] = $registro['last_pay_amt'];
				$arc_cus_type_cd[$i] = $registro['cus_type_cd'];
				$arc_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				$arc_vend_no[$i] = $registro['vend_no'];
/*
				$date_doc = substr($aro_doc_dt[$i],0,4)."/".substr($aro_doc_dt[$i],4,2)."/".$Fday=substr($aro_doc_dt[$i],6,2);
				
				$fecha_new[$i] = date_create($date_doc);
				$fp .= " days";
				
				date_add($fecha_new[$i], date_interval_create_from_date_string($fp));
				//echo date_format($fecha_new[$i], 'Y/m/d');
*/				
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

echo "COD,NIT,CLIENTE,TIPOCLIENTE,F. CREACION,FP,VENDEDOR,COBRADOR,ZONA,F.ULT.VTA,VLR.ULT.VTA,F.ULT.PAGO,VLR.ULT.PAGO,\n";

for( $i=0; $i<$cont;$i++)
 {
	//Código Hijo
//	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	$registro_cxc = number_format($arc_cus_no[$i],0,'','');	
	//Nit
//	echo "<td>".$arc_nit[$i]."</td>";
    $registro_cxc .= ",".$arc_nit[$i];
	//Nombre del cliente
//	echo "<td>".$arc_cus_name[$i]."</td>";
    $registro_cxc .= ",".$arc_cus_name[$i];
	//T. Cliente
//	echo "<td>".$arc_cus_type_cd[$i]."</td>";
    $registro_cxc .= ",".$arc_cus_type_cd[$i];
	//F. Creación
//	echo "<td>".substr($arc_start_dt[$i],6,2)."/".substr($arc_start_dt[$i],4,2)."/".substr($arc_start_dt[$i],0,4)."</td>";
    $registro_cxc .= ",".substr($arc_start_dt[$i],6,2)."/".substr($arc_start_dt[$i],4,2)."/".substr($arc_start_dt[$i],0,4);

	//Forma de Pago
//	echo "<td>".$arc_ar_terms_cd[$i]."</td>";
    $registro_cxc .= ",".$arc_ar_terms_cd[$i];
	//Vendedor
//	echo "<td>".$ars_slspsn_name[$i]."</td>";
    $registro_cxc .= ",".$ars_slspsn_name[$i];
	//Cobrador
//	echo "<td>".$ars_slspsn_collector[$i]."</td>";
    $registro_cxc .= ",".$ars_slspsn_collector[$i];
	//Zona
//	echo "<td>".$arc_vend_no[$i]."</td>";
    $registro_cxc .= ",".$arc_vend_no[$i];
	//F. Última Venta
//	echo "<td>".substr($arc_last_sale_dt[$i],6,2)."/".substr($arc_last_sale_dt[$i],4,2)."/".substr($arc_last_sale_dt[$i],0,4)."</td>";
    $registro_cxc .= ",".substr($arc_last_sale_dt[$i],6,2)."/".substr($arc_last_sale_dt[$i],4,2)."/".substr($arc_last_sale_dt[$i],0,4);
	//Vlr. Última Venta
//	echo "<td>".number_format($arc_last_sale_amt[$i],0,'',',')."</td>";
    $registro_cxc .= ",".number_format($arc_last_sale_amt[$i],0,'','');	
	//F. Último Pago
//	echo "<td>".substr($arc_last_pay_dt[$i],6,2)."/".substr($arc_last_pay_dt[$i],4,2)."/".substr($arc_last_pay_dt[$i],0,4)."</td>";
    $registro_cxc .= ",".substr($arc_last_pay_dt[$i],6,2)."/".substr($arc_last_pay_dt[$i],4,2)."/".substr($arc_last_pay_dt[$i],0,4);
	//Vlr. Último Pago
//	echo "<td>".number_format($arc_last_pay_amt[$i],0,'',',')."</td>";
    $registro_cxc .= ",".number_format($arc_last_pay_amt[$i],0,'','');	

	echo $registro_cxc.",\n";
 }//for
 //   echo ",".number_format($arc_cus_no,2,".","").",\n";

?>