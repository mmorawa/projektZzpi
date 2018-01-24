<?php
echo "<CENTER>Odzyskiwanie hasła
<form action='?a=odzyskaj' method='post'>
	<table>
		<tr>
			<td>
			Login:
			</td>
			<td>
			<input class='button' type='text' style='width:200px' name='login' />
			<td>
		</tr>
		<tr>
			<td>
				E-mail:
			</td>
			<td>
				<input class='button' type='text' style='width:200px' name='email' />
			</td>
		</tr>

		<tr>
			<td>
			</td>
			<td>
				<input class='button' type='submit' style='width:100px' value='Odzyskaj'/>
			</td>
		</tr>
	</table>
</form>
<a href='?a=home'><button class='button'>Powrót</button></a></CENTER>
</BR>
</CENTER>";

if(!empty($_POST)){
	if (!empty($_POST['login']) && (!empty($_POST['email']))){
		$login=$_POST['login'];
		$email=$_POST['email']; 
		
		//sprawdzenie poprawności
		$dane = mysqli_query($db , "SELECT * FROM WebSiteUsers WHERE Login='$login' LIMIT 1");
		if (mysqli_num_rows($dane)==1){
			$dane=mysqli_fetch_assoc($dane);
			if ($email==$dane['Email']){
				
				function losowy_ciag($dlugosc){
				   $string = md5(time());
				   $string = substr($string,0,$dlugosc);
				   return($string);
				}
				$nowehaslo = losowy_ciag(10);

				$to = $email;
				$subject = "Odzyskiwanie konta do strony zakladowej";
				$message = "Nowe hasło do strony zakładowej: ".$nowehaslo;
				$from = "konto.zakladu@gmail.pl";
				$headers = "From:".$from;
				mail($to,$subject,$message,$headers);
				$md5haslo = md5($nowehaslo);
				mysqli_query($db ,"UPDATE `WebSiteUsers` SET Haslo = '".$md5haslo."' WHERE Login='".$login."';");
				echo "<CENTER>Wysłano nowe hasło na podany adres email.</BR>";
					
			}
			else {
				echo '<CENTER>Podano nieprawidłowe dane!</CENTER><BR>';
			}
		}
		else {
			echo '<CENTER>Podano nieprawidłowe dane!</CENTER><BR>';
		}		
	}
	else{
		echo '<CENTER>Podaj swój login oraz adres email.</CENTER><BR>';
	}
};
?>