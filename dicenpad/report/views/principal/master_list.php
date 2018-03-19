<?php 

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L', 'Legal');
$pdf->Cell(0, 10, 'PRINCIPAL MASTER LIST', 1, 1, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 0, 'Filter by: ' . $status, 0, 1, 'L');
$pdf->Ln(1);
$pdf->Cell(0, 0, 'As of ' . date('M d, Y'), 0, 1, 'L');
$pdf->Ln(8);

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
    body { font: 12px arial; }
    h4 {
        text-align: center;
        border: 1px solid #000;
    }

    table { width: 100%;  }
    th {
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
        text-align: center;
        font-weight: bold;
        font-size: 9px;
    }
    td{
        text-align: center;
        border-bottom: 1px dashed #000;
        font-size: 8px;
    }

</style>


<table cellpadding="3" cellspacing="0">
    <tr>
        <th width="3%">No</th>
        <th width="5%">Code</th>
        <th width="15%">Name</th>
        <th width="29%">Address</th>
        <th width="10%">In-charge</th>
        <th width="10%">Position</th>
        <th width="10%">Tel No.</th>
        <th width="10%">Fax No.</th>
        <th width="8%">Accredited</th>
    </tr>
EOF;

if($results){
    $counter = 0;
    foreach ($results as $value) {
        $counter++;

        $contact = trim($value->telno1) . ((trim($value->telno2) != '')? '/' . trim($value->telno2) : '') . ((trim($value->telno3) != '')? '/' . trim($value->telno3) : '');
        $fax = trim($value->fax1) . ((trim($value->fax2) != '')? '/' . trim($value->fax2) : '') . ((trim($value->fax3) != '')? '/' . trim($value->fax3) : '');

        $accredited = date('m/d/Y', strtotime($value->accredited));
$html .= <<<EOF
    <tr> 
    <td><center>{$counter}</center></td>
    <td>{$value->code}</td>
    <td style="text-align: left;">{$value->fullname}</td>
    <td style="text-align: left;">{$value->address}</td>
    <td style="text-align: left;">{$value->person1}</td>
    <td style="text-align: left;">{$value->designate1}</td>
    <td>{$contact}</td>
    <td>{$fax}</td>
    <td>{$accredited}</td>
    </tr> 
EOF;
    }
}

$html .= <<<EOF
</table>
EOF;

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('principal-list.pdf', 'I');