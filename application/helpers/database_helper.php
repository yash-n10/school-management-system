<?php
/**
 * Object to Array
 *
 * Takes an object as input and converts the class variables to array key/vals
 * Uses the magic __FUNCTION__ callback method for multi arrays.
 *
 * $array = object_to_array($object);
 * print_r($array);
 * 
 * @param object - The $object to convert to an array
 * @return array
 */
if(!function_exists('navigation_acedemicsession'))
{
	function navigation_acedemicsession()
	{
             //get main CodeIgniter object
            $ci = & get_instance();
             //load databse model
            $ci->load->model('dbconnection');
            //get data from database
            $accseesion = $ci->dbconnection->Get_namme("accedemic_session", "active", "Y", "session");;

            return $accseesion;
        
	}
}

// --------------------------------------------------------------------


if(!function_exists('dash_per_month_amount'))
{
	function dash_per_month_amount($yearquery,$mon,$yearmn,$strquery3)
	{
             //get main CodeIgniter object
            $ci = & get_instance();
             //load databse model
            $ci->load->model('dbconnection');
            //get data from database
            $amount = $ci->dbconnection->select("fee_transaction_head","count(if(collection_centre='FCLB',id,NULL)) as on_cnt,"
                    . "count(if(collection_centre!='FCLB',id,NULL)) as off_cnt,sum(if(collection_centre='FCLB',total_amount,0)) as amnt, "
                    . "sum(if(collection_centre!='FCLB',total_amount,0)) as amt", "$yearquery Month(payment_date)=$mon and "
                            . "Year(payment_date)=$yearmn  and response_code=0 and paid_status=1 $strquery3");

            return $amount;
        
	}
}

// --------------------------------------------------------------------


if(!function_exists('dash_payment_analytics'))
{
	function dash_payment_analytics($yearquery,$mon,$yearmn)
	{
             //get main CodeIgniter object
            $ci = & get_instance();
             //load databse model
//            $ci->load->model('dbconnection');
            //get data from database
            $payment_analytics = $ci->db->query("SELECT count(scount) success_count, count(fcount) failure_count, count(gcount) visiting_count,"
                    . "count(halfcount) hcount FROM ( SELECT  CASE WHEN response_code=0 THEN 1 ELSE NULL END scount,   "
                    . "CASE WHEN response_code=2  THEN 1 ELSE NULL END  fcount,  CASE WHEN response_code=1  THEN 1 ELSE NULL END  gcount,"
                    . "CASE WHEN response_code=0 and response_status=0  THEN 1 ELSE NULL END  halfcount from fee_transaction_head "
                    . "where $yearquery MONTH(payment_date)=$mon and Year(payment_date)=$yearmn and collection_centre='FCLB') t")->result();

            return $payment_analytics;
        
	}
}

// --------------------------------------------------------------------

/**
 * Object to Array
 *
 * Takes an object as input and converts the class variables to array key/vals
 * Uses the magic __FUNCTION__ callback method for multi arrays.
 *
 * $array = object_to_array($object);
 * print_r($array);
 * 
 * @param object - The $object to convert to an array
 * @return array
 */
if(!function_exists('menu'))
{
	function menu($usergroupid,$parentnode,$level,$school_id)
	{
		 //get main CodeIgniter object
                $ci = & get_instance();

                //get data from database
//                switch($usergroupid){
//                    case '1' : 
                        $menulist = $ci->db->query("SELECT lp.*,ug.user_group_id,(select m_code from crmfeesclub.module where id=lp.module_id) module FROM crmfeesclub.link_page lp "
                                . "inner join crmfeesclub_$school_id.user_group_permission ug on lp.id=ug.link_code "
                                . "where  ug.user_group_id=$usergroupid and ug.permission like '%R%' and lp.parent_node=$parentnode and lp.level=$level;")->result_array();
//                        break;
//                    default :
//                        $menulist = $ci->db->query("SELECT lp.*,ug.user_group_id FROM crmfeesclub.link_page lp "
//                                . "inner join crmfeesclub.user_group_permission ug on lp.id=ug.link_code "
//                                . "inner join crmfeesclub.school_modules sm on sm.module_id=lp.module_id "
//                                . "where  ug.user_group_id=$usergroupid and ug.permission like '%R%' and lp.parent_node=$parentnode and lp.level=$level;")->result_array();
//                        
//                }
             

                return $menulist;
	}
}

// --------------------------------------------------------------------
if(!function_exists('submenu'))
{
	function submenu($usergroupid,$parentnode,$level,$school_id)
	{
		 //get main CodeIgniter object
                $ci = & get_instance();

                //get data from database
//                switch($usergroupid){
//                    case '1' : 
                        $menulist = $ci->db->query("SELECT lp.*,ug.user_group_id,(select m_code from crmfeesclub.module where id=lp.module_id) module FROM crmfeesclub.link_page lp "
                                . "inner join crmfeesclub_$school_id.user_group_permission ug on lp.id=ug.link_code "
                                . "where  ug.user_group_id=$usergroupid and ug.permission like '%R%' and lp.parent_node=$parentnode and lp.level=$level order by lp.priority;")->result_array();
//                        break;
//                    default :
//                        $menulist = $ci->db->query("SELECT lp.*,ug.user_group_id FROM crmfeesclub.link_page lp "
//                                . "inner join crmfeesclub.user_group_permission ug on lp.id=ug.link_code "
//                                . "inner join crmfeesclub.school_modules sm on sm.module_id=lp.module_id "
//                                . "where  ug.user_group_id=$usergroupid and ug.permission like '%R%' and lp.parent_node=$parentnode and lp.level=$level;")->result_array();
//                        
//                }
             

                return $menulist;
	}
}

// --------------------------------------------------------------------



/**
 * Array to Object
 *
 * Takes an array as input and converts the class variables to an object
 * Uses the magic __FUNCTION__ callback method for multi objects.
 *
 * $object = array_to_object($array);
 * print_r($object);
 * 
 * @param array - The $array to convert to an object
 * @return object
 */
if(!function_exists('array_to_object'))
{
	function array_to_object($array)
	{
		$object = new stdClass;
		foreach($array as $key => $value)
		{
			if(is_array($value))
				$object->{$key} = array_to_object($value);
			else
				$object->{$key} = $value;
		}

		return $object;
	}
}
