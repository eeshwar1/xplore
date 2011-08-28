<?php
include('functions.php');
echo "<html><head><title>Search UIS packages</title>
           </head><body>";
echo "<h1>Search packages</h1>";

echo '<form method="post">';
echo '<table>';
echo '<tr><td>query:</td><td><input name="query" 
           size="50"/></td></tr>';
echo '</table>';
echo '<input type="submit" value="FIND ME!"/>';
echo '</form>';

if(isset($_POST['query']) && $_POST['query'] != ''){
    $query = $_POST['query'];
    $results = solrQuery($query);
    if($results != ''){
        echo "<h3>Results:</h3>";

        $results =
            explode('<?xml version="1.0" encoding="UTF-8"?>', $results);
        $results = $results[1];

        $dom = new DomDocument;
        $dom->loadXML($results);
        $docs = $dom->getElementsByTagName('doc');

        $i = 1;
        foreach ($docs as $doc) {
            $strings = $doc->getElementsByTagName('str');
            foreach($strings as $str){
                $attr = $str->getAttribute('name');
                $data = $str->textContent;
                switch($attr){
                case 'city':
                    $city = $data;
                    break;
                case 'clocation':
                    $clocation = $data;
                    break;
                case 'country':
                    $country = $data;
                    break;
                case 'digits':
                    $digits = $data;
                    break;
                case 'dim':
                    $dim = $data;
                    break;
                case 'icode':
                    $icode = $data;
                    break;
                case 'pcode':
                    $pcode = $data;
                    break;
                case 'planet':
                    $planet = $data;
                    break;
                case 'street':
                    $street = $data;
                    break;
                case 'trackid':
                    $trackid = $data;
                    break;
                case 'weight':
                    $weight = $data;
                    break;
                }
            }
            echo "$i.";
            echo '<table border="1">';
            echo '<tr><td>city:</td><td>'
			                                   .$city.'</td></tr>';
            echo '<tr><td>clocation:</td><td>'
			                                    .$clocation.'</td></tr>';
            echo '<tr><td>country:</td><td>'
			                                    .$country.'</td></tr>';
            echo '<tr><td>digits:</td><td>'
			                                     .$digits.'</td></tr>';
            echo '<tr><td>dim:</td><td>'
			                                      .$dim.'</td></tr>';
            echo '<tr><td>icode:</td><td>'
			                                      .$icode.'</td></tr>';
            echo '<tr><td>pcode:</td><td>'
			                                      .$pcode.'</td></tr>';
            echo '<tr><td>planet:</td><td>'
			                                      .$planet.'</td></tr>';
            echo '<tr><td>street:</td><td>'
			                                      .$street.'</td></tr>';
            echo '<tr><td>trackid:</td><td>'
			                                      .$trackid.'</td></tr>';
            echo '<tr><td>weight:</td><td>'
			                                      .$weight.'</td></tr>';
            echo '</table><br/>';
            $i++;
        }
    }
}
else if(isset($_POST['query']) && $_POST['query'] == ''){
    echo "ERROR in input: query cannot be empty.<br/>";
}


echo "</body></html>";

?>