<?php
include('functions.php');
echo "<html><head><title>Add UIS package
                           </title></head><body>";
echo "<h1>Add a package</h1>";

if(isset($_POST['trackid']) && $_POST['trackid'] != ''){
    $city = $_POST['city'];
    $clocation = $_POST['clocation'];
    $country = $_POST['country'];
    $digits = $_POST['digits'];
    $dim = $_POST['dim'];
    $icode = $_POST['icode'];
    $pcode = $_POST['pcode'];
    $planet = $_POST['planet'];
    $street = $_POST['street'];
    $trackid = $_POST['trackid'];
    $weight = $_POST['weight'];
    $result = solrUpdate($city, $clocation, $country, $digits, $dim, $icode,
                         $pcode, $planet, $street, $trackid, $weight);
    if(strstr($result, '<int name="status">0</int>'))
        echo 'SUCCESS: Data updated/indexed.<br/>';
    $result = solrCommit();
    if(strstr($result, '<int name="status">0</int>'))
        echo 'SUCCESS: Update/index committed.<br/>';
}
else if(isset($_POST['trackid']) && $_POST['trackid'] == ''){
    echo "ERROR in input: trackid cannot be empty.<br/>";
}


echo '<form method="post">';
echo '<table>';
echo '<tr><td>city:</td><td><input 
               name="city" size="50"/></td></tr>';
echo '<tr><td>clocation:</td><td><input name="clocation" '.
     'size="50"/></td></tr>';
echo '<tr><td>country:</td><td><input 
               name="country" size="50"/></td></tr>';
echo '<tr><td>digits:</td><td><input 
               name="digits" size="50"/></td></tr>';
echo '<tr><td>dim:</td><td><input 
               name="dim" size="50"/></td></tr>';
echo '<tr><td>icode:</td><td><input 
               name="icode" size="50"/></td></tr>';
echo '<tr><td>pcode:</td><td><input 
               name="pcode" size="50"/></td></tr>';
echo '<tr><td>planet:</td><td><input 
               name="planet" size="50"/></td></tr>';
echo '<tr><td>street:</td><td><input 
               name="street" size="50"/></td></tr>';
echo '<tr><td>trackid:</td><td><input 
               name="trackid" size="50"/></td></tr>';
echo '<tr><td>weight:</td><td><input 
               name="weight" size="50"/></td></tr>';
echo '</table>';
echo '<input type="submit" value="INDEX ME!"/>';
echo '</form>';

echo "</body></html>";

?>