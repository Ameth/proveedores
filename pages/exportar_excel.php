<?php 
if(isset($_GET['exp'])&&$_GET['exp']!=""&&$_GET['Cons']!=""){
	require("includes/conexion.php");
	
	//Exportar Factura de proveedores
	if($_GET['exp']==1){
		$Cons=base64_decode($_GET['Cons']);
		$SQL=sqlsrv_query($conexion,$Cons);
		$Num=sqlsrv_has_rows($SQL);
		//echo $Cons;
		
		if($SQL){
			require('Classes/PHPExcel.php');
			$objExcel= new PHPExcel();
			$objSheet=$objExcel->setActiveSheetIndex(0);
			$objExcel->
			getProperties()
				->setCreator("AConstruir");
			
			$EstiloTitulo = array(
				'font' => array(
					'bold' => true,
				)
			);
			
			
			//Colocar estilos
			$objExcel->getActiveSheet()->getStyle('A1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('B1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('C1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('D1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('E1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('F1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('G1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('H1')->applyFromArray($EstiloTitulo);
					
			//Ancho automatico
			$objExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			
			//Titulo de la hoja
			$objExcel->getActiveSheet()->setTitle('Factura proveedores');
			
			$objExcel->setActiveSheetIndex(0)
					 ->setCellValue('A1','Numero interno')
					 ->setCellValue('B1','Fecha factura')
					 ->setCellValue('C1','Fecha registro')
					 ->setCellValue('D1','Estado')
					 ->setCellValue('E1','Fecha pago')
				     ->setCellValue('F1','Factura proveedor')
					 ->setCellValue('G1','Proyecto')
				     ->setCellValue('H1','Valor');
			
			$i=2;
			while($registros=sqlsrv_fetch_array($SQL)){
				$dPago=ConsultarPago($registros['DocEntry'], $registros['CardCode']);
				
				$objExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				
				$objSheet->setCellValue('A'.$i,$registros['DocNum']);
				$objSheet->setCellValue('B'.$i,$registros['DocDate']->format('Y-m-d'));
				$objSheet->setCellValue('C'.$i,$registros['CreateDate']->format('Y-m-d'));			
				if($dPago['DocNum']!=""){
					$objSheet->setCellValue('D'.$i,'Pagada');
				}else{
					$objSheet->setCellValue('D'.$i,'Pendiente');
				}
				if($dPago['DocNum']!=""){
					$objSheet->setCellValue('E'.$i,$dPago['FechaPago']->format('Y-m-d'));
				}else{
					$objSheet->setCellValue('E'.$i,'');
				}
				$objSheet->setCellValue('F'.$i,$registros['NumAtCard']);			
				$objSheet->setCellValue('G'.$i,utf8_encode($registros['PrjName']));
				$objSheet->setCellValue('H'.$i,$registros['DocTotal']);
				$i++;
				}
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="FacturasProveedores.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter=PHPExcel_IOFactory::createWriter($objExcel,'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	
	//Exportar Pagos efectuados
	if($_GET['exp']==2){
		$Cons=base64_decode($_GET['Cons']);
		$SQL=sqlsrv_query($conexion,$Cons);
		$Num=sqlsrv_has_rows($SQL);
		//echo $Cons;
		
		if($SQL){
			require('Classes/PHPExcel.php');
			$objExcel= new PHPExcel();
			$objSheet=$objExcel->setActiveSheetIndex(0);
			$objExcel->
			getProperties()
				->setCreator("AConstruir");
			
			$EstiloTitulo = array(
				'font' => array(
					'bold' => true,
				)
			);
			
			
			//Colocar estilos
			$objExcel->getActiveSheet()->getStyle('A1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('B1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('C1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('D1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('E1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('F1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('G1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('H1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('I1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('J1')->applyFromArray($EstiloTitulo);
			$objExcel->getActiveSheet()->getStyle('K1')->applyFromArray($EstiloTitulo);
					
			//Ancho automatico
			$objExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			
			//Titulo de la hoja
			$objExcel->getActiveSheet()->setTitle('Pagos efectuados');
			
			$objExcel->setActiveSheetIndex(0)
					 ->setCellValue('A1','Factura')
					 ->setCellValue('B1','Fecha factura')
					 ->setCellValue('C1','Fecha vencimiento')
					 ->setCellValue('D1','Numero interno')
					 ->setCellValue('E1','Valor factura')
					 ->setCellValue('F1','Valor pagado')
				     ->setCellValue('G1','Fecha pago')
				     ->setCellValue('H1','Efectivo')
					 ->setCellValue('I1','Tranferencia')
					 ->setCellValue('J1','Cheque')
					 ->setCellValue('K1','Num. Cheque');
			
			$i=2;
			while($registros=sqlsrv_fetch_array($SQL)){
				$objExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				
				$objSheet->setCellValue('A'.$i,$registros['FacturaProveedor']);
				if($registros['FechaContFactura']!=""){
					$objSheet->setCellValue('B'.$i,$registros['FechaContFactura']->format('Y-m-d'));
				}else{
					$objSheet->setCellValue('B'.$i,'');
				}
				if($registros['FechaVencFactura']!=""){
					$objSheet->setCellValue('C'.$i,$registros['FechaVencFactura']->format('Y-m-d'));
				}else{
					$objSheet->setCellValue('C'.$i,'');
				}
				$objSheet->setCellValue('D'.$i,$registros['NumPagoEfectuado']);
				$objSheet->setCellValue('E'.$i,$registros['DocTotal']);
				$objSheet->setCellValue('F'.$i,$registros['ValorPago']);
				if($registros['FechaPago']!=""){
					$objSheet->setCellValue('G'.$i,$registros['FechaPago']->format('Y-m-d'));
				}else{
					$objSheet->setCellValue('G'.$i,'');
				}				
				$objSheet->setCellValue('H'.$i,$registros['CashSum']);
				$objSheet->setCellValue('I'.$i,$registros['TrsfrSum']);
				$objSheet->setCellValue('J'.$i,$registros['CheckSum']);
				$objSheet->setCellValue('K'.$i,$registros['CheckNum']);
				$i++;
				}
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="PagosEfectuados.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter=PHPExcel_IOFactory::createWriter($objExcel,'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	
	//Exportar Informe de Ordenes de Compra abiertas
	if($_GET['exp']==3){
		$CardCode=base64_decode($_GET['Cons']);
		$Cons="EXEC usp_InformeOrdenCompraAbiertas '".$CardCode."'";
		$SQL=sqlsrv_query($conexion,$Cons);
		$Num=sqlsrv_has_rows($SQL);
		//echo $Cons;
		
		if($SQL){
			require('Classes/PHPExcel.php');
			$objExcel= new PHPExcel();
			$objSheet=$objExcel->setActiveSheetIndex(0);
			$objExcel->
			getProperties()
				->setCreator("AConstruir");
			
			$EstiloTituloInfo = array(
				'font' => array(
					'bold' => true,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'D9EDF7'))
			);
			$EstiloTituloDanger = array(
				'font' => array(
					'bold' => true,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DEDE'))
			);
			
			$EstiloCeldaInfo = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'D9EDF7'))
			);
			$EstiloCeldaDanger = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DEDE'))
			);
			
			//Colocar estilos
			$objExcel->getActiveSheet()->getStyle('A1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('B1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('C1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('D1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('E1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('F1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('G1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('H1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('I1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('J1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('K1')->applyFromArray($EstiloTituloDanger);
			$objExcel->getActiveSheet()->getStyle('L1')->applyFromArray($EstiloTituloDanger);
			$objExcel->getActiveSheet()->getStyle('M1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('N1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('O1')->applyFromArray($EstiloTituloInfo);
			$objExcel->getActiveSheet()->getStyle('P1')->applyFromArray($EstiloTituloInfo);
						
			//Ancho automatico
			$objExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
			$objExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);		
			
			//Titulo de la hoja
			$objExcel->getActiveSheet()->setTitle('Ordenes abiertas');
			
			$objExcel->setActiveSheetIndex(0)
					 ->setCellValue('A1','Orden de Compra')
					 ->setCellValue('B1','Fecha de OC')
					 ->setCellValue('C1','Usuario de Compras')
					 ->setCellValue('D1','Cod Proveedor')
					 ->setCellValue('E1','Proveedor')
					 ->setCellValue('F1','Total documento')
					 ->setCellValue('G1','CodProyecto')
					 ->setCellValue('H1','Proyecto')
					 ->setCellValue('I1','CodItem')
					 ->setCellValue('J1','Descripcion')
					 ->setCellValue('K1','Cantidad')
					 ->setCellValue('L1','Cantidad faltante')
					 ->setCellValue('M1','Precio')
					 ->setCellValue('N1','Total')
					 ->setCellValue('O1','CodAlmacen')
					 ->setCellValue('P1','NumEntrada');
			$i=2;
			while($registros=sqlsrv_fetch_array($SQL)){
				$objExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('N'.$i)->getNumberFormat()
					->setFormatCode('#,###');
				$objExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($EstiloCeldaDanger);
				$objExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($EstiloCeldaDanger);
				$objExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($EstiloCeldaInfo);
				$objExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($EstiloCeldaInfo);
										
				$objSheet->setCellValue('A'.$i,$registros['OrdenCompra']);
				$objSheet->setCellValue('B'.$i,$registros['FechaOC']->format('Y-m-d'));
				$objSheet->setCellValue('C'.$i,utf8_encode($registros['UsuarioCompras']));
				$objSheet->setCellValue('D'.$i,$registros['CodProveedor']);
				$objSheet->setCellValue('E'.$i,utf8_encode($registros['Proveedor']));
				$objSheet->setCellValue('F'.$i,$registros['TotalDocumento']);
				$objSheet->setCellValue('G'.$i,$registros['CodProyecto']);
				$objSheet->setCellValue('H'.$i,utf8_encode($registros['Proyecto']));
				$objSheet->setCellValue('I'.$i,$registros['CodItem']);
				$objSheet->setCellValue('J'.$i,utf8_encode($registros['Descripcion']));
				$objSheet->setCellValue('K'.$i,$registros['Cantidad']);
				$objSheet->setCellValue('L'.$i,$registros['CantidadFaltante']);
				$objSheet->setCellValue('M'.$i,$registros['Precio']);
				$objSheet->setCellValue('N'.$i,$registros['Total']);
				$objSheet->setCellValue('O'.$i,$registros['CodAlmacen']);
				$objSheet->setCellValue('P'.$i,$registros['NumEntrada']);
				$i++;
				}
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="OrdenesAbiertas_'.date('YmdHis').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter=PHPExcel_IOFactory::createWriter($objExcel,'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	sqlsrv_close ($conexion);
}
?>