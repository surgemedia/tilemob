<?php
$file = '../pdfs/SPECTRUM.pdf';

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="SPECTRUM.pdf"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: '.filesize($file));
header('Accept-Ranges: bytes');

@readfile($file);
?>