<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\base\Component;

class GoogleAds extends Component
{
    public $userAgent = "INSERT_COMPANY_NAME_HERE";
    public $refresh_token = "INSERT_OAUTH2_REFRESH_TOKEN_HERE";
    public $developerToken = "INSERT_DEVELOPER_TOKEN_HERE";
    public $clientCustomerId = "";
    public $server_version = null;
    private $_user = null;
    public function setClient($oauth2Info)
    {
        $this->_user = new \AdWordsUser();
        $this->_user->LogAll();
        $this->_user->SetOAuth2Info($oauth2Info);
        $this->_user->SetUserAgent($this->userAgent);
        $this->_user->SetClientLibraryUserAgent($this->userAgent);
        $this->_user->SetClientCustomerId($this->clientCustomerId);
        $this->_user->SetDeveloperToken($this->developerToken);
    }
    public function getUser()
    {
        return $this->_user;
    }
}
