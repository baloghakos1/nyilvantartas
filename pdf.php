<?php
require('tfpdf.php');
require_once('C:\xampp\htdocs\nyilvantartas\eszkozok.php');
$servername = "localhost";
    $username = "root";
    $password = null;
    $database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password, $database);

class PDF extends tFPDF
{

    function ASD($ok): void
{
    $this->Cell(15,6,"id",1);
    $this->Cell(65,6,"Név",1);
    $this->Cell(15,6,"Polc",1);
    $this->Cell(15,6,"Oszlop",1);
    $this->Cell(15,6,"Sor",1);
    $this->Cell(15,6,"Raktár",1);
    $this->Cell(15,6,"Min_Mennyiség",1);
    $this->Cell(15,6,"Mennyiség",1);
    $this->Cell(15,6,"Ár",1);
    $this->Ln();
    foreach($ok as $oksa) {
        $szia = 0;
        foreach($oksa as $prdct) {
            if($szia == 1) {
                $this->Cell(65,6,$prdct,1);
            }
            else {
                $this->Cell(15,6,$prdct,1);
            }
            $szia++;
        }
        $this->Ln();
    }
}
function Header()
{
    $this->Image('asd.jpg',10,6,20);
    $this->SetFont('Arial','B',15);
    $this->Cell(80);
    $this->Cell(30,10,'Title',1,0,'C');
    $this->Ln(20);
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$pdf = new PDF();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',14);
$pdf->AddPage();
$all = Eszkozok::getALL($mysqli);
$asd = $pdf->ASD($all);
$pdf->SetFont('Times','',12);
$pdf->Output();
?>