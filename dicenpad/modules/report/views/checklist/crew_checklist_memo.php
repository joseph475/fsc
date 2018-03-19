<?php 

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

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

$ship_docs = '';
$vessel = '';
$joining = date('F d, Y');

if($results){
    foreach ($results as $value) {
        $ship_docs = $value->ship_document;
        $vessel = strtoupper($value->vessel_name);
        $joining = date('F d, Y', strtotime($value->joining_date));
        break;
    }   
}

// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
    body { font: 12px arial; }
    h1 {
        color: navy;
        font-family: times;
        font-size: 24pt;
        text-decoration: underline;
    }

    ol.b { font-weight: bold; }
    ol li ol { font-weight: normal; }

</style>

<h4>{$joining}<br/> </h4>

<h4>TO THE MASTER <br/> {$vessel}</h4>

<p>Dear Sir,</p>

<p>Please kindly find the Ship's & Crew documents as follows;</p>

<ol type="A" class="b">
    <li style="margin-bottom: 20px;">SHIP DOCUMENTS: {$ship_docs} <br/></li>
    <li>CREW DOCUMENTS:
        <ol type="1" class="b">
EOF;

if($results){
    foreach ($results as $value) {
$html .= <<<EOF
    {$value->crew_document}
EOF;
    }   
}

$html .= <<<EOF
        </ol>
    </li>
</ol>

<p>We hope you will find all in good order.</p>

<p>Very Truly Yours,</p>

<p>FAIR Shipping Corporation</p>

<p>MR. JULIUS M. BONDOC <br/>Assitant Operation Manager</p>
EOF;

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('checklist-memo.pdf', 'I');