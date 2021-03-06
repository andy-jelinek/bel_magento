<?php
/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2013 YesTheme.com. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      YesTheme.com
 * @email       support@yestheme.com
 */
class MT_Widget_Block_Widget
    extends Mage_Catalog_Block_Product_Abstract
    implements Mage_Widget_Block_Interface {

    protected $_productCollection;

    protected function _construct(){
        parent::_construct();
        $this->setData('cache_tags', array('MT_WIDGET'));
    }

    protected function _prepareLayout(){
        $head = $this->getLayout()->getBlock('head');
        $head->addJs('mt/extensions/jquery/jquery-1.9.1.min.js');
        $head->addJs('mt/extensions/jquery/plugins/flexslider/jquery.flexslider.js');
        $head->addJs('mt/widget/frontend.js');
        return parent::_prepareLayout();
    }

    public function getCacheLifetime(){
        return $this->getData('cache') ? (int)$this->getData('cache') : null;
    }

    public function getCacheKeyInfo(){
        return array(
            'MT_WIDGET',
            Mage::app()->getStore()->getId(),
            $this->getData('widget_type'),
            $this->getData('category_ids'),
            $this->getData('product_ids'),
            $this->getData('attribute'),
            $this->getData('attribute_mode'),
            $this->getData('block_ids'),
            $this->getData('mode'),
            $this->getData('scroll'),
            $this->getData('column'),
            $this->getData('namespace'),
            $this->getData('speed')
        );
    }

    protected function _beforeToHtml(){
        if ($this->getTemplate() == 'mt/widget/default.phtml'){
            switch ($this->getData('widget_type')){
                case 'product':
                    switch ($this->getData('mode')){
                        case 'related':
                            $this->setTemplate('mt/widget/related.phtml');
                            break;
                        default:
                            $this->setTemplate('mt/widget/product.phtml');
                            break;
                    }
                    break;
                case 'attribute':
                    $this->setTemplate('mt/widget/attribute.phtml');
                    break;
                case 'block':
                    $this->setTemplate('mt/widget/block.phtml');
                    break;
            }
        }
        return parent::_beforeToHtml();
    }

    public function getBlocks(){
        $blocks = array();
        $layout = $this->getLayout();
        $storeId = Mage::app()->getStore()->getId();

        $classes = array();
        $order = array();
        foreach(array('lg', 'md', 'sm', 'xs') as $l){
            foreach (explode('|', $this->getData('block_' . $l)) as $block){
                list($blockId, $column, $cls) = explode(',', $block);

                if (!isset($classes[$blockId])){
                    $classes[$blockId] = "col-{$l}-{$column} ";
                }else{
                    $classes[$blockId] .= "col-{$l}-{$column} ";
                }
                $classes[$blockId] .= "{$cls} ";

                if (!in_array($blockId, $order)) $order[] = $blockId;
            }
        }

        foreach ($order as $blockId){
            $collection = Mage::getModel('cms/block')
                ->getCollection()
                ->addFieldToFilter('identifier', array('eq' => $blockId));

            if ($collection->count()){
                $model = $collection->getFirstItem();
                $model->load($model->getId());
                $storeIds = $model->getStoreId();
                if ($model->getIsActive() && (in_array($storeId, $storeIds) || in_array(0, $storeIds))){
                    $blocks[] = array(
                        'class' => isset($classes[$blockId]) ? $classes[$blockId] : '',
                        'content' => $layout->createBlock('cms/block')->setStoreId()->setBlockId($blockId)->toHtml()
                    );
                }
            }
        }
        return $blocks;
    }

    public function getAttibuteOptions(){
        $showOptions = explode(',', $this->getData('attribute_options'));
        list($attributeId, $attributeCode) = explode(',' ,$this->getData('attribute'));
        $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attributeId)
            ->setStoreFilter()
            ->load();
        $options = array();
        foreach ($optionCollection as $option){
            if ($option->getImage() && in_array($option->getId(), $showOptions)){
                $options[] = array(
                    'id' => $option->getId(),
                    'label' => $option->getValue(),
                    'image' => $option->getImage(),
                    'link' => $this->getUrl('catalogsearch/result/index', array('q' => $option->getValue()))
                );
            }
        }
        if ($this->getData('attribute_mode') == 1 && $attributeCode){
            $productCollection = Mage::getResourceModel('catalog/product_collection')
                ->addStoreFilter()
                ->addAttributeToSelect($attributeCode)
                ->addAttributeToFilter($attributeCode, array('neq' => ''))
                ->addAttributeToFilter($attributeCode, array('notnull' => true));
            $optionsInUse = array_unique($productCollection->getColumnValues($attributeCode));
            foreach ($options as $i=>$option){
                if (in_array($option['id'], $optionsInUse)){
                    unset($options[$i]);
                }
            }
        }
        return $options;
    }

    public function getConfig($name){
        switch ($name){
            case 'move':
                return (int)$this->getData('move');
                break;
            case 'margin':
                return (int)$this->getData('margin');
                break;
            case 'widget_title':
                $title = $this->escapeHtml($this->getData('widget_title'));
                if (!$title){
                    switch ($this->getData('mode')){
                        case 'related':
                            $title = Mage::helper('catalog')->__('Related Products');
                            break;
                        case 'up':
                            $title = Mage::helper('catalog')->__('You may also be interested in the following product(s)');
                            break;
                        case 'cross':
                            $title = Mage::helper('catalog')->__('Based on your selection, you may be interested in the following items:');
                            break;
                    }
                }
                return $title;
                break;
            case 'responsive':
                $obj = new stdClass;
                $obj->type = $this->getData('responsive');
                $obj->data = $obj->type == 'width' ? (int)$this->getData('responsive_width') : $this->getData('responsive_bkp');
                $obj->margin = $this->getConfig('margin');
                return json_encode($obj);
                break;
            case 'paging':
                return $this->getData('paging') ? 'true' : 'false';
                break;
            case 'loop':
                return $this->getData('loop') ? 'true' : 'false';
                break;
            case 'speed':
                return is_numeric($this->getData('speed')) ? $this->getData('speed') : 5000;
                break;
            case 'autoplay':
                return $this->getData('autoplay') ? 'true' : 'false';
                break;
            case 'namespace':
                return $this->getData('namespace') ? $this->getData('namespace') : 'flex-';
                break;
            case 'id':
                return Mage::helper('core')->uniqHash('flexslider-');
                break;
            case 'column':
                return is_numeric($this->getData('column')) ? $this->getData('column') : 4;
                break;
            case 'row':
                return is_numeric($this->getData('row')) ? $this->getData('row') : 1;
                break;
            case 'mode':
                return 'grid';
                break;
            case 'scroll':
                return $this->getData('scroll');
                break;
            case 'limit':
                return is_numeric($this->getData('limit')) ? $this->getData('limit') : 1;
                break;
            default:
                return '';
                break;
        }
    }

    public function getLoadedProductCollection() {
        if (!$this->_productCollection){
            $mode = $this->_getData('mode');
            $collection = null;
            switch ($mode) {
                case 'new':
                    $collection = $this->getNewCollection();
                    break;
                case 'latest':
                    $collection = $this->getLatestCollection();
                    break;
                case 'bestsell':
                    $collection = $this->getBestSellerCollection();
                    break;
                case 'mostviewed':
                    $collection = $this->getMostViewedCollection();
                    break;
                case 'featured':
                    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'featured');
                    if($attribute->getId()) {
                        $collection = $this->getFeaturedCollection();
                    }
                    break;
                case 'random':
                default:
                    $collection = $this->getRandomCollection();
                    break;
                case 'specificed':
                    $collection = $this->getSpecificedCollection();
                    break;
                case 'related':
                    $collection = $this->_getRelatedCollection();
                    break;
                case 'up':
                    $collection = $this->_getUpSellCollection();
                    break;
                case 'cross':
                    $collection = $this->_getCrossSellCollection();
                    break;
            }
            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }

    protected function _getUpSellCollection(){
        $product = Mage::registry('product');
        /* @var $product Mage_Catalog_Model_Product */

        if ($product){
            $collection = $product->getUpSellProductCollection()
                ->setPositionOrder()
                ->addStoreFilter();

            if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')){
                Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($collection,
                    Mage::getSingleton('checkout/session')->getQuoteId()
                );
                $this->_addProductAttributesAndPrices($collection);
            }

            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

            $collection->setPage(1, $this->getLimit());
            $collection->load();

            /**
             * Updating collection with desired items
             */
            Mage::dispatchEvent('catalog_product_upsell', array(
                'product'       => $product,
                'collection'    => $collection,
                'limit'         => $this->getLimit()
            ));

            foreach ($collection as $product) {
                $product->setDoNotUseCategoryId(true);
            }

            return $collection;
        }
        return array();
    }

    protected function _getCrossSellCollection(){
        $product = Mage::registry('product');
        /* @var $product Mage_Catalog_Model_Product */

        if ($product){
            $collection = $product->getCrossSellProductCollection()
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->setPositionOrder()
                ->addStoreFilter();

            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

            $collection->setPage(1, $this->getLimit());
            $collection->load();

            foreach ($collection as $product) {
                $product->setDoNotUseCategoryId(true);
            }

            return $collection;
        }
        return array();
    }

    protected function _getRelatedCollection(){
        $product = Mage::registry('product');
        /* @var $product Mage_Catalog_Model_Product */

        if ($product){
            $collection = $product->getRelatedProductCollection()
                ->addAttributeToSelect('required_options')
                ->setPositionOrder()
                ->addStoreFilter();

            if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')){
                Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($collection,
                    Mage::getSingleton('checkout/session')->getQuoteId()
                );
                $this->_addProductAttributesAndPrices($collection);
            }

            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

            $collection->setPage(1, $this->getLimit());
            $collection->load();

            foreach ($collection as $product) {
                $product->setDoNotUseCategoryId(true);
            }

            return $collection;
        }
        return array();
    }

    public function getSpecificedCollection(){
        $catIds = explode(',', $this->getCategoryIds());
        $proIds = explode(',', $this->getProductIds());
        if($catIds) {
            $catProIds = $this->getProductIdsByCategories($catIds);
            $proIds = array_intersect($proIds, $catProIds);
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addIdFilter($proIds)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        } else {
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addStoreFilter()
                ->addUrlRewrite()
                ->addIdFilter($proIds)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addTaxPercents();
        }
        $products->setPage(1, $this->getLimit());
        $products->load();
        return $products;
    }

    public function getRandomCollection(){
        $catids = $this->getCategoryIds();
        $arr_productids = false;
        if ($catids) {
            $catIds = explode(',', $catids);
            $arr_productids = $this->getProductIdsByCategories($catIds);
        }
        $collection = Mage::getResourceModel('catalog/product_collection');
        if ($arr_productids) {
            $collection->addIdFilter($arr_productids);
        }
        Mage::getModel('catalog/layer')->prepareProductCollection($collection);
        $collection->getSelect()->order('rand()');
        $collection->addStoreFilter();
        $collection->setPage(1, $this->getLimit());
        return $collection;
    }

    public function getNewCollection(){
        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $catids = $this->getCategoryIds();
        if($catids) {
            $catIds = explode(',', $catids);
            $arr_productids = $this->getProductIdsByCategories($catIds);
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addIdFilter($arr_productids)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
                ->addAttributeToFilter(array(
                    array('attribute' => 'news_to_date', 'date' => true, 'from' => $todayDate),
                    array('attribute' => 'news_to_date', 'is' => new Zend_Db_Expr('null'))),
                    '',
                    'left')
                ->addAttributeToSort('news_from_date', 'desc');
        } else {
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
                ->addAttributeToFilter(array(
                    array('attribute' => 'news_to_date', 'date' => true, 'from' => $todayDate),
                    array('attribute' => 'news_to_date', 'is' => new Zend_Db_Expr('null'))),
                    '',
                    'left')
                ->addAttributeToSort('news_from_date', 'desc');
        }
        $products->setPage(1, $this->getLimit());
        $products->load();
        return $products;
    }

    public function getLatestCollection($fieldorder='updated_at', $order='desc') {
        $catIds = $this->getCategoryIds();
        if($catIds) {
            $catIds = explode(',', $catIds);
            $proIds = $this->getProductIdsByCategories($catIds);
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addIdFilter($proIds)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setOrder($fieldorder, $order);
        } else {
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addStoreFilter()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setOrder($fieldorder, $order);
        }
        $products->setPage(1, $this->getLimit());
        $products->load();
        return $products;
    }

    public function getBestSellerCollection() {
        $catIds = $this->getCategoryIds();
        if($catIds) {
            $catIds = explode(',', $catIds);
            $ctf = array();
            foreach ($catIds as $cat){
                $ctf[]['finset'] = $cat;
            }
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*')->addStoreFilter();
            $products->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
                     ->addAttributeToFilter('category_id', array($ctf));
        } else {
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*')->addStoreFilter();
        }
        $orderItems = $this->getTableName('sales/order_item');
        $orderMain = $this->getTableName('sales/order');
        $products->getSelect()
            ->join(array('items' => $orderItems), "items.product_id = e.entity_id", array('count' => 'SUM(items.qty_ordered)'))
            ->join(array('trus' => $orderMain), "items.order_id = trus.entity_id", array())
            ->where('trus.status = ?', 'complete')
            ->group('e.entity_id')
            ->order('count DESC');
        $products->setPage(1, $this->getLimit());
        $products->load();
        return $products;
    }

    public function getMostViewedCollection() {
        $catIds = $this->getCategoryIds();
        if($catIds) {
            $catIds = explode(',', $catIds);
            $arr_productids = $this->getProductIdsByCategories($catIds);
            $products = Mage::getResourceModel('reports/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addViewsCount()
                ->addIdFilter($arr_productids);
        } else {
            $products = Mage::getResourceModel('reports/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addViewsCount();
        }
        $products->setPage(1, $this->getLimit());
        $products->load();
        return $products;
    }

    public function getFeaturedCollection() {
        $catIds = $this->getCategoryIds();
        if($catIds) {
            $catIds = explode(',', $catIds);
            $arr_productids = $this->getProductIdsByCategories($catIds);
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addIdFilter($arr_productids)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter("featured", 1);
        } else {
            $products = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter()
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter("featured", 1);
        }
        $products->setPage(1, $this->getLimit());
        $products->load();
        return $products;
    }

    public function getProductsByCategory($catId) {
        $storeId    = Mage::app()->getStore()->getId();
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->addMinimalPrice()
            ->addTaxPercents();
        if($catId) {
            $category = Mage::getModel('catalog/category')->load($catId, array('entity_id'));
            if($category->getId()) {
                $collection->addCategoryFilter($category);
            }
        }
        return $collection;
    }

    public function getProductIdsByCategories($catIds) {
        $productIds = array();
        if(count($catIds)) {
            foreach($catIds as $catId) {
                $productIdArr = $this->getProductsByCategory($catId);
                if(count($productIdArr)) {
                    foreach($productIdArr as $product) {
                        $productIds[] = $product->getId();
                    }
                }
            }
        }
        $productIds = array_unique($productIds);
        return $productIds;
    }

    public function getTableName($modelEntity) {
        try {
            $table = Mage::getSingleton('core/resource')->getTableName($modelEntity);
        } catch (Exception $e){
            Mage::throwException($e->getMessage());
        }
        return $table;
    }
}