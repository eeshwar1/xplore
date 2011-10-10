<?php

define('SOLR_URL', 'http://localhost:8080/xplore/');

function solrUpdate($docname, $doctype, $doctext){
    $dom = new DomDocument();
    $root = $dom->createElement('add');
    $root = $dom->appendChild($root);

    $doc = $dom->createElement('doc');
    $doc = $root->appendChild($doc);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'docname');
    $fieldText = $dom->createTextNode(esc($docname));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'doctype');
    $fieldText = $dom->createTextNode(esc($doctype));
    $field->appendChild($fieldText);
    $doc->appendChild($field);

    $field = $dom->createElement('field');
    $field->setAttribute('name', 'doctext');
    $fieldText = $dom->createTextNode(esc($doctext));
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