<?php
echo "<CENTER>Zmiana hasła
<form action='?a=opcje' method='post'>
	<table>
		<tr>
			<td>
			Stare hasło:
			</td>
			<td>
			<input class='button' type='password' style='width:200px' name='oldpassword' />
			<td>
		</tr>
		<tr>
			<td>
				Nowe Hasło:
			</td>
			<td>
				<input class='button' type='password' style='width:200px' name='newpassword' />
			</td>
		</tr>

		<tr>
			<td>
			</td>
			<td>
				<input class='button' type='submit' style='width:100px' value='Zmień hasło!'/>
			</td>
		</tr>
	</table>
</CENTER>";

if(!empty($_POST)){
	if (!empty($_POST['oldpassword']) && (!empty($_POST['newpassword']))){
		$old=$_POST['oldpassword'];
		$new=$_POST['newpassword']; 
		//sprawdzenie poprawności
		$dane = mysqli_query($db , "SELECT * FROM WebSiteUsers WHERE Id=".$_SESSION['id']." LIMIT 1");
		if (mysqli_num_rows($dane)===1){
			$dane = mysqli_fetch_assoc($dane);
			if ( (md5($old))== $dane['Haslo']){ 
				$new = md5($new);
				mysqli_query($db , "UPDATE WebSiteUsers SET Haslo='".$new."' WHERE Id=".$_SESSION['id']." LIMIT 1");
				echo "Pomyślnie zmieniono hasło";
			}
			else{
				echo "Stare hasło jest nie prawidłowe";
			}
		}
		else{
			echo '<CENTER>Problem z użytkownikiem!</CENTER><BR>';
		}
	}
	else{
		echo '<CENTER>Uzupełnij wszystkie dane!</CENTER><BR>';
	}
};
?>