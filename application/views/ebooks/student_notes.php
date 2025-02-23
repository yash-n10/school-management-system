<div class="form-group has-feedback">
  <div class="box">
    <div class="box-body">

    </div>
    <div class="box-body">
        <div class="table-responsive">
      <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="period">
        <thead style="background:#99ceff;">
          <tr>
              <th style="border-bottom:0px">S.No.</th>
              <th style="border-bottom:0px">Class</th>
              <th style="border-bottom:0px">Section</th>
              <th style="border-bottom:0px">Subject</th>              
              <th style="border-bottom:0px">D/O/P</th>
              <th style="border-bottom:0px">Description</th>
              <th style="border-bottom:0px">View</th>
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
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                </th>  
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                </th>                

                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
            </tr>
        </thead>
          <tbody>
            <?php 
           
            $i=1;
            foreach($notes as $value){ ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value->class_name; ?></td>
                <td><?php echo $value->section_name; ?></td>
                <td><?php echo $value->subject_name; ?></td>
                <td><?php echo $value->dop; ?></td>
                <td><?php echo $value->description; ?></td>
                <?php if($value->attachment !='') { ?>
                <td><a href="<?php echo base_url();?>/assets/ebooks/notes/<?php echo $value->attachment;?>" class="btn btn-primary">View Notes</a></td>
                <?php } else { ?>
                  <td><button class="btn btn-warning"> No Attachemnt</button></td>
                <?php } ?>

              </tr>

           <?php 
              $i++;
              }
            ?>
          </tbody>
      </table>
        </div>   
    </div>   
  </div>
</div>


<script>


$(function ()
{
  CKEDITOR.replace('descr');
  CKEDITOR.replace('descr_ed');

    var table =$('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
    $('#searchhead th input').on('keyup change', function () {
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
});

</script>


