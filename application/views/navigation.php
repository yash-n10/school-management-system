<aside class="main-sidebar stickysidebar">   
	<section class="sidebar">      
		<div class="user-panel jumbotron" style="box-shadow: 1px 1px 1px #ddd; padding:3px 6px 3px 6px;">
			<div class="pull-left image" style='height:85px !important'>
				<?php
				$logofile = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
                
				if (file_exists($logofile)) {
					echo "<img width='100px' style='' src=" . base_url() . $logofile . ">\n";
	//				echo "<img width='100px' style='' src=" . base_url() . 'assets/img/' . $this->session->userdata('school_id') . '.JPG' . ">\n";
				}
                
				if (!empty($this->session->userdata('school_id')) || $this->session->userdata('school_id') == 0)
					$accseesion = navigation_acedemicsession();
				else
					$accseesion = '';
				?>
			</div>
            
			<div class="pull-left info text-wrap" style="color:#043149; ">
				<p style="white-space: normal; line-height:normal; font-size:medium; color:darkred; text-transform:uppercase; ">
						<?php echo $this->session->userdata('school_name'); ?></p>
				<p style="font-size:12px; color:grey;">
					<?php
					if (!empty($accseesion)) {
						echo 'Session : &nbsp;' . $accseesion ;
					}
				?></p>
				
				<p class="login_type" style="font-size:11px; color:#3cb334;  text-transform:uppercase;">
						<i class="fa fa-circle" style="color:#3cb334;font-size:10px;margin-top:-10px;">&nbsp;</i>
					<?php 
					$login_type = $this->session->userdata('login_type');
					echo ucwords($login_type);
					?>
				</p>  
			</div>
		</div>

		<ul class="sidebar-menu jumbotron" id="myNav" data-widget="tree">       
			<?php
			function tree_builder($navtitle, $navitem, $navlevel, $uriarray, $usergroupid, $a, $school_id) {
				if (in_array($navitem['module'], $a) || $usergroupid==1) {
					$urlparts = explode('/', $navitem['url']);
					$pagename = end($urlparts);

					if (isset($uriarray[$navlevel]) && $uriarray[$navlevel] == $pagename)
						$active = 'active';
					else
						$active = '';

					if ($navitem['link']=='TRUE')
						$href = base_url($navitem['url']);
					else
						$href = '#';
            
					$tabs = str_repeat("\t", $navlevel);
                
					if (ENVIRONMENT == 'development')
						echo "\n<!-- Title: $navtitle, Level: $navlevel - Page Name: $pagename URI Entry: " . (isset($uriarray[$navlevel]) ? $uriarray[$navlevel] : "N/A") . "-->\n";

					if ($navitem['children']=='FALSE') {
						if ($active != '')
							echo "$tabs<li class='$active'>";
						else
							echo "$tabs<li>";
                    
						echo "<a href='$href'><i class='fa " . $navitem['icon'] . "'></i> <span>$navtitle</span></a></li>";
					
					} else {
						echo "$tabs<li class='treeview $active'>\n";
						echo "$tabs\t<a href='$href'><i id='ico' class='fa " . $navitem['icon'] . "'></i> <span class='nav-title'>$navtitle</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span></a>\n";
						echo "$tabs\t<ul class='treeview-menu'>\n";
						$menulistq= submenu($usergroupid, $navitem['parent_node'], $navlevel + 1, $school_id);
                    
						foreach ($menulistq as $childkey => $childvalue) {
							$childitem=array(
										'icon'		=> $childvalue['l_icon'],
										'url'		=> $childvalue['l_url'],
										'link'		=> ($childvalue['children_status']=='FALSE')?'TRUE':'FALSE',
										'children'	=> $childvalue['children_status'],
										'parent_node'=> $childvalue['id'],
										'module'	=> $childvalue['module'],
									);
                        
							tree_builder($childvalue['l_name'], $childitem, $navlevel + 1, $uriarray, $usergroupid, $a, $school_id);
						}
						echo "$tabs\t</ul>";
						echo "$tabs</li>";
					}
				}
			}

			$uriarray = $this->uri->segment_array();
			$navlevel = 1;
			$a = array();
       
			foreach ($this->session->userdata('sch_modules') as $r) {
				array_push($a, $r->modules);
			}

			$school_id = $this->session->userdata('school_id');

			array_push($a, 'common');
			$menulist = menu($this->session->userdata('user_group_id'), 0, $navlevel, $school_id);
        
			foreach ($menulist as $navkey => $navvalue) {
				$navitem=array(
							'icon'		=> $navvalue['l_icon'],
							'url'		=> $navvalue['l_url'],
							'link'		=> ($navvalue['children_status']=='FALSE')?'TRUE':'FALSE',
							'children'	=> $navvalue['children_status'],
							'parent_node' => $navvalue['id'],
							'module'	=> $navvalue['module'],
				);

				tree_builder($navvalue['l_name'], $navitem, $navlevel, $uriarray,$this->session->userdata('user_group_id'),$a,$school_id);
			}
			?>
		</ul>
	</section>
</aside>