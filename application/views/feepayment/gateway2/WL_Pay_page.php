<?php 
	/**
	 * This Is the Kit File To Be Included For Transaction Request
	 */
//ECHO ;
	include ($_SERVER['DOCUMENT_ROOT'].'/assets/gateway/AWLMEAPI.php');
	
	//create an Object of the above included class
	$obj = new AWLMEAPI();

	//create an object of Request Message
	$reqMsgDTO = new ReqMsgDTO(); 

	/* Populate the above DTO Object On the Basis Of The Received Values */
	// PG MID
//	$reqMsgDTO->setMid('WL0000000027698');//Test id
//	$reqMsgDTO->setMid('WL0000000006572');//Live id
	$reqMsgDTO->setMid($MID);//Live id
	// Merchant Unique order id
        // refrence_no_order_id
//	$reqMsgDTO->setOrderId(rand(10,10000));
	$reqMsgDTO->setOrderId($refrence_no_order_id);
	//Transaction amount in paisa format
	$reqMsgDTO->setTrnAmt($final_total*100);
	//Transaction remarks
	$reqMsgDTO->setTrnRemarks($description);
	// Merchant transaction type (S/P/R)
	$reqMsgDTO->setMeTransReqType('S');
	// Merchant encryption key
//	$reqMsgDTO->setEnckey('6375b97b954b37f956966977e5753ee6');//Test key
//        $reqMsgDTO->setEnckey('48b3ea074f36178c4f59c10bfd9c4416');//Live key
        $reqMsgDTO->setEnckey($EncKey);//Live key
	// Merchant transaction currency
	$reqMsgDTO->setTrnCurrency('INR');
	// Recurring period, if merchant transaction type is R
//	$reqMsgDTO->setRecurrPeriod($_REQUEST['recurPeriod']);
	// Recurring day, if merchant transaction type is R
//	$reqMsgDTO->setRecurrDay($_REQUEST['recurDay']);
	// No of recurring, if merchant transaction type is R
//	$reqMsgDTO->setNoOfRecurring($_REQUEST['numberRecurring']);
	// Merchant response URl
//	$reqMsgDTO->setResponseUrl('https://crm.feesclub.com/test_gateway/meTrnSuccess.php');
	$reqMsgDTO->setResponseUrl($return_url);
//        redirect(base_url().'student/respond?student_id=' .$student_id. '&admission_no='.$admission_no. '&total=' .$final_total. '&class_id=' .$class_code. '&school_id='.$school_id.'&months='.$months.'&init_mont='.$init_mont.'&fin_mont='.$fin_mont.'&year='.$year_val.'&half_yearly='.$half_yearly.'&max_sesion_id='.$max_sesion_id);

	// Optional additional fields for merchant
	$reqMsgDTO->setAddField1($product_code);
	$reqMsgDTO->setAddField2($student_id);
	$reqMsgDTO->setAddField3($refrence_no_order_id);
//	$reqMsgDTO->setAddField4($_REQUEST['addField4']);
//	$reqMsgDTO->setAddField5($_REQUEST['addField5']);
//	$reqMsgDTO->setAddField6($_REQUEST['addField6']);
//	$reqMsgDTO->setAddField7($_REQUEST['addField7']);
//	$reqMsgDTO->setAddField8($_REQUEST['addField8']);
	
	/* 
	 * After Making Request Message Send It To Generate Request 
	 * The variable `$urlParameter` contains encrypted request message
	 */
	 //Generate transaction request message
	$merchantRequest = "";
	
	$reqMsgDTO = $obj->generateTrnReqMsg($reqMsgDTO);
	
	if ($reqMsgDTO->getStatusDesc() == "Success"){
		$merchantRequest = $reqMsgDTO->getReqMsg();
	}
?>


<!--<form action="https://cgt.in.worldline.com/ipg/doMEPayRequest" method="post" name="txnSubmitFrm"> Test url-->

<form action="https://ipg.in.worldline.com/doMEPayRequest" method="post" name="txnSubmitFrm"> 
	<h4 align="center">Redirecting To Payment Please Wait..</h4>
	<h4 align="center">Please Do Not Press Back Button OR Refresh Page</h4>
	<input type="hidden" size="200" name="merchantRequest" id="merchantRequest" value="<?php echo $merchantRequest; ?>"  />
	<input type="hidden" name="MID" id="MID" value="<?php echo $reqMsgDTO->getMid(); ?>"/>
</form>
<script  type="text/javascript">
	//submit the form to the worldline
	document.txnSubmitFrm.submit();
</script>




