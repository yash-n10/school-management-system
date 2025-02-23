<div class="box">
    <div class="box-header">
        <!------CONTROL TABS START------->

        <ul class="nav nav-tabs nav-tabs-left">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('email_view'); ?>
                </a>
            </li>
        </ul>

        <!------CONTROL TABS END------->
    </div>
    <div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane  active" id="list">
            		
                    <div class="box">
                        <div class="box-content">
                            <div id="dataTables">
                            <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                                <thead>
                                    <tr>
                                        <th><div>ID</div></th>
                                        <th width="80"><div><?php echo get_phrase('subject');?></div></th>
                                        <th><div><?php echo get_phrase('time');?></div></th>
                             <th><div><?php echo get_phrase('body');?></div></th>
                                        <th><div><?php echo get_phrase('view');?></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1;foreach($result as $row):
                                      if(in_array($user_id,explode(',',$row['read']))):
                                     ?>
                                    <tr>
                                        <td><?php echo $count++;?></td>
                                        <td><?php echo $row['subject'];?></td>
                                        <td width="200px"><?php echo $row['time'];?></td>
                                         <td><?php echo $row['body'];?></td>
                                        <td align="center" width="200px;">
                                            <a data-toggle="modal" href="#modal-form" onclick="modal('email_body',<?php echo $row['id'];?>)"
                                                 class="btn btn-default btn-small">
                                                    <i class="icon-envelope"></i> <?php echo get_phrase('View Email');?>
                                            </a>
                                              <a  data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url(); ?>student/email_delete/<?php echo $row['id']; ?>')" class="btn btn-red btn-small">

                                                            <i class="icon-trash"></i> <?php echo get_phrase('delete'); ?>

                                              </a>
                                        </td>
                                    </tr>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
		</div>
            <!----TABLE LISTING ENDS--->
            </div>
	</div>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
</script>
   