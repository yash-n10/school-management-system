<div class="form-group has-feedback">
  <div class="box">
    <div class="box-body">
       <div class="col-lg-12" style="text-align:right;">
           <?php if(substr($right_access, 0,1)=='C') {?>
          <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add Category">
            <i class="fa fa-plus-circle"></i>&nbsp;
          </a>
            <?php } ?>
        </div>

    </div>
    <div class="box-body">
        <?php if(substr($right_access, 1,1)=='R') {?>
        <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="period">
          <thead style="background:#99ceff;">
            <tr>
                <th style="border-bottom:0px">S.No.</th>
                <th style="border-bottom:0px">Category Name</th>
                <th style="border-bottom:0px">Action</th>
            </tr>
          </thead>
          <thead style="background: #cce6ff">
            <tr id="searchhead">

                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                </th>

                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
            </tr>
        </thead>
          <tbody>
            <?php 
              $i = '1';
              foreach($category as $val){
            ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $val->name?></td>
                <td>
                    <?php if(substr($right_access, 2,1)=='U') {?>
                    <span>
                        <a class="btn a-edit" onclick="edit(<?php echo $val->id;?>,'<?php echo $val->name;?>')"><i class="fa fa-edit"></i> </a>
                    </span>
                    <?php }?>
                    <?php if (substr($right_access, 3,1)=='D'){?>
                    <span>
                        <a class="btn a-delete" onclick="deletes(<?php echo $val->id;?>)"><i class="fa fa-trash"></i> </a>
                    </span>
                    <?php } ?>
                </td>
              </tr>
            <?php $i++;}?>
          </tbody>
        </table>
        </div>   
        <?php }?>
    </div>   
  </div>
</div>
<?php if(substr($right_access, 0,1)=='C') {?>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_add" class="form-horizontal" method="post" >    
              
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add Category</h3>
              </div>      
              <div class="modal-body">
                             
                  <div class="form-group" style="width:90%;margin-left:5%;">
                    <label for="email" class="control-label">Category Name</label>
                    <input type="text" class="form-control" id="name" required>
                  </div>
                  
                
              
              </div>
              <div class="modal-footer">
                  <a id="butt" class="btn btn-success" onclick="save()">SAVE</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
               </form> 
            </div>
          </div>
        </div>
<?php }?>
      <!--Edit Modal-->
      <?php if(substr($right_access, 2,1)=='U') {?>
        <div id="EditModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Update Category</h3>
                </div>
              <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="post" style="width:90%;margin-left:5%;">                 
                  <div class="form-group">
                    <label for="email" class="control-label">Category Name</label>
                    <input type="text" class="form-control" id="name_edit" required>
                  </div>
                  <a id="butt_update" class="btn btn-success" onclick="update()">UPDATE</a>
                </form> 
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <?php }?>
      <!-- End Edit Modal-->
<script>
$(function ()
{
    var table = $('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
    $('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
});


$('#class').on('change keyup',function(){
  var value = $(this).val();
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section').empty();
        $("#section").append(data);
      },        
  });
});

function save()
{
 if(!$('#form_add')[0].checkValidity()) {
      $(this).show();
      $('#form_add')[0].reportValidity();
      return false;
  }
  else{
    var catname = $('#name').val();
    var nam = catname.toLowerCase();
    var slug = nam.replace(/\s+/g, '_');

    $.ajax({
      url : "<?php echo site_url('academics/homework/Category/Add_category')?>",
      type : "POST",
      data : {name:catname,slug:slug},
      success: function(data)
      {
        console.log(data);
        location.reload();
      }
    });
  }
}

function deletes(id)
{
  var r = confirm("Are you sure you want to Delete?");
  if (r == true) 
  {  
  $.ajax({
    url : "<?php echo site_url('academics/homework/Category/Delete_category')?>",
    type : "POST",
    data : {id:id},
    success: function(data)
    {
      //console.log(data);
      location.reload();
    }
  });
  }
}

function edit(id,name)
{
  $("form")[0].reset();
  $('#butt_update').attr('onclick','update('+id+')');
  $('#name_edit').val(name);
  $('#EditModal').modal('show');

}


function update(id)
{
  var catname =$('#name_edit').val();
  var nam = catname.toLowerCase();
  var slug = nam.replace(/\s+/g, '_');
  
  $.ajax({
    url : "<?php echo site_url('academics/homework/Category/Update_category')?>",
    type : "POST",
    data : {id:id,name:catname,slug:slug},
    success: function(data)
    {
      //console.log(data);
      location.reload();
    }
  });

}
</script>