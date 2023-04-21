<?php
define('FPDF_FONTPATH','font/');
require('fpdf_thai.php');

class PDF extends FPDF_TH
{
	function Header()
	{
		$this->SetFont('AngsanaNew','B',15);
		$this->SetY(10);
		$this->SetX(20);
		$this->Ln(7);
		$this->Ln(7);
		$this->SetX(10);
		$this->SetFontSize(14);
		$this->TCell(0,0,'�к�ʹѺʹع��õѴ�Թ㨡���ç���ҧ�ͧ�Թ��Ҥ���ѧ�ˡó��ҹ����ѹ',0,0,'L');
		$this->SetX(-50);
		$this->SetFontSize(14);
		$this->TCell(0,0,'�ѹ������� : '.date("d/m/y H:i"),0,0,'L');
		$this->SetLineWidth(0.4);
		$this->Line(10,30,290,30);
	}
	function Footer()
	{
		$this->SetLineWidth(0.4);
		$this->Line(10,196,290,196);
		$this->SetY(-10);
		$this->SetFont('AngsanaNew','',14);
		$this->TCell(0,0,'˹�� '.$this->PageNo().'/{nb}',0,0,'R');
	}
} //End class

//Create new pdf file
$pdf=new PDF('L');

//Set thai font
$pdf->SetThaiFont();

$pdf->AliasNbPages();

//Open file
$pdf->Open();

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 60;

//Set Row Height
$row_height = 6;

function getNowDateTh() {
	$yy = date('Y')+543;
	$mm = date('m');
	$dd = date('d');
	return $yy.'-'.$mm.'-'.$dd;
}
$pdf->Ln(7);
$pdf->Ln(7);
$pdf->Ln(7);
$pdf->SetFontSize(20);
$pdf->SetY(35);
$pdf->SetX(20);
$pdf->TCell(0,0,' ',0,0,'C');
$pdf->Ln(7);
$pdf->SetX(20);
$pdf->TCell(0,0,'��§ҹ�����ž�ѡ�ҹ�ˡó��ҹ����ѹ �ӡѴ',0,0,'C');
$pdf->Ln(7);


//���ѧ���蹷ҧ��ҹ����

		$pdf->SetFontSize(14);
		$pdf->TCell(0,0,'��Ш��ѹ   '."$printdate ".'���   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

//print column titles for the actual page

$pdf->SetFillColor(232,232,232);
$pdf->SetFontSize(16);
$pdf->SetY($y_axis_initial);
$pdf->SetX(10);

			$pdf->TCell(15,6,'�ӴѺ���',1,0,'C',1);
			$pdf->TCell(25,6,'���ʾ�ѡ�ҹ',1,0,'C',1);
			$pdf->TCell(45,6,'����-���ʡ��',1,0,'C',1);
			$pdf->TCell(120,6,'�������',1,0,'C',1);
			$pdf->TCell(30,6,'���˹�',1,0,'C',1);


$y_axis = $y_axis_initial + $row_height;
//initialize counter
$i = 0;
$r=1;
$count = 0;
//$totalPrice=0;
//Set maximum rows per page
$max = 20;
	if ($txtsearch == ""){
				    for($i=0;$i<=10;$i++){

		if ($i == $max){
			//Set $i variable to 0 (first row)
			$i = 0;

			$pdf->AddPage();
			$pdf->SetFontSize(16);
			$pdf->SetY(35);
			$pdf->SetX(20);
			//$pdf->TCell(0,0,'�ѹ��� '.$sellpro_date ,0,0,'L');
			$pdf->Ln(7);
			$pdf->Ln(7);
			$pdf->SetFontSize(20);
			$pdf->SetY(35);
			$pdf->SetX(20);
			$pdf->TCell(0,0,' ',0,0,'C');
			$pdf->Ln(7);
			$pdf->SetX(20);
			$pdf->TCell(0,0,'��§ҹ�����ž�ѡ�ҹ�ˡó��ҹ����ѹ �ӡѴ',0,0,'C');
			$pdf->Ln(7);

				$pdf->SetFontSize(14);
				$pdf->TCell(0,0,'��Ш��ѹ   '."$printdate ".'���   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

			//print column titles for the actual page

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFontSize(16);
			$pdf->SetY($y_axis_initial);
			$pdf->SetX(10);
			$pdf->TCell(15,6,'�ӴѺ���',1,0,'C',1);
			$pdf->TCell(25,6,'���ʾ�ѡ�ҹ',1,0,'C',1);
			$pdf->TCell(45,6,'����-���ʡ��',1,0,'C',1);
			$pdf->TCell(120,6,'�������',1,0,'C',1);
			$pdf->TCell(30,6,'���˹�',1,0,'C',1);



			//Go to next row
			$y_axis = $y_axis_initial + $row_height;
			
			//Set $i variable to 0 (first row)
			$i = 0;
		}

		$pdf->SetFontSize(14);
		$pdf->SetY($y_axis);
		$pdf->SetX(10);
		$pdf->TCell(15,6,'22222',1,0,'C');
		$pdf->TCell(25,6,'11111',1,0,'C');
		$pdf->TCell(45,6,'33333',1,0,'L');


		//echo $objprovince->province_name;
		$address='55555++++';

		$pdf->TCell(120,6,$address,1,0,'L');

		
		$pdf->TCell(30,6,'6666666+',1,0,'L');


		//Go to next row
		$y_axis = $y_axis + $row_height;
		$i = $i + 1;
		$r = $r + 1;
		$count = $count + 1;
		//$totalPrice=$totalPrice+$price;
			}
	} //End while

//������ѧ���� SearchByName
if ($txtsearch != ""){
	$objper->SearchByName($txtsearch);
			while($objper->GetRecord()){
	 			$i=$i+1;

		if ($i == $max){
			//Set $i variable to 0 (first row)
			$i = 0;

			$pdf->AddPage();
			$pdf->SetFontSize(16);
			$pdf->SetY(35);
			$pdf->SetX(20);
			//$pdf->TCell(0,0,'�ѹ��� '.$sellpro_date ,0,0,'L');
			$pdf->Ln(7);
			$pdf->Ln(7);
			$pdf->SetFontSize(20);
			$pdf->SetY(35);
			$pdf->SetX(20);
			$pdf->TCell(0,0,' ',0,0,'C');
			$pdf->Ln(7);
			$pdf->SetX(20);
			$pdf->TCell(0,0,'��§ҹ�����ž�ѡ�ҹ�ˡó��ҹ����ѹ �ӡѴ',0,0,'C');
			$pdf->Ln(7);

				$pdf->SetFontSize(14);
				$pdf->TCell(0,0,'��Ш��ѹ   '."$printdate ".'���   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

			//print column titles for the actual page

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFontSize(16);
			$pdf->SetY($y_axis_initial);
			$pdf->SetX(10);
			$pdf->TCell(15,6,'�ӴѺ���',1,0,'C',1);
			$pdf->TCell(25,6,'���ʾ�ѡ�ҹ',1,0,'C',1);
			$pdf->TCell(45,6,'����-���ʡ��',1,0,'C',1);
			$pdf->TCell(120,6,'�������',1,0,'C',1);
			$pdf->TCell(30,6,'���˹�',1,0,'C',1);



			//Go to next row
			$y_axis = $y_axis_initial + $row_height;
			
			//Set $i variable to 0 (first row)
			$i = 0;
		}

		$pdf->SetFontSize(14);
		$pdf->SetY($y_axis);
		$pdf->SetX(10);
		$pdf->TCell(15,6,$r,1,0,'C');
		$pdf->TCell(25,6,$objper->per_id,1,0,'C');
		$pdf->TCell(45,6,$objper->per_fname.'      '.$objper->per_sname,1,0,'L');

		$objprovince->SProvince($objper->province_id);  
		$objprovince->GetRecord();
		//echo $objprovince->province_name;
		$address='5555555++';

		$pdf->TCell(120,6,$address,1,0,'L');

		$objposition->SPosition($objper->position_id);  
		$objposition->GetRecord();
		$pdf->TCell(30,6,$objposition->position_name,1,0,'L');

		//Go to next row
		$y_axis = $y_axis + $row_height;
		$i = $i + 1;
		$r = $r + 1;
		$count = $count + 1;
		//$totalPrice=$totalPrice+$price;
			}
	} //End while
//���ѧ����SearchByName

//������ѧ���� SearchByID
if ($txtsearch != ""){
	$objper->SearchByID($txtsearch);
			while($objper->GetRecord()){
	 			$i=$i+1;

		if ($i == $max){
			//Set $i variable to 0 (first row)
			$i = 0;

			$pdf->AddPage();
			$pdf->SetFontSize(16);
			$pdf->SetY(35);
			$pdf->SetX(20);
			//$pdf->TCell(0,0,'�ѹ��� '.$sellpro_date ,0,0,'L');
			$pdf->Ln(7);
			$pdf->Ln(7);
			$pdf->SetFontSize(20);
			$pdf->SetY(35);
			$pdf->SetX(20);
			$pdf->TCell(0,0,' ',0,0,'C');
			$pdf->Ln(7);
			$pdf->SetX(20);
			$pdf->TCell(0,0,'��§ҹ�����ž�ѡ�ҹ�ˡó��ҹ����ѹ �ӡѴ',0,0,'C');
			$pdf->Ln(7);

				$pdf->SetFontSize(14);
				$pdf->TCell(0,0,'��Ш��ѹ   '."$printdate ".'���   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

			//print column titles for the actual page

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFontSize(16);
			$pdf->SetY($y_axis_initial);
			$pdf->SetX(10);
			$pdf->TCell(15,6,'�ӴѺ���',1,0,'C',1);
			$pdf->TCell(25,6,'���ʾ�ѡ�ҹ',1,0,'C',1);
			$pdf->TCell(45,6,'����-���ʡ��',1,0,'C',1);
			$pdf->TCell(120,6,'�������',1,0,'C',1);
			$pdf->TCell(30,6,'���˹�',1,0,'C',1);



			//Go to next row
			$y_axis = $y_axis_initial + $row_height;
			
			//Set $i variable to 0 (first row)
			$i = 0;
		}

		$pdf->SetFontSize(14);
		$pdf->SetY($y_axis);
		$pdf->SetX(10);
		$pdf->TCell(15,6,$r,1,0,'C');
		$pdf->TCell(25,6,$objper->per_id,1,0,'C');
		$pdf->TCell(45,6,$objper->per_fname.'      '.$objper->per_sname,1,0,'L');

		$objprovince->SProvince($objper->province_id);  
		$objprovince->GetRecord();
		//echo $objprovince->province_name;
		$address='8888+++';

		$pdf->TCell(120,6,$address,1,0,'L');

		$objposition->SPosition($objper->position_id);  
		$objposition->GetRecord();
		$pdf->TCell(30,6,$objposition->position_name,1,0,'L');

		//Go to next row
		$y_axis = $y_axis + $row_height;
		$i = $i + 1;
		$r = $r + 1;
		$count = $count + 1;
		//$totalPrice=$totalPrice+$price;
			}
	} //End while
//���ѧ����SearchByID

	$pdf->SetFontSize(16);
	$pdf->SetY($y_axis);
	$pdf->TCell(235,6,'�����ѡ�ҹ������  '.$count.'  ��',1,0,'R',1);
//Create file
$pdf->Output();
?>