<?php

    require_once('../fpdf/AlphaPDF.php');
    $pdf = new AlphaPDF('L','mm','A5');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false);
    // $pdf->SetDrawColor(223,36,67);
    // $pdf->SetTextColor(223,36,67);
	$pdf->SetTitle('Receipt');

    if(file_exists('../images/topgodimage.png')){
        $pdf->Image('../images/topgodimage.png',45,10,120,7);
    }
    $pdf->SetFont('Arial','B',10);
    $pdf->SetY(14);
    $pdf->SetX(150);
    $pdf->Cell(0,5,'Prop.: S.SELVAM',0,1,'C',0);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetY(18);
    $pdf->SetX(10);
    $pdf->Cell(0,5,'Sri Senthur Murugan Speed Parcal Service',0,1,'C',0);
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(10);
    $pdf->Cell(0,5,'HO : 648, Palaniyandavarpuram Colony, SIVAKASI. Cell : 96882 09858,73388 87566',0,1,'C',0);
    $pdf->SetX(10);
    $pdf->Cell(0,5,'Sivakasi to Karur, Velayuthampalayam, Paramathi Velur, Kodumudi, Mayanur, Kulithalai, Puliyur,',0,1,'C',0);
    $pdf->SetX(10);
    $pdf->Cell(0,5,'Chinnadharapuram, Mulanur, Kangayam, vellaikkovil',0,1,'C',0);

    $pdf->SetX(10);
    $pdf->Cell(0,5,'Karur : 99650 37850, Erode : 95784 18755, Namakkal : 78451 50160, Salem : 74189 09858',0,1,'C',0);
    $pdf->SetX(10);
    $pdf->Cell(0,5,'Tiruchengode : 93636 09858',0,1,'C',0);

    $pdf->Cell(0,2,'',0,0,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(20,5,'No.',0,0,'L',0);
    $pdf->SetX(30);
    $pdf->Cell(40,5,'58450',0,0,'L',0);

    $pdf->SetX(140);
    $pdf->Cell(15,5,'Date',0,0,'R',0);
    $pdf->SetX(155);
    $pdf->Cell(40,5,':____________',0,1,'L',0);

    $pdf->Cell(0,3,'',0,1,'C',0);
    $start_y = $pdf->GetY();
    $pdf->SetX(10);
    $pdf->Cell(30,7,'Consignor : M/s.',0,0,'L',0);
    $pdf->SetX(40);
    $pdf->Cell(55,7,'___________________________',0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(85,7,'__________________________________________',0,0,'L',0);

    $pdf->Line(96,55,96,71);
    $pdf->Line(98,55,98,71);

    $pdf->SetY($start_y);
    $pdf->SetX(100);
    $pdf->Cell(30,7,'Consignor : M/s.',0,0,'L',0);
    $pdf->SetX(130);
    $pdf->Cell(55,7,'__________________________',0,1,'L',0);
    $pdf->SetX(100);
    $pdf->Cell(85,7,'__________________________________________',0,1,'L',0);

    $pdf->Cell(0,1,'',0,1,'C',0);
    $sy = $pdf->GetY();
    $pdf->SetX(10);
    $pdf->Cell(20,5,'No Of',0,1,'C',0);
    $pdf->SetX(10);
    $pdf->Cell(20,5,'Articles',0,0,'C',0);
    $pdf->SetY($sy);
    $pdf->Cell(20,10,'',1,0,'C',0);
    $pdf->SetX(30);
    $pdf->Cell(70,5,'Description if Goods',0,1,'C',0);
    $pdf->SetX(30);
    $pdf->Cell(70,5,'(Said to Contain)',0,0,'C',0);
    $pdf->SetY($sy);
    $pdf->SetX(30);
    $pdf->Cell(70,10,'',1,0,'C',0);
    $pdf->SetX(100);
    $pdf->Cell(20,5,'Weight',0,1,'C',0);
    $pdf->SetX(100);
    $pdf->Cell(20,5,'Kg.',0,0,'C',0);
    $pdf->SetY($sy);
    $pdf->SetX(100);
    $pdf->Cell(20,10,'',1,0,'C',0);
    $pdf->SetX(120);
    $pdf->Cell(30,5,'',0,1,'C',0);
    $pdf->SetX(120);
    $pdf->Cell(30,5,'',0,0,'C',0);
    $pdf->SetY($sy);
    $pdf->SetX(120);
    $pdf->Cell(30,10,'',1,0,'C',0);
    $pdf->SetX(150);
    $pdf->Cell(45,5,'Freight',0,1,'C',0);
    $pdf->SetX(150);
    $pdf->Cell(30,5,'Rs.',0,0,'C',0);
    $pdf->SetX(180);
    $pdf->Cell(20,5,'Ps.',0,0,'C',0);
    $pdf->SetY($sy);
    $pdf->SetX(150);
    $pdf->Cell(50,10,'',1,1,'C',0);
    $pdf->SetFont('Arial','',8);

    $y_axis = $pdf->GetY();

    $last_y1 = $pdf->GetY();
    $empty_y1 = $pdf->GetY();
    $pdf->SetY($empty_y1 +40);

    $pdf->SetFont('Arial','B',12);
    $pdf->SetX(30);
    $pdf->Cell(30,10,'Topay / Paid',1,1,'C',0);

    $pdf->SetY($last_y1);

    $last_y = $pdf->GetY();
    $empty_y = $pdf->GetY();
    $pdf->SetY($empty_y +26);

    $pdf->SetFont('Arial','',9);
    $pdf->SetX(120);
    $pdf->cell(30,6,'Loading Rs.',0,1,'R',0);
    $pdf->SetX(120);
    $pdf->cell(30,6,'Unloading Rs.',0,1,'R',0);
    $pdf->SetX(120);
    $pdf->cell(30,6,'G.c.Cha.',0,0,'R',0);
    $pdf->SetX(150);
    $pdf->cell(30,6,'',1,0,'R',0);
    $pdf->SetX(180);
    $pdf->Cell(20,6,'',1,1,'R',0);
    $pdf->SetX(120);
    $pdf->cell(30,6,'Total',0,0,'R',0);
    $pdf->SetX(150);
    $pdf->cell(30,6,'',1,0,'R',0);
    $pdf->SetX(180);
    $pdf->Cell(20,6,'',1,1,'R',0);
    $pdf->SetY($last_y);

    
    $pdf->SetY($y_axis);
    $pdf->SetX(10);
    $pdf->Cell(20,50,'',1,0,'C',0);
    $pdf->SetX(30);
    $pdf->Cell(70,50,'',1,0,'C',0);
    $pdf->SetX(100);
    $pdf->Cell(20,50,'',1,0,'C',0);
    $pdf->SetX(120);
    $pdf->Cell(30,50,'',1,0,'C',0);
    $pdf->SetX(150);
    $pdf->Cell(30,50,'',1,0,'C',0);
    $pdf->SetX(180);
    $pdf->Cell(20,50,'',1,1,'C',0);

   
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(10);
    $pdf->Cell(0,6,'For SRI SENDHUR MURUGAN SERVICE',0,1,'R',0);
    

    $pdf->OutPut();

?>