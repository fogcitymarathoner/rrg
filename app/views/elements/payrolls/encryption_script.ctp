
<?php
/*
* skip payroll transmittial in for if it is not existent for whatever reason
*/
$xml_file_name =$xml_home.'payrolls/paystub_transmittals/'.str_pad((string)$payroll['Payroll']['id'], 5, "0", STR_PAD_LEFT).'.xml';
if(file_exists ( $xml_file_name))
{
    echo '<h3>Encryption Script</h3><br>';
    // require_once("XML/Unserializer.php");
    require_once dirname(__FILE__) . '/../../XML/Unserializer.php';
    $serializer = &new XML_Unserializer();
    $f = fopen($xml_file_name,'r');
    $fsize = filesize($xml_file_name);
    if($fsize)
    {
        $doc = fread($f,$fsize);
        fclose($f);
        $serializer->unserialize($doc);
        $payments = $serializer->getUnserializedData ( );
    }
    //
    if(isset($payments['Payroll']['date_generated']))
    {
        echo '#fixture generated on: '.$payments['Payroll']['date_generated'].'<br></br>';
    }
    echo 'cp '.$xml_file_name .' . <br>';
}
?>