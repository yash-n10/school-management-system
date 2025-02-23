<style>
    .nav-tabs > li .active > a
    {
        background:red;
        color:black;
    }
    
</style>

<div class="form-group has-feedback">
   <div class="box"> 
    <div class="box-body">    
    	<!------CONTROL TABS START------->
        <div>
            <div class="table-responsive">
              <table class='table table-bordered table-stripped' style="background:#b3d9ff;">
                  <tr style="background:#66c2ff">
                      <td style="background:#b3d9ff;"></td>
                       <?php for($k=0; $k<$period; $k++) { ?>
                      <td style="color:#0000b3"><b>
                       <?php echo $start[$k].":".$start_min[$k]."-".$end[$k].":".$end_min[$k]; ?>
                      </b> </td> <?php } ?>
                    
              </tr>
              
             
              <?php for($i=0; $i<$cnt; $i++) { ?>
              <tr>
                  <td> <?php echo $day[$i]; ?></td>
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
    	<!------CONTROL TABS END------->
        
	</div>
   </div>
</div>