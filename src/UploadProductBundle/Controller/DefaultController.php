<?php

namespace UploadProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@UploadProduct/Default/index.html.twig');
    }
    
    public function uploadProductAction(Request $request)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }

        
        $product_id = $_POST['product_id'];
        $carpeta = "files/products/".$userId."/";
        
        if (!file_exists($carpeta))
        {
            mkdir($carpeta, 0777);
        }
        
        opendir($carpeta);

        $image_status = "";
        
        $filenameImage = $_FILES['product_image']['tmp_name'];
        
        $typeImage = $_FILES['product_image']['type'];
        if ($typeImage == "image/jpeg" OR $typeImage == "image/jpg" OR $typeImage == "image/png") {
            
            if($typeImage == "image/jpeg")
            {
                $destinationImage = $carpeta . $product_id . ".jpeg";
            }
            if($typeImage == "image/jpg")
            {
                $destinationImage = $carpeta . $product_id . ".jpg";
            }
            if($typeImage == "image/png")
            {
                $destinationImage = $carpeta . $product_id . ".png";
            }
            move_uploaded_file($filenameImage, $destinationImage);
        }
        
        $response = array();
        $response[0] = array(
            'image_status' => $image_status
        );
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
    
    public function updateProductAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $productName_uploadProductInput = $_POST['productName_uploadProductInput'];
            $productPrice_uploadProductInput = $_POST['productPrice_uploadProductInput'];
            $productDescription_uploadProductTextarea = $_POST['productDescription_uploadProductTextarea'];
            $productImage_uploadProductInput = $_FILES['productImage_uploadProductInput']['name'];
            
            $selectedArtistId_uploadProductInput = $_POST['selectedArtistId_uploadProductInput'];
            $selectedSongId_uploadProductInput = $_POST['selectedSongId_uploadProductInput'];
            $selectedProductTypeId_uploadProductInput = $_POST['selectedProductTypeId_uploadProductInput'];
            
            
            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
            }
            else {
                $userId = 0;
            }
        
            if ($request->isXMLHttpRequest()) {
                
                $typeImage = $_FILES["productImage_uploadProductInput"]['type'];
                if ($typeImage == "image/jpeg" OR $typeImage == "image/jpg" OR $typeImage == "image/png") {

                    if($typeImage == "image/jpeg")
                    {
                        $imageType = ".jpeg";
                    }
                    if($typeImage == "image/jpg")
                    {
                        $imageType = ".jpg";
                    }
                    if($typeImage == "image/png")
                    {
                        $imageType = ".png";
                    }

                }

                $artist = $em->getRepository('HomeBundle:User')->findOneByUserId($selectedArtistId_uploadProductInput);
                $song = $em->getRepository('HomeBundle:Video')->findOneByVideoId($selectedSongId_uploadProductInput);
                $producttype = $em->getRepository('HomeBundle:Producttype')->findOneByProducttypeId($selectedProductTypeId_uploadProductInput);
                $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);

                $product = new \HomeBundle\Entity\Product();
                $product->setProductDescription($productDescription_uploadProductTextarea);
                $product->setProductImage("");
                $product->setProductPrice($productPrice_uploadProductInput);
                $product->setProductName($productName_uploadProductInput);
                $product->setArtist($artist);
                $product->setSong($song);
                $product->setProducttype($producttype);
                $product->setUser($user);
                $em->persist($product);
                $em->flush();
                    
                $new_imageName = $product->getProductId();
                $product->setProductImage($new_imageName.$imageType);
                $em->persist($product);
                $em->flush();
                    
                $product_id = $product->getProductId();
                $product_description = $product->getProductDescription();
                $product_image = $product->getProductImage();
                $product_name = $product->getProductName();
                $product_price = $product->getProductPrice();
                $product_artist = $product->getArtist();
                $product_song = $product->getSong();
                $product_type = $product->getProducttype();
                $product_user = $product->getUser();

                $response[0] = array(
                    'product_id' => $product_id,
                    'product_description' => $product_description,
                    'product_image' => $product_image,
                    'product_name' => $product_name,
                    'product_price' => $product_price,
                    'product_artist' => $product_artist,
                    'product_song' => $product_song,
                    'product_type' => $product_type,
                    'product_user' => $product_user
                );
                
                return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
            }
        }
    }
    
    public function uploadSecondaryImagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $amount_images = $_POST['amount_images'];
        $product_id = $_POST['product_id'];
        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }

        $carpeta = "files/products/secondaryImages/".$userId."/".$product_id."/";
        
        if (!file_exists($carpeta))
        {
            mkdir($carpeta, 0777);
        }
        
        opendir($carpeta);
        
        $i=0;
        foreach($_FILES["secondaryImages_uploadProductInput"]['tmp_name'] as $key => $tmp_name)
        {   
            $filenameImage = $_FILES["secondaryImages_uploadProductInput"]['tmp_name'][$key];

            $productImage_id = "currentImage_id".$i;
            $destination_productImage = $_POST[$productImage_id];

            $typeImage = $_FILES["secondaryImages_uploadProductInput"]['type'][$key];
            if ($typeImage == "image/jpeg" OR $typeImage == "image/jpg" OR $typeImage == "image/png") {

                if($typeImage == "image/jpeg")
                {
                    $destinationImage = $carpeta . $destination_productImage . ".jpeg";
                }
                if($typeImage == "image/jpg")
                {
                    $destinationImage = $carpeta . $destination_productImage . ".jpg";
                }
                if($typeImage == "image/png")
                {
                    $destinationImage = $carpeta . $destination_productImage . ".png";
                }

                move_uploaded_file($filenameImage, $destinationImage);
            }
            
            $i++;
        }
        
        
        $image_status = "";
        
        $response = array();
        $response[0] = array(
            'image_status' => $image_status
        );
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
    
    public function updateSecondaryImagesAction(Request $request)
    {
        $product_id = $_POST['product_id'];
        
        $em = $this->getDoctrine()->getManager();
        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }

        $amountImages = 0;
        foreach($_FILES["secondaryImages_uploadProductInput"]['tmp_name'] as $key => $tmp_name)
        {
            $amountImages++;
        }
        
        
        $i = 0;
        foreach($_FILES["secondaryImages_uploadProductInput"]['tmp_name'] as $key => $tmp_name)
        {
            if ($_FILES["secondaryImages_uploadProductInput"]['name'][$key]) {
                
                $typeImage = $_FILES["secondaryImages_uploadProductInput"]['type'][$key];
                if ($typeImage == "image/jpeg" OR $typeImage == "image/jpg" OR $typeImage == "image/png") {
                    
                    if($typeImage == "image/jpeg")
                    {
                        $imageType = ".jpeg";
                    }
                    if($typeImage == "image/jpg")
                    {
                        $imageType = ".jpg";
                    }
                    if($typeImage == "image/png")
                    {
                        $imageType = ".png";
                    }
                    
                }
                
                $product = $em->getRepository('HomeBundle:Product')->findOneByProductId($product_id);
                
                $productImage = new \HomeBundle\Entity\Productimage();
                $productImage->setProduct($product);
                $productImage->setProductimageImage("");
                $em->persist($productImage);
                $em->flush();
                
                
                $new_imageName = $productImage->getProductimageId();
                $productImage->setProductimageImage($new_imageName.$imageType);
                $em->persist($productImage);
                $em->flush();
                
                $productimageId = $productImage->getProductimageId();
                $productimage = $productImage->getProductimageImage();
                
                $response[$i] = array(
                    'productimageId' => $productimageId,
                    'productimage' => $productimage,
                    'amountImages' => $amountImages
                );
                $i++;
            }
        }
        
        

        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
    
    
    
    
    
    
    
    
    
    
    public function getCurrentArtistInformationAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $username = $_POST['username'];
            
            $userInformation = $em->createQuery(
                "SELECT u.userId, u.userName, u.userProfilephoto, u.userFirstgivenname, u.userSecondgivenname, 
                u.userFirstfamilyname, u.userSecondfamilyname, u.userEmail, u.userBiography 
                FROM HomeBundle:User u 
                WHERE u.userName = '$username'"
            );
            $userInformation_v = $userInformation->getResult();
            
            if (isset($userInformation_v[0]['userId']))
            {
                $userId_value = $userInformation_v[0]['userId'];
                $userName_value = $userInformation_v[0]['userName'];
                $userProfilephoto_value = $userInformation_v[0]['userProfilephoto'];
                $userFirstgivenname_value = $userInformation_v[0]['userFirstgivenname'];
                $userSecondgivenname_value = $userInformation_v[0]['userSecondgivenname'];
                $userFirstfamilyname_value = $userInformation_v[0]['userFirstfamilyname'];
                $userSecondfamilyname_value = $userInformation_v[0]['userSecondfamilyname'];
                $userEmail_value = $userInformation_v[0]['userEmail'];
                $userBiography_value = $userInformation_v[0]['userBiography'];                
            } else
            {
                $userId_value = "_";
                $userName_value = "_";
                $userProfilephoto_value = "_";
                $userFirstgivenname_value = "_";
                $userSecondgivenname_value = "_";
                $userFirstfamilyname_value = "_";
                $userSecondfamilyname_value = "_";
                $userEmail_value = "_";
                $userBiography_value = "_";
            }
            
            
            $artistInformation = array();
            $artistInformation[0] = array(
                'userId' => $userId_value,
                'userName' => $userName_value,
                'userProfilephoto' => $userProfilephoto_value,
                'userFirstgivenname' => $userFirstgivenname_value,
                'userSecondgivenname' => $userSecondgivenname_value,
                'userFirstfamilyname' => $userFirstfamilyname_value,
                'userSecondfamilyname' => $userSecondfamilyname_value,
                'userEmail' => $userEmail_value,
                'userBiography' => $userBiography_value
            );
            
            return new Response(json_encode($artistInformation), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getCurrentArtistSongsAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $username = $_POST['username'];
            
            $songInformation = $em->createQuery(
                "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, 
                v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
                v.videoAmountComments, v.videoScore, u.userId, u.userName 
                FROM HomeBundle:Video v 

                JOIN HomeBundle:User u 
                WITH u.userId = v.user 

                WHERE u.userName = '$username'

                ORDER BY v.videoAmountViews DESC"
            )
            ->setFirstResult(0)
            ->setMaxResults(300);

            $songInformation_v = $songInformation->getResult();
            
                        
            $amountVideos = count($songInformation_v);
            
            
            $i = 0;
            while (isset($songInformation_v[$i]['videoId'])) {
                
                    if (
                        file_exists("files/".$songInformation_v[$i]['userId'].
                        "/".$songInformation_v[$i]['videoId'].
                        "/".$songInformation_v[$i]['videoImage'])
                        &&
                        file_exists("files/".$songInformation_v[$i]['userId'].
                        "/".$songInformation_v[$i]['videoId'].
                        "/".$songInformation_v[$i]['videoContent'])
                    )
                    {
                        $videoUpdatedate = $songInformation_v[$i]['videoUpdatedate'];
                        $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                        $videoAmountViews = $songInformation_v[$i]['videoAmountViews'];
                        $videoAmountViewsFormat = number_format($videoAmountViews);

                        $videoAmountComments = $songInformation_v[$i]['videoAmountComments'];
                        $videoAmountCommentsFormat = number_format($videoAmountComments);
                        
                        $videoId_Value = $songInformation_v[$i]['videoId'];
                        $videoName_Value = $songInformation_v[$i]['videoName'];
                        $videoDescription_Value = $songInformation_v[$i]['videoDescription'];
                        $videoImage_Value = $songInformation_v[$i]['videoImage'];
                        $videoContent_Value = $songInformation_v[$i]['videoContent'];
                        $videoUpdatedate_Value = $videoUpdatedateString;
                        $videoAmountViews_Value = $videoAmountViewsFormat;
                        $videoAmountComments_Value = $videoAmountCommentsFormat;
                        $videoScore_Value = $songInformation_v[$i]['videoScore'];
                        $userId_Value = $songInformation_v[$i]['userId'];
                        $userName_Value = $songInformation_v[$i]['userName'];
                        $amountVideos_Value = $amountVideos;
                        
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
                        $amountVideos_Value = $amountVideos;
                    }
                
                $videoFromUser[$i] = array(                    
                    'videoId' => $videoId_Value,
                    'videoName' => $videoName_Value,
                    'videoDescription' => $videoDescription_Value,
                    'videoImage' => $videoImage_Value,
                    'videoContent' => $videoContent_Value,
                    'videoUpdatedate' => $videoUpdatedate_Value,
                    'videoAmountViews' => $videoAmountViews_Value,
                    'videoAmountComments' => $videoAmountComments_Value,
                    'videoScore' => $videoScore_Value,
                    'userId' => $userId_Value,
                    'userName' => $userName_Value,
                    'amountVideos' => $amountVideos_Value
                );
                $i++;
            }
            
            if (isset($songInformation_v[0]['videoId'])) {
                
            } else
            {
                $videoFromUser[0] = array(                    
                    'videoId' => "_",
                    'videoName' => "_",
                    'videoDescription' => "_",
                    'videoImage' => "_",
                    'videoContent' => "_",
                    'videoUpdatedate' => "_",
                    'videoAmountViews' => "_",
                    'videoAmountComments' => "_",
                    'videoScore' => "_",
                    'userId' => "_",
                    'userName' => "_",
                    'amountVideos' => "_"
                );
            }
            
            return new Response(json_encode($videoFromUser), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function insertKeywordProductAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            
            $product_id = $_POST['product_id'];
            $amountKeywords = $_POST['amountAttemptedKeywords'];
            
            $em = $this->getDoctrine()->getManager();
                
                
            $i = 0;
            while ($i <= $amountKeywords) {
                
                if (isset($_POST['productKeywordContentInput_uploadProduct'.$i]))
                {
                    $productKeyword_Value = $_POST['productKeywordContentInput_uploadProduct'.$i];
                    
                    $keyword_id = $this->insertKeyword($em, $productKeyword_Value);
                    $this->insertKeywordProduct($em, $keyword_id, $product_id);    
                }
                
                $i++;
            }
            
            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function insertKeyword($em, $productKeyword_Value)
    {
        $kewywordInformation = $em->createQuery(
            "SELECT DISTINCT k.keywordId, k.keywordContent 
            FROM HomeBundle:Keyword k 

            WHERE k.keywordContent = '$productKeyword_Value'
            "
        );

        $kewywordInformation_v = $kewywordInformation->getResult();
        if (isset($kewywordInformation_v[0]['keywordId']))
        {
            $keyword_id = $kewywordInformation_v[0]['keywordId'];
        } else
        {
            $keyword = new \HomeBundle\Entity\Keyword();
            $keyword->setKeywordContent($productKeyword_Value);
            $keyword->setKeywordScore(0);
            $em->persist($keyword);
            $em->flush();

            $keyword_id = $keyword->getKeywordId();
        }
        return $keyword_id;
    }
    
    public function insertKeywordProduct($em, $keyword_id, $product_id)
    {
        $productKewywordInformation = $em->createQuery(
            "SELECT DISTINCT kp.keywordproductId 
            FROM HomeBundle:Keywordproduct kp 

            JOIN HomeBundle:Keyword k 
            WITH k.keywordId = kp.keyword 

            WHERE k.keywordId = '$keyword_id' 
            "
        );

        $productKewywordInformation_v = $productKewywordInformation->getResult();

        if (isset($productKewywordInformation_v[0]['keywordproductId']))
        {

        } else
        {
            $product = $em->getRepository('HomeBundle:Product')->findOneByProductId($product_id);
            $keyword = $em->getRepository('HomeBundle:Keyword')->findOneByKeywordId($keyword_id);

            $keywordProduct = new \HomeBundle\Entity\Keywordproduct();
            $keywordProduct->setKeyword($keyword);
            $keywordProduct->setProduct($product);
            $em->persist($keywordProduct);
            $em->flush();
        }
    }

    public function getProductTypeAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $productType_value = $_POST['productType_value'];
//            WHERE pt.producttypeName = '$productType_value' 
            $productTypeInformation = $em->createQuery(
                "SELECT DISTINCT pt.producttypeName, pt.producttypeId 
                FROM HomeBundle:Producttype pt 

                WHERE pt.producttypeName LIKE '%$productType_value%' 
                
                ORDER BY pt.producttypeScore DESC"
            )
            ->setFirstResult(0)
            ->setMaxResults(30);

            $productTypeInformation_v = $productTypeInformation->getResult();
            $productTypeVideosAmount = count($productTypeInformation_v);
            
            $i = 0;
            while (isset($productTypeInformation_v[$i]['producttypeId'])) {
                $producttypeId_value = $productTypeInformation_v[$i]['producttypeId'];
                $producttypeName_value = $productTypeInformation_v[$i]['producttypeName'];
                
                $productType[$i] = array(                    
                    'producttypeId' => $producttypeId_value,
                    'producttypeName' => $producttypeName_value,
                    'productTypeVideosAmount' => $productTypeVideosAmount
                );
                $i++;
            }


            if (isset($productTypeInformation_v[0]['producttypeId'])) {
                $producttypeId_value = $productTypeInformation_v[0]['producttypeId'];
                $this->increase_score_productType($producttypeId_value, $em);
            } else
            {
                $this->insert_productType($productType_value, $em);
                $productType[0] = array(
                    'producttypeId' => "_",
                    'producttypeName' => "_",
                    'productTypeVideosAmount' => $productTypeVideosAmount
                );
            }
            
            return new Response(json_encode($productType), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function increase_score_productType($producttypeId_value, $em)
    {
        $productType = $em->getRepository('HomeBundle:Producttype')->findOneByProducttypeId($producttypeId_value);
        $score = $productType->getProducttypeScore();
        $newScore = $score + 1;
        $productType->setProducttypeScore($newScore);
        $em->persist($productType);
        $em->flush();
    }
    
    public function insert_productType($productType_value, $em)
    {
        $productType = new \HomeBundle\Entity\Producttype();
        $productType->setProducttypeName($productType_value);
        $productType->setProducttypeScore(0);
        $em->persist($productType);
        $em->flush();
    }
    
    public function getStockAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
            }
            else {
                $userId = 0;
            }
            
            $daysAmount = $_POST['daysAmount'];
            $order = $_POST['order']; // 1: ascendent; 0: descendent (by default)
            $orderType = $_POST['orderType']; // 0: default, 1: sales, 2: stock, 3: name, 4: type 
        
            if ($orderType === 4)
            {
                $order_array = $this->getStockByType($em, $userId, $order);
            } else
            {
                $order_array = $this->getStockByName($em, $userId, $order);
            } 
            
            $stringQuery =
                "SELECT DISTINCT 
                p.productId, p.productName, p.productPrice, p.productDescription, p.productImage, 
                pt.producttypeId, pt.producttypeName, 
                a.userId artistId, a.userName artistName, u.userId, u.userName 
                    
                FROM HomeBundle:Product p 

                JOIN HomeBundle:User u 
                WITH u.userId = p.user 

                JOIN HomeBundle:Producttype pt 
                WITH pt.producttypeId = p.producttype 

                JOIN HomeBundle:User a 
                WITH p.artist = a.userId 

                WHERE u.userId = '$userId' ".$order_array;
        
            $stockInformation = $em->createQuery(
                $stringQuery
            );
            $stockInformation_v = $stockInformation->getResult();
            
            $amountProducts = count($stockInformation_v);
            
            $i = 0;
            while (isset($stockInformation_v[$i]['productId'])) {

                if ($stockInformation_v) {
                    
                    if (
                        file_exists("files/products/".$stockInformation_v[$i]['userId'].
                        "/".$stockInformation_v[$i]['productImage'])
                    )
                    {
                        $productImage_Value = $stockInformation_v[$i]['productImage'];
                    }
                    else
                    {
                        $productImage_Value = "_";
                    }
                    
                    $productId_Value = $stockInformation_v[$i]['productId'];
                    $productName_Value = $stockInformation_v[$i]['productName'];
                    $productPrice_Value = $stockInformation_v[$i]['productPrice'];
                    $productDescription_Value = $stockInformation_v[$i]['productDescription'];
                    $producttypeId_Value = $stockInformation_v[$i]['producttypeId']; 
                    $producttypeName_Value = $stockInformation_v[$i]['producttypeName'];
                    $artistId_Value = $stockInformation_v[$i]['artistId'];
                    $artistName_Value = $stockInformation_v[$i]['artistName'];
                    $userId_Value = $stockInformation_v[$i]['userId'];
                    $userName_Value = $stockInformation_v[$i]['userName'];
                    
                    $salesAmount = $this->getSalesReport($daysAmount, $em, $productId_Value);
                    $stockAmount = $this->getStockReport($em, $productId_Value);
                } else {
                    $productId_Value = "_";
                    $productName_Value = "_";
                    $productPrice_Value = "_";
                    $productDescription_Value = "_";
                    $productImage_Value = "_";
                    $producttypeId_Value = "_";
                    $producttypeName_Value = "_";
                    $artistId_Value = "_";
                    $artistName_Value = "_";
                    $userId_Value = "_";
                    $userName_Value = "_";
                    $salesAmount = 0;
                    $stockAmount = 0;
                }

                $sendData[$i] = array(
                    'productId' => $productId_Value,
                    'productName'=> $productName_Value,
                    'productPrice' => $productPrice_Value,
                    'productDescription' => $productDescription_Value,
                    'productImage' => $productImage_Value,
                    'producttypeId' => $producttypeId_Value,
                    'producttypeName' => $producttypeName_Value,
                    'artistId' => $artistId_Value,
                    'artistName' => $artistName_Value,
                    'userId' => $userId_Value,
                    'userName' => $userName_Value,
                    'amountProducts' => $amountProducts,
                    'salesAmount' => $salesAmount,
                    'stockAmount' => $stockAmount
                );
//                array_multisort($sendData['productId'], SORT_ASC, SORT_NUMERIC);
//                usort($sendData, 'productId');
                $i++;
            }
            
            if ($i == 0)
            {
                $sendData[0] = array(
                    'productId' => "_",
                    'productName'=> "_",
                    'productPrice' => "_",
                    'productDescription' => "_",
                    'productImage' => "_",
                    'producttypeId' => "_",
                    'producttypeName' => "_",
                    'artistId' => "_",
                    'artistName' => "_",
                    'userId' => "_",
                    'userName' => "_",
                    'amountProducts' => $amountProducts,
                    'salesAmount' => $salesAmount,
                    'stockAmount' => $stockAmount
                );
            }
            
            
            
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function getStockByName($em, $userId, $order)
    {
        
        if ($order == 1)
        {





            $order_array = " ORDER BY p.productName ASC";
        } else
        {
            $order_array = " ORDER BY p.productName DESC";
        }
        
        return $order_array;
    }

    public function getStockByType($em, $userId, $order)
    {
        
        if ($order == 1)
        {
            $order_array = " ORDER BY pt.producttypeName ASC";
        } else
        {
            $order_array = " ORDER BY pt.producttypeName DESC";
        }
        
        return $order_array;
    }

    public function getStockReport($em, $productId_Value)
    {
        $stockProduct = $em->createQuery(
            "SELECT s.stockId, s.stockAmount 

            FROM HomeBundle:Stock s 
            
            JOIN HomeBundle:Product p 
            WITH s.product = p.productId 

            WHERE p.productId = '$productId_Value'"
        );
        $stockProduct_v = $stockProduct->getResult();
        if (isset($stockProduct_v[0]['stockId']))
        {
            $stockChecking = 0;
            $stockAmount = 0;
            while (isset($stockProduct_v[$stockChecking]['stockId'])) {
                $stockAmount += $stockProduct_v[$stockChecking]['stockAmount']; 
                $stockChecking++;
            }
            
        } else
        {
            $stockAmount = 0;
        }
        
        return $stockAmount;
    }
    
    public function getSalesReport($daysAmount, $em, $productId_Value)
    {
        $todayDate = date("Y-m-d");
        $initialRankDate = strtotime('-'.$daysAmount.' day', strtotime($todayDate));
        $initialRankDate_v2 = date ("Y-m-d", $initialRankDate);
        
        $sellingProduct = $em->createQuery(
            "SELECT sp.sellingproductId, sp.sellingproductDate 

            FROM HomeBundle:Sellingproduct sp 
            
            JOIN HomeBundle:Product p 
            WITH sp.product = p.productId 

            WHERE sp.sellingproductDate >= '$initialRankDate_v2' and p.productId = '$productId_Value'"
        );
        $sellingProduct_v = $sellingProduct->getResult();

        if (isset($sellingProduct_v[0]['sellingproductId']))
        {
            $salesAmount = count($sellingProduct_v);
        } else
        {
            $salesAmount = 0;
        }
        
        return $salesAmount;
    }
    
    public function drawImagesAboutStockAction(Request $request)
    {
        $productId = $_POST['productId'];
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $stockInformation_images = $em->createQuery(
                "SELECT p.productId, pi.productimageId, pi.productimageImage, u.userId 
                FROM HomeBundle:Product p 

                JOIN HomeBundle:Productimage pi 
                WITH pi.product = p.productId 

                JOIN HomeBundle:User u 
                WITH u.userId = p.user 

                WHERE p.productId = '$productId'"
            );
            $stockInformation_images_v = $stockInformation_images->getResult();

            $amountImages = count($stockInformation_images_v);
            
            $i = 0;
            while (isset($stockInformation_images_v[$i]['productId'])) {

                if ($stockInformation_images_v) {
                    if (
                        file_exists("files/products/secondaryImages/".$stockInformation_images_v[$i]['userId'].
                        "/".$stockInformation_images_v[$i]['productId'].
                        "/".$stockInformation_images_v[$i]['productimageImage'])
                    )
                    {
                        $productimageImage_Value = $stockInformation_images_v[$i]['productimageImage'];
                    }
                    else
                    {
                        $productimageImage_Value = "_";
                    }
                    $productimageId_Value = $stockInformation_images_v[$i]['productimageId'];
                    $userId_Value = $stockInformation_images_v[$i]['userId'];
                    $productId_Value = $stockInformation_images_v[$i]['productId'];
                } else {
                    $productimageId_Value = "_";
                    $productimageImage_Value = "_";
                    $userId_Value = "_";
                    $productId_Value = "_";
                }

                $sendData[$i] = array(
                    'productimageId' => $productimageId_Value,
                    'productimageImage' => $productimageImage_Value,
                    'userId' => $userId_Value,
                    'productId' => $productId_Value,
                    'amountImages' => $amountImages
                );
                $i++;
            }
            
            if ($i == 0)
            {
                $sendData[0] = array(
                    'productimageId' => "_",
                    'productimageImage' => "_",
                    'userId' => "_",
                    'productId' => "_",
                    'amountImages' => $amountImages
                );
            }
            
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getStockId($stockId)
    {
        $em = $this->getDoctrine()->getManager();

        $stockInformation = $em->createQuery(
            "SELECT s.stockId 
            FROM HomeBundle:Stock s 
            WHERE s.stockId = '$stockId'"
        );
        $stockInformation_v = $stockInformation->getResult();
        
        if ($stockInformation_v[0]['stockId'])
        {
            $stockId_value = $stockInformation_v[0]['stockId'];               
        } else
        {
            $stockId_value = "_";
        }
        
        return $stockId_value;
    }
    
}
