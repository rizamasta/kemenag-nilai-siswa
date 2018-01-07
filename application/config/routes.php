<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route = array(
                /** default url */
                'default_controller' => "Dashboard/dashboard/index",
                'dashboard' => "Dashboard/dashboard/index",
                'getDataNotification' => "Dashboard/dashboard/getDataNotification",
                /** user start*/
                'user' => "User/index",
                'user/add' => "User/add",
                'user/edit/(:num)' => "User/edit/$1",
                'user/getUserJSON/(:num)' => "User/getUserJSON/$1",
                'user/getUserSetting' => "User/getUserSetting",
                'user/checkPassword' => "User/checkPassword",
                'user/saveSetting' => "User/saveSetting",
                /** user end*/

                /** nasabah start*/
                'member' => "Member/Member/index",
                'member/add' => "Member/Member/add",
                'member/edit/(:num)' => "Member/Member/edit/$1",
                'member/getMemberJSON/(:num)' => "Member/Member/getMemberJSON/$1",
                "member/getMemberAjax" => "Member/Member/getMemberAjax",
                "member/getHistory/(:num)" => "Member/Member/getHistory/$1",
                /** nasabah end*/

                /** data management start*/
                //manage siskamling start
                'manage' => "Manage/Siskamling/index",
                'manage/siskamling' => "Manage/Siskamling/index",
                'manage/siskamling/getSiskamlingAjax' => "Manage/Siskamling/getSiskamlingAjax",
                'manage/siskamling/getSiskamlingJSON/(:num)' => "Manage/Siskamling/getSiskamlingJSON/$1",
                //manage siskamling end
                //manage guardian start
                'manage/guardian' => "Manage/Guardian/index",
                'manage/guardian/getGuardianAjax' => "Manage/Guardian/getGuardianAjax",
                //manage guardian end
                //manage tourguard start
                'manage/tourguard' => "Manage/Tourguard/index",
                'manage/tourguard/getTourGuardAjax' => "Manage/Tourguard/getTourGuardAjax",
                //manage tourguard end
                //manage poi start
                'manage/poi' => "Manage/Poi/index",
                'manage/poi/add' => "Manage/Poi/add",
                'manage/poi/edit/(:num)' => "Manage/Poi/edit/$1",
                'manage/poi/getPoiAjax/(:num)' => "Manage/Poi/getPoiAjax/$1",
                'manage/poi/getPOI/(:num)' => "Manage/Poi/getPOI/$1",
                //manage poi end

                /** data management end*/

                /** analytic start **/
                'report' => "Report/Report/index",
                'report/all' => "Report/Report/index",
                'report/called' => "Report/Report/called",
                'report/waiting' => "Report/Report/waiting",
                'report/helped' => "Report/Report/helped",
                'report/update' => "Report/Report/updateStatus",
                'report/getAllAjax/(:num)' => "Report/Report/getAllAjax/$1",
                'report/getAllWaitingAjax/(:num)'=>"Report/Report/getAllWaitingAjax/$1",
                'report/getAllCallAjax/(:num)'=>"Report/Report/getAllCallAjax/$1",
                'report/getAllHelpedAjax/(:num)'=>"Report/Report/getAllHelpedAjax/$1",
                'report/getReportJSON/(:num)/(:any)'=>"Report/Report/getReportJSON/$1/$2",
                /** analytic end **/
                /** auth page start*/
                'login' => "Auth/Login",
                'auth' => "Auth/Login/auth",
                'logout' => "Auth/Login/logout",
                '404_override' => 'Custom/error_404',
                'translate_uri_dashes' => true,
                /** auth page end */

                /** start setting **/
                'termcondition' => "Setting/Termcondition/index",
                'termcondition/privacy' => "Setting/Termcondition/privacy",
                'termcondition/update/(:num)' => "Setting/Termcondition/update/$1",
                /** end setting */
            );
