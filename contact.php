<?php
$dir = plugin_dir_path( __FILE__ );
 require_once($dir.'recaptchalib.php');


 $options = get_option('SimplyContact_Options');
  if(isset($options['g_key_pri'])){
 	 $privatekey = $options['g_key_pri'];//$options['g_key_pri'];
 }


if(isset($options['to_email'])){
	$to_email = $options['to_email'];
}




  if(isset($_POST['contact'])){       
       $errors = array();
       $simply_result = array();
       if((empty($_POST['senderName'])) ||(empty($_POST['subject']))||
	    (valid_email($_POST['senderEmail']) == false) ||
	    (empty($_POST['senderComments']))){
	      /*If the form is not in right format then report error*/
	      $errors['all'] = "Fill in the necessary fields";
	       //echo '<script>alert("Fill in the necessary fields");</script>';
	      if(empty($_POST['senderName'])){
		     $errors['name']="Must be atleast 5 Characters";
		      //echo '<script>alert("name");</script>';
	      }
	      if(valid_email($_POST['senderEmail']) == false){
		     $errors['email']= "Enter a valid email";
		      //echo '<script>alert("email");</script>';
	      }
		  
		  if(empty($_POST['subject'])){
		  	$errors['subject'] = "Subject cannot be empty";
		  }
	      
	      if(empty($_POST['senderComments'])){
		     $errors['comments'] ="Must be atlest 15 characters long";
	      }
	      
	 }
       $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

       if (!$resp->is_valid) {
	  $errors['captcha']="Enter the code correctly";
	
       } else
	      {
		     if (empty($errors))
	      {
	      	
		
		   $name= htmlentities($_POST['senderName']);
		   $email = htmlentities($_POST['senderEmail']);
		   $sender_comments = htmlentities($_POST['senderComments']);
		   $subject = htmlentities($_POST['subject']);
		   $message = "<html><body><p>Sender : ".$name."</p>";
	       $message.= "<p>Sender Email : ".$email."</p>";
		   $message.= "<p>Message : </p> <p>".$sender_comments."</p></body></html>";
		   $to =  $to_email;
		   $reps = '-f'.$email;
		   // Mail header
		   $headers  = 'MIME-Version: 1.0' . "\r\n";
		   $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		   $headers .= 'From: '.$email. "\r\n";
		   $headers .= 'Reply-To: '.$email . "\r\n" . 'X-Mailer: PHP/' . phpversion();
  
		      if(wp_mail($to, $subject ,$message, $headers)){
			  $simply_result['success'] = "Your message has been sent ";
		      }
		      else{
			  $simply_result['failure'] ="Sorry cannot send message now try again later";
		      }
		   
	      }
	      
	      }
       
  
  
        
}
       
 /*
 *
 *Valid Email check
 *
 */
    function valid_email($email)
    {
          
            // First, we check that there's one @ symbol, and that the lengths are right
            if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
                // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
                return false;
            }
            // Split it into sections to make life easier
            $email_array = explode("@", $email);
            $local_array = explode(".", $email_array[0]);
            for ($i = 0; $i < sizeof($local_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                    return false;
                }
            }
            if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
                $domain_array = explode(".", $email_array[1]);
                if (sizeof($domain_array) < 2) {
                    return false; // Not enough parts to domain
                }
                for ($i = 0; $i < sizeof($domain_array); $i++) {
                    if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                        return false;
                    }
                }
            }
    
            return true;
    } 

  ?>


<div class="sc-form-container">

        <!-- contact form-->

     
         <!--// Display  Success -->   
        <?php if(isset($simply_result['success'])){
        
        ?><div class="simply-success">
		       <p class="imp"> Your Message has been sent </p>
		   </div>
        <?php }
        else if(isset($simply_result['failure'])) {
         ?><div class="simply-error">
               <p class="imp">'.$simply_result['failure'].'</p>
		   </div>
		
		<?php        
        }
	    // Display  error 
	    if (isset($errors['all'])){?>
	      <div class="error">
		     <div class="col-md-12">
		       <p class="imp"> Fields marked with <span class="orange">&#35;</span> are necessary</p>
		     </div>
		   </div> 
		   <?php
	      
	    }?>
	    
	     
		
            <form id="simply-contact" class="simplyContact" action="<?php the_permalink(); ?>" method="POST">
                	<!-- Name Field-->
                    <p><label for="sendername">Name</label>  <span class="simply-imp">&#35;</span><br>
		    
                    <input type="text" class="sc-input" name="senderName" value="<?php if(!isset($simply_result['success'])){if(isset($_POST['senderName'])){echo htmlentities($_POST['senderName']);}}?>">
				     <?php if (isset($errors['name'])){
					    echo '<p class="err"> '.$errors['name'].' </p>';
				     }?>
                     </p>
                  
                    <!-- Email Field-->
                    <p><label for="senderEmail">Email</label>  <span class="simply-imp">&#35;</span><br>
                   
		    		<input type="text" class="sc-input"  name="senderEmail" value="<?php if(!isset($simply_result['success'])){if(isset($_POST['senderEmail'])){echo htmlentities($_POST['senderEmail']);}}?>">
				      <?php if (isset($errors['email'])){
					    echo '<p class="err">'.$errors['email'].'</p>';
				     }?>
                    </p>
                    
				    <!-- Subject Field-->
                    <p><label for="subject">Subject</label>  <span class="simply-imp">&#35;</span><br>
                   
		    		<input type="text" class="sc-input"  name="subject" value="<?php if(!isset($simply_result['success'])){if(isset($_POST['subject'])){echo htmlentities($_POST['subject']);}}?>">
				      <?php if (isset($errors['subject'])){
					    echo '<p class="err">'.$errors['subject'].' </p>';
				     }?>
				     </p>

                
                    <!-- Message/Comment Field-->
                    <p> <label for="senderComments">Message</label>  <span class="simply-imp">&#35;</span><br>
				    <?php if (isset($errors['comments'])){
					    echo '<p class="err">'.$errors['comments'].'</p>';
				     }?>
                    <textarea class="sc-text"  name="senderComments" cols="25" rows="5"><?php if(!isset($simply_result['success'])){if(isset($_POST['senderComments'])){echo htmlentities($_POST['senderComments']);}}?></textarea>
                    </p>
                    
                     <!-- reCaptcha-->
			        <div class="simply-captcha">
				     <p> <label> Enter Code </label> <span class="simply-imp">&#35;</span> </p>
				     <?php if (isset($errors['captcha'])){
					    echo '<p class="err">'.$errors['captcha'].'</p>';
				     }?>
				     <script type="text/javascript">
				      var RecaptchaOptions = {
					 theme : 'clean'
				      };
				      </script>
				    <?php
				    
				     require_once($dir.'recaptchalib.php');
					 if(isset($options['g_key_pub'])){
					 	$publickey = $options['g_key_pub'];//$options['g_key_pub']; 
					 }
					 
				     
				     echo recaptcha_get_html($publickey);
				   	 ?>
			         </div>
	      
			      	<!-- Submit btn -->
		             <input class="simply-submit" type="submit" name="contact" value="Submit">
			      
            </form>
            <div class="plugin-name">
			<span>'Simply Contact'  WordPress plugin</span>
			</div>
</div>

