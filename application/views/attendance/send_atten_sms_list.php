<style>
.btn-sent {
        padding: 0;
    border-radius: 50%;
    line-height: 0;
    color: black;
    background-color: transparent;
    border-color: #39843c;
    width: 4.5rem;
    min-width: 3.5rem;
    height: 4.5rem;
    box-shadow: 1px 3px 1.5px 0 rgba(0,0,0,.12), 0 1px 1px 0 rgba(0,0,0,.26);
}
.btn-sent:active,.btn-sent:hover,.btn-sent:hover:active,.btn-sent:focus,.btn-sent:visited{
    color: #fff;
    background-color: #46a149;
    border-color: #39843c;
}
.btn-inbox {
        padding: 0;
    border-radius: 50%;
    line-height: 0;
    color: black;
    background-color: transparent;
    border-color: #2f3d88;
    width: 4.5rem;
    min-width: 3.5rem;
    height: 4.5rem;
    box-shadow: 1px 3px 1.5px 0 rgba(0,0,0,.12), 0 1px 1px 0 rgba(0,0,0,.26);
}
.btn-inbox:active,.btn-inbox:visited,.btn-inbox:hover,.btn-inbox:hover:active,.btn-inbox:focus{
    color: #fff;
    background-color: #495bc0;
    border-color: #1e2756;
}



.btn-trash {
        padding: 0;
    border-radius: 50%;
    line-height: 0;
    color: black;
    background-color: transparent;
    border-color: #f44336;
    width: 4.5rem;
    min-width: 3.5rem;
    height: 4.5rem;
    box-shadow: 1px 3px 1.5px 0 rgba(0,0,0,.12), 0 1px 1px 0 rgba(0,0,0,.26);
}
.btn-trash:active,.btn-trash:hover,.btn-trash:hover:active,.btn-trash:focus{
    color: #fff;
    background-color: #f55549;
    border-color: #e11b0c;
}
.btn-compose{
    /*color: rgba(0,0,0,.87);*/
    color: #fff;
    /*background-color: hsla(0,0%,60%,.4);*/
    background-color: hsla(340, 82%, 52%, 0.94);
    border-color: hsla(0,0%,60%,.4);
}
.btn-composesms{
    /*color: rgba(0,0,0,.87);*/
    color: #fff !important;
    /*background-color: hsla(0,0%,60%,.4);*/
    background-color: hsla(262, 52%, 47%, 0.788235294117647);
    border-color: hsla(0,0%,60%,.4);
}
.btn-compose:hover,.btn-composesms:hover{
    z-index: 1;
    box-shadow: 0 4px 5px 0 rgba(0,0,0,.14), 0 1px 10px 0 rgba(0,0,0,.12), 0 2px 4px -1px rgba(0,0,0,.2);
}

</style>

<div class="form-group">
    <div class='box box-primary panel'>
        <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;background-color: #dff0d8;">
            <ul class="nav nav-tabs">
                <!-- <li class=""><a data-toggle="tab" href="#mail" style="font-weight:bold;" >Mail</a></li> -->
                <li class="active"><a data-toggle="tab" href="#sms" style="font-weight:bold" >SMS</a></li>

            </ul>
        </div>
        <div class='box-body'>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="sms"> 
                    <div class="col-sm-12 col-md-12" >                        
                        <a type="button" class="btn btn-composesms" style="float:right" href="<?php echo base_url('attendance/Student_attendance/compose_sms');?>">Compose</a>
                    </div>
                    <div class="col-sm-12 col-md-12" style="height:5px">
                        
                    </div>
                  
                    <div class="col-sm-12 col-md-12">
                        
                        <div class="table-responsive">
                            <table id="inboxsmstable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>From</th>      
                                        <th>To User</th>      
                                        <th>To Mobile No.</th>      
                                        <th>Message body</th>
                                        <th>Datetime</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($smsdata as $key => $value) {?>
                                    <tr>
                                        <td><?php echo $value->from_user;?></td>
                                        <td><?php echo $value->to_user;?></td>
                                        <td><?php echo $value->to_number;?></td>
                                        <td><?php echo $value->message_content;?></td>
                                        <td><?php echo $value->sent_ts;?></td>
                                        <!--<td></td>-->
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<!-- /.box-body -->
</div>
<!-- /.box -->
<script>
    $(document).ready(function (){
        $('#inboxmailtable').hide();
        $('#inboxmailtable_wrapper').css('display','none');
        $('#trashmailtable').hide();
        $('#trashmailtable_wrapper').css('display','none');
        
        var table = $('#inboxsmstable').DataTable({
                "destroy":true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false
        });
    });
</script>