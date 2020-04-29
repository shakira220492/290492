<?php

namespace VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ScoreVideoController extends Controller {

    public function indexAction() {
//        return $this->render('@Video/Default/index.html.twig');
    }

    public function getScoreVideoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $current_video_id = $_POST['current_video_id'];
        
        if ($request->isXMLHttpRequest()) {
            
            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($current_video_id);
            $video_score = $video->getVideoScore();
            
            $users2 = array();
            $users2[0] = array(
                'video_score' => $video_score
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function setScoreVideoAction(Request $request)
    {
        $current_video_id = $_POST['current_video_id'];
        $score_video = $_POST['score_video'];
                
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            if ($userId === 0 && $current_video_id)
            {
                
            } else
            {
                $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($current_video_id);
                $previous_score = $video->getVideoScore();
                $previous_peopleScore = $video->getVideoPeoplescore();
                
                $new_score = ($previous_score * $previous_peopleScore/($previous_peopleScore+1)) + $score_video * (1/($previous_peopleScore+1));
                $new_peopleScore = $previous_peopleScore + 1;
                        
                $video->setVideoScore($new_score);
                $video->setVideoPeoplescore($new_peopleScore);
                $em->persist($video);
                $em->flush();
            }
            
            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function getPersonalScoreVideoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $current_video_id = $_POST['current_video_id'];
                        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        $videoscore_array = array();
        $videoscore_array = $this->obtener_VideoScore($em, $current_video_id, 0);
        $videoscoreDate = $videoscore_array[1];
        $videoscorePunctuation = $videoscore_array[2];
        
        if ($request->isXMLHttpRequest()) {
            $users2 = array();
            $users2[0] = array(
                'videoscorePunctuation' => $videoscorePunctuation,
                'videoscoreDate' => $videoscoreDate
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function setPersonalScoreVideoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $current_video_id = $_POST['current_video_id'];
        $score_video = $_POST['score_video'];
                
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        $videoscore_array = array();
        $videoscore_array = $this->obtener_VideoScore($em, $current_video_id, $score_video);
        $videoscoreDate = $videoscore_array[1];
        $videoscorePunctuation = $videoscore_array[2];
        if ($request->isXMLHttpRequest()) {
            $users2 = array();
            $users2[0] = array(
                'videoscorePunctuation' => $videoscorePunctuation,
                'videoscoreDate' => $videoscoreDate
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