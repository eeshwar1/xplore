<?php
include('solrInterface.php');

if(isset($_GET['searchText']) && $_GET['searchText'] != ''){
	
    $query = $_GET['searchText'];
    
    //echo 'searchText = ' . $query;
    $results = solrQuery($query);
    if($results != '')
    {

		//echo '<BR>results ' . $results;
        $result  = explode('<?xml version="1.0" encoding="UTF-8"?>', $results);
        
       // echo var_dump($result);
        $results = $result[1];

        $dom = new DomDocument;
        $dom->loadXML($results);
        $docs = $dom->getElementsByTagName('doc');

        $i = 1;
        
        $alldocs = array();
        foreach ($docs as $doc)
        {
            $strings = $doc->getElementsByTagName('str');
            foreach($strings as $str)
            {
                $attr = $str->getAttribute('name');
                $data = $str->textContent;
                switch($attr)
                {
                case 'docname':
                    $docname = $data;
                    break;
                case 'doctype':
                    $doctype = $data;
                    break;
                case 'doctext':
                    $doctext = $data;
                    break;
                }
            }
        
          $docdata = array(
            			"doc_name" => $docname,
            			"doc_type" => $doctype,
            			"doc_text" => $doctext);
          
        
        $alldocs[] = $docdata;
        
            $i++;
        }
       echo json_encode($alldocs,JSON_FORCE_OBJECT);
    }
   else
   {
     echo '<b>No data found for this query</b>';
   }
}
else if(isset($_GET['searchText']) && $_GET['searchText'] == ''){
    echo "ERROR in input: query cannot be empty.<br/>";
}
else
{
  echo "nothing received";
}


?>