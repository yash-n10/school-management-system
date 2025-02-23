<?php
foreach ($sale_data as $value) 
{
  $taxable_amount         = $value->total_taxable_value;
  $igst                   = $value->total_igst;
  $sgst                   = $value->total_sgst;
  $cgsts                  = $value->total_cgst;
  if($igst!=''){
    $tax_amt = $igst;
  }
  else
  {
    $tax_amt = $sgst+$cgsts;
  }
  $tax_amount             = $tax_amt;
  $per_product_discount   = $value->tot_discount_product;
  $net_amount_product     = $value->tot_netamt_product;
  $discount_calculation   = $value->discount_calculation;
  $overall_discount       = $value->total_discount;
  if($discount_calculation=='P')
  {
    $discount_product     = ($taxable_amount*$per_product_discount)/100;
    $discount_amt         = ($net_amount_product*$overall_discount)/100;
  }
  else
  {
    $discount_product     = $per_product_discount;
    $discount_amt         = $overall_discount;
  }
  $other_charge           = $value->total_other_charge;
  $final_net_amount       = $value->net_amount;
  $paid                   = $value->total_paid;
  $due                    = $value->total_due;
}

foreach ($company_data as $key => $company_value){}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Invoice</title>

<style>
a
{
  color: #5D6975;
  text-decoration: underline;
}

body
  {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

h1 {
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 3px 0 2px 0;
  background: url(dimension.png);
}

#borderr {
  border-top: 1px solid  #5D6975;
  border-left: 1px solid  #5D6975;
  border-right: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  height: 1000px;
  margin: 0px 0px -2.5px 0px;
  
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  page-break-inside:avoid;
}

table tr:nth-child(2n-1) td {
  background: #ffffff;
}

table th,
table td {
  text-align: center;
}

table th {
  /*padding: 2px 10px;*/
  color: #4c4949;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: bold;
}

table td {
  padding: 7px;
  text-align: right;  
}

table { page-break-inside:auto }
tr    { page-break-inside:avoid; page-break-after:auto }

.tablecustomtd {
	border-bottom:1px solid #ffffff;
	background: #ffffff;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    
</style>
<style>
table, th, td {
    border: 1px solid #5D6975;
    height:3px;
	margin: 3px -0.5px 3px -0.5px;
}
td{
height:7px;
margin: 5px -0.5px 6px -0.5px;
}
</style>
</head>

  <body style="width:100%;">
    <div class="row">
      <div class="col-md-12">
        <span><b style="padding left: 20px"> <?php 
                $logo = $datav[0]->logo;
                if($logo ==''){
            ?>
            
            <?php } else {?>    
          
              <img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/digikhata/<?php echo $datav[0]->logo;?>" weidth="50px;" height="70px;">
            <?php }?></b></span><br>
        <div>
          <span style="text-align: left;padding-left: 10px;">GSTIN : <?php echo $company_value->gstin;?></span><span style="text-align: right;padding-left: 400px;">Date :  <?php echo date('d-m-Y', strtotime($value->date));?> </span><br>
          <span style="text-align: left;padding-left: 10px;padding-right: 189px;">Mobile : <?php echo $company_value->mobile;?></span><span style=""><u>  TAX/RETAIL INVOICE</u></span><span style="margin-left: 130px;">Invoice No: <?php echo $value->invoice_no;?> </span><br>
          <span><h2 style="position: static;width: 700px;padding-bottom: 2px;padding-top: 2px;"><center><?php echo $company_value->company_name;?></center></h2></span><br>
          
          <span style=""><center><?php echo $company_value->address;?></center></span>
        </div>
        <div>
          <table style="width: 100%; position: relative;top: 10px;">
            <tr>
              <th colspan="2" style="height: 2%">Deals in : xxxxx xxxx xxxx xxxx</th>
            </tr>
            <tr>
              <th rowspan="2" style="text-align: left;padding-left: 4px;">Details of Receiver :<br>
                <span>Name : <?php echo $value->ledger_name;?> </span><br>
                <span>Address : <?php echo $value->address;?></span><br>
                <span style="padding-right: 90px;">State : <?php echo $value->state_name;?></span> <span>State Code : <?php echo $value->state;?></span><br>
                <span style="padding-right: 76px;">Mobile : <?php echo $value->phone;?></span> <span>GSTIN : <?php echo $value->gst_no;?></span><br>
              </th>
              <th></th>
            </tr>
            <tr>
              <th style="text-align: left;padding-left: 4px;">Transportation Mode :<br>
                <span>Vehicle Number :</span><br>
                <span>Date of Supply :</span><br>
                <span>Place of Supply :</span>
              </th>
            </tr>
            <tr>
              <th style="height: 30px;" colspan="2">STATE CODE : xx</th>
            </tr>
          </table>
        </div>
        <div>
    		  <table style="width: 100%; position: relative;top: 5px;margin-top: 0;">
            <tr>
              <th rowspan="2" style="width: 1%;text-align: center;">Sr <br> NO.</th>
              <th rowspan="2"style="width: 30%;text-align: center;">Name Of Product/Service</th>
              <th rowspan="2" style="width: 5%;text-align: center;">HSN/ <br>SAC Code</th>
              <th rowspan="2" style="width: 9%;text-align: center;">Qty.</th>
              <th rowspan="2" style="width: 10%;text-align: center;">Rate</th>
              <th rowspan="2" style="width: 10%;text-align: center;">Taxable <br> Value</th>
              <th colspan="2" style="width: 12%;text-align: center;">CGST</th>
              <th colspan="2" style="width: 12%;text-align: center;">SGST</th>
              <th rowspan="2" style="width: 15%;text-align: center;">Total</th>
            </tr>

            <tr>
              <th style="width: 7%;">Rate</th>
              <th style="width: 8%;">Amt.</th>
              <th style="width: 7%;">Rate</th>
              <th style="width: 8%;">Amt.</th>
            </tr>
            
            <?php $i=1; foreach($sale_product as $value_sale_product)
              { 

                  $hsn          = $value_sale_product->hsn;
                  $gst_rate     = $value_sale_product->gstrate;

                  $product_name = $value_sale_product->product_name;
                  $qty          = $value_sale_product->qty;
                  $mrp          = $value_sale_product->mrp;
                  $discount     = $value_sale_product->discount;
                  $gst_type     = $value_sale_product->gst_type;
                  $taxable_price   = $value_sale_product->taxable_price;
                  $gst_amount   = $value_sale_product->tax_amount;
                  $cgst         = $gst_amount/2;
                  $net_amount   = $value_sale_product->total_net_amount;
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"><?php echo $i;?></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"><?php echo $product_name;?></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"><?php echo $hsn;?></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"><?php echo $qty;?></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"><?php echo $mrp;?></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"><?php echo $taxable_price;?></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"><?php echo $net_amount;?></td>
            </tr>

            <?php $i++;} ?>

             <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>


            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>

            <?php $i=1; { 
              ?>
            <tr>
              <td style="text-align:center;width: 1%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 30%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 9%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 7%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 8%;" class="tablecustomtd"></td>
              <td style="text-align:center;width: 10%;" class="tablecustomtd"></td>
            </tr>

            <?php $i++;} ?>


          </table>
        </div>
        <div>
          <table style="width: 100%; position: relative;top: 1px;margin-top: 0;">
          <tr>
              <td colspan="3" rowspan="3" style="text-align: left;" valign="top">Total Invoice Value (In Figures) : <br><br><?php echo $word;?></td>
              <td colspan="7" valign="top">Total Amount Before Tax</td>
              <td><?php if(isset($taxable_amount)){echo $taxable_amount;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td colspan="7">CGST</td>
              <td><?php if(isset($cgsts)){echo $cgsts;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td colspan="7">SGST</td>
              <td><?php if(isset($sgst)){echo $sgst;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td rowspan="4" colspan="3" valign="top" style="text-align: left;">Terms & Conditions:<br><br><br><?php echo $datav[0]->termscondition;?></td>
              <td colspan="7">IGST</td>
              <td><?php if(isset($igst)){echo $igst;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td colspan="7">Total Tax Amount : </td>
              <td><?php if(isset($tax_amount)){echo $tax_amount;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td colspan="7">Total Per Product Discount</td>
              <td><?php if(isset($discount_product)){echo $discount_product;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td colspan="7">Total Net Amount</td>
              <td><?php if(isset($net_amount_product)){echo $net_amount_product;}else{echo '-';}?></td>
            </tr>
            <tr>
              <?php foreach($bank_detail as $bank_value){}?>
              <td colspan="3" rowspan="3" valign="top" style="text-align: left;">Bank Details<br> <br>Bank Name :<?php echo strtoupper($bank_value->bank_name);?>  <br>
                      Branch : <?php echo strtoupper($bank_value->branch_name);?> <br>
                      A/C No. : <?php echo $bank_value->account_number;?> <br>
                      IFSC Code: <?php echo strtoupper($bank_value->ifsc_code);?> <br></td>
              <td colspan="7">Overall Discount</td>
              <td><?php if(isset($discount_amt)){echo $discount_amt;}else{echo '-';}?></td>
            </tr>
            <tr>
                <td colspan="7">Total Other Charges</td>
                <td><?php if(isset($other_charge)){echo $other_charge;}else{echo '-';}?></td>
            </tr>
            <tr>
              <td colspan="7">Final Net Amount</td>
              <td><?php if(isset($final_net_amount)){echo $final_net_amount;}else{echo '-';}?></td>
            </tr>  
            <tr>
                <th style="text-align:left;" colspan="6" height="10%" valign="bottom">Customer Signature</th>
                <th style="text-align:left;" colspan="5" height="10%" valign="bottom">Authorized Signatory</th>
              </tr> 
          </table>
        </div>
      </div>
   </div>
  </body>
</html>