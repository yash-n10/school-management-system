<?php
    include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGenerator.php');
    include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGeneratorPNG.php');
    include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGeneratorSVG.php');
    include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGeneratorHTML.php');
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
    $generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG();
    $generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
?>

<!DOCTYPE html>
<html>
<head>
	<title>I-Card</title>
	<style type="text/css">
		.row
		{
			width: 100%;
			height: 233px;
				
		}
		.col-md-6
		{
			width: 20%;
			height: 210px;
			border:1px solid #000;
			border-radius: 5px;
		}
	</style>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
</head>
<body>
	<div class="container">
		<?php
		$i=1;
		foreach ($students as $key => $value) {

			
			$f_name =$value->first_name;
			$m_name =$value->middle_name;
			$l_name =$value->last_name;
			$class =$value->class_id;
			$section =$value->section_id;
			$name = $f_name.' '.$m_name.' '.$l_name;
			$clas = $this->dbconnection->select("class", "class_name", "status='Y' AND id=$class");
			$sec = $this->dbconnection->select("section", "sec_name", "status='Y' AND id=$section");
		?>
		<div class="row">
			<div class="col-md-6" style="position: absolute;margin-left:20%;">				
				<div class="header" style="height: 19px;text-align: center;font-size:12px;">
					<h4 style="padding: 0px 0px 0px 0px;margin-top: 2px;color: red;"><?php echo strtoupper($school[0]->description);?></h4>
				</div>	
				<hr>
				<div class="content">
					<center>
						<img src="assets/img/2.JPG" style="width:50px;height:50px;margin-bottom:10px;">
					</center>
					<div class="details" style="margin-left: 5px;height: 60px;line-height:0.9;font-size: 7px;">
						<b>NAME : </b>&nbsp;<span><?php echo strtoupper($name);?></span>
						<p><b>CLASS : </b>&nbsp;<span><?php echo $clas[0]->class_name;?></span></p>
						<p><b>SECTION : </b>&nbsp;<span><?php echo $sec[0]->sec_name;?></span></p>
						<p><b>ADMISSION NO. : </b>&nbsp;<span><?php echo $value->admission_no;?></span></p>
					</div>
				</div>
				<div class="sig">
					<div class="signature" style="margin-left:75px;">
							<p style="font-size:7px;"><b>Issuing Authority</b></p>
					</div>
				</div>
				<div class="footer" style="margin-bottom: 5px;">
					<div class="barcode" style="height: 20px;width: 10%;margin-left: 16px;">
	                    <?php
	                        $code = base64_encode($generatorPNG->getBarcode($value->admission_no, $generatorPNG::TYPE_CODE_39));
	                    ?>
	                    <img style="width: 110px;height: 20px;" src="data:image/png;base64,<?php echo $code;?>"> 
	                </div>
	            </div>
			</div>
			<div class="col-md-6" style="margin-left: 50%;">
				<div class="header_back" style="text-align: center;">
					<b style="font-size: 14px;">INSTRUCTIONS</b>
					<hr>
				</div>
				<div class="content_back" style="font-size: 8px;margin-left:-20px;">
					<ul>
						<li>This ID Card is Property of School and is non-transferable.</li>
						<li>For Security and Identification purpose, this card must be displayed as and when it is demanded.</li>
						<li>Loss or theft of the card must be immediately reported to the Issuing Authority.</li>	
						<li>For Security and Identification purpose, this card must be displayed as and when it is demanded.</li>					
					</ul>
				</div>
				<div class="footer_back" style="font-size: 7px;line-height:1.5;">
					<span>&nbsp;&nbsp;<b>ADDRESS :</b> &nbsp; <?php echo $school[0]->address;?></span>
					<p style="margin:  0px 0px 0px 0px;"><span>&nbsp;&nbsp;<b>CONTACT :</b> &nbsp; <?php echo $school[0]->phone;?></span></p>
					<p style="margin: 0px 0px 0px 0px;"><span>&nbsp;&nbsp;<b>E-MAIL :</b> &nbsp; <?php echo $school[0]->email;?></span></p>
				</div>	
			</div>
		</div>

		<div class="cut">
			<span>&#9986;----------------------------------------------------------------------------------------------------------------------------------</span> 
		</div>
		

		
		<?php $i++;}?>		
	</div>
</body>
</html>