<?php 
//echo $admission_no;
$payment = array( 
			'channel' 		=> 10,
//			'account_id'            => 21984,
			'account_id'            => $MID,
                        'TransactionID'         => 9006003,
			'reference_no'          => $refrence_no_order_id,
			'amount'                => $final_total,
//			'description'           => "FeesClub Student Payment Total of ".$final_total."- Admission-N0 ".$admission_no."- Student ID ".$student_id."- Class ".$class_code."- from_month ".$init_mont."- to_month ".$fin_mont."- year ".$year_val,
			'description'           => "$description",

//			'return_url'            => base_url() . 'student/respond?student_id=' .$student_id. '&admission_no='.$admission_no. '&total=' .$final_total. '&class_id=' .$class_code. '&school_id='.$school_id.'&months='.$months.'&init_mont='.$init_mont.'&fin_mont='.$fin_mont.'&year='.$year_val.'&half_yearly='.$half_yearly.'&max_sesion_id='.$max_sesion_id,
			'return_url'            => "$return_url",
			'mode'			=> 'LIVE',
			'name'			=> $name,
			'email'			=> $email,			
			'address'		=> 'India',
			'city'			=> 'Mumbai',
			'state'			=> 'MH',
			'postal_code'           => '400069',
			'country'		=> 'IND',
			'phone'			=> '2211112222',
			'ship_name'		=> $name,
			'ship_address'          => 'India',
			'ship_city'		=> 'Mumbai',
			'ship_state'            => 'MH',
			'ship_postal_code'      => '400069',
			'ship_country'          => 'IND',
			'ship_phone'            => '2211112222'
		);

		$HASHING_METHOD = 'sha512'; // md5,sha1
		$ACTION_URL = "https://secure.ebs.in/pg/ma/payment/request";

 // 		$hashData = 'e643efc7cd6cb3a61bbed0842644dd76';
		$hashData = $EncKey;

		ksort($payment);
		foreach ($payment as $key => $value){
			if (strlen($value) > 0) {
				$hashData .= '|'.$value;
			}
		}
		if (strlen($hashData) > 0) {
			$secureHash = strtoupper(hash($HASHING_METHOD, $hashData));
		}
	        if($final_total==0)
		{
                    header("Location: ".site_url("student"));
                }
?>
          <html>
			<body onLoad="document.payment.submit();">
				<h3>Please wait, redirecting to process payment..</h3>
				<form action="<?php echo $ACTION_URL;?>" name="payment" method="POST">
					<?php
						foreach($payment as $key => $value) {
					?>
					<input type="hidden" value="<?php echo $value;?>" name="<?php echo $key;?>"/>
					<?php
						}
					?>
					<input type="hidden" value="<?php echo $secureHash; ?>" name="secure_hash"/>
				</form>
			</body>
	</html>
        <script  type="text/javascript">
	//submit the form to the worldline
	document.payment.submit();
        </script>