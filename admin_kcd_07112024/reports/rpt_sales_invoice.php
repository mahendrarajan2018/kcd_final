<?php

    require_once('../fpdf/AlphaPDF.php');
    $pdf = new AlphaPDF('P','mm','A4');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false);
    // $pdf->SetDrawColor(223,36,67);
    // $pdf->SetTextColor(223,36,67);
	$pdf->SetTitle('Invoice');
    $pdf->SetFont('Arial','B',10);

    $pdf->SetX(10);
    $pdf->Cell(20,5,'Branch',0,0,'L',0);
    $pdf->SetX(30);
    $pdf->Cell(70,5,': ____________________________________',0,0,'L',0);
    $pdf->SetX(110);
    $pdf->Cell(20,5,'OPEN Km.',0,0,'L',0);
    $pdf->SetX(130);
    $pdf->Cell(25,5,'____________',0,0,'L',0);
    $pdf->SetX(155);
    $pdf->Cell(20,5,'Close Km.',0,0,'L',0);
    $pdf->SetX(175);
    $pdf->Cell(25,5,'____________',0,1,'L',0);
    $pdf->Cell(0,1,'',0,1,'C',0);

    $starty = $pdf->GetY();
    $pdf->Cell(0,2,'',0,1,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(90,5,'Sri Senthur Murugan Speed parcal Service',0,1,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(90,5,'H.O. : 648, Palaniyandavarpuram Colony,',0,1,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(90,5,'SIVAKASI',0,1,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(90,5,'Cell : 96882 09858, 73388 87566',0,0,'C',0);

    $pdf->SetY($starty);
    $pdf->Cell(0,2,'',0,1,'C',0);
    $pdf->SetX(110);
    $pdf->Cell(40,5,'LUGGAGE CHART NO.',0,0,'C',0);

    $pdf->SetY($starty);
    $pdf->Cell(0,2,'',0,1,'C',0);
    $pdf->SetX(150);
    $pdf->Cell(25,5,'Vechile No.',0,0,'C',0);
    $pdf->SetX(175);
    $pdf->Cell(25,5,':___________',0,1,'L',0);
    $pdf->SetX(150);
    $pdf->Cell(25,5,'Date.',0,0,'C',0);
    $pdf->SetX(175);
    $pdf->Cell(25,5,':___________',0,1,'L',0);

    $pdf->SetY($starty);
    $pdf->SetX(10);
    $pdf->cell(100,25,'',1,0,'L',0);

    $pdf->SetX(110);
    $pdf->Cell(40,25,'',1,0,'L',0);

    $pdf->SetX(150);
    $pdf->Cell(50,25,'',1,1,'L',0);

    $pdf->SetX(10);
    $pdf->Cell(10,7,'S.No',1,0,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(30,7,'L.R.No.',1,0,'C',0);
    $pdf->SetX(50);
    $pdf->Cell(25,7,'To',1,0,'C',0);
    $pdf->SetX(75);
    $pdf->Cell(35,7,'Consignor',1,0,'C',0);
    $pdf->SetX(110);
    $pdf->Cell(35,7,'Consignee',1,0,'C',0);
    $pdf->SetX(145);
    $pdf->Cell(35,7,'Articles',1,0,'C',0);
    $pdf->SetX(180);
    $pdf->Cell(20,7,'NO.',1,1,'C',0);
    $pdf->SetFont('Arial','',8);

    $y_axis = $pdf->GetY();

    if($pdf->GetY() >= 195){
        $y = $pdf->GetY();
        $pdf->SetX(10);
        $pdf->Cell(10,270-$y_axis,'',1,0,'C',0);
        $pdf->SetX(20);
        $pdf->Cell(30,270-$y_axis,'',1,0,'C',0);
        $pdf->SetX(50);
        $pdf->Cell(25,270-$y_axis,'',1,0,'C',0);
        $pdf->SetX(75);
        $pdf->Cell(35,270-$y_axis,'',1,0,'C',0);
        $pdf->SetX(110);
        $pdf->Cell(35,270-$y_axis,'',1,0,'C',0);
        $pdf->SetX(145);
        $pdf->Cell(35,270-$y_axis,'',1,0,'C',0);
        $pdf->SetX(180);
        $pdf->Cell(20,270-$y_axis,'',1,1,'C',0);

        $pdf->SetX(10);
        $pdf->SetFont('Arial','B',9);
        $next_page = $pdf->PageNo()+1;
        $pdf->Cell(0,5,'Continued to Page Number '.$next_page,1,1,'R',0);

        $pdf->AddPage();
        $pdf->SetTitle('Invoice');
        $pdf->SetFont('Arial','B',10);

        $pdf->SetX(10);
        $pdf->Cell(20,5,'Branch',0,0,'L',0);
        $pdf->SetX(30);
        $pdf->Cell(70,5,': ____________________________________',0,0,'L',0);
        $pdf->SetX(110);
        $pdf->Cell(20,5,'OPEN Km.',0,0,'L',0);
        $pdf->SetX(130);
        $pdf->Cell(25,5,'____________',0,0,'L',0);
        $pdf->SetX(155);
        $pdf->Cell(20,5,'Close Km.',0,0,'L',0);
        $pdf->SetX(175);
        $pdf->Cell(25,5,'____________',0,1,'L',0);
        $pdf->Cell(0,1,'',0,1,'C',0);

        $starty = $pdf->GetY();
        $pdf->Cell(0,2,'',0,1,'C',0);
        $pdf->SetX(20);
        $pdf->Cell(90,5,'Sri Senthur Murugan Speed parcal Service',0,1,'C',0);
        $pdf->SetX(20);
        $pdf->Cell(90,5,'H.O. : 648, Palaniyandavarpuram Colony,',0,1,'C',0);
        $pdf->SetX(20);
        $pdf->Cell(90,5,'SIVAKASI',0,1,'C',0);
        $pdf->SetX(20);
        $pdf->Cell(90,5,'Cell : 96882 09858, 73388 87566',0,0,'C',0);

        $pdf->SetY($starty);
        $pdf->Cell(0,2,'',0,1,'C',0);
        $pdf->SetX(110);
        $pdf->Cell(40,5,'LUGGAGE CHART NO.',0,0,'C',0);

        $pdf->SetY($starty);
        $pdf->Cell(0,2,'',0,1,'C',0);
        $pdf->SetX(150);
        $pdf->Cell(25,5,'Vechile No.',0,0,'C',0);
        $pdf->SetX(175);
        $pdf->Cell(25,5,':___________',0,1,'L',0);
        $pdf->SetX(150);
        $pdf->Cell(25,5,'Date.',0,0,'C',0);
        $pdf->SetX(175);
        $pdf->Cell(25,5,':___________',0,1,'L',0);

        $pdf->SetY($starty);
        $pdf->SetX(10);
        $pdf->cell(100,25,'',1,0,'L',0);

        $pdf->SetX(110);
        $pdf->Cell(40,25,'',1,0,'L',0);

        $pdf->SetX(150);
        $pdf->Cell(50,25,'',1,1,'L',0);

        $pdf->SetX(10);
        $pdf->Cell(10,7,'S.No',1,0,'C',0);
        $pdf->SetX(20);
        $pdf->Cell(30,7,'L.R.No.',1,0,'C',0);
        $pdf->SetX(50);
        $pdf->Cell(25,7,'To',1,0,'C',0);
        $pdf->SetX(75);
        $pdf->Cell(35,7,'Consignor',1,0,'C',0);
        $pdf->SetX(110);
        $pdf->Cell(35,7,'Consignee',1,0,'C',0);
        $pdf->SetX(145);
        $pdf->Cell(35,7,'Articles',1,0,'C',0);
        $pdf->SetX(180);
        $pdf->Cell(20,7,'NO.',1,1,'C',0);

        $pdf->SetFont('Arial','',8);
    }

    $pdf->SetY($y_axis);
    $pdf->SetX(10);
    $pdf->Cell(10,225,'',1,0,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(30,225,'',1,0,'C',0);
    $pdf->SetX(50);
    $pdf->Cell(25,225,'',1,0,'C',0);
    $pdf->SetX(75);
    $pdf->Cell(35,225,'',1,0,'C',0);
    $pdf->SetX(110);
    $pdf->Cell(35,225,'',1,0,'C',0);
    $pdf->SetX(145);
    $pdf->Cell(35,225,'',1,0,'C',0);
    $pdf->SetX(180);
    $pdf->Cell(20,225,'',1,1,'C',0);

    $end_sy = $pdf->GetY();
    $pdf->Cell(60,4,'',0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(30,5,'Name Of the Driver',0,0,'L',0);
    $pdf->SetX(40);
    $pdf->Cell(60,5,':',0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(30,5,'Driver Signature',0,0,'L',0);
    $pdf->SetX(40);
    $pdf->Cell(60,5,':_________________________________',0,1,'L',0);

    $pdf->SetY($end_sy);
    $pdf->Cell(30,10,'',0,1,'L',0);
    $pdf->SetX(100);
    $pdf->Cell(30,5,'Prepared by',0,0,'C',0);

    $pdf->SetY($end_sy);
    $pdf->Cell(70,10,'',0,1,'L',0);
    $pdf->SetX(130);
    $pdf->Cell(70,5,'Parcal/ Authority/ Signature',0,1,'C',0);

    $pdf->SetY($end_sy);
    $pdf->SetX(10);
    $pdf->cell(90,17,'',1,0,'L',0);

    $pdf->SetX(100);
    $pdf->Cell(30,17,'',1,0,'L',0);

    $pdf->SetX(130);
    $pdf->Cell(70,17,'',1,1,'L',0);
    

    $pdf->OutPut();

    ?>
