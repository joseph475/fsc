<?php 

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L', 'Legal');
$pdf->Cell(0, 10, 'VESSEL MASTER LIST', 1, 1, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 0, $status, 0, 1, 'L');
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

    table { width: 100%; }

    th {
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
        text-align: center;
        font-weight: bold;
        border-bottom: 1px dashed #000;
        font-size: 9px;
    }
    table td{
        text-align: center;
        border-bottom: 1px dashed #000;
        font-size: 8px;
    }

</style>


<table cellpadding="3" cellspacing="0">
    <tr>
        <th width="3%">No</th>
        <th width="23%">Name</th>
        <th width="14%">Principal</th>
        <th width="3%">Year</th>
        <th width="4%">GRT</th>
        <th width="4%">NET</th>
        <th width="4%">DWT</th>
        <th width="4%">Length</th>
        <th width="4%">Depth</th>
        <th width="4%">Breadth</th>
        <th width="4%">Cylinder</th>
        <th width="4%">HP</th>
        <th width="4%">Speed</th>
        <th width="9%">Type</th>
        <th width="5%">Flag</th>
        <th width="7%">IMO No.</th>
    </tr>
EOF;

if($results){
    $counter = 0;
    foreach ($results as $value) {
        $counter++;
$html .= <<<EOF
    <tr> 
        <td><center>{$counter}</center></td>
        <td style="text-align: left;"><b>{$value->vessel_name}</b> 
             <br/> BUILDER: {$value->builder}
             <br/> BUILT IN: {$value->builtin}
             <br/> Engine: {$value->engine}
            </td>
        <td style="text-align: left;">{$value->principal}</td>
        <td>{$value->e_year}</td>
        <td>{$value->gross}</td>
        <td>{$value->net}</td>
        <td>{$value->dwt}</td>
        <td>{$value->length}</td>
        <td>{$value->depth}</td>
        <td>{$value->breadth}</td>
        <td>{$value->cylinder}</td>
        <td>{$value->hp}</td>
        <td>{$value->speed}</td>
        <td style="text-align: left;">{$value->type}</td>
        <td style="text-align: left;">{$value->flag}</td>
        <td>{$value->imo_nos}</td>
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
$pdf->Output('vessels-list.pdf', 'I');