<?php
	#if(file_exists("nucleo/general.php")) require_once("nucleo/general.php");
	
	class files extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_enviroments	="DEVELOPER";
		var $sys_fields		=array(
			"id"			=>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"file"	    	=>array(
			    "title"             => "archivo",
			    "showTitle"         => "si",
			    "type"              => "file",
			    "default"           => "",
			    "value"             => "",			    
			),
			"type"	    	=>array(
			    "title"             => "Tipo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),

			"object"	    =>array(
			    "title"             => "Modulo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),	
			"company_id"	    =>array(
			    "title"             => "Compañia",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"user_id"	    =>array(
			    "title"             => "Usuario",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),						
			"fecha"	    =>array(
			    "title"             => "Fecha",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),						
			"extension"	    =>array(
			    "title"             => "Fecha",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),			
			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################&sys_action=__SAVE
		public function __CONSTRUCT($option=NULL)
		{
			parent::__CONSTRUCT($option);
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{    	   
    		#$this->__PRINT_R($datas); 
    		$option["table"]=$datas;
    	    $return =NULL;
			if(@is_array($datas))
			{							
				if(is_null($option))	$option=array();				

				if(isset($datas["error"]) AND $datas["error"]==0)
				{
					$uploads_dir 			= 'modulos/files/file';
					$datas					=array();
					$tmp_name 				= $datas["tmp_name"];
					$name 					= $datas["name"];
					$type 					= $datas["type"];
					
					$vtype					=explode(".",$name);
					$ctype					=count($vtype) - 1;
					$extension				=$vtype[$ctype];
					
					$datas["file"]			=$name;
					$datas["type"]			=$type;
					$datas["extension"]		=$extension;
					$datas["object"]		=$option["table"];
					$datas["company_id"]	=$_SESSION["company"]["id"];
					$datas["user_id"]		=$_SESSION["user"]["id"];
					$datas["fecha"]			=$this->sys_date;
										
					$return					=parent::__SAVE($datas);

					$path					="$uploads_dir/$return.$extension";

					move_uploaded_file($tmp_name, $path);							
				}
			}	

		    return $return;	
		}		

   		public function __GET_FILE($id=NULL)
    	{    	    
			$return="";
			if(!is_null($id))
			{
				$data=$this->__BROWSE($id);
				
				#$this->__PRINT_R($data);
				if(is_array($data) and count($data)>0)
				{
					if(array_key_exists("type",$data[0]))
					{
						if($data[0]["type"]=="image/png")		$return="<img src=\"../modulos/files/file/$id.png\">";
						if($data[0]["type"]=="image/jpg")		$return="<img src=\"../modulos/files/file/$id.jpg\">";
					}		
				}				
			}					
		    return $return;	
		}		
	}
?>
