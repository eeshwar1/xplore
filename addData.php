<?php
include('solrInterface.php');
echo "<html><head><title>Add Data</title></head><body>";
echo "<h1>Add data</h1>";

if(isset($_POST['docname']) && $_POST['docname'] != ''){
    $docname = $_POST['docname'];
    $doctype = $_POST['doctype'];
    $doctext = $_POST['doctext'];
   
    $result = solrUpdate($docname, $doctype, $doctext);
    if(strstr($result, '<int name="status">0</int>'))
        echo 'SUCCESS: Data updated/indexed.<br/>';
    $result = solrCommit();
    if(strstr($result, '<int name="status">0</int>'))
        echo 'SUCCESS: Update/index committed.<br/>';
}
else if(isset($_POST['docname']) && $_POST['docname'] == ''){
    echo "ERROR in input: docname cannot be empty.<br/>";
}


echo '<form method="post">';
echo '<table>';
echo '<tr><td>docname:</td><td><input 
               name="docname" size="50"/></td></tr>';
echo '<tr><td>doctype:</td><td><input name="doctype" '.
     'size="50"/></td></tr>';
echo '<tr><td>doctext</td><td><input 
               name="doctext" size="50"/></td></tr>';
echo '</table>';
echo '<input type="submit" value="INDEX ME!"/>';
echo '</form>';

echo "</body></html>";

?>