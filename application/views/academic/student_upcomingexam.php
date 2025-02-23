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
                <a href="" data-toggle="modal">
                    <div class="col-md-2 examlist">
                        <p><b><?php echo $examdata->name;?></b></p>
                        <p>Date: <span><?php  $date = $examdata->start_date;$dat = strtotime($date);echo date('d/m/Y',$dat);?></span></p>
                        <p>Total: <span><?php echo $examdata->grand_total;?></span> | <span>Pass Mark:&nbsp;</span><span><?php echo $examdata->pass_mark;?></span></p>
                    </div>
                </a>
               
            <?php }?>
          

        </div>
    </div> 
</div>

