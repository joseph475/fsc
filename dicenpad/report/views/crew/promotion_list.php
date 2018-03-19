<?php 

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('P', 'A4');
$pdf->Cell(0, 10, 'PROMOTION LIST', 1, 1, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 0, $status, 0, 1, 'L');
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
        <th width="4%">No</th>
        <th width="28%">Name</th>
        <th width="24%">Vessel</th>
        <th width="8%">Prev Position</th>
        <th width="8%">New Position</th>
        <th width="10%">Promotion</th>
        <th width="18%">Remarks</th>
    </tr>
EOF;

if($results){
    $counter = 0;
    foreach ($results as $value) {
        $counter++;
        $pd = date('d-M-Y', strtotime($value->promotion_date));
$html .= <<<EOF
    <tr> 
    <td><center>{$counter}</center></td>
    <td style="text-align: left;">{$value->fullname}</td>
    <td style="text-align: left;">{$value->vessel_name}</td>
    <td>{$value->new_position_code}</td>
    <td>{$value->prev_position_code}</td>
    <td>{$pd}</td>
    <td style="text-align: left;">{$value->remarks}</td>
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
$pdf->Output('promotion-list.pdf', 'I');