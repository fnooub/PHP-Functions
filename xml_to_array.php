<?php

$xmlstring = <<<XML
<nam>
	<phan>
		<tieude>Phan 1</tieude>
		<danhsach>Lorem ipsum dolor sit amet.</danhsach>
		<danhsach>Aut quas aspernatur necessitatibus assumenda!</danhsach>
		<danhsach>Porro fugiat veritatis molestiae fugit?</danhsach>
		<danhsach>Harum consequuntur totam, nostrum reiciendis!</danhsach>
		<danhsach>Minima tempora qui fuga est!</danhsach>
		<danhsach>Omnis provident iste pariatur mollitia.</danhsach>
		<danhsach>Cumque, quidem quasi soluta voluptates.</danhsach>
		<danhsach>Dolores ex recusandae explicabo expedita.</danhsach>
		<danhsach>Natus impedit dicta, similique ipsum.</danhsach>
		<danhsach>Aut maiores assumenda sint ab.</danhsach>
	</phan>
	<phan>
		<tieude>Phan 2</tieude>
		<danhsach>Lorem ipsum dolor.</danhsach>
		<danhsach>Praesentium, numquam eligendi.</danhsach>
		<danhsach>Non, voluptates, enim.</danhsach>
		<danhsach>Modi, ipsum, voluptatibus.</danhsach>
		<danhsach>Esse, earum, blanditiis.</danhsach>
		<danhsach>Qui molestias, excepturi.</danhsach>
		<danhsach>Ea, vel, velit!</danhsach>
		<danhsach>Pariatur, magnam consectetur.</danhsach>
		<danhsach>Omnis, repellat, atque!</danhsach>
		<danhsach>Sapiente, modi, vel.</danhsach>
		<danhsach>Molestias doloribus, iste.</danhsach>
		<danhsach>Beatae, non, accusantium!</danhsach>
		<danhsach>Exercitationem, accusamus, assumenda!</danhsach>
		<danhsach>Voluptatibus, repellendus, maiores?</danhsach>
		<danhsach>Provident, laboriosam ipsum.</danhsach>
	</phan>
</nam>
XML;

print_r(xml_to_array($xmlstring));

function xml_to_array($xmlstring)
{
	$xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json, TRUE);
	return $array;
}