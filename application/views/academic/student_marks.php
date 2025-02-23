<style>
.examlist {
    border: 1px solid #ccc;
    padding: 15px 10px 12px 13px;
    margin: 10px 30px 50px 0;
    min-height: 89px;
    box-shadow: 2px 1px 50px 5px #ccc;
}
.aa
{
    color:black;
}
</style>

<div class="box">
    <div class="box-body">
      <div class="col-lg-12">
            <?php foreach($exam as $examdata){?>
                <a href="" class="aa" data-toggle="modal" onclick="result(<?php echo $examdata->id;?>)">
                    <div class="col-md-2 examlist">
                        <p><b><?php echo $examdata->name;?></b></p>
                        <!-- <p>Date: <span><?php  $date = $examdata->date;$dat = strtotime($date);echo date('d/m/Y',$dat);?></span></p> -->
                        <p>Total: <span><?php echo $examdata->grand_total;?></span> | <span>Pass Mark:</span><span><?php echo $examdata->pass_mark;?></span></p>
                    </div>
                </a>
               
            <?php }?>
            <input type="hidden" id="class_id" value="<?php echo $class_id;?>">
            <input type="hidden" id="sec_id" value="<?php echo $section_id;?>">
            <input type="hidden" id="stu_id" value="<?php echo $student_id;?>">

        </div>
      </div>
    </div>
<div class="box">
    <div class="box-body">
      <div class="col-md-12" style="width: 100%;position: absolute;">
        <table class="table table-bordered" style="width:99%">            
         <!--  <thead>
            <tr>
              <th colspan="7" style="padding: 5px;text-align:center;background-color:#002147;color:#fff;">Term 1</th>
            </tr>
          </thead> -->
          <thead>
                    <tr>
                      <th scope="col">Subjects</th>
                      <th scope="col">Unit Test</th>
                      <th scope="col">Class Records</th>
                      <th scope="col">Subject Enrichment</th>
                      <th scope="col">Theory Exam</th>
                      <th scope="col">Marks Obtained</th>
                      <th scope="col">GR</th>
                    </tr>
                  </thead>

                   <tbody>
                         <?php $i = 1;
                          foreach ($result as $data) { ?>
                      <tr class="table-active">
                        <td scope="row"><?php echo $data->subjectname; ?></td>
                        <td><?php echo $data->periodic_test; ?></td>
                        <td><?php echo $data->note_book; ?></td>
                        <td><?php echo $data->sub_enrichment; ?></td>
                        <td><?php echo $data->written_exam; ?></td>
                        <td><?php echo $data->mark_obtained; ?></td>
                        <td><?php // echo $data->subjectname; ?></td>
                      </tr>
                       <?php $i++; } ?>
                    </tbody>
          
        </table>
      </div>

      








        
    </div> 
</div>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" id="dats">
      
    </div>

  </div>
</div>


<script>

function result(id)
{

    var examid = id;
    var clsid = $('#class_id').val();
    var secid = $('#sec_id').val();
    var stuid = $('#stu_id').val();
    $('#myModal').modal('show');
    $.ajax({
      url   : "<?php echo site_url('Student/Getresult')?>",
      type  : "POST",
      data  : {examid:examid,clsid:clsid,stuid:stuid,secid:secid},
      success: function(data)
      {    
         //console.log(data);
         $('#dats').html(data);
      }
    });
}

</script>