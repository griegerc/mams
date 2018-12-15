<?php

	require('../config.php');

?>
<html>
	<?php print Admin::getHead(); ?>
	<body>
		<a name="top"></a>
		<h1>PHP-Constants</h1>
		<?php

			$allConstants = get_defined_constants(true);

			$categories = array_keys($allConstants);
			$boxCategories = '';
			foreach ($categories as $category) {
				$boxCategories .= '<a href="#'.$category.'">'.$category.'</a>&#160;&#160; ';
			}
			print '<p>'.$boxCategories.'</p>';

			foreach ($allConstants as $category => $constants) {
				?>
					<a name="<?php print $category; ?>"></a>
					<h2><?php print $category; ?></h2>
					<p><a href="#top">top</a></p>
					<table class="table1">
					<?php
					foreach ($constants as $key => $value) {
						?>
							<tr>
								<th><?php print $key; ?></th>
								<td><em><?php print gettype($value); ?></em></td>
								<td><?php print $value; ?></td>
							</tr>
						<?php
					}
					?>
					</table>
				<?php
			}
		?>
	</body>
</html>