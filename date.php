<html>
<head>
	<title>Consulta de Cuentas x Cobrar por Vendedor</title>
	<link href="./css/principal.css" type="text/css" rel="stylesheet">
	<script languaje="JavaScript1.2" type="text/javascript">


		function validar( )
		{
			if( (document.getElementById('cven_1').value == "" && document.getElementById('cven_2').value == "" ) )
			{
				alert("Debe ingrear un número de Vendedor Válido!");
				foco(); return 0;
			}
			else if( document.getElementById('cven_1').value != "" && isNaN( eval("document.getElementById('cven_1').value") ) )
			{
				alert("El código del Vendedor debe ser un valor numérico!");
				foco(); return 0;
			}
			else if( document.getElementById('cven_2').value != "" && isNaN( eval("document.getElementById('cven_2').value") ) )
			{
				alert("El código del Vendedor debe ser un valor numérico!");
				foco(); return 0;
			}
			else if( document.getElementById('cven_1').value != "" && !isNaN( eval("document.getElementById('cven_1').value") ) )
			{
				consulta['0'].submit();
			}
			else if( document.getElementById('cven_2').value != "" && !isNaN( eval("document.getElementById('cven_2').value") ) )
			{
				consulta['1'].submit();
			}
		}
		function foco( )
		{
 			document.getElementById('cven_1').focus();
			return 0;
		}

	</script>		
</head>

<body bgcolor="#FFFFFF" text="#333334" link="#0000FF" topmargin="0" rightmargin="0" onLoad="foco()">
<?
require("./session/libreria.php");

function dias_cartera($fecha_i,$fecha_f)
{
	
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}


	$link = Fconectar();

	if( $link )
	{

	 $sql2 = 
			"
				SELECT
					AROPNFIL.doc_dt, AROPNFIL.doc_due_dt, ARSLMFIL.slspsn_name
				FROM
					AROPNFIL_SQL AROPNFIL,
					ARSLMFIL_SQL ARSLMFIL
				WHERE
					AROPNFIL.apply_to_no = 190538 AND
					AROPNFIL.doc_type = 'I' AND
					AROPNFIL.slspsn_no = ARSLMFIL.slspsn_no
			";
				 // Se ejecuta la consulta y se guardan los resultados
				 $results2 = odbc_exec( $link, $sql2 ) or die ( "Error en instruccion SQL $orden" );;
				 $existe2 = odbc_num_rows ( $results2 );

				 if ( $existe2 )
				{
					$registro2 = odbc_fetch_array($results2);
					$aro_doc_dt[$i] = $registro2['doc_dt'];
					$aro_doc_due_dt[$i] = $registro2['doc_due_dt'];
					//$ars_slspsn_name[$i] = $registro2['slspsn_name'];
				}
				
				$date_doc = substr($aro_doc_dt[$i],0,4)."-".substr($aro_doc_dt[$i],4,2)."-".substr($aro_doc_dt[$i],6,2);
				$date_doc2 = substr($aro_doc_due_dt[$i],0,4)."-".substr($aro_doc_due_dt[$i],4,2)."-".substr($aro_doc_due_dt[$i],6,2);
				$interval = dias_cartera($date_doc,date("Y-m-d"));
								
				echo "<br>(".$date_doc.") - (".date("Y-m-d").") = ".$interval."<br>";
				echo "Vencimiento: ".$date_doc2;

				//date_add($fecha_new[$i], date_interval_create_from_date_string($fp));
				//echo date_format($fecha_new[$i], 'Y/m/d');				
				$i++;
	
			$cont=$i;
	
	}//if( $link > 0 )
	else
	{
		Ferror("No se pudo establecer conexion con la Base de Datos!");
	}

 // Se cierra la conexión
 odbc_close( $link );
?>
</body>
</html>


