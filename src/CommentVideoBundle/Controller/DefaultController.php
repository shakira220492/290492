<?php

namespace CommentVideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@CommentVideo/Default/index.html.twig');
    }
    
    public function getCommentAboutVideoAction(Request $request) {
        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $current_video_id = $_POST['current_video_id'];
            $startPosition = $_POST['startPositionComments'];
            $amountComments = $_POST['amountComments'];
            
            $em = $this->getDoctrine()->getManager();
            $videouserId = $this->obtener_VideoUser($em, $current_video_id, $userId);
            $query = $em->createQuery(
                "SELECT vc.videocommentId, vc.videocommentContent, vc.videocommentDate, 
                vu.videouserId, 
                u.userId, u.userName, 
                v.videoId, v.videoAmountComments 
                FROM HomeBundle:Videocomment vc 
                
                JOIN HomeBundle:Videouser vu
                WITH vu.videouserId = vc.videouser 
                
                JOIN HomeBundle:User u 
                WITH u.userId = vu.user 
                
                JOIN HomeBundle:Video v 
                WITH v.videoId = vu.video 
                
                WHERE vu.videouserId = '$videouserId' 
                ORDER BY vc.videocommentDate DESC "
            )
            ->setFirstResult($startPosition) 
            ->setMaxResults($amountComments); 

            $comment = $query->getResult();

            if (isset($comment[0]['videocommentId'])) {
                $videocommentId_Value = $comment[0]['videocommentId'];
                $videocommentContent_Value = $comment[0]['videocommentContent'];
                $videocommentDate_Value = $comment[0]['videocommentDate'];
                $userId_Value = $comment[0]['userId'];
                $userName_Value = $comment[0]['userName'];
                $videoId_Value = $comment[0]['videoId'];
                $videoAmountComments_Value = $comment[0]['videoAmountComments'];

//                $videocommentId_Value = "_";
//                $videocommentContent_Value = "_";
//                $videocommentDate_Value = "_";
//                $userId_Value = "_";
//                $userName_Value = "_";
//                $videoId_Value = "_";
//                $videoAmountComments_Value = "_";

                $users2[0] = array(
                    'videocommentId' => $videocommentId_Value,
                    'videocommentContent' => $videocommentContent_Value,
                    'videocommentDate' => $videocommentDate_Value,
                    'userId' => $userId_Value,
                    'userName' => $userName_Value,
                    'videoId' => $videoId_Value,
                    'videoAmountComments' => $videoAmountComments_Value
                );
            } else {
                $users2[0] = array(
                    'videocommentId' => "_",
                    'videocommentContent' => "_",
                    'videocommentDate' => "_",
                    'userId' => "_",
                    'userName' => "_",
                    'videoId' => "_",
                    'videoAmountComments' => "_"
                );
            }
            
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function getCommentsAboutVideoAction(Request $request)
    {        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $current_video_id = $_POST['current_video_id'];
            $startPosition = $_POST['startPositionComments'];
            $amountComments = $_POST['amountComments'];
            
            $em = $this->getDoctrine()->getManager();
            $videouserId = $this->obtener_VideoUser($em, $current_video_id, $userId);
            $query = $em->createQuery(
                "SELECT vc.videocommentId, vc.videocommentContent, vc.videocommentDate, 
                vu.videouserId, 
                u.userId, u.userName, 
                v.videoId, v.videoAmountComments 
                FROM HomeBundle:Videocomment vc 
                
                JOIN HomeBundle:Videouser vu
                WITH vu.videouserId = vc.videouser 
                
                JOIN HomeBundle:User u 
                WITH u.userId = vu.user 
                
                JOIN HomeBundle:Video v 
                WITH v.videoId = vu.video 
                
                WHERE vu.videouserId = '$videouserId' 
                ORDER BY vc.videocommentDate DESC "
            )
                ->setFirstResult($startPosition) 
                ->setMaxResults($amountComments); 

            $comment = $query->getResult();                

            
            $amountCommentsFound = 0;

            while (isset($comment[$amountCommentsFound]['videocommentId'])) {
                $amountCommentsFound++;
            }
            
                $i = 0;
                while (isset($comment[$i]['videocommentId'])) {
                    
                    if ($comment) {
//                        $commentId_Value = $comment[$i]['commentId'];
//                        $commentContent_Value = $comment[$i]['commentContent'];
//                        $commentLikes_Value = $comment[$i]['commentLikes'];
//                        $commentDislikes_Value = $comment[$i]['commentDislikes'];
//                        $commentCreationdate_Value = $comment[$i]['commentCreationdate'];
//                        $userName_Value = $comment[$i]['userName'];
                        
                        $videocommentId_Value = $comment[$i]['videocommentId'];
                        $videocommentContent_Value = $comment[$i]['videocommentContent'];
                        $videocommentDate_Value = $comment[$i]['videocommentDate'];
                        $userId_Value = $comment[$i]['userId'];
                        $userName_Value = $comment[$i]['userName'];
                        $videoId_Value = $comment[$i]['videoId'];
                        $videoAmountComments_Value = $comment[$i]['videoAmountComments'];
                    } else {
                        $videocommentId_Value = "_";
                        $videocommentContent_Value = "_";
                        $videocommentDate_Value = "_";
                        $userId_Value = "_";
                        $userName_Value = "_";
                        $videoId_Value = "_";
                        $videoAmountComments_Value = "_";
                    }

                    $sendData[$i] = array(
                        'videocommentId' => $videocommentId_Value,
                        'videocommentContent' => $videocommentContent_Value,
                        'videocommentDate' => $videocommentDate_Value,
                        'userId' => $userId_Value,
                        'userName' => $userName_Value,
                        'videoId' => $videoId_Value,
                        'videoAmountComments' => $videoAmountComments_Value
                    );
                    $i++;
                }

                if ($i == 0) {
                    $videocommentId_Value = "_";
                    $videocommentContent_Value = "_";
                    $videocommentDate_Value = "_";
                    $userId_Value = "_";
                    $userName_Value = "_";
                    $videoId_Value = "_";
                    $videoAmountComments_Value = "_";

                    $sendData[0] = array(
                        'videocommentId' => $videocommentId_Value,
                        'videocommentContent' => $videocommentContent_Value,
                        'videocommentDate' => $videocommentDate_Value,
                        'userId' => $userId_Value,
                        'userName' => $userName_Value,
                        'videoId' => $videoId_Value,
                        'videoAmountComments' => $videoAmountComments_Value
                    );
                }

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function addCommentVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            if (isset($_SESSION['loginSession'])) {
                $userId = $_SESSION['loginSession'];
            }
            else {
                $userId = 0;
            }
            
            $current_video_id = $_POST['current_video_id'];
            $commentContent = $_POST['commentContent'];

            if ($current_video_id === "" || $commentContent === "" || $userId === 0) {
                $status = "0";
            } else
            {
                
                $todayDate = date("Y-m-d");
                $commentDate = date_create_from_format('Y-m-d', $todayDate);
                
                $videouserId = $this->obtener_VideoUser($em, $current_video_id, $userId);
                $videoUser = $em->getRepository('HomeBundle:Videouser')->findOneByVideouserId($videouserId);
                
                $videocomment = new \HomeBundle\Entity\Videocomment();
                $videocomment->setVideocommentContent($commentContent);
                $videocomment->setVideocommentDate($commentDate);
                $videocomment->setVideouser($videoUser);
                    
                $em->persist($videocomment);
                $em->flush();
                
                $status = "1";
            }
            
            $users2 = array();
            $users2[0] = array(
                'status' => $status
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function increaseCommentsAmountVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $current_video_id = $_POST['current_video_id'];
            
            if ($current_video_id) {
                $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($current_video_id);

                $amountComments = $video->getVideoAmountComments();
                $newAmountComments = $amountComments + 1;

                $video->setVideoAmountComments($newAmountComments);
                $em->persist($video);
                $em->flush();
                
                $status = "1";
            } else
            {
                $status = "0";
            }

            $users2 = array();
            $users2[0] = array(
                'status' => $status
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function obtener_VideoScore($em, $current_video_id, $score)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        $videouserId = $this->obtener_VideoUser($em, $current_video_id, $userId);
        
        $videoScore = $em->createQuery(
            "SELECT vs.videoscoreId, vs.videoscorePunctuation, vs.videoscoreDate, vu.videouserId 
            FROM HomeBundle:Videoscore vs 

            JOIN HomeBundle:Videouser vu 
            WITH vu.videouserId = vs.videouser 

            WHERE vu.videouserId = '$videouserId'
            "
        )
        ->setMaxResults(1);
        
        $videoScore_e = $videoScore->getResult();
        
        $videoUser = $em->getRepository('HomeBundle:Videouser')->findOneByVideouserId($videouserId);
        
        $todayDate = date("Y-m-d");
        $todayDate_format = date_create_from_format('Y-m-d', $todayDate);

        if ($score == 0 && !isset($videoScore_e[0]['videoscoreId'])) {
//            crear con valor de score 0            
            $videoscore_entity = new \HomeBundle\Entity\Videoscore();
            $videoscore_entity->setVideouser($videoUser);
            $videoscore_entity->setVideoscoreDate($todayDate_format);
            $videoscore_entity->setVideoscorePunctuation($score);
            $em->persist($videoscore_entity);
            $em->flush();
        } else if ($score == 0 && isset($videoScore_e[0]['videoscoreId'])) {
//            leer
            $videoscoreId_value = $videoScore_e[0]['videoscoreId'];
            $videoscore_entity = $em->getRepository('HomeBundle:Videoscore')->findOneByVideoscoreId($videoscoreId_value);
        } else if ($score != 0 && !isset($videoScore_e[0]['videoscoreId'])) {
//            crear con valor de score que me mandaron score=x
            $videoscore_entity = new \HomeBundle\Entity\Videoscore();
            $videoscore_entity->setVideouser($videoUser);
            $videoscore_entity->setVideoscoreDate($todayDate_format);
            $videoscore_entity->setVideoscorePunctuation($score);
            $em->persist($videoscore_entity);
            $em->flush();
        } else if ($score != 0 && isset($videoScore_e[0]['videoscoreId'])) {
//            editar con valor de score que me mandaron score=x
            $videoscoreId_value = $videoScore_e[0]['videoscoreId'];
            $videoscore_entity = $em->getRepository('HomeBundle:Videoscore')->findOneByVideoscoreId($videoscoreId_value);
            $videoscore_entity->setVideouser($videoUser);
            $videoscore_entity->setVideoscoreDate($todayDate_format);
            $videoscore_entity->setVideoscorePunctuation($score);
            $em->persist($videoscore_entity);
            $em->flush();
        }

        $videoscoreId = $videoscore_entity->getVideoscoreId();
        $videoscoreDate = $videoscore_entity->getVideoscoreDate();
        $videoscorePunctuation = $videoscore_entity->getVideoscorePunctuation();
        $videouser = $videoscore_entity->getVideouser();
            
        $videoscore_array = array(); // array que me almacena la cantidad de palabras
        $videoscore_array[0] = $videoscoreId;
        $videoscore_array[1] = $videoscoreDate;
        $videoscore_array[2] = $videoscorePunctuation;
        $videoscore_array[3] = $videouser;
        
        return $videoscore_array;
    }
    
    public function obtener_VideoUser($em, $current_video_id, $userId)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        $videoUser = $em->createQuery(
            "SELECT vu.videouserId, v.videoId, u.userId 
            FROM HomeBundle:Videouser vu 

            JOIN HomeBundle:User u 
            WITH vu.user = u.userId 

            JOIN HomeBundle:Video v 
            WITH vu.video = v.videoId 

            WHERE u.userId = '$userId' and v.videoId = '$current_video_id'
            "
        )
        ->setMaxResults(1);
        
        $videoUser_e = $videoUser->getResult();

        if (isset($videoUser_e[0]['videouserId'])) {
            $videoUserId = $videoUser_e[0]['videouserId'];
        } else {
            // crear el videouser y obtener el videouser
            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);
            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($current_video_id);
            
            $videoUser_entity = new \HomeBundle\Entity\Videouser();
            $videoUser_entity->setUser($user);
            $videoUser_entity->setVideo($video);
            $em->persist($videoUser_entity);
            $em->flush();
            $videoUserId = $videoUser_entity->getVideouserId();
        }
        
        return $videoUserId;
        
    }
    
}
