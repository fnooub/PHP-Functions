<?php

function nl2p($string, $nl2br = true)
{
	// Normalise new lines
	$string = str_replace(array("\r\n", "\r"), "\n", $string);

	// Extract paragraphs
	$parts = explode("\n", $string);

	// Put them back together again
	$string = '';

	foreach ($parts as $part) {
		$part = trim($part);
		if ($part) {
			if ($nl2br) {
				// Convert single new lines to <br />
				$part = nl2br($part);
			}
			$string .= "<p>$part</p>\n";
		}
	}

	return $string;
}

/*ví dụ*/
$text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend, purus id tincidunt dignissim, nisl mauris tempus diam, ac gravida orci ipsum ut velit. Donec mattis, sem id gravida convallis, purus nunc viverra dui, sit amet pretium ipsum orci vel eros. Morbi fermentum mauris tincidunt, tincidunt tortor a, congue quam. Nullam tempor mauris vel euismod maximus. Proin et suscipit massa. Nam tincidunt congue tellus, sed ultricies metus tempor et. Donec vestibulum mollis ipsum. Phasellus viverra tellus massa, vel cursus nulla dapibus a. Donec neque nulla, suscipit a sodales ac, egestas et nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.

Donec consequat ex ut nisl malesuada mattis. Aenean libero neque, fringilla at hendrerit quis, aliquet ac sem. Curabitur id egestas magna. In hac habitasse platea dictumst. Aliquam vel enim at lacus lacinia porttitor id vitae diam. Maecenas arcu lectus, commodo et porttitor a, egestas non lorem. Nulla augue enim, viverra sed elementum eu, vulputate at nunc. Nulla eget felis ut ipsum lobortis pulvinar vitae eu tellus. Ut posuere auctor iaculis.

Vestibulum viverra iaculis enim in ornare. Praesent ultrices lectus sit amet ipsum vestibulum, non tristique turpis dictum. Etiam vulputate luctus libero, rutrum feugiat nibh aliquam et. Cras malesuada elit nunc. Suspendisse quis diam ultricies, congue felis eu, vehicula ligula. Praesent ac nulla nisl. Nam metus erat, rutrum id egestas sed, luctus sed lectus. Maecenas venenatis porta luctus. Suspendisse potenti. Proin nec tincidunt sem.

Ut condimentum, mi quis fermentum venenatis, quam libero rutrum dui, a efficitur diam mi nec ipsum. Nullam iaculis sapien libero. Duis feugiat nibh erat, nec viverra ligula interdum eget. Cras mauris justo, aliquet ac consequat id, aliquet eget nunc. Duis tristique mi eu facilisis convallis. Sed non ornare purus, vel vulputate mauris. Nullam massa erat, venenatis facilisis ex ut, consectetur sollicitudin lorem. Pellentesque pellentesque magna odio, vel vehicula diam posuere quis. Nunc non neque elit. Sed nec tempus ante, non egestas massa. Sed at ante auctor, tempor lacus vel, semper ante. Donec non arcu nisi. Phasellus lacinia et elit vitae posuere. Quisque ac vehicula massa. Nullam commodo, metus nec pharetra scelerisque, ante metus dictum neque, non vulputate est nibh nec elit. Nullam sodales sit amet neque eget vestibulum.

Mauris pretium pretium faucibus. Phasellus quis posuere nisl, vitae consectetur tellus. In vitae eros nisi. Ut eget sapien quis lorem placerat porta. Etiam mollis magna turpis, vitae faucibus justo mattis vitae. Nam luctus ligula ut lacus tempor, sed laoreet dui laoreet. Mauris elementum ex at arcu consectetur, vitae faucibus massa auctor. Nulla sed enim nec mi mattis suscipit congue at ligula. Nunc a erat sem. Proin non euismod nisi. Phasellus convallis odio erat, sed facilisis nisi consequat sed. Proin tempus, ex non viverra lobortis, dolor sem blandit leo, non tempor sem massa quis arcu. Curabitur imperdiet ante vitae accumsan sodales. Nam tempor mi at ex dapibus scelerisque. Donec lacinia vestibulum velit sit amet elementum.';

echo nl2p($text);