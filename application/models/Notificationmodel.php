<?php 
class Notificationmodel Extends CI_Model{
   
 public function savenotification($postdata = "", $file = "")
    {
        /*print_r($postdata);
        print_r($file); die;*/
        $type = 1;
        if (!empty($file)) {
            $errors         = array();
            $desired_dir    = "uploads/notification";
            $key            = uniqid();

            $file_name = $file['name'];
            $file_size = $file['size'];
            $file_tmp  = $file['tmp_name'];
            $file_type = $file['type'];

            $filearr   = explode('.', $file['name']);
            $file_name = 'Not' . $key . time();
            $filename  = $file_name . '.' . $filearr[1];
            //die;
            if (is_dir($desired_dir) == false) {
                mkdir("$desired_dir", 0700);
            }
            if (is_dir("$desired_dir/" . $filename) == false) {
                move_uploaded_file($file_tmp, "$desired_dir/" . $filename);
            } else {
                $new_dir = "$desired_dir/" . $filename . time();
                rename($file_tmp, $new_dir);
            }
            $imgdata   = array('image' => $filename, 'extension' => $filearr[1], 'path' => base_url().'uploads/notification');
            $file_name = $this->db->insert('media', $imgdata);
            $file_name = $this->db->insert_id();
        } else {
            $file_name = 0;
        }
		if (isset($postdata['select_user']) && is_array($postdata['select_user']) && count($postdata['select_user'])>0) {
            #$id   = $postdata['user_id'];
            $postdata['user_id'] = implode(',', $postdata['select_user']);
            $id = json_encode($postdata['select_user']);
            $type = 2;
        } else {
            $id = '0';
        }
		$current_datetm = date('Y-m-d H:i:s');
		
        $data = array(
            'user_id'              => $id,
            'subject'              => $postdata['subject'],
            'notification_message' => $postdata['nmessage'],
            'image'                => $file_name,
            'type'                 => $type,
            'status'               => '1',
            'create_date '         => $current_datetm,
        );
        $query     = $this->db->insert('notification', $data);
        $insert_id = $this->db->insert_id();
		 // print_r($insert_id);
		 // die();
        /*return true;
        die;   */
        $send_notification = $this->send_notifications($postdata['user_id'], $postdata['subject'], $postdata['nmessage'], $filename, $current_datetm, $insert_id);
		// print_r($send_notification);
		// die();
        $this->session->set_userdata('success', 'notification sent successfully.');
        return true;
    }

    PUBLIC FUNCTION send_notifications($userId,$subject,$message,$filename,$current_datetm,$insert_id)
    {
        //$this->load->model('user/change_model');
        //echo $userId;die;
        // $androidkey='AAAADNWO3Dk:APA91bE4fiYsxqbJS1wm0HKZBgq2cl3BXJjmd909dS_8QWvyU4hukpa8ADWc9uiLh9ZrqrQbS_88BtVpgKGnQC67YRhdgDnFyuNAc8u27CZ7kxmeg47doE-y4WoxYWmy9k6HJHmF_d4k';
		
		$androidkey='AAAAdX6EuTk:APA91bGW1Z5cza3WYrh2cIj291Q37EhVolWjdu6Yh83JZAETg7_U3UyaUxOIthjLc5g7FAll7BLOSN4ZOIEbccpfTXGkwotDcDiIYwGEWiC9RFfsHClApWP4V3YbAeh0_DVAbroP191d';
		
		     
        $ioskey='AAAAjYxTXmc:APA91bHaMp_LQzmsk1_BueyVz5WZHCL4S_5J_-3CsUreiJPNI_6HTzCWa7QLn1Q_IOyhAzPweg7JceKSNpZ1e95Q61TEi8HpldmRGhAmjwwyuyqnDxectJz2C7Qp2KPavfLUEv8aOwLx';
if(empty($insert_id)){
			$insert_id = "";     		
		}		
		if(empty($filename)){	   	       	
			$filename = "";		
		}else{
			$filename = base_url().'uploads/notification/'.$filename;
		}		
		if(empty($subject)){			
			$subject = "";		
		}		
		if(empty($message)){			
			$message = "";		
		}		
		if(empty($current_datetm)){			
			$current_datetm = date('Y-m-d H:i:s');		
		}

        $message1 = array(

                'image' => $filename,

                'body'=> $subject,
                'id'=> $insert_id,
                //'message'=>$message,
                'title'=>$message,

                'time'=>$current_datetm,

         );
		 // print_r($message1);
		// die();
        $userId = $userId == '' ? 'All' : $userId;

        $android_data = $this->GetDeviceToken($userId,1);
		// print_r($android_data);
		// die();
        if ($android_data) {
			
            /**$android_names = array_column($android_data, 'device_token');
            $fields        = array(
                'registration_ids' => $android_names,
                'data'             => array('body'=>$message1),
            );
			
            $result = $this->AndroidpushNotification($fields);**/
			foreach ($android_data as $ad) {
//echo "<pre>";print_r($ad); die();
                $registrationIds = $ad['device_id'];
                //die();
                $msg = array(
                    #'title' => $subject,
                    'body' => json_encode($message1)
                );
                $fields = array(
                    'to' => $registrationIds,
                    'data' => $msg
                );
// print_r($fields); die();
                $result = $this->AndroidpushNotification($fields);
                print_r($result);
            }//die;
        }
        // $ios_data = $this->GetDeviceToken($userId,2);
        // if($ios_data){
          // $ios_names = array_column($ios_data, 'device_token');
          // foreach ($ios_names as $key => $iostoken) {
            // $push_inotification = $this->IosNotificationAPN($iostoken,$subject,$message,$ioskey,$filename);
          // }
        // }
    }
    PUBLIC FUNCTION IosNotificationAPN ($device_token,$subjecct,$message,$apikey,$image)
    {

        $filepath=$_SERVER['DOCUMENT_ROOT'].'/assets/CertificatesProduction-2.pem'; //developement
         $pass = "123456";
         
          $deviceToken = $device_token;
          $message = array
                (
                  'title' => $subjecct,
                  'body'  => $message,
                  'time' => date('H:m:s')/*Default sound*/
                );
          
          $badge = 1;
          $sound = 'default';
         
          $body = array();
          $body['aps'] = array('alert' => $message);
     
          if ($badge)
                $body['aps']['badge'] = $badge;
          if ($sound)
                $body['aps']['sound'] = $sound;
     
          $ctx = stream_context_create();
          stream_context_set_option($ctx, 'ssl', 'local_cert', $filepath);
     
          stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
        //  $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 120, STREAM_CLIENT_CONNECT, $ctx);
          
           $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 120, STREAM_CLIENT_CONNECT, $ctx);
     
          if (!$fp) {
             //   print "Failed to connect $err $errstrn";
                return;
          } else {
              
              //  print "Connection OK\n";
          }
     
          $payload = json_encode($body);
          $deviceToken = sprintf('%u', CRC32(str_replace(' ', '', $deviceToken)));
          $msg = chr(0).pack('n',32);
          $msg .= pack('H*', $deviceToken);
          $msg .= pack('n',strlen($payload)).$payload;
          //die;
          fwrite($fp, $msg);
          fclose($fp);
        return true;
    }
    PUBLIC FUNCTION AndroidpushNotification($fields)
    {
      $headers = array(
            'Authorization: key=' .'AAAAdX6EuTk:APA91bGW1Z5cza3WYrh2cIj291Q37EhVolWjdu6Yh83JZAETg7_U3UyaUxOIthjLc5g7FAll7BLOSN4ZOIEbccpfTXGkwotDcDiIYwGEWiC9RFfsHClApWP4V3YbAeh0_DVAbroP191d ',
            'Content-Type: application/json'
        );
      $ch = curl_init(); 

      //Setting the curl url
      curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      
      //setting the method as post
      curl_setopt($ch, CURLOPT_POST, true);

      //adding headers 
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //disabling ssl support
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      
      //adding the fields in json format 
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

      //finally executing the curl request 
      $result = curl_exec($ch);
      //echo "ASEfasergte";
      //print_r($result); die;
      if ($result === FALSE) {
          die('Curl failed: ' . curl_error($ch));
      }
      //Now close the connection
      curl_close($ch);

     return $result;
  }
  // PUBLIC function GetDeviceToken ($ids,$deviceType)
  // {
    // $and = $ids=='All' ? '' : ' AND id IN ('.$ids.')';
    // $query = "SELECT device_token
    // FROM members 
    // WHERE isactive = 1 AND device_type=".$deviceType." ".$and."
    // GROUP BY id
    // ORDER BY id ASC";
    // $query=$this->db->query($query);
    // return $query->result_array();
  // }
  
  
  public function GetDeviceToken($ids, $deviceType)
    {
        $and   = $ids == 'All' ? '' : ' AND id IN (' . $ids . ')';
		$and   .= 'And  device_id != ""';
        $query = "SELECT id,device_id FROM users WHERE isactive = 1 " . $and . " GROUP BY id ORDER BY id ASC";
	
        $query = $this->db->query($query);
		//echo $this->db->last_query();die;
		
        return $query->result_array();
    }
  public function notification_data($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        $this->db->select('nf.id,nf.user_id,nf.image as upimage,nf.subject,nf.notification_message,nf.create_date,me.image,me.path');
        $this->db->from('notification nf');
        $this->db->join('media me', 'nf.image = me.id', 'left');
        $this->db->where(array('nf.status !=' => 3)); 
        $this->db->ORDER_BY('nf.id', 'DESC');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }
//class close
}
?>