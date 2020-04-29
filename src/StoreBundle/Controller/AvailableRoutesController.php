<?php

namespace StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class AvailableRoutesController extends Controller
{
    public $k = 0; 
    public $sendata_routes_size = 0;
    
    
    public function AvailableRoutesAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            
            ////////////////////////////////////
            
            $em2 = $this->getDoctrine()->getEntityManager();
            $db2 = $em2->getConnection();

            $originLocation = 2;
            $destinyLocation = 2;
            $package_maxAmount = 1;
            $xyz = 0;
            $callsToExecuteQuery_2 = 0;
            $sendata_routes = array();
            $sendata_users = array();

//                $sendata_routes[0][0]["package_id"] = 0;
//                $sendata_routes[0][0]["packageOrigin_id"] = 0;
//                $sendata_routes[0][0]["location_id_Origin"] = 0;
//                $sendata_routes[0][0]["packageDestiny_id"] = 0;
//                $sendata_routes[0][0]["location_id_Destiny"] = 0;
//                $sendata_routes[0][0]["availableRoute_id"] = 0;
//                $sendata_routes[0][0]["availableRoute_openedDate"] = 0;
//                $sendata_routes[0][0]["availableRoute_closedDate"] = 0;
//                $sendata_routes[0][0]["user_id"] = 0;
//                $sendata_routes[0][0]["user_name"] = 0;
//                $sendata_routes[0][0]["routes_amount"] = 0;
//                $sendata_routes[0][0]["packages_amount"] = 0;
//                $sendata_routes[0][0]["x_position"] = 0;

            $reachLocation = "local";
            $coverage = 2;
            
//            $this->identifyRange($originLocation, $destinyLocation);
            $query_order = $this->getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage);
            $sendata_routes = $this->executeQuery_2(
            $db2, 
            $query_order, 
            $originLocation, 
            $destinyLocation, 
            $package_maxAmount, 
            $xyz, 
            $callsToExecuteQuery_2, 
            $sendata_routes,
            $sendata_users);

                
//                $sendata_routes[0][0]["package_id"] = 6543;
//                $sendata_routes[0][0]["packageOrigin_id"] = 6543;
//                $sendata_routes[0][0]["location_id_Origin"] = 6543;
//                $sendata_routes[0][0]["packageDestiny_id"] = 6543;
//                $sendata_routes[0][0]["location_id_Destiny"] = 6543;
//                $sendata_routes[0][0]["availableRoute_id"] = 6543;
//                $sendata_routes[0][0]["availableRoute_openedDate"] = 6543;
//                $sendata_routes[0][0]["availableRoute_closedDate"] = 6543;
//                $sendata_routes[0][0]["user_id"] = 6543;
//                $sendata_routes[0][0]["user_name"] = 6543;
//                $sendata_routes[0][0]["routes_amount"] = 6543;
//                $sendata_routes[0][0]["packages_amount"] = 6543;
//                $sendata_routes[0][0]["x_position"] = 6543;

//                $sendata_routes[1][0]["package_id"] = 6543;
//                $sendata_routes[1][0]["packageOrigin_id"] = 6543;
//                $sendata_routes[1][0]["location_id_Origin"] = 6543;
//                $sendata_routes[1][0]["packageDestiny_id"] = 6543;
//                $sendata_routes[1][0]["location_id_Destiny"] = 6543;
//                $sendata_routes[1][0]["availableRoute_id"] = 6543;
//                $sendata_routes[1][0]["availableRoute_openedDate"] = 6543;
//                $sendata_routes[1][0]["availableRoute_closedDate"] = 6543;
//                $sendata_routes[1][0]["user_id"] = 6543;
//                $sendata_routes[1][0]["user_name"] = 6543;
//                $sendata_routes[1][0]["routes_amount"] = 6543;
//                $sendata_routes[1][0]["packages_amount"] = 6543;
//                $sendata_routes[1][0]["x_position"] = 6543;
//
//                $sendata_routes[2][0]["package_id"] = 1;
//                $sendata_routes[2][0]["packageOrigin_id"] = 1;
//                $sendata_routes[2][0]["location_id_Origin"] = 1;
//                $sendata_routes[2][0]["packageDestiny_id"] = 1;
//                $sendata_routes[2][0]["location_id_Destiny"] = 1;
//                $sendata_routes[2][0]["availableRoute_id"] = 1;
//                $sendata_routes[2][0]["availableRoute_openedDate"] = 1;
//                $sendata_routes[2][0]["availableRoute_closedDate"] = 1;
//                $sendata_routes[2][0]["user_id"] = 1;
//                $sendata_routes[2][0]["user_name"] = 1;
//                $sendata_routes[2][0]["routes_amount"] = 1;
//                $sendata_routes[2][0]["packages_amount"] = 1;
//                $sendata_routes[2][0]["x_position"] = 1;
            
            return new Response(
                json_encode($sendata_routes), 
                200, 
                array('Content-Type' => 'application/json'));
        }
        
    }
    
    
    function executeQuery_2(
        $db2, 
        $query_order, 
        $originLocation, 
        $destinyLocation, 
        $package_maxAmount, 
        $xyz, 
        $callsToExecuteQuery_2, 
        $sendata_routes,
        $sendata_users)
    {
            $stmt2 = $db2->prepare($query_order);
            $params2 = array();
            $stmt2->execute($params2);

            $cursos2 = $stmt2->fetchAll();
            
            if ($cursos2)
            {
                
                foreach($cursos2 as $curso123) // routes_amount 
                {
                    $j=1;
                    for ($i = 0; $i < $package_maxAmount; $i++)
                    {
                        $sendata_routes[$xyz][$i]["package_id"] = $curso123["package_id_$j"];
                        $sendata_routes[$xyz][$i]["packageOrigin_id"] = $curso123["packageOrigin_id_$j"];
                        $sendata_routes[$xyz][$i]["location_id_Origin"] = $curso123["location_id_Origin_$j"];
                        $sendata_routes[$xyz][$i]["packageDestiny_id"] = $curso123["packageDestiny_id_$j"];
                        $sendata_routes[$xyz][$i]["location_id_Destiny"] = $curso123["location_id_Destiny_$j"];
                        $sendata_routes[$xyz][$i]["availableRoute_id"] = $curso123["availableRoute_id_$j"];
                        $sendata_routes[$xyz][$i]["availableRoute_openedDate"] = $curso123["availableRoute_openedDate_$j"];
                        $sendata_routes[$xyz][$i]["availableRoute_closedDate"] = $curso123["availableRoute_closedDate_$j"];
                        $sendata_routes[$xyz][$i]["user_id"] = $curso123["user_id_$j"];
                        $sendata_routes[$xyz][$i]["user_name"] = $curso123["user_name_$j"];
                        $sendata_routes[0][0]["routes_amount"] = $xyz;
                        $sendata_routes[$xyz][$i]["packages_amount"] = $package_maxAmount;
                        $sendata_routes[$xyz][$i]["package_position"] = $i;
                        $sendata_routes[$xyz][$i]["route_position"] = $xyz;

//                    $sendata_routes[$xyz][$i]["package_id"] = "_.._";
//                    $sendata_routes[$xyz][$i]["packageOrigin_id"] = "_.._";
//                    $sendata_routes[$xyz][$i]["location_id_Origin"] = "_.._";
//                    $sendata_routes[$xyz][$i]["packageDestiny_id"] = "_.._";
//                    $sendata_routes[$xyz][$i]["location_id_Destiny"] = "_.._";
//                    $sendata_routes[$xyz][$i]["availableRoute_id"] = "_.._";
//                    $sendata_routes[$xyz][$i]["availableRoute_openedDate"] = "_.._";
//                    $sendata_routes[$xyz][$i]["availableRoute_closedDate"] = "_.._";
//                    $sendata_routes[$xyz][$i]["user_id"] = "_.._";
//                    $sendata_routes[$xyz][$i]["user_name"] = "_.._";
//                    $sendata_routes[0][0]["routes_amount"] = "_.._";
//                    $sendata_routes[$xyz][$i]["packages_amount"] = "_.._";
//                    $sendata_routes[$xyz][$i]["package_position"] = "_.._";
//                    $sendata_routes[$xyz][$i]["route_position"] = "_.._";
                        $j++;
                    }

                    $xyz++; // posición de ruta 0:(2), 1:(1), 2:(1,2), 3:(1,3,2), 4:(1,2,2), 5:(1,1,3,4) 
                }
    
            }

            if($package_maxAmount < 4)
            {
                $package_maxAmount++;
            }

            
            
            
        if ($callsToExecuteQuery_2 < $package_maxAmount)
        {
            $callsToExecuteQuery_2++;

            $reachLocation = "local";
            $coverage = 2;
            $query_order = $this->getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage);
            $sendata_routes = $this->executeQuery_2(
            $db2, 
            $query_order, 
            $originLocation, 
            $destinyLocation, 
            $package_maxAmount, 
            $xyz, 
            $callsToExecuteQuery_2, 
            $sendata_routes,
            $sendata_users);
        }
        
        return $sendata_routes;
    }
    
            
    function getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage)
    {
        $string_a = "";
        $string_b = "";
        $string_c = "";
        $string_d = "";
        $string_e = "";
        $string_f = "";
        $string_b_1 = "";
        $string_b_2 = "";
        
        if ($reachLocation === "international")
        {
            $string_b_1 .= 
            "

            ";

            $string_b_2 .= 
            "

            ";
        } else if ($reachLocation === "national")
        {
            $string_b_1 .= 
            "
                CityOrigin_1.city_id as city_idOrigin_1, 
                DepartmentOrigin_1.department_id as department_idOrigin_1, 
                CountryOrigin_1.country_id as country_idOrigin_1, 
            ";

            $string_b_2 .= 
            "
                CityDestiny_1.city_id as city_idDestiny_1, 
                DepartmentDestiny_1.department_id as department_idDestiny_1, 
                CountryDestiny_1.country_id as country_idDestiny_1, 
            ";
        } else if ($reachLocation === "departamental")
        {
            $string_b_1 .= 
            "
                CityOrigin_1.city_id as city_idOrigin_1, 
                DepartmentOrigin_1.department_id as department_idOrigin_1, 
            ";

            $string_b_2 .= 
            "
                CityDestiny_1.city_id as city_idDestiny_1, 
                DepartmentDestiny_1.department_id as department_idDestiny_1, 
            ";
        } else if ($reachLocation === "local")
        {
            $string_b_1 .= 
            "
                CityOrigin_1.city_id as city_idOrigin_1, 
            ";

            $string_b_2 .= 
            "
                CityDestiny_1.city_id as city_idDestiny_1, 
            ";
        }
                
        if ($package_maxAmount == 1)
        {
            $string_b .= 
            "
                SELECT DISTINCT  
                    Package_1.package_id as package_id_1,   
                    Package_1.package_reachLocation as package_reachLocation_1, 
                    PackageOrigin_1.packageOrigin_id as packageOrigin_id_1,   
                    LocationOrigin_1.location_id as location_id_Origin_1,   
                    $string_b_1 

                    PackageDestiny_1.packageDestiny_id as packageDestiny_id_1,   
                    LocationDestiny_1.location_id as location_id_Destiny_1, 
                    $string_b_2 

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
            $string_b .= $this->get_string_b_1($package_amount, $reachLocation);
            $string_b .= $this->get_string_b_2($package_amount+1, $reachLocation);

            if ($i == $package_maxAmount - 1)
            {
                $string_b .= 
                "
                    SELECT DISTINCT  
                        Package_1.package_id as package_id_1,   
                        Package_1.package_reachLocation as package_reachLocation_1, 
                        PackageOrigin_1.packageOrigin_id as packageOrigin_id_1,   
                        LocationOrigin_1.location_id as location_id_Origin_1,   
                        $string_b_1 
                            
                        PackageDestiny_1.packageDestiny_id as packageDestiny_id_1,   
                        LocationDestiny_1.location_id as location_id_Destiny_1,  
                        $string_b_2 

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
                

                
                if ($reachLocation === "international")
                {
                    
                } else if ($reachLocation === "national")
                {
                    $string_a .= 
                    "
    INNER JOIN City as CityDestiny_1 ON CityDestiny_1.city_id = LocationDestiny_1.city_id 
    INNER JOIN Department as DepartmentDestiny_1 ON DepartmentDestiny_1.department_id = CityDestiny_1.department_id 
    INNER JOIN Country as CountryDestiny_1 ON CountryDestiny_1.country_id = DepartmentDestiny_1.country_id 
                        

    INNER JOIN City as CityOrigin_1 ON CityOrigin_1.city_id = LocationOrigin_1.city_id 
    INNER JOIN Department as DepartmentOrigin_1 ON DepartmentOrigin_1.department_id = CityOrigin_1.department_id 
    INNER JOIN Country as CountryOrigin_1 ON CountryOrigin_1.country_id = DepartmentOrigin_1.country_id 
                    ";  
                } else if ($reachLocation === "departamental")
                {
                    $string_a .= 
                    "
    INNER JOIN City as CityDestiny_1 ON CityDestiny_1.city_id = LocationDestiny_1.city_id 
    INNER JOIN Department as DepartmentDestiny_1 ON DepartmentDestiny_1.department_id = CityDestiny_1.department_id 
                        

    INNER JOIN City as CityOrigin_1 ON CityOrigin_1.city_id = LocationOrigin_1.city_id 
    INNER JOIN Department as DepartmentOrigin_1 ON DepartmentOrigin_1.department_id = CityOrigin_1.department_id 
                    ";  
                } else if ($reachLocation === "local")
                {
                    $string_a .= 
                    "
    INNER JOIN City as CityDestiny_1 ON CityDestiny_1.city_id = LocationDestiny_1.city_id 

    INNER JOIN City as CityOrigin_1 ON CityOrigin_1.city_id = LocationOrigin_1.city_id 
                    ";  
                }
                
                
                

//            $reachLocation_1 = 
//            "
//                INNER JOIN City as City_1 ON City_1.city_id = LocationDestiny_1.city_id 
//                and City_1.city_id = LocationOrigin_1.city_id 
//                
//                INNER JOIN City as City_1 ON City_1.city_id = LocationDestiny_1.city_id 
//                and City_1.city_id = LocationOrigin_1.city_id 
//                INNER JOIN Department as Department_1 ON Department_1.department_id = City_1.department_id 
//
//                INNER JOIN City as City_1 ON City_1.city_id = LocationDestiny_1.city_id 
//                and City_1.city_id = LocationOrigin_1.city_id 
//                INNER JOIN Department as Department_1 ON Department_1.department_id = City_1.department_id 
//                INNER JOIN Country as Country_1 ON Country_1.country_id = Department_1.country_id 
//            ";
//            
//            $reachLocation_2 = 
//            "
//                department.country_id = $originCountry 
//                city.department_id = $originDepartment 
//                location.city_id = $originCity 
//            ";
            
                
                
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
                
                if ($reachLocation === "international")
                {
                    
                } else if ($reachLocation === "national")
                {
                    $string_a .= 
                    "
    INNER JOIN City as CityDestiny_$i ON CityDestiny_$i.city_id = LocationDestiny_$i.city_id 
    INNER JOIN Department as DepartmentDestiny_$i ON DepartmentDestiny_$i.department_id = CityDestiny_$i.department_id 
    INNER JOIN Country as CountryDestiny_$i ON CountryDestiny_$i.country_id = DepartmentDestiny_$i.country_id 
                        

    INNER JOIN City as CityOrigin_$i ON CityOrigin_$i.city_id = LocationOrigin_$i.city_id 
    INNER JOIN Department as DepartmentOrigin_$i ON DepartmentOrigin_$i.department_id = CityOrigin_$i.department_id 
    INNER JOIN Country as CountryOrigin_$i ON CountryOrigin_$i.country_id = DepartmentOrigin_$i.country_id 
                    ";  
                } else if ($reachLocation === "departamental")
                {
                    $string_a .= 
                    "
    INNER JOIN City as CityDestiny_$i ON CityDestiny_$i.city_id = LocationDestiny_$i.city_id 
    INNER JOIN Department as DepartmentDestiny_$i ON DepartmentDestiny_$i.department_id = CityDestiny_$i.department_id 
                        

    INNER JOIN City as CityOrigin_$i ON CityOrigin_$i.city_id = LocationOrigin_$i.city_id 
    INNER JOIN Department as DepartmentOrigin_$i ON DepartmentOrigin_$i.department_id = CityOrigin_$i.department_id 
                    ";  
                } else if ($reachLocation === "local")
                {
                    $string_a .= 
                    "
    INNER JOIN City as CityDestiny_$i ON CityDestiny_$i.city_id = LocationDestiny_$i.city_id 

    INNER JOIN City as CityOrigin_$i ON CityOrigin_$i.city_id = LocationOrigin_$i.city_id 
                    ";  
                }
                
                
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
        
        for ($i = 1; $i <= $package_maxAmount; $i++)
        {
            if ($i == $package_maxAmount)
            {

                if ($reachLocation === "international")
                {
                    $string_d .= "";
                } else if ($reachLocation === "national")
                {
                    $string_d .= 
                    "
                        CountryOrigin_$i.country_id = $coverage and
                        CountryDestiny_$i.country_id = $coverage 
                    ";
                } else if ($reachLocation === "departamental")
                {
                    $string_d .= 
                    "
                        DepartmentOrigin_$i.department_id = $coverage and 
                        DepartmentDestiny_$i.department_id = $coverage 
                    ";
                } else if ($reachLocation === "local")
                {    
                    $string_d .= 
                    "
                        CityOrigin_$i.city_id = $coverage and 
                        CityDestiny_$i.city_id = $coverage 
                    ";
                }

            } else
            {

                if ($reachLocation === "international")
                {
                    $string_d .= "";
                } else if ($reachLocation === "national")
                {
                    $string_d .= 
                    "
                        country_idOrigin_$i = $coverage and 
                        country_idDestiny_$i = $coverage and 
                    ";
                } else if ($reachLocation === "departamental")
                {
                    $string_d .= 
                    "
                        department_idOrigin_$i = $coverage and 
                        department_idDestiny_$i = $coverage and 
                    ";
                } else if ($reachLocation === "local")
                {    
                    $string_d .= 
                    "
                        city_idOrigin_$i = $coverage and 
                        city_idDestiny_$i = $coverage and 
                    ";
                }

            }
        }
                    
                    
                  
        
        
        
        
        
        
        
        for ($i = 1; $i <= $package_maxAmount; $i++)
        {
            if ($i == $package_maxAmount)
            {
                $string_e .= "
                    Package_$i.package_reachLocation = '$coverage' 
                ";
            } else
            {
                $string_e .= "
                    package_reachLocation_$i = '$coverage' and 
                ";
            }
        }
        
        
        
        
        $query_order = 
            "
                $string_b
                $string_a

                WHERE 
                $string_c
                and
                $string_d
                and
                $string_e
                    
                    
                
                GROUP BY $string_f 
                ORDER BY $string_f DESC 
            ";

        return $query_order;
        
    }
            
    function get_string_b_1($package_amount, $reachLocation)
    {
        $string_b1 = "";
        $string_b1 .= 
        "SELECT DISTINCT 
            ";
        for ($j = 1; $j <= $package_amount; $j++)
        {
            $string_b_1 = "";
            $string_b_2 = "";

            if ($reachLocation === "international")
            {
                $string_b_1 .= 
                "

                ";

                $string_b_2 .= 
                "

                ";
            } else if ($reachLocation === "national")
            {
                $string_b_1 .= 
                "
                    city_idOrigin_$j, 
                    department_idOrigin_$j, 
                    country_idOrigin_$j, 
                ";

                $string_b_2 .= 
                "
                    city_idDestiny_$j, 
                    department_idDestiny_$j, 
                    country_idDestiny_$j, 
                ";
            } else if ($reachLocation === "departamental")
            {
                $string_b_1 .= 
                "
                    city_idOrigin_$j, 
                    department_idOrigin_$j, 
                ";

                $string_b_2 .= 
                "
                    city_idDestiny_$j, 
                    department_idDestiny_$j, 
                ";
            } else if ($reachLocation === "local")
            {
                $string_b_1 .= 
                "
                    city_idOrigin_$j, 
                ";

                $string_b_2 .= 
                "
                    city_idDestiny_$j, 
                ";
            }
        
            $string_b1 .= 
            "
            package_id_$j, 
            package_reachLocation_$j, 
            packageOrigin_id_$j, 
            location_id_Origin_$j, 
            $string_b_1

            packageDestiny_id_$j,   
            location_id_Destiny_$j, 
            $string_b_2
                
            availableRoute_id_$j, 
            availableRoute_openedDate_$j, 
            availableRoute_closedDate_$j, 
            user_id_$j,  
            user_name_$j, 

            ";
        }
        
        return $string_b1;
                    
    }
    
    function get_string_b_2($package_amount, $reachLocation)
    {

        $string_b_1 = "";
        $string_b_2 = "";

        if ($reachLocation === "international")
        {
            $string_b_1 .= 
            "

            ";

            $string_b_2 .= 
            "

            ";
        } else if ($reachLocation === "national")
        {
            $string_b_1 .= 
            "
                CityOrigin_$package_amount.city_id as city_idOrigin_$package_amount, 
                DepartmentOrigin_$package_amount.department_id as department_idOrigin_$package_amount, 
                CountryOrigin_$package_amount.country_id as country_idOrigin_$package_amount, 
            ";

            $string_b_2 .= 
            "
                CityDestiny_$package_amount.city_id as city_idDestiny_$package_amount, 
                DepartmentDestiny_$package_amount.department_id as department_idDestiny_$package_amount, 
                CountryDestiny_$package_amount.country_id as country_idDestiny_$package_amount, 
            ";
        } else if ($reachLocation === "departamental")
        {
            $string_b_1 .= 
            "
                CityOrigin_$package_amount.city_id as city_idOrigin_$package_amount, 
                DepartmentOrigin_$package_amount.department_id as department_idOrigin_$package_amount, 
            ";

            $string_b_2 .= 
            "
                CityDestiny_$package_amount.city_id as city_idDestiny_$package_amount, 
                DepartmentDestiny_$package_amount.department_id as department_idDestiny_$package_amount, 
            ";
        } else if ($reachLocation === "local")
        {
            $string_b_1 .= 
            "
                CityOrigin_$package_amount.city_id as city_idOrigin_$package_amount, 
            ";

            $string_b_2 .= 
            "
                CityDestiny_$package_amount.city_id as city_idDestiny_$package_amount, 
            ";
        }

        $string_b1 = "";
        $string_b1 .= 
        "
            Package_$package_amount.package_id as package_id_$package_amount,   
            Package_$package_amount.package_reachLocation as package_reachLocation_$package_amount,  
            PackageOrigin_$package_amount.packageOrigin_id as packageOrigin_id_$package_amount,   
            LocationOrigin_$package_amount.location_id as location_id_Origin_$package_amount,   
            $string_b_1

            PackageDestiny_$package_amount.packageDestiny_id as packageDestiny_id_$package_amount,   
            LocationDestiny_$package_amount.location_id as location_id_Destiny_$package_amount,  
            $string_b_2

            AvailableRoute_$package_amount.availableRoute_id as availableRoute_id_$package_amount, 
            AvailableRoute_$package_amount.availableRoute_openedDate as availableRoute_openedDate_$package_amount, 
            AvailableRoute_$package_amount.availableRoute_closedDate as availableRoute_closedDate_$package_amount, 
            User_$package_amount.user_id as user_id_$package_amount,  
            User_$package_amount.user_name as user_name_$package_amount    
            FROM ( 
        ";

        return $string_b1;
    }
    
    function identifyRange($originLocation, $destinyLocation)
    {
        $originCity = $this->getOriginCity($originLocation);
        $destinyCity = $this->getDestinyCity($destinyLocation);
        $originDepartment = $this->getOriginDepartment($originCity);
        $destinyDepartment = $this->getDestinyDepartment($destinyCity);
        $originCountry = $this->getOriginCountry($originDepartment);
        $destinyCountry = $this->getDestinyCountry($destinyDepartment);
        
        if($originCity == $destinyCity)
        {
//            echo 'l';
            $location_position = 0;
            $location_array[$location_position] = array();
            $location_parent = 0;
            $location_name = "la humildad segundo sector";
                    
            $this->getLocalRoute($originCity, $location_position, $location_array, $location_parent, $location_name);
            
            $reachLocation = "local";
            $coverage = 2;
            $query_order = $this->getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage);
            $sendata_routes = $this->executeQuery_2(
                $db2, 
                $query_order, 
                $originLocation, 
                $destinyLocation, 
                $package_maxAmount, 
                $xyz, 
                $callsToExecuteQuery_2, 
                $sendata_routes,
                $sendata_users);   
        } else if($originDepartment == $destinyDepartment)
        {
            $reachLocation = "departamental";
            $coverage = 2;
            $query_order = $this->getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage);
            $sendata_routes = $this->executeQuery_2(
                $db2, 
                $query_order, 
                $originLocation, 
                $destinyLocation, 
                $package_maxAmount, 
                $xyz, 
                $callsToExecuteQuery_2, 
                $sendata_routes,
                $sendata_users);   
        } else if($originCountry == $destinyCountry)
        {
            $reachLocation = "national";
            $coverage = 2;
            $query_order = $this->getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage);
            $sendata_routes = $this->executeQuery_2(
                $db2, 
                $query_order, 
                $originLocation, 
                $destinyLocation, 
                $package_maxAmount, 
                $xyz, 
                $callsToExecuteQuery_2, 
                $sendata_routes,
                $sendata_users);   
        } else 
        {
            $reachLocation = "international";
            $coverage = 2;
            $query_order = $this->getQueryString($originLocation, $destinyLocation, $package_maxAmount, $reachLocation, $coverage);
            $sendata_routes = $this->executeQuery_2(
                $db2, 
                $query_order, 
                $originLocation, 
                $destinyLocation, 
                $package_maxAmount, 
                $xyz, 
                $callsToExecuteQuery_2, 
                $sendata_routes,
                $sendata_users);   
        }
    }
    
    function getOriginCity($originLocation)
    {
        $originCity_string = "";
        $originCity_string .= 
        "
            SELECT DISTINCT 
                city_id 
                FROM location 
                WHERE location_id = $originLocation 
        ";

        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($originCity_string);
        $params2 = array();
        $stmt2->execute($params2);
        $cursos2 = $stmt2->fetchAll();        
        
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) 
            {
                $originCity = $curso123["city_id"];
            }
        }
        return $originCity;
    }

    function getDestinyCity($destinyLocation)
    {
        $destinyCity_string = "";
        $destinyCity_string .= 
        "
            SELECT DISTINCT 
                city_id 
                FROM location 
                WHERE location_id = $destinyLocation 
        ";

        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($destinyCity_string);
        $params2 = array();
        $stmt2->execute($params2);
        $cursos2 = $stmt2->fetchAll();        
        
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) 
            {
                $destinyCity = $curso123["city_id"];
            }
        }
        return $destinyCity;
    }

    function getOriginDepartment($originCity)
    {
        $originDepartment_string = "";
        $originDepartment_string .= 
        "
            SELECT DISTINCT 
                department_id 
                FROM city 
                WHERE city_id = $originCity 
        ";

        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($originDepartment_string);
        $params2 = array();
        $stmt2->execute($params2);
        $cursos2 = $stmt2->fetchAll();        
        
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) 
            {
                $originDepartment = $curso123["department_id"];
            }
        }
        return $originDepartment;
    }
    
    function getDestinyDepartment($destinyCity)
    {
        $destinyDepartment_string = "";
        $destinyDepartment_string .= 
        "
            SELECT DISTINCT 
                department_id 
                FROM city 
                WHERE city_id = $destinyCity 
        ";

        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($destinyDepartment_string);
        $params2 = array();
        $stmt2->execute($params2);
        $cursos2 = $stmt2->fetchAll();
        
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) 
            {
                $destinyDepartment = $curso123["department_id"];
            }
        }
        
        return $destinyDepartment;
    }
    
    function getOriginCountry($originDepartment)
    {
        $originCountry_string = "";
        $originCountry_string .= 
        "
            SELECT DISTINCT 
                country_id 
                FROM department 
                WHERE department_id = $originDepartment 
        ";

        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($originCountry_string);
        $params2 = array();
        $stmt2->execute($params2);
        $cursos2 = $stmt2->fetchAll();
        
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) 
            {
                $originCountry = $curso123["country_id"];
            }
        }
        
        return $originCountry;
    }
    
    function getDestinyCountry($destinyDepartment)
    {
        $destinyCountry_string = "";
        $destinyCountry_string .= 
        "
            SELECT DISTINCT 
                country_id 
                FROM department 
                WHERE department_id = $destinyDepartment 
        ";

        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($destinyCountry_string);
        $params2 = array();
        $stmt2->execute($params2);
        $cursos2 = $stmt2->fetchAll();
        
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) 
            {
                $destinyCountry = $curso123["country_id"];
            }
        }
        
        return $destinyCountry;
    }
    
    
    function getLocalRoute($originCity, $location_position, $location_array, $location_parent, $location_name)
    {
        if ($location_position == 0)
        {
            $location_string = 
            "
                SELECT DISTINCT 
                    location_id, 
                    location_name, 
                    location_parent 
                    FROM location 
                    WHERE city_id = $originCity and location_name = '$location_name'
            ";
            
            $em2 = $this->getDoctrine()->getEntityManager();
            $db2 = $em2->getConnection();
            $stmt2 = $db2->prepare($location_string);
            $params2 = array();
            $stmt2->execute($params2);
            $cursos2 = $stmt2->fetchAll();        
            
            if($cursos2)
            {
                foreach($cursos2 as $curso123) 
                {
                    $location_id = $curso123["location_id"];
                    $location_name = $curso123["location_name"];
                    $location_parent = $curso123["location_parent"];

                    $location_array[$location_position] = array(
                        'location_id' => $location_id, 
                        'location_name' => $location_name, 
                        'location_parent' => $location_parent, 
                        'location_position' => $location_position 
                    );

                    $excs = $location_array[$location_position]['location_name'];
                    echo '<br> - '.$excs.' - ';

                }
                
                echo '<br> $location_position == 0 : the first value';
                $location_string = 
                "
                    SELECT DISTINCT 
                        location_id, 
                        location_name, 
                        location_parent 
                        FROM location 
                        WHERE city_id = $originCity and location_name = 'la humildad'
                ";
                $location_position++;
                $location_array = $this->getLocalRoute($originCity, $location_position, $location_array, $location_parent, $location_name);
                    
                return $location_array;
            }
        } else
        {
            $location_string = 
            "
                SELECT DISTINCT 
                    location_id, 
                    location_name, 
                    location_parent 
                    FROM location 
                    WHERE location_id = $location_parent
            ";
            
            $em2 = $this->getDoctrine()->getEntityManager();
            $db2 = $em2->getConnection();
            $stmt2 = $db2->prepare($location_string);
            $params2 = array();
            $stmt2->execute($params2);
            $cursos2 = $stmt2->fetchAll();        

            if ($cursos2)
            {
                foreach($cursos2 as $curso123) 
                {
                    $location_id = $curso123["location_id"];
                    $location_name = $curso123["location_name"];
                    $location_parent = $curso123["location_parent"];

                    $location_array[$location_position] = array(
                        'location_id' => $location_id, 
                        'location_name' => $location_name, 
                        'location_parent' => $location_parent, 
                        'location_position' => $location_position 
                    );

                    $excs = $location_array[$location_position]['location_name'];
                    echo '<br> - '.$excs.' - ';

                }
                
                if ($location_parent == NULL)
                {
                    echo '<br> $location_parent == NULL : the biggest location on the city';
                } else if ($location_parent != NULL && $location_position != 0)
                {
                    echo '<br> $location_parent != NULL : locations in the middle (but not the nearest beacuse $location_position != 0)';
                    echo '<br> $location_position != 0 : there are more parents locations, so isnt the first value';
                    $location_string = 
                    "
                        SELECT DISTINCT 
                            location_id, 
                            location_name, 
                            location_parent 
                            FROM location 
                            WHERE location_id = $location_parent
                    ";
                    $location_position++;
                    $location_array = $this->getLocalRoute($originCity, $location_position, $location_array, $location_parent, $location_name);
                }
                            
                return $location_array;
        
            }
        }
        
        // $location_parent : Has the table called Location the camp called location_parent empty (Null) or Full
        // $location_position : current (unkmown value) = 0, c (u v) + 1, c (u v) + 2, c (u v) + 3, etc.
    }
    
    function getDepartamentalRoute($originCity, $destinyCity)
    {
//        $this->getQueryString($originCity, $destinyCity, $package_maxAmount, $reachLocation, $coverage);
    }
    
    function getNationalRoute($originCity, $destinyCity)
    {
//        $this->getQueryString($originCity, $destinyCity, $package_maxAmount, $reachLocation, $coverage);
    }
    
    function getInternationalRoute($originCity, $destinyCity)
    {
//        $this->getQueryString($originCity, $destinyCity, $package_maxAmount, $reachLocation, $coverage);
    }
    
    
    
    function getUsers_2()
    {
        $sendata_users = array();
        for ($i = 0; $i < 5; $i++)
        {
            $sendata_users[$i] = array(
                'user_id' => "_123456...".$i." ...",
                'user_name' => "_",
                'amount_trajectories' => "_",
                'average_trajectory_time' => "_",
                'amount_anomalies' => "_",
                'last_loggin_duration' => "_",
                'amount_time_logged' => "_"
            );
        }
        return $sendata_users;
    }
    
    function getUsers($package_id, $sendata_users)
    {
        $string_a = "";
        $string_b_1 = "";
        $string_b_2 = "";
        $string_c_1 = "";
        $string_c_2 = "";
        $string_d_1 = "";
        $string_d_2 = "";
        
        
        
        $string_d_1 .= 
        "SELECT DISTINCT 
            user_id, 
            user_name, 
            amount_trajectories, 
            average_trajectory_time, 
            amount_anomalies, 
            MAX(SendingStatus.sendingStatus_available) as datetime_login, 
            MAX(SendingStatus.sendingStatus_unavailable) as datetime_logout, 
            
            DATEDIFF(
            IFNULL(MAX(SendingStatus.sendingStatus_unavailable), NOW()), 
            MAX(SendingStatus.sendingStatus_available)
            ) as last_loggin_duration, 
            
            sum(
                DATEDIFF(
                    IFNULL(SendingStatus.sendingStatus_unavailable, 
                    SendingStatus.sendingStatus_available 
                    ),
                    SendingStatus.sendingStatus_available 
                )
            ) as amount_time_logged 
            
            FROM
            (
        ";

        $string_d_2 .= 
        "
        ) TBR 

        LEFT JOIN SendingStatus ON SendingStatus.sendingStatus_user_id = user_id 

        GROUP BY user_id 
        ORDER BY 
            amount_trajectories DESC, 
            average_trajectory_time DESC, 
            last_loggin_duration DESC, 
            amount_anomalies ASC, 
            amount_time_logged DESC 
        ";
        
        $string_c_1 .= 
        "SELECT DISTINCT 
            user_id, 
            user_name, 
            amount_trajectories, 
            average_trajectory_time, 
            count(Anomaly.anomaly_id) as amount_anomalies 
                
        FROM
        (
        ";
        
        $string_c_2 .= 
        "
        ) TB
        
            LEFT JOIN Trajectory ON Trajectory.messenger_id = user_id 
            LEFT JOIN Anomaly ON Anomaly.trajectory_id = Trajectory.trajectory_id 

            GROUP BY user_id 
        ";
        
        $string_b_1 .= 
        "SELECT DISTINCT 
            user_id, 
            user_name, 
            count(Trajectory.trajectory_id) as amount_trajectories, 

            IFNULL(
                CAST(
                    avg(
                        DATEDIFF
                        (
                            Trajectory.trajectory_settingProduct, 
                            Trajectory.trajectory_gettingProduct
                        )
                    ) AS INT), 
                0) as average_trajectory_time 
                
        FROM
        (
        ";
        
        $string_b_2 .= 
        "
        ) T

        LEFT JOIN Trajectory ON Trajectory.messenger_id = user_id 

        GROUP BY user_id 
        ";
        
        $string_a .= 
        "SELECT DISTINCT 
            User.user_id as user_id, 
            User.user_name as user_name 

            FROM Package 
            LEFT JOIN PackageMessenger ON PackageMessenger.package_id = $package_id 
            INNER JOIN User ON User.user_id = PackageMessenger.messenger_id 

            GROUP BY user_id 
            ORDER BY user_id DESC 
        ";

        
        
        $query_order = 
            "
                $string_d_1
                $string_c_1
                $string_b_1
                $string_a
                $string_b_2
                $string_c_2
                $string_d_2
            ";


        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();
        $stmt2 = $db2->prepare($query_order);
        $params2 = array();
        $stmt2->execute($params2);

        $cursos2 = $stmt2->fetchAll();
        $i = 0;
        foreach($cursos2 as $curso)
        {
            $sendata_users[$i] = array(
                'user_id' => $curso["user_id"],
                'user_name' => $curso["user_name"],
                'amount_trajectories' => $curso["amount_trajectories"],
                'average_trajectory_time' => $curso["average_trajectory_time"],
                'amount_anomalies' => $curso["amount_anomalies"],
                'last_loggin_duration' => $curso["last_loggin_duration"],
                'amount_time_logged' => $curso["amount_time_logged"]
            );
            $i++;
        }
        
        return $sendata_users;
        
    }
    
    
}