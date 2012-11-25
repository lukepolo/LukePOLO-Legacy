<!-- Start of blog header -->
<div id="project_brain" class="page-header">
	<h1>Woah waaa wee waaa <small><h2 style="color:#336699;display:inline-block">crazy semester!</h2></small></h1>
</div>
<!-- Start of blog -->
<div style="padding-bottom:30px;" class="row">
    <div class="span1">
        <div class="pull-left date">
            <span class="day">20</span>
            <span class="month">September</span>
            <span class="year">2012</span>
        </div>
    </div>
    <div class="span9 offset1">
        <p>
		So its been awhile, a long while! But it's almost Thanksgiving break!
		<p>
			I'm hoping this will give me an oppertunity to do some
			more work on <a href="BoilerProjects.com">BoilerProjects.com</a> (formally known as Project Brain). Yes thats right the infamous (and yes I do really mean infamous)
			Project Brain has its final name ,for now :-).
		</p>
		<p>
			While this project is no where near being done, I believe this will be mostly completed and ready for testing at the END of December. But let me just give you a basis of this idea.
			<p style="display: inline;">
				I was looking for a project managment website that would be able to suit all of my needs, with a relative low learning curve. And of course free.
				<h4 style="display: inline;">Guess what?!</h4>
				I coulnd't find one that was easy to use. I spent over 1 hour trying to figur eout how to setup a project and to add members ect.
				I thought to myself
				<br>
				<br>
				<blockquote>"This is taking way to damn long.."</blockquote>
				Well I hope this project turns into a success!
				
			</p>
			<p>
				Time will only tell! Till then dont get bitten by those Turkeys!
				<br>
				<small>P.S : I plan on updating LukePOLO.com over winter break!</small>
			</p>
		</p>
        </p>
	<br>
        <blockquote>
		Happy Thanksgiving!
            <small>Luke</small>
        </blockquote>
    </div>
</div>
<!-- End of Blog -->
</div>
<div id="busy_busy" style="background-color:white" class="hero-unit">
<!-- SO WE CAN CREATE A SEPERATE BLOCK -->
<!-- Start of blog header -->
<div class="page-header">
	<h1>Busy Busy Busy! <small><h2 style="color:#336699;display:inline-block">but aren't we all?!</h2></small></h1>
</div>
<!-- Start of blog -->
<div style="padding-bottom:30px;" class="row">
    <div class="span1">
        <div class="pull-left date">
            <span class="day">9</span>
            <span class="month">August</span>
            <span class="year">2012</span>
        </div>
    </div>
    <div class="span9 offset1">
        <p>
		
		Just thought I'd give an update on what has been going on for the past MONTH! It has a been a crazy couple of weeks, school started and just transferred into Industrial Engineering!
		You may think I'm pretty crazy for switch but there's good reason
		
		<p style="padding:20px;" class="offset1">
			1. I can get more involved with programing<br>
			2. A thing called "Interdisciplinary Undergraduate Concentration in Software Engineering"<br>
			3. Ill graduate faster!<br>
		</p>
		
		So let's talk more about this concentration. Courses I will be taking before I graduate in Dec 2013:
		<p style="padding:20px;" class="offset1">
			1. CS 30700 - Software Engineering<br>
			2. CS 35200 - Compilers: Principles and Practice<br>
			3. CS 49000 - Topics in Computer Sciences for Undergraduates<br>
			4. CS 42600 - Computer Security<br>
		</p>
		<p>
		And I plan on taking more courses throughout the year <a href="http://www.udacity.com/">with http://www.udacity.com/</a> and some courses with Purdue online.
		</p>
		<p>
			<strong>PS:</strong> I have an interview today! I am super excited, because I actually like to interview!
		</p>
        </p>
	<br>
        <blockquote>
		Hope everyone is having a great week!
            <small>Luke</small>
        </blockquote>
    </div>
</div>
<!-- End of Blog -->
</div>
<div id="google_voice" style="background-color:white" class="hero-unit">
<!-- SO WE CAN CREATE A SEPERATE BLOCK -->
<!-- Start of blog header -->
<div class="page-header">
	<h1>Google Voice Integration <small><h2 style="color:#336699;display:inline-block">lets chat!</h2></small></h1>
</div>
<!-- Start of blog -->
<div style="padding-bottom:30px;" class="row">
    <div class="span1">
        <div class="pull-left date">
            <span class="day">9</span>
            <span class="month">August</span>
            <span class="year">2012</span>
        </div>
    </div>
    <div class="span9 offset1">
        <p>
So I've been working with Google voice, and it's very very cool. At work we don't have a "long distance" plan so we use Google voice if they give us a non-local number.
So I started to look for an API, and what I found is <strong>THEY DONT HAVE ONE!</strong>
So I found a really good already built authenticate procedure:
		<pre class="prettyprint">
namespace Gvoice;

class Gvoice
{
	/**
	  * Modify this
	**/
	// The Google account type
	var $account_type = 'GOOGLE';
	// Service for Google Voice is grandcentral (it may change)
	var $service = 'grandcentral';
	// The host of your site (for logging purposes) 
	var $source = '';				
	// _rnr_se - This can be found in the source code of the inbox page of your Google Voice
	// Simply view the source and search for '_rnr_se'. Should be a string of about 30
	// characters (numbers, letters, and symbols)
	var $_rnr_se = ''; 
 
	/**
	  * Do not modify
	**/
	var $url = 'https://www.google.com/';	// Google HTTPS URL
	var $auth; 	// The AUTH key
	var $email = '';	// Users email address
	var $password = '';	// Users password
 
	function __construct () {
		// Authenticate if the Auth key is empty
		if ($this->auth == '') {
			$this->authenticate();
		}
	}
 
	/**
	  * authenticate
	  * Authenticates using the email and password.
	  * @return Auth Session Key
	**/
 
	function authenticate () {
		$form_data = array();
		$form_data['accountType'] = $this->account_type;
		$form_data['Email'] = $this->email;
		$form_data['Passwd'] = $this->password;
		$form_data['service'] = $this->service;
		$form_data['source'] = $this->source;
 
		$response = $this->transmit($form_data, 'accounts/ClientLogin');
		preg_match("/Auth\=(.*)/", $response, $matches);
 
		if (count($matches) == 0) {
			return $response;
		} else {
			$this->auth = str_replace("Auth=", "", $matches[0]);
			return $this->auth;
		}
	}
 
	/**
	  * transmit
	  * Transmits the passed in POST data
	  * @param $form_data An array of POST fields and values
	  * @param $path The path to call
	  * @return Response from the server
	**/
 
	function transmit ($form_data, $path, $USE_POST=true) {
		$url = $this->url.$path;
		$fields = array();
 
		foreach ($form_data as $field => $value)
			$fields[] = $field.'='.urlencode($value);
 
		// POST or GET?
		if ($USE_POST) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, count($form_data));
			curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $fields));
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Authorization: GoogleLogin auth=".$this->auth));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		} else {
			$ch = curl_init($url.'?'.implode('&', $fields));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		}
 
		$response = curl_exec($ch);
 
		return $response;
	}
 
	/**
	  * send_sms
	  * Sends an SMS message
	  * @param $phone_number The number to send the SMS message to
	  * @param $text The message
	  * @return Response from the server (success or fail)
	**/
 
	function send_sms ($phone_number, $text) {
		$form_data = array();
		$form_data['phoneNumber'] = $phone_number;
		$form_data['text'] = $text;
		$form_data['id'] = '';
		$form_data['_rnr_se'] = $this->_rnr_se;
 
		$response = $this->transmit($form_data, 'voice/sms/send/');
 
		return $response;
	}
 
	/**
	  * get_sms
	  * Gets the HTML of the SMS inbox
	  * @param $UNREAD boolean - Show unread or not
	  * @return The HTML from the SMS inbox page
	**/
 
	function get_sms($UNREAD=false) {
		$form_data = array();
		$form_data['auth'] = $this->auth;
 
		if ($UNREAD)
			$path = 'voice/inbox/recent/unread/';
		else
			$path = 'voice/inbox/recent/';
 
		$response = $this->transmit($form_data, $path, false);
 
		return $response;
	}
	
	// this is the only part I did! thanks Kalinchuk
	/**
	 * calls a phone number fro your google voice account
	 * @param forwarding_number is the number in your google account that you want to call from
	 * @param calling_number is the number you wish to call
	 * @param phone type that is label within your google voice account
	 */
	function callNumber($forwarding_number,$calling_number,$phone_type)
	{
		switch ($phone_type)
		{
			case 'mobile':
				$phone_type = 2;
				break;
			case 'work' :
				$phone_type = 3;
				break;
			case 'home':
				$phone_type = 1;
				break;
			case 'gizmo':
				$phone_type = 7;
				break;
		}
		
		$form_data = array();
		$form_data['forwardingNumber'] = '+1'.$forwarding_number;
		$form_data['outgoingNumber'] = '+1'.$calling_number;
		$form_data['subscriberNumber'] = 'undefined';
		$form_data['phoneType'] = $phone_type;
		$form_data['remember'] = '1';
		$form_data['_rnr_se'] = $this->_rnr_se;
		
		$response = $this->transmit($form_data, 'voice/call/connect/');
		
		return $response;
	}
}
		</pre>
		
		To make a phone call you can use it like this :
<pre class="prettyprint">
public function call_number($forwarding_number,$number)
{
	// or you can always make it global
	$gv = new Gvoice\Gvoice();

	echo $gv->callNumber(preg_replace('/[^0-9]/','',$forwarding_number),preg_replace('/[^0-9]/','',$number));
}
</pre>
		To text message you can use it like this :
<pre class="prettyprint">
public function send_text($number,$text_message)
{
	$gv = new Gvoice\Gvoice();
	
	echo $gv->send_sms(preg_replace('/[^0-9]/','',$number), $text_message);
}
</pre>
		I would really like to thank Kalinchuk , here is the link to his orginal file : <a href="http://kalinchuk.com/?p=44">http://kalinchuk.com/?p=44</a>
        </p>
	<br>
        <blockquote>
		Let me know how you like it!
		
            <small>Luke</small>
        </blockquote>
    </div>
</div>
<!-- End of Blog -->
</div> <!-- SO WE CAN CREATE A SEPERATE BLOCK -->
<div id="#snmp" style="background-color:white" class="hero-unit">
<div class="page-header">
	<h1>Getting Switch Information With SNMP <small><h2 style="color:#336699;display:inline-block">gives me headaches</h2></small></h1>
</div>
<!-- Start of blog -->
<div style="padding-bottom:30px;" class="row">
    <div class="span1">
        <div class="pull-left date">
            <span class="day">18</span>
            <span class="month">July</span>
            <span class="year">2012</span>
        </div>
    </div>
    <div class="span9 offset1">
        <p>
		<p>
			<strong>UPDATED : August 8th , 2012</strong>
<pre class="prettyprint">
exec("snmpwalk -v 2c -Ox -c public".$vlan." ".$switch_ip." ".$list_macs->oid,$mac_list);
</pre>
			SNMP can wear you out, I spent a good amount of time trying to figure out the best way for us to get port information for stacked switches.
		</p>
		Previously we were using 2 SNMP commands, this was great because it was very fast to compute each switch. But we started having "hacks" which changed
		for each switch. This didn't feel right so I decided to re-write it.
		<br><br>
		<pre class="prettyprint">
/**
* This function allows you to find out switch information on what
* is plugged in giving back mac addresses, ip addresses and which port they 
* are plugged into.
*
* This currently is working for the following switches (probably more but cannot test)
* - Cisco 2950
* - Cisco 2960
* - Cisco 2960s
* - Cisco 3750
* - Cisco 3750s
* - Extreme switches
*
* @switch_ip	The switch ip to search on , format : *.*.*.*
* @subnets	(array)		Configured Ports subnets ,   format : *.*.*.*
* @vlans	(array)		Configured Ports vlans, ex. 260
* @start_ports  (array)		Starting ports for each switch ex. Cisco 2960 start with 10001
* @end_ports 	(array)		Ending ports for each switch ex. Cisco 2960 end with 10049
**/
public static function get_switch_info($switch_ip,$subnets,$vlans,$start_ports,$end_ports)
{
	// List of all OID's that we will be using
	$list_macs = '.1.3.6.1.2.1.17.4.3.1.1';
	$get_index_oid = 'ipAdEntIfIndex';
	$ip_to_mac_oid = 'ipNetToMediaPhysAddress';
	$port_index_oid = '.1.3.6.1.2.1.17.4.3.1.2';
	$port_map_oid = '.1.3.6.1.2.1.17.1.4.1.2';
	
	// If the vlan is zero , it doesn't need a vlan!
	if($vlan != 0)
	{
		$vlan = '@'.$vlan;
	}
	else
	{
		$vlan = '';
	}
	
	// Only need todo these commands once every vlan
	if(isset(static::$ips_to_macs[$vlan]) !== true)
	{
		// Need to get the index of the VLAN to grab all the IPs connected to the switch
		$index = str_replace("INTEGER: ","",@snmp2_walk($subnet,"public",$get_index_oid.$subnet));
		static::$ips_to_macs[$vlan]['index'] = $index[0];
		
		// Gets the IP to MAC mapping
		exec("snmpwalk -v 1 -c public -O sq $subnet.$ip_to_mac_oid.static::$ips_to_macs[$vlan]['index'],static::$ips_to_macs[$vlan]['info']");
	}
	
	// SNMP calls
	exec("snmpwalk -v 2c -Ox -c public".$vlan." ".$switch_ip." ".$list_macs->oid,$mac_list);
	$port_index = @snmp2_real_walk($switch_ip,'public'.$vlan,$port_index_oid);
	$port_mapping = @snmp2_real_walk($switch_ip,'public'.$vlan,$port_map_oid);
	
	// Makes sure the mac list isn't empty otherwise no point going throuhg it
	if(empty($mac_list) === true)
	{
		return;
	}
	
	// Combine the arrays to make it easy to find
	$mac_index = array_combine($mac_list, $port_index);
	
	$ip_mac_array = array();
	
	// Lets match the IP's and Mac Addresses
	foreach (static::$ips_to_macs[$vlan]['info'] as $ip_to_mac)
	{
		$ip_mac_address = null;
		
		// We just want the IP and MAC
		$ip_to_mac = preg_split('/\s/',str_replace('ipNetToMediaPhysAddress.'.static::$ips_to_macs[$vlan]['index'].'.','',$ip_to_mac));
		$ip_mac = preg_split('/:/',$ip_to_mac[1]);
		
		// Leading zeros are missing so lets make sure they get added
		foreach($ip_mac as $mac_part)
		{
			$ip_mac_address .= str_pad($mac_part,2,'0',STR_PAD_RIGHT ); 
		}
		$ip_mac_array[strtoupper($ip_mac_address)] = $ip_to_mac[0];
	}
	
	// Find the port that the mac is in then match it to the IP address
	foreach($mac_index as $mac => $port_index)
	{
		// Getting the mac address and port index (which is the index of where the port number will be at)
		$mac_address = preg_replace('/(^Hex-STRING\:)|(\s)/','',$mac);
		$port_index = 'SNMPv2-SMI::mib-2.17.1.4.1.2.'.preg_replace('/(^INTEGER\:)|(\s)/','',$port_index);
		
		// Lets make sure our snmp call has that port index
		if(array_key_exists($port_index,$port_mapping) === true)
		{
			// We can find the port number by the index now
			$port_number = str_replace('INTEGER: ','',$port_mapping[$port_index]);
			
			// If its a stacked switch we have an array so find out how many times we need to loop
			$count = count($start_port) - 1;
			
			// This flag is set so we can know when we find the port within the range of our switches
			$flag = false;
		     
			// Makes sure that the ports are in a valid range for the switch 
			while($count >= 0 && $flag == false)
			{
				// This is to make sure our port # is in our valid range
				if($port_number >= $start_port[$count] && $port_number < $end_port[$count])
				{
				   $flag = true;
				}
				$count--;
			}
			
			// This is to check to see if didn't have a valid range 
			if($flag == false)
			{
			   continue;
			}
			
			// Lets see if we could match the mac and ip together
			if(isset($ip_mac_array[$mac_address]) === true)
			{
			   $user_ip = $ip_mac_array[$mac_address];
			}
			else
			{
			   $user_ip = 'UNKNOWN';
			}
			
			// Add ':' to the mac address
			$mac_address = preg_replace('/(.{2})(?!$)/','$1:',$mac_address);
			
			// Put into data array so we can use it
			$data->ports_information[] = $port_number."__".$user_ip."__".$mac_address;
			$data->vlan =  $vlan;
		}
	}
	if(isset($data) === true)
	{
		return $data;
	}
}
		</pre>
		
		
        </p>
	<br>
        <blockquote>
		I am sure this is not the best way , so if you can tell me of any improvments let me know!
            <small>Luke</small>
        </blockquote>
    </div>
</div>
<!-- End of Blog -->
</div> <!-- SO WE CAN CREATE A SEPERATE BLOCK -->
<!-- Start of blog -->
<div id="my_new_site" style="background-color:white" class="hero-unit">
<div class="page-header">
	<h1>My New Site <small><h2 style="color:#336699;display:inline-block">nothing ever goes as planned</h2></small></h1>
</div>
<div class="row">
    <div class="span1">
        <div class="pull-left date">
            <span class="day">08</span>
            <span class="month">July</span>
            <span class="year">2012</span>
        </div>
    </div>
    <div class="span6 offset1">
        <p>
            I have been learning a lot since creating my first website. This one is the same, nothing goes as planned. But it has been a fun interesting experience,
            Dealing with godaddy.com's web hosting, SSH access and installing fuelphp was a hassle. I finally got it working 2 hours later with a solid install so everything went pretty smooth after that.
            Now I'm having a weird CSS issue where my footer won't stay at the bottom , which I'm sure I just need to move a div around, bah I'm not sure!
        </p>
        <p>
            Enough of that , I will be adding the ability to post comments and other features for blog page, but I wanted to put something up for now instead of having a blank page saying there was an error!
            I plan on posting something relevant to what I'm doing each week!
        </p>
        <blockquote>
            Enjoy your week!
            <small>Luke</small>
        </blockquote>
    </div>
    <div class="span3">
        <h6>Comments</h6>
                Under Construction
    </div>
</div>
<!-- End of Blog -->
