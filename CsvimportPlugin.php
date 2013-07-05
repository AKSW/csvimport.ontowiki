<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * The main class for the csv import plugin.
 *
 * @category   OntoWiki
 * @package    Extensions_Csvimport
 * @copyright  Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author     Tim Ermilov <yamalight@gmail.com>
 */
class CsvimportPlugin extends OntoWiki_Plugin
{

    // ------------------------------------------------------------------------
    // --- Plugin handler methods ---------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Event handler method, which is called on menu creation. Adds some
     * datagathering relevant menu entries.
     *
     * @param Erfurt_Event $event
     *
     * @return bool
     */
    public function onCreateMenu($event)
    {
        if ($event->isModel) {
            $url = new OntoWiki_Url(array('controller' => 'csvimport'), array());
            $menu = $event->menu;
            $menu->appendEntry('Import CSV Data', (string) $url);
        }

        return true;
    }

    /*
     * add another import action
     */
    public function onProvideImportActions($event)
    {
        $myImportActions = array(
            'csvimport-upload' => array(
                'controller' => 'csvimport',
                'action' => 'upload',
                'label' => 'Upload a CSV file with statistical or tabular data.',
                'description' => 'Tabular data import uses property mapping and Statistical data import uses DataCube mapping.'
            )
        );

        $event->importActions = array_merge($event->importActions, $myImportActions);
        return $event;
    }
}
