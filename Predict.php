<?php

Yaf_Loader::import(APPLICATION_PATH."/extensions/predict/index.php");

class Mc_Predict
{
    static private function getBrowser($u_agent) 
    { 
        $bname = 'UnknownBrowser';
        $platform = 'UnknownPlatform';
        $version = "";

        //First get the platform?
        if (preg_match('/android/i', $u_agent)) {
            $platform = 'Android';
        }
        elseif (preg_match('/iphone/i', $u_agent)) {
            $platform = 'iPhone';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        elseif (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        }
        
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/LieBaoFast/i',$u_agent)) 
        { 
            $bname = 'LieBaoFast'; 
            $ub = "LieBaoFast"; 
        }
        elseif(preg_match('/LBBROWSER/i',$u_agent)) 
        { 
            $bname = 'LBBROWSER'; 
            $ub = "LBBROWSER"; 
        }
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        }
        elseif(preg_match('/OPR/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "OPR"; 
        }        
        elseif(preg_match('/MQQBrowser/i',$u_agent)) 
        { 
            $bname = 'QQMobileBrowser'; 
            $ub = "MQQBrowser"; 
        }
        elseif(preg_match('/QQBrowser/i',$u_agent)) 
        { 
            $bname = 'QQBrowser'; 
            $ub = "QQBrowser"; 
        }
        elseif(preg_match('/SogouMobileBrowser/i',$u_agent)) 
        { 
            $bname = 'SogouMobileBrowser'; 
            $ub = "SogouMobileBrowser"; 
        }
        elseif(preg_match('/SE/i',$u_agent) && preg_match('/MetaSr/i',$u_agent)) 
        { 
            $bname = 'SogouBrowser'; 
            $ub = "SE"; 
        }
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Firefox'; 
            $ub = "Firefox"; 
        }
        elseif(preg_match('/Maxthon/i',$u_agent)) 
        { 
            $bname = 'Maxthon'; 
            $ub = "Maxthon"; 
        }
        elseif(preg_match('/TheWorld/i',$u_agent)) 
        { 
            $bname = 'TheWorld'; 
            $ub = "TheWorld"; 
        }    
        elseif(preg_match('/TaoBrowser/i',$u_agent)) 
        { 
            $bname = 'TaobaoBrowser'; 
            $ub = "TaoBrowser"; 
        }        
        elseif(preg_match('/baidubrowser/i',$u_agent)) 
        { 
            $bname = 'baidubrowser'; 
            $ub = "baidubrowser"; 
        }
        elseif(preg_match('/BIDUBrowser/i',$u_agent)) 
        { 
            $bname = 'baidubrowser'; 
            $ub = "BIDUBrowser"; 
        }           
        elseif(preg_match('/UCBrowser/i',$u_agent)) 
        { 
            $bname = 'UCBrowser'; 
            $ub = "UCBrowser"; 
        }
        elseif(preg_match('/UBrowser/i',$u_agent)) 
        { 
            $bname = 'UCBrowser'; 
            $ub = "UBrowser"; 
        }
        elseif(preg_match('/QHBrowser/i',$u_agent)) 
        { 
            $bname = 'QHBrowser'; 
            $ub = "QHBrowser"; 
        }
        elseif(preg_match('/MXiOS/i',$u_agent)) 
        { 
            $bname = 'MXiOS'; 
            $ub = "MXiOS"; 
        }
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 
        elseif(preg_match('/weibo/i',$u_agent)) 
        { 
            $bname = 'weibo'; 
            $ub = "weibo"; 
        } 
        elseif(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)||preg_match('/CriOS/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        }
        else
        {
            $bname = 'unknown';
            $ub = 'unknown';
        }
        
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        
        // see how many we have
        $i = count($matches['browser']);
        if($bname == 'unknown' || $ub == 'unknown' || $i == 0)
        {
            $version="unknownVersion";
        }
        elseif ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][1];
            }
            else {
                $version= $matches['version'][0];
            }
        }
        else {
            $version= $matches['version'][0];
        }
        
        // check if we have a number
        if ($version==null || $version=="") {$version="unknownVersion";}
        
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
    
    static public function sort($user_info_arr,$spec_info_origin_arr)
    {    
        //when search result is empty, then spec array is NULL and instanceKeys is 0 => NULL
        if($spec_info_origin_arr == NULL)
        {
            $isK_null = array("0" => "NULL");
            return array($spec_info_origin_arr, $isK_null);
        }
        
        //get origin spec id for the case when don't use predict interface
        foreach($spec_info_origin_arr as $k => $v)
        {
            $sid[$k] = $spec_info_origin_arr[$k]['spec_id'];
        }
        
        $re = NULL;
        $s = NULL;
        //get a recommender, 如果接口失效，注释掉   
        $re = new Recommender('sina-miaoche');
        //implement a statistics request, 如果接口失效，注释掉
        $s = new Statistics('sina-miaoche');
        
        //如果接口失效
        if($re == NULL||$s == NULL)
        {
            $instKeys = array_fill(0,count($spec_info_origin_arr),'NULL');
            for ($i=0; $i<count($sid); $i++)
            {
                $indexchanged_instKeys[$sid[$i]] = $instKeys[$i];
            }
            return array($sid, $indexchanged_instKeys);
        }
        
        $request = Yaf_Dispatcher::getInstance()->getRequest();
        $params = $request->getQuery() + $request->getPost() + $request->getParams();
        ksort($params);
        foreach ($params as $k => $v) {
            if ($v === '') {
                unset($params[$k]);
                continue;
            }
            $params[$k] = trim($v);
        }
        
        $sort_url = isset($params["sort"]) ? $params["sort"] : "NULL";
        $asc_url = isset($params["asc"]) ? $params["asc"] : "NULL";
        if($sort_url == "NULL" && $asc_url == "NULL") 
            $sortRule = "price+1";
        else if($sort_url == "price")
        {
            if($asc_url == "NULL")
                $asc_url = "1";
            $sortRule = $sort_url."+".$asc_url;
        }
        else if($sort_url != "price")
        {
            if($asc_url == "NULL")
                $asc_url = "1";
            $sortRule = $sort_url."+".$asc_url;
        }
        else
        {
            $sortRule = $sort_url."+".$asc_url;
        }
            
        $p_url = isset($params["p"]) ? $params["p"] : "1";
        
        $featuresForPredict = array("min_price", "weight", "brand_id", "series_id", "spec_id", "deal_record", "discount", "msrp", "name");        
        $da = array();
        $specid_arr = array();//save spec id used as index when sort
        $sorted_auto_array = array();//save spec information after sort
        $sorted_auto_id = array();//save spec id after sort
        
        $spec_info_arr = $spec_info_origin_arr;  
       
        $instanceKeys = $re->getInstanceKeys(count($spec_info_arr));

        //change the index of instanceKeys for case not use predict interface and return sid
        $indexchanged_instanceKeys = array();
        for ($i=0; $i<count($sid); $i++)
        {
            $indexchanged_instanceKeys[$sid[$i]] = $instanceKeys[$i];
        }

        //add items
        foreach ($spec_info_arr as $k => $v)
        {     
            // construct a recommend feature object
            $ri = new RecommendFeature();

            $chajia = $spec_info_arr[$k]['msrp'] - $spec_info_arr[$k]['min_price'];
            $ri->addFeature("price_difference",(string)$chajia);            
            $ri->addFeature("rank","0");            
            $ri->addFeature("page",(string)$p_url);
            $ri->addFeature("brand_name",(string)$spec_info_arr[$k]['brand_name']['name']);
            $ri->addFeature("series_name",(string)$spec_info_arr[$k]['series_name']['name']);

            //add features to a spec instance //and add customInformation
            foreach ($v as $kk => $vv)
            {   
                if(in_array($kk,$featuresForPredict))
                {
                    $ri->addFeature((string)$kk,(string)$vv);//add feature
                }
            }
            //add an instance with defined features into recommender
            array_push($specid_arr,$spec_info_arr[$k]['spec_id']); 
            
            $re->addInstance((string)$instanceKeys[$k],$ri);
        }

        //construct request features
        //add user
        $ri = new RecommendFeature();   
        foreach ($user_info_arr as $k => $v)
        {
            if($k=='ip')
            {
                $ip_4 = explode('.',$v);
                $ip_3 = $ip_4[0].'.'.$ip_4[1].'.'.$ip_4[2];
                $ri->addFeature((string)$k,(string)$ip_3);
            }
            else if($k=='ua')
            {
                $ua = self::getBrowser($v);
                $ri->addFeature("Browser",(string)$ua['name']);
                $ri->addFeature("BrowserVersion",(string)$ua['version']);
                $ri->addFeature("platform",(string)$ua['platform']);
            }
            else
            {
                $ri->addFeature((string)$k,$v);
            }
        }
        $ri->addFeature("sort_rule",$sortRule);
        $ri->addFeature("flowType","pc_000");

        $re->setReqFeature($ri);

        //assign action type to be predicted
        $actionList = [0];

        //predict the instances
        $status = $re->predict($actionList);

        if ($status->getErrorCode() == ServiceCallStatus::ERR_OK
            || $status->getErrorCode() == ServiceCallStatus::ERR_PARTIAL_ERROR)
        {
            //fetch the result of each instance
            for ($i=0; $i<count($instanceKeys); $i++)
            {
                // if status is ok
                // fetch the result of 'instance_1'
                // or throw exception if instanceKey not found
                try {
                    $rr = $re->getResult($instanceKeys[$i]);

                    //get prediction of action type 0
                    $rp = $rr->getPrediction(0);
                    $status = $rp[0];
                    $value = $rp[1];

                    //save spec id as key, prediction result as value
                    $array_save[$specid_arr[$i]] = $value;
                    $array_instanceKeys_tosort[$specid_arr[$i]] = $instanceKeys[$i];
                    $array_spec_info[$specid_arr[$i]] = $spec_info_arr[$i];
                } catch(Exception $e) {
                    return array($sid, $indexchanged_instanceKeys);//如果失败，返回原spec_id
                }
            }
        }
        else
        {
            return array($sid, $indexchanged_instanceKeys);//如果失败，返回原spec_id
        }
        
        //stable sort
        $temp = array();
        $i = 0;
        foreach ($array_save as $key => $value) {
            $temp[] = array($i, $key, $value);
            $i++;
        }
        
        uasort($temp, function($a, $b) {
            return $a[2] == $b[2] ? ($a[0] > $b[0]) : ($a[2] < $b[2] ? 1 : -1);
        });
        
        $array_save = array();
        foreach ($temp as $val) {
            $array_save[$val[1]] = $val[2];
        }

        //get the spec id after sorted.
        $sorted_auto_id = array_keys($array_save);
        
        //get the instanceKeys after sorted.
        $sorted_instanceKeys = array();
        $sorted_spec_info_arr = array();
        foreach ($sorted_auto_id as $k => $v)
        {
            $sorted_instanceKeys[$v] = $array_instanceKeys_tosort[$v];
            $sorted_spec_info_arr[$k] = $array_spec_info[$v];
        }

        //show
        foreach ($sorted_spec_info_arr as $k => $v)
        {     
            // construct a display info object
            $d = new DisplayInfo();
            
            //set instanceKey
            $d->setInstanceKey((string)$sorted_instanceKeys[$sorted_spec_info_arr[$k]['spec_id']]);
            $d->addCustomInfo("rank",(string)$k);
            // make statistics display request
            array_push($da,$d);
        }
        $s->statDisplay($da);

        //return specid
        return array($sorted_auto_id, $sorted_instanceKeys);
    }
    
    //如果压力测试失败，注释掉\app\actions\Auto\Detail.php中的 $this->predict($spec_id);这一句话，大约在575行
    static public function statistic($userid_str,$specid_int)
    {        
        
        $request = Yaf_Dispatcher::getInstance()->getRequest();
        $params = $request->getQuery() + $request->getPost() + $request->getParams();
        ksort($params);
        foreach ($params as $k => $v) {
            if ($v === '') {
                unset($params[$k]);
                continue;
            }
            $params[$k] = trim($v);
        }
        
        $instanceKey = isset($params['ik'])?$params['ik']:"NULL";
        if($instanceKey == "NULL")
        {
            return;
        }
            
        $s = new Statistics('sina-miaoche');
        
        $actionValue = 1;
        $actionType = 0;        
        // make discrete statistics action request
        try{
            $s->statDiscreteAction($instanceKey, $actionValue, $actionType);
        } catch(Exception $e) {
            return;
        }
    }

}
?>
