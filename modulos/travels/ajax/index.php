<?php
	require_once("../../../nucleo/sesion.php");	
	$option				=array();	

	$item				=new items($option);	

	
	$objeto				=new travels($option);	
	$datas				=$objeto->__VIAJE_HOY();
	
	foreach($datas["data"] as $OV)
	{
		foreach($OV["movimientos_ids"] as $travels)
		{
			$objeto->__PRINT_R($item->__BROWSE($travels["item_id"]);
			
	
	
	
	
		
		}			
	}	
?>
