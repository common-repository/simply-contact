=== Simply Contact ===
Contributors: Raja Mohammed
Donate link:  http://cthreelabs.com/simply-contact.php#donate
Tags: contact form, reCaptcha 
Requires at least: 3.0.1
Tested up to: 3.9.2
Stable tag: 0.2

A simple contact form powered by Google reCaptcha.

== Description ==

A simple contact form powered by Google reCaptcha.
The user needs to have a valid Google reCaptcha keys generated for their domain.

The form can easily be pulled into any page using the short code [SC]

Requirements 

* Google reCaptcha keys Public and private keys generated for their site.
* A valid email id preferably carrying the same domain name as their website.
* if your site name is www.cthreelabs.com then the mail id should be xxxx@cthreelabs.com.
* The form is tested with out any additional plugin for SMTP configuration and works well and good.
* The form may require  WP Mail SMTP pluign if the form fails to send mail (optional).
* Using WP Mail SMTP plugin along with Simply Contact will enable the user to send mail to Gmail account provided the user configures the WP MAIL SMTP as described. 
* Requires wordpress 3.0.1 and above.

== Installation ==

1. Download.
2. Upload to your `/wp-contents/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. To disply the form Type the shortcode - [SC]	 including the square brackets.
5. If necessary install WP MAIL SMTP plugin - read Description.

== Frequently Asked Questions ==

= How do i display the Contact Form on any page =

Type [SC] where you want the form to be displayed

= How Can I use this plugin to receive email to my Gmail account  =

Install WP MAIL SMTP plugin and Use these settings:

Mailer: SMTP
SMTP Host: smtp.gmail.com
SMTP Port: 465
Encryption: SSL
Authentication: Yes
Username: your full gmail address
Password: your mail password

= Can you add more features to the plugin? =

This is a initial release probably some additional feature coming soon . 


= I need a contact form plugin custom made can you help me . =

please contact me to discuss on custom contact form. I can help you on certain condition but all request are not accepted . I can be contacted here:
<hello@cthreelabs.com>
<http://www.cthreelabs.com/simply-contact.php>


== Other Notes ==
The default theme of the contact form is clean , please refer the screen shot.
The form size is set at minimum width of 450px , it is adviced to place the form in a container greater than 450px .
The form is not responsive !.  

=Customize Contact form appearance =

You can customize the contact form using the following CSS classes 

Form container div  -> .sc-form-container ,
All input fields    -> .sc-input ,
All the labels      -> .sc-text ,
Fields container    -> .simplyContact p ,
Important fields #  -> .simply-imp ,
Submit Button       -> .simply-submit ,
reCaptcha text area -> .recaptcha_input_area > input (use !important declaration to override google styles) ,
Succes Message      -> .simply-success ,
Failure Message     -> .simply-failure ,

Add this to your Custom style sheer to remove Google reCaptcha image and privacy policy in captcha input area 

--> #recaptcha_logo, #recaptcha_privacy{
  display:none !important;
}


== Screenshots ==

1. Screenshot of the Form .

== Changelog ==

= 0.2 =
*Initial Stable release 


== Upgrade Notice ==


