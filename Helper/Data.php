<?php
/**
 * A module for the Instagram Basic Display API.
 * Copyright (C) 2020  Sparacino Enzo Franco
 *
 * This file is part of Sparacino/Instagram.
 *
 * Sparacino/Instagram is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Sparacino\Instagram\Helper;

use Magento\Framework\App\Helper\AbstractHelper;


class Data extends AbstractHelper
{

    /**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACTIVE = 'instagram/options/active';
    const XML_PATH_APP_ACCESS_TOKEN = 'instagram/options/app_access_token';
    const API_URL = 'https://graph.instagram.com/';

    private $fields = 'caption, id, media_type, media_url, permalink, thumbnail_url, timestamp, children{id, media_type, media_url, permalink, thumbnail_url, timestamp}';
    private $timeout = 90000;
    private $connectTimeout = 20000;


    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getConfig(self::XML_PATH_ACTIVE) && $this->getAccessToken();
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->getConfig(self::XML_PATH_APP_ACCESS_TOKEN);
    }

    /**
     * Get config
     *
     * @param string $path
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return array
     */
     public function getMedia()
     {
         if ($this->isEnabled()) {
             $userMedia = $this->getUserMedia();
             if ($userMedia->data) {
                 $media = [];
                 foreach ($userMedia->data as $key => $value) {
                     $media[$value->id]['caption'] = (isset($value->caption) && $value->caption) ? $value->caption : '';
                     $media[$value->id]['thumbnail'] = ($value->media_type == 'VIDEO') ? $value->thumbnail_url : $value->media_url;
                     $media[$value->id]['permalink'] = $value->permalink;
                 }
                 return $media;
             }
         }
         return [];
     }

    public function getUserMedia($id = 'me', $limit = 0, $before = null, $after = null)
    {
        $params = [
            'fields' => $this->fields
        ];

        if ($limit > 0) {
            $params['limit'] = $limit;
        }
        if (isset($before)) {
            $params['before'] = $before;
        }
        if (isset($after)) {
            $params['after'] = $after;
        }

        return $this->call($id . '/media', $params);
    }

    protected function call($function, $params = null, $method = 'GET')
    {

        $authMethod = '?access_token=' . $this->getAccessToken();

        $paramString = null;

        if (isset($params) && is_array($params)) {
            $paramString = '&' . http_build_query($params);
        }

        $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);

        $headerData = array('Accept: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $jsonData = curl_exec($ch);

        if (!$jsonData) {
            return false;
        }

        list($headerContent, $jsonData) = explode("\r\n\r\n", $jsonData, 2);

        curl_close($ch);

        return json_decode($jsonData);
    }
}
