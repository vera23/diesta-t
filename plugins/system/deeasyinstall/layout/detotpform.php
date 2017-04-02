<html>
<head>
	<title>Authenticator Code Required</title>
	<?php $baseurl = JUri::base(true); ?>
	<link rel="stylesheet" href="<?php echo $baseurl; ?>/plugins/system/deeasyinstall/layout/css/bootstrap.min.css" type="text/css" />
	<style type="text/css"> body{padding:0px 20px 10px;}.error-msg{color:red;min-height:30px;}</style>
	<script>
		function $(id){ return document.getElementById(id); }
		function onAuthCodeChange(){ var authcode = $('authcode'); if(authcode.value.length==6){ $('form').submit(); }}
	</script>
</head>
<body class="detotp">
	<b class="error-msg"><?php echo $displayData['authCodeMsg']; ?></b>
	<form method="POST" id="form">
		<div class="form-group">
			<input name="deauthcode" type="text" onchange="onAuthCodeChange(this)" onkeyup="onAuthCodeChange(this)" class="form-control" id="authcode" placeholder="Auth Code" maxlength="6">
		</div>
		<input type="hidden" name="deeasyinstallver" value="<?php echo $displayData['deeasyinstallver']; ?>">
		<div style="padding:5px 0px 0px;">Download Google Authenticator app for 
			<a class="btn btn-default btn-sm" target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=en">Android</a> or
			<a class="btn btn-default btn-sm" target="_blank" href="https://itunes.apple.com/in/app/google-authenticator/id388497605">iOS</a>
			 <br />Using this app scan <a href="<?php echo $displayData['link']; ?>" target="_blank">QRCode</a> from your site's DeEasyInstall Plugin.
		</div>
	</form>
</body>
</html>