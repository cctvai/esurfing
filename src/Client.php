<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 2016-09-28 下午6:27
 */

namespace Wenpeng\Esurfing;

use Exception;
use Wenpeng\Curl;

class Client
{
    private $appID;
    private $appSecret;
    private $accessToken;
    private $tokenExpire;

    /**
     * Client constructor
     *
     * @param string $appID
     * @param string $appSecret
     * @throws Exception
     */
    public function __construct($appID, $appSecret)
    {
        $this->appID = $appID;
        $this->appSecret = $appSecret;

        $url = 'https://oauth.api.189.cn/emp/oauth2/v3/access_token';
        $params = [
            'app_id' => $this->appID,
            'app_secret' => $this->appSecret,
            'grant_type' => 'client_credentials'
        ];
        $data = $this->curl($url, $params);
        if ($data->res_code) {
            throw new Exception($data->res_message);
        }

        $this->accessToken = $data->access_token;
        $this->tokenExpire = $data->expires_in;
    }

    /**
     * Submit Request
     *
     * @param string $url
     * @param array $params
     * @return object
     */
    public function request($url, $params)
    {
        $params = array_merge($params, [
            'app_id' => $this->appID,
            'timestamp' => date('Y-m-d H:i:s'),
            'access_token' => $this->accessToken,
        ]);
        $params = ksort($params);
        $string = http_build_query($params);
        $params['sign'] = hash_hmac('sha1', $string, $this->appSecret);

        return $this->curl($url, $params);
    }

    /**
     * Curl Process
     *
     * @param string $url
     * @param array $params
     * @return object
     * @throws Exception
     */
    public function curl($url, $params)
    {
        $curl = new Curl();
        $curl->post($params)->submit($url);
        if ($curl->fail()) {
            throw new Exception($curl->message());
        }

        $data = json_decode($curl->data());
        if ($data === false) {
            throw new Exception('API返回的JSON异常');
        }
        return $data;
    }

    /**
     * Access Token
     *
     * @return string
     */
    public function accessToken()
    {
        return $this->accessToken;
    }

    /**
     * Token Expire Time
     *
     * @return integer
     */
    public function tokenExpire()
    {
        return $this->tokenExpire;
    }
}