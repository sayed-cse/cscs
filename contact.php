<?php require(dirname(__FILE__) . '/header.php'); ?>
<section class="row">
	<article class="rc12">
		<div class="pad"><h1 class="head2 tal">CONTUCT US</h1></div>
	</article>
	<article class="rc12">
		<div class="rc6 pad">
<!--# #-->		
		<div class="gmap"></div>
<img src="<?php banner(); ?>" style="width:140px;height:100px;">		
		<p class="tal adb">
			21/155 hyde street Yarraville VIC 3013 Australia.<br>
			Tel:(03) 9687 6001 Fax:(03) 96896003<br>
			Email:info@citysight.com<br>
			www.citysight.com.au
		</p>			
<!--# #-->					
		</div>
		<div class="rc6 pad">
		<div class="taj adb">
				<p>Send us your contact details and we will have one of representatives reply to you shortly.</p>
<!--# #-->
<?php
if(isset($_POST['send']))
{
	if($errors = validate())
	{
		form($errors);
	}
	elseif($errors = process())
	{
		form($errors);
	}
}
else
{
	form();
}
function process() 
{
	$errors = array();
	$to = 'info@citysight.com.au';
	$cc = '';
	$bcc = '';
	$company_name = stripslashes($_POST['cname']);
	$from = stripslashes($_POST['cemail']);
	$phone = stripslashes($_POST['phone']);
	$suburb = stripslashes($_POST['subrub']);
	$postcode = stripslashes($_POST['pcode']);;
	$state = stripslashes($_POST['state']);
	$message = stripslashes($_POST['message']);;
	$subject = stripslashes($_POST['subrub']);

	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/html; charset=utf-8";
	$headers[] = "Content-Transfer-Encoding:7bit";
	$headers[] = "From: ".$from;
	$headers[] = "Cc: ".$cc;
	$headers[] = "Bcc: ".$bcc;
	$headers[] = "Reply-To: ".$from;
	$headers[] = "Return-Path: ".$from;
	$headers[] = "X-Originating-IP: " . $_SERVER['SERVER_ADDR'];
	$headers[] = "Senders IP: ".$_SERVER['REMOTE_ADDR'];	
	$headers[] = "Subject: ".$suburb;
	$headers[] = "X-Mailer: PHP/".phpversion();
	$post_email = mail($to, $subject,
		'<html><body><h1 style="margin:1px;padding:2px 4px 2px 4px;background-color:#5A8226;color:#fff">'.$subject.'</h1>
		<p>
			<b>Company Name :</b> '.$company_name.'<br>
			<b>Message :</b> '.$message.'<br><br>
			<b>From :</b> '.$from.'<br>
			<b>Phone :</b> '.$phone.'<br>
			<b>Postcode :</b> '.$postcode.'<br>
			<b>State :</b> '.$state.'<br>
			<b>Suburb :</b> '.$suburb.'<br>
		</p>
		</body></html>', implode("\r\n", $headers), "-f $from");
#<!-- -->   	
	if($post_email == true)
	{
		$errors[] = '<b class="true">Your request has been send.</b>';
		#var_dump($post_email);exit();
	}
	return $errors;
}
#
function validate() 
{
	session_start();
# Start with an empty array of error messages
	$errors = array();
		$cname = trim($_POST['cname']);
		$phone = is_numeric($_POST['phone']);
		$captcha = trim($_SESSION["code"]==$_POST["captcha"]);
	    $pcode =  is_numeric($_POST['pcode']);
	    $state = trim($_POST['state']);
	    $suburb = trim($_POST['subrub']);
if(empty($cname) && !preg_match("/^[\w\ \+\-\'\"]+$/", $cname)){$errors[] = '* Company name must contain only alphanumeric characters, spaces &amp; + or - signs';}
		if(empty($phone)){$errors[] = '* Phone must be numeric';}
		if(empty($captcha)){$errors[] = '* Captcha empty or invalid';}
		if(empty($pcode)){$errors[] = '* Post code must numeric';}
		if(empty($state)){$errors[] = '* State cannot be empty';}
		if(empty($suburb)){$errors[] = '* Suburb cannot be empty';}		
# Return the (possibly empty) array of error messages
	return $errors;   
}
# Display the form
function form($errors = array()) {
    // If some errors were passed in, print them out
	if($errors == true){echo('<p class="false">'.implode("<br>\r\n",$errors).'</p>');}
    echo('
	<form name="contact" action="'.htmlspecialchars(htmlentities($_SERVER['PHP_SELF'])).'" method="post">
	<table id="contact" border="0" cellpadding="4" cellspacing="0" border-collapse="collapse">
	<tr>
	        <td colspan="2" class="ins"><input type="text" name="cname" value="Company Name" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
	        <td colspan="2" class="ins"><input type="email" name="cemail" value="Contact Email" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
	        <td colspan="2" class="ins"><input type="tel" name="phone" value="Phone" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
	        <td class="ins"><input type="text" name="subrub" value="Suburb" onfocus="clearText(this)" onblur="clearText(this)"></td>
	        <td class="ins"><input type="text" name="pcode" value="Postcode" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
	        <td colspan="2" class="ins">
	        	<select name="state">
	        		<option value="">State</option>
	        		<option value="western australia">Western Australia</option>
	        		<option value="south australia">South Australia </option>
	        		<option value="victoria">Victoria</option>
	        		<option value="new south wales">New South Wales </option>
	        		<option value="queensland">Queensland </option>
	        		<option value="tasmania">Tasmania</option>
	        	</select>
	        </td>
	</tr>
	<tr>
	        <td colspan="2" class="ins"><textarea name="message"></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><b>CODE</b></td>
	</tr>
	<tr>
	        <td class="ins"><input type="text" name="captcha" value="" onfocus="clearText(this)" onblur="clearText(this)"></td>
	        <td class="ins"><p class="captcha tac fbold"><img src="captcha.php"></p></td>	        
	</tr>
	<tr>
		<td colspan="2"><br>Please enter code below for verification:</td>
	</tr>				
	<tr>
	        <td class="ins"><input class="radius tac fbold colorw" type="reset" name="clear" value="Clear"></td>
	        <td class="ins"><input class="radius tac fbold colorw" type="submit" name="send" value="Send"></td>
	</tr>                                                                                                                                                                                                                                                                                                                              
	</table>
	</form>');
}
?>
		</div>
<!--# #-->
		</div>
	</article>
</section>
<?php require(dirname(__FILE__) . '/footer.php'); ?>				