<?php
	#if(file_exists("nucleo/general.php")) require_once("nucleo/general.php");
	
	class device extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
				"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),		
			"name"	    	=>array(
			    "title"             => "Numero Economico",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"bastidor"	    	=>array(
			    "title"             => "Bastidor",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),

			"uniqueId"	    =>array(
			    "title"             => "Imei",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),	
			"status"	    =>array(
			    "title"             => "Estatus",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"dataId"	    =>array(
			    "title"             => "Clave Datos",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),						
			"positionId"	    =>array(
			    "title"             => "Posicion Actual",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),						
			"transmision"	    =>array(
			    "title"             => "Transmision",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",
			    "source"			=>array(
			    	"Automatica"	=>	"Automatica",
			    	"Estandar"		=>	"Estandar",
			    ),	
			    
			),
			"tipoCombustible"   =>array(
			    "title"             => "Tipo de Combustible",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"emisionesCO2"      =>array(
			    "title"             => "Emisiones CO2",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"caballosPotencia"   =>array(
			    "title"             => "Caballos de Potencia",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"fechaAdquisicion"   =>array(
			    "title"             => "Fecha de Adquisicion",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",
			),
			"valorCoche"   =>array(
			    "title"             => "Costo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"numAsientos"   =>array(
			    "title"             => "Numero de Asientos",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"numPuertas"   =>array(
			    "title"             => "Numero de Puertas",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"color"   =>array(
			    "title"             => "Color",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"image"   =>array(
			    "title"             => "Imagen",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",
			    "source"			=>array(
			    	"01"	=>	"Carro Gris",
			    	"02"	=>	"Carro Rojo",
			    	"03"	=>	"Camioneta Gris",
			    	"90"	=>	"Celular Negro",
			    	"91"	=>	"Celular Azul",
			    	"92"	=>	"Celular Verde",
			    	"93"	=>	"Celular Rojo",			    	
			    )
			),			
			"telefono"   =>array(
			    "title"             => "Telefono",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"file_id"	    =>array(
			    "title"             => "Imagen",
			    "showTitle"         => "no",
			    "type"              => "file",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"company_id"	    =>array(
			    "title"             => "Compania",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "company",
			    "class_path"        => "modulos/company/modelo.php",
			    "class_field_o"    	=> "company_id",
			    "class_field_m"    	=> "id",
			    			    
			),									
			"responsable_id"	    =>array(
			    "title"             => "Externo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"responsable_fisico_id"	=>array(
			    "title"             => "Supervisor",
			    "description"       => "Encargado de supervisar distintos dispositivos",
			    "showTitle"         => "si",
			    "type"              => "autocomplete",
			    "source"           	=> "../modulos/user/ajax/index.php",
			    "value"             => "",			    
			    
			    "relation"          => "one2many",			    
			    "class_name"       	=> "user",
			    #"class_path"        => "modulos/user/modelo.php",
			    "class_field_l"    	=> "name",				# Label
			    "class_field_o"    	=> "responsable_fisico_id",
			    "class_field_m"    	=> "id",
			    
			),			
			"placas"	    		=>array(
			    "title"             => "Placas",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################&sys_action=__SAVE


		public function __CONSTRUCT()
		{
			
			$this->files_obj	=new files();	
			parent::__CONSTRUCT();
		}
				

   		public function __SAVE($datas=NULL,$option=NULL)
    	{    	    
    	    $datas["company_id"]		=$_SESSION["company"]["id"];

    	    $files_id					=$this->files_obj->__SAVE();    	    
    	    if(!is_null($files_id))		$datas["files_id"]			=$files_id;    	    

    		parent::__SAVE($datas,$option);
		}		
		public function devices_time()

    	{
      		if(is_null($option))			$option				=array();
    		if(is_null($option["select"]))	$option["select"]	=array();
    		    		
			$option["select"]["d.name"]			="ECONOMICO";
			$option["select"]["c.rasonSocial"]	="EMPRESA";
			$option["select"]["d.placas"]		="PLACAS";
			$option["select"]["SEC_TO_TIME(TIMESTAMPDIFF(SECOND, d.lastUpdate, now()))"]		="REPORTO HACE";
			$option["select"]["lastUpdate"]		="ULTIMO REPORTE";
			
			$option["from"]						="device d LEFT JOIN company c ON d.company_id = c.id";
			
			$option["where"][]					="dev.company_id NOT IN (1)";
			$option["where"][]					="SEC_TO_TIME(TIMESTAMPDIFF(SECOND, d.lastUpdate, now()))>'00:10:00'";
						
			$data = $this->__VIEW_REPORT($option);

			$para      = 'evigra@hotmail.com';
			$titulo    = 'SOLESGPS POSITIONS';
			$mensaje   = $data;
			$cabeceras = 'From: webmaster@example.com' . "\r\n" .
				'Reply-To: webmaster@example.com' . "\r\n" .
				'X-Mailer: PHP/';
			mail($para, $titulo, $mensaje, $cabeceras);			

    	}		
		public function devices($option=NULL)
    	{
    		if(is_null($option))	$option=array();

			#$option["echo"]="DEVICES :: modelo";    		
			$option["total"]	=1;
			$option["select"]   =array(
					"distinct(d.id)"																							=>"d_id",
					"d.*",
					"IF(image!=0,CONCAT('../sitio_web/img/car/vehiculo_',image,'/i225.png'),'../modulos/device/img/cell.png')"	=>"file_id",
					"IF(vehicle=1,'../modulos/device/img/car.png','../modulos/device/img/cell.png')"							=>"file_id1",
			);
			$option["from"]     ="device d, user_group ug, groups g";
			
			if(!isset($option["where"]))    $option["where"]    =array();
			
			$option["where"][]      ="d.company_id={$_SESSION["company"]["id"]}";
			$option["where"][]      ="ug.menu_id=2";
			$option["where"][]      ="
				(		
					(
						responsable_fisico_id={$_SESSION["user"]["id"]}		
						AND user_id=responsable_fisico_id
						AND ug.active=g.id
					)        
					OR					
					(
						ug.user_id={$_SESSION["user"]["id"]}		
						AND ug.active=g.id
						AND g.nivel<=20
					)
				)			
			";		
			$return =$this->__VIEW_REPORT($option);
			
			#$this->__PRINT_R($return);
			
			return	$return; 
    	
		}		
		
	}
?>
