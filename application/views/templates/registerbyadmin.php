<?php
$path = base_url();
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Register Successfully</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//fonts.googleapis.com/css?family=Heebo:300,400,700" rel="stylesheet">
</head>

<body style="max-width:600px; width:100%; margin:0 auto; font-family: 'Heebo', sans-serif; font-size:18px;">
	<table style="width:100%; background:#0f0513;">
		<tbody>
			<tr>
				<td>
					<table style="width:100%;padding:38px 0 20px 0;">
						<tbody>
							<tr>
								<td style="text-align:center;"><img src="<?php echo base_url(); ?>assets_diesel/dist/img/logo.png" alt="logo" /></td>
							</tr>
						</tbody>
					</table>

					<table style="width:85%; margin:0 auto;  border-radius:20px 20px 0 0; color:#ffffff; margin-bottom:-3px; background-color:#790000;">
						<thead>
							<tr>
								<th colspan="2" style="padding:30px 24px 0 24px;">
									<h1 style="font-size:27.5px; color:#ffffff; margin-top:0;">Welcome to Diesel Fuel Stop,</h1>
								</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td colspan="2" style="padding:0 24px;">
									<p style="margin-bottom:0; color:#fff;">Hello</p>
									<?php if (isset($name)) : ?>
									<p style="margin-top:5px; color:#fff;">Mr <?php echo $name; ?>,</p>
									<?php endif; ?>

									<p style="margin:0; padding:20px 0; text-align:justify; color:#fff;">Firstly, we would like to say that we are really glad to have you here with Diesel Fuel Stop. Secondly, we are sure that your journey with us is going to be profitable.</p>
									<p style="margin:0; padding:20px 0; text-align:justify; color:#fff;">We are sure your all the services are going to be beneficial and brings the most out of it for you.</p>
									<p style="color:#fff;">Your User Mail ID : <?php echo $email; ?></p>
									<p style="color:#fff;">Your Password : <?php echo $password; ?></p>

									<!--<p style="margin-bottom:0;padding-top:20px; color:#fff;">Technical Team</p>-->
									<p style="margin-top:5px;padding-bottom:30px; color:#fff;">Diesel Fuel Stop</p>
								</td>
							</tr>
						</tbody>

						<tfoot>

							<tr>
								<td style="padding:10px 24px; text-align:center; padding-bottom:10px; border-top:1px solid #fff; background-color:#fff;">Info@dieselfuelstop.com/</a></td>
								<td style="padding:10px 24px; text-align:center; padding-bottom:10px; border-top:1px solid #fff; background-color:#fff;">www.dieselfuelstop.com/</td>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>