<?php
include "db.php";
require "vendor/autoload.php";

$uid=$_SESSION["id"];
$sql=$conn->prepare("select * from books where uid=?");
$sql->bind_param("i",$uid);
$execute();
$result=$sql->get_result();
$pdf=new TCPDF();
$pdf->Ln(6);
$pdf->Cell(0,1,"C");
$pdf->setFont("times","I",16);
$html='<table>
<tr>
<td>ID</td>
<td>TITLE</td>
<td>AUTHOR</td>
<td>ISBN</td>
<td>CATEGORY</td>
<td>PRICE</td>
</tr>
';
while($row=$result->fetch_assoc()){
$html.='<tr>
<td>'.$row["bid"].'</td>
<td>'.$row["title"].'</td>
<td>'.$row["author"].'</td>
<td>'.$row["isbn"].'</td>
<td>'.$row["category"].'</td>
<td>'.$row["price"].'</td>
</td>';
}
$html.'</table>';
$pdf->writeHTML($html,tru,false,true,false,"");
$pdf->Output("product.pdf","D");
?>
