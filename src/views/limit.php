<?php defined('SHIELDON_VIEW') || exit('Life is short, why are you wasting time?');
/*
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

?>
<!DOCTYPE html>
<html lang="<?php echo $langCode ?>">
<head>
    <meta charset="utf-8">
    <meta name="robots" CONTENT="noindex, nofollow">
    <title><?php echo $lang['limit.title'] ?></title>
    <?php echo '<style>' . $css . '</style>'; ?>
</head>
<body>
	<div class="so-container">
		<h1><?= $lang['limit.heading'] ?></h1>
        <fieldset>
            <legend><?php echo $lang['limit.message'] ?></legend>
            <div class="so-icon">
                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgZGF0YS1uYW1lPSJMYXllciAxIiBpZD0iTGF5ZXJfMSIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiM1MmIxYjE7fS5jbHMtMntmaWxsOiM1MjUzNTQ7fS5jbHMtM3tmaWxsOiNmZmY7fS5jbHMtNHtmaWxsOiNjY2JlYjA7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZS8+PGNpcmNsZSBjbGFzcz0iY2xzLTEiIGN4PSI3MCIgY3k9IjcwIiByPSI2NCIvPjxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTk3LDM2VjI5YTEsMSwwLDAsMC0xLTFINDZhMSwxLDAsMCwwLTEsMXY3YTEsMSwwLDAsMCwxLDFoNWMtMSwzLjEtMSw2Ljg0LTEsMTEsMCw3LjMsOC4zMSwxNi44OSwxNC40OCwyM0M1OC4zMSw3Ny4xMSw1MCw4Ni43LDUwLDk0YzAsNC4xNiwwLDcuOSwxLDExSDQ2YTEsMSwwLDAsMC0xLDF2N2ExLDEsMCwwLDAsMSwxSDk2YTEsMSwwLDAsMCwxLTF2LTdhMSwxLDAsMCwwLTEtMUg5MWMxLTMuMSwxLTYuODQsMS0xMSwwLTcuMy04LjMxLTE2Ljg5LTE0LjQ4LTIzQzgzLjY5LDY0Ljg5LDkyLDU1LjMsOTIsNDhjMC00LjE2LDAtNy45LTEtMTFoNUExLDEsMCwwLDAsOTcsMzZaIi8+PHBhdGggY2xhc3M9ImNscy0zIiBkPSJNOTYsMzVWMjhhMSwxLDAsMCwwLTEtMUg0NWExLDEsMCwwLDAtMSwxdjdhMSwxLDAsMCwwLDEsMWg1Yy0xLDMuMS0xLDYuODQtMSwxMSwwLDcuMyw4LjMxLDE2Ljg5LDE0LjQ4LDIzQzU3LjMxLDc2LjExLDQ5LDg1LjcsNDksOTNjMCw0LjE2LDAsNy45LDEsMTFINDVhMSwxLDAsMCwwLTEsMXY3YTEsMSwwLDAsMCwxLDFIOTVhMSwxLDAsMCwwLDEtMXYtN2ExLDEsMCwwLDAtMS0xSDkwYzEtMy4xLDEtNi44NCwxLTExLDAtNy4zLTguMzEtMTYuODktMTQuNDgtMjNDODIuNjksNjMuODksOTEsNTQuMyw5MSw0N2MwLTQuMTYsMC03LjktMS0xMWg1QTEsMSwwLDAsMCw5NiwzNVoiLz48cGF0aCBjbGFzcz0iY2xzLTEiIGQ9Ik04Ny4zNCw0N0M4Ny4zNCw1Ni41OSw3MCw3MSw3MCw3MVM1Mi42Niw1Ni41OSw1Mi42Niw0Nyw1Mi42NiwzMC41LDcwLDMwLjUsODcuMzQsMzcuNDQsODcuMzQsNDdaIi8+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNODcuMzQsOTNDODcuMzQsODMuNDEsNzAsNjksNzAsNjlTNTIuNjYsODMuNDEsNTIuNjYsOTNzMCwxNi41MSwxNy4zNCwxNi41MVM4Ny4zNCwxMDIuNTYsODcuMzQsOTNaIi8+PHBhdGggY2xhc3M9ImNscy00IiBkPSJNODcuMTMsOTkuMDljMCwuMzEtLjA3LjYxLS4xMi45MS0uOSw1Ljc3LTQuMjksOS41LTE3LDkuNXMtMTYuMTEtMy43My0xNy05LjVjMC0uMy0uMDktLjYtLjEyLS45MSwzLjQ1LTcuNjgsMTMuOS0xNi4yNiwxNi40OC0xOC40OWExLDEsMCwwLDEsMS4zLDBDNzMuMjMsODIuODMsODMuNjgsOTEuNDEsODcuMTMsOTkuMDlaIi8+PHBhdGggY2xhc3M9ImNscy00IiBkPSJNODYuNTEsNTFjLTMsNy45LTEzLjE4LDE3LjA4LTE1Ljg2LDE5LjRhMSwxLDAsMCwxLTEuMywwQzY2LjY3LDY4LjA4LDU2LjQ3LDU4LjksNTMuNDksNTFaIi8+PC9zdmc+">
            </div>
            <?php if ($showLineupInformation || $showOnlineInformation) : ?>
                <div class="so-info">
                    <?php if ($showLineupInformation) : ?>
                        <?php printf($lang['lineup_info'], '<strong>' . $this->currentWaitNumber . '</strong>'); ?>&nbsp;&nbsp;
                    <?php endif; ?>
                    <?php if ($showOnlineInformation) : ?>
                        <?php printf($lang['online_info'], '<strong>' . $this->sessionCount . '</strong>'); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </fieldset>
        <?php if ($showCreditLink) : ?>
            <div class="so-credit" style="display: block !important;"><?php printf($lang['credit'], '<a href="https://github.com/terrylinooo/shieldon" style="display: inline-block !important;" target="_blank">Shieldon</a>'); ?></div>
        <?php endif; ?>
	</div>
</body>
</html>