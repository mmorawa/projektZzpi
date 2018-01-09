<?php
echo "<CENTER>Logowanie
<form action='?a=home' method='post'>
	<table>
		<tr>
			<td>
			Login:
			</td>
			<td>
			<input type='text' style='width:200px' name='login' />
			<td>
		</tr>
		<tr>
			<td>
				Hasło:
			</td>
			<td>
				<input type='password' style='width:200px' name='password' />
			</td>
		</tr>

		<tr>
			<td>
			</td>
			<td>
				<input type='submit' style='width:100px' value='Zaloguj'/>
			</td>
		</tr>
	</table>
</form>
	<table>
		<tr>
			<td> Nie pamiętasz hasła? 
			</td>
			<td>
				<a href='?a=odzyskaj'>Odzyskaj hasło</a>
			</td>
		</tr>
	</table>
</CENTER>";

if(!empty($_POST)){
	if (!empty($_POST['login']) && (!empty($_POST['password']))){
		$login=$_POST['login'];
		$password=$_POST['password']; 
		//sprawdzenie poprawności
		$dane = mysqli_query($db , "SELECT * FROM WebSiteUsers WHERE Login='$login' LIMIT 1");
		if (mysqli_num_rows($dane)===1){
			$dane=mysqli_fetch_assoc($dane);
			if (md5( $password)===$dane['Haslo']){
                //logowanie i pobranie sesji
				$_SESSION['id'] = $dane['Id']; 
				$dane = mysqli_query($db , "SELECT IdStanowiska FROM Pracownicy WHERE Id=".$_SESSION['id']." LIMIT 1");
				$dane = mysqli_fetch_array($dane);
				$_SESSION['stanowisko'] = $dane['0'];
				header("Location: ?a=start");
			}
			else {
				echo '<CENTER>Podane hasło jest nieprawidłowe!</CENTER><BR>';
			}
		}
		else {
			echo '<CENTER>Nie istnieje takie konto użytkownika!</CENTER><BR>';
		}		
	}else {
		echo '<CENTER>Uzupełnij wszystkie dane!</CENTER><BR>';
	}
};
?>
