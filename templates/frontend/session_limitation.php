<?php
/**
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * php version 7.1.0
 *
 * @category  Web-security
 * @package   Shieldon
 * @author    Terry Lin <contact@terryl.in>
 * @copyright 2019 terrylinooo
 * @license   https://github.com/terrylinooo/shieldon/blob/2.x/LICENSE MIT
 * @link      https://github.com/terrylinooo/shieldon
 * @see       https://shieldon.io
 */

declare(strict_types=1);
defined( 'SHIELDON_VIEW' ) || die( 'Illegal access' );
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
	<?php
		_e( 'Please line up', 'wp-shieldon' );
	?>
		</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">

<div class="modal modal-sheet d-block bg-body-secondary p-4 py-md-5">
	<div class="modal-dialog">

		<div class="modal-content rounded-4 shadow">

			<div class="modal-header p-5 pb-4 border-bottom-0">
				<h1 class="fw-bold mb-0 fs-2">
				<?php
					_e( 'Please line up', 'wp-shieldon' );
				?>
					</h1>
			</div>

			<div class="modal-body p-4 text-center">
				<p>
					<img src="https://shieldon-io.github.io/static/icons/icon-clock_96x96.png">
				</p>
				<p>
					<?php
					_e( 'This page is limiting the number of people online. Please wait a moment.', 'wp-shieldon' );
					?>
				</p>
				<p>
					Queue: 
					<?php
					echo $onlineinfo['queue'];
					?>
					<br>
					<?php
					//if (!empty($uiInfo['is_display_online_user_amount'])) {
					?>
					Count: 
					<?php
					echo $onlineinfo['count'];
					?>
					<br>
					<?php
					//}
					?>
					Order: 
					<?php
					echo $onlineinfo['order'];
					?>
					<br><br>
					Limit period: 
					<?php
					echo $onlineinfo['limitperiod'];
					?>
					<br>
					Limit count: 
					<?php
					echo $onlineinfo['limitcount'];
					?>
				</p>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
		integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
		crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
		integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
		crossorigin="anonymous"></script>
</body>
</html>
