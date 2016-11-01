<?php
function encrypt($code, $content) {
	$hash = unpack('H*', $code)[1];
	$length = strlen($hash);
	$value = unpack('H*', $content)[1];
	$data = '';
	for ($i = 0; $i < strlen($value); $i++) {
		$data .= substr($value, $i, 1);
		if ($i%$length == 0){
			$data.=substr($hash, rand(0, $length-1), 1);
		}
	}
	
	return $data;
}

function decrypt($code, $content) {
	$hash = unpack('H*', $code)[1];
	$length = strlen($hash);
	$data = '';$c = 0;
	for ($i = 0; $i < strlen($content); $i++) {
		$data .= substr($content, $i, 1);
		if ($c%$length == 0){
			$i++;
		}
		$c++;
	}
	
	return pack('H*', $data);
}

function getGUID()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}