<?php

define('SOLR_URL', 'http://localhost:8080/xplore/');

function solrUpdate($city, $clocation, $country, $digits, $dim, $icode,
                    $pcode, $planet, $street, $trackid, $weight){
    $dom = new DomDocument();
    $root = $dom->createElement('add');
    $root = $dom->appendChild($root);

    $doc = $dom->createElement('doc');
    $doc = $root->appendChild($doc);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'city');
    $fieldText = $dom->createTextNode(esc($city));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'clocation');
    $fieldText = $dom->createTextNode(esc($clocation));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'country');
    $fieldText = $dom->createTextNode(esc($country));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'digits');
    $fieldText = $dom->createTextNode(esc($digits));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'dim');
    $fieldText = $dom->createTextNode(esc($dim));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'icode');
    $fieldText = $dom->createTextNode(esc($icode));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'pcode');
    $fieldText = $dom->createTextNode(esc($pcode));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'planet');
    $fieldText = $dom->createTextNode(esc($planet));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'street');
    $fieldText = $dom->createTextNode(esc($street));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'trackid');
    $fieldText = $dom->createTextNode(esc($trackid));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'weight');
    $fieldText = $dom->createTextNode(esc($weight));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $str = $dom->saveXML();
    if($str)
        return $success = request($str, "update");
    return 0;
}

                    
function request($reqData, $type){

    $header[] = "Content-type: text/xml; charset=UTF-8";

    $session = curl_init();
    curl_setopt($session, CURLOPT_HEADER,         true);
    curl_setopt($session, CURLOPT_HTTPHEADER,     $header);
    curl_setopt($session, CURLOPT_URL,            SOLR_URL.$type);
    curl_setopt($session, CURLOPT_POSTFIELDS,     $reqData);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($session, CURLOPT_POST,           1);

    $response = curl_exec($session);
    curl_close($session);

    return $response;
}
                    
function esc($str){
    $str = str_replace('&', '&',  $str);
    $str = str_replace('<', '<',   $str);
    $str = str_replace('>', '>',   $str);
    $str = str_replace('"', '&quot;', $str);
    $str = str_replace('\'', '&#39;', $str);
    return $str;
}
                    
function solrCommit(){
    return request("<commit/>", "update");
}

function solrQuery($q){
    $query = "?q=".trim(urlencode($q)).
        "&version=2.2&start=0&rows=10&indent=on";

    if($q != '')
        return $results = request("", "select".$query);
    return 0;
}
?>