# Codethinkniter
Simple Codeigniter İnsert-Update Library

Beta süreci başlangıcı 12.03.2018



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

```
<label>Blog Başlık</labeş>
<input type="text" name="1">  // Name kısmına verinin kaydedileceği sütunun sırasını girmelisin. Bu inputa yazılan başlık tablonun 1.sırasındaki sütuna kaydedilecektir.
```
 
