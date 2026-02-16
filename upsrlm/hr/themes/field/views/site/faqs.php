<?php

use yii\jui\Accordion;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php echo $this->render('common'); ?>
<div class="page-header">

    <h4 class="blue">
        <i class="ace-icon fa fa-check bigger-110"></i>
        Frequently Asked Questions
    </h4>


</div>                 
<div class="row">   
    <?php
    echo Accordion::widget([
        'items' => [
            [
                'header' => 'How will Fieldata (FD) help me?',
                'content' => 'FD will help you monitor your projects; create reports using real-time data; share your reports with your donors and partners; and collaborate with other organizations working around you.',
            ],
            [
                'header' => 'What can I use FD for?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p> You can use FD to:</p>
                                       <ul>
						<li>
							<b>Monitor your projects</b>: Your field-staff can send in daily, weekly or monthly project-data with photographs, location (GPS), audio, etc.</li>
						<li>
							<b>Conduct surveys &amp; polls</b>: Your field-staff can carry out surveys, census and polls by interviewing your beneficiaries and local stakeholders</li>
						<li>
							<b>Manage administrative tasks</b>: Your field-staff can send in their expense-sheets, daily-tasks, etc.</li>
					</ul>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'What hardware do I need to use FD? Do I need GPRS (data-connectivity) on my mobile phones??',
                'headerOptions' => ['tag' => 'h3'],
                'content' => 'The FD website can be accessed by any internet enabled device.  The FD Mobile App works with Android devices (version 2.3 and above) -- mobile phones, tablets, netbooks.',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'What degree of customization does FD offer?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p>FD’s free-account offers standard modules and dashboards for creating reporting-questionnaires, managing field-staff contact information, collecting data, and generating reports.</p><p>New modules and features will be added as we go along and learn from you. If you have specific requirements / customizations, do write to us. Our technology team at Arthify Inc. can help you with that</p>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'Why should I share my data?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '	Sharing of data is required only for the free-accounts. We believe that by sharing your project data you will not only be showing to the world that you are a <b>transparent</b> and accountable organization, you will also be helping other organizations and individuals <b>learn from you</b>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'How secure is my data?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => 'FD uses encryption protocols to transfer data between the FD-Collect mobile app and the server.',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'Can I decide which information to keep private and which I want to share? Can my respondents’ personal information be kept hidden?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => 'Within each report-questionnaire, you will be able to “anonymize” (hide) data-fields that contain personal information. If you have a premium account, you can decide which data and reports to share or not share.',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'What will the data I collect and share be used for?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p> Only the organizational information and project data you share will be available for others to view and analyze. This data will be used by you and other organizations like yours for bettering their projects and services, and for activities like fund-raising.</p>
                                       <p>
						No personal information will be made accessible or used for any purpose on FD.
					</p>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'After registering, what ongoing support will I have access to?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p> Free account users will be able to access the Help Forum (coming soon), while paid-account subscribers will be able to receive email support within 24 hours during regular week days.</p>
                                       <p>
					Premium users, depending on their customized plans, will have access to phone and on-site support.
					</p>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'Will my activity status impact my visibility to donors?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p> Yes it will. FD is to help you show-case your activities to your donors. It is important for you to demonstrate your commitment in tracking and assessing your projects.
					</p>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'In case I leave my account idle for some time, will I be de-registered?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p> All accounts start off with a 3 year life-span. If your account is idle for 3 years, it will be de-registered. You can also de-register and delete all your data anytime.
					</p>',
                'options' => ['tag' => 'div'],
            ],
            [
                'header' => 'If I want to delete my account at any later stage, will my data-history be removed from the FD database?',
                'headerOptions' => ['tag' => 'h3'],
                'content' => '<p> Yes, you have full control on your data. You can delete it any stage, and it will be removed from FD’s database.
					</p>',
                'options' => ['tag' => 'div'],
            ],
        ],
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'headerOptions' => ['tag' => 'h3'],
        'clientOptions' => ['collapsible' => false],
    ]);
    ?>
</div>    
