<?php
$student_info	=	$this->crud_model->get_student_info($current_student_id);

foreach($student_info as $row):?>
    <center>
    <div class="box">
        <div class="">
            <div class="title custom-tam-profile-block">
                
                    <div>
                        <img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>"/>
                    </div>
                    <div>
                        <h4><?php echo $row['name'];?></h4>
                    </div>
                
            </div>
        </div>
        <table class="table table-normal ">
        	 
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
        
            <?php if($row['class_id'] != ''):?>
            <tr>
                <td>Class</td>
                <td><b><?php echo $this->crud_model->get_class_name($row['class_id']);?></b></td>
            </tr>
            <?php endif;?>
            

			
            <?php if($row['roll'] != ''):?>
            <tr>
                <td>Roll</td>
                <td><b><?php echo $row['roll'];?></b></td>
            </tr>
            <?php endif;?>
            <?php if($row['admission_number'] != ''):?>
            <tr>
                <td>Admission Number</td>
                <td><b><?php echo $row['admission_number'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['sex'] != ''):?>
            <tr>
                <td>Gender</td>
                <td><b><?php echo $row['sex'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['father_name'] != ''):?>
            <tr>
                <td>Father Name</td>
                <td><b><?php echo $row['father_name'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['mother_name'] != ''):?>
            <tr>
                <td>Mother Name</td>
                <td><b><?php echo $row['mother_name'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['birthday'] != ''):?>
            <tr>
                <td>Birthday</td>
                <td><b><?php echo $row['birthday'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['doj'] != ''):?>
            <tr>
                <td>Date of Joining</td>
                <td><b><?php echo $row['doj'];?></b></td>
            </tr>
            <?php endif;?>
        
            <?php if($row['birth_place'] != ''):?>
            <tr>
                <td>Birth Place</td>
                <td><b><?php echo $row['birth_place'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['blood_group'] != ''):?>
            <tr>
                <td>Blood Group</td>
                <td><b><?php echo $row['blood_group'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['height'] != ''):?>
            <tr>
                <td>Height</td>
                <td><b><?php echo $row['height'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['weight'] != ''):?>
            <tr>
                <td>Weight</td>
                <td><b><?php echo $row['weight'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['religion'] != ''):?>
            <tr>
                <td>Religion</td>
                <td><b><?php echo $row['religion'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['cast'] != ''):?>
            <tr>
                <td>Cast</td>
                <td><b><?php echo $row['cast'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['nationality'] != ''):?>
            <tr>
                <td>Nationality</td>
                <td><b><?php echo $row['nationality'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['student_cid'] != 0):?>
            <tr>
                <td>Country</td>
                <td><b><?php echo getcountry($row['student_cid']);?></b></td>
            </tr>
            <?php endif;?>
        	
            
             <?php if($row['passport_number'] != ''):?>
            <tr>
                <td>Passport Number</td>
                <td><b><?php echo $row['passport_number'];?></b></td>
            </tr>
            <?php endif;?>
            
             <?php if($row['date_of_issue'] != ''):?>
            <tr>
                <td>Date of Issue</td>
                <td><b><?php echo $row['date_of_issue'];?></b></td>
            </tr>
            <?php endif;?>
            
             <?php if($row['date_of_expiry'] != ''):?>
            <tr>
                <td>Date of Expiry</td>
                <td><b><?php echo $row['date_of_expiry'];?></b></td>
            </tr>
            <?php endif;?>
            
            
            <?php if($row['email'] != ''):?>
            <tr>
                <td>Tam Username</td>
                <td><b><?php echo $row['email'];?></b></td>
            </tr>
            <?php endif;?>


            <?php if($row['parent_email'] != ''):?>
            <tr>
                <td>Parent Tam Username</td>
                <td><b><?php echo $row['parent_email'];?></b></td>
            </tr>
            <?php endif;?>
            
            <?php if($row['parent_password'] != ''):?>
            <tr>
                <td>Parent Tam Password</td>
                <td><b><?php echo $row['parent_password'];?></b></td>
            </tr>
            <?php endif;?>

            <?php if($row['parent_phone1'] != ''):?>
            <tr>
                <td>Parent Mobile1</td>
                <td><b><?php echo $row['parent_phone1'];?></b></td>
            </tr>
            <?php endif;?>
        
            <?php if($row['parent_phone2'] != ''):?>
            <tr>
                <td>Parent Mobile2</td>
                <td><b><?php echo $row['parent_phone2'];?></b></td>
            </tr>
            <?php endif;?>
            
             <?php if($row['father_cid'] != 0):?>
            <tr>
                <td>Father Country</td>
                <td><b><?php echo getcountry($row['father_cid']);?></b></td>
            </tr>
            <?php endif;?>
            
             <?php if($row['mother_cid'] != 0):?>
            <tr>
                <td>Mother Country</td>
                <td><b><?php echo getcountry($row['mother_cid']);?></b></td>
            </tr>
            <?php endif;?>
            
            
             <?php if($row['student_parent_email'] != ''):?>
            <tr>
                <td>Student Parent Email</td>
                <td><b><?php echo $row['student_parent_email'];?></b></td>
            </tr>
            <?php endif;?>

             <?php if($row['previous_school_name'] != ''):?>
            <tr>
                <td>Previous School Name</td>
                <td><b><?php echo $row['previous_school_name'];?></b></td>
            </tr>
            <?php endif;?>

             <?php if($row['address'] != ''):?>
            <tr>
                <td style="vertical-align:top;">Present Address</td>
                <td><b><?php echo $row['address'];?></b>
                    <div id="map" style="width:200px;height:200px;border-radius:50%;"></div>
                </td>
            </tr>
            <?php endif;?>

             <?php if($row['permanent_address'] != ''):?>
            <tr>
                <td style="vertical-align:top;">Permanent Address</td>
                <td><b><?php echo $row['permanent_address'];?></b>
                    <div id="map1" style="width:200px;height:200px;border-radius:50%;"></div>
                </td>
            </tr>
            <?php endif;?>

            

             <?php if($row['occupation'] != ''):?>
            <tr>
                <td>Occupation</td>
                <td><b><?php echo $row['occupation'];?></b></td>
            </tr>
            <?php endif;?>

             <?php if($row['income_per_annum'] != ''):?>
            <tr>
                <td>Income(per Annum)</td>
                <td><b><?php echo $row['income_per_annum'];?></b></td>
            </tr>
            <?php endif;?>
            
        </table>
	</div>
	</center>
        <!--<iframe class="google_map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $row['address'];?>&output=embed&iwloc=near"></iframe>-->
        
    
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&extension=.js"></script>
    <script>
    jQuery(document).ready(function () {
        var map;
		var map1;
        var centerPosition = new google.maps.LatLng(40.747688, -74.004142);

        var style = [{
            "stylers": [{
                "visibility": "on"
            }]
        }, {
            "featureType": "road",
                "stylers": [{
                "visibility": "on"
            }, {
                "color": "#ffffff"
            }]
        }, {
            "featureType": "road.arterial",
                "stylers": [{
                "visibility": "on"
            }, {
                "color": "#fee379"
            }]
        }, {
            "featureType": "road.highway",
                "stylers": [{
                "visibility": "on"
            }, {
                "color": "#fee379"
            }]
        }, {
            "featureType": "landscape",
                "stylers": [{
                "visibility": "on"
            }, {
                "color": "#f3f4f4"
            }]
        }, {
            "featureType": "water",
                "stylers": [{
                "visibility": "on"
            }, {
                "color": "#7fc8ed"
            }]
        }, {}, {
            "featureType": "road",
                "elementType": "labels",
                "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [{
                "visibility": "on"
            }, {
                "color": "#83cead"
            }]
        }, {
            "elementType": "labels",
                "stylers": [{
                "visibility": "on"
            }]
        }, {
            "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [{
                "weight": 1
            }, {
                "visibility": "off"
            }]
        }]
        
        var image = {
            url: 'https://dl.dropboxusercontent.com/u/814783/fiddle/marker.png',
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 0)
        };
        var shadow = {
            url: 'https://dl.dropboxusercontent.com/u/814783/fiddle/shadow.png',
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 0)
        };
        var marker = new google.maps.Marker({
            position: centerPosition,
            map: map,
            icon: image,
            shadow: shadow
        });
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
          zoom: 12,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        map.setOptions({
                styles: style
            });
            
            
        var address = "<?php echo $row['address'];?>";
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
          } else {
            //alert("Geocode was not successful for the following reason: " + status);
          }
        });
		
		map1 = new google.maps.Map(document.getElementById("map1"), mapOptions);
        map1.setOptions({
                styles: style
            });
            
            
        var address1 = "<?php echo $row['permanent_address'];?>";
        geocoder.geocode( { 'address': address1}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map1.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map1,
                position: results[0].geometry.location
            });
          } else {
            //alert("Geocode was not successful for the following reason: " + status);
          }
        });
		
    });
    
    
    
    
    </script>

<?php endforeach;?>