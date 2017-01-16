<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
/**
 * Remote file class
 *
 * @category OntoWiki
 * @package Extensions
 * @subpackage Csvimport
 * @copyright Copyright (c) 2010, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class RemoteFile
{
    public function __construct($ckanResourceId)
    {
        $this->ckanResourceId = $ckanResourceId;
        $this->uri = $this->getUri($this->ckanResourceId);
        $this->localPath = $this->createTempFile();
    }

    private function getUri($ckanResourceId)
    {
        include_once 'Zend/Http/Client.php';
        $client = new Zend_Http_Client();
        $client->setUri('http://csv2rdf.aksw.org/getUriByCkanResourceId');
        $client->setMethod(Zend_Http_Client::POST);
        $client->setParameterPost('resource_id', $ckanResourceId);
        $result = $client->request();
        if($result->isError()) {
            echo $result->getStatus();
        } else {
            return json_decode($result->getBody());
        }
    }

    private function createTempFile()
    {
        return tempnam(sys_get_temp_dir(), 'csvimport');
    }

    public function download()
    {
        $newfname = $this->localPath;
        $file = fopen($this->uri, "rb");
        if ($file) {
            $newf = fopen($newfname, "wb");

            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }

        if ($file) {
            fclose($file);
        }

        if ($newf) {
            fclose($newf);
        }

        return $this->localPath;
    }

}
