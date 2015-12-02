<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"carteracliente.csv\"" );


require("./session/libreria.php");

if( isset($_GET['cus_no']) )
{
	$Customer_no = $_GET['cus_no'];

	$link = Fconectar();

	if( $link )
	{
		//echo "ok";
		// Consulta sql
		 $sql = 
				"
					SELECT
						ARCUSFIL.par_cus_no, ARCUSFIL.cus_no, ARCUSFIL.cus_name, AROPNFIL.doc_no, AROPNFIL.apply_to_no, AROPNFIL.doc_type, AROPNFIL.doc_dt,
						SUM(AROPNFIL.amt_1 + AROPNFIL.amt_2) VALOR
					FROM
						ARCUSFIL_SQL ARCUSFIL,
						AROPNFIL_SQL AROPNFIL
					WHERE
						ARCUSFIL.cus_no = AROPNFIL.cus_no AND
						ARCUSFIL.par_cus_no = $Customer_no
					GROUP BY
						ARCUSFIL.par_cus_no, ARCUSFIL.cus_no, ARCUSFIL.cus_name, AROPNFIL.doc_no, AROPNFIL.apply_to_no, AROPNFIL.doc_type, AROPNFIL.doc_dt
					UNION
					SELECT
						ARCUSFIL.par_cus_no, ARCUSFIL.cus_no, ARCUSFIL.cus_name, AROPNFIL.doc_no, AROPNFIL.apply_to_no, AROPNFIL.doc_type, AROPNFIL.doc_dt, 
						SUM(AROPNFIL.amt_1 + AROPNFIL.amt_2) VALOR2
					FROM
						ARCUSFIL_SQL ARCUSFIL,
						AROPNFIL_SQL AROPNFIL
					WHERE
						ARCUSFIL.cus_no = AROPNFIL.cus_no AND
						ARCUSFIL.cus_no = $Customer_no
					GROUP BY
						ARCUSFIL.par_cus_no, ARCUSFIL.cus_no, ARCUSFIL.cus_name, AROPNFIL.doc_no, AROPNFIL.apply_to_no, AROPNFIL.doc_type, AROPNFIL.doc_dt
					ORDER BY
						AROPNFIL.apply_to_no, AROPNFIL.doc_dt ASC
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
				//$arc_slspsn_no[$i] = $registro['slspsn_no'];
				//$aro_cus_no[$i] = $registro['cus_no2'];
				$aro_doc_dt[$i] = $registro['doc_dt'];
				$aro_doc_no[$i] = $registro['doc_no'];
				$aro_doc_type[$i] = $registro['doc_type'];
				$aro_apply_to_no[$i] = $registro['apply_to_no'];
				//$aro_curr_cd[$i] = $registro['curr_cd'];
				//$aro_doc_due_dt[$i] = $registro['doc_due_dt'];
				$aro_amt[$i] = $registro['VALOR'] + $registro['VALOR2'];
				//$aro_ar_terms_cd[$i] = $registro['ar_terms_cd'];
				//$aro_slspsn_no[$i] = $registro['slspsn_no2'];
				//$aro_curr_trx_rt[$i] = $registro['curr_trx_rt'];
				//$ars_slspsn_name[$i] = $registro['slspsn_name'];
				$total_cliente += $aro_amt[$i]; 

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

echo "CODHIJO,TIPODOC,NODOC,FECHA,VALORDOC,\n";

$doc_sub = -1;
$tot_doc = 0;
$flag = 0;

for( $i=0; $i<$cont;$i++)
 {
	if( $doc_sub == -1 || $doc_sub == $aro_apply_to_no[$i] )
	{
		$flag = 0;
		$tot_doc += $aro_amt[$i];
	}
	else
		$flag = 1;
		
	$doc_sub = $aro_apply_to_no[$i];

if( $flag )
{
	//echo 
	//"<tr>
	
		//<td colspan='4' align='right'> <b>Saldo Documento : </b></td>
	//	<td align='right'><b>".number_format($tot_doc,2)."</b></td>
//	$registro_cxc .= ",".number_format($tot_doc[$i],2,".","");	
//	</tr>";
//	$tot_doc = $aro_amt[$i];
	echo ",,,,".number_format($tot_doc,2,".","").",\n";
//	 $registro_cxc .= ",".$aro_amt[$i];
}
	//Código Padre
	//echo "<td>".$arc_par_cus_no[$i]."</td>";
	//Código Hijo
    $registro_cxc = number_format($arc_cus_no[$i],0,'','');	
//	echo "<td>".number_format($arc_cus_no[$i],0,'','')."</td>";
	//Nombre del cliente
	//echo "<td>".$arc_cus_name[$i]."</td>";
	//Código Vendedor
//	echo "<td>".$arc_slspsn_no[$i]."</td>";
/*****************************  FIN ARCUSFIL  ****************************/

/*****************************  INICIO AROPNFIL  ****************************/
	//Cód. Cliente
//	echo "<td>".$aro_cus_no[$i]."</td>";
	//Documentos todos
//	echo "<td>".$aro_doc_no[$i]."</td>";
	//Tipo doc
	if( $aro_doc_type[$i]== 'I' )
	{
		//echo "<td>FACTURA</td>";
		$registro_cxc .= ",FACTURA";
	}

	else if( $aro_doc_type[$i]== 'C' ){
		//echo "<td>N. CRÉDITO</td>";
		$registro_cxc .= ",CREDITO";
	}
	

	else if( $aro_doc_type[$i]== 'D' ){
	//	echo "<td>N. DÉBITO</td>";
      $registro_cxc .= ",DEBITO";
	}

	else if( $aro_doc_type[$i]== 'P' ){
		//echo "<td>PAGO</td>";
	$registro_cxc .= ",PAGO";
    }

	else {
		//echo "<td>Otro</td>";
	$registro_cxc .= ",OTRO";
    }
	
	//Documentos todos
	//echo "<td>".$aro_doc_no[$i]."</td>";
	$registro_cxc .= ",".$aro_doc_no[$i];

	//Factura
	//echo "<td>".$aro_apply_to_no[$i]."</td>";
	//Fecha documento
	
	//echo "<td>".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4)."</td>";
	$registro_cxc .= ",".substr($aro_doc_dt[$i],6,2)."/".substr($aro_doc_dt[$i],4,2)."/".substr($aro_doc_dt[$i],0,4);

	//Moneda
//	echo "<td>".$aro_curr_cd[$i]."</td>";
	//Fecha Vencimiento
//	echo "<td>".$aro_doc_due_dt[$i]."</td>";
	//Valor Factura
    $registro_cxc .= ",".$aro_amt[$i];

	//echo "<td align='right'>".number_format($aro_amt[$i])."</td>";
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
echo ",,,,".number_format($total_cliente,2,".","").",\n";
?>