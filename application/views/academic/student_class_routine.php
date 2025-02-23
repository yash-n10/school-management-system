<style>
  .nav-tabs > li .active > a
  {
      background:red;
      color:black;
  }    
</style>

<div class="form-group has-feedback">
   
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({

      maxDate: 0 ,
      onSelect: function (dateText, inst) {
          var dates = $(this).val();          
          var date = $(this).datepicker('getDate');

          var year = date.getFullYear();
          var month = date.getMonth()+1;
          var dat = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
          var finaldate= year+'-'+month+'-'+dat;
          //alert(finaldate);
          
          var dayOfWeek = date.getUTCDay();
          if(dayOfWeek=='0')
          {
             var day = 'Monday';
             var daa ='monday';
          }
          else if(dayOfWeek=='1')
          {
            var day = 'Tuesday';
            var daa = 'tuesday';
          }
          else if(dayOfWeek=='2')
          {
            var day = 'Wednesday';
            var daa = 'wednesday';
          }
          else if(dayOfWeek=='3')
          {
            var day = 'Thursday';
            var daa = 'thursday';
          }
          else if(dayOfWeek=='4')
          {
            var day = 'Friday';
            var daa = 'friday';
          }
          else if(dayOfWeek=='5')
          {
            var day = 'Saturday';
            var daa = 'saturday';
          }
          else if(dayOfWeek=='6')
          {
            var day = 'Sunday';
            var daa = 'sunday';
          }

          $('.panel-title').html('');
          $('.panel-title').append("<b>(Date:  "+dates+"   |  Day: "+day+" )</b>");
          var clasid = $('#clsid').val(); 
          var secid = $('#secid').val(); 
          $.ajax({
              url   : "<?php echo site_url('student/GetRout')?>",
              type  : "POST",
              data  : {day:daa,clasid:clasid,secid:secid,date:finaldate},
              success: function(data)
              {    
                console.log(data);
                $('#routdata').html('');
                $('.trr').html('');
                $('#routdata').html(data);
              }
          });
        }
      });
    });
  $(document).ready(function() {
    var clasid = $('#clsid').val(); 
    var secid = $('#secid').val(); 
    
    var d = new Date();

    var days = d.getDay();
    if(days=='1')
    {
       var day = 'Monday';
       var daa ='monday';
    }
    else if(days=='2')
    {
      var day = 'Tuesday';
      var daa = 'tuesday';
    }
    else if(days=='3')
    {
      var day = 'Wednesday';
      var daa = 'wednesday';
    }
    else if(days=='4')
    {
      var day = 'Thursday';
      var daa = 'thursday';
    }
    else if(days=='5')
    {
      var day = 'Friday';
      var daa = 'friday';
    }
    else if(days=='6')
    {
      var day = 'Saturday';
      var daa = 'saturday';
    }
    else if(days=='0')
    {
      var day = 'Sunday';
      var daa = 'sunday';
    }


    var month = d.getMonth()+1;
    var dayaa = d.getDate();
    var tdate = (month<10 ? '0' : '') + month + '/' + (dayaa<10 ? '0' : '') + dayaa + '/' +d.getFullYear() ;
    
    $('.panel-title').html('');
    $('.panel-title').append("<b>(Date:  "+tdate+"   |  Day: "+day+" )</b>");
          $.ajax({
              url   : "<?php echo site_url('student/GetRout')?>",
              type  : "POST",
              data  : {day:daa,clasid:clasid,secid:secid},
              success: function(data)
              {    
                //console.log(data);
                $('#routdata').html('');
                $('.trr').html('');
                $('#routdata').html(data);
              }
          });
  });
  </script>
  <div class="box"> 
    <div class="box-body"> 
      <h4>VIEW ROUTINE BY DATE</h4>
      <div class="row">
      <div class="form-group col-md-4">
        <label for="pwd">Select Date:</label>
        <input type="text" class="form-control" id="datepicker" value="<?php echo date('m/d/Y');?>">
      </div>
      </div>
        <div class="panel-title"></div>
        <hr/>
      
        <div class="table-responsive">
          <table class="table table-bordered table-stripped">
            <tbody id="routdata">
              
             
            </tbody>
          </table>
        </div>
    </div>
    <input type="hidden" id="clsid" value="<?php echo $class_id;?>">
    <input type="hidden" id="secid" value="<?php echo $section_id;?>">
  </div>


  <div class="box"> 
    <div class="box-body">    
        <h4>OVERALL ROUTINE</h4>
        <div>
            <div class="table-responsive">
              <table class='table table-bordered table-stripped' style="background:#b3d9ff;">
                  <tr style="background:#66c2ff">
                    <td style="background:#b3d9ff;font-weight: bold;">Time<br/>Day</td>
                     <?php for($k=0; $k<$period; $k++) { ?>
                    <td style="color:#0000b3">
                      <b><?php echo $start[$k].":".$start_min[$k]."-".$end[$k].":".$end_min[$k]; ?></b></td> 
                      <?php } ?>                    
                  </tr>             
             
                  <?php for($i=0; $i<$cnt; $i++) { ?>
                  <tr>
                      <td> <?php echo ucwords($day[$i]); ?></td>
                      <?php for($j=0; $j<$count; $j++) { ?>
                      <td> <?php if(isset($day_subject[$i][$j])) { echo $day_subject[$i][$j]; } else { echo ' ';}?>
                          <br>

                      <?php if(isset($tchr_nam[$i][$j])) { echo $tchr_nam[$i][$j] ; } else {echo ' ';}?></td>
                      <?php } ?>
                  </tr>
                  <?php  } ?>
              </table>
            </div>             
        </div>        
   </div>
   </div>
</div>