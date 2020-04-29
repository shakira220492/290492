<?php

namespace StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Store/Default/index.html.twig');
    }
    
    public function pruebasdfAction()
    {

//        
//            $em = $this->getDoctrine()->getEntityManager();
//            $db = $em->getConnection();
//            $query = "SELECT DISTINCT country_id, country_name, "
//                    . "count(country_name) as cantidad, "
//                    . "count(*) as amountCountries FROM Country";
//            $stmt = $db->prepare($query);
//            $params = array();
//            $stmt->execute($params);
//            
//            $cursos = $stmt->fetchAll();
//            
//            $j=0;
//            foreach($cursos as $curso)
//            {
//                $sendData[] = array(
//                    'countryId' => $curso["country_id"],
//                    'countryName' => $curso["country_name"],
//                    'cantidad' => $curso["cantidad"],
//                    'amountCountries' => $curso["amountCountries"]
//                );
//                $j++;
////                print_r("este es el array: ".$sendData);
//            }
        

    }


    public function addToShoppingCartAction(Request $request)
    {
        $productId = $_POST["productId"];
        $amountProducts = $_POST["amountProducts"];
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
                
                $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);
                $product = $em->getRepository('HomeBundle:Product')->findOneByProductId($productId);

                $todayDate = date("Y-m-d");
                $todayDate_format = date_create_from_format('Y-m-d', $todayDate);

                $selectedProduct = new \HomeBundle\Entity\Selectedproduct();
                $selectedProduct->setProduct($product);
                $selectedProduct->setUser($user);
                $selectedProduct->setSelectedproductDate($todayDate_format);
                $selectedProduct->setSelectedproductAmount($amountProducts);

                $em->persist($selectedProduct);
                $em->flush();
                
                $selectedproductId = $selectedProduct->getSelectedproductId();
                $selectedproductDate = $selectedProduct->getSelectedproductDate();
                $selectedproductDateString = $selectedproductDate->format('d-M-Y');
                $selectedproductAmount = $selectedProduct->getSelectedproductAmount();
            } else
            {
                
            }
            
            $users2 = array();
            $users2[0] = array(
                'selectedproductId' => $selectedproductId,
                'selectedproductDate' => $selectedproductDateString,
                'selectedproductAmount' => $selectedproductAmount
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function deleteSelectedProductAction(Request $request)
    {
        $selectedProductId = $_POST["selectedProductId"];
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $selectedproduct = $em->getRepository('HomeBundle:Selectedproduct')->findOneBySelectedproductId($selectedProductId);
            $em->remove($selectedproduct);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getSelectedProductsAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
                
                $selectedProduct = $em->createQuery(
                    "SELECT DISTINCT sp.selectedproductId, sp.selectedproductDate, sp.selectedproductAmount, 
                        p.productId, p.productName, p.productPrice, 
                        p.productDescription, p.productImage 
                    FROM HomeBundle:Selectedproduct sp 

                    JOIN HomeBundle:Product p 
                    WITH p.productId = sp.product 

                    JOIN HomeBundle:User u 
                    WITH u.userId = sp.user 

                    WHERE u.userId = '$userId'
                    "
                );
                
                $selectedProductInstance = $selectedProduct->getResult();

                $amountSelectedProducts = 0;

                while (isset($selectedProductInstance[$amountSelectedProducts]['selectedproductId'])) {
                    $amountSelectedProducts++;
                }

                $i = 0;
                while (isset($selectedProductInstance[$i]['selectedproductId'])) {
                    $selectedproductDate = $selectedProductInstance[$i]['selectedproductDate'];
                    $selectedproductDateString = $selectedproductDate->format('d-M-Y');
                    
                    $selectedproductId_Value = $selectedProductInstance[$i]['selectedproductId'];
                    $selectedproductDate_Value = $selectedproductDateString;
                    $selectedproductAmount_Value = $selectedProductInstance[$i]['selectedproductAmount'];
                    $productId_Value = $selectedProductInstance[$i]['productId'];
                    $productName_Value = $selectedProductInstance[$i]['productName'];
                    $productPrice_Value = $selectedProductInstance[$i]['productPrice'];
                    $productDescription_Value = $selectedProductInstance[$i]['productDescription'];
                    $productImage_Value = $selectedProductInstance[$i]['productImage'];

                    if (file_exists("files/products/".$selectedProductInstance[$i]['productImage']))
                    {
                        $productImage_Value = $selectedProductInstance[$i]['productImage'];
                    } else
                    {
                        $productImage_Value = "decline.png";
                    }
                    
                    $sendData[$i] = array(
                        'selectedproductId' => $selectedproductId_Value,
                        'selectedproductDate' => $selectedproductDate_Value,
                        'selectedproductAmount' => $selectedproductAmount_Value,
                        'productId' => $productId_Value,
                        'productName' => $productName_Value,
                        'productPrice' => $productPrice_Value,
                        'productDescription' => $productDescription_Value,
                        'productImage' => $productImage_Value,
                        'amountSelectedProducts' => $amountSelectedProducts
                    );

                    $i++;
                }

                if ( $i === 0 )
                {
                    $selectedproductId_Value = "_";
                    $selectedproductDate_Value = "_";
                    $selectedproductAmount_Value = "_";
                    $productId_Value = "_";
                    $productName_Value = "_";
                    $productPrice_Value = "_";
                    $productDescription_Value = "_";
                    $productImage_Value = "_";

                    $sendData[0] = array(
                        'selectedproductId' => $selectedproductId_Value,
                        'selectedproductDate' => $selectedproductDate_Value,
                        'selectedproductAmount' => $selectedproductAmount_Value,
                        'productId' => $productId_Value,
                        'productName' => $productName_Value,
                        'productPrice' => $productPrice_Value,
                        'productDescription' => $productDescription_Value,
                        'productImage' => $productImage_Value,
                        'amountSelectedProducts' => $amountSelectedProducts
                    );
                }

            } else
            {
                $selectedproductId_Value = "_";
                $selectedproductDate_Value = "_";
                $selectedproductAmount_Value = "_";
                $productId_Value = "_";
                $productName_Value = "_";
                $productPrice_Value = "_";
                $productDescription_Value = "_";
                $productImage_Value = "_";

                $sendData[0] = array(
                    'selectedproductId' => $selectedproductId_Value,
                    'selectedproductDate' => $selectedproductDate_Value,
                    'selectedproductAmount' => $selectedproductAmount_Value,
                    'productId' => $productId_Value,
                    'productName' => $productName_Value,
                    'productPrice' => $productPrice_Value,
                    'productDescription' => $productDescription_Value,
                    'productImage' => $productImage_Value,
                    'amountSelectedProducts' => 0
                );
            }
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function identifyKeywordAction(Request $request)
    {
        
        $keyword = $_POST["keyword"];
            
        if ($request->isXMLHttpRequest()) {
        
            $em2 = $this->getDoctrine()->getEntityManager();
            $db2 = $em2->getConnection();
            $query_keyword = "
                SELECT DISTINCT 
                    concat( 
                        'Keyword: ', 
                        '(', 
                            Keyword.keyword_id, 
                            ' - ', 
                            Keyword.keyword_content, 
                            ' - ', 
                            Product.product_id, 
                        ')' 
                    ) as individual_description, 
                    Product.product_id as found_product_id 

                    FROM
                        Keyword as Keyword

                        INNER JOIN KeywordProduct ON Keyword.keyword_id = KeywordProduct.keyword_id 
                        INNER JOIN Product ON Product.product_id = KeywordProduct.product_id 
                    WHERE Keyword.keyword_content = '$keyword' 
                    GROUP BY individual_description";
            $query_artist = "
                SELECT DISTINCT 
                    concat( 
                        'KeywordArtist: ', KeywordArtist.keywordArtist_id, 
                        '(', 
                            User.user_id, 
                            ' - ', 
                            User.user_name, 
                            ' - ', 
                            Keyword.keyword_id, 
                            ' - ', 
                            Keyword.keyword_content, 
                            ' - ', 
                            Product.product_id, 
                        ')' 
                    ) as individual_description, 
                    Product.product_id as found_product_id 

                    FROM
                        Keyword 

                        INNER JOIN KeywordArtist ON KeywordArtist.keyword_id = Keyword.keyword_id 
                        INNER JOIN User ON KeywordArtist.user_id = User.user_id 
                        INNER JOIN Product ON Product.artist_id = User.user_id 

                    WHERE Keyword.keyword_content = '$keyword' 
                    GROUP BY individual_description ";
            $query_productType = "
                SELECT DISTINCT 
                    concat( 
                        'KeywordProductType: ', KeywordProductType.keywordProductType_id, 
                        '(', 
                            ProductType.productType_id, 
                            ' - ', 
                            ProductType.productType_name, 
                            ' - ', 
                            Keyword.keyword_id, 
                            ' - ', 
                            Keyword.keyword_content, 
                            ' - ', 
                            Product.product_id, 
                        ')' 
                    ) as individual_description, 
                    Product.product_id as found_product_id 
                    
                    FROM
                        Keyword 
                        
                    INNER JOIN KeywordProductType ON KeywordProductType.keyword_id = Keyword.keyword_id 
                    INNER JOIN ProductType ON ProductType.productType_id = KeywordProductType.productType_id 
                    INNER JOIN Product ON Product.productType_id = ProductType.productType_id 

                    WHERE Keyword.keyword_content = '$keyword' 
                    GROUP BY individual_description ";
            $query_song = "
                SELECT DISTINCT 
                    concat( 
                        'KeywordVideo: ', KeywordVideo.keywordVideo_id, 
                        '(', 
                            Video.video_id, 
                            ' - ', 
                            Video.video_name, 
                            ' - ', 
                            Keyword.keyword_id, 
                            ' - ', 
                            Keyword.keyword_content, 
                            ' - ', 
                            Product.product_id, 
                        ')' 
                    ) as individual_description, 
                    Product.product_id as found_product_id 
                    
                    FROM
                        Keyword 
                        
                    INNER JOIN KeywordVideo ON KeywordVideo.keyword_id = Keyword.keyword_id 
                    INNER JOIN Video ON Video.video_id = KeywordVideo.video_id 
                    INNER JOIN Product ON Product.song_id = Video.video_id 

                    WHERE Keyword.keyword_content = '$keyword' 
                    GROUP BY individual_description ";
            $query2 = "
                SELECT DISTINCT
                    description, 
                    found_product_id, 
                    found_product_score, 
                    found_sales_amount, 
                    found_search_results, 
                    found_images_amount, 
                    Product.product_name as found_product_name, 
                    Product.product_price as found_product_price, 
                    Product.product_description as found_product_description, 
                    Product.product_image as found_product_image, 
                    sum(Product.product_id) as found_total_products 
                FROM 
                (
                SELECT DISTINCT
                    description, 
                    found_product_id, 
                    found_product_score, 
                    found_sales_amount, 
                    found_search_results, 
                    count(ProductImage.ProductImage_id) as found_images_amount 
                FROM
                (
                    SELECT DISTINCT 
                        description, 
                        found_product_id, 
                        IFNULL(CAST(avg(ProductScore.productScore_punctuation) AS INT), 0) as found_product_score,  
                        found_sales_amount, 
                        found_search_results 
                    FROM 
                    ( 
                        SELECT DISTINCT 
                            description, 
                            found_product_id, 
                            count(SellingProduct.product_id) as found_sales_amount, 
                            found_search_results 
                        FROM 
                        ( 

                            SELECT DISTINCT 
                                GROUP_CONCAT(individual_description) as description, 
                                found_product_id, 
                                count(individual_description) as found_search_results 
                            FROM 
                            (
                            ".
                            $query_keyword.
                            "
                            UNION ALL 
                            ".
                            $query_artist.
                            "
                            UNION ALL 
                            ".
                            $query_productType.
                            "
                            UNION ALL 
                            ".
                            $query_song.
                            "
                            ) TBL
                            GROUP BY found_product_id 
                            ORDER BY found_search_results DESC 
                        ) T
                        LEFT JOIN SellingProduct ON SellingProduct.product_id = found_product_id 
                        GROUP BY found_product_id 
                        ORDER BY found_sales_amount DESC 
                    ) TV
                    LEFT JOIN ProductScore ON ProductScore.product_id = found_product_id 
                    GROUP BY found_product_id 
                    ORDER BY found_product_score DESC 
                ) TVT
                LEFT JOIN ProductImage ON ProductImage.product_id = found_product_id 
                GROUP BY found_product_id 
                ORDER BY found_images_amount DESC 
                )TBTB
            LEFT JOIN Product ON Product.product_id = found_product_id 
            GROUP BY Product.product_id 
            ORDER BY Product.product_id DESC 
            LIMIT 0, 50 
            ";
            

            

            $stmt2 = $db2->prepare($query2);
            $params2 = array();
            $stmt2->execute($params2);
            
            $cursos2 = $stmt2->fetchAll();
            
            foreach($cursos2 as $curso)
            {
                if (file_exists("files/products/".$curso["found_product_image"]))
                {
                    $found_product_image = $curso["found_product_image"];
                } else
                {
                    $found_product_image = "decline.png";
                }
                $sendData[] = array(
                    'description' => $curso["description"],
                    'found_sales_amount' => $curso["found_sales_amount"],
                    'found_product_score' => $curso["found_product_score"],
                    'found_search_results' => $curso["found_search_results"],
                    'found_images_amount' => $curso["found_images_amount"],
                    'found_product_id' => $curso["found_product_id"],
                    'found_product_name' => $curso["found_product_name"],
                    'found_product_price' => $curso["found_product_price"],
                    'found_product_description' => $curso["found_product_description"],
                    'found_product_image' => $found_product_image,
                    'found_total_products' => $curso["found_total_products"]
                );
            }
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function get_artist($em, $keyword)
    {
        $artist_query = $em->createQuery(
            "SELECT DISTINCT a.userId, k.keywordId, k.keywordContent, ka.keywordartistId 
            FROM HomeBundle:User a 

            JOIN HomeBundle:Keywordartist ka 
            WITH a.userId = ka.user 

            JOIN HomeBundle:Keyword k 
            WITH k.keywordId = ka.keyword 

            WHERE k.keywordContent = '$keyword' 

            ORDER BY 
            a.userScore DESC 
            "
        )
        ->setFirstResult(0)
        ->setMaxResults(1);

        $artist_queryInstance = $artist_query->getResult();
    }
    
    
    public function get_productType($em, $keyword)
    {
        $productType_query = $em->createQuery(
            "SELECT DISTINCT pt.producttypeId, k.keywordId, k.keywordContent, kpt.keywordproducttypeId
            FROM HomeBundle:Producttype pt 

            JOIN HomeBundle:Keywordproducttype kpt 
            WITH pt.producttypeId = kpt.producttype 

            JOIN HomeBundle:Keyword k 
            WITH k.keywordId = kpt.keyword 

            WHERE k.keywordContent = '$keyword' 

            ORDER BY 
            pt.producttypeScore DESC 
            "
        )
        ->setFirstResult(0)
        ->setMaxResults(1);

        $productType_queryInstance = $productType_query->getResult();
    }
    
    
    public function get_video($em, $keyword)
    {
        $video_query = $em->createQuery(
            "SELECT DISTINCT v.videoId, k.keywordId, k.keywordContent, kv.keywordvideoId 
            FROM HomeBundle:Video v 

            JOIN HomeBundle:Keywordvideo kv 
            WITH v.videoId = kv.video 

            JOIN HomeBundle:Keyword k 
            WITH k.keywordId = kv.keyword 

            WHERE k.keywordContent = '$keyword' 

            ORDER BY 
            v.videoScore DESC 
            "
        )
        ->setFirstResult(0)
        ->setMaxResults(1);

        $video_queryInstance = $video_query->getResult();
    }
    
    public function getProductDetailsAction(Request $request)
    {
        $productId = $_POST["productId"];
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $selectedProduct = $em->createQuery(
                "SELECT DISTINCT pi.productimageId, pi.productimageImage, u.userId 
                FROM HomeBundle:Product p 

                JOIN HomeBundle:Productimage pi 
                WITH p.productId = pi.product 
                
                JOIN HomeBundle:User u 
                WITH p.user = u.userId 

                WHERE p.productId = '$productId'
                "
            );

            $selectedProductInstance = $selectedProduct->getResult();

            $amountImages = count($selectedProductInstance);

            $i = 0;
            while (isset($selectedProductInstance[$i]['productimageId'])) {
                
                $productimageId_Value = $selectedProductInstance[$i]['productimageId'];
                $productimageImage_Value = $selectedProductInstance[$i]['productimageImage'];
                $userId_Value = $selectedProductInstance[$i]['userId'];

                $sendData[$i] = array(
                    'productimageId' => $productimageId_Value, 
                    'productimageImage' => $productimageImage_Value, 
                    'userId' => $userId_Value, 
                    'amountImages' => $amountImages 
                );

                $i++;
            }

            if ( $i === 0 )
            {
                $sendData[$i] = array(
                    'productimageId' => 0, 
                    'productimageImage' => "decline.png", 
                    'userId' => 0, 
                    'amountImages' => 0 
                );
            }
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
}
