<?php

namespace EditProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@EditProfile/Default/index.html.twig');
    }
    
    public function getVideoListProfileAction(Request $request)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

//            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);

            $artistListVideo = $em->createQuery(
                "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, 
                v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
                v.videoAmountComments, v.videoScore, v.videoCoinScore, 
                u.userId, u.userName 
                FROM HomeBundle:Video v 
                
                JOIN HomeBundle:User u 
                WITH v.user = u.userId 
                
                WHERE u.userId = '$userId'"
            );

            $artistListVideo_v = $artistListVideo->getResult();
                        
            $amountVideos = 0;
            while (isset($artistListVideo_v[$amountVideos]['videoId'])) {
                $amountVideos++;
            }
            
            $i = 0;
            while (isset($artistListVideo_v[$i]['videoId'])) {
                
                
                if (
                    file_exists("files/".$artistListVideo_v[$i]['userId'].
                    "/".$artistListVideo_v[$i]['videoId'].
                    "/".$artistListVideo_v[$i]['videoImage'])
                    &&
                    file_exists("files/".$artistListVideo_v[$i]['userId'].
                    "/".$artistListVideo_v[$i]['videoId'].
                    "/".$artistListVideo_v[$i]['videoContent'])
                )
                {
                    $videoUpdatedate = $artistListVideo_v[$i]['videoUpdatedate'];
                    $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                    $videoAmountViews = $artistListVideo_v[$i]['videoAmountViews'];
                    $videoAmountViewsFormat = number_format($videoAmountViews);

                    $videoAmountComments = $artistListVideo_v[$i]['videoAmountComments'];
                    $videoAmountCommentsFormat = number_format($videoAmountComments);
                    
                    $videoId_Value = $artistListVideo_v[$i]['videoId'];
                    $videoName_Value = $artistListVideo_v[$i]['videoName'];
                    $videoDescription_Value = $artistListVideo_v[$i]['videoDescription'];
                    $videoImage_Value = $artistListVideo_v[$i]['videoImage'];
                    $videoContent_Value = $artistListVideo_v[$i]['videoContent'];
                    $videoUpdatedate_Value = $videoUpdatedateString;
                    $videoAmountViews_Value = $videoAmountViewsFormat;
                    $videoAmountComments_Value = $videoAmountCommentsFormat;
                    $videoScore_Value = $artistListVideo_v[$i]['videoScore'];
                    $videoCoinScore_Value = $artistListVideo_v[$i]['videoCoinScore'];
                    $userId_Value = $artistListVideo_v[$i]['userId'];
                    $userName_Value = $artistListVideo_v[$i]['userName'];
                    $amountVideos_Value = $amountVideos;
                } else {
                    $videoId_Value = "_";
                    $videoName_Value = "_";
                    $videoDescription_Value = "_";
                    $videoImage_Value = "_";
                    $videoContent_Value = "_";
                    $videoUpdatedate_Value = "_";
                    $videoAmountViews_Value = "_";
                    $videoAmountComments_Value = "_";
                    $videoScore_Value = "_";
                    $videoCoinScore_Value = "_";
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
                    'videoCoinScore' => $videoCoinScore_Value,
                    
                    'userId' => $userId_Value,
                    'userName' => $userName_Value,
                    'amountVideos' => $amountVideos_Value
                );
                $i++;
            }
            
            if ($i == 0)
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
                    'videoCoinScore' => "_",
                    'userId' => "_",
                    'userName' => "_",
                    'amountVideos' => $amountVideos
                );
            }
            
            return new Response(json_encode($videoFromUser), 200, array('Content-Type' => 'application/json'));
            
        }
    }
    
    public function updateInfoProfileAction(Request $request)
    {
        $userName_value = $_POST['userName_value'];
        $userFirstgivenname_value = $_POST['userFirstgivenname_value'];
        $userSecondgivenname_value = $_POST['userSecondgivenname_value'];
        $userFirstfamilyname_value = $_POST['userFirstfamilyname_value'];
        $userSecondfamilyname_value = $_POST['userSecondfamilyname_value'];
        $userEmail_value = $_POST['userEmail_value'];
        $userCurrentPassword_value = $_POST['userCurrentPassword_value'];
        $userNewPassword_value = $_POST['userNewPassword_value'];
        $userConfirmPassword_value = $_POST['userConfirmPassword_value'];            
        $userBiography_value = $_POST['userBiography_value'];
        
        $mensaje = 0;
        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);
            $currentPassword = $user->getUserPassword();
            
            if ($userNewPassword_value == $userConfirmPassword_value
                && $userNewPassword_value
                && $userConfirmPassword_value
                && $userCurrentPassword_value == $currentPassword)
            {
                $user->setUserPassword($userNewPassword_value); // si se pudo
                $mensaje = 4; // borrar el contenido de los inputs
            } else if ($userNewPassword_value != $userConfirmPassword_value
                && $userNewPassword_value
                && $userConfirmPassword_value
                && $userCurrentPassword_value == $currentPassword)
            {
                $mensaje = 3; // NO COINCIDEN resaltar confirmacion del password y el new password // borrar el contenido de los inputs
            } else if ($userNewPassword_value == $userConfirmPassword_value
                && $userNewPassword_value
                && $userConfirmPassword_value
                && $userCurrentPassword_value != $currentPassword)
            {
                $mensaje = 2; // EL PASSWORD QUE INGRESO COMO ACTUAL ES INCORRECTO resaltar el current password // borrar el contenido de los inputs
            } else if ($userNewPassword_value != $userConfirmPassword_value
                && $userNewPassword_value
                && $userConfirmPassword_value
                && $userCurrentPassword_value != $currentPassword)
            {
                $mensaje = 1; // TODO LO INGRESO MAL
            } else if (!$userNewPassword_value
                || !$userConfirmPassword_value)
            {
                // no se pudo
                $mensaje = 0; // NO SE MODIFICO EL PASSWORD borrar el contenido de los inputs
            }
            
            
            
            $user->setUserName($userName_value);
            $user->setUserFirstgivenname($userFirstgivenname_value);
            $user->setUserSecondgivenname($userSecondgivenname_value);
            $user->setUserFirstfamilyname($userFirstfamilyname_value);
            $user->setUserSecondfamilyname($userSecondfamilyname_value);
            $user->setUserEmail($userEmail_value);
            $user->setUserBiography($userBiography_value);
            
            
            $em->persist($user);
            $em->flush();

            $userInfo[0] = array(
                'userId' => "-",
                'mensaje' => $mensaje
            );
            
            return new Response(json_encode($userInfo), 200, array('Content-Type' => 'application/json'));
        }
    }

}