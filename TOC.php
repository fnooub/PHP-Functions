<?php
namespace Lutdev\TOC;

/**
 * Class TableContents for generation table of contents
 *
 * @package Lutdev\TOC
 */
class TableContents
{
    public $symbols = "/\!|\?|:|\.|\,|\;|\\|\/|{|}|\[|\]|\(|\)|\%|\^|\*|_|\=|\+|\@|\#|\~|`|\'|\"|“/";
    public $spaces = "/ |\&nbsp\;|\\r|\\n/";
    public $stripTags = "/<\/?[^>]+>|\&[a-z]+;|\'|\"/";

    /**
     * Add ID attribute to the headers (h1-h10)
     *
     * @param string $description
     *
     * @return string
     */
    public function headerLinks(string $description) : string
    {
        /**
         * Support h1-h10 headers. You can using wysiwyg editor and replace h7-h10 tags.
         * This operation clear p tags around headers
         */
        $description = preg_replace("/<(p|[hH](10|[1-9]))>(<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>)<\/(p|[hH](10|[1-9]))>/", "$3", $description);

        preg_match_all("/<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>/", $description, $items);

        $usedItem = [];

        for ($i = 0; $i < count($items[0]); $i++) {

            $name = preg_replace($this->stripTags, '', trim($this->replaceH1Symbols($items[2][$i])));

            if ($name) {
                $link = preg_replace($this->symbols, '', strtolower($name));
                $link = preg_replace($this->spaces, '-', $link);
                $repeatCount = count(array_keys($usedItem, $name));

                if ($repeatCount > 0) {
                    $link .= '-' . ($repeatCount + 1);
                }

                $title = "<h" . $items[1][$i] . " id='" . $link . "'>" . $items[2][$i] . "</h" . $items[1][$i] . ">";

                $description = $this->replaceFirstOccurrence($items[0][$i], $title, $description);

                $usedItem[] = $name;
            } else {
                $description = $this->replaceFirstOccurrence($items[0][$i], '', $description);
            }
        }

        return $description;
    }

    /**
     * Generate table of contents
     *
     * @param string $originText
     *
     * @return string
     */
    public function tableContents(string $originText) : string
    {
        $originText = preg_replace("/<(p|[hH](10|[1-9]))>(<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>)<\/(p|[hH](10|[1-9]))>/", "$3", $originText);

        preg_match_all("/<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>/", $originText, $items);

        $menu = "{";
        $subItemsCount = 0;
        $parentItem = [];
        $usedItem = [];

        for ($i = 0; $i < count($items[0]); $i++) {

            $name = preg_replace($this->stripTags, "", trim(html_entity_decode($this->replaceH1Symbols($items[2][$i]), ENT_QUOTES)));

            if ($name) {
                $link = preg_replace($this->symbols, "", strtolower($name));
                $link = preg_replace($this->spaces, "-", $link);
                $repeatCount = count(array_keys($usedItem, $name));

                if ($repeatCount > 0) {
                    $link .= "-" . ($repeatCount + 1);
                }

                if ($i == 0) {
                    $menu .= '"' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';
                } elseif ($i != 0 && $items[1][$i] > $items[1][$i - 1]) {

                    $quantity = $items[1][$i] - $items[1][$i - 1];
                    $menu .= ', "subItems": {';
                    array_push($parentItem, (int)$items[1][$i - 1]);
                    $subItemsCount += $quantity;

                    for ($j = 1; $j <= $quantity - 1; $j++) {
                        $menu .= "\"" . $j . "\":{";
                        $menu .= '"subItems": {';
                        array_push($parentItem, $items[1][$i - 1] + $j);
                    }

                    $menu .= '"' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';

                } elseif ($i != 0 && $items[1][$i] < $items[1][$i - 1]) {
                    $quantity = $items[1][$i - 1] - $items[1][$i];
                    $menu .= "}";

                    if ($subItemsCount) {
                        for ($j = 1; $j <= $quantity * 2; $j++) {
                            $menu .= "}";
                            if ($j % 2 == 0) {
                                $subItemsCount--;
                                array_pop($parentItem);
                            }
                        }
                    }

                    $menu .= ', "' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';
                } else {
                    $menu .= '}, "' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';
                }

                if (!array_key_exists($i + 1, $items[1])) {
                    $a = $items[1][$i];

                    $lastParent = array_shift($parentItem);

                    if ($lastParent && $lastParent < $a) {
                        for ($q = 0; $q <= ($a - $lastParent) * 2; $q++) {
                            $menu .= "}";
                        }
                    } else {
                        $menu .= "}";
                    }
                }

                $usedItem[] = $name;
            }
        }
        $menu .= "}";

        return $menu;
    }

    /**
     * Replace special symbols in the headers
     *
     * @param string $text
     *
     * @return string
     */
    protected function replaceH1Symbols(string $text) : string
    {
        $text = preg_replace("/\&nbsp\;/", " ", $text);
        $text = preg_replace("/\&lt\;/", "«", $text);
        $text = preg_replace("/\&gt\;/", "»", $text);
        $text = preg_replace("/\&laquo\;/", "«", $text);
        $text = preg_replace("/\&raquo\;/", "»", $text);

        return $text;
    }

    /**
     * Replace first occurrence
     *
     * @param $from
     * @param $to
     * @param $subject
     *
     * @return string
     *
     * @link http://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
     */
    protected function replaceFirstOccurrence(string $from, string $to, string $subject) : string
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return preg_replace($from, $to, $subject, 1);
    }
}

/*TOC*/
use Lutdev\TOC\TableContents;

$tableContents = new TableContents();

$text = '<h1>Lorem ipsum dolor.</h1>
<h2>Lorem ipsum.</h2>
<h2>Reprehenderit, nam!</h2>
<h3>Lorem ipsum dolor sit.</h3>
<h3>Lorem ipsum dolor sit.</h3>
<h3>Lorem ipsum dolor sit.</h3>
<p>haha</p>
<h4>Lorem ipsum.</h4>
<h4>Lorem ipsum.</h4>
<h4>Lorem ipsum.</h4>
<h4>Lorem ipsum.</h4>
<h5>Lorem ipsum dolor sit.</h5>
<h5>Lorem ipsum dolor sit.</h5>
<h6>Lorem ipsum dolor sit.</h6>
<h4>Lorem ipsum.</h4>
<h4>Lorem ipsum.</h4>
<h3>Lorem ipsum dolor sit.</h3>
<h2>Placeat, aut.</h2>
<h2>Commodi, eius!</h2>
<h2>Accusamus, dolores!</h2>
<h1>In, provident, aspernatur.</h1>
<h1>Fugit, perspiciatis, atque?</h1>
<h1>Doloremque a, dolores.</h1>
<h1>Exercitationem enim, sint.</h1>
<h1>A, facere, modi.</h1>
<h1>Optio, ullam architecto.</h1>
<h1>Debitis aliquid, dolorem.</h1>
<h1>Molestiae, earum excepturi.</h1>
<h1>At, expedita, molestias.</h1>';

$a = $tableContents->tableContents($text);

$b = json_decode($a, true);

//print_r($b);

echo array2ul($b);

//code by acmol
function array2ul($array) {
    $out = "<ul>";
    foreach($array as $key => $elem){
        if(!is_array($elem)){
                $out .= "<li><span>$key:[$elem]</span></li>";
        }
        else $out .= "<li><span>$key</span>".array2ul($elem)."</li>";
    }
    $out .= "</ul>";
    return $out; 
}
