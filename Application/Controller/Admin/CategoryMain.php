<?php

namespace test\CategoriesMedia\Application\Controller\Admin;

use test\CategoriesMedia\Application\Model\MediaUrl;
use oxRegistry;
use oxField;
use stdClass;
use oxCategory;
use oxUtilsPic;
use oxUtilsFile;
use oxExceptionToDisplay;
use oxDbMetaDataHandler;
use oxUtilsView;
use category_main_ajax;

/**
 * Admin article main categories manager.
 * There is possibility to change categories description, sorting, range of price
 * and etc.
 * Admin Menu: Manage Products -> Categories -> Main.
 */
class CategoryMain extends CategoryMain_parent
{

    /**
     * Collects available article extended parameters, passes them to
     * Smarty engine and returns template file name "article_extend.tpl".
     *
     * @return string
     */
    public function render()
    {
        $return = parent::render();

        $category = $this->_aViewData["edit"];

        //load media files
        $this->_aViewData['aMediaUrls'] = $category->getMediaUrls();

        return $return;
    }

    /**
     * Saves modified extended article parameters.
     *
     * @return mixed
     */
    public function save()
    {
        parent::save();

        $soxId = $this->getEditObjectId();

        $aMediaFile = $this->getConfig()->getUploadedFile("mediaFile");

        if ($aMediaFile['name']) {
            $myConfig = $this->getConfig();

            if ($myConfig->isDemoShop()) {
                $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\ExceptionToDisplay::class);
                $oEx->setMessage('ARTICLE_EXTEND_UPLOADISDISABLED');
                \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($oEx, false);

                return;
            }
        }

        //saving media file
        $sMediaUrl = $this->getConfig()->getRequestParameter("mediaUrl");
        $sMediaDesc = $this->getConfig()->getRequestParameter("mediaDesc");

        if (($sMediaUrl && $sMediaUrl != 'http://') || $aMediaFile['name'] || $sMediaDesc) {
            if (!$sMediaDesc) {
                return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay('EXCEPTION_NODESCRIPTIONADDED');
            }

            if ((!$sMediaUrl || $sMediaUrl == 'http://') && !$aMediaFile['name']) {
                return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay('EXCEPTION_NOMEDIAADDED');
            }

            $oMediaUrl = oxNew(\OxidEsales\Eshop\Application\Model\MediaUrl::class);
            $oMediaUrl->setLanguage($this->_iEditLang);
            $oMediaUrl->oxmediaurls__oxisuploaded = new \OxidEsales\Eshop\Core\Field(0, \OxidEsales\Eshop\Core\Field::T_RAW);

            //handle uploaded file
            if ($aMediaFile['name']) {
                try {
                    $sMediaUrl = \OxidEsales\Eshop\Core\Registry::getUtilsFile()->processFile('mediaFile', 'out/media/');
                    $oMediaUrl->oxmediaurls__oxisuploaded = new \OxidEsales\Eshop\Core\Field(1, \OxidEsales\Eshop\Core\Field::T_RAW);
                } catch (\Exception $e) {
                    return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($e->getMessage());
                }
            }

            //save media url
            $oMediaUrl->oxmediaurls__oxobjectid = new \OxidEsales\Eshop\Core\Field($soxId, \OxidEsales\Eshop\Core\Field::T_RAW);
            $oMediaUrl->oxmediaurls__oxurl = new \OxidEsales\Eshop\Core\Field($sMediaUrl, \OxidEsales\Eshop\Core\Field::T_RAW);
            $oMediaUrl->oxmediaurls__oxdesc = new \OxidEsales\Eshop\Core\Field($sMediaDesc, \OxidEsales\Eshop\Core\Field::T_RAW);
            $oMediaUrl->oxmediaurls__objecttype = new \OxidEsales\Eshop\Core\Field(MediaUrl::OBJECTTYPE_CATEGORY, \OxidEsales\Eshop\Core\Field::T_RAW);
            $oMediaUrl->save();
        }
    }

    /**
     * Updates existing media descriptions
     */
    public function updateMedia()
    {
        $aMediaUrls = $this->getConfig()->getRequestParameter('aMediaUrls');

        if (is_array($aMediaUrls)) {
            foreach ($aMediaUrls as $sMediaId => $aMediaParams) {
                $oMedia = oxNew(\OxidEsales\Eshop\Application\Model\MediaUrl::class);

                if ($oMedia->load($sMediaId)) {
                    $oMedia->setLanguage(0);
                    $oMedia->assign($aMediaParams);
                    $oMedia->setLanguage($this->_iEditLang);
                    $oMedia->save();
                }
            }
        }
    }

    /**
     * Deletes media url (with possible linked files)
     */
    public function deletemedia()
    {
        $soxId = $this->getEditObjectId();
        $sMediaId = $this->getConfig()->getRequestParameter("mediaid");

        if ($sMediaId && $soxId) {
            $oMediaUrl = oxNew(\OxidEsales\Eshop\Application\Model\MediaUrl::class);
            $oMediaUrl->load($sMediaId);
            $oMediaUrl->delete();
        }
    }

}
