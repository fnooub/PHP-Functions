<?php
include 'functions.php';
/* tải lại nội dung */
$link = get_links_content('links.txt');
$single_curl = single_curl($link);
$bdTit = '<p class="title" style="font-size: 1.2rem; margin-bottom: 0.2rem">';
$tieude = get_match($bdTit, '</p>', $single_curl);

$bdCont = '<div id="ContentBody" class="" data-id=\'120\' style="margin-top: 1rem">';
$cont = get_match($bdCont, '</div>', $single_curl);

$cont = nl2p(remove_all_tags($cont));

// data
$data = "{$tieude}\n{$cont}\n";

save_content($data, 'Texts');
