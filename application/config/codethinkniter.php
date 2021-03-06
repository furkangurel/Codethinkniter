<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|----------------------------------------------------------------------------------------------------------------------|
|                                    CodeTHİNKniter v2. Easy Insert-Update Library 					   		 	       |	  
|----------------------------------------------------------------------------------------------------------------------|
|  Author  : Furkan Gürel																							   |
|  Github  : https://github.com/furkangurel 																		   |
|  Youtube : https://youtube.com/c/codeigniterhocasi                                                                   |
|----------------------------------------------------------------------------------------------------------------------|


|-----------------------| |--------------------------------------------------------------------------------| 
|DOSYA YÜKLEME KURALLARI| |-Upload edilecek dosyalar için gerekli varsayılan kurallar belirlemenizi sağlar-|
|-----------------------| |--------------------------------------------------------------------------------|

Upload Path   : Upload edilen dosyaların kaydedileceği dosya adı.                                                         */
$config['upload_path']          = 'assets'; 																			  /*
Allowed Types : Upload edilen dosyaların uzantıları belirtmenizi sağlar. Kullanımı $config['allowed_types']='jpg|png|pdf  */
$config['allowed_types']        = 'jpg|png|pdf|jpeg';																	  /*
Max Size : Upload edilen dosyaların maximum dosya boyutunu girmenizi sağlar. 1 MB = 1024                                  */
$config['max_size']             = 3024;													                                  /*          
Max Width : Upload edilen resimin genişlik değerini  girmenizi sağlar                                                     */
$config['max_width']            = 1750;                                                                                   /*
Max Width : Upload edilen resimin yükseklik değerini  girmenizi sağlar   												  */
$config['max_height']           = 1750;                                  												  /*
Upload Fail : Upload edilen dosyanın hangi sebepten yüklenemediğini ekrana basar.  										  */
$config['upload_fail']          = array('start'  =>'<div class="alert alert-danger">',
										'finish' =>'</div>'); 				  											  /*
Session Name   : İşlem sonucunda kullanıcıya sunulcak bilgileri saklıyacak session adını giriniz.                     	  */
$config['thinksession']         = 'sonuc';      																	      /*




|-----------------------| |------------------------------------------------------------------------------------------| 
|İŞLEM SONUCU KURALLARI | |Kütüphane üzerinden işleminizi yaptıktan sonra çalışmasını istediğiniz kuralları belirler.|
|-----------------------| |------------------------------------------------------------------------------------------|

Auto Pilot     : İşlem sonucunda kullanıcıya sunulcak bilgileri otomatik  sunmanızı sağlar.    true/false             */
$config['auto_pilot']     = true;     																			      /*

Success İnsert : Ekleme işlemi başarıyla gerçekleşirse Ekranda yazacak olan bilgi mesajını belirlemenizi sağlar.      */
$config['success_insert'] = '<div class="alert alert-success">Ekleme işlemi başarıyla yapıldı.</div>';                /*
																												  
Success Update : Güncelleme işlemi başarıyla gerçekleşirse Ekranda yazacak olan bilgi mesajını belirlemenizi sağlar.  */
$config['success_update'] = '<div class="alert alert-success">Güncelleme işlemi başarıyla yapıldı.</div>';            /*

Validation Error : Validation işlemi gerçekleşmezse Ekranda yazacak olan bilgi mesajı stilini belirlemenizi sağlar.  */
$config['validation_error'] = array('start'  => '<div class="alert alert-danger">',
									'finish'  =>'</div>');                 											/*




/*
|---------------------------| |------------------------------------------------------------------------------------------| 
|CODETHİNKNİTER KULLANIMI   | |                                  İNSERT METODU             								 |
|---------------------------| |------------------------------------------------------------------------------------------|

Controller
| 
$this->load->library('Codethinkniter');
$this->codethinkniter->command('tabloadi','insert');
|
View
<input type="text" name="1"> // Name kısmına bu inputtan gelen verinin kaydolacağı sütunun sırasını yazmalısın.

Tüm form  inputlarını destekler.

*/

/*
|---------------------------| |------------------------------------------------------------------------------------------| 
|CODETHİNKNİTER KULLANIMI   | |                                  UPDATE METODU           								 |
|---------------------------| |------------------------------------------------------------------------------------------|

Controller
| 
$this->load->library('Codethinkniter');
$this->codethinkniter->command('tabloadi','upload');
|
View
<input type="text" name="1"> // Name kısmına bu inputtan gelen verinin kaydolacağı sütunun sırasını yazmalısın.

<input type="hidden" name="0" value="<?php codethinkniter($id)"> // Güncellenmesini istediğiniz veriye ait id yi 
																	name="0" dedikten sonra value kısmında codet
																	hinkniter() metoduyla belirtin.

*/


/*
|---------------------------| |------------------------------------------------------------------------------------------| 
|CODETHİNKNİTER KULLANIMI   | |                                  FORM VALİDATİON          								 |
|---------------------------| |------------------------------------------------------------------------------------------|

Controller
| 
$this->load->library('Codethinkniter');

$config=array
(
	array
	(
		'field'=>"1", 				// Validation kuralı yazdığınız inputun name değerini girmelisiniz.
		'label'=>"Haber Başlığı",  // Eğer Validation kuralından geçemezse hata gösterirken yazmasını istediğiniz başlık.
		'rules'=>"required|min_length[5]" // Belirlediğiniz Kurallar.
	)
);
$this->codethinkniter->validate($config);
$this->codethinkniter->command('tabloadi','insert');
|

Validate satırının command den üstte yazması gereklidir.

View
|
<input type="text" name="1" value="<?php echo validatemessage(1)"> // Eğer Form validation hatalı olursa input içerisinde 
																	  hatalı olan içeriği tekrar gösterir.


*/


/*
|---------------------------| |------------------------------------------------------------------------------------------| 
|CODETHİNKNİTER KULLANIMI   | |                                  AUTO PİLOT         								 	 |
|---------------------------| |------------------------------------------------------------------------------------------|

Controller
| 
$this->load->library('Codethinkniter');

$this->codethinkniter->auto_pilot() /true or false

Configde belirlemiş olduğunuz auto pilot metodunun dışında kullanmak istediğinizde tanımlamanız gerekir.Configde auto_pilot
true ise ve bir controllerda false olarak kullanmak isterseniz ilgili fonksiyonda yazmanız yeterli olacaktır.


*/																	  



/*
|---------------------------| |------------------------------------------------------------------------------------------| 
|KULLANILABİLİR FONKSYİONLAR| |Formdan veri çekerken kullanileceğiniz fonksiyonlar.                                      |
|---------------------------| |------------------------------------------------------------------------------------------|

SEF Fonksiyonu = Arama Motoru dostu url yaratmak için kullanılan fonksiyondur. Tablonuzaki bir sütunu sef leyerek kaydet-
				 mek için kullanabilirsiniz. Örnek olarak Blog eklerken Bloğun başlığını sefli olarak başka bir sutunda -
				 kayıt ederek sefli url yoluyla linklendirme yapabilirsiniz.

				 Kullanımı : <input type="hidden" name="6" value="sef(1)">  

				 Type hidden vererek formda görülmesini kapatıyoruz. Name kısmına sefli kaydedilecek bilginin sutunun sı
				 rasını  yazıyoruz. Value kısmında ise hangi inputtan gelen verinin sef li kaydedileceğini belirtiyoruz.

Codethinkniter = Formdan veri gönderirken inputlar dışındaki kaynaklardaki  (session/veritabanı değeri gibi) verilere ih-
			 	 tiyaç duyulursa, Bu fonksiyonla formla gönderebilirsiniz.

			 	 Kullanımı : <input type="hidden" name="6" value="<?php codethinkniter($session->uye_id) ?>">

			 	 Type hidden vererek formda görülmesini kapatıyoruz. Name kısmına tablodaki ilgili sütunun sırasını yazı
			 	 yoruz. Value kısmında ise php tagları içinde codethinkniter fonksiyonunun içine göndermek istediğimiz
			 	 veriyi yazıyoruz.

			 	 ---------------------------------------GELİŞTİRME AŞAMASINDA----------------------------------------------

*/