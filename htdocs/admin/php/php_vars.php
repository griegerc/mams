<?php

	require('../config.php');

	$vars = array(
		'$_SERVER'  => $_SERVER,
		'$_SESSION' => $_SESSION,
		'$_REQUEST' => $_REQUEST
	);

?>
<html>
	<?php print Admin::getHead(); ?>
	<body>
		<a name="top"></a>
		<h1>PHP-Variables</h1>
		<?php
			foreach ($vars as $varKey => $var) {
				?>
				<h2><?php print $varKey; ?></h2>
				<table class="table1">
				<?php
					if (isset($var)) {
						foreach ($var as $key=>$value) {
							?>
							<tr>
								<th style="width: 200px;"><?php print $key; ?></th>
								<td style="width: 50px;"><i><?php print gettype($value); ?></i></td>
								<td style="width: 700px;">
									<?php
										if (!is_scalar($value)) {
											?>
											<pre style="overflow:auto;"><?php print_r($value); ?></pre>
											<?php
										} else {
											print $value;
										}
									?>
								</td>
							</tr>
							<?php
						}
					}
				?>
				</table>
				<?php
			}
		?>
	</body>
</html>