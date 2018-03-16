# Codethinkniter
Simple Codeigniter İnsert-Update Library

Beta süreci başlangıcı 12.03.2018

Tutorial : https://www.youtube.com/watch?v=rRDNh1JYyH0



<pre>
	v2 Yenilikleri<hr>

	<li> Form Validation Özelliği Eklendi.</li>
	<li> Validationdan geçemeyen inputların değerlerini göstermek için validatemssage() fonksiyonu eklendi.</li>
	<li> Tüm mesajları ekrana basan message() fonksiyonu eklendi. </li>

<pre>



Projeye dahil etmek için;
<pre>$this->load->library('Codethinkniter'); </pre>


Kullanımı

Controller
<pre>
public function blogekle()
{
   $this->codethinkniter('tabloadı','komut'); // insert-update
}
</pre>


View
```
<form action="" method="post">
<label>Blog Başlık</labeş>
<input type="text" name="1"> / Name kısmında yazan sayı tablonuzda kaydetmek istediğiniz sütunun sırası olmalıdır.
```
 
