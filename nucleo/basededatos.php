<?php
	
	class basededatos 
	{    
		protected  $OPHP_database=array(
			"user"		=>"admin_evigra",
			"pass"		=>"EvG30JiC06",
			#"name"		=>"admin_server",			
			"name"		=>"admin_server",
			"host"		=>"solesgps.com",
			#"host"		=>"localhost",
			"type"		=>"mysql",
		);
		#*/
		public function __CONSTRUCT()
		{  
			
	    }				
		public function __NIVEL_SESION($nivel)
		{  
			$return=false;
			
			$menu_activo=@$_SESSION["sys"]["menu"];
			
			if(is_array(@$_SESSION["group"]))
			{	
				foreach(@$_SESSION["group"] as $datos)
				{
					#if($datos["menu_id"]==$menu_activo AND $datos["nivel"]<=$nivel) 
					#	$return=true;
			
					$eval="
						if($"."datos[\"menu_id\"]==$"."menu_activo AND $"."datos[\"nivel\"]$nivel) 
							$"."return=true;				
					";
					eval($eval);
				}		
			}		
			return $return;
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
    		#$this->__PRINT_R($_SESSION);
    	    $return="";
    	    #$img=@$_SESSION["user"]["img_files_id_min"];
    	    $img=@$_SESSION["user"]["img_files_id_sup_chi"];
    	    $return="    
    	    	<!--	            	        
    	        <img src=\"../sitio_web/img/settings.png\" height=\"20\">
    	        -->
    	        <font id=\"setting\" title=\"Ajustes\">
    	            {$img}
    	        </font>
    	    ";


    	    return  $return;
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
		    echo "<div class=\"developer\" title=\"Sistema :: {$this->sys_object} {$this->sys_name}\"><pre>";
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
		    echo $this->__JS_SET($variable);
    	}    	
		public function __JS_SET($variable)
		{  
		    return "
		        <script>
		            $variable
		        </script>    
		    ";
    	}    	
		public function __JS_SET_INPUT($datas)
		{
			$return="";
			if(is_array($datas))
			{				
			    foreach($datas as $field =>$value)
			    {
			    	$return.="
			    		set_var(\"{$field}\", \"$value\");";			 		
				}			  
			}
			return $return;
    	}    	
    	
		public function __BUTTON($datas=NULL)
		{  
			$return="";
			if(is_array($datas))
			{
				
			    foreach($datas as $data)
			    {
			    	$icon="";
					$title="";
			    	$action=0;
			    	$titulo="";
					$sys_input="";
			        foreach($data as $etiqueta =>$valor)
			        {					       
			        	if($etiqueta=="icon") 	
			        	{
			        		$icon="$valor";
			        	}		
			        	elseif($etiqueta=="text") 	
			        	{
			        		$titulo="$valor";
			        		$text="$valor";
			        	}		    	
			        	elseif($etiqueta=="title") 	
			        	{
			        		$title="$valor";		        		
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
			        			
			        			if($etiqueta=="import") 	$icon="ui-icon ui-icon-arrowthickstop-1-s";
			        						        			
			        			if(in_array($etiqueta,array("create","write","report","kanban")))	
			        			{
			        				$text="false";
			        				$action="1";
			        			}
			        			elseif(in_array(substr($etiqueta,0,6),array("create","report","kanban")))	
			        			{
			        				$text="true";
			        				$action="1";
			        			}			        			
			        			elseif(in_array(substr($etiqueta,0,5),array("write")))	
			        			{
			        				$text="true";
			        				$action="1";
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
			        		if(@$action=="1")	
			        		{
			        			$font_id	="$etiqueta"."_{$this->sys_name}";
			        			$funcion_id	="execute"."_{$this->sys_name}";
			        		}	
			        		else				$font_id="$etiqueta";
			        		
			        		$value="$etiqueta";
							if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n) AND isset($this->sys_view_l18n["$etiqueta"]))	
							{			        	
								$titulo		=$this->sys_view_l18n["$etiqueta"];
							}			        	
							if($titulo=="")	$titulo=$valor;
							
			        	}
			        }	
			        if($value=="action")    $sys_input.="$(\"#sys_action_{$this->sys_name}\").val(\"__SAVE\");";
			        else					
			        {
			        	$sys_input.="
							$(\"#sys_action_{$this->sys_name}\").val(\"__clean_session\");
			        		$(\"#sys_section_{$this->sys_name}\").val(\"$value\");
			        		$(\"#sys_id_{$this->sys_name}\").val(\"\");
			        		$(\"input.{$this->sys_name}\").val(\"\");							
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
							$(\"#$font_id\").click(function()
							{								
								var enviar	=true;									
								$sys_input
								
								$(\".sys_filter\").val(\"\");
								
								if($(this).attr(\"id\")==\"action_{$this->sys_name}\") 								
								{									
									enviar	=false;	
									if(typeof submit_{$this->sys_name} === 'function') 								
									{															
										enviar	=submit_{$this->sys_name}();
									}									
									else
									{
										enviar	=true;		
									}								
									if($(\"[class*='required'][class*='{$this->sys_name}']\").length>0)
									{				
										$(\"[class*='required'][class*='{$this->sys_name}']\").each(function(){
											if(   $(this).val()==\"\"   )
											{
												enviar=false;	
											}										
										});	
										var form=\"Favor de verificar los campos faltantes</font>\";								
									}
								}
								
								if(enviar==true)	$(\"form\").submit();
								else 
								{
									$(\"#message\")
									.html(form)
									.dialog({
										width:\"400\",
										modal: true,
									});
								}							
							});		 
			        	";
		        	}
					if($etiqueta=="import")
					{
						$script.="
							$(\"#$font_id\").click(function()
							{									
								var form=\"Archivo CSV <input id=\\\"import_csv_{$this->sys_name}\\\"  name=\\\"import_csv_{$this->sys_name}\\\" type=\\\"file\\\" class=\\\"formulario\\\"><font id=\\\"upload_import\\\">Cargar</font>\";								
								$(\"#message\")
								.html(form)
								.dialog({
									width:\"400\",
									modal: true,
								});
								var datos={		
									type: 'POST',													
									async: true,
									cache: false,
									contentType: false,
									enctype: 'multipart/form-data',
									processData: false,
								};
																
								$(\"#upload_import\")
									.button()
									.click(function()
									{
										$(\"#message\")
											.dialog(\"destroy\")
											.hide();										
								
										var formData = new FormData($(\"form\")[0]);
										
										var subiendo=datos;
										
										subiendo.url		='../sitio_web/ajax/general.php&seccion_import=subiendo_archivo&sys_name={$this->sys_name}&date=".date("YmdHis")."';
										subiendo.data		=formData;
										subiendo.success	=function (response) 
										{			
											var obj = $.parseJSON( response);
																					
											$(\"#message\")
											.attr({\"title\":\"Estado del sistema\"})
											.html(obj.mensaje)
											.dialog({
												width:\"400\",
												modal: true,
											});				

											var preparar=datos;
											preparar.url		='../sitio_web/ajax/general.php&seccion_import=preparar_tabla&sys_name={$this->sys_name}&date=".date("YmdHis")."';										
											preparar.success	=function (response) 
											{
												var html=$(\"#message\").html() + response;											
												$(\"#message\").html(html);												
												
												var cargar=datos;
												cargar.url		='../sitio_web/ajax/general.php&seccion_import=cargar_tabla&sys_name={$this->sys_name}&date=".date("YmdHis")."&name='+obj.name;										
												cargar.success	=function (response) 
												{
													var html=$(\"#message\").html() + response;											
													$(\"#message\").html(html);												
																										
													var actualizar=datos;
													actualizar.url		='../sitio_web/ajax/general.php&seccion_import=actualizando_datos&sys_name={$this->sys_name}&date=".date("YmdHis")."';										
													actualizar.success	=function (response) 
													{
														$(\"#import_pendiente\").html(response);												
													};											
													$.ajax(actualizar);														
												};											
												$.ajax(cargar);																									
											};											
											$.ajax(preparar);	
										};
										$.ajax(subiendo);	
									});									
							});		        	
			        	";						
					}		
		        	
			        $return .="
			        	<font id=\"$font_id\" title=\"$title\">$titulo</font>
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
			        	<input id=\"{$data["id"]}\" type=\"checkbox\">
			        	<label for=\"{$data["id"]}\">{$data["title"]}</label>				        	
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
			if(isset($valor["source"]))
			{	
		    	$vauxpath						=explode("/",$_SERVER["PHP_SELF"]);
		    	$vauxpath[count($vauxpath)-1]	="";
		    	$auxpath						="http://".$_SERVER["SERVER_NAME"].implode("/",$vauxpath).substr($valor["source"],3,strlen($valor["source"])-3);
			}        	
        	return	@json_decode(@file_get_contents($auxpath."?id=".$valor["value"]));
		}		
		##############################################################################
		public function __DATA_AUTOCOMPLETE($data)
		{		
			$data_json=array();
			if(count($data)>0)
			{
				foreach($data as $row)
				{
					$data_json[]=array(
						'label'     => $row["name"],
						'clave'		=> $row["id"]	
					);			
				}
			}
			else
			{
				if(@$_GET["term"]!="")	$busqueda=@$_GET["term"];
				else					$busqueda=@$_GET["id"];
				
				$data_json[]=array(
					'label'     => "Sin resultados para ". $busqueda,
					'clave'		=> ""	
				);				
			}		
			echo json_encode($data_json);
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

