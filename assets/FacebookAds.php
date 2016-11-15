<?php
namespace app\assets;
// use Yii;
// use yii\base\Component;
// use Facebook\FacebookSession;
// use Facebook\FacebookRedirectLoginHelper;
// use Facebook\FacebookRequest;
// use Facebook\GraphUser;
// use Exception;
// class Facebook extends Component
// {
//     public $appId = '705550269598587';
//     public $secret = 'bc647af7944a04123a0945752ce2a9ec';
//     public $scope;
//     private $session;
//     private $accessToken;
//     public function init()
//     {
//         parent::init();
//         if (!Yii::$app->session->isActive) {
//             Yii::$app->session->open();
//         }
//         FacebookSession::setDefaultApplication($this->appId, $this->secret);
//         $accessToken = Yii::$app->session->get('fbAccessToken');
//         if ($accessToken !== null) {
//             $this->setSession(new FacebookSession($accessToken));
//         }
//     }
//     public function getSession()
//     {
//         return $this->session;
//     }
//     public function setSession(FacebookSession  $session)
//     {
//         $this->setAccessToken($session->getToken());
//         $this->session = $session;
//     }
//     public function getAccessToken()
//     {
//         return $this->accessToken;
//     }
//     public function setAccessToken($accessToken)
//     {
//         $this->accessToken = $accessToken;
//         Yii::$app->session->set('fbAccesstoken', $this->accessToken);
//     }
//     public function getLoginUrl($redirectUrl, $scope = null)
//     {
//         $helper = new FacebookRedirectLoginHelper($redirectUrl);
//         return $helper->getLoginUrl(['scope' => $scope]);
//     }
//     public function getLoginSession($redirectUrl)
//     {
//         $helper = new FacebookRedirectLoginHelper($redirectUrl);
//         $this->setSession($helper->getSessionFromRedirect());
//         return $this->getSession();
//     }
//     public function getUser($userId = 'me')
//     {        
//         echo $this->getSession();
//         try {
//             $request = new FacebookRequest($this->getSession(), 'GET', '/' . $userId);
//             return $request->execute()->getGraphObject(GraphUser::className())->asArray();
//         } catch (Exception $e) {}
//         return [];
//     }
//     public function getFriends($userId = 'me')
//     {
//         $limit = 25;
//         $friendCount = $this->getFriendsCount($userId);
//         $friends = [];
//         try {
//             for ($offset = 0; $offset <= $friendCount; $offset += $limit) {
//                 $request = new FacebookRequest($this->getSession(), 'GET', '/' . $userId . '/friends', [
//                     'offset' => $offset,
//                     'limit' => $limit,
//                 ]);
//                 $response = $request->execute()->getGraphObject()->asArray();
//                 foreach ($response['data'] as $friend) {
//                     array_push($friends, (array) $friend);
//                 }
//                 if (count($friends) < $limit) {
//                     break;
//                 }
//             }
//         } catch (Exception $e) {}
//         return $friends;
//     }
//     public function getFriendsCount($userId = 'me')
//     {
//         try {
//             $request = new FacebookRequest($this->getSession(), 'GET', '/' . $userId . '/friends', [
//                 'offset' => 0,
//                 'limit' => 0,
//             ]);
//             $response = $request->execute()->getGraphObject()->asArray();
//             return $response['summary']->total_count;
//         } catch (Exception $e) {}
//         return 0;
//     }
// }

use Facebook\Facebook;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\GraphNodes\GraphUser;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Authentication\OAuth2Client;
class FacebookAds
{
    const APP_ID = '705550269598587';
    const APP_SECRET = 'bc647af7944a04123a0945752ce2a9ec';
    const ACCESS_TOKEN = 'EAAKBsbkwy3sBAAVrheVCRPxZCvHY24y9RUWmF8xIi8RtHwdjqQZB9QQBi23rZCLWKTNvXKfhQcMEVcZAteWgLLON4GbujjKtIY2nZBmeTIdTyFkkSY2BFpQdfHeOO0uXSbpksMirSjGbbCcHkZC4JAsPJl3yHuBGhKcjolx15p1FH9saG6M3RY';
//    private $fb;
    public function init()
    {
        $facebook = new Facebook([
          'app_id' => FacebookAds::APP_ID,
          'app_secret' => FacebookAds::APP_SECRET,
          'default_graph_version' => 'v2.7',
        ]);
        $helper = $facebook->getJavaScriptHelper();
        print_r($helper);
        try {
          $accessToken = $helper->getAccessToken();
          echo "<h3>Token: ".$helper->getAccessToken()."</h3>";
        } catch(FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        echo $accessToken;
        if (isset($accessToken)) {
          // Logged in!
          $_SESSION['facebook_access_token'] = (string) $accessToken;

          // Now you can redirect to another page and use the
          // access token from $_SESSION['facebook_access_token']
        }
        //return $facebook;
    }

    public function getAccessToken(){
        $fb = FacebookAds::init();
        //echo $_SESSION['facebook_access_token'];
        // if (! isset($accessToken)) {
        //   echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
        //   exit;
        // }

        // // Logged in
        // echo '<h3>Signed Request</h3>';
        // var_dump($helper->getSignedRequest());

        // echo '<h3>Access Token</h3>';
        // var_dump($accessToken->getValue());


        // $loginUrl = $helper->getLoginUrl('myWebsites/back.php', $permissions); 
        // echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }

    public function getUser(){
        $fb = FacebookAds::init();
        //$helper = $fb->getCanvasHelper();
        try {
          // Get the \Facebook\GraphNodes\GraphUser object for the current user.
          // If you provided a 'default_access_token', the '{access-token}' is optional.
          $response = $fb->get('/me');

        } catch(FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        $me = $response->getGraphUser(); 
        echo 'Logged in as ' . $me->getName();
    }

    public function getFriendCount(){
        $fb = FacebookAds::init();
        try {
          // Get the \Facebook\GraphNodes\GraphUser object for the current user.
          // If you provided a 'default_access_token', the '{access-token}' is optional.
          $response = $fb->get('/me/friends');

        } catch(FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        //$friends = $response;
        //echo 'Total friends: ' . count($friends);     
        echo json_encode($response->getGraphEdge()->getMetaData());
    }
}
