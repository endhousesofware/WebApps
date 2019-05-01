<HTML>
 <HEAD>
 <TITLE>Web Rings</TITLE>
 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/color/jquery.color-2.1.2.min.js" integrity="sha256-H28SdxWrZ387Ldn0qogCzFiUDDxfPiNIyJX7BECQkDE=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="../common/common.js" type="text/javascript"></script>

 <script type="text/javascript">
 $(document).ready(function() {
	$("#larrow").click(function() {
		ringsite = ringsite - 1;
		//alert("Clicked left arrow image:" + ringname + ":" + ringsite);
		displaywebring(ringname,ringsite);
	});
	$("#rarrow").click(function() {
		ringsite = ringsite + 1;
		//alert("Clicked right arrow image:" + ringname + ":" + ringsite);
		displaywebring(ringname,ringsite);
	});

//	$("#faq").find("dd").hide().end().find("dt").click(function() {
//		var answer = $(this).next();
//		if (answer.is(":visible")) {
//			answer.slideUp();
//		} else {
//			answer.slideDown();
//		}
//	});
 });
 </script>

 </HEAD>
 <BODY>

<?
	$cleardb_url = parse_url("mysql://b89a906620fc1a:f6356c21@us-cdbr-iron-east-01.cleardb.net/heroku_0ba2a24595c8c86?reconnect=true");

	$databaseName = substr($cleardb_url["path"],1);
	$username = $cleardb_url["user"];
	$password = $cleardb_url["pass"];
	$hostname = $cleardb_url["host"];
				
	$link = mysqli_connect("$hostname","$username","$password","$databaseName");
	//printf("System status: %s\n", mysqli_stat($link));
	
	if (mysqli_connect_errno())
  	{
  		die("Failed to connect to MySQL: " . mysqli_connect_error());
	}
	  
	mysqli_select_db($link,$databaseName);

	// init constants
	$date = date("Y-m-d");
	$time = date("H:i:s");
	$webringimagewidth = 130;
	$webringimageheight = 50;
	$arrowimagewidth = 50;
	$arrowimageheight = 20;
	$webringname=$_GET["webringname"];		
	$webringindex=$_GET["webringindex"];		
	
	$webringlist = mysqli_query($link,"SELECT ehsWebRingName,ehsWebRingDescription,ehsWebRingImageURL FROM ehswebrings WHERE ehsWebRingName='$webringname'");

	if (mysqli_num_rows($webringlist) == 0) {
		print("No such webring : $webringname");
		exit();
	}

	$webringsitelist = mysqli_query($link,"SELECT ehsWebRingItemID,ehsWebRingItemName,ehsWebRingItemDescription,ehsWebRingItemImageURL,ehsWebRingItemSiteURL FROM ehswebringitem WHERE ehsWebRingItemWebRingName='$webringname'");
	$numwebringsites = mysqli_num_rows($webringsitelist);

	if ($webringindex < 0) {$webringindex = $numwebringsites - 1;} // remember zero basesd
	if ($webringindex > $numwebringsites - 1) {$webringindex = 0;}
	print("<SCRIPT>setringsite($webringindex);</SCRIPT>"); // update js ringsite variable

	$sitecount = 0;
	while ($row = mysqli_fetch_array($webringsitelist, MYSQLI_ASSOC)) {
		if ($sitecount != $webringindex) {$sitecount++;continue;}

		$webringitemname = $row["ehsWebRingItemName"];
		$webringitemdescription = $row["ehsWebRingItemDescription"];
		$webringitemimageurl = $row["ehsWebRingItemImageURL"];
		$webringitemsiteurl = $row["ehsWebRingItemSiteURL"];

		print("<CENTER><TABLE><TR><TD>");
		print("<IMG src='left-arrow.png' id='larrow' width=$arrowimagewidth height=$arrowimageheight>");
		print("</TD><TD><CENTER>");
		print("<B>$webringitemname</B>");
		print("<BR><A href='$webringitemsiteurl'><IMG src='$webringitemimageurl' width=$webringimagewidth height=$webringimageheight></A><BR>");
		print("<B>$webringitemdescription</B>");
		print("</CENTER></TD><TD>");
		print("<IMG src='right-arrow.png' id='rarrow' width=$arrowimagewidth height=$arrowimageheight>");
		print("</TD></TR></TABLE></CENTER>");

		break;
	}
?>

</BODY>
</HTML>
