<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Expire Documents</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
    <style type="text/css">
        body {
            font: normal 11px  arial,sans-serif;
        }

        @page { margin: 0.2in 0.2in 0.2in 0.2in;} 

        p { margin: 0; font-size: 12px; }

        .header { text-align: center; margin-bottom: 25px; }
        .header h4, .header h5 { margin: 0; }
        .header p { font-size: 9px; }

        .clear { clear: both; }
        p.inline_p { display: inline; }
        p.has_pad { padding-right: 15px;  }

        table { width: 100%; margin: 0; padding: 0; font-size: 11px; }  
        table thead { border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 3px 0; }
        table thead td { font-weight: bold; padding: 4px 0; }
        table td, table th { padding: 2px; vertical-align: middle; border: 1px solid #000;  }   /*  border: 1px solid #cecece */
        table td.uline { border-bottom: 1px solid #000; }
        table td.td_label { font-size: 6px; padding: 0; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h4>DOCUMENT MAINTENANCE REPORT</h4>
    </div>
    <div class="body">
        <p style="margin-bottom: 10px;">Document: <?php echo isset($docs)? $docs : '' ; ?>  </p>

        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 2%;"><p>No</p></th>
                    <th style="width: 5%;"><p>Rank</p></th>
                    <th style="width: 23%;"><p>Name</p></th>
                    <th style="width: 20%;"><p>Vessel</p></th>
                    <th style="width: 9%;"><p>Certificates</p></th>
                    <th style="width: 9%;"><p>Date On Board</p></th>
                    <th style="width: 9%;"><p>Expiry Date</p></th>
                    <th style="width: 15%;"><p>Remarks</p></th>
                    <th style="width: 8%;"><p>Updates</p></th>
                </tr>
            </thead>

        <?php
        if($data):
            $counter = 0;
            foreach ($data as $value):
                $counter++;

                $expr   = ($value->date_expired != '0000-00-00')? $value->date_expired : '';    
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $counter; ?></td>
                <td style="text-align: center;"><?php echo $value->code; ?></td>
                <td><?php echo $value->fullname; ?></td>
                <td><?php echo $value->vessel_name; ?></td>
                <td style="text-align: center;"><?php echo $value->docs_nos; ?></td>
                <td style="text-align: center;"><?php echo $value->embarked; ?></td>
                <td style="text-align: center;"><?php echo $expr; ?></td>
                <td><?php echo $value->remarks; ?></td>
                <td>&nbsp;</td>
            </tr>
        <?php 
            endforeach;
        endif;
        ?>
        </table>
    </div>
</body>
</html>