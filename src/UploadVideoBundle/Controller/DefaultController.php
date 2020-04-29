<?php

namespace UploadVideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
//        return $this->render('UploadVideoBundle/Default/index.html.twig');
        return $this->render('@UploadVideo/Default/index.html.twig');
    }
    
    public function uploadVideoAction(Request $request)
    {
        
        $videoId = $_POST['video_id'];
        $userId = $_POST['user_id'];
        
        $carpeta = "files/".$userId."/".$videoId."/";
        
        if (!file_exists($carpeta))
        {
            mkdir($carpeta, 0777);
        }
        
        opendir($carpeta);

        $video_status = "";
        $image_status = "";
        
        $filenameVideo = $_FILES['video_content']['tmp_name'];
//        $destinationVideo = $carpeta . $_FILES['video_content']['name'];
        $typeVideo = $_FILES['video_content']['type'];
        if ($typeVideo == "video/mp4") {
            $destinationVideo = $carpeta . $videoId . ".mp4";
            move_uploaded_file($filenameVideo, $destinationVideo);
        }

        $filenameImage = $_FILES['video_portrait']['tmp_name'];
//        $destinationImage = $carpeta . $_FILES['video_portrait']['name']."_hello";
        $typeImage = $_FILES['video_portrait']['type'];
        if ($typeImage == "image/jpeg" OR $typeImage == "image/jpg" OR $typeImage == "image/png") {
            if($typeImage == "image/jpeg")
            {
                $destinationImage = $carpeta . $videoId . ".jpeg";
            }
            if($typeImage == "image/jpg")
            {
                $destinationImage = $carpeta . $videoId . ".jpg";
            }
            if($typeImage == "image/png")
            {
                $destinationImage = $carpeta . $videoId . ".png";
            }
            move_uploaded_file($filenameImage, $destinationImage);
        }
        

        
        $response = array();
        $response[0] = array(
            'video_status' => $video_status,
            'image_status' => $image_status
        );
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
        
    public function updateVideoAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $video_name_data = $_POST['video_name'];
            $video_description_data = $_POST['video_description'];
            $video_content_data = $_FILES['video_content']['name'];
            $video_portrait_data = $_FILES['video_portrait']['name'];

            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
            }
            else {
                $userId = 0;
            }

            $todayDate = date("Y-m-d");
            $videoUpdatedate = date_create_from_format('Y-m-d', $todayDate);

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);

            $video = new \HomeBundle\Entity\Video();
            
            $video->setUser($user);
            $video->setVideoAmountComments(0);
            $video->setVideoAmountViews(0);
            $video->setVideoContent($video_content_data);
            $video->setVideoDescription($video_description_data);
            $video->setVideoImage($video_portrait_data);
            $video->setVideoScore(0);
            $video->setVideoName($video_name_data);
            $video->setVideoUpdatedate($videoUpdatedate);
            $video->setVideoCoinScore(0);
            $video->setVideoPeoplescore(0);
            
            $em->persist($video);
            $em->flush();

            $video_user_id = $video->getUser();
            $video_id = $video->getVideoId();
            $video_amount_comments = $video->getVideoAmountComments();
            $video_amount_views = $video->getVideoAmountViews();
            $video_content = $video->getVideoContent();
            $video_description = $video->getVideoDescription();
            $video_image = $video->getVideoImage();
            $video_score = $video->getVideoScore();
            $video_name = $video->getVideoName();
            $video_update_date = $video->getVideoUpdatedate();
            $video_coin_score = $video->getVideoCoinScore();
            $video_people_score = $video->getVideoPeoplescore();
            
            $response[0] = array(
                'user' => $userId,
                'videoId' => $video_id,
                'videoAmountComments' => $video_amount_comments,
                'videoAmountViews' => $video_amount_views,
                'videoContent' => $video_content,
                'videoDescription' => $video_description,
                'videoImage' => $video_image,
                'videoScore' => $video_score,
                'videoName' => $video_name,
                'videoUpdatedate' => $video_update_date,
                'videoCoinScore' => $video_coin_score,
                'videoPeopleScore' => $video_people_score
            );
            
            return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
            
        }
    }
    
    public function uploadKeywordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentKeyword_2 = $_POST['currentKeywordContent'];
        $videoId = $_POST['videoId'];

        // me retira (espacios en blanco, saltos de linea, etc) que haya al inicio de la variable $keywords_entered
        $currentKeyword_1 = ltrim($currentKeyword_2);

        // me retira (espacios en blanco, saltos de linea, etc) que haya al final de la variable $keywords_entered
        $keywords_entered = rtrim($currentKeyword_1);
        
        $characters_entered_amount = $this->getCharactersEnteredAmount($keywords_entered);
        
        $word_entered = array();
        $word_entered = $this->separateKeywords($keywords_entered);
        
        $this->setKeyword($em, $word_entered, $characters_entered_amount);
        $this->set_keywordVideo($em, $characters_entered_amount, $word_entered, $videoId);
            
        if ($request->isXMLHttpRequest()) {
            $response = array();
            $response[] = array(
                'keywordId' => "-",
                'keywordVideoId' => "-"
            );

            return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getCharactersEnteredAmount($keywords_entered)
    {
        $characters_entered_amount = 0;
        if ($keywords_entered) {
            for ($i = 0; $i < strlen($keywords_entered); $i++) {
                if ($keywords_entered[$i] == " ") {
                    $previous = $i - 1;

                    if ($keywords_entered[$previous] == " ") {

                    } else {
                        $characters_entered_amount++; // creo que esto es pa contar la cantidad de palabras
                    }
                } else {
                }
            }
        }
        return $characters_entered_amount;
    }

    public function separateKeywords($keywords_entered)
    {
        $word_entered = array();
        if ($keywords_entered) {
            $characters_entered_amount = 0;
            $temporal_word = "";

            for ($i = 0; $i < strlen($keywords_entered); $i++) {
                //si llegase a existir un espacio entre la frase que se escribió en el buscador,
                //entonces que me ejecute lo siguiente:
                if ($keywords_entered[$i] == " ") {
                    $temporal_word = "";
                    $previous = $i - 1;

                    //si el caracter actual y el caracter anterior son espacios en blanco
                    if ($keywords_entered[$previous] == " ") {

                    } else {
                        //si el caracter actual es espacio en blanco,
                        //pero el caracter anterior NO es espacio en blanco
                        $characters_entered_amount++; // creo que esto es pa contar la cantidad de palabras
                    }
                } else {
                    $temporal_character = $keywords_entered[$i];
                    $temporal_word .= $temporal_character;
                    $word_entered[$characters_entered_amount] = $temporal_word;
                }
            }
        }
        return $word_entered;
    }
    
    
    
    
    public function setKeyword($em, $word_entered, $characters_entered_amount)
    {
        $keywordContent = "";
        for ($i = 0; $i <= $characters_entered_amount; $i++)
        {
            $keywordContent.=$word_entered[$i]." ";
        }
        
        $currentKeyword = $em->createQuery(
            "SELECT k.keywordId, k.keywordScore 
            FROM HomeBundle:Keyword k 
            WHERE k.keywordContent = '$keywordContent'"
        );
        
        $currentKeyword_e = $currentKeyword->getResult();
        
        if (isset($currentKeyword_e[0]['keywordId'])) {
            $keywordId = $currentKeyword_e[0]['keywordId'];
            $keywordScore = $currentKeyword_e[0]['keywordScore'];
            
            $this->incrementar_keyword_score($em, $keywordId, $keywordScore);
        } else
        {
            $this->insertar_keyword($em, $keywordContent);
        }
    }
                  
    public function incrementar_keyword_score($em, $keywordId, $keywordScore)
    {
        $new_keywordScore = $keywordScore + 1;
        $keyword = $em->getRepository('HomeBundle:Keyword')->findOneByKeywordId($keywordId);
        $keyword->setKeywordScore($new_keywordScore);
        $em->persist($keyword);
        $em->flush();
    }

    public function insertar_keyword($em, $keywordContent)
    {
        $keyword = new \HomeBundle\Entity\Keyword;
        $keyword->setKeywordContent($keywordContent);
        $keyword->setKeywordScore(0);
        $em->persist($keyword);
        $em->flush();
    }
    
    
    
    
    public function set_keywordVideo($em, $characters_entered_amount, $word_entered, $videoId)
    {
        $keywordContent = "";
        for ($i = 0; $i <= $characters_entered_amount; $i++)
        {
            $keywordContent.=$word_entered[$i]." ";
        }
        
        $keyword = $em->getRepository('HomeBundle:Keyword')->findOneByKeywordContent($keywordContent);
        $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($videoId);
        
        $keywordVideo = new \HomeBundle\Entity\Keywordvideo;
        $keywordVideo->setKeyword($keyword);
        $keywordVideo->setVideo($video);
        $em->persist($keywordVideo);
        $em->flush();
    }
    
    
}