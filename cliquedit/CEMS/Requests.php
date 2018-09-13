<?php 


class Requests
{
	
	public static function get( $method, $api_key, $domain, $getData= null ) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
	    
	    if( !is_null( $getData ) ) $getData = http_build_query($getData);

	    //echo Requests::$endpoint.$method."?api_key=".$api_key."&domain=".$domain."&".$getData;
	    curl_setopt($ch, CURLOPT_URL, Requests::$endpoint.$method."?api_key=".$api_key."&domain=".$domain."&".$getData );

	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    
	    $data = curl_exec($ch);
	    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    if ($retcode == 200) {
	        curl_close($ch);
	    	return $data;
	    }else{
	        echo '<strong>CEMS Error: '.curl_error($ch).'</strong>';
	        curl_close($ch);
	    	return null;
	    }
	}

	public static function post( $method, $api_key, $domain, $postData ) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
	    curl_setopt($ch, CURLOPT_URL, Requests::$endpoint.$method."?api_key=".$api_key."&domain=".$domain );

	    /*Post options*/

	    curl_setopt($ch, CURLOPT_POST, 1);

	    $postData = http_build_query($postData);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData );

	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    
	    $data = curl_exec($ch);
	    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    if ($retcode == 201) {
	        curl_close($ch);
	    	return $data;
	    }else{
	        echo '<strong>CEMS Error: '.curl_error($ch).'</strong>';
	        curl_close($ch);
	    	return null;
	    }
	}

	private static $endpoint = "http://cliqued.it/api/";
}

?>