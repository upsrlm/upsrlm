<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>
<table class="table ">

    <tr style="background-color: #000000;color: #ffffff">
        <td >
        </td>
        <td >Performance metric
        </td>
        <td>
            KPA
        </td>
        <td >Criteria
            &amp; weightage
        </td>
        <td >
            Rating
        </td>
        <td >
            Particulars; justification
        </td>
    </tr>
    <tr height="10px"></tr>
    <tr >
        <th width="8%" rowspan="2" class="text-90deg-text" style="background-color:#8dd873">
            RSETI   
        </th>
        <td rowspan="2" style="background-color:#def9d7">1. BC Sakhi certification (against total no. of GPs)</td>
        <td style="background-color:#def9d7">1.1. % of certified BCs</td>
       
        <td style="background-color:#def9d7">
            <table style="width:100%">
                <tr>
                    <td width="80%">90-100%</td> 

                </tr> 
                <tr>
                    <td width="80%">Less than 90%</td> 

                </tr>

            </table>    
        </td>
        <td style="background-color:#def9d7">
            <table style="width:100%">
                <tr>
                    <td width="80%">10</td> 

                </tr> 
                <tr>
                    <td width="80%">0</td> 

                </tr>

            </table>   
        </td>
        <td style="background-color:#def9d7">
            Weightage : <?=$model->per_certified_bc?><br/>
            Rating : <?=$model->certified_bc_rating?>
        </td>
    </tr>
    <tr style="background-color:#def9d7">
        
        <td style="background-color:#def9d7">1.2. % of certified BC unwilling</td>
       
        <td style="background-color:#def9d7">
            <table style="width:100%">
                <tr>
                    <td width="80%">Less than 25</td> 

                </tr> 
                <tr>
                    <td width="80%">More than 25</td> 

                </tr>

            </table>    
        </td>
        <td style="background-color:#def9d7">
            <table style="width:100%">
                <tr>
                    <td width="80%">10</td> 

                </tr> 
                <tr>
                    <td width="80%">0</td> 

                </tr>

            </table>   
        </td>
        <td style="background-color:#def9d7">
            Weightage : <?=$model->per_certified_bc_unwilling?><br/>
            Rating : <?=$model->certified_bc_unwilling_rating?>
        </td>
    </tr>
    <tr height="10px"></tr>
    
    
    <tr>
        <th width="8%" rowspan="2" class="text-90deg-text" style="background-color:#60caf3">
            UPSRLM   
        </th>
        <td rowspan="2" style="background-color:#caedfb">2. Timely provision of program inputs</td>
        <td style="background-color:#caedfb">2.1. Payment of BC support fund</td>
       
        <td style="background-color:#caedfb">
            <table style="width:100%">
                <tr>
                    <td width="80%">Above 90%</td> 

                </tr> 
                <tr>
                    <td width="80%">Less than 90%</td> 

                </tr>

            </table>    
        </td>
        <td style="background-color:#caedfb">
            <table style="width:100%">
                <tr>
                    <td width="80%">10</td> 

                </tr> 
                <tr>
                    <td width="80%">0</td> 

                </tr>

            </table>   
        </td>
        <td style="background-color:#caedfb">
            Weightage : <?=$model->upsrlm_payment_of_bc_support_fund_per?><br/>
            Rating : <?=$model->certified_bc_unwilling_rating?>
        </td>
    </tr>
    <tr style="background-color:#caedfb">
        
        <td style="background-color:#caedfb">2.2. Payment of BC honorarium</td>
       
        <td style="background-color:#caedfb">
            <table style="width:100%">
                <tr>
                    <td width="80%">Above 90%</td> 

                </tr> 
                <tr>
                    <td width="80%">Less than 90%</td> 

                </tr>

            </table>    
        </td>
        <td style="background-color:#caedfb">
            <table style="width:100%">
                <tr>
                    <td width="80%">10</td> 

                </tr> 
                <tr>
                    <td width="80%">0</td> 

                </tr>

            </table>   
        </td>
        <td style="background-color:#caedfb">
            Weightage : <?=$model->upsrlm_payment_of_bc_honorarium_per?><br/>
            Rating : <?=$model->certified_bc_unwilling_rating?>
        </td>
    </tr>
     <tr height="10px"></tr>
    
    
    <tr>
        <th width="8%" rowspan="3" class="text-90deg-text" style="background-color:#747474">
            Partner Agency 
        </th>
        <td rowspan="2" style="background-color:#d1d1d1">3. BC Sakhi Operational & performance</td>
        <td style="background-color:#d1d1d1">3.1. Ave. no. working days/ month (Last 3 months)</td>
       
        <td style="background-color:#d1d1d1">
            <table style="width:100%">
                <tr>
                    <td width="80%">More than 25 days</td> 

                </tr> 
                <tr>
                    <td width="80%">16-25 days</td> 

                </tr>
                <tr>
                    <td width="80%">0-15 days</td> 

                </tr>
            </table>    
        </td>
        <td style="background-color:#d1d1d1">
            <table style="width:100%">
                <tr>
                    <td width="80%">10</td> 

                </tr> 
                <tr>
                    <td width="80%">5</td> 

                </tr>
                <tr>
                    <td width="80%">0</td> 

                </tr>
            </table>   
        </td>
        <td style="background-color:#d1d1d1">
            Weightage : <?=$model->partner_agency_avg_no_of_working_days?><br/>
            Rating : <?=$model->partner_agency_avg_no_of_working_days_rating?>
        </td>
    </tr>
    <tr style="background-color:#d1d1d1">
        
        <td style="background-color:#d1d1d1">3.2. Ave. no. of txn./ month (Last 3 months)</td>
       
        <td style="background-color:#d1d1d1">
            <table style="width:100%">
                <tr>
                    <td width="80%">More than 100 txn.</td> 

                </tr> 
                <tr>
                    <td width="80%">51 to 100 txn</td> 

                </tr>
                <tr>
                    <td width="80%">Less than 50 txn</td> 

                </tr>
            </table>    
        </td>
        <td style="background-color:#d1d1d1">
            <table style="width:100%">
                <tr>
                    <td width="80%">10</td> 

                </tr> 
                <tr>
                    <td width="80%">5</td> 

                </tr>
                 <tr>
                    <td width="80%">0</td> 

                </tr>
            </table>   
        </td>
        <td style="background-color:#d1d1d1">
            Weightage : <?=$model->partner_agency_avg_no_of_txn?><br/>
            Rating : <?=$model->partner_agency_avg_no_of_txn_rating?>
        </td>
    </tr>
      <tr height="10px"></tr>
     <tr>
        <th width="8%" rowspan="3" class="text-90deg-text" style="background-color:#f1a983">
            Partner Agency 
        </th>
        <td rowspan="2" style="background-color:#fae2d5">4. Operational stability of BC Sakhi</td>
        <td style="background-color:#fae2d5">4.1. Ave. commission earning/ month (Last 3 months)</td>
       
        <td style="background-color:#fae2d5">
            <table style="width:100%">
                <tr>
                    <td width="80%">More than Rs. 25k</td> 

                </tr> 
                <tr>
                    <td width="80%">Rs. 10k & Rs. 25k</td> 

                </tr>
                <tr>
                    <td width="80%">Less than Rs. 10k</td> 

                </tr>
            </table>    
        </td>
        <td style="background-color:#fae2d5">
            <table style="width:100%">
                <tr>
                    <td width="80%">50</td> 

                </tr> 
                <tr>
                    <td width="80%">25</td> 

                </tr>
                <tr>
                    <td width="80%">0</td> 

                </tr>
            </table>   
        </td>
        <td style="background-color:#fae2d5">
            Weightage : <?=$model->partner_agency_avg_com_earning?><br/>
            Rating : <?=$model->partner_agency_avg_com_earning_rating?>
        </td>
    </tr>
    <tr style="background-color:#fae2d5">
        
        <td style="background-color:#fae2d5">4.2. Repayment of BC Support fund (Last 6 months, not cumulative)</td>
       
        <td style="background-color:#fae2d5">
            <table style="width:100%">
                <tr>
                    <td width="80%">100% loan re-paid with interest</td> 

                </tr> 
                <tr>
                    <td width="80%">More than 50% of loan</td> 

                </tr>
                <tr>
                    <td width="80%">Between 25-50% of loan</td> 

                </tr>
                <tr>
                    <td width="80%">Less than 25% of loan</td> 

                </tr>
                <tr>
                    <td width="80%">Zero repayment</td> 

                </tr>
            </table>    
        </td>
        <td style="background-color:#fae2d5">
            <table style="width:100%">
                <tr>
                    <td width="80%">50</td> 

                </tr> 
                <tr>
                    <td width="80%">25</td> 

                </tr>
                 <tr>
                    <td width="80%">15</td> 

                </tr>
                <tr>
                    <td width="80%">10</td> 

                </tr>
                <tr>
                    <td width="80%">0</td> 

                </tr>
            </table>   
        </td>
        <td style="background-color:#fae2d5">
            Weightage : <?=$model->repayment_of_support_fund_per?><br/>
            Rating : <?=$model->repayment_of_support_fund_rating?>
        </td>
    </tr>
</table>
<?php

$css = <<<cs
      
 .text-90deg-text{
  /*transform: translateX(-10%) translateY(5%) rotate(-90deg);*/
}
.progress-bar{
font-size:18px
 }  
cs;
$this->registerCss($css);
?>        