<?php
	require_once("../../nucleo/sesion.php");
	
	$class_name										=@$_REQUEST["class_name"];		
	$class_field_l									=@$_REQUEST["class_field_l"];	
	$class_field_m									=@$_REQUEST["class_field_m"];		
	
	if(isset($_REQUEST["procedure"]))
		$procedure										=@$_REQUEST["procedure"];

	$eval="

		$"."option"."_obj_$campo	=array(
			\"memory_n\"		=>3,
			\"class_one\"		=>\"{$this->sys_name}\",
		);													
		$"."objeto   	=new {$class_name}($"."option"."_obj_$campo);
	";		
	if(isset($procedure))
	{
		$datas										=array();
		$eval.="
			$"."datas		=$"."objeto->{$procedure}();
		";		
		eval($eval);
		$datas			=$datas["data"];
		
		foreach($datas as $index => $data)
		{
			$datas[$index]["label"]			=$data[$class_field_l];
			$datas[$index]["clave"]			=$data[$class_field_m];
		}
		/*
		$datas[]=array(
			"label"		=>"Crear registro",
			"clave"		=>"create"
		);
		*/
		echo json_encode($datas);
	}
	else
	{
		$eval.="
			$"."objeto->words				=$"."objeto->__INPUT(array(),$"."objeto->sys_fields);
			$"."view_auto_create  			=$"."objeto->__VIEW_CREATE($"."objeto->sys_module . \"html/create\");	
			#$"."objeto->__PRINT_R($"."view_auto_create);		
			echo $"."objeto->__REPLACE($"."view_auto_create,$"."objeto->words);
		";		
		eval($eval);
	}
?>
