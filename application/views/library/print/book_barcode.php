<style type="text/css">
  .programme {
    border: 1px solid 
    #ccc;
    height: 400px;
    overflow: scroll;
}
</style>
<form action="<?php echo base_url();?>library/print/book_barcode/prints" target="_blank" method="POST">
  <div class="form-group has-feedback">
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

            <div class="form-group row">
              <label for="staticCollegeProg" class="col-sm-4 col-form-label">Category</label>
              <div class="col-sm-8">
                <select class="form-control" id="category" name="category" onchange="getbook()">
                  <option value="">Select Category</option>
                  <?php foreach ($category as $key => $value): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->category_name;?></option>  
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticCollegeProg" class="col-sm-4 col-form-label">Publisher</label>
              <div class="col-sm-8">
                <select class="form-control" id="publisher" name="publisher" onchange="getbook()">
                  <option value="">Select Publisher</option>
                  <?php foreach ($publisher as $key => $value): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>  
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticCollegeProg" class="col-sm-4 col-form-label">Author</label>
              <div class="col-sm-8">
                <select class="form-control" id="author" name="author" onchange="getbook()">
                  <option value="">Select Author</option>
                  <?php foreach ($author as $key => $value): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>  
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticCollegeProg" class="col-sm-4 col-form-label">Library Location</label>
              <div class="col-sm-8">
                <select class="form-control" id="location" name="location" onchange="getbook()">
                  <option value="">Select Library Location</option>
                  <?php foreach ($location as $key => $value): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>  
                  <?php endforeach ?>
                </select>
              </div>
            </div>
               <div class="form-group row">
              <label for="staticCollegeProg" class="col-sm-4 col-form-label">Library Location</label>
              <div class="col-sm-8">
                <select class="form-control" id="almirah" name="almirah" onchange="getbook()">
                  <option value="">Select Almirah No</option>
                  <?php
                   $almirah =$this->db->query("SELECT DISTINCT almirah_no from book order by almirah_no");
                    $almirah=$almirah->result();
                  ?>
                  <?php foreach ($almirah as $key => $value): ?>
                  <option value="<?php echo $value->almirah_no;?>"><?php echo $value->almirah_no;?></option>  
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            
          </div>

          <div class="col-md-6">
            <div class="programme">
              <table class="table table-bordered table-striped" id="period">
                <thead>
                  <tr>
                      <th><input type="checkbox" name="chkbox" id="chkbox" class="checkBoxClass"></th>              
                      <th>Book/Document Name</th>
                      <th>Accession No</th>
                  </tr>
                </thead>
          

                <tbody id="list_data">
            
                </tbody>

              </table>
            </div>
          </div>  
        </div>
        <hr>
        <button type="submit" class="btn btn-primary mb-2" id="sub"> Print</button>
        <input type="hidden" id="upd_id" name="upd_id" value="">
        <a class="btn btn-primary mb-2" id="upd" onclick="update()" style="display: none;"> UPDATE</a>
        <a class="btn btn-outline-success" id="msg_save" style="display: none;"><i class="fa fa-check" aria-hidden="true"></i> Successfully Saved</a>
        <a class="btn btn-outline-success" id="msg" style="display: none;"><i class="fa fa-check" aria-hidden="true"></i> Updated</a>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
  $(document).ready(function () {
      $("#chkbox").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
      });
      
      $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#chkbox").prop("checked",false);
        }
      });
  });

  function getbook()
  {
    var category  = $('#category').val();
    var publisher = $('#publisher').val();
    var author    = $('#author').val();
    var location  = $('#location').val();
    var almirah =$('#almirah').val();
    $.ajax({
        url : "<?php echo base_url('library/print/book_barcode/getbook');?>",
        type: "POST",
        data: {category:category,publisher:publisher,author:author,location:location,almirah:almirah},
        dataType: 'json',
        success: function (data)
        {
          console.log(data);
          $("#list_data").html('');
          $("#list_data").html(data.ret);
        },
    });  
  }
</script>