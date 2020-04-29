<?php

namespace StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class StoreTestController extends Controller
{
    public $sendata_routes = array();
    public $sendata_users = array();
    public $a = 2;
    public $k=0; 

    public function homeAction()
    {
        $em2 = $this->getDoctrine()->getEntityManager();
        $db2 = $em2->getConnection();

        $originCity = 1;
        $destinyCity = 1;
        $package_maxAmount = 3;

        global $sendata_routes;
        global $sendata_users;
        global $a;

        $sendata_routes_size = sizeof($sendata_routes);

        $query_order = $this->getQueryString($originCity, $destinyCity, $package_maxAmount);
        $this->executeQuery_2($db2, $query_order, $originCity, $destinyCity, $package_maxAmount);

        echo 'store test --- ';
                
        return $this->render('@Store/home/storetest.html.twig');
    }
    

    function executeQuery_2($db2, $query_order, $originCity, $destinyCity, $package_maxAmount)
    {
        echo ' .... '.
        $query_order;
        $stmt2 = $db2->prepare($query_order);
        $params2 = array();
        $stmt2->execute($params2);

        $cursos2 = $stmt2->fetchAll();

        echo 'qwerty';    
        
        global $sendata_routes;
        
        $routes_amount = 0;
        $x=0;
        
            global $k;
            
        if ($cursos2)
        {
            foreach($cursos2 as $curso123) // routes_amount 
            {
//                $k = $curso123["routes_amount_1"];

                for ($i = 1; $i <= $package_maxAmount; $i++)
                {
//                    $package_id_1 = $curso123["package_id_$i"];
//                    $packageOrigin_id_1 = $curso123["packageOrigin_id_$i"];
//                    $city_id_Origin_1 = $curso123["city_id_Origin_$i"];
//                    $packageDestiny_id_1 = $curso123["packageDestiny_id_$i"];
//                    $city_id_Destiny_1 = $curso123["city_id_Destiny_$i"];
//
//
//                    echo '<br><br> '.
//                        "<br> package id: ".$package_id_1.
//                        "<br> origin package: ".$packageOrigin_id_1.
//                        "<br> origin city: ".$city_id_Origin_1.
//                        "<br> destiny package: ".$packageDestiny_id_1.
//                        "<br> destiny city: ".$city_id_Destiny_1.
//                        "<br><br><br>";
                    
                $sendata_routes[$x] = array(
                    'package_id_'.$i => $curso123["package_id_$i"],
                    'packageOrigin_id_'.$i => $curso123["packageOrigin_id_$i"],
                    'city_id_Origin_'.$i => $curso123["city_id_Origin_$i"],
                    'packageDestiny_id_'.$i => $curso123["packageDestiny_id_$i"],
                    'city_id_Destiny_'.$i => $curso123["city_id_Destiny_$i"]
                );
                    

                }
                
                
                $x++;
                echo 'repeticion: '.$x."<br>";
            }
            
            echo 'si';
            
//            $routes_amount = $cursos2["routes_amount_1"];
            $j=0;
            foreach($cursos2 as $curso) // routes_amount 
            {
//                $sendata_routes[$j] = array(
//                    'package_id_' => "_".$k." ... ".$curso["package_id_1"],
//                    'packageOrigin_id_' => $curso["packageOrigin_id_1"],
//                    'city_id_Origin_' => $curso["city_id_Origin_1"],
//                    'packageDestiny_id_' => $curso["packageDestiny_id_1"],
//                    'city_id_Destiny_' => $curso["city_id_Destiny_1"],
//                    'amount_' => 4
//                );
//                $j++;
            }
            
            
            
        } else
        {
            echo 'no';
//            $sendata_routes[0] = array(
//                'package_id_' => "_",
//                'packageOrigin_id_' => "_",
//                'city_id_Origin_' => "_",
//                'packageDestiny_id_' => "_",
//                'city_id_Destiny_' => "_",
//                'amount_' => 2
//            );
//            
//            $sendata_routes[1] = array(
//                'package_id_' => "2",
//                'packageOrigin_id_' => "2",
//                'city_id_Origin_' => "2",
//                'packageDestiny_id_' => "2",
//                'city_id_Destiny_' => "2",
//                'amount_' => 2
//            );
        }
        
    }
    
            
    function getQueryString($originCity, $destinyCity, $package_maxAmount)
    {
        $string_a = "";
        $string_b = "";
        $string_c = "";
        $string_f = "";
        
        for ($i = 1; $i <= $package_maxAmount; $i++)
        {
            $packages_amount = $package_maxAmount - $i;

            $string_b .= 
            "SELECT DISTINCT 
                ";
            for ($j = 1; $j <= $packages_amount; $j++)
            {
                $string_b .= 
                "
                package_id_$j, 
                packageOrigin_id_$j, 
                city_id_Origin_$j, 
                packageDestiny_id_$j, 
                city_id_Destiny_$j, 
                ";
                
                if ($j == $packages_amount)
                {
                    $k = $j + 1;
                    $string_b .= 
                    "
                        Package_$k.package_id as package_id_$k, 
                        PackageOrigin_$k.packageOrigin_id as packageOrigin_id_$k, 
                        CityOrigin_$k.city_id as city_id_Origin_$k, 
                        PackageDestiny_$k.packageDestiny_id as packageDestiny_id_$k, 
                        CityDestiny_$k.city_id as city_id_Destiny_$k 
                    ";
                }
            }
            
            if ($i == $package_maxAmount)
            {
                $string_b .= 
                "
                    Package_1.package_id as package_id_1, 
                    PackageOrigin_1.packageOrigin_id as packageOrigin_id_1, 
                    CityOrigin_1.city_id as city_id_Origin_1, 
                    PackageDestiny_1.packageDestiny_id as packageDestiny_id_1, 
                    CityDestiny_1.city_id as city_id_Destiny_1 
                    FROM City as CityOrigin_1 
                ";
            } else
            {
                $string_b .= 
                "FROM 
                (";
            }
            
            if ($i == 1)
            {
                $string_a .= 
                "
                    LEFT JOIN PackageOrigin as PackageOrigin_1 ON PackageOrigin_1.city_id = CityOrigin_1.city_id 

                    LEFT JOIN Package as Package_1 ON PackageOrigin_1.package_id = Package_1.package_id 

                    LEFT JOIN PackageDestiny as PackageDestiny_1 ON PackageDestiny_1.package_id = Package_1.package_id 
                    LEFT JOIN City as CityDestiny_1 ON PackageDestiny_1.city_id = CityDestiny_1.city_id 
                    
                    LEFT JOIN PackageMessenger ON PackageMessenger.package_id = Package_1.package_id 
                
                ";  
//                WHERE CityOrigin_1.city_id = '1' and CityDestiny_1.city_id = '1' 
            } else
            {
                $previous_value = $i - 1;
                $string_a .= 
                "
                ) Z_$i 
                    LEFT JOIN City as CityOrigin_$i ON city_id_Destiny_$previous_value = CityOrigin_$i.city_id 
                    LEFT JOIN PackageOrigin as PackageOrigin_$i ON PackageOrigin_$i.city_id = CityOrigin_$i.city_id 

                    LEFT JOIN Package as Package_$i ON PackageOrigin_$i.package_id = Package_$i.package_id 

                    LEFT JOIN PackageDestiny as PackageDestiny_$i ON PackageDestiny_$i.package_id = Package_$i.package_id 
                    LEFT JOIN City as CityDestiny_$i ON PackageDestiny_$i.city_id = CityDestiny_$i.city_id 
                        
                    LEFT JOIN PackageMessenger ON PackageMessenger.package_id = Package_$i.package_id 
                
                ";
//                WHERE CityOrigin_$i.city_id = '1' and CityDestiny_$i.city_id = '1' 
            }
            
        }
        
        for ($i = 1; $i <= $package_maxAmount; $i++)
        {
            
            if ($package_maxAmount === 1)
            {
                $next_value = 1;
//                $origin = "CityOrigin_$next_value.city_id";
//                $destiny = "CityDestiny_$i.city_id";
                $origin = "city_id_Origin_$next_value";
                $destiny = "city_id_Destiny_$i";
            } else if ($package_maxAmount > 1)
            {
                $next_value = $i + 1;
                $bucles_amount = $package_maxAmount - 1;
                if ($i === $bucles_amount)
                {
//                    $origin = "CityOrigin_$next_value.city_id";
//                    $destiny = "city_id_Destiny_$i";
                    $origin = "city_id_Origin_$next_value";
                    $destiny = "city_id_Destiny_$i";
                } else if ($i < $bucles_amount)
                {
                    $origin = "city_id_Origin_$next_value";
                    $destiny = "city_id_Destiny_$i";
                }
            }
            
            if ($i == 1)
            {
//                $string_c .= "
//                    $origin = $destiny 
//                ";
            }
            else if ($i == $package_maxAmount)
            {
                
            }
            else 
            {
//                $string_c .= "
//                    and $origin = $destiny 
//                ";
            }
            
            if ($i == $package_maxAmount)
            {
                if ($package_maxAmount == 1)
                {
//                    $string_c .= "
//                        PackageOrigin_1.city_id = '$originCity' 
//                        and PackageDestiny_$package_maxAmount.city_id = '$destinyCity' 
//                    ";
                    $string_c .= "
                        CityOrigin_1.city_id = '$originCity' 
                        and CityDestiny_$package_maxAmount.city_id = '$destinyCity' 
                    ";
//                    $string_c .= "
//                        city_id_Origin_1 = '$originCity' 
//                        and city_id_Destiny_$package_maxAmount = '$destinyCity' 
//                    ";
                } else 
                {
//                    $string_c .= "
//                        PackageOrigin_1.city_id = '$originCity' 
//                        and PackageDestiny_$package_maxAmount.city_id = '$destinyCity' 
//                    ";
                    $string_c .= "
                        city_id_Origin_1 = '$originCity' 
                        and CityDestiny_$package_maxAmount.city_id = '$destinyCity' 
                    ";
//                    $string_c .= "
//                        city_id_Origin_1 = '$originCity' 
//                        and city_id_Destiny_$package_maxAmount = '$destinyCity' 
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
    
}
