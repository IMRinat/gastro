<?php

echo "privet \n";
print_r ( get_web_page( '45.r-mis.ru' ));
echo "poka \n";

function get_web_page( $url )
{
    $ch      = curl_init( $url );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_USERAGENT, "spider");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie2.txt");

    //curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );

    $newheader=substr($content,0,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
    $newbody=substr($content,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
    curl_close( $ch );


    preg_match_all("/Set-Cookie: (.*?)=(.*?);/i",$newheader,$res);
    $cookie='';
    foreach ($res[1] as $key => $value) {
       //Здесь можно провести любую обработку COOKIES
       $cookie.= $value.'='.$res[2][$key].'; ';
    };

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['cookie'] = $cookie;
    $header['newheader'] = $newheader;
    $header['newbody'] =  $newbody;
    $header['content'] = $content;

    return $header;
}
?>