<?php

namespace UploadProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BranchController extends Controller
{
    public function uploadBranchAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $branchName_uploadBranchInput = $_POST['branchName_uploadBranchInput'];
            $branchCellphone_uploadBranchInput = $_POST['branchCellphone_uploadBranchInput'];
            $branchTelephone_uploadBranchInput = $_POST['branchTelephone_uploadBranchInput'];
            $branchAddress_uploadBranchInput = $_POST['branchAddress_uploadBranchInput'];
            $branchDescription_uploadBranchTextarea = $_POST['branchDescription_uploadBranchTextarea'];
            $branchCountry_uploadBranchSelect = $_POST['branchCountry_uploadBranchSelect'];
            $branchCity_uploadBranchSelect = $_POST['branchCity_uploadBranchSelect'];
            
            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
            }
            else {
                $userId = 0;
            }

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);
            $country = $em->getRepository('HomeBundle:Country')->findOneByCountryName($branchCountry_uploadBranchSelect);
            
            if(!$country)
            {
                $country = new \HomeBundle\Entity\Country();
                $country->setCountryName($branchCountry_uploadBranchSelect);
                $em->persist($country);
                $em->flush();
            }

            $city = $em->getRepository('HomeBundle:City')->findOneByCityName($branchCity_uploadBranchSelect);
            if (!$city)
            {
                $city = new \HomeBundle\Entity\City();
                $city->setCityName($branchCity_uploadBranchSelect);
                $city->setCountry($country);
                $em->persist($city);
                $em->flush();
            }

            $branch = new \HomeBundle\Entity\Branch();
            $branch->setBranchName($branchName_uploadBranchInput);
            $branch->setBranchAddress($branchAddress_uploadBranchInput);
            $branch->setBranchAditionalInformation($branchDescription_uploadBranchTextarea);
            $branch->setBranchCellphone($branchCellphone_uploadBranchInput);
            $branch->setBranchTelephone($branchTelephone_uploadBranchInput);
            $branch->setCity($city);
            $branch->setUser($user);
            $em->persist($branch);
            $em->flush();
            
            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getBranchCountryAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $country = $em->createQuery(
                "SELECT c.countryId, c.countryName 
                FROM HomeBundle:Country c "
            );
            $country_v = $country->getResult();
            
            $amountCountries = 0;
            while (isset($country_v[$amountCountries]['countryId'])) {
                $amountCountries++; // this is another function, and another div 
            }
            
            $i = 0;
            while (isset($country_v[$i]['countryId'])) {
                
                if ($country_v) {
                    $countryId_Value = $country_v[$i]['countryId'];
                    $countryName_Value = $country_v[$i]['countryName'];
                    $amountCountries_Value = $amountCountries;
                } else {
                    $countryId_Value = "_";
                    $countryName_Value = "_";
                    $amountCountries_Value = $amountCountries;
                }

                $countryData[$i] = array(
                    'countryId' => $countryId_Value,
                    'countryName' => $countryName_Value,
                    'amountCountries' => $amountCountries_Value
                );
                $i++;
            }
            
            return new Response(json_encode($countryData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getBranchCityAction(Request $request)
    {
        
        $user_country = $_POST['user_country'];
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $city = $em->createQuery(
                "SELECT ci.cityId, ci.cityName 
                FROM HomeBundle:City ci 
                JOIN HomeBundle:Country co 
                WITH ci.country = co.countryId 
                WHERE co.countryName = '$user_country'"
            );
            $city_v = $city->getResult();
            
            $amountCities = 0;
            while (isset($city_v[$amountCities]['cityId'])) {
                $amountCities++; // this is another function, and another div 
            }
            
            $i = 0;
            while (isset($city_v[$i]['cityId'])) {
                
                if ($city_v) {
                    $cityId_Value = $city_v[$i]['cityId'];
                    $cityName_Value = $city_v[$i]['cityName'];
                    $amountCities_Value = $amountCities;
                } else {
                    $cityId_Value = "_";
                    $cityName_Value = "_";
                    $amountCities_Value = $amountCities;
                }

                $cityData[$i] = array(
                    'cityId' => $cityId_Value,
                    'cityName' => $cityName_Value,
                    'amountCities' => $amountCities_Value
                );
                $i++;
            }
            
            return new Response(json_encode($cityData), 200, array('Content-Type' => 'application/json'));
        }
    }
}