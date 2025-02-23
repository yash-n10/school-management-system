<style>
    .stickysidebar {
        position: fixed!important;

        /*                overflow:auto;
        height:100%;*/

    }
</style>

<aside class="main-sidebar stickysidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel" style="    box-shadow: 1px 2px 1px #ddd">
            <div class="pull-left image" style='height:80px !important'>
                <?php
//$logofile = 'uploads/' . $this->session->userdata('school_code') . '/' . $this->session->userdata('school_code') . 'logo.png';
                $logofile = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
                if (file_exists($logofile)) {
//	echo "<img width='100px' src=" . base_url() . 'uploads/' . $this->session->userdata('school_code') . '/' . $this->session->userdata('school_code') . 'logo.png?ts=' . filemtime($logofile) .  ">\n";
                    echo "<img width='100px' style='height:100%' src=" . base_url() . 'assets/img/' . $this->session->userdata('school_id') . '.JPG' . ">\n";
                }
                if (!empty($this->session->userdata('school_id')) || $this->session->userdata('school_id') == 0)
                    $accseesion = navigation_acedemicsession();
                else
                    $accseesion = '';
                ?>
            </div>
            <div class="pull-left info">
                <p style="white-space: pre-line;line-height: normal;font-size: medium;text-shadow: 2px 2px lightgrey;
                   font-style: oblique;color:darkred"><?php echo $this->session->userdata('school_name'); ?></p>
                <p> <?php
                    if (!empty($accseesion)) {
                        echo '( ' . $accseesion . ' )';
                    }
                    ?></p>
            </div>
        </div>

        <!-- search form (Optional) -->
        <!--      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
        </button>
        </span>
        </div>
        </form> -->
        <!-- /.search form -->
        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" id="myNav" data-widget="tree" >
            <li class="header">NAVIGATION</li>
                <?php

                function tree_builder($navtitle, $navitem, $navlevel, $uriarray,$usergroupid,$a,$school_id) {

                    if (in_array($navitem['module'], $a) || $usergroupid==1) {

                        $urlparts = explode('/', $navitem['url']);
//                        if (isset($navitem['custom_link']))
//                            $pagename = $navitem['custom_link'];
//                        else
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
                            echo "<a href='$href'><i class='fa " . $navitem['icon'] . "'></i> <span>$navtitle</span></a></li>\n";
                        } else {
                            echo "$tabs<li class='treeview $active'>\n";
                            echo "$tabs\t<a href='$href'><i class='fa " . $navitem['icon'] . "'></i> <span>$navtitle</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span></a>\n";
                            echo "$tabs\t<ul class='treeview-menu'>\n";
                            $menulistq= submenu($usergroupid, $navitem['parent_node'], $navlevel + 1,$school_id);
                            foreach ($menulistq as $childkey => $childvalue) {
                                $childitem=array(
                                    'icon'=>$childvalue['l_icon'],
                                    'url'=>$childvalue['l_url'],
                                    'link'=>($childvalue['children_status']=='FALSE')?'TRUE':'FALSE',
                                    'children'=>$childvalue['children_status'],
                                    'parent_node'=>$childvalue['id'],
                                    'module'=>$childvalue['module'],
                                );
                                tree_builder($childvalue['l_name'], $childitem, $navlevel + 1, $uriarray,$usergroupid,$a,$school_id);
                            }
                            echo "$tabs\t</ul>\n";
                            echo "$tabs</li>\n";
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
                
                $menulist= menu($this->session->userdata('user_group_id'), 0, $navlevel,$school_id);
         
                foreach ($menulist as $navkey => $navvalue) {
                    $navitem=array(
                        'icon'=>$navvalue['l_icon'],
                        'url'=>$navvalue['l_url'],
                        'link'=>($navvalue['children_status']=='FALSE')?'TRUE':'FALSE',
                        'children'=>$navvalue['children_status'],
                        'parent_node'=>$navvalue['id'],
                        'module'=>$navvalue['module'],
                    );

                    tree_builder($navvalue['l_name'], $navitem, $navlevel, $uriarray,$this->session->userdata('user_group_id'),$a,$school_id);
                    
                }
                ?>
        </ul>

        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

