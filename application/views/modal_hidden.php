
<!-----------HIDDEN MODAL FORM - COMMON IN ALL PAGES ------>
<div id="modal-form" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div id="modal-tablesLabel" style="color:#fff; font-size:16px;">&nbsp; </div>
	</div>
    <div class="modal-body" id="modal-body">loading data..</div>
    <div class="modal-footer">
        <button class="btn btn-gray" onclick="custom_print('frame1')">Print</button>
        <button class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
<!-----------HIDDEN MODAL DELETE CONFIRMATION - COMMON IN ALL PAGES ------>
<div id="modal-delete" class="modal hide fade" style="height:140px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h6 id="modal-tablesLabel"> <i class="icon-info-sign"></i></h6>
	</div>
    <div class="modal-delete-body" id="modal-body-delete">Delete data ?</div>
    <div class="modal-footer">
    	<a href="" id="delete_link" class="btn btn-red" >Confirm</a>
        <button class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</div>


<!-- Modal -->
<div id="custom-tam-model" class="modal hide fade" tabindex="-1" role="dialog">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="custom-tam-mode">Send SMS to Absenties</h3>
</div>
<div class="modal-body">
<div id="custom-tam-model-body">Test</div>
</div>
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>

<!-- Modal -->
<div id="custom-tam-model-roll" class="modal hide fade" tabindex="-1" role="dialog">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="custom-tam-mode">Students List</h3>
</div>
<div class="modal-body">
<div id="custom-tam-model-body-roll">Test</div>
</div>
<hr />
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>

<!-- Modal -->
<div id="custom-tam-model-pay-his" class="modal hide fade" tabindex="-1" role="dialog">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="custom-tam-mode">Payment History</h3>
</div>
<div class="modal-body">
<div id="custom-tam-model-body-pay-his">Test</div>
</div>
<hr />
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>

<!-- Modal -->
<div id="custom-tam-model-sms-unpaid" class="modal hide fade" tabindex="-1" role="dialog">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="custom-tam-mode">Send SMS to Unpaid Members</h3>
</div>
<div class="modal-body">
<div id="custom-tam-model-body-sms-unpaid">Test</div>
</div>
<hr />
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>


<script>
function modal(param1 ,param2 ,param3)
{
	document.getElementById('modal-body').innerHTML = 
		'<iframe id="frame1" src="<?php echo base_url();?>modal/popup/'+param1+'/'+param2+'/'+param3+'" width="100%" height="400" frameborder="0"></iframe>';

	document.getElementById('modal-tablesLabel').innerHTML = param1.replace("_"," ");
}

function modal_delete(param1)
{
	document.getElementById('delete_link').href = param1;
}

/////////////PRINT A DIV FUNCTION////////////////

function custom_print(div_id)
{
	var mywindow = window.open('', 'my div', 'height=400,width=600');
	mywindow.document.write(document.getElementById(div_id).contentWindow.document.body.innerHTML);
	mywindow.print();
	mywindow.close();
	return true;
}

</script>
