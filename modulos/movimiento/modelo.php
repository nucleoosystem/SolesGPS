<?php
	class movimiento extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu			=array();
		var $sys_enviroments	="DEVELOPER";
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"company_id"	    =>array(
			    "title"             => "Empresa",
			    "type"              => "input",
			),			
			"trabajador_id"	    =>array(
			    "title"             => "Vendedor",
			    "description"       => "Responsable del dispositivo",
			    "type"              => "autocomplete",
			    "procedure"       	=> "__AUTOCOMPLETE",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "trabajador",
			    "class_field_l"    	=> "nombre",				# Label
			    "class_field_o"    	=> "trabajador_id",
			    "class_field_m"    	=> "id",			    
			),			
			"empresa_id"	=>array(
			    "title"             => "Empresa",
			    "title_filter"      => "Empresa",	
			    "type"              => "autocomplete",
			    "value"             => "",			    
			    "procedure"       	=> "__AUTOCOMPLETE",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "company",
			    "class_field_l"    	=> "nombre",				# Label
			    "class_field_o"    	=> "empresa_id",
			    "class_field_m"    	=> "id",			    
			),			
			/*
			"movimiento_id"	    =>array(
			    "type"              => "autocomplete",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "movimiento",			    
			    "class_field_o"    	=> "movimiento_id",
			    "class_field_m"    	=> "id",				
			),
			#*/
			"movimientos_ids"	    =>array(
			    "type"              => "form",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "movimientos",			    
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "movimiento_id",				
			),
			"subtipo"	    =>array(
			    "title"             => "Tipo",
			    "title_filter"      => "Subtipo",		
			    "type"              => "input",
			),			
			"tipo"	    =>array(
			    "title"             => "Tipo",
			    "title_filter"      => "Tipo",				    
			    "type"              => "hidden",
			),			
			"compra"	    =>array(
			    "title"             => "Lista de compra",
			    "type"              => "hidden",
			),			
			"venta"	    =>array(
			    "title"             => "Lista de venta",
			    "type"              => "hidden",
			),			
			"registro"	    =>array(
			    "title"             => "Registrado",
			    "type"              => "input",
			),			
			"fecha"	    =>array(
			    "title"             => "Fecha",
			    "title_filter"      => "Fecha",
			    "type"              => "datetime",
			),				

			"caducidad"	    =>array(
			    "title"             => "Caducidad",
			    "title_filter"      => "Caducidad",
			    "type"              => "date",
			),
			"folio"	    =>array(
			    "title"             => "Folio",
			    "title_filter"      => "Folio",
			    "type"              => "hidden",
			),	
			"estatus"	    =>array(
			    "title"             => "Activo",
			    "type"              => "checkbox",
			),
			
			"cron_cantidad"	    =>array(
			    "title"             => "Cantidad de Tiempo",
			    "type"              => "input",
			),	
			"cron_unidad"	    =>array(
			    "title"             => "Unidad de tiempo",
			    "type"              => "select",
			    "source"            => array(
				    "DAY"     		=> "Dia",
				    "MONTH"     	=> "Mes",
				    "YEAR"  	   	=> "Ano",
				)
			),	
			"subtotal"	    =>array(
			    "title"             => "Subtotal",
			    "type"              => "input",
			),	
			"total"	    =>array(
			    "title"             => "Total",
			    "type"              => "input",
			),	
			"iva"	    =>array(
			    "title"             => "IVA",
			    "type"              => "input",
			),	
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
        
		public function __CONSTRUCT()
		{	
			parent::__CONSTRUCT();					
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
  			if((!isset($datas["tipo"]) OR $datas["tipo"]=="") AND isset($this->tipo_movimiento) AND $this->tipo_movimiento!="")
    			$datas["tipo"]						=$this->tipo_movimiento;								
    		    		
			if(isset($datas["subtipo"]) AND ($datas["subtipo"]=="SV" OR $datas["subtipo"]=="SC"))	
			{
				$datas["iva"]				=0;				
				$datas["total"]				=$datas["subtotal"];
			}					
			if($this->request["sys_section_". $this->sys_object]=="create")
			{
				$option_folios=array();
				$option_folios["tipo"]			=$datas["tipo"];
				$option_folios["variable"]		=date("Y");
				$datas["folio"]					=$this->__FOLIOS($option_folios);
			}				

			$datas["registro"]				=$this->sys_date;
			if(isset($_SESSION["company"]["id"]))
				$datas["company_id"]		=$_SESSION["company"]["id"];
			if(!isset($datas["trabajador_id"])	OR $datas["trabajador_id"]=="")	
				$datas["trabajador_id"]		=$_SESSION["user"]["trabajador_id"];		

    	    return parent::__SAVE($datas,$option);
		}
		
   		public function __INPUT($words=NULL, $fields=NULL)
    	{
    	    $this->words =parent::__INPUT($words, $fields);    	    
    	    
    	    if(isset($this->tipo_movimiento) AND !in_array($this->tipo_movimiento,array("PV","PC")) )
	    	    $this->__TOTALES($this->obj_movimientos_ids->__VIEW_REPORT);
    	    
    	    return parent::__INPUT($this->words, $this->sys_fields);    	        	    
		}
		
   		public function __TOTALES($option=NULL)
    	{
    		$this->sys_fields["subtotal"]["value"]	=0;
    		$this->sys_fields["iva"]["value"]		=0;
    		$this->sys_fields["total"]["value"]		=0;
    		foreach($option["data"] as $row)
    		{
				$this->sys_fields["subtotal"]["value"]	+=$row["subtotal"];
				$this->sys_fields["iva"]["value"]		+=$row["impuesto"];
    		}
			if(isset($this->sys_fields["subtipo"]["value"]) AND ($this->sys_fields["subtipo"]["value"]=="SV" OR $this->sys_fields["subtipo"]["value"]=="SC"))	
				$this->sys_fields["iva"]["value"]=0;

    		$this->sys_fields["total"]["value"]		=$this->sys_fields["subtotal"]["value"] + $this->sys_fields["iva"]["value"];  			
    		$this->sys_fields["subtotal"]["value"]	=$this->sys_fields["subtotal"]["value"];
		}
   		public function __BROWSE($option="")
    	{			    	
			if($option=="")					$option				=array();			
			if(!isset($option["where"]))	$option["where"]	=array();
			
			if(isset($_SESSION["company"]["id"]))
	    		$option["where"][]			="company_id={$_SESSION["company"]["id"]}";    		
	    		
			if(!isset($this->request["sys_order_". $this->sys_object]))
				$option["order"]="id desc";
	    		
			return parent::__BROWSE($option);
		}							
		
   		public function __BROWSE_KANBAN($option="")
    	{			    	
			if($option=="")					$option				=array();			
			if(!isset($option["where"]))	$option["where"]	=array();
			
			if(!isset($option["select"]))	$option["select"]	=array();

#/*			
			$option["select"][]	="m1.*";
			$option["select"]["CASE WHEN SUM(m1.orden)>0 THEN SUM(m1.orden)	END"]	="orden";
			$option["select"]["CASE WHEN SUM(m1.pago)>0 THEN SUM(m1.pago) END"]		="pago";
			$option["select"]["
				CASE
					#WHEN SUM(m1.pago)-SUM(m1.orden)>0 THEN SUM(m1.pago)-SUM(m1.orden)  				  				 
					WHEN tipo='OV' THEN SUM(m1.pago)-SUM(m1.orden)
					
					
					#WHEN SUM(m1.orden)-SUM(m1.pago)>0 AND tipo='OC' THEN (SUM(m1.pago)*-1)+SUM(m1.orden)
				END				
			"]="deudor"; 
			$option["select"]["				
				CASE 
					WHEN SUM(m1.orden)-SUM(m1.pago)<0 AND tipo='OV' THEN (SUM(m1.orden)*-1)-SUM(m1.pago) 
					WHEN SUM(m1.orden)-SUM(m1.pago)<0 THEN (SUM(m1.orden)*-1)-SUM(m1.pago)
				END				
			"]="acreedor";
			
			$option["select"]["IF(SUM(m1.orden)-SUM(m1.pago)>0, '#ff0000','')"]="color1";
			$option["select"]["IF(SUM(m1.orden)-SUM(m1.pago)<0, '#1bce54','')"]="color2";    
			$option["select"]["IF(SUM(m1.orden)-SUM(m1.pago)=0, '#ccc','')"]="color3";
			
			$option["from"]		="
				(
					SELECT  
						(CASE WHEN tipo IN (\"PV\",\"OC\") then total else 0 end) as PAGO,
						(CASE WHEN tipo IN (\"OV\",\"PC\") then total else 0 end) as ORDEN,		
						m.*
					FROM movimiento m WHERE tipo in (\"PV\", \"OV\",\"PC\", \"OC\")			
				) m1
			";
			#$option["echo"]		="movimiento";
			$option["group"]	="empresa_id";
#*/

/*
			$option["select"]["*"];
			$option["select"]["CASE WHEN tipo IN (\"PV\",\"PC\") then total else 0 end"]="pago";
			$option["select"]["CASE WHEN tipo IN (\"OV\",\"OC\") then total else 0 end"]="orden";
			
			$option["where"][]="tipo in (\"PV\", \"OV\",\"PC\", \"OC\")";
			$option["group"]="empresa_id,tipo";

#*/	    		
			return parent::__BROWSE($option);
		}							
	}
?>
