<?php

/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
    public function __construct($uri) {
        $this->uri = $uri;
        $this->localPath = $this->createTempFile();
    }

    private function createTempFile() {
        return tempnam(sys_get_temp_dir(), 'csvimport');
    }

    public function download() {
        $newfname = $this->localPath;
        $file = fopen ($this->uri, "rb");
        if ($file) {
            $newf = fopen ($newfname, "wb");

            if ($newf)
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
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
    //public function getckandataAction()
    //{
        //require_once('RemoteFile.php');
        //$test_uri = "http://data.london.gov.uk/datafiles/demographics/census-historic-population-borough.csv";
        //$remoteFile = new RemoteFile($test_uri);
        //$tempFile = $remoteFile->download();
        //$store = $this->_getSessionStore();
        //$store->importedFile = $tempFile;
        //$store->importMode   = 'scovo'; 

        //$this->_forward('mapping');
    //}

