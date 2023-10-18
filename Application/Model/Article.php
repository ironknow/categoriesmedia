<?php

namespace test\CategoriesMedia\Application\Model;

/**
 * Class Article
 * @package test\CategoriesMedia\Application\Model
 */
class Article extends Article_parent
{
    /**
     * Return article media URL
     *
     * @return array
     */
    public function getMediaUrls()
    {
        if ($this->_aMediaUrls === null) {
            $this->_aMediaUrls = oxNew(\OxidEsales\Eshop\Core\Model\ListModel::class);
            $this->_aMediaUrls->init("oxmediaurl");
            $this->_aMediaUrls->getBaseObject()->setLanguage($this->getLanguage());

            $sViewName = getViewName("oxmediaurls", $this->getLanguage());
            $sQ = "select * from {$sViewName} where oxobjectid = :oxobjectid and objecttype = :objecttype";
            $this->_aMediaUrls->selectString($sQ, [
                ':oxobjectid' => $this->getId(),
                ':objecttype' => MediaUrl::OBJECTTYPE_ARTCILE
            ]);
        }

        return $this->_aMediaUrls;
    }
}
