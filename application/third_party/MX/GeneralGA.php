<?php

class GeneralGA {

    public function getListAnalytics($start = null) {
        $analytics = $this->getService();
        $profile = $this->getFirstProfileId($analytics);
        $results = $this->getResults($analytics, $profile,$start);
        $Device = !empty($results->getRows()) ? $results->getRows() : array();
        $getDevice = array();
        foreach ($Device as $key => $value) {
            $getDevice[$value[0]] = $value[1];
        }
        $data = array();
        $data['data'] = $results->getTotalsForAllResults();
        $data['device'] = $getDevice;
        return $data;
    }

     public function getListPerformanceAnalytics($start = null,$end = null) {
        $analytics = $this->getService();
        $profile = $this->getFirstProfileId($analytics);
        $results = $this->getResults($analytics, $profile,$start,$end);
        $trafic = $this->getResultsTrafic($analytics, $profile,$start,$end)->getRows();
        $traficSocial = $this->getResultsSocial($analytics, $profile,$start,$end)->getRows();

        $totalSocial = 0;
        $totalDirect = 0;
        $totalReferral = 0;
        $totalOrganic = 0;
        foreach ($trafic as $k=>$v):
           if($v[0] === '(direct)'):
               $totalDirect += $v[2];
           endif;
           if($v[1] === 'referral'):
               $totalReferral += $v[2];
           endif;
           if($v[1] === 'organic'):
               $totalOrganic += $v[2];
           endif;
        endforeach;
        foreach ($traficSocial as $k=>$v):
            $totalSocial +=$v[1];
        endforeach;
        $resultsUserType = $this->getResultsUserType($analytics, $profile,$start,$end)->getRows();
        $session = $this->getResultsSessionDuration($analytics, $profile,$start,$end);

        foreach ($resultsUserType as $key => $value) {
            $getOverview[$value[0]] = $value[1];
        }
        $datasession = $session->getRows();
        $session = 0;
        $pageViews = 0;
        $sum = 0;
        $data = array();
        $data['overview'] = $results->getTotalsForAllResults();
        $data['overview']['userType'] = $getOverview;
        $data['mediumsource'] = $trafic;
        $data['TraficSource']['totalSocial']=$totalSocial;
        $data['TraficSource']['totalDirect']=$totalDirect;
        $data['TraficSource']['totalRefferal']=$totalReferral;
        $data['TraficSource']['totalOrganic']=$totalOrganic;
        $data['demographic']['city'] = $this->getResultsCity($analytics, $profile,$start,$end)->getRows();
        $data['demographic']['totalCountry'] =0;
        $data['demographic']['totalCity'] = 0;



        return $data;
    }


    public function getListReportAnalyticsPageNews($channel = null, $start = null, $end = null) {
        $analytics = $this->getService();
        $profile = $this->getFirstProfileId($analytics);
        if (!empty($channel) && !empty($start) && !empty($end)) {
            $startX = date_create($start);
            $endX = date_create($end);
            $startDate = date_format($startX, 'Y-m-d');
            $endDate = date_format($endX, 'Y-m-d');
            $results = $this->getResultsPageNews($analytics, $profile, $channel, $startDate, $endDate);
        }elseif (!empty($start) && !empty($end)) {
            $startX = date_create($start);
            $endX = date_create($end);
            $startDate = date_format($startX, 'Y-m-d');
            $endDate = date_format($endX, 'Y-m-d');
            $results = $this->getResultsPageNews($analytics, $profile, null, $startDate, $endDate);
        }elseif (!empty($channel)) {
            $results = $this->getResultsPageNews($analytics, $profile, $channel);
        }  else {
            $results = $this->getResultsPageNews($analytics, $profile);
        }

        $Device = $results->getRows();
        return $Device;
    }

    public function getListReportAnalyticsPageStory($channel = null, $start = null, $end = null) {
        $analytics = $this->getService();
        $profile = $this->getFirstProfileId($analytics);
        if(!empty($channel) && !empty($start) && !empty($end)) {
            $startX = date_create($start);
            $endX = date_create($end);
            $startDate = date_format($startX, 'Y-m-d');
            $endDate = date_format($endX, 'Y-m-d');
            $results = $this->getResultsPageStory($analytics, $profile, $channel, $startDate, $endDate);
        }elseif(!empty($start) && !empty($end)) {
            $startX = date_create($start);
            $endX = date_create($end);
            $startDate = date_format($startX, 'Y-m-d');
            $endDate = date_format($endX, 'Y-m-d');
            $results = $this->getResultsPageStory($analytics, $profile, null, $startDate, $endDate);
        }elseif (!empty($channel)) {
            $results = $this->getResultsPageStory($analytics, $profile, $channel);
        }  else {
            $results = $this->getResultsPageStory($analytics, $profile);
        }
        $Device = $results->getRows();
        return $Device;
    }
    /**
     *
     * @param String $channel
     * @param Date $start
     * @param Date $end
     * @return Array Membuat sembuag
     */
    public function getListReportAnalyticsPageStreaming($channel = null, $start = null, $end = null) {
        $analytics = $this->getService();
        $profile = $this->getFirstProfileId($analytics);
        if (!empty($start) && !empty($end)) {
            $startX = date_create($start);
            $endX = date_create($end);
            $startDate = date_format($startX, 'Y-m-d');
            $endDate = date_format($endX, 'Y-m-d');
            $results = $this->getResultsPageLiveStreaming($analytics, $profile, null, $startDate, $endDate);
//            echo $startDate;
        } elseif (!empty($channel) && !empty($start) && !empty($end)) {
            $startX = date_create($start);
            $endX = date_create($end);
            $startDate = date_format($startX, 'Y-m-d');
            $endDate = date_format($endX, 'Y-m-d');
            $results = $this->getResultsPageLiveStreaming($analytics, $profile, $channel, $startDate, $endDate);
        }elseif (!empty($channel)) {
            $results = $this->getResultsPageLiveStreaming($analytics, $profile, $channel);
        }  else {
            $results = $this->getResultsPageLiveStreaming($analytics, $profile);
        }
        $Device = $results->getRows();
        return $Device;
    }

    public function getService() {
        // Creates and returns the Analytics service object.
        // Load the Google API PHP Client Library.
        require_once(APPPATH . 'libraries/Google/autoload.php');
        // Use the developers console and replace the values with your
        // service account email, and relative location of your key file.
        $service_account_email = GA_SERVICE_ACCOUNT_EMAIL;
        // $GAKey =
        $key_file_location = FCPATH . GA_PATH . GA_KEY_FILE;
        // $key_file_location = 'NETZID.P12';
        #$service_account_email = 'guest-876@net-portal-project.iam.gserviceaccount.com';
        #$key_file_location = 'NETZID-DEV.P12';
        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName(GA_PROJECT_NAME);


        $analytics = new Google_Service_Analytics($client);


        // Read the generated client_secrets.p12 key.
        $key = file_get_contents($key_file_location);
        $cred = new Google_Auth_AssertionCredentials(
                $service_account_email, array(Google_Service_Analytics::ANALYTICS_READONLY), $key
        );
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        return $analytics;
    }

    public function getFirstprofileId(&$analytics) {
        // Get the user's first view (profile) ID.
        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();
        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();
            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                    ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                        ->listManagementProfiles($firstAccountId, $firstPropertyId);
                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();
                } else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new Exception('No properties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }

    public function getResults(&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:deviceCategory');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions,ga:pageviews,ga:bounceRate,ga:avgSessionDuration,ga:users,ga:pageviewsPerSession,ga:uniquePageviews', $dimension
        );
    }


     public function getResultsUserType(&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:userType');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions', $dimension
        );
    }

    public function getResultsOS (&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:operatingSystem','max-results' => 10,'sort' => '-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions', $dimension
        );
    }
    public function getResultsBrowser (&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:browser','max-results' => 10,'sort' => '-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions', $dimension
        );
    }
    public function getResultsCountry (&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:country','max-results' => 10,'sort' => '-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions', $dimension
        );
    }
    public function getResultsCity (&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:city','max-results' => 10,'sort' => '-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions', $dimension
        );
    }
    public function getResultsSessionDuration (&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:sessionDurationBucket','max-results' => 10000,'sort'=>'-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions,ga:pageViews',$dimension
        );
    }

    public function getResultsSocial (&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:socialNetwork','sort'=>'-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions',$dimension
        );
    }
    public function getResultsTrafic(&$analytics, $profileId,$start = null,$end = null) {
        $date = !empty($start) ? $start : date('Y-m-01');
        $end  = !empty($end) ? $end : 'today';
        $dimension = array('dimensions' => 'ga:source,ga:medium','sort'=>'-ga:sessions');
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $date, $end, 'ga:sessions',$dimension
        );
    }
    public function getResultsPageNews(&$analytics, $profileId, $channel = null, $start = null, $end = null) {
        if (!empty($start) && !empty($end)) {
            $startDate = $start;
            $endDate = $end;
        } else {
            $startDate = date('Y-m-01');
            $endDate = 'today';
        }
        if (!empty($channel)) {
            $filters = 'ga:pagePath%3D@/news/;ga:pagePath%3D@/' . $channel;
            $dimension = array('dimensions' => 'ga:pagePath,ga:pageTitle', 'max-results' => 10, 'sort' => '-ga:pageviews', 'filters' => $filters);
        } else {
            $dimension = array('dimensions' => 'ga:pagePath,ga:pageTitle', 'max-results' => 10, 'sort' => '-ga:pageviews', 'filters' => 'ga:pagePath%3D@/news/');
        }
        $data = $analytics->data_ga->get(
                'ga:' . $profileId, $startDate, $endDate, 'ga:pageviews', $dimension
        );
        return $data;
    }

    public function getResultsPageStory(&$analytics, $profileId, $channel = null, $start = null, $end = null) {
        if (!empty($start) && !empty($end)) {
            $startDate = $start;
            $endDate = $end;
        } else {
            $startDate = date('Y-m-01');
            $endDate = 'today';
        }
        if (!empty($channel)) {
            $filters = 'ga:pagePath%3D@/story/;ga:pagePath%3D@/' . $channel;
            $dimension = array('dimensions' => 'ga:pagePath,ga:pageTitle', 'max-results' => 10, 'sort' => '-ga:pageviews', 'filters' => $filters);
        } else {
            $filters = 'ga:pagePath%3D@/story/';
            $dimension = array('dimensions' => 'ga:pagePath,ga:pageTitle', 'max-results' => 10, 'sort' => '-ga:pageviews', 'filters' => $filters);
        }
        $data = $analytics->data_ga->get(
                'ga:' . $profileId, $startDate, $endDate, 'ga:pageviews', $dimension
        );
        return $data;
    }

    public function getResultsPageLiveStreaming(&$analytics, $profileId,$chanel = null, $start = null, $end = null) {
        if (!empty($start) && !empty($end)) {
            $startDate = $start;
            $endDate = $end;
        } else {
            $startDate = date('Y-m-01');
            $endDate = 'today';
        }
        if (!empty($channel)) {
            $filters = 'ga:pagePath%3D@/streaming/;ga:pagePath%3D@/' . $channel;
            $dimension = array('dimensions' => 'ga:pagePath,ga:pageTitle', 'max-results' => 10, 'sort' => '-ga:pageviews', 'filters' => $filters);
        } else {
            $filters = 'ga:pagePath%3D@/streaming/';
            $dimension = array('dimensions' => 'ga:pagePath,ga:pageTitle', 'max-results' => 10, 'sort' => '-ga:pageviews', 'filters' => $filters);
        }
        $data = $analytics->data_ga->get(
                'ga:' . $profileId, $startDate, $endDate, 'ga:pageviews', $dimension
                );
        return $data;
    }

}
