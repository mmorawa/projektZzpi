<?php
require('fpdf/fpdf.php');

//Zmiana kodowania
function convert( $array, $z, $do)
{
    $temp = array();
    foreach ( $array as $k => $v )
        if ( is_array( $v ) )
            $temp[$k] = convert( $v, $z, $do );
        else
            $temp[$k] = iconv( $z, $do, $v );
    return $temp;
}

//Klasa PDF
$pdf = new FPDF();
class PDF extends FPDF
{

//Funkcja tworząca tabelę
function Table($header, $data)
{
    // Szerokość kolumn
    $w = array();
    for ($i=0;$i<count($data);$i++)
        $w[$i]=80;
    
    // Nagłówek
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    
    // Dane
    for($i=0;$i<count($data);$i++){
        for($j=0;$j<2;$j++){
            $this->Cell($w[$i],7,$data[$i][$j],1,0,'C');
            }
        $this->Ln();
    }

}

}



//Nowy PDF
$pdf = new PDF();

//Czcionka
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
$pdf->SetFont('arial_ce','',14);

//Dane do tabeli
$headerUTF = array('Imię i nazwisko', 'Wynagrodzenie (w zł)');
$header = convert($headerUTF,'UTF-8','windows-1250//TRANSLIT');

//To do zmiany - przykładowe dane
$dataUTF = array('Jan Kowalski', '234','Michał Kowalski', '214','Marek Nowy','0','Piotr Kozak','34');

$dataLONG = convert($dataUTF,'UTF-8','windows-1250//TRANSLIT');
$data=array_chunk($dataLONG, 2);


//Nowa strona
$pdf->AddPage();


//Opis tabeli
$pdf->Ln();
$opis=iconv('UTF-8','windows-1250//TRANSLIT','Zestawienie miesięczne wynagrodzenia za: ');
$pdf->Cell(10,10, $opis.date('m-Y'));
$pdf->Ln();

//Tabela
$pdf->Table($header,$data);

//Wyświetlenie pliku w przeglądarce przy pomocy wtyczki obsługującej format PDF
$pdf->Output();
//Pobranie pliku PDF
//$pdf->Output(D);
?>
