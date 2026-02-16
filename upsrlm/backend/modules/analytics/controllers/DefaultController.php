<?php

namespace backend\modules\analytics\controllers;

use yii\web\Controller;
use atlasmobile\analytics\Analytics;
use backend\models\GoogleAnalyticsLog;
use backend\models\SiteReport;
use kartik\social\GoogleAnalytics;

/**
 * Default controller for the `analytics` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReport()
    {
        
        $model= new SiteReport();
        $last_week_date=date('Y-m-d', strtotime('-7 days'));
        $dateranges=array(
            "ga_visitor_count_till_date"          =>  array("startDate"=>"2019-11-01","endDate"=>"today"),
            "ga_visitor_count_till_yesterday"    =>  array("startDate"=>"2019-11-01","endDate"=>"yesterday"),
            "ga_visitor_count_till_last_one_week"     =>  array("startDate"=>"2019-11-01","endDate"=>$last_week_date),
            "ga_visitor_count_today"     =>  array("startDate"=>"today","endDate"=>"today"),
        );
       

        foreach($dateranges as $key => $daterange){
            $analytics = new Analytics();
            $analytics->startDate = $daterange['startDate'];
            $analytics->endDate = $daterange['endDate'];		
            $visitorsData = $analytics->getUsers();	
            $model->$key=$visitorsData;
        }
        $model->save();
        return $this->render('index');


        


    }

    public function actionLog()
    {
        
        $model= new GoogleAnalyticsLog();
        $analytics = new Analytics();
		$analytics->startDate = 'yesterday';
		$analytics->endDate = 'yesterday';
		
		$visitorsData = $analytics->getUsers();
		$pageViewsData = $analytics->getPageViews();
		
       
        $model->total_visitor_count_yesterday      =   $visitorsData;
        $model->total_page_view_count_yesterday    =   $pageViewsData;

        $model->date=date('Y-m-d', strtotime('-1 days'));
        $model->save(false);
        return $this->render('index');

    }
}
