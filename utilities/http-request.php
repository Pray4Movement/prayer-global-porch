<?php

/**
 * Send an API response
 * @param  *       $response The API response
 * @param  integer $code     The response code
 * @param  boolean $encode   If true, encode response
 */
function send_response ($response, $code = 200) {
	http_response_code($code);
	die(json_encode($response));
}