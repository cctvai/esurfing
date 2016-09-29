<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 2016-09-28 下午5:17
 */

namespace Wenpeng\Esurfing\Request;

class VoiceNotice
{
    public $client;

    /**
     * VoiceNotice constructor.
     *
     * @param \Wenpeng\Esurfing\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Send Voice Notice
     *
     * @param integer $template
     * @param string $phone
     * @param array $params
     * @return object
     */
    public function send($template, $phone, $params)
    {
        $url = 'http://api.189.cn/v2/emp/ims/voiceNotice';
        return $this->client->request($url, [
            'template_id' => $template,
            'calleeNbr' => ltrim($phone),
            'template_param' => json_encode($params)
        ]);
    }
}