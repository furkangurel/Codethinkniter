<?php

class CodeThinkniter
{
	private $ci;

	public function command($name,$job,$upload=null)
	{
		$ci = &get_instance();
		if($ci->input->method()=="post"){
		switch ($job)
		{  
		   case     "insert": return $this->insert($name,$upload); 		 				break;
		   case     "update": return $this->update($name,$upload); 		 				break;
		   default:  echo $job." Kullanılabilir komutlar arasında değil. ";         	break;
		}
	}}


	public function validate($rules)
	{
		$ci = &get_instance();
		if($ci->input->method()=="post"){
		$ci->load->library('form_validation');
		$ci->form_validation->set_rules($rules);
		if ($ci->form_validation->run() == FALSE)
                {
                        $ci->session->set_flashdata(config_item('thinksession'),validation_errors
                        	(
                        	    config_item('validation_error')['start'] , config_item('validation_error')['finish'])
                         	);
                        $input=$ci->input->post();
                        foreach ($input as $key => $value) 
                        {
                        	$ci->session->set_flashdata('a'.$key,set_value($key));
                        }
                        return redirect($_SERVER['HTTP_REFERER']);
                }
	}}

	public function auto_pilot($val)
	{
	    $ci=get_instance();
	    if($val==true){$durum="True";}else{$durum="False";}
	    if(config_item('auto_pilot')==$val)
	    {
	        echo "Config de belirtilmiş olan Auto_pilot değeri zaten ".$durum ;
	        die();
	    }
	    if($val==true){$val="on";}else{$val="off";}
	    return $ci->session->set_flashdata('auto_pilot',$val);
	}
	
	public function insert($name,$upload)
	{
		$ci = &get_instance();							   				
		$tables=$ci->db->list_fields($name); 	  						  
		$arraytable = $this->stdarray($tables);   
		$image=$_FILES;	
		$input=$ci->input->post(); 	   						   
		$rules=$this->uploadrules($upload);	  					       
		$data=$this->createdata($arraytable,$image,$input,$rules);	 
		return $this->procedure("insert",$name,$data);				
	}

	public function update($name,$upload)
	{
		$ci = &get_instance();							   			
		$tables=$ci->db->list_fields($name); 	  						 
		$arraytable = $this->stdarray($tables);                          
		$image=$_FILES;							                        
		$input=$ci->input->post();		   	   						   	
		$rules=$this->uploadrules($upload);	  					      
		$data=$this->createdata($arraytable,$image,$input,$rules,1); 
		return $this->procedure("update",$name,$data);				
	}


	function procedure($job,$table,$data)
	{
		$ci = &get_instance();
		$value=$ci->session->userdata('updateveb');
		$manuelpilot=$ci->session->flashdata('auto_pilot');
		switch ($job)
		{
		   case "insert":
		 		 $result=$ci->db->insert($table,$data);

				 if($manuelpilot)
				 {
				 	if($manuelpilot=="on")
				 	{
				 		if(config_item('thinksession')!="")
						{
				 			$ci->session->set_flashdata(config_item('thinksession'),config_item('success_insert'));				 	
				 		}
				 		return redirect($_SERVER['HTTP_REFERER']);
				 	}
				 }else
				 {
				 	if(config_item('auto_pilot')==true)
				 	{
				 		if(config_item('thinksession')!="")
						{
				 			$ci->session->set_flashdata(config_item('thinksession'),config_item('success_insert'));				 	
				 		}
				 		return redirect($_SERVER['HTTP_REFERER']);
				 	}
				 }
				 
		   return $result; 
		   break;
		   case "update": 
		   $results=$ci->db->where($value)->update($table,$data);

		   if(config_item('thinksession')!="")
				 {
				 	$ci->session->set_flashdata(config_item('thinksession'),config_item('success_update'));
				 }
				if($manuelpilot)
				 {
				 	if($manuelpilot=="on")
				 	{
				 		if(config_item('thinksession')!="")
						{
				 			$ci->session->set_flashdata(config_item('thinksession'),config_item('success_update'));				 	
				 		}
				 		return redirect($_SERVER['HTTP_REFERER']);
				 	}
				 }else
				 {
				 	if(config_item('auto_pilot')==true)
				 	{
				 		if(config_item('thinksession')!="")
						{
				 			$ci->session->set_flashdata(config_item('thinksession'),config_item('success_update'));				 	
				 		}
				 		return redirect($_SERVER['HTTP_REFERER']);
				 	}
				 }
		   return $results;
		   break;
		   default: echo "Bu Komutu bilmiyorum"; die(); break;
		}
	}


	
	





	function createdata($db,$image,$input,$upload,$update=null)
	{
		    $ci = &get_instance();
			if($update)
			{
				if(!isset($input[0]))
				{
					echo "Güncellenecek id değeri belirtilmemiş. Formdan name değeri 0 olan inputta value kısmında id belirtiniz.";
					die();
				}
				$enc=$this->sessiondata($input[0]);
				$updateveb=array($db[0]=>$enc); 
				$ci->session->set_userdata('updateveb',$updateveb);
				unset($db[0]);
				unset($input[0]);
			}
		

	
			foreach($image as $img => $val)
			{
				if($val['size']!=0){
			    $file_path=$this->upfile($upload,$img);
				if($file_path)
				{
					$data[$db[$img]]=$file_path;
				}
						
			}}


		foreach($input as $inp => $value)
		{
			
			$data[$db[$inp]]=$value;
			if($val=$this->sef($value))
			{
				$data[$db[$inp]]=$this->seftranslate($input[$val]);
			}
			if($value=$this->sessiondata($value))
			{
				$data[$db[$inp]]=$value;
			}
		}	
		return $data;
	}
	
	function uploadrules($upload)
	{
	
			if(config_item('upload_path')=="")
			{
				echo "Dosyaların yükleneceği yolu Config/codethinkniter.php üzerinden Default olarak belirtin.";
				exit();
			}
			if(config_item('allowed_types')=="")  
			{
				echo "Yüklenmesine izin verilen uzantıları  Config/codethinkniter.php üzerinden Default olarak belirtin.";
				exit();
			}
			if(!config_item('max_size'))	 
			{
				echo "Dosyaların yüklenebileceği maximum boyutu Config/codethinkniter üzerinden Default olarak belirtin.";
				exit();
			}
			if(config_item('max_width')=="") 
			{
				echo "Dosyaların yüklenebileceği maximum genişliği Config/codethinkniter.php üzerinden Default olarak belirtin.";
				exit();
			}
			if(config_item('max_height')=="") 
			{
				echo "Dosyaların yüklenebileceği maximum uzunluğu  Config/codethinkniter.php üzerinden Default olarak belirtin.";
				exit();
			}

			if(!isset($upload['upload_path']))   
				{ 
					$upload['upload_path']   =   config_item('upload_path'); 
				}
			if(!isset($upload['allowed_types']))
				{ 
					$upload['allowed_types']   =   config_item('allowed_types'); 
				}
			if(!isset($upload['max_size']))
				{ 
					$upload['max_size']   =   config_item('max_size'); 
				}
			if(!isset($upload['max_width']))
				{ 
					$upload['max_width']   =   config_item('max_width'); 
				}
			if(!isset($upload['max_height']))
				{ 
					$upload['max_height']   =   config_item('max_height'); 
				}

				return $upload;
	}

	 function upfile($config,$name)
 	{
 	$ci=get_instance();
 	$ci->upload->initialize($config);
 	if($ci->upload->do_upload($name))
 	{
 		$resim=$ci->upload->data();
 		$resimadi=$resim['file_name'];
 		$kayityolu=base_url().$config['upload_path'].'/'.$resimadi;
 		return $kayityolu;
 	}else
 	{
 		if($ci->upload->display_errors()=="<p>err</p>")
 		{
 			return "err";
 		}else
 		{
 			$ci->session->set_flashdata(config_item('thinksession'),$ci->upload->display_errors
 			(
 				config_item('upload_fail')['start'] ,
 				config_item('upload_fail')['finish']
 			));
 			return redirect($_SERVER['HTTP_REFERER']);
 		}
 	}
 	}
	
 	public function sef($value)   	
	{
		if(strstr($value, "sef"))
			{
			return  $metin = preg_replace('/[^ .%0-9]/', '', $value);
			}
	}

	public function stdarray($std)
	{
		return json_decode(json_encode($std), true); 
	}

	public function sessiondata($value)
	{
		if ( base64_encode(base64_decode($value)) === $value)
		{
    			return base64_decode($value);
    	}
	}


	function seftranslate($str)
	{
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults);
    $char_map = array(
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}

}



?>