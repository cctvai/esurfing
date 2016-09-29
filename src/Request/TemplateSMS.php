<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 2016-09-28 下午5:17
 */

namespace Wenpeng\Esurfing\Request;

class TemplateSMS
{
    public $client;

    /**
     * TemplateSMS constructor.
     *
     * @param \Wenpeng\Esurfing\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Send Template SMS
     *
     * @param integer $template
     * @param string $phone
     * @param array $params
     * @return object
     */
    public function send($template, $phone, $params)
    {
        $url = 'http://api.189.cn/v2/emp/templateSms/sendSms';
        return $this->client->request($url, [
            'template_id' => $template,
            'acceptor_tel' => ltrim($phone),
            'template_param' => json_encode($params)
        ]);
    }

    /**
     * Get SMS Status
     *
     * @param integer $identifier
     * @return object
     */
    public function status($identifier)
    {
        $url = 'http://api.189.cn/v2/EMP/nsagSms/appnotify/querysmsstatus';
        return $this->client->request($url, ['identifier' => $identifier]);
    }
}