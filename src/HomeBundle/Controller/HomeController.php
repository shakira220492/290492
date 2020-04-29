<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HomeBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    
    public function homeTestAction()
    {
        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();

        $originCity = 2;
        $destinyCity = 2;
        $package_maxAmount = 1;
        $xyz = 0;
        $sendata_routes = array();
        $sendata_routes_returned = array();
        $sendata_users = array();
            
        
//        $range = $this->identifyRange($originCity, $destinyCity);
        $query_order = $this->getQueryString($originCity, $destinyCity, $package_maxAmount);
        $sendata_routes_returned = $this->executeQuery_2(
            $db2, 
            $query_order, 
            $originCity, 
            $destinyCity, 
            $package_maxAmount, 
            $xyz, 
            $sendata_routes,
            $sendata_users);
//        echo $query_order;
//        echo '<br><br><br><br><br><br>lima';
//        
        
//        $xyz_1 = sizeof($sendata_routes_returned);
//        
//        for ($k = 0; $k < $xyz_1; $k++)
//        {            echo 'k';
//            for ($i = 0; $i < $package_maxAmount; $i++)
//            {                echo 'i';
//                echo $sendata_routes_returned[$k][$i]["package_id"];
//                echo $sendata_routes_returned[$k][$i]["package_id"];
//                echo $sendata_routes_returned[$k][$i]["packageOrigin_id"];
//                echo $sendata_routes_returned[$k][$i]["location_id_Origin"];
//                echo $sendata_routes_returned[$k][$i]["packageDestiny_id"];
//                echo $sendata_routes_returned[$k][$i]["location_id_Destiny"];
//                echo $sendata_routes_returned[$k][$i]["availableRoute_id"];
//                echo $sendata_routes_returned[$k][$i]["availableRoute_openedDate"];
//                echo $sendata_routes_returned[$k][$i]["availableRoute_closedDate"];
//                echo $sendata_routes_returned[$k][$i]["user_id"];
//                echo $sendata_routes_returned[$k][$i]["user_name"];
//                echo '<br>';
//            }
//        }
        
//        echo '<br><br><br><br><br><br>ambrossio';
    }
    
    
    function executeQuery_2(
        $db2, 
        $query_order, 
        $originCity, 
        $destinyCity, 
        $package_maxAmount, 
        $xyz, 
        $sendata_routes,
        $sendata_users)
    {            
        echo '<br> ////////////////////// executeQuery_2 function: '.$package_maxAmount."<br>";
        $query_order;
        $stmt2 = $db2->prepare($query_order);
        $params2 = array();
        $stmt2->execute($params2);

        $cursos2 = $stmt2->fetchAll();
        
        $routes_amount = 0;
        
        
        if ($xyz == 0)
        {
            $xyz = 0; // MAYBE IS THE SAME THAN $routes_amount = 0;
        } else
        {
            $xyz = sizeof($sendata_routes);
        }
        
        if ($package_maxAmount < 3)
        {
            echo 'package_maxAmount: '.$package_maxAmount.'<br>';
            if ($cursos2)
            {                echo 'THERE ARE POIUYT';
                foreach($cursos2 as $curso123) // routes_amount 
                {                    echo 'FIRST : FOREACH';
                    $j=1;
                    for ($i = 0; $i < $package_maxAmount; $i++)
                    {                        echo 'SECOND : FOR';
                        $package_id = $curso123["package_id_$j"];
                        
                        $sendata_routes[$xyz][$i] = array(
                            'package_id' => $curso123["package_id_$j"],
                            'packageOrigin_id' => $curso123["packageOrigin_id_$j"],
                            'location_id_Origin' => $curso123["location_id_Origin_$j"],
                            'packageDestiny_id' => $curso123["packageDestiny_id_$j"],
                            'location_id_Destiny' => $curso123["location_id_Destiny_$j"],
                            'availableRoute_id' => $curso123["availableRoute_id_$j"],
                            'availableRoute_openedDate' => $curso123["availableRoute_openedDate_$j"],
                            'availableRoute_closedDate' => $curso123["availableRoute_closedDate_$j"],
                            'user_id' => $curso123["user_id_$j"],
                            'user_name' => $curso123["user_name_$j"],
                            'routes_amount' => $routes_amount,
                            'packages_amount' => $package_maxAmount,
                            'x_position' => $xyz
                        );
                        
                        echo "package_id: " . $sendata_routes[$xyz][$i]["package_id"]."<br>";
                        echo "packageOrigin_id: " . $sendata_routes[$xyz][$i]["packageOrigin_id"]."<br>";
                        echo "location_id_Origin: " . $sendata_routes[$xyz][$i]["location_id_Origin"]."<br>";
                        echo "packageDestiny_id: " . $sendata_routes[$xyz][$i]["packageDestiny_id"]."<br>";
                        echo "location_id_Destiny: " . $sendata_routes[$xyz][$i]["location_id_Destiny"]."<br>";
                        echo "availableRoute_id: " . $sendata_routes[$xyz][$i]["availableRoute_id"]."<br>";
                        echo "availableRoute_openedDate: " . $sendata_routes[$xyz][$i]["availableRoute_openedDate"]."<br>";
                        echo "availableRoute_closedDate: " . $sendata_routes[$xyz][$i]["availableRoute_closedDate"]."<br>";
                        echo "user_id: " . $sendata_routes[$xyz][$i]["user_id"]."<br>";
                        echo "user_name: " . $sendata_routes[$xyz][$i]["user_name"]."<br>";
                        echo "routes_amount: " . $sendata_routes[$xyz][$i]["routes_amount"]."<br>";
                        echo "packages_amount: " . $sendata_routes[$xyz][$i]["packages_amount"]."<br>";
                        echo "x_position: " . $sendata_routes[$xyz][$i]["x_position"]."<br>";
                        echo '<br><br>___________________<br><br>';
                        $j++;
                    }
                    $xyz++;
                }
                
                $package_maxAmount++;
                $query_order = $this->getQueryString($originCity, $destinyCity, $package_maxAmount);
                $sendata_routes = $this->executeQuery_2(
                $db2, 
                $query_order, 
                $originCity, 
                $destinyCity, 
                $package_maxAmount, 
                $xyz,
                $sendata_routes,
                $sendata_users);
                
                return $sendata_routes;
            } else
            {
                echo 'ZXCVBNM';
//                $sendata_routes = array(
//                    array(
//                        'routes_amount_0' => 0,
//                        'package_amount_0' => 0
//                    )
//                );
                return $sendata_routes;
            }

        } else {
            echo 'QWERO';
            return $sendata_routes;
        }
    }
    
            
    function get_string_b_1($package_amount)
    {
        $string_b1 = "";
        $string_b1 .= 
        "SELECT DISTINCT 
            ";
        for ($j = 1; $j <= $package_amount; $j++)
        {
            $string_b1 .= 
            "
            package_id_$j,   
            packageOrigin_id_$j,   
            location_id_Origin_$j,   
            packageDestiny_id_$j,   
            location_id_Destiny_$j,  
            availableRoute_id_$j, 
            availableRoute_openedDate_$j, 
            availableRoute_closedDate_$j, 
            user_id_$j,  
            user_name_$j, 
            ";
        }
        
        return $string_b1;
                    
    }
    
    function get_string_b_2($package_amount)
    {
        $string_b1 = "";
        $string_b1 .= 
        "
            Package_$package_amount.package_id as package_id_$package_amount,   
            PackageOrigin_$package_amount.packageOrigin_id as packageOrigin_id_$package_amount,   
            LocationOrigin_$package_amount.location_id as location_id_Origin_$package_amount,   
            PackageDestiny_$package_amount.packageDestiny_id as packageDestiny_id_$package_amount,   
            LocationDestiny_$package_amount.location_id as location_id_Destiny_$package_amount,  
            AvailableRoute_$package_amount.availableRoute_id as availableRoute_id_$package_amount, 
            AvailableRoute_$package_amount.availableRoute_openedDate as availableRoute_openedDate_$package_amount, 
            AvailableRoute_$package_amount.availableRoute_closedDate as availableRoute_closedDate_$package_amount, 
            User_$package_amount.user_id as user_id_$package_amount,  
            User_$package_amount.user_name as user_name_$package_amount    
            FROM ( 
        ";

        return $string_b1;
    }
            
    function getQueryString($originLocation, $destinyLocation, $package_maxAmount)
    {
        $string_a = "";
        $string_b = "";
        $string_c = "";
        $string_f = "";

        if ($package_maxAmount == 1)
        {
            $string_b .= 
            "
                SELECT DISTINCT  
                    Package_1.package_id as package_id_1,   
                    PackageOrigin_1.packageOrigin_id as packageOrigin_id_1,   
                    LocationOrigin_1.location_id as location_id_Origin_1,   
                    PackageDestiny_1.packageDestiny_id as packageDestiny_id_1,   
                    LocationDestiny_1.location_id as location_id_Destiny_1,  
                    AvailableRoute_1.availableRoute_id as availableRoute_id_1, 
                    AvailableRoute_1.availableRoute_openedDate as availableRoute_openedDate_1, 
                    AvailableRoute_1.availableRoute_closedDate as availableRoute_closedDate_1, 
                    User_1.user_id as user_id_1,  
                    User_1.user_name as user_name_1    
                    FROM Location as LocationOrigin_1 
            ";
        }
            
        for ($i = 1; $i < $package_maxAmount; $i++)
        {
            $package_amount = $package_maxAmount - $i;
            $string_b .= $this->get_string_b_1($package_amount);
            $string_b .= $this->get_string_b_2($package_amount+1);

            if ($i == $package_maxAmount - 1)
            {
                $string_b .= 
                "
                    SELECT DISTINCT  
                        Package_1.package_id as package_id_1,   
                        PackageOrigin_1.packageOrigin_id as packageOrigin_id_1,   
                        LocationOrigin_1.location_id as location_id_Origin_1,   
                        PackageDestiny_1.packageDestiny_id as packageDestiny_id_1,   
                        LocationDestiny_1.location_id as location_id_Destiny_1,  
                        AvailableRoute_1.availableRoute_id as availableRoute_id_1, 
                        AvailableRoute_1.availableRoute_openedDate as availableRoute_openedDate_1, 
                        AvailableRoute_1.availableRoute_closedDate as availableRoute_closedDate_1, 
                        User_1.user_id as user_id_1,  
                        User_1.user_name as user_name_1    
                        FROM Location as LocationOrigin_1 
                ";
            }
        }
        
        for ($i = 1; $i <= $package_maxAmount; $i++)
        {
            if ($i == 1)
            {
                $string_a .= 
                "
                    INNER JOIN PackageOrigin as PackageOrigin_1 ON PackageOrigin_1.location_id = LocationOrigin_1.location_id 

                    INNER JOIN Package as Package_1 ON PackageOrigin_1.package_id = Package_1.package_id 

                    INNER JOIN PackageDestiny as PackageDestiny_1 ON PackageDestiny_1.package_id = Package_1.package_id 
                    INNER JOIN Location as LocationDestiny_1 ON PackageDestiny_1.location_id = LocationDestiny_1.location_id 
                    
                    INNER JOIN PackageMessenger as PackageMessenger_1 ON PackageMessenger_1.package_id = Package_1.package_id 
                    
                    INNER JOIN AvailableRoute as AvailableRoute_1 ON AvailableRoute_1.packageMessenger_id = PackageMessenger_1.packageMessenger_id 
                    INNER JOIN User as User_1 ON User_1.user_id = PackageMessenger_1.messenger_id 
                
                ";  
//                WHERE CityOrigin_1.city_id = '1' and CityDestiny_1.city_id = '1' 
            } else
            {
                $previous_value = $i - 1;
                $string_a .= 
                "
                ) Z_$i 
                    INNER JOIN Location as LocationOrigin_$i ON location_id_Destiny_$previous_value = LocationOrigin_$i.location_id 
                    INNER JOIN PackageOrigin as PackageOrigin_$i ON PackageOrigin_$i.location_id = LocationOrigin_$i.location_id 

                    INNER JOIN Package as Package_$i ON PackageOrigin_$i.package_id = Package_$i.package_id 

                    INNER JOIN PackageDestiny as PackageDestiny_$i ON PackageDestiny_$i.package_id = Package_$i.package_id 
                    INNER JOIN Location as LocationDestiny_$i ON PackageDestiny_$i.location_id = LocationDestiny_$i.location_id 
                        
                    INNER JOIN PackageMessenger as PackageMessenger_$i ON PackageMessenger_$i.package_id = Package_$i.package_id 
                
                    INNER JOIN AvailableRoute as AvailableRoute_$i ON AvailableRoute_$i.packageMessenger_id = PackageMessenger_$i.packageMessenger_id 
                    INNER JOIN User as User_$i ON User_$i.user_id = PackageMessenger_$i.messenger_id 
                
                ";
//                WHERE CityOrigin_$i.city_id = '1' and CityDestiny_$i.city_id = '1' 
                        
            }
            
        }
        
        for ($i = 1; $i <= $package_maxAmount; $i++)
        {
            
            if ($package_maxAmount === 1)
            {
                $next_value = 1;
                $origin = "LocationOrigin_$next_value.location_id";
                $destiny = "LocationDestiny_$i.location_id";
//                $origin = "location_id_Origin_$next_value";
//                $destiny = "location_id_Destiny_$i";
            } else if ($package_maxAmount > 1)
            {
                $next_value = $i + 1;
                $bucles_amount = $package_maxAmount - 1;
                if ($i === $bucles_amount)
                {
                    $origin = "LocationOrigin_$next_value.location_id";
                    $destiny = "location_id_Destiny_$i";
//                    $origin = "location_id_Origin_$next_value";
//                    $destiny = "location_id_Destiny_$i";
                } else if ($i < $bucles_amount)
                {
                    $origin = "location_id_Origin_$next_value";
                    $destiny = "location_id_Destiny_$i";
                }
            }
            
            if ($i == 1)
            {
                $string_c .= "
                    $origin = $destiny 
                ";
            }
            else if ($i == $package_maxAmount)
            {
                
            }
            else 
            {
                $string_c .= "
                    and $origin = $destiny 
                ";
            }
            
            if ($i == $package_maxAmount)
            {
                if ($package_maxAmount == 1)
                {
//                    $string_c .= "
//                        PackageOrigin_1.location_id = '$originLocation' 
//                        and PackageDestiny_$package_maxAmount.location_id = '$destinyLocation' 
//                    ";
                    $string_c .= "
                        and LocationOrigin_1.location_id = '$originLocation' 
                        and LocationDestiny_$package_maxAmount.location_id = '$destinyLocation' 
                    ";
//                    $string_c .= "
//                        location_id_Origin_1 = '$originLocation' 
//                        and location_id_Destiny_$package_maxAmount = '$destinyLocation' 
//                    ";
//                    $string_c .= "
//                        location_id_Origin_1 = '$originLocation' 
//                        and location_id_Destiny_$package_maxAmount = '$destinyLocation' 
//                    ";
                } else 
                {
//                    $string_c .= "
//                        PackageOrigin_1.location_id = '$originLocation' 
//                        and PackageDestiny_$package_maxAmount.location_id = '$destinyLocation' 
//                    ";
                    $string_c .= "
                        and location_id_Origin_1 = '$originLocation' 
                        and LocationDestiny_$package_maxAmount.location_id = '$destinyLocation' 
                    ";
//                    $string_c .= "
//                        location_id_Origin_1 = '$originLocation' 
//                        and location_id_Destiny_$package_maxAmount = '$destinyLocation' 
//                    ";
//                    $string_c .= "
//                        location_id_Origin_1 = '$originLocation' 
//                        and location_id_Destiny_$package_maxAmount = '$destinyLocation' 
//                    ";
                }
            }
            
            if ($i == $package_maxAmount)
            {
                $string_f .= "
                    package_id_$i 
                ";
            } else
            {
                $string_f .= "
                    package_id_$i, 
                ";
            }
            
        }        
        
        $query_order = 
            "
                $string_b
                $string_a
                
                WHERE 
                $string_c
                
                GROUP BY $string_f 
                ORDER BY $string_f DESC 
            ";

        return $query_order;
        
    }
    
    
    public function homeAction()
    {
        $id = 1;
        $taskEntity = new Task;
        
        $get_task_properties_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_task_properties_form');
        
        $check_session_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'check_session_form');
        
        $log_in_user_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'log_in_user_form');
        
        $log_out_user_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'log_out_user_form');
        
        $re_log_in_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 're_log_in_form');
        
        $get_stored_field_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_stored_field_form');
        $get_stored_layout_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_stored_layout_form');
        
        $set_this_field_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_this_field_form');
        $set_this_layout_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_this_layout_form');
        
        $delete_stored_field_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_stored_field_form');
        $delete_stored_layout_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_stored_layout_form');
        
        $update_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'update_form');
        $set_usualMode_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_usualMode_form');
        $set_currentMode_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_currentMode_form');
        
        $get_comment_about_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_comment_about_video_form');
        $get_comments_about_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_comments_about_video_form');
        $add_comment_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'add_comment_video_form');
        
        $set_cacheList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_cacheList_form');
        $get_cacheList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_cacheList_form');
        $set_cacheListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_cacheListVideo_form');
        $get_cacheListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_cacheListVideo_form');
                
        $set_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_specificList_form');
        $get_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_specificList_form');
        $set_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_specificListVideo_form');
        $get_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_specificListVideo_form');
        
        $delete_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_specificList_form');
        $delete_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_specificListVideo_form');
        $edit_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'edit_specificListVideo_form');
        $edit_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'edit_specificList_form');
        $increase_comments_amount_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'increase_comments_amount_video_form');
        
        $read_lyrics_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'read_lyrics_form');
        
        $get_closedCaption_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_closedCaption_form');
        
        $set_closedCaption_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_closedCaption_form');
        
        $delete_specific_closedCaption_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_specific_closedCaption_form');

        $upload_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'upload_video_form');
        
        $update_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'update_video_form');
        
        $upload_keyword_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'upload_keyword_form');
        
        $search_keyword_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'search_keyword_form');
        
        $get_artist_information_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_artist_information_form');
        
        $get_artist_list_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_artist_list_form');
                
        $store_current_keywords_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'store_current_keywords_form');
        $get_most_viewed_videos_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_most_viewed_videos_form');
        
                
        $get_history_songs_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_history_songs_form');
                
        $get_followers_profile_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_followers_profile_form');
                
        $get_following_profile_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_following_profile_form');
        
        $get_views_profile_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_views_profile_form');
        
        $get_video_list_profile_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_video_list_profile_form');
        
        $update_info_profile_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'update_info_profile_form');

        $edit_video_properties_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'edit_video_properties_form');

        $get_follower_information_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_follower_information_form');

        $sign_up_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'sign_up_form');
        
        $get_city_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_city_form');
        
        $get_country_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_country_form');
        
        $upload_profile_photo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'upload_profile_photo_form');
        
        $get_video_keywords_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_video_keywords_form');
        
        $delete_video_keywords_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_video_keywords_form');
        
        $save_video_keywords_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'save_video_keywords_form');
        
        $get_video_lyric_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_video_lyric_form');
        
        $get_lyric_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_lyric_form');
        
        $save_lyricsWord_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'save_lyricsWord_form');
        
        $delete_lyricsWord_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_lyricsWord_form');
        
        $edit_lyricsWord_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'edit_lyricsWord_form');
        
        $get_video_speed_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_video_speed_form');
        
        $set_video_speed_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_video_speed_form');
        
        $get_lyrics_frame_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_lyrics_frame_form');
        
        $increase_amount_views_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'increase_amount_views_form');
        
        $get_keywordUsers_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_keywordUsers_form');
        
        $get_videosPerKeywordUsers_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_videosPerKeywordUsers_form');
        
        $delete_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_video_form');
        
        $get_videos_to_delete_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_videos_to_delete_form');
        
        $decline_delete_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'decline_delete_video_form');
        
        $check_window_properties_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'check_window_properties_form');
        
        $get_window_properties_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_window_properties_form');
        
        $set_window_properties_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_window_properties_form');
        
        $store_windowVariables_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'store_windowVariables_form');
        
        $check_videos_to_delete_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'check_videos_to_delete_form');
        
        $store_history_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'store_history_form');
        
        $add_to_shopping_cart_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'add_to_shopping_cart_form');
        
        $delete_selected_product_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_selected_product_form');
        
        $get_selected_products_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_selected_products_form');
        
        $facebook_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'facebook_form');
        
        $google_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'google_form');
        
        $successLoginGoogle_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'successLoginGoogle_form');
        
        $get_karaoke_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_karaoke_form');
        
        $get_score_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_score_video_form');
        
        $set_score_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_score_video_form');
        
        $get_personal_score_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_personal_score_video_form');
        
        $set_personal_score_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_personal_score_video_form');
        
        $follow_artist_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'follow_artist_form');
        
        $upload_product_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'upload_product_form');
        
        $update_product_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'update_product_form');
        
        $upload_secondary_images_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'upload_secondary_images_form');
        
        $update_secondary_images_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'update_secondary_images_form');
        
        $get_current_list_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_current_list_form');
        
        $get_current_artist_information_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_current_artist_information_form');
        
        $get_current_artist_songs_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_current_artist_songs_form');
        
        $get_productType_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_productType_form');
        
        $get_stock_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_stock_form');
        
        $draw_images_about_stock_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'draw_images_about_stock_form');
        
        $insert_keywordProduct_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'insert_keywordProduct_form');
        
        $get_branch_city_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_branch_city_form');
        
        $get_branch_country_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_branch_country_form');
        
        $upload_branch_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'upload_branch_form');
        
        $get_branch_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_branch_form');
        
        $confirm_stockAmount_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'confirm_stockAmount_form');
        
        $confirm_stockPrice_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'confirm_stockPrice_form');
        
        $identify_keyword_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'identify_keyword_form');
        
        $get_product_details_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_product_details_form');
        
        $available_routes_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'available_routes_form');
        
        $video_data = $this->getVideoData($id);
                
//        return $this->render('@Artist/Default/updateCurrency.html.twig');
        

////        $todayDate = date("Y-m-d");
////        $nextMonthDate = strtotime('+30 day', strtotime($todayDate));
////        $nextMonthDate_v2 = date ("Y-m-d", $nextMonthDate);
////        $deleteRequestDate = date_create_from_format('Y-m-d', $nextMonthDate_v2);
//
//        
//        
//        

        
        
        
        
        
        
        return $this->render('@Home/home/home.html.twig', array(
            'get_task_properties_form_ajax' => $get_task_properties_form_ajax->createView(),
            'check_session_form_ajax' => $check_session_form_ajax->createView(),
            
            'log_in_user_form_ajax' => $log_in_user_form_ajax->createView(),
            'log_out_user_form_ajax' => $log_out_user_form_ajax->createView(),
            're_log_in_form_ajax' => $re_log_in_form_ajax->createView(),
            
            'get_stored_field_form_ajax' => $get_stored_field_form_ajax->createView(),
            'get_stored_layout_form_ajax' => $get_stored_layout_form_ajax->createView(),
            
            'set_this_field_form_ajax' => $set_this_field_form_ajax->createView(),
            'set_this_layout_form_ajax' => $set_this_layout_form_ajax->createView(),
            
            'delete_stored_field_form_ajax' => $delete_stored_field_form_ajax->createView(),
            'delete_stored_layout_form_ajax' => $delete_stored_layout_form_ajax->createView(),
            'update_form_ajax' => $update_form_ajax->createView(),
            'set_usualMode_form_ajax' => $set_usualMode_form_ajax->createView(),
            'set_currentMode_form_ajax' => $set_currentMode_form_ajax->createView(),
            
            'get_comment_about_video_form_ajax' => $get_comment_about_video_form_ajax->createView(),
            'get_comments_about_video_form_ajax' => $get_comments_about_video_form_ajax->createView(),
            'add_comment_video_form_ajax' => $add_comment_video_form_ajax->createView(),
            
            'set_cacheList_form_ajax' => $set_cacheList_form_ajax->createView(),
            'get_cacheList_form_ajax' => $get_cacheList_form_ajax->createView(),
            'set_cacheListVideo_form_ajax' => $set_cacheListVideo_form_ajax->createView(),
            'get_cacheListVideo_form_ajax' => $get_cacheListVideo_form_ajax->createView(),
            'set_specificList_form_ajax' => $set_specificList_form_ajax->createView(),
            'get_specificList_form_ajax' => $get_specificList_form_ajax->createView(),
            'set_specificListVideo_form_ajax' => $set_specificListVideo_form_ajax->createView(),
            'get_specificListVideo_form_ajax' => $get_specificListVideo_form_ajax->createView(),
            'delete_specificList_form_ajax' => $delete_specificList_form_ajax->createView(),
            'delete_specificListVideo_form_ajax' => $delete_specificListVideo_form_ajax->createView(),
            'edit_specificListVideo_form_ajax' => $edit_specificListVideo_form_ajax->createView(),
            'edit_specificList_form_ajax' => $edit_specificList_form_ajax->createView(),
            'increase_comments_amount_video_form_ajax' => $increase_comments_amount_video_form_ajax->createView(),
            'read_lyrics_form_ajax' => $read_lyrics_form_ajax->createView(),
            'get_closedCaption_form_ajax' => $get_closedCaption_form_ajax->createView(),
            'set_closedCaption_form_ajax' => $set_closedCaption_form_ajax->createView(),
            'delete_specific_closedCaption_form_ajax' => $delete_specific_closedCaption_form_ajax->createView(),
            'upload_video_form_ajax' => $upload_video_form_ajax->createView(),
            'update_video_form_ajax' => $update_video_form_ajax->createView(),
            'upload_keyword_form_ajax' => $upload_keyword_form_ajax->createView(),
            'search_keyword_form_ajax' => $search_keyword_form_ajax->createView(),
            'get_artist_information_form_ajax' => $get_artist_information_form_ajax->createView(),
            'get_artist_list_form_ajax' => $get_artist_list_form_ajax->createView(),
            'store_current_keywords_form_ajax' => $store_current_keywords_form_ajax->createView(),
            'get_most_viewed_videos_form_ajax' => $get_most_viewed_videos_form_ajax->createView(),
            'get_history_songs_form_ajax' => $get_history_songs_form_ajax->createView(),
            'get_followers_profile_form_ajax' => $get_followers_profile_form_ajax->createView(),
            'get_following_profile_form_ajax' => $get_following_profile_form_ajax->createView(),
            'get_views_profile_form_ajax' => $get_views_profile_form_ajax->createView(),
            'get_video_list_profile_form_ajax' => $get_video_list_profile_form_ajax->createView(),
            'update_info_profile_form_ajax' => $update_info_profile_form_ajax->createView(),
            'edit_video_properties_form_ajax' => $edit_video_properties_form_ajax->createView(),
            'get_follower_information_form_ajax' => $get_follower_information_form_ajax->createView(),
            'sign_up_form_ajax' => $sign_up_form_ajax->createView(),
            'get_city_form_ajax' => $get_city_form_ajax->createView(),
            'get_country_form_ajax' => $get_country_form_ajax->createView(),
            'upload_profile_photo_form_ajax' => $upload_profile_photo_form_ajax->createView(),
            'get_video_keywords_form_ajax' => $get_video_keywords_form_ajax->createView(),
            'delete_video_keywords_form_ajax' => $delete_video_keywords_form_ajax->createView(),
            'save_video_keywords_form_ajax' => $save_video_keywords_form_ajax->createView(),
            'get_video_lyric_form_ajax' => $get_video_lyric_form_ajax->createView(),
            'get_lyric_form_ajax' => $get_lyric_form_ajax->createView(),
            'save_lyricsWord_form_ajax' => $save_lyricsWord_form_ajax->createView(),
            'delete_lyricsWord_form_ajax' => $delete_lyricsWord_form_ajax->createView(),
            'edit_lyricsWord_form_ajax' => $edit_lyricsWord_form_ajax->createView(),
            'get_video_speed_form_ajax' => $get_video_speed_form_ajax->createView(),
            'set_video_speed_form_ajax' => $set_video_speed_form_ajax->createView(),
            'get_lyrics_frame_form_ajax' => $get_lyrics_frame_form_ajax->createView(),
            'increase_amount_views_form_ajax' => $increase_amount_views_form_ajax->createView(),
            'get_keywordUsers_form_ajax' => $get_keywordUsers_form_ajax->createView(),
            'get_videosPerKeywordUsers_form_ajax' => $get_videosPerKeywordUsers_form_ajax->createView(),
            'delete_video_form_ajax' => $delete_video_form_ajax->createView(),
            'get_videos_to_delete_form_ajax' => $get_videos_to_delete_form_ajax->createView(),
            'decline_delete_video_form_ajax' => $decline_delete_video_form_ajax->createView(),
            'check_window_properties_form_ajax' => $check_window_properties_form_ajax->createView(),
            'get_window_properties_form_ajax' => $get_window_properties_form_ajax->createView(),
            'set_window_properties_form_ajax' => $set_window_properties_form_ajax->createView(),
            'store_windowVariables_form_ajax' => $store_windowVariables_form_ajax->createView(),
            'check_videos_to_delete_form_ajax' => $check_videos_to_delete_form_ajax->createView(),
            'store_history_form_ajax' => $store_history_form_ajax->createView(),
            'add_to_shopping_cart_form_ajax' => $add_to_shopping_cart_form_ajax->createView(),
            'delete_selected_product_form_ajax' => $delete_selected_product_form_ajax->createView(),
            'get_selected_products_form_ajax' => $get_selected_products_form_ajax->createView(),
            'facebook_form_ajax' => $facebook_form_ajax->createView(),
            'google_form_ajax' => $google_form_ajax->createView(),
            'successLoginGoogle_form_ajax' => $successLoginGoogle_form_ajax->createView(),
            'get_karaoke_form_ajax' => $get_karaoke_form_ajax->createView(),
            'get_score_video_form_ajax' => $get_score_video_form_ajax->createView(),
            'set_score_video_form_ajax' => $set_score_video_form_ajax->createView(),
            'get_personal_score_video_form_ajax' => $get_personal_score_video_form_ajax->createView(),
            'set_personal_score_video_form_ajax' => $set_personal_score_video_form_ajax->createView(),
            'follow_artist_form_ajax' => $follow_artist_form_ajax->createView(),
            'upload_product_form_ajax' => $upload_product_form_ajax->createView(),
            'update_product_form_ajax' => $update_product_form_ajax->createView(),
            'upload_secondary_images_form_ajax' => $upload_secondary_images_form_ajax->createView(),
            'update_secondary_images_form_ajax' => $update_secondary_images_form_ajax->createView(),
            'get_current_list_form_ajax' => $get_current_list_form_ajax->createView(),
            'get_current_artist_information_form_ajax' => $get_current_artist_information_form_ajax->createView(),
            'get_current_artist_songs_form_ajax' => $get_current_artist_songs_form_ajax->createView(),
            'get_productType_form_ajax' => $get_productType_form_ajax->createView(),
            'get_stock_form_ajax' => $get_stock_form_ajax->createView(),
            'draw_images_about_stock_form_ajax' => $draw_images_about_stock_form_ajax->createView(),
            'insert_keywordProduct_form_ajax' => $insert_keywordProduct_form_ajax->createView(),
            'get_branch_city_form_ajax' => $get_branch_city_form_ajax->createView(),
            'get_branch_country_form_ajax' => $get_branch_country_form_ajax->createView(),
            'upload_branch_form_ajax' => $upload_branch_form_ajax->createView(),
            'get_branch_form_ajax' => $get_branch_form_ajax->createView(),
            'confirm_stockAmount_form_ajax' => $confirm_stockAmount_form_ajax->createView(),
            'confirm_stockPrice_form_ajax' => $confirm_stockPrice_form_ajax->createView(),
            'identify_keyword_form_ajax' => $identify_keyword_form_ajax->createView(),
            'get_product_details_form_ajax' => $get_product_details_form_ajax->createView(),
            'available_routes_form_ajax' => $available_routes_form_ajax->createView(),
        
            
            
            
            
            'video_data' => $video_data,
            
            'client_id' => 'ATg4hDECz7fnRBM6NDiao3TnTSRcYeS3yG8ApvKSiGZazIKyu6jW-AYxBXGTHb7TM4KFy53o8fkMeVQK',
            'secret' => 'EC9xlLF-x7BqWkWSYW9Ivtx35nBGcF-NZS1lgZJgXzVb9Q-1qP3-3a85bUmSvMU43x9wjANU4V7_9SF9',
            /**sdk configuration*/
            'settings' => array(
                'mode' => 'sandbox', /*available option 'sandbox' or 'live'*/
                'http.ConnectionTimeOut' => 30, /*specify the max request time in seconds*/
                'log.LogEnabled' => true, /*wheter want to log to a file*/
                /*'log.FileName' => storage_path().'logs/paypal.log',*/ /*specify the file that want to write on*/
                'log.LogLevel' => 'FINE' /*available option 'FINE', 'INFO', 'WARN', or 'ERROR' Logging is most verbose in the 'FINE' level and decreases as you proceed towards ERROR*/
            )
        ));
    }
 

    function getVideoData($id)
    {
        $em = $this->getDoctrine()->getManager();

        $video_query = $em->createQuery(
            "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, 
                v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
                v.videoAmountComments, v.videoScore, u.userId, u.userName 
                
                FROM HomeBundle:Video v
                
                JOIN HomeBundle:User u 
                WITH u.userId = v.user 
                
            WHERE v.videoId = '$id'"
        );

        $video_query_v = $video_query->getResult();

        if (isset($video_query_v[0]['videoId'])) {
            $videoUpdatedate = $video_query_v[0]['videoUpdatedate'];
            $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

            $videoAmountViews = $video_query_v[0]['videoAmountViews'];
            $videoAmountViewsFormat = number_format($videoAmountViews);

            $videoAmountComments = $video_query_v[0]['videoAmountComments'];
            $videoAmountCommentsFormat = number_format($videoAmountComments);
        
            $videoId_Value = $video_query_v[0]['videoId'];
            $videoName_Value = $video_query_v[0]['videoName'];
            $videoDescription_Value = $video_query_v[0]['videoDescription'];
            $videoImage_Value = $video_query_v[0]['videoImage'];
            $videoContent_Value = $video_query_v[0]['videoContent'];
            $videoUpdatedate_Value = $videoUpdatedateString;
            $videoAmountViews_Value = $videoAmountViewsFormat;
            $videoAmountComments_Value = $videoAmountCommentsFormat;
            $videoScore_Value = $video_query_v[0]['videoScore'];
            $userId_Value = $video_query_v[0]['userId'];
            $userName_Value = $video_query_v[0]['userName'];
        } else
        {
            $videoId_Value = "_";
            $videoName_Value = "_";
            $videoDescription_Value = "_";
            $videoImage_Value = "_";
            $videoContent_Value = "_";
            $videoUpdatedate_Value = "_";
            $videoAmountViews_Value = "_";
            $videoAmountComments_Value = "_";
            $videoScore_Value = "_";
            $userId_Value = "_";
            $userName_Value = "_";
        }
            
        $video_array = array(); // array que me almacena la cantidad de palabras
        $video_array[0] = $videoId_Value;
        $video_array[1] = $videoName_Value;
        $video_array[2] = $videoDescription_Value;
        $video_array[3] = $videoImage_Value;
        $video_array[4] = $videoContent_Value;
        $video_array[5] = $videoUpdatedate_Value;
        $video_array[6] = $videoAmountViews_Value;
        $video_array[7] = $videoAmountComments_Value;
        $video_array[8] = $videoScore_Value;
        $video_array[9] = $userId_Value;
        $video_array[10] = $userName_Value;
        
        return $video_array;
    }
    
    
    private function createCustomForm($objForm, $objEntity, $method, $route) {
        $form = $this->createForm($objForm, $objEntity, array(
            'action' => $this->generateUrl($route),
            'method' => $method
        ));
        return $form;
    }
}