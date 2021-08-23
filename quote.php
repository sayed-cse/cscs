<?php require(dirname(__FILE__) . '/header.php'); ?>
<section class="row">
	<article class="rc12">
		<div class="pad"><h1 class="head2 tal">REQUEST A QUOTE</h1></div>
	</article>
	<article class="rc12">
		<div class="rc8 pad">
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
		$mobile = stripslashes($_POST['mobile']);
		$suburb = stripslashes($_POST['subrub']);
		$postcode = stripslashes($_POST['pcode']);
		$services = implode("\r\n", $_POST['service']);
		$message = stripslashes($_POST['message']);;
		$subject = stripslashes($_POST['subrub']);
		$date = trim(stripslashes($_POST['date']));
		$time = trim(stripslashes($_POST['time']));
#
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=utf-8";
		$headers[] = "Content-Transfer-Encoding:7bit";
		$headers[] = "From: ".$from;
		$headers[] = "Cc: ".$cc;
		$headers[] = "Bcc: ".$bcc;
		$headers[] = "Reply-To: ".$from;
		$headers[] = "Return-Path: ".$from;
		$headers[] = "X-Originating-IP: ".$_SERVER['SERVER_ADDR'];
		$headers[] = "Senders IP: ".$_SERVER['REMOTE_ADDR'];
		$headers[] = "Subject: ".$suburb;
		$headers[] = "X-Mailer: PHP/".phpversion();
		$post_email = mail($to, $subject,
		'<html><body><h1 style="margin:1px;padding:2px 4px 2px 4px;background-color:#00AEEF;color:#fff">'.$subject.'</h1>
		<p>
			<b>Company Name :</b> '.$company_name.'<br>
			<b>Message :</b> '.$message.'<br><br>
			<b>From :</b> '.$from.'<br>
			<b>Phone :</b> '.$phone.'<br>
			<b>Mobile :</b> '.$mobile.'<br>
			<b>Postcode :</b> '.$postcode.'<br>
			<b>Service :</b> '.$services.'<br>
			<b>Suburb :</b> '.$suburb.'<br>
			<b>Date :</b> '.$date.'<br>
			<b>Time :</b> '.$time.'<br>
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
		$mobile =  is_numeric($_POST['mobile']);
		$captcha = trim($_SESSION["code"]==$_POST["captcha"]);
	    $pcode =  is_numeric($_POST['pcode']);
	    $suburb = trim($_POST['subrub']);
	    #$services = implode("\r\n", $_POST['service']);
	    $date = trim($_POST['date']);
	    $time = trim($_POST['time']);
		if(empty($cname) && !preg_match("/^[\w\ \+\-\'\"]+$/", $cname)){$errors[] = '* Company name must contain only alphanumeric characters, spaces &amp; + or - signs';}
		if(!isset($_POST['service'])){$errors[] = '* Service Cannot be Unchecked';}		
		if(empty($phone)){$errors[] = '* Phone must be numeric';}
		if(empty($captcha)){$errors[] = '* Captcha empty or invalid';}
		if(empty($pcode)){$errors[] = '* Post code must numeric';}
		if(empty($suburb)){$errors[] = '* Suburb cannot be empty';}	
		if(empty($date)){$errors[] = '* Date cannot be empty or alpha numeric';}
		if(empty($time)){$errors[] = '* Time cannot be empty or alpha numeric';}		
# Return the (possibly empty) array of error messages
	return $errors;	   
}
# Display the form
function form($errors = array()) {
    // If some errors were passed in, print them out
	if($errors == true){echo('<p class="false">'.implode("<br>\r\n",$errors).'</p>');}
    echo('
<form name="contact" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">
	<table id="quote" name="about" border="0" cellpadding="4" cellspacing="0" border-collapse="collapse">
	<tr>
		<td colspan="2" class="ins"><input type="text" name="cname" value="Company Name" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
		<td colspan="2" class="ins"><input type="email" name="cemail" value="Contact Email" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
		<td class="ins"><input type="tel" name="phone" value="Phone" onfocus="clearText(this)" onblur="clearText(this)"></td>
		<td class="ins"><input type="tel" name="mobile" value="Mobile" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
		<td class="ins"><input type="text" name="subrub" value="Suburb:" onfocus="clearText(this)" onblur="clearText(this)"></td>
		<td class="ins"><input type="text" name="pcode" value="Postcode" onfocus="clearText(this)" onblur="clearText(this)"></td>
	</tr>
	<tr>
		<td class="ins"><input name="date" type="text" id="datetimepicker1"/></td>
		<td class="ins"><input name="time" type="text" id="datetimepicker2"/></td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="rc6">
				<ul>
					<li><input id="check1" type="checkbox" name="service[]" value="Window Clearing"><label for="check1"> Window Clearing</label></li>
					<li><input id="check2" type="checkbox" name="service[]" value="Carpet Clearing"><label for="check2"> Carpet Clearing</label></li>
					<li><input id="check3" type="checkbox" name="service[]" value="Graffiti Removal"><label for="check3"> Graffiti Removal</label></li>
					<li><input id="check4" type="checkbox" name="service[]" value="Gutters &amp; Drains"><label for="check4"> Gutters &amp; Drains</label></li>
					<li><input id="check5" type="checkbox" name="service[]" value="Car Park Maintenance &amp; Sweping"><label for="check5"> Car Park Maintenance &amp; Sweping</label></li>
				</ul>			
			</div>
			<div class="rc6">
				<ul>
					<li><input id="check6" type="checkbox" name="service[]" value="Tile/Grout &amp; Toilet Cleaning"><label for="check6"> Tile/Grout &amp; Toilet Cleaning</label></li>
					<li><input id="check7" type="checkbox" name="service[]" value="High Pressure Steem Cleaning"><label for="check7"> High Pressure Steam Cleaning</label></li>
					<li><input id="check8" type="checkbox" name="service[]" value="Concrete Sealing &amp; Retroplating"><label for="check8"> Concrete Sealing &amp; Retroplating</label></li>
					<li><input id="check9" type="checkbox" name="service[]" value="Floor Striping &amp; Sealing"><label for="check9"> Floor Striping &amp; Sealing</label></li>
					<li>&nbsp;</li>
				</ul>			
			</div>
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
		<td class="ins"><input class="radius fbold colorw tac" type="reset" name="clear" value="Clear"></td>
		<td class="ins"><input class="radius fbold colorw tac" type="submit" name="send" value="Send"></td>
	</tr>
	</table>				
</form>');
}
?>
<script async="async" type="text/javascript" src="jquery.datetimepicker.js"></script><script async="async" type="text/javascript">$(document).ready(function(){/* Dater */$('#datetimepicker1').datetimepicker({lang:'en', i18n:{en:{months:['January','February','March','April', 'May','June','July','August', 'September','October','November','December'], dayOfWeek:["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"] } }, timepicker:false, mask:false, inline:false, format:'d/m/Y', minDate:0, todayButton:true, defaultSelect:true, closeOnDateSelect:true, weeks:true, defaultDate:new Date(), value:'Date Required'}); /* Timer */ $('#datetimepicker2').datetimepicker({datepicker:false, mask:false, format:'H:i', step:5, defaultTime:'00:00', value:'Time Required'}); /*End*/}); </script>
		</div>
		<div class="rc4">&nbsp;</div>
	</article>
</section>
<?php require(dirname(__FILE__) . '/footer.php'); ?>
