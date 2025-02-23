<?php //print_r($tutorial); ?>
<style>
.blinkbutton{background-color:#004a7f;-webkit-border-radius:10px;border-radius:10px;border:none;color:#fff;cursor:pointer;padding:5px 10px;text-align:center;text-decoration:none;-webkit-animation:glowing 1500ms infinite;-moz-animation:glowing 1500ms infinite;-o-animation:glowing 1500ms infinite;animation:glowing 1500ms infinite}@-webkit-keyframes glowing {
		  0% { background-color: #0083c2; -webkit-box-shadow: 0 0 3px #B20000; }
		  50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
		  100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
		}@-moz-keyframes glowing {
		  0% { background-color: #0083c2; -moz-box-shadow: 0 0 3px #B20000; }
		  50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
		  100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
		}@-o-keyframes glowing {
		  0% { background-color: #0083c2; box-shadow: 0 0 3px #B20000; }
		  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
		  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
		}@keyframes glowing {
		  0% { background-color: #0083c2; box-shadow: 0 0 3px #B20000; }
		  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
		  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
		}
</style>
<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class="table-responsive" id="data_tab">
				<table class="table table-bordered table-striped" id="book_publisher">
					<thead style="background:#99ceff;">
					  <tr>
					    <th>Sl No.</th>
					    <th>CLass Name</th>
					    <th>Subject Name</th>
					    <th>Title</th>
					    <th>Video url</th>
					    <th>Date</th>
					    <th>Image</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($tutorial as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->class_name;?></td>
		                    <td><?php echo $value->subject_name;?></td>
		                    <td><?php echo $value->title;?></td>
		                    <td><?php echo $value->video_url;?></td>
		                    <td><?php echo $value->lesson_date;?></td>
		                    <td><?php echo $value->image_video;?></td>
		                    <td><a  class="blinkbutton" onclick="video(this.id)" id="<?php echo $value->id;?>">Play</a></td>
		                </tr>
		                <?php $x++;}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

 <!--EVENT MODAL-->
  <div class="modal fade" id="tradition" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="">Watch Video</h4>
        </div>
        <div class="modal-body">
          <iframe width="100%" id="ifrm" height="300" src="" frameborder="0" allow="autoplay" allowfullscreen></iframe>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>  
  <!--EVENT MODAL-->
<script type="text/javascript">
	function video(id)
{
	
	$.ajax({
		url:"<?php echo base_url()?>Student/GetVideoUrl",
		type:"POST",
		data:{id:id},
		dataType:"json",
	success:function(data)
	{
		// alert(data.video_url);
		console.log(data);
		$('#ifrm').attr('src','');
		$('#ifrm').attr('src',data.video_url);
		$('#tradition').modal('show');
	}
});
}
</script>