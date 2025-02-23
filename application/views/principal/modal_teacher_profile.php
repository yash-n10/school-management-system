
<?php
$teacher_info	=	$this->crud_model->get_teacher_info($current_teacher_id);
foreach($teacher_info as $row):?>
<center>
<div class="box">
	<div class="">
		<div class="title">
			<div class="title custom-tam-profile-block">
                
                    <div>
					<img src="<?php echo $this->crud_model->get_image_url('teacher' , $row['teacher_id']);?>" />
				    </div>
                    <div>
					<h3 style=" color:#666;font-weight:100;"><?php echo $row['name'];?></h3>
				  </div>
			</div>
		</div>
	</div>
    <br />
	<table class="table table-normal">

		<?php if($row['name'] != ''):?>
		<tr>
			<td width="150">Name</td>
			<td><b><?php echo $row['name'];?></b></td>
		</tr>
		<?php endif;?>
		
		<?php if($row['sex'] != ''):?>
		<tr>
			<td>Gender</td>
			<td><b><?php echo $row['sex'];?></b></td>
		</tr>
		<?php endif;?>

		<?php if($row['birthday'] != ''):?>
		<tr>
			<td>Birthday</td>
			<td><b><?php echo $row['birthday'];?></b></td>
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
		
		<?php if($row['email'] != ''):?>
		<tr>
			<td>Tam Username</td>
			<td><b><?php echo $row['email'];?></b></td>
		</tr>
		<?php endif;?>

		

		<?php if($row['blood_group'] != ''):?>
        <tr>
            <td>Blood Group</td>
            <td><b><?php echo $row['blood_group'];?></b></td>
        </tr>
        <?php endif;?>

        <?php if($row['previous_school_name'] != ''):?>
        <tr>
            <td>Previous School Name</td>
            <td><b><?php echo $row['previous_school_name'];?></b></td>
        </tr>
        <?php endif;?>
	
		<?php if($row['subject'] != ''):?>
		<tr>
			<td>Subject</td>
			<td><b><?php echo $row['subject'];?></b></td>
		</tr>
		<?php endif;?>
		
		<?php if($row['phone'] != ''):?>
		<tr>
			<td>Phone</td>
			<td><b><?php echo $row['phone'];?></b></td>
		</tr>
		<?php endif;?>

		<?php if($row['teacher_email'] != ''):?>
		<tr>
			<td>Teacher Email</td>
			<td><b><?php echo $row['teacher_email'];?></b></td>
		</tr>
		<?php endif;?>
		
		<?php if($row['employee_academicyear_id'] != ''):?>
		<tr>
			<td>Batch</td>
			<td><b><?php echo $this->crud_model->get_batch($row['employee_academicyear_id']);?></b></td>
		</tr>
		<?php endif;?>

		<?php if($row['father_name'] != ''):?>
		<tr>
			<td>Father/Husaband/Gurdian Name</td>
			<td><b><?php echo $row['father_name'];?></b></td>
		</tr>
		<?php endif;?>

		<?php if($row['father_mobile_number'] != ''):?>
		<tr>
			<td>Father/Husaband/Gurdian Mobile Number</td>
			<td><b><?php echo $row['father_mobile_number'];?></b></td>
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
	</table>
</center>
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