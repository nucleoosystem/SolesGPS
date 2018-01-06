<?php
	
	class basededatos 
	{    
		var $OPHP_database=array(
			"user"		=>"admin_evigra",
			"pass"		=>"EvG30JiC06",
			#"name"		=>"admin_soles",			
			"name"		=>"admin_soles37",
			"host"		=>"solesgps.com",
			#"host"		=>"localhost",
			"type"		=>"mysql",
		);
		#*/
		public function __CONSTRUCT()
		{  
			
	    }				
		function abrir_conexion()
		{
			if($this->OPHP_database["type"]=="mysql")	        	
			{			
				$this->OPHP_conexion = @mysqli_connect("localhost", $this->OPHP_database["user"], $this->OPHP_database["pass"], $this->OPHP_database["name"]) OR $this->reconexion();
			}
		}

		function reconexion()
		{
			if($this->OPHP_database["type"]=="mysql")	        	
			{
				$this->OPHP_conexion = @mysqli_connect("solesgps.com", $this->OPHP_database["user"], $this->OPHP_database["pass"], $this->OPHP_database["name"]);
			}
		}
		
		function cerrar_conexion()
		{
		    $this->OPHP_conexion->close();
		}	
		
		
		///////////////////////////////////////////////////////////
		public function __FILE_JS($data)
		{
		    $return="";  
            foreach($data as $valor)
    		{    		    													   
    		    #if($valor=="maps")                  $file="http://maps.google.com/maps/api/js";
    		    if($valor=="maps")                  $file="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTDTeSJ3Uu3hHCy73RzGoJbx6vmKcmmUI";
    		    else if($valor=="responsivevoice")  $file="https://code.responsivevoice.org/responsivevoice.js";
    		    else                                $file="$valor.js";
    		        		        		    
    		    $return.="<script src=\"$file\"></script>";    		        		    
    		        		    
    		    if($valor=="maps")	$return.="
    		    	<script src=\"../sitio_web/js/maplabel-compiled.js\"></script>
    		    ";    		    
			}		
			return $return;
    	} 
    	public function __HTML_USER()
    	{
    	    $return="";
    	    $img=@$_SESSION["user"]["img_files_id_min"];
    	    $return="    	            	        
    	        <img src=\"../sitio_web/img/settings.png\" height=\"20\">
    	        <font id=\"setting\" title=\"Ajustes\">
    	            {$img}
    	        </font>
    	    ";
    	    return $return;
    	}
    	
		public function __FILE_CSS($data)
		{
		    $return="";  
            foreach($data as $valor)
    		{    		
    		    $file="$valor.css";
    		    $return.="<link rel=\"stylesheet\" type=\"text/css\" href=\"$file\">";    		    
			}		
			return $return;
    	}     	     	  
		public function __PRINT_R($variable)
		{  
		    echo "<div class=\"echo\" title=\"Sistema\"><pre>";
		    @print_r(@$variable);
		    echo "</pre></div>";			
    	} 
		public function __PRINT_HTML($variable)
		{  
			if(is_array($variable))
			{
				$return="";
				foreach($variable as $row)
				{
					if(is_array($row))	$return.="<tr>".$this->__PRINT_HTML($row). "</tr>";
					else				$return.=$this->__PRINT_HTML($row);	
				}
				return $return;
			}
			else
			{
				return "<td>".$variable."</td>";
			}
    	}     	   	
		public function __JS($variable)
		{  
		    echo "
		        <script>
		            $variable
		        </script>    
		    ";
    	}    	
		public function __BUTTON($datas=NULL)
		{  
			$return="";
			if(is_array($datas))
			{
			    foreach($datas as $data)
			    {
			    	$icon="";
			    	$action=0;
			        foreach($data as $etiqueta =>$titulo)
			        {					       
			        	if($etiqueta=="icon") 	
			        	{
			        		$icon="$titulo";
			        	}		
			        	elseif($etiqueta=="text") 	
			        	{
			        		$text="$titulo";
			        	}		    	
			        	else
			        	{
			        		if(@$icon=="")
			        		{
			        			if($etiqueta=="create") 	$icon="ui-icon-document";
			        			if($etiqueta=="write") 		$icon="ui-icon-pencil";
			        			if($etiqueta=="report") 	$icon="ui-icon-note";			        		
			        			if($etiqueta=="kanban") 	$icon="ui-icon-newwin";			        		
			        			if($etiqueta=="action") 	$icon="ui-icon-document";
			        			if($etiqueta=="cancel") 	$icon="ui-icon-close";

								$script_id="";			

			        						        			
			        			if(in_array($etiqueta,array("create","write","report","kanban")))	
			        			{
			        				$text="false";
			        				$action="1";
			        				$script_id="$(\"#sys_id_{$this->sys_object}\").val(\"\");";      			
			        			}
			        			else
			        			{
					    			if(in_array($etiqueta,array("action")))	
					    			{
					    				$action="1";
									}			        				
			        				$text="true";			        			
			        			}
			        		}
			        		if(@$action=="1")	$font_id="$etiqueta"."_{$this->sys_object}";
			        		else				$font_id="$etiqueta";
			        		
			        		$value="$etiqueta";
							if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n) AND isset($this->sys_view_l18n["$etiqueta"]))	
							{			        	
								$titulo		=$this->sys_view_l18n["$etiqueta"];
							}			        	
							
			        	}
			        }	
			        if($value=="action")    $sys_input="$(\"#sys_action_{$this->sys_object}\").val(\"__SAVE\");";
			        else					
			        {
			        	$sys_input="
			        		$(\"#sys_section_{$this->sys_object}\").val(\"$value\");
			        		$(\"#sys_id_{$this->sys_object}\").val(\"\");
			        		$(\"input.{$this->sys_object}\").val(\"\");
			        	";
			        }
		        	$script="
							$(\"#$font_id\").button({
								icons: {	primary: \"$icon\" },
								text: $text
							});
					";
					if(@$action=="1")
					{				
						$script.="
							$(\"#$font_id\").click(function(){
									$sys_input
									
									$(\"form\").submit();																										
								}
							);		        	
			        	";
		        	}		        	
			        $return .="
			        	<font id=\"$font_id\">$titulo</font>
			        	<script>
			        		$script
			        	</script>
			        ";
			        
			    }
			}    
			return $return;
		} 			
		public function __CHECK($datas=NULL, $name=NULL)
		{  
			$return="";
			if(is_array($datas))
			{
			    foreach($datas as $data)
			    {			    
			        $return .="
			        	<input id=\"{$data["id"]}\" type=\"checkbox\">		<label for=\"{$data["id"]}\">{$data["title"]}</label>				        	
			        ";
			    }
		        $return ="
					<div id=\"$name\">
					$return
					</div>
					<script>
						$(\"div#$name\").buttonset();
					</script>		        	
		        ";			    
			}    
			return $return;
		} 			
    	##############################################################################    
		public function __JSON_AUTOCOMPLETE($valor)
		{		
        	$vauxpath						=explode("/",$_SERVER["PHP_SELF"]);
        	$vauxpath[count($vauxpath)-1]	="";
        	$auxpath						="http://".$_SERVER["SERVER_NAME"].implode("/",$vauxpath).substr($valor["source"],3,strlen($valor["source"])-3);
        	
        	return	@json_decode(@file_get_contents($auxpath."?id=".$valor["value"]));
		}		
		##############################################################################
		public function menu_vehicle()
    	{
    		if(isset($_SESSION["company"]["id"]))	
    		{
				$option["select"]   =array( "d.*" );
				$option["from"]		="devices d join positions p on p.deviceId=d.id";			
				$option["where"]	=array(
				    "d.company_id={$_SESSION["company"]["id"]}"
				);
				$option["group"]	="deviceId";
				
				$vehicles            =$this->__VIEW_REPORT($option);
				
				$html="";
				
		
				$comando_sql        ="
					select
						distinct(d.id) as d_id, 
						d.*
					from 	
						devices d,
						user_group ug,
						groups g
					where 	d.company_id={$_SESSION["company"]["id"]}
						AND ug.menu_id=2
						
						AND(		
							(
								responsable_fisico_id={$_SESSION["user"]["id"]}		
								AND user_id=responsable_fisico_id
								AND ug.active=g.id
							)        
							OR
							(
								ug.user_id={$_SESSION["user"]["id"]}		
								AND ug.active=g.id
								AND g.nivel<40
							)
						) 			
	
				";	
				$option_conf=array();
	

				$option_conf["open"]	=1;
				$option_conf["close"]	=1;			
				$data =$this->__EXECUTE($comando_sql,$option_conf);	
				
				foreach($data as $vehicle)
				{
					if($vehicle["image"]=="")	$vehicle["image"]="01";
				
			    	$html.="
				        <table class=\"select_devices\" device=\"{$vehicle["id"]}\" lat=\"\" lon=\"\" width=\"100%\" height=\"40\" border=\"0\">
			        		<tr>
				        		<td rowspan=\"2\"  width=\"50\" align=\"center\">
			        				<img height=\"25\" src=\"../sitio_web/img/car/vehiculo_{$vehicle["image"]}/i135.png\">
			        			</td>
			        			<td valign=\"bottom\">{$vehicle["name"]}</td>
			        			<td width=\"25\" rowspan=\"2\" class=\"event_device\"> - </td>
			        		</tr>
			        		<tr>
			        			<td  valign=\"top\"><b>{$vehicle["placas"]}</b></td>
			        			
			        		</tr>		        	
			        	</table>
			    	";			
				}
		    	$html="
			    	<font style=\"padding-left:5px; color:SteelBlue; font-size:13; font-weight:bold;\"> Dispositivos </font>
		        	<table  width=\"100%\" height=\"30\" border=\"0\">
			        	<tr>
		        			<td width=\"60\" align=\"center\" class=\"select_devices\" device=\"-1\">
			        			<img src=\"../sitio_web/img/eyes.png\">
		        			</td>
		        			<td valign=\"center\" style=\"padding-left:30px;\" class=\"select_devices\" device=\"0\"><b>VER TODOS</b></td>
		        		</tr>			        	
		        	</table>		    
		        	<!-- BASE DE DATOS
		        	<div id=\"devices_all\" style=\"overflow:auto; height:30px;\"> 
		        	-->
		        	<div id=\"devices_all\" style=\"overflow:auto; height:30px;\">
			        	$html
		    		</div>
		    	";			
		    }
		    else	
			{
				$html="";
			}
			return $html;

		}					
	}
?>

