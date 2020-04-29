<?php

namespace UploadProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StockController extends Controller
{
//    public function indexAction()
//    {
//        return $this->render('@UploadProduct/Default/index.html.twig');
//    }
    
    public function getBranchAction(Request $request)
    {
        $productId = $_POST['productId'];
        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }

        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $branchQuery = $em->createQuery(
                "SELECT b.branchId, b.branchName, b.branchAddress, 
                b.branchTelephone, b.branchCellphone, b.branchAditionalInformation, 
                c.cityName, co.countryName 

                FROM HomeBundle:Branch b 

                JOIN HomeBundle:User u 
                WITH b.user = u.userId 

                JOIN HomeBundle:City c 
                WITH b.city = c.cityId 

                JOIN HomeBundle:Country co 
                WITH c.country = co.countryId 

                WHERE u.userId = '$userId'"
            );
            $branchQuery_v = $branchQuery->getResult();
            $amountBranch = count($branchQuery_v);
            
            $i = 0;
            while (isset($branchQuery_v[$i]['branchId'])) {
                
                $branchId_Value = $branchQuery_v[$i]['branchId'];

                $stockQuery = $em->createQuery(
                    "SELECT b.branchId, b.branchName, b.branchAddress, 
                    b.branchTelephone, b.branchCellphone, b.branchAditionalInformation, 
                    c.cityName, co.countryName, s.stockAmount, s.stockPrice 

                    FROM HomeBundle:Branch b 

                    JOIN HomeBundle:City c 
                    WITH b.city = c.cityId 

                    JOIN HomeBundle:Country co 
                    WITH c.country = co.countryId 

                    JOIN HomeBundle:Stock s 
                    WITH s.branch = b.branchId 

                    JOIN HomeBundle:Product p 
                    WITH s.product = p.productId

                    WHERE b.branchId = '$branchId_Value' and p.productId = '$productId'"
                );
                $stockQuery_v = $stockQuery->getResult();

                if (isset($stockQuery_v[0]['branchId']))
                {
                    $branchId_Value = $stockQuery_v[0]['branchId'];
                    $branchName_Value = $stockQuery_v[0]['branchName'];
                    $branchAddress_Value = $stockQuery_v[0]['branchAddress'];
                    $branchTelephone_Value = $stockQuery_v[0]['branchTelephone'];
                    $branchCellphone_Value = $stockQuery_v[0]['branchCellphone'];
                    $branchAditionalInformation_Value = $stockQuery_v[0]['branchAditionalInformation'];
                    $cityName_Value = $stockQuery_v[0]['cityName'];
                    $countryName_Value = $stockQuery_v[0]['countryName'];
                    $stockAmount_Value = $stockQuery_v[0]['stockAmount'];
                    $stockPrice_Value = $stockQuery_v[0]['stockPrice'];

                    $sendData[$i] = array(
                        'branchId' => $branchId_Value,
                        'branchName' => $branchName_Value,
                        'branchAddress' => $branchAddress_Value,
                        'branchTelephone' => $branchTelephone_Value,
                        'branchCellphone' => $branchCellphone_Value,
                        'branchAditionalInformation' => $branchAditionalInformation_Value,
                        'cityName' => $cityName_Value,
                        'countryName' => $countryName_Value,
                        'stockAmount' => $stockAmount_Value,
                        'stockPrice' => $stockPrice_Value,
                        'amountBranch' => $amountBranch
                    );
                } 
                else {
                    $branchId_Value = $branchQuery_v[$i]['branchId'];
                    $branchName_Value = $branchQuery_v[$i]['branchName'];
                    $branchAddress_Value = $branchQuery_v[$i]['branchAddress'];
                    $branchTelephone_Value = $branchQuery_v[$i]['branchTelephone'];
                    $branchCellphone_Value = $branchQuery_v[$i]['branchCellphone'];
                    $branchAditionalInformation_Value = $branchQuery_v[$i]['branchAditionalInformation'];
                    $cityName_Value = $branchQuery_v[$i]['cityName'];
                    $countryName_Value = $branchQuery_v[$i]['countryName'];
                    $stockAmount_Value = 0;
                    $stockPrice_Value = 0;

                    $sendData[$i] = array(
                        'branchId' => $branchId_Value,
                        'branchName' => $branchName_Value,
                        'branchAddress' => $branchAddress_Value,
                        'branchTelephone' => $branchTelephone_Value,
                        'branchCellphone' => $branchCellphone_Value,
                        'branchAditionalInformation' => $branchAditionalInformation_Value,
                        'cityName' => $cityName_Value,
                        'countryName' => $countryName_Value,
                        'stockAmount' => $stockAmount_Value,
                        'stockPrice' => $stockPrice_Value,
                        'amountBranch' => $amountBranch
                    );
                }
                
                $i++;
            }
            
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function confirmStockAmountAction(Request $request)
    {
        $branchId_data = $_POST['branchId_data'];
        $productId_data = $_POST['productId_data'];
        $stockAmount_data = $_POST['stockAmount_data'];
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $branch = $em->getRepository('HomeBundle:Branch')->findOneByBranchId($branchId_data);
            $product = $em->getRepository('HomeBundle:Product')->findOneByProductId($productId_data);
            $stockId = $this->getStockData($em, $productId_data, $branchId_data);
            
            $todayDate = date("Y-m-d");
            $todayDate_format = date_create_from_format('Y-m-d', $todayDate);
            
            if ($stockId != "null")
            {
                $stock = $em->getRepository('HomeBundle:Stock')->findOneByStockId($stockId);
                $stock->setStockAmount($stockAmount_data);
                
                $em->persist($stock);
                $em->flush();
            } else
            {
                $stock = new \HomeBundle\Entity\Stock();
                $stock->setBranch($branch);
                $stock->setProduct($product);
                $stock->setStockAmount($stockAmount_data);
                $stock->setStockLasttransactiondate($todayDate_format);
                $stock->setStockPrice(0);
                
                $em->persist($stock);
                $em->flush();
            }
            
            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function confirmStockPriceAction(Request $request)
    {
        $branchId_data = $_POST['branchId_data'];
        $productId_data = $_POST['productId_data'];
        $stockPrice_data = $_POST['stockPrice_data'];
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $branch = $em->getRepository('HomeBundle:Branch')->findOneByBranchId($branchId_data);
            $product = $em->getRepository('HomeBundle:Product')->findOneByProductId($productId_data);
            $stockId = $this->getStockData($em, $productId_data, $branchId_data);
            
            $todayDate = date("Y-m-d");
            $todayDate_format = date_create_from_format('Y-m-d', $todayDate);
            
            if ($stockId != "null")
            {
                $stock = $em->getRepository('HomeBundle:Stock')->findOneByStockId($stockId);
                $stock->setStockPrice($stockPrice_data);
                
                $em->persist($stock);
                $em->flush();
            } else
            {
                $stock = new \HomeBundle\Entity\Stock();
                $stock->setBranch($branch);
                $stock->setProduct($product);
                $stock->setStockAmount(0);
                $stock->setStockLasttransactiondate($todayDate_format);
                $stock->setStockPrice($stockPrice_data);
                
                $em->persist($stock);
                $em->flush();
            }
            
            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getStockData($em, $productId_data, $branchId_data)
    {
        $stockProduct = $em->createQuery(
            "SELECT s.stockId, s.stockAmount 

            FROM HomeBundle:Stock s 
            
            JOIN HomeBundle:Product p 
            WITH s.product = p.productId 
            
            JOIN HomeBundle:Branch b 
            WITH s.branch = b.branchId 

            WHERE p.productId = '$productId_data' and 
            b.branchId = '$branchId_data' 
            ORDER BY s.stockLasttransactiondate DESC"
        );
        $stockProduct_v = $stockProduct->getResult();
        if (isset($stockProduct_v[0]['stockId']))
        {
            $stockId = $stockProduct_v[0]['stockId'];
        } else
        {
            $stockId = "null";
        }
        
        return $stockId;
    }
    
}
