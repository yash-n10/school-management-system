	<div class="container-fluid padded">
		
       <div class="box tam-custom-assignments">
					<div class="box-header">
						<span class="title">
                        	<!--<i class="icon-reorder"></i>-->
                            <?php echo get_phrase('google_news');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    <div class="row-fluid">
                    <div class="span9 offset2">
                    
                    <div class="row-fluid">
       					<div class="span12 custom-news" id="news1a">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12 custom-news" id="news2a">
                        </div>
                     </div>
                    <div class="row-fluid">
                        <div class="span12 custom-news" id="news3a">
                        </div>
                     </div>
                    <div class="row-fluid">
                        <div class="span12 custom-news" id="news4a">
                        </div>
                        
                   </div>
                   <div class="row-fluid">
                        <div class="span12 custom-news" id="news5a">
                        </div>
                        
                   </div>
                    
                    
                    	<script src="https://www.google.com/jsapi" type="text/javascript"></script>
						<script type="text/javascript">
						
						// reference link bellow
						
						// https://developers.google.com/news-search/newsshow/
						
						// This optional argument supplies the topic or topic used as a query to the News Search. The value of this argument                        // specifies the topic in the current or selected edition:
						// h - specifies the top headlines topic
						// w - specifies the world topic
						// b - specifies the business topic
						// n - specifies the nation topic
						// t - specifies the science and technology topic
						// el - specifies the elections topic
						// p - specifies the politics topic
						// e - specifies the entertainment topic
						// s - specifies the sports topic
						// m - specifies the health topic
						
						// topic=b
						
						
                          google.load("elements", "1", {packages : ["slideshow", "newsshow"]});
                          google.setOnLoadCallback(initialize, true);
                          function initialize() {
                            // news1
                            var options = new Object();
                            options.queryList = [
                              {
                                topic : "h",
                                rsz : "large",
								ned : "in"
                              },
                              
                              ];
                            options.linkTarget = "_blank";
                            new google.elements.NewsShow("news1a", options);
                            
                             // news2
                            var options = new Object();
                            options.queryList = [
                              {
                                topic : "w",
                                rsz : "small",
                              },
                              
                              ];
                            options.linkTarget = "_blank";
                            new google.elements.NewsShow("news2a", options);
                            
                             // news3
                            var options = new Object();
                            options.queryList = [
                              {
                                topic : "b",
                                rsz : "large",
								ned : "in"
                              },
                              
                              ];
                            options.linkTarget = "_blank";
                            new google.elements.NewsShow("news3a", options);
                            
                            // news4
                            var options = new Object();
                            options.queryList = [
                              {
                                topic : "n",
                                rsz : "small",
								ned : "in"
                              },
                              
                              ];
                            options.linkTarget = "_blank";
                            new google.elements.NewsShow("news4a", options);
							
							 // news5
                            var options = new Object();
                            options.queryList = [
                              {
                                topic : "t",
                                rsz : "large",
								ned : "in"
                              },
                              
                              ];
                            options.linkTarget = "_blank";
                            new google.elements.NewsShow("news5a", options);
                           
                          }
                        </script>
                    	</div>
						</div>
					</div>
				</div>
       
   </div>
   
  
  <script>
  $(document).ready(function() {

    // page is now ready, initialize the calendar...

    $("#calendar2").fullCalendar({
            header: {
                left: "prev,next",
                center: "title",
                right: "month,agendaWeek,agendaDay"
            },
            editable: 0,
            droppable: 0,
            /*drop: function (e, t) {
                var n, r;
                r = $(this).data("eventObject"), n = $.extend({}, r), n.start = e, n.allDay = t, $("#calendar").fullCalendar("renderEvent", n, !0);
                if ($("#drop-remove").is(":checked")) return $(this).remove()
            },*/
            events: [
			<?php 
			$notices	=	$this->db->get('noticeboard')->result_array();
			foreach($notices as $row):
			?>
			{
                title: "<?php echo $row['notice_title'];?>",
                start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
				end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
            },
			<?php 
			endforeach
			?>
			]
        })

});
  </script>