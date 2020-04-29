<?php

namespace PlayBannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@PlayBanner/Default/index.html.twig');
    }
    
    public function getVideoSpeedAction(Request $request)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        $geolocalization = $_SERVER["REMOTE_ADDR"];

        if ($request->isXMLHttpRequest()) {
        
            if ($userId === 0)
            {
                $em = $this->getDoctrine()->getManager();
                
                $windowByGeolocalization = $em->createQuery(
                    "SELECT w.windowId, w.windowVideospeed, w.windowGeolocalization 
                    FROM HomeBundle:Window w 
                    JOIN HomeBundle:User u 
                    WITH w.user = u.userId
                    WHERE w.windowGeolocalization = '$geolocalization'
                    "
                );
                
                $windowByGeolocalization_e = $windowByGeolocalization->getResult();
                
                if (isset($windowByGeolocalization_e[0]['windowId'])) 
                {
                    // windowByGeolocalization
                    $windowId_Value = $windowByGeolocalization_e[0]['windowId'];
                    $windowVideospeed_Value = $windowByGeolocalization_e[0]['windowVideospeed'];
                    $windowGeolocalization_Value = $windowByGeolocalization_e[0]['windowGeolocalization'];

                    $sendData = array();
                    $sendData[0] = array(
                        'windowId' => $windowId_Value,
                        'windowVideospeed' => $windowVideospeed_Value,
                        'windowGeolocalization' => $windowGeolocalization_Value
                    );
                } else
                {
                    // windowByDefault
                    $sendData = array();
                    $sendData[0] = array(
                        'windowId' => "_",
                        'windowVideospeed' => "_",
                        'windowGeolocalization' => "_"
                    );
                }
            } 
            else 
            {
                $em = $this->getDoctrine()->getManager();
                
                $windowByUser = $em->createQuery(
                    "SELECT w.windowId, w.windowVideospeed, w.windowGeolocalization 
                    FROM HomeBundle:Window w 
                    JOIN HomeBundle:User u 
                    WITH w.user = u.userId 
                    WHERE u.userId = '$userId'"
                );
                
                $windowByUser_e = $windowByUser->getResult();
                
                
                if (isset($windowByUser_e[0]['windowId'])) 
                {
                    // windowByUser
                    $windowId_Value = $windowByUser_e[0]['windowId'];
                    $windowVideospeed_Value = $windowByUser_e[0]['windowVideospeed'];
                    $windowGeolocalization_Value = $windowByUser_e[0]['windowGeolocalization'];

                    $sendData = array();
                    $sendData[0] = array(
                        'windowId' => $windowId_Value,
                        'windowVideospeed' => $windowVideospeed_Value,
                        'windowGeolocalization' => $windowGeolocalization_Value
                    );
                    
                    
                } else
                {
                    // windowByDefault
                    $sendData = array();
                    $sendData[0] = array(
                        'windowId' => "_",
                        'windowVideospeed' => "_",
                        'windowGeolocalization' => "_"
                    );
                }
                
            }
            
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function setVideoSpeedAction(Request $request)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $video_speed = $_POST['video_speed'];
            $geolocalization = $_SERVER["REMOTE_ADDR"];
            
            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);
            
            
            // si no existe el window, entonces crearla 
            
            
            $window = $em->getRepository('HomeBundle:Window')->findOneByUser($user);
            
            if (!$window)
            {
                $window = new \HomeBundle\Entity\Window;
                $window->setUser($user);
                $window->setWindowConfigurationareasize(0);
                $window->setWindowGeolocalization($geolocalization);
                $window->setWindowVideosize(0);
                $window->setWindowVideospeed($video_speed);
                $window->setWindowVolume(0);
                
                $em->persist($window);
                $em->flush();
            } else {
                $window->setWindowGeolocalization($geolocalization);
                $window->setWindowVideospeed($video_speed);
                $window->setUser($user);

                $em->persist($window);
                $em->flush();
            }
            
            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getCurrentListAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $kindOfList = $_POST['kindOfList'];
            $listId = $_POST['listId'];

            $em = $this->getDoctrine()->getManager();
            
            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
                $useripId = 0;
            }
            else {
                $userId = 0;
                $useripId = $this->get_useripId($em);
            }
            
            $videosInformation[0] = array();
                
            
            if ($kindOfList === "listBundle")
            {
                $videosInformation = $this->get_listBundle($listId, $em, $userId, $useripId);
            }


            if ($kindOfList === "dataminingBundle") // funciona
            {
                $videosInformation = $this->get_dataminingBundle($listId, $em, $userId, $useripId);
            }
            

            if ($kindOfList === "artistBundle")
            {
                $videosInformation = $this->get_artistBundle($listId, $em, $userId, $useripId);
            }


            if ($kindOfList === "searchResults")
            {
                $videosInformation = $this->get_searchResults($listId, $em, $userId, $useripId);
            }
            
                
            if ($kindOfList === "historyResults")
            {
                $videosInformation = $this->get_historyResults($listId, $em, $userId, $useripId);
            }


            if ($kindOfList === "dataminingResults")
            {
                $videosInformation = $this->get_dataminingResults($listId, $em, $userId, $useripId);
            }
            
            
            return new Response(json_encode($videosInformation), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function get_listBundle($listId, $em, $userId, $useripId)
    {
        $query = $em->createQuery(
            "SELECT 
            v.videoId, v.videoName, v.videoDescription, v.videoImage, 
            v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
            v.videoScore, v.videoAmountComments, 
            u.userId, u.userName 

            FROM HomeBundle:Specificlistvideo slv 

            JOIN HomeBundle:Video v 
            WITH slv.video = v.videoId 

            JOIN HomeBundle:Specificlist sl 
            WITH slv.specificlist = sl.specificlistId 

            JOIN HomeBundle:User u 
            WITH v.user = u.userId 

            WHERE sl.specificlistId = '$listId'"
        )
        ->setFirstResult(0)
        ->setMaxResults(30);
        
        $video_e = $query->getResult();

        $amountVideos = 0;
        while (isset($video_e[$amountVideos]['videoId'])) 
        {
            $amountVideos++;
        }
        $i = 0;

        while (isset($video_e[$i]['videoId'])) {
            if (
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoImage'])
                &&
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoContent'])                    
                )
            {
                $videoUpdatedate = $video_e[$i]['videoUpdatedate'];
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                $videoAmountViews = $video_e[$i]['videoAmountViews'];
                $videoAmountViewsFormat = number_format($videoAmountViews);

                $videoAmountComments = $video_e[$i]['videoAmountComments'];
                $videoAmountCommentsFormat = number_format($videoAmountComments);

                $videoId_Value = $video_e[$i]['videoId'];
                $videoName_Value = $video_e[$i]['videoName'];
                $videoDescription_Value = $video_e[$i]['videoDescription'];
                $videoImage_Value = $video_e[$i]['videoImage'];
                $videoContent_Value = $video_e[$i]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videoAmountViewsFormat;
                $videoAmountComments_Value = $videoAmountCommentsFormat;
                $videoScore_Value = $video_e[$i]['videoScore'];
                $userId_Value = $video_e[$i]['userId'];
                $userName_Value = $video_e[$i]['userName'];
            }
            else
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

            $videosInformation[$i] = array(
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
                'amountVideos' => $amountVideos
            );

            $i++;

        }

        if ($i === 0)
        {
            $videosInformation[0] = array(
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


        return $videosInformation;
    }
    
    public function get_dataminingBundle($listId, $em, $userId, $useripId)
    {
        $query = $em->createQuery(
            "SELECT DISTINCT 
            v.videoId, v.videoName, v.videoDescription, v.videoImage, 
            v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
            v.videoScore, v.videoAmountComments, 
            u.userId, u.userName 

            FROM HomeBundle:Video v 

            JOIN HomeBundle:User u 
            WITH u.userId = v.user 

            JOIN HomeBundle:Keywordvideo kv 
            WITH kv.video = v.videoId 

            JOIN HomeBundle:Keyword k 
            WITH k.keywordId = kv.keyword 

            WHERE k.keywordId = '$listId'
            "
        )
        ->setFirstResult(0)
        ->setMaxResults(30);
        
        $video_e = $query->getResult();

        $amountVideos = 0;
        while (isset($video_e[$amountVideos]['videoId'])) 
        {
            $amountVideos++;
        }
        $i = 0;

        while (isset($video_e[$i]['videoId'])) {
            if (
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoImage'])
                &&
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoContent'])                    
                )
            {
                $videoUpdatedate = $video_e[$i]['videoUpdatedate'];
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                $videoAmountViews = $video_e[$i]['videoAmountViews'];
                $videoAmountViewsFormat = number_format($videoAmountViews);

                $videoAmountComments = $video_e[$i]['videoAmountComments'];
                $videoAmountCommentsFormat = number_format($videoAmountComments);

                $videoId_Value = $video_e[$i]['videoId'];
                $videoName_Value = $video_e[$i]['videoName'];
                $videoDescription_Value = $video_e[$i]['videoDescription'];
                $videoImage_Value = $video_e[$i]['videoImage'];
                $videoContent_Value = $video_e[$i]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videoAmountViewsFormat;
                $videoAmountComments_Value = $videoAmountCommentsFormat;
                $videoScore_Value = $video_e[$i]['videoScore'];
                $userId_Value = $video_e[$i]['userId'];
                $userName_Value = $video_e[$i]['userName'];
            }
            else
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

            $videosInformation[$i] = array(
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
                'amountVideos' => $amountVideos
            );

            $i++;

        }

        if ($i === 0)
        {
            $videosInformation[0] = array(
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


        return $videosInformation;
    }
    
    
    public function get_artistBundle($listId, $em, $userId, $useripId)
    {
        $query = $em->createQuery(
            "SELECT 
            v.videoId, v.videoName, v.videoDescription, v.videoImage, 
            v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
            v.videoScore, v.videoAmountComments, 
            u.userId, u.userName 

            FROM HomeBundle:Video v 

            JOIN HomeBundle:User u 
            WITH v.user = u.userId 

            WHERE u.userId = '$listId'"
        )
        ->setFirstResult(0)
        ->setMaxResults(30);
        
        $video_e = $query->getResult();

        $amountVideos = 0;
        while (isset($video_e[$amountVideos]['videoId'])) 
        {
            $amountVideos++;
        }
        $i = 0;

        while (isset($video_e[$i]['videoId'])) {
            if (
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoImage'])
                &&
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoContent'])                    
                )
            {
                $videoUpdatedate = $video_e[$i]['videoUpdatedate'];
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                $videoAmountViews = $video_e[$i]['videoAmountViews'];
                $videoAmountViewsFormat = number_format($videoAmountViews);

                $videoAmountComments = $video_e[$i]['videoAmountComments'];
                $videoAmountCommentsFormat = number_format($videoAmountComments);

                $videoId_Value = $video_e[$i]['videoId'];
                $videoName_Value = $video_e[$i]['videoName'];
                $videoDescription_Value = $video_e[$i]['videoDescription'];
                $videoImage_Value = $video_e[$i]['videoImage'];
                $videoContent_Value = $video_e[$i]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videoAmountViewsFormat;
                $videoAmountComments_Value = $videoAmountCommentsFormat;
                $videoScore_Value = $video_e[$i]['videoScore'];
                $userId_Value = $video_e[$i]['userId'];
                $userName_Value = $video_e[$i]['userName'];
            }
            else
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

            $videosInformation[$i] = array(
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
                'amountVideos' => $amountVideos
            );

            $i++;

        }

        if ($i === 0)
        {
            $videosInformation[0] = array(
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


        return $videosInformation;
    }
    
    
    public function get_searchResults($listId, $em, $userId, $useripId)
    {
        $keywordContent = $this->debug_word($listId);

        $query = $em->createQuery(
            "SELECT DISTINCT 
            v.videoId, v.videoName, v.videoDescription, v.videoImage, 
            v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
            v.videoScore, v.videoAmountComments, 
            u.userId, u.userName 

            FROM HomeBundle:Video v 

            JOIN HomeBundle:User u 
            WITH u.userId = v.user 

            JOIN HomeBundle:Keywordvideo kv 
            WITH v.videoId = kv.video 

            JOIN HomeBundle:Keyword k 
            WITH kv.keyword = k.keywordId 

            WHERE k.keywordContent = '$keywordContent' 
            ORDER BY 
            v.videoScore DESC, 
            v.videoAmountViews DESC, 
            v.videoAmountComments DESC, 
            v.videoUpdatedate DESC"
        )
        ->setFirstResult(0)
        ->setMaxResults(30);
        
        $video_e = $query->getResult();

        $amountVideos = 0;
        while (isset($video_e[$amountVideos]['videoId'])) 
        {
            $amountVideos++;
        }
        $i = 0;

        while (isset($video_e[$i]['videoId'])) {
            if (
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoImage'])
                &&
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoContent'])                    
                )
            {
                $videoUpdatedate = $video_e[$i]['videoUpdatedate'];
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                $videoAmountViews = $video_e[$i]['videoAmountViews'];
                $videoAmountViewsFormat = number_format($videoAmountViews);

                $videoAmountComments = $video_e[$i]['videoAmountComments'];
                $videoAmountCommentsFormat = number_format($videoAmountComments);

                $videoId_Value = $video_e[$i]['videoId'];
                $videoName_Value = $video_e[$i]['videoName'];
                $videoDescription_Value = $video_e[$i]['videoDescription'];
                $videoImage_Value = $video_e[$i]['videoImage'];
                $videoContent_Value = $video_e[$i]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videoAmountViewsFormat;
                $videoAmountComments_Value = $videoAmountCommentsFormat;
                $videoScore_Value = $video_e[$i]['videoScore'];
                $userId_Value = $video_e[$i]['userId'];
                $userName_Value = $video_e[$i]['userName'];
            }
            else
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

            $videosInformation[$i] = array(
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
                'amountVideos' => $amountVideos
            );

            $i++;

        }

        if ($i === 0)
        {
            $videosInformation[0] = array(
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


        return $videosInformation;
        
    }
    
    
    public function get_historyResults($listId, $em, $userId, $useripId)
    {
        if ($userId != 0)
        {
            $query = $em->createQuery(
                "SELECT 
                v.videoId, v.videoName, v.videoDescription, v.videoImage, 
                v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
                v.videoScore, v.videoAmountComments, 
                u.userId, u.userName 

                FROM HomeBundle:History h 

                JOIN HomeBundle:Video v 
                WITH v.videoId = h.video 

                JOIN HomeBundle:User u 
                WITH u.userId = h.user 

                WHERE h.user = '$userId'

                ORDER BY h.historyDate DESC"
            )
            ->setFirstResult(0)
            ->setMaxResults(30);
        } else
        {
            $query = $em->createQuery(
                "SELECT DISTINCT 
                v.videoId, v.videoName, v.videoDescription, v.videoImage, 
                v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
                v.videoScore, v.videoAmountComments, 
                u.userId, u.userName 
                
                FROM HomeBundle:History h 

                JOIN HomeBundle:Video v 
                WITH v.videoId = h.video 

                JOIN HomeBundle:Userip ui 
                WITH ui.useripId = h.userip 

                JOIN HomeBundle:User u 
                WITH u.userId = v.user 

                WHERE h.userip = '$useripId'

                ORDER BY h.historyDate DESC"
            )
            ->setFirstResult(0)
            ->setMaxResults(30);
        }
        
        $video_e = $query->getResult();

        $amountVideos = 0;
        while (isset($video_e[$amountVideos]['videoId'])) 
        {
            $amountVideos++;
        }
        $i = 0;

        while (isset($video_e[$i]['videoId'])) {
            if (
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoImage'])
                &&
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoContent'])                    
                )
            {
                $videoUpdatedate = $video_e[$i]['videoUpdatedate'];
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                $videoAmountViews = $video_e[$i]['videoAmountViews'];
                $videoAmountViewsFormat = number_format($videoAmountViews);

                $videoAmountComments = $video_e[$i]['videoAmountComments'];
                $videoAmountCommentsFormat = number_format($videoAmountComments);

                $videoId_Value = $video_e[$i]['videoId'];
                $videoName_Value = $video_e[$i]['videoName'];
                $videoDescription_Value = $video_e[$i]['videoDescription'];
                $videoImage_Value = $video_e[$i]['videoImage'];
                $videoContent_Value = $video_e[$i]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videoAmountViewsFormat;
                $videoAmountComments_Value = $videoAmountCommentsFormat;
                $videoScore_Value = $video_e[$i]['videoScore'];
                $userId_Value = $video_e[$i]['userId'];
                $userName_Value = $video_e[$i]['userName'];
            }
            else
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

            $videosInformation[$i] = array(
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
                'amountVideos' => $amountVideos
            );

            $i++;

        }

        if ($i === 0)
        {
            $videosInformation[0] = array(
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

        return $videosInformation;
    }
    
    
    public function get_dataminingResults($listId, $em, $userId, $useripId)
    {
        if ($userId != 0)
        {
            $query = $em->createQuery(
            "SELECT DISTINCT 
            v.videoId, v.videoName, v.videoDescription, v.videoImage, 
            v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
            v.videoScore, v.videoAmountComments, 
            u.userId, u.userName 

            FROM HomeBundle:Video v

            JOIN HomeBundle:User u 
            WITH u.userId = v.user 

            JOIN HomeBundle:Datamininglist dl 
            WITH v.videoId = dl.video 

            WHERE 

            dl.user = '$userId' 

            ORDER BY 

            dl.datamininglistScore DESC, 
            dl.datamininglistDate DESC, 

            v.videoScore DESC, 
            v.videoAmountViews DESC, 
            v.videoAmountComments DESC"
            )
            ->setFirstResult(0)
            ->setMaxResults(30);
        } else
        {
            $query = $em->createQuery(
            "SELECT DISTINCT 
            v.videoId, v.videoName, v.videoDescription, v.videoImage, 
            v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
            v.videoScore, v.videoAmountComments, 
            u.userId, u.userName 

            FROM HomeBundle:Video v 

            JOIN HomeBundle:User u 
            WITH u.userId = v.user 

            JOIN HomeBundle:Datamininglist dl 
            WITH v.videoId = dl.video 

            WHERE 

            dl.userip = '$useripId' 

            ORDER BY 

            dl.datamininglistScore DESC,
            dl.datamininglistDate DESC, 

            v.videoScore DESC, 
            v.videoAmountViews DESC, 
            v.videoAmountComments DESC"
            )
            ->setFirstResult(0)
            ->setMaxResults(30);
        }
        
        $video_e = $query->getResult();

        $amountVideos = 0;
        while (isset($video_e[$amountVideos]['videoId'])) 
        {
            $amountVideos++;
        }
        $i = 0;

        while (isset($video_e[$i]['videoId'])) {
            if (
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoImage'])
                &&
                file_exists("files/".$video_e[$i]['userId'].
                "/".$video_e[$i]['videoId'].
                "/".$video_e[$i]['videoContent'])                    
                )
            {
                $videoUpdatedate = $video_e[$i]['videoUpdatedate'];
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                $videoAmountViews = $video_e[$i]['videoAmountViews'];
                $videoAmountViewsFormat = number_format($videoAmountViews);

                $videoAmountComments = $video_e[$i]['videoAmountComments'];
                $videoAmountCommentsFormat = number_format($videoAmountComments);

                $videoId_Value = $video_e[$i]['videoId'];
                $videoName_Value = $video_e[$i]['videoName'];
                $videoDescription_Value = $video_e[$i]['videoDescription'];
                $videoImage_Value = $video_e[$i]['videoImage'];
                $videoContent_Value = $video_e[$i]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videoAmountViewsFormat;
                $videoAmountComments_Value = $videoAmountCommentsFormat;
                $videoScore_Value = $video_e[$i]['videoScore'];
                $userId_Value = $video_e[$i]['userId'];
                $userName_Value = $video_e[$i]['userName'];
            }
            else
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

            $videosInformation[$i] = array(
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
                'amountVideos' => $amountVideos
            );

            $i++;

        }

        if ($i === 0)
        {
            $videosInformation[0] = array(
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

        return $videosInformation;
    }
    
    
    public function debug_word($keywords_entered_2)
    {
        // me retira (espacios en blanco, saltos de linea, etc) que haya al inicio de la variable $keywords_entered
        $keywords_entered_1 = ltrim($keywords_entered_2);

        // me retira (espacios en blanco, saltos de linea, etc) que haya al final de la variable $keywords_entered
        $keywords_entered = rtrim($keywords_entered_1);
        
        $word_entered = array();
        $word_entered = $this->separateKeywords($keywords_entered);

        $characters_entered_amount = $this->getCharactersEnteredAmount($keywords_entered);
        $keywordContent = "";
        for ($i = 0; $i <= $characters_entered_amount; $i++)
        {
            $keywordContent.=$word_entered[$i]." ";
        }
        
        return $keywordContent;
    }
    
    public function separateKeywords($keywords_entered)
    {
        $word_entered = array(); // array que me almacena la cantidad de palabras
        if ($keywords_entered) {
            $characters_entered_amount = 0;
            $temporal_word = "";

            // separar palabras de la frase que se ingresó en el motor de busqueda
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
    
    
    
    public function get_useripId($em)
    {
        $geolocalization = $_SERVER["REMOTE_ADDR"];
        
        $existentedUserip = $em->createQuery(
            "SELECT ui.useripId 
            FROM HomeBundle:Userip ui 
            WHERE ui.useripGeolocalization = '$geolocalization'"
        );
        
        $existentedUserip_v = $existentedUserip->getResult();

        if (isset($existentedUserip_v[0]['useripId'])) {
            $useripId = $existentedUserip_v[0]['useripId'];
        } else {
            $useripId = $this->insertar_userip($em, $geolocalization);
        }
        return $useripId;
    }
    
    public function insertar_userip($em, $geolocalization)
    {
        $userip = new \HomeBundle\Entity\Userip;
        $userip->setUseripGeolocalization($geolocalization);
        $em->persist($userip);
        $em->flush();
        
        $existentedUserip = $em->createQuery(
            "SELECT ui.useripId 
            FROM HomeBundle:Userip ui 
            WHERE ui.useripGeolocalization = '$geolocalization'"
        );
        $existentedUserip_v = $existentedUserip->getResult();
        $useripId = $existentedUserip_v[0]['useripId'];
        
        return $useripId;
    }
    
}