<style type="text/css">
	@page { margin-left: 0px;margin-right: 0px;margin-bottom: 0px;margin-top: 15.5px; } body { margin-left: 0px;margin-right: 0px;margin-bottom: 0px;margin-top: 15.5px; }
	
</style>
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
	<title>Book Barcode</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		.row
		{
			width: 100%;

		}
		.col-md-3
		{
			width: 20%;
			height: 40px;
			border:1px solid #000;
			border-radius: 5px;
		}
		div.grid      { width: 710px;height: 85px;}
		div.grid div  { float: left; height: 40px; }
		div.col100    { width: 160px;height:70px;}		
		div.clear     { clear: both; }
	</style>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
</head>
<body>
	
	<div class="container" style="margin-left: 58px !important;">
		<?php
		$i=0;
		$j=0;
		// $book= array('1' =>1 ,'2'=>2 );
		foreach ($book as $key => $value) 
		{
			$data = $this->db->query("SELECT acc_no FROM book_detail WHERE id=$value")->result();
			$acc_no = $data[0]->acc_no;
		if($i%4==0)
		{

	        $j++;
	        if($j%11==0){
	        echo '<br>';
}
// else{
	        echo '<div class="grid" style="margin-top:10.1px !important; ">';
	    // }
// 	        echo '<div class="grid" style="margin-top:12px !important;">';

// }
// 	     //    if ($j>4) {
	     //    echo '<div class="grid" style="margin-top:10px !important;">';
	     //    }
	     //    elseif ($j%10==0) {
	        	
	     //    echo '<div class="grid" style="margin-top:15px;">';
	     //    }
		    // else{
	     //    echo '<div class="grid">';
	   		// }
	    }
	    $i++;
		?>	
		    <div class="col100" style="<?php if ($i==2 or $i==4 or $i==3) {?>margin-left:25px;<?php }elseif ($i==1) {
		    	?>margin-left:-15px;<?php }?>">
		    <!-- <div class="col100"> -->
		    	<div class="barcode" style="width: 10%;">
                    <?php
                        $code = base64_encode($generatorPNG->getBarcode( $acc_no, $generatorPNG::TYPE_CODE_39));
                    ?>
                    <img style="width: 140px;height: 30px;" src="data:image/png;base64,<?php echo $code;?>">  
                    <figcaption style="font-size:12px;margin-left:35px;"><?php echo $acc_no;?></figcaption>                                      
                </div>
			</div>		
		<?php
		    if($i%4==0)
		    {
		        echo '</div>';
		        $i = 0;
		    }
		}
	    ?>		
	</div>
</body>
</html>