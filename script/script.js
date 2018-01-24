function toogle() {
    var x = document.getElementById("details2");
    if (x.style.display === "none") {
		tresc =  document.getElementById("details").innerHTML;
		document.getElementById("details2").innerHTML =  tresc;
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function zegar(){
	var dzisiaj = new Date();
	var dzien = dzisiaj.getDate();
	if(dzien < 10) dzien= "0"+dzien;	
	var miesiac = dzisiaj.getMonth()+1;
	if(miesiac < 10) miesiac= "0"+miesiac;	
	var rok = dzisiaj.getFullYear();
	var godzina = dzisiaj.getHours();
	if(godzina < 10) godzina = "0"+godzina;
		var minuta = dzisiaj.getMinutes();
	if(minuta < 10) minuta = "0"+minuta;
	var sekunda = dzisiaj.getSeconds();	
	if(sekunda < 10) sekunda= "0"+sekunda;		
	
	document.getElementById("footer").innerHTML = 
	dzien+"/"+miesiac+"/"+rok+" "+godzina+":"+minuta+":"+sekunda;	
	setTimeout("zegar()",1000);
}
