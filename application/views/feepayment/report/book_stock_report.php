<style>
	input.largerCheckbox{
		width:40px;
		height:15px;
	}
</style>
<div class="form-group">
    <div class="box">
        <div class="box-body">
            <div class="col-sm-12 col-md-12 table-responsive" id="annual_load" style="padding-top:3%">
                <form id="frmstudent1" role="form" method="POST">
                    <table id="studentlist1" class="table table-bordered table-striped">
                        <thead>
                            <tr> 
                                <th> Sl No </th>
                                <th> Fee Name No </th>
                                <th> Class </th>
                                <th> Opening Qty </th>
                                <th> Sale Qty </th>
                                <th> Rest Qty </th>
                            </tr> 
                        </thead>
                        <tbody id="annual_load_td">
                            <?php
                            $i=1;
                                foreach ($book_stock_report as $data) { ?>
                                    <tr>
                                        <td ><?php echo $i; ?></td>
                                        <td ><?php echo $data->fee_name; ?></td>
                                        <td ><?php echo $data->class_name; ?></td>
                                        <td ><?php echo $data->opening_qty; ?></td>
                                        <td ><?php echo $data->sale_qty; ?></td>
                                        <td ><?php echo $data->rest_qty; ?></td>
                                    </tr>
                                 <?php $i++; } ?>
                        </tbody>
                    </table>


                </form>

            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
 $(document).ready(function ()
    {
$('#studentlist1').DataTable({
                
"dom": 'Bfrtip',
                buttons: [
                               {
                                   extend: 'collection',
                                   text: 'Export',
                                   buttons: [
//                                        'copy',
                                       'excel',
                                       'csv',
                                       'pdf',
                                       'print'
                                   ]
                               }
                           ],
            });
});
</script>