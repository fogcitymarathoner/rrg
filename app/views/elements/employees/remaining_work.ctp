<?php
if(empty($employee['Employee']['ssn_crypto']))
{
echo '<td>NO SNN</td>';
}
else
{
echo '<td></td>';
}
if(empty($employee['Employee']['city']))
{
echo '<td>NO CITY</td>';
}
else
{
echo '<td></td>';
}
if(empty($employee['Employee']['zip']))
{
echo '<td>NO Zip</td>';
}
else
{
echo '<td></td>';
}
echo '</tr>';

?>
