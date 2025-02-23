<?php

$ci =& get_instance();

 $ci->load->model('fee_model');
	 //$receipt_id;
	 $receiptdata = $ci->fee_model->getReceiptData($receipt_id);
	 
	// print_r($receiptdata);
	 
	 extract($receiptdata);
	 
	 $cat_data = $ci->fee_model->getfeecategory($cat_id);
	 
	 extract($cat_data);
	 
	 $gtotal = number_format(($fee_collection_amount + $fee_collection_late_charge),2);
	 
	 
	 $pydate = date("M d, Y",strtotime($fee_collection_date));
	 
	 $paymode = $fee_collection_mode;
	 
	 if($paymode == 0){
		 
		 $mode_val= "Cash";
	 } if($paymode == 1){
		 $paymode == "Cheque";
	 }
	 
	 $system_name	=	$this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
	 
	 $system_email	=	$this->db->get_where('settings' , array('type' => 'system_email'))->row()->description;
	 
	 $system_address	=	$this->db->get_where('settings' , array('type' => 'address'))->row()->description;

?>

<table class="currentTable" data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="TopLogoModule" align="center" bgcolor="#3b485b" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td align="center">
									<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:668px;" align="center" height="30">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td align="center">
									<table class="table600Min" data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:668px;" align="center">
													<table data-bgcolor="CredentialsBGColor" class="table600" data-border-bottom-color="borderColor" style="border-bottom:1px solid #dde5f1; border-radius:6px 6px 0 0;" align="center" bgcolor="#fdfdfd" width="629" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td class="table600st" style="min-width:629px;" align="left" width="629">
																	<table class="table600Logo" align="left" width="260" border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<td>
																					<table class="centerize" data-border-bottom-color="LogoDivider-OnMobile" style="border-bottom-color:#67bffd; margin-left:0;" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
                                                                                        	<tr>
                                                                                            <td class="esFrMb" height="15">
                                                                                            </tr>
																							<tr>
																								<td class="esFrMb" width="30">
																								</td>
																								<td style="line-height:1px;" align="center">
																									 <a href="#" style="text-decoration: none;"><img src="/uploads/logo.png" style="display: block;text-decoration: none;border: none;" alt="Logo Image" align="top" border="0" /></a>
																								</td>
																								<td class="esFrMb" width="30">
																								</td>
																							</tr>
                                                                                            <tr>
                                                                                            <td class="esFrMb" height="15">
                                                                                            </tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																	<table class="table600Menu" align="right" width="348" border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;
																					
																				</td>
																			</tr>
                                                                            <tr>
																				<td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;
																					
																				</td>
																			</tr>
                                                                            <tr>
																				<td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;
																					
																				</td>
																			</tr>
                                                                            <tr>
																				<td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;
																					
																				</td>
																			</tr>
																			<tr>
																				<td class="AnnouncementTD editable" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="AnnouncementLink" data-color="AnnouncementTXT" style="color: #425065;font-family: sans-serif;font-size: 18px;text-align: right;line-height: 150%;font-weight: bold;letter-spacing: 2px;" align="right" valign="middle" width="318" height="80">
																					<a href="#" style="text-decoration: none;color: #425065;" data-color="AnnouncementLink"></a>RECEIPT
																				</td>
																				<td class="esFrMb" width="30">
																				</td>
																			</tr>
																			<tr>
																				<td colspan="2" style="font-size:0;line-height:0;" height="10">&nbsp;
																					
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="WelcomeTextModule" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="table600st" style="min-width:668px;" align="center">
									<table data-bgcolor="CredentialsBGColor" class="table600Min" style="min-width:629px;" align="center" bgcolor="#fdfdfd" width="629" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:629px;">
													<table class="table600" data-border-bottom-color="borderColor" style="border-bottom:1px solid #dde5f1;" align="left" width="629" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td align="center">
																	<table border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<td align="center">
																					<table class="table600" width="629" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="vrtclAlgn2" height="25">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz" width="30">
																								</td>
																								<td class="RegularTextTD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #727e8d;font-family: sans-serif;font-size: 13px;font-weight: lighter;text-align: left;line-height: 23px;">
																									Dear <?php echo $fname ?>,<br />Your payment amount <strong style="font-weight: bold"> <?php echo $fee_collection_amount ?></strong> towards <span style="font-weight: bold"><?php echo $fee_category.' - '.$pname ?></span> processed successfuly for your child <span style="font-weight: bold"><?php echo $sname ?></span> on <span style="font-weight: bold"><?php echo $fee_collection_added_date ?></span>.
																								</td>
																								<td class="wz" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="vrtclAlgn" height="25">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="ReceiptCredentialsModule-2COL" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="table600st" style="min-width:668px;" align="center">
									<table class="table600Min" style="min-width:628px;" align="center" width="629" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:628px;">
													<table data-bgcolor="CredentialsBGColor" class="table600" align="left" bgcolor="#fdfdfd" width="629" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td>
																	<table data-bgcolor="CredentialsBGColor" align="center" bgcolor="#fdfdfd" border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<th class="stack" style="margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" data-border-bottom-color="borderColor" width="314">
																					<table class="table600" align="center" width="314" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz" width="30">
																								</td>
																								<td align="center" valign="top">
																									<table class="tableTxt" align="left" width="252" border="0" cellpadding="0" cellspacing="0">
																										<tbody>
																											<tr>
																												<td rowspan="2" style="line-height:1px;" align="center" valign="top" width="25">
																													<img src="/uploads/email/invoice-icon-20x20.png" style="display:block;" alt="IMG" border="0" />
																												</td>
																												<td rowspan="2" style="font-size:0;line-height:0;" width="14">&nbsp;
																													
																												</td>
																												<td class="header2TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionCaptionLink" data-color="SectionCaptionTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;text-align: left;line-height: 19px;font-weight: lighter;" align="left" valign="top" width="211">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionCaptionLink"></a>Receipt Sent To
																												</td>
																											</tr>
																											<tr>
																												<td class="RegularText4TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionInfoLink" data-color="SectionInfoTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: bold;text-align: left;line-height: 23px;" align="left" valign="top" width="179">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionInfoLink"></a><?php echo $fname ?>
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="10">&nbsp;
																													
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" class="RegularTextTD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #727e8d;font-family: sans-serif;font-size: 13px;font-weight: lighter;text-align: left;line-height: 23px;">
																													<?php echo $raddress; ?><br /><a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="RegularLink"><?php echo $rmail ?></a>
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																													
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																								<td class="wz" width="30">
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack" data-border-left-color="borderColor" data-border-bottom-color="borderColor" style="border-left:1px solid #dde5f1;border-bottom:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;" valign="top" width="314">
																					<table class="table600" align="center" width="314" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz" width="30">
																								</td>
																								<td align="center" valign="top">
																									<table class="tableTxt" align="left" width="252" border="0" cellpadding="0" cellspacing="0">
																										<tbody>
																											<tr>
																												<td rowspan="2" style="line-height:1px;" align="center" valign="top" width="25">
																													<img src="/uploads/email/home-icon-20x20.png" style="display:block;" alt="IMG" border="0" />
																												</td>
																												<td rowspan="2" style="font-size:0;line-height:0;" width="14">&nbsp;
																													
																												</td>
																												<td class="header2TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionCaptionLink" data-color="SectionCaptionTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;text-align: left;line-height: 19px;font-weight: lighter;" align="left" valign="top" width="211">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionCaptionLink"></a>Receipt Sent From
																												</td>
																											</tr>
																											<tr>
																												<td class="RegularText4TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionInfoLink" data-color="SectionInfoTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: bold;text-align: left;line-height: 23px;" align="left" valign="top" width="179">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionInfoLink"></a><?php echo $system_name; ?>.
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="10">&nbsp;
																													
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" class="RegularTextTD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #727e8d;font-family: sans-serif;font-size: 13px;font-weight: lighter;text-align: left;line-height: 23px;">
																													<?php echo $system_address ?><br /><a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="RegularLink"><?php echo $system_email ?></a>
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																													
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																								<td class="wz" width="30">
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="ReceiptCredentialsModule-3COL" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="table600st" style="min-width:668px;" align="center">
									<table class="table600Min" style="min-width:629px;" align="center" width="629" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:629px;">
													<table data-bgcolor="CredentialsBGColor" class="table600" align="left" bgcolor="#fdfdfd" width="629" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td align="left">
																	<table data-bgcolor="CredentialsBGColor" align="center" bgcolor="#fdfdfd" border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<th class="stack" style="margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" data-border-bottom-color="borderColor" width="209">
																					<table class="table600" align="center" width="209" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz" width="30">
																								</td>
																								<td align="center" valign="top">
																									<table class="tableTxt" align="left" width="145" border="0" cellpadding="0" cellspacing="0">
																										<tbody>
																											<tr>
																												<td rowspan="2" style="line-height:1px;" align="center" valign="top" width="25">
																													<img src="/uploads/email/number-icon-20x20.png" style="display:block;" alt="IMG" border="0" />
																												</td>
																												<td rowspan="2" style="font-size:0;line-height:0;" width="14">&nbsp;
																													
																												</td>
																												<td class="header2TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionCaptionLink" data-color="SectionCaptionTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;text-align: left;line-height: 19px;font-weight: lighter;" align="left" valign="top">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionCaptionLink"></a>Receipt No
																												</td>
																											</tr>
																											<tr>
																												<td class="RegularText4TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionInfoLink" data-color="SectionInfoTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: bold;text-align: left;line-height: 23px;" align="left" valign="top">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionInfoLink"></a>#<?php echo $fee_collection_receipt ?>
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																													
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																								<td class="wz" width="30">
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack" data-border-left-color="borderColor" data-border-bottom-color="borderColor" style="border-bottom:1px solid #dde5f1;border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;" width="209">
																					<table class="table600" align="center" width="209" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz" width="30">
																								</td>
																								<td align="center" valign="top">
																									<table class="tableTxt" align="left" width="145" border="0" cellpadding="0" cellspacing="0">
																										<tbody>
																											<tr>
																												<td rowspan="2" style="line-height:1px;" align="center" valign="top" width="25">
																													<img src="/uploads/email/date-icon-20x20.png" style="display:block;" alt="IMG" border="0" />
																												</td>
																												<td rowspan="2" style="font-size:0;line-height:0;" width="14">&nbsp;
																													
																												</td>
																												<td class="header2TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionCaptionLink" data-color="SectionCaptionTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;text-align: left;line-height: 19px;font-weight: lighter;" align="left" valign="top">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionCaptionLink"></a>Receipt Date
																												</td>
																											</tr>
																											<tr>
																												<td class="RegularText4TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionInfoLink" data-color="SectionInfoTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: bold;text-align: left;line-height: 23px;" align="left" valign="top">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionInfoLink"></a><?php echo $pydate ?>
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																													
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																								<td class="wz" width="30">
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack" data-border-left-color="borderColor" data-border-bottom-color="borderColor" style="border-bottom:1px solid #dde5f1;border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;" width="209">
																					<table class="table600" align="center" width="209" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz" width="30">
																								</td>
																								<td align="center" valign="top">
																									<table class="tableTxt" align="left" width="145" border="0" cellpadding="0" cellspacing="0">
																										<tbody>
																											<tr>
																												<td rowspan="2" style="line-height:1px;" align="center" valign="top" width="25">
																													<img src="/uploads/email/dollar-icon-20x20.png" style="display:block;" alt="IMG" border="0" />
																												</td>
																												<td rowspan="2" style="font-size:0;line-height:0;" width="14">&nbsp;
																													
																												</td>
																												<td class="header2TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionCaptionLink" data-color="SectionCaptionTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;text-align: left;line-height: 19px;font-weight: lighter;" align="left" valign="top">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionCaptionLink"></a>Receipt Total
																												</td>
																											</tr>
																											<tr>
																												<td class="RegularText4TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionInfoLink" data-color="SectionInfoTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: bold;text-align: left;line-height: 23px;" align="left" valign="top">
																													<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionInfoLink"></a><?php echo $fee_collection_amount ?>
																												</td>
																											</tr>
																											<tr>
																												<td colspan="3" style="font-size:0;line-height:0;" height="25">&nbsp;
																													
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																								<td class="wz" width="30">
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="FinalCalculationsModule-4ROWS" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="table600st" style="min-width:668px;" align="center">
									<table class="table600Min" style="min-width:629px;" align="center" width="629" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:629px;">
													<table data-bgcolor="CalculationsBGColor" class="table600" align="left" bgcolor="#eff3f7" width="629" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td align="left">
																	<table align="center" border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<th rowspan="4" class="stack4" data-bgcolor="CalculationsBGColor" data-border-bottom-color="borderColor" style="margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#eff3f7" width="349" height="100">
																					<table class="table60034" align="center" width="349" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="50">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td style="line-height:1px;" class="TDtable60034" align="center" width="347">
																									<img src="/uploads/email/sign.png" style="display:block;" alt="IMG" border="0" />
																								</td>
																							</tr>
																							<tr>
																								<td class="RegularText5TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">
																									<a href="#" data-color="RegularLink" style="text-decoration: none;color: #67bffd;"></a><?php echo $aname; ?><br />Accounts Manager<br />
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack3" data-bgcolor="CalculationsBGColor" data-border-bottom-color="borderColor" data-border-left-color="borderColor" style="border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#eff3f7" valign="top" width="139">
																					<table class="table60033" align="center" width="139" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz2" width="30">
																								</td>
																								<td class="RegularText5TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">
																									<a href="#" data-color="RegularLink" style="text-decoration: none;color: #67bffd;"></a>Sub Total
																								</td>
																								<td class="wz2" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack3" data-bgcolor="CalculationsBGColor" data-border-bottom-color="borderColor" data-border-left-color="borderColor" style="border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#eff3f7" valign="top" width="139">
																					<table class="table60033" align="center" width="139" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz2" width="30">
																								</td>
																								<td class="RegularText5TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">
																									<a href="#" data-color="RegularLink" style="text-decoration: none;color: #67bffd;"></a><?php echo $fee_collection_amount  ?>
																								</td>
																								<td class="wz2" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																			</tr>
																			<tr>
																				<th class="stack3" data-bgcolor="CalculationsBGColor" data-border-bottom-color="borderColor" data-border-left-color="borderColor" style="border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#eff3f7" valign="top" width="139">
																					<table class="table60033" align="center" width="139" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz2" width="30">
																								</td>
																								<td class="RegularText5TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">
																									<a href="#" data-color="RegularLink" style="text-decoration: none;color: #67bffd;"></a>Late Charges 
																								</td>
																								<td class="wz2" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack3" data-bgcolor="CalculationsBGColor" data-border-bottom-color="borderColor" data-border-left-color="borderColor" style="border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#eff3f7" valign="top" width="139">
																					<table class="table60033" align="center" width="139" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz2" width="30">
																								</td>
																								<td class="RegularText5TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">
																									<a href="#" data-color="RegularLink" style="text-decoration: none;color: #67bffd;"></a><?php echo $fee_collection_late_charge ?>
																								</td>
																								<td class="wz2" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																			</tr>
																			
																			<tr>
																				<th class="stack3" data-bgcolor="ThemeColorBG" data-border-bottom-color="borderColor" data-border-left-color="borderColor" style="border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#67bffd" valign="top" width="139">
																					<table class="table60033" align="center" width="139" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz2" width="30">
																								</td>
																								<td data-bgcolor="ThemeColorBG" class="header5TD" data-link-style="text-decoration:none; color:#ffffff;" data-link-color="ReceiptCaptionsLink" data-color="ReceiptCaptionsTXT" style="color: #ffffff;font-family: sans-serif;font-size: 15px;text-align: center;line-height: 27px;font-weight: bold;" bgcolor="#67bffd">
																									<a href="#" data-color="ReceiptCaptionsLink" style="text-decoration: none;color: #ffffff;"></a>Total
																								</td>
																								<td class="wz2" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																				<th class="stack3" data-bgcolor="ThemeColorBG" data-border-bottom-color="borderColor" data-border-left-color="borderColor" style="border-left:1px solid #dde5f1;margin:0; padding:0;vertical-align:top;border-bottom:1px solid #dde5f1;" bgcolor="#67bffd" valign="top" width="139">
																					<table class="table60033" align="center" width="139" border="0" cellpadding="0" cellspacing="0">
																						<tbody>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																							<tr>
																								<td class="wz2" width="30">
																								</td>
																								<td data-bgcolor="ThemeColorBG" class="header5TD" data-link-style="text-decoration:none; color:#ffffff;" data-link-color="ReceiptCaptionsLink" data-color="ReceiptCaptionsTXT" style="color: #ffffff;font-family: sans-serif;font-size: 15px;text-align: center;line-height: 27px;font-weight: bold;" bgcolor="#67bffd">
																									<a href="#" data-color="ReceiptCaptionsLink" style="text-decoration: none;color: #ffffff;"></a><?php echo $gtotal; ?>
																								</td>
																								<td class="wz2" width="30">
																								</td>
																							</tr>
																							<tr>
																								<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="20">&nbsp;
																									
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</th>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="FinalNotesModule" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="table600st" style="min-width:668px;" align="center">
									<table class="table600Min" style="min-width:629px;" align="center" width="629" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:629px;">
													<table data-bgcolor="CredentialsBGColor" class="table600" style="border-radius:0 0 6px 6px;" align="left" bgcolor="#fdfdfd" width="629" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td>
																	<table class="table600" width="627" border="0" cellpadding="0" cellspacing="0">
																		<tbody>
																			<tr>
																				<td colspan="3" style="font-size:0;line-height:0;" class="va2" height="25">&nbsp;
																					
																				</td>
																			</tr>
																			<tr>
																				<td class="wz" width="30">
																				</td>
																				<td class="RegularText5TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="color: #425065;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">
																					<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="RegularLink">www.mildtrix.com</a><br /><a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="RegularLink"><?php echo $system_email ?></a>
																				</td>
																				<td class="wz" width="30">
																				</td>
																			</tr>
																			<tr>
																				<td colspan="3" class="va2" style="font-size:0;line-height:0;" height="30">&nbsp;
																					
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <table data-bgcolor="TemplateBGColor" style="table-layout:fixed;margin:0 auto;" data-module="FooterModule" align="center" bgcolor="#384855" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td align="center">
					<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:668px;" align="center" bgcolor="#384855" width="668" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="table600st" style="min-width:668px;" align="center">
									<table data-bgcolor="TemplateBGColor" class="table600Min" style="table-layout:fixed;margin:0 auto;min-width:629px;" align="center" bgcolor="#384855" width="629" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="table600st" style="min-width:629px;" align="center">
													<table class="table600" align="center" width="610" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td height="25">
																</td>
															</tr>
															<tr>
																<!--NOTES -->

																<td class="companyAddressTD" data-link-style="text-decoration:none; color:#ffffff;" data-link-color="FooterCaptionLink" data-color="FooterCaptionTXT" style="color: #67bffd;font-family: sans-serif;font-size: 13px;text-align: center;font-weight: bold;line-height: 190%;">
																	<a href="#" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="FooterCaptionLink"></a>THANK YOU VERY MUCH FOR CHOOSING US
																</td>
															</tr>
															<tr>
																<td style="font-size:0;line-height:0;" height="25">&nbsp;
																	
																</td>
															</tr>
															
															<tr>
																<td height="25">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
