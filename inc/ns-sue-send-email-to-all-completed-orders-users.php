<?php
function ns_sue_mail_template($ns_titolo, $ns_testo){
	return '
<!DOCTYPE html>
<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>NoStudio</title>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
	<div id="wrapper" dir="ltr" style="background-color: #f5f5f5; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%;">
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
			<tr>
				<td align="center" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #ffffff; border: 1px solid #dcdcdc; border-radius: 3px !important;">
						<tr>
							<td align="center" valign="top">
								<!-- Header -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style=\'background-color: #96588a; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;\'>
									<tr>
										<td id="header_wrapper" style="padding: 36px 48px; display: block;">
											<h1 style=\'color: #ffffff; font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #3da3e5; -webkit-font-smoothing: antialiased;\'>'.$ns_titolo.'</h1>
										</td>
									</tr>
								</table>
								<!-- End Header -->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<!-- Body -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
									<tr>
										<td valign="top" id="body_content" style="background-color: #ffffff;">
											<!-- Content -->
											<table border="0" cellpadding="20" cellspacing="0" width="100%">
												<tr>
													<td valign="top" style="padding: 48px;">
														<div id="body_content_inner" style=\'color: #636363; font-family: "Montserrat", sans-serif; font-size: 14px; line-height: 150%; text-align: left;\'>

															<p style="margin: 0 0 16px;">'.$ns_testo.'<br><br><br></p>

															
															<p style="margin: 0 0 16px; text-align: center; color: #c09bb9;">'.get_bloginfo( 'name' ).'</p>

														</div>
													</td>
												</tr>
											</table>
											<!-- End Content -->
										</td>
								</tr>
								</table>
								<!-- End Body -->
							</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
';
}

function ns_sue_send_email_to_array($users_email){
    //Sending an email to all customers that have completed an order including this product.
    foreach($users_email as $email){
    	$sue_user = get_user_by( 'email', $email );
		$ns_sue_user_dear =  $sue_user->first_name . ' ' . $sue_user->last_name;

        $text = ns_sue_mail_template('New update avaiable', 'Howdy '.$ns_sue_user_dear.',<br><br>just wanted to let you know that we have released an update to <b>'.$_POST['post_title'].'</b>.<br>If you have any questions please feel free to contact us any time.<br><br>You receive this mail because you purchased product '.$_POST['post_title'].'.<br><br><br>Thank you!');

        wp_mail( $email, '['.get_bloginfo( 'name' ).'] Product update avaiable', $text);
    }

}
?>