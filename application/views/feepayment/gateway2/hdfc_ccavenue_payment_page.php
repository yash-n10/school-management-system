<html>
    <head>
    <!--<title> Non-Seamless-kit</title>-->
    </head>
    <body>
    <center>

        <?php
//        include('Crypto.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/Crypto.php');



        $merchant_data = '';
        $payment_data = array(
            'tid'           => '',
//            'merchant_id'   => 171467,
            'merchant_id'   => $MID,
            'order_id'      => $refrence_no_order_id, // Wi@JH0DAVrd is the code to identify the account no
            'amount'        => $final_total,
            'currency'      => 'INR',
            'redirect_url'  => "$return_url",
            'cancel_url'    => "$return_url",
            'language'      => 'EN',
            'billing_name' => $name,
            'billing_email' => $email,
            'billing_address' => '',
            'billing_city' => '',
            'billing_state' => '',
            'billing_zip' => '',
            'billing_country' => '',
            'billing_tel' => '',
            'delivery_name' => $name,
            'delivery_address' => '',
            'delivery_city' => '',
            'delivery_state' => '',
            'delivery_zip' => '',
            'delivery_country' => '',
            'delivery_tel' => '',
            'merchant_param1' => "$fee_transac_id",
            'merchant_param2' => "$fee_action_id",
            'merchant_param3' => "$pgw",
            'merchant_param4' => "",
        );
//        $working_key = '0230E900A4E51F12C51408158BF0B515'; //Shared by CCAVENUES
        $working_key = $EncKey; //Shared by CCAVENUES
//        $access_code = 'AVXF77FC13CH70FXHC'; //Shared by CCAVENUES
        $access_code = $AccessCode; //Shared by CCAVENUES


        foreach ($payment_data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

//        print_r($merchant_data);

        $encrypted_data = encrypt($merchant_data, $working_key); // Method for encrypting the data.
        ?>
        
        <?php if($Live_Test=='TEST') { 
            
            $action_url="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }else{
            
            $action_url="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }
        ?>
       
        
        <form method="post" name="redirect" action="<?php echo $action_url;?>">
      
            <?php
            echo "<input type=hidden name=encRequest value=$encrypted_data>";
            echo "<input type=hidden name=access_code value=$access_code>";
            ?>
        </form>
    </center>

    <script language='javascript'>document.redirect.submit();</script>
</body>
</html>