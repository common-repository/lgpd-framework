<?php
 /**
  * WHMCS Licensing Addon - Integration Code Sample
  * http://www.whmcs.com/addons/licensing-addon/
  *
  * The following code is a fully working code sample demonstrating how to
  * perform license checks using the WHMCS Licensing Addon. It is PHP 4 and
  * 5 compatable.  Requires the WHMCS Licensing Addon to be used.
  *
  * @package    WHMCS
  * @author     WHMCS Limited <development@whmcs.com>
  * @copyright  Copyright (c) WHMCS Limited 2005-2013
  * @license    http://www.whmcs.com/license/ WHMCS Eula
  * @version    $Id$
  * @link       http://www.whmcs.com/
  */

// This prevents any direct access
exit;

// Replace "yourprefix" with your own unique prefix to avoid conflicts with
// other instances of the licensing addon included within the same scope
function ipals20_check_license( $licensekey, $localkey = '' ) {

	// -----------------------------------
	// -- Configuration Values --
	// -----------------------------------

	// Enter the url to your WHMCS installation here
	$whmcsurl = 'http://www.portal.stallioninternet.com/';
	// Must match what is specified in the MD5 Hash Verification field
	// of the licensing product that will be used with this check.
	$licensing_secret_key = 'Jordan#2014$';
	// The number of days to wait between performing remote license checks
	$localkeydays = 15;
	// The number of days to allow failover for after local key expiry
	$allowcheckfaildays = 5;

	// -----------------------------------
	// -- Do not edit below this line --
	// -----------------------------------

	$check_token    = time() . md5( mt_rand( 1000000000, 9999999999 ) . $licensekey );
	$checkdate      = date( 'Ymd' );
	$domain         = $_SERVER['SERVER_NAME'];
	$usersip        = isset( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
	$dirpath        = dirname( __FILE__ );
	$verifyfilepath = 'modules/servers/licensing/verify.php';
	$localkeyvalid  = false;
	if ( $localkey ) {
		$localkey  = str_replace( "\n", '', $localkey ); // Remove the line breaks
		$localdata = substr( $localkey, 0, strlen( $localkey ) - 32 ); // Extract License Data
		$md5hash   = substr( $localkey, strlen( $localkey ) - 32 ); // Extract MD5 Hash
		if ( $md5hash == md5( $localdata . $licensing_secret_key ) ) {
			$localdata         = strrev( $localdata ); // Reverse the string
			$md5hash           = substr( $localdata, 0, 32 ); // Extract MD5 Hash
			$localdata         = substr( $localdata, 32 ); // Extract License Data
			$localdata         = base64_decode( $localdata );
			$localkeyresults   = unserialize( $localdata );
			$originalcheckdate = $localkeyresults['checkdate'];
			if ( $md5hash == md5( $originalcheckdate . $licensing_secret_key ) ) {
				$localexpiry = date( 'Ymd', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - $localkeydays, date( 'Y' ) ) );
				if ( $originalcheckdate > $localexpiry ) {
					$localkeyvalid = true;
					$results       = $localkeyresults;
					$validdomains  = explode( ',', $results['validdomain'] );
					if ( ! in_array( $_SERVER['SERVER_NAME'], $validdomains ) ) {
						$localkeyvalid             = false;
						$localkeyresults['status'] = 'Invalid';
						$results                   = array();
					}
					$validips = explode( ',', $results['validip'] );
					if ( ! in_array( $usersip, $validips ) ) {
						$localkeyvalid             = false;
						$localkeyresults['status'] = 'Invalid';
						$results                   = array();
					}
					$validdirs = explode( ',', $results['validdirectory'] );
					if ( ! in_array( $dirpath, $validdirs ) ) {
						$localkeyvalid             = false;
						$localkeyresults['status'] = 'Invalid';
						$results                   = array();
					}
				}
			}
		}
	}
	if ( ! $localkeyvalid ) {
		$postfields = array(
			'licensekey' => $licensekey,
			'domain'     => $domain,
			'ip'         => $usersip,
			'dir'        => $dirpath,
		);
		if ( $check_token ) {
			$postfields['check_token'] = $check_token;
		}
		$query_string = '';
		foreach ( $postfields as $k => $v ) {
			$query_string .= $k . '=' . urlencode( $v ) . '&';
		}
		if ( function_exists( 'curl_exec' ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $whmcsurl . $verifyfilepath );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $query_string );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			$data = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$fp = fsockopen( $whmcsurl, 80, $errno, $errstr, 5 );
			if ( $fp ) {
				$newlinefeed = "\r\n";
				$header      = 'POST ' . $whmcsurl . $verifyfilepath . ' HTTP/1.0' . $newlinefeed;
				$header     .= 'Host: ' . $whmcsurl . $newlinefeed;
				$header     .= 'Content-type: application/x-www-form-urlencoded' . $newlinefeed;
				$header     .= 'Content-length: ' . @strlen( $query_string ) . $newlinefeed;
				$header     .= 'Connection: close' . $newlinefeed . $newlinefeed;
				$header     .= $query_string;
				$data        = '';
				@stream_set_timeout( $fp, 20 );
				@fputs( $fp, $header );
				$status = @socket_get_status( $fp );
				while ( ! @feof( $fp ) && $status ) {
					$data  .= @fgets( $fp, 1024 );
					$status = @socket_get_status( $fp );
				}
				@fclose( $fp );
			}
		}
		if ( ! $data ) {
			$localexpiry = date( 'Ymd', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - ( $localkeydays + $allowcheckfaildays ), date( 'Y' ) ) );
			if ( $originalcheckdate > $localexpiry ) {
				$results = $localkeyresults;
			} else {
				$results                = array();
				$results['status']      = 'Invalid';
				$results['description'] = 'Remote Check Failed';
				return $results;
			}
		} else {
			preg_match_all( '/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches );
			$results = array();
			foreach ( $matches[1] as $k => $v ) {
				$results[ $v ] = $matches[2][ $k ];
			}
		}
		if ( ! is_array( $results ) ) {
			die( 'Invalid License Server Response' );
		}
		if ( $results['md5hash'] ) {
			if ( $results['md5hash'] != md5( $licensing_secret_key . $check_token ) ) {
				$results['status']      = 'Invalid';
				$results['description'] = 'MD5 Checksum Verification Failed';
				return $results;
			}
		}
		if ( $results['status'] == 'Active' ) {
			$results['checkdate'] = $checkdate;
			$data_encoded         = serialize( $results );
			$data_encoded         = base64_encode( $data_encoded );
			$data_encoded         = md5( $checkdate . $licensing_secret_key ) . $data_encoded;
			$data_encoded         = strrev( $data_encoded );
			$data_encoded         = $data_encoded . md5( $data_encoded . $licensing_secret_key );
			$data_encoded         = wordwrap( $data_encoded, 80, "\n", true );
			$results['localkey']  = $data_encoded;
		}
		$results['remotecheck'] = true;
	}
	unset( $postfields, $data, $matches, $whmcsurl, $licensing_secret_key, $checkdate, $usersip, $localkeydays, $allowcheckfaildays, $md5hash );
	return $results;
}

// Get the license key and local key from storage
// These are typically stored either in flat files or an SQL database

$licensekey = '';
$localkey   = '';
$base       = __DIR__;
$handle     = fopen( $base . '/license.txt', 'r' );
if ( $handle ) {
	$count = 0;
	while ( ( $line = fgets( $handle ) ) !== false ) {
		// process the line read.
		if ( $count == 0 ) {
			$licensekey = trim( $line );
		} elseif ( $count == 1 ) {
			$localkey = trim( $line );
			break;
		}
		$count++;
	}

	fclose( $handle );
} else {
	die( 'Could not read license file. Please contact support.' );
}

echo $licensekey . '<br/>';
echo $localkey . '<br/>';

// Validate the license key information
$results = licensetest_check_license( $licensekey, $localkey );

// Raw output of results for debugging purpose
echo '<textarea cols="100" rows="20">' . print_r( $results, true ) . '</textarea>';

// Interpret response
switch ( $results['status'] ) {
	case 'Active':
		// get new local key and save it somewhere
		$localkeydata = str_replace( ' ', '', preg_replace( '/\s+/', ' ', $results['localkey'] ) );
		$handle       = fopen( $base . '/license.txt', 'r' );
		if ( $handle ) {
			$count = 0;
			while ( ( $line = fgets( $handle ) ) !== false ) {
				// process the line read.
				if ( $count == 0 ) {
					$licensekey = trim( $line );
					break;
				}
				$count++;
			}
			fclose( $handle );
			if ( isset( $results['localkey'] ) ) {
				$textfile = fopen( $base . '/license.txt', 'w' ) or die( 'Unable to open file!' );
				$contents = $licensekey . "\n" . $localkeydata . "\n";
				fwrite( $textfile, $contents );
				fclose( $textfile );
			}
		} else {
			die( 'Could not read license file. Please contact support.' );
		}
		break;
	case 'Invalid':
		die( 'License key is Invalid' );
		break;
	case 'Expired':
		die( 'License key is Expired' );
		break;
	case 'Suspended':
		die( 'License key is Suspended' );
		break;
	default:
		die( 'Invalid Response' );
		break;
}


