



<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<style>
   
.table th { text-align:center; }
.table td { text-align:center; }
.table a:hover { text-decoration: none; }
.cl_wday { text-align: center; font-weight:bold; }
.cl_equal { width: 14%; }
.day { width: 14%; }
.day_num { text-align:left; cursor:pointer; margin: -8px; padding:8px; } 
.day_num:hover { background:#F5F5F5; }
.matter .content { width: 100%;text-align:left; color: #2FA4E7; margin-top:10px; }
.highlight { color: #0088CC; font-weight:bold; }
</style>

<!--
<div class="page-head">
  <h2 class="pull-left"> <?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("calendar_line"); ?></span> </h2>
</div>
<div class="clearfix"  ></div>
-->

   
  <div  style="width:80%;float:right;margin-right:25px;position:relative;top:-450px;">
<p>&nbsp;</p>
	<div>
    <?php echo $calender; ?>
    </div>
<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>

 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line("add_event"); ?>  <span id="selected_date"></span></h4>
      </div>
      
        
        <div class="modal-body">
         <p style="margin: 33px 35px 24px;"> Add/Modify Event:</p>
<p><?php echo $this->lang->line("add_modify_event"); ?></p>
<p><?php /* echo form_textarea('event', '', 'class="input-block-level" style="height:100px;" id="event_data_input"'); */  ?>
<textarea name="event" class="form-control" style="height:100px;margin-left: 58px;
width: 438px;" id="event_data_input"></textarea>
<input type="hidden" name="dayNum" id="dayNum" value="" /></p>
</div>
        
       
   
   
  
   <div class="modal-footer">
<span id="delb" class="pull-left" style="min-width:70px; max-width:150px; text-align:left; display:none;">
<input type="submit" class="btn btn-danger" onclick="Show_Div(Div_1)"  id="del" value="Delete"><?php echo $this->lang->line("delete"); ?></span>

<button class="btn btn-green" data-dismiss="modal" aria-hidden="true" style=""><?php echo $this->lang->line("close"); ?>Close</button>
<input type="submit" name="add" value="Add" onclick="Show_Div(Div_1)" class="btn btn-green" id="ok" data-loading-text="" style=" 
width: 49px;"><?php echo $this->lang->line("adding"); ?>
<div id="Div_1"  style="width:500px;margin:0px auto;text-align:center;display: none;position:relative;top:-22px;">Please Wait...Your request is processing...<i class="icon-spinner icon-spin icon-large"></i></div>
</div>
        
     
        
        
        
</div>
</div>
    </div>




  <script type="text/javascript">
        function Show_Div(Div_id) {
            if (false == $(Div_id).is(':visible')) {
                $(Div_id).show(250);
            }
            else {
                $(Div_id).hide(250);
            }
        }
    </script>

<script type="text/javascript">
	$('document').ready(function(){
		$('.table .day').click(function() {
			day_num = $(this).find('.day_num').html();
			month_year = $('#month_year').text();
			$('#selected_date').text(day_num+' '+month_year);
			if($(this).find('.content').length) {
				var v = $(this).find('.content').html();
				var v = v.replace(/<br>/g, "|");
				$('#delb').show();
			} else {
				var v = "";
			}
			
			$('#event_data_input').val(v);
			$('#dayNum').val(day_num);
			$('#myModal').modal();
			
		});
		$('#myModal').on('shown.bs.modal', function () {
			$("#event_data_input").focus(); 
			$initialVal = $('#event_data_input').val();
        	$('#event_data_input').val('');
        	$('#event_data_input').val($initialVal);
    			
    	});
		
		
		$('#myModal').on('click', '#ok', function() {
                   
			$(this).text('<?php echo $this->lang->line("adding"); ?>');
			day_data = $('#event_data_input').val();
			day = $('#dayNum').val();
			
			if (day_data != null) {
				
				$.ajax({
					url: window.location,
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>',
						day: day,
						data: day_data
					},
					success: function(msg) {
						location.reload();
					}						
				});
				
			}
		});
		
		$('#myModal').on('click', '#del', function() {
			$(this).text('<?php echo $this->lang->line("deleting"); ?>');
			day = $('#dayNum').val();
				$.ajax({
					url: window.location,
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>',
						day: day,
						data: ''
					},
					success: function(msg) {
						location.reload();
					}						
				});
		});
		
	});
		
	</script>
        
          <style>
          #custom-footer-id,h3{display:none;}
        
         .main-content{height:500px; }
            
        </style>