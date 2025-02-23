<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('get_sms'))
{
	function get_sms($template,$student_name = '',$father_name='',$class='') {
                 $msg = $template;
                 if($student_name!='')
                 {
                     $msg = str_replace("%student%", $student_name, $msg);
                 }
                 if($father_name!='')
                 {
                    $msg = str_replace("%father%", $father_name, $msg);
                 }
                 if($class!='')
                 {
                   $msg = str_replace("%class%", $class, $msg);
                 }
		return $msg;
	}
}

if ( ! function_exists('get_students_by_class_id'))
{
     function get_students_by_class_id($class_id,$format='json')
     {
                $CI	= &get_instance();
		$CI->load->database();
                $CI->db->select('student_id as value,name as text');
                $CI->db->from('student');
                $CI->db->where('class_id',$class_id);
                $query = $CI->db->get();
                $students_data = $query->result();
                return json_encode($students_data);

     }
}


if(!function_exists('send_sms'))
{
   function send_sms($to,$msg)
   {
       //http://www.smsmyntra.com/
       $url = "http://sms.smsmyntra.com/api/sendmsg.php?user=EduCloudCampus&pass=q12345&sender=ECCMPS&phone=%s&text=%s&priority=ndnd&stype=normal";
//       $url = "http://sms.bulksmsind.in/sendSMS?username=mildrix&message=hello&sendername=XYZ&smstype=TRANS&numbers=8210471962&apikey=08052465-9d8d-4913-b6d1-f3f58a817623";
	   
       //$msg = urlencode ( $msg );
       $url = sprintf($url,$to,$msg);
       echo $url;
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('X-Mashape-Authorization: YEOmdmfwvW4kIbLLCYYCL3BqRSX9inDp'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
   }
}


if(!function_exists('send_sms_biz'))
{
   function send_sms_biz($mob_number,$message_content)
   {
        $username = "Jagan@mildtrix.com";
        $password = "Inspiron6411";
        $approved_senderid = "FECLUB";
        $mob_number = "$mob_number";
        $message = $message_content;
        $enc_msg = rawurlencode($message); // Encoded message
        $fullapiurl = "http://smsc.biz/httpapi/send?username=$username&password=$password&sender_id=$approved_senderid&route=T&phonenumber=$mob_number&message=$enc_msg";
        $ch = curl_init($fullapiurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
   }
}



if(!function_exists('send_bulksmsind'))
{
   function send_bulksmsind($to,$msg,$sender)
   {
       $msg = urlencode ($msg);
       $url = "http://sms.bulksmsind.in/sendSMS?username=mildrix&message=$msg&sendername=$sender&smstype=TRANS&numbers=$to&apikey=08052465-9d8d-4913-b6d1-f3f58a817623";
	   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $json= json_decode($response);
        $arr['responseCode']=$json[0]->responseCode;
        $arr['msgid']=$json[1]->msgid;
        return $arr;
   }
}


if(!function_exists('send_bulksmsind_vv'))
{
   function send_bulksmsind_vv($to,$msg,$sender)
   {
       $msg = urlencode ($msg);
       $url = "http://sms.bulksmsind.in/sendSMS?username=mildrix&message=$msg&sendername=$sender&smstype=TRANS&numbers=$to&apikey=08052465-9d8d-4913-b6d1-f3f58a817623";
     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $json= json_decode($response);
        $arr['responseCode']=$json[0]->responseCode;
        $arr['msgid']=$json[1]->msgid;
        return $arr;
   }
}


if(!function_exists('send_smstomountc'))
{
   function send_smstomountc($to,$msg,$sender)
   {
       $msg = rawurlencode ($msg);
       $sender = urlencode($sender);
       
//       $url = "http://sms.stormesoft.com/api2/send/?username=manjalyocd@gmail.com&hash=4cde6b4d745b626aa7af731367bbe020268fea72&numbers=$to&sender=$sender&message=$msg";
	   
       // Prepare data for POST request
	$data = array('username' => "manjalyocd@gmail.com", 
                    'hash' => "4cde6b4d745b626aa7af731367bbe020268fea72", 'numbers' => $to, "sender" => $sender, "message" => $msg);

	// Send the POST request with cURL
	$ch =  curl_init('http://sms.stormesoft.com/api2/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
//		return $response;
                $json= json_decode($response);
        $arr['responseCode']=$json->status;
        $arr['msgid']=$json->messages[0]->id;
        return $arr;

      
   }
}


if(! function_exists('send_sms_template'))
{
   function send_sms_template($student_id,$class_id,$msg)
   {
                  $CI	= &get_instance();
		  $CI->load->database();
                  $student_name =  $CI->db->select('name')->from('student')->where('student_id', $student_id)->get()->row()->name;
                  $father_name = $CI->db->select('name')->from('parent')->where('student_id', $student_id)->get()->row()->name;
                  $class_name = $CI->db->select('name')->from('class')->where('class_id', $class_id)->get()->row()->name;
                 if(strpos($msg,'%student%') !== false)
                 {
                     $msg = str_replace("%student%", $student_name, $msg);
                 }
                 if(strpos($msg,'%father%') !== false)
                 {
                    $msg = str_replace("%father%", $father_name, $msg);
                 }
                 if(strpos($msg,'%class%') !== false)
                 {
                   $msg = str_replace("%class%", $class, $msg);
                 }
                 //echo $msg;
                 $to = get_parent_number($student_id);
                 if($to !=NULL && $to != "" )
                 {
                     //echo sprintf("sent to %s successfully message is %s",$to,$msg); 
                 }
                 
                 //print_r(send_sms($to,$msg));
		 return $msg;
   }

}

if(!function_exists('send_sms_to_class')){
    function send_sms_to_class($class_id,$msg){
         $CI	= &get_instance();
   $CI->load->database();
   $students = $CI->db->select('student_id')->from('student')->where('class_id', $class_id)->get()->result();
   foreach($students as $student){
       $to = get_parent_number($student->student_id);
       send_sms_template($student->student_id,$class_id,$msg);
   }
       return 0;
    }
}

if(!function_exists('get_parent_number')){
    function get_parent_number($student_id){
       //$students = $this->db->get
       $CI	= &get_instance();
       $CI->load->database();
       return $CI->db->select('phone')->from('parent')->where('student_id', $student_id)->get()->row()->phone;
    }
}


if(!function_exists('send_tam_sms'))
{
   function send_tam_sms($to,$msg)
   {
      	$URL = "http://182.18.165.185/API/sms.php";
		$post_fields = array(
			'username' => 'varun7king',
			'password' => 'varun7king',
			'from' => 'TAMSMS',
			'to' => $to,
			'msg' => $msg
		);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		//curl_exec($ch);
		return curl_exec($ch);
   }
}