<?php

class Mage_Catalog_Block_Product_IteamoAllProductsPage extends Mage_Catalog_Block_Product_Abstract {

    protected $_productsCount=null;
    protected $_defaultToolbarBlock="catalog/product_list_toolbar";

    const DEFAULT_PRODUCTS_COUNT="";

// NEW FUNCTIONAL <<< ====================
    /**
     *
     */
    public function __construct() {
        $this->addToCart();
        // DEBUG <<<
        // echo '$_REQUEST'; echo '<hr>'; print_r($_REQUEST); echo '<hr>';
        // echo '$_SERVER'; echo '<hr>'; print_r($_SERVER); echo '<hr>';
        // >>> DEBUG  
    }

    /**
     *
     */
    public function addToCart() {
        $arToBasket=array();
        $arToBasket=$_REQUEST['arToBasket'];
        if (!empty($arToBasket)) {
            $cart=Mage::getModel("checkout/cart");
            foreach ($arToBasket as $entityId=> $quantity)
                if ($quantity > 0) {
                    try {
                        $cart->addProduct($entityId,$quantity);
                    } catch (Exception $e) {
                        
                    }
                }
            $cart->save();
            // DEBUG <<<
            // echo '$_SERVER'; echo '<hr>'; print_r($_SERVER); echo '<hr>';
            // die();
            // >>> DEBUG                  
            Mage::app()->getFrontController()->getResponse()->setRedirect($_SERVER['REQUEST_URI']);    
        }
        // DEBUG <<<
        // echo '$_REQUEST'; echo '<hr>'; print_r($_REQUEST); echo '<hr>';    
        // >>> DEBUG  
    }

    /**
     *
     */
    public function getCategoriesTree() {
        $category=Mage::getModel('catalog/category');
        $tree=$category->getTreeModel();
        $tree->load();
        $ids=$tree->getCollection()
                ->addAttributeToSelect('is_active')
                ->getAllIds();
        $arr=array();
        if ($ids)
            foreach ($ids as $id)
                if ($id > 2) {
                    $objCategory=Mage::getModel('catalog/category');
                    $objCategory->load($id);
                    if (
                            $objCategory->getIncludeInMenu() && $objCategory->getIsActive() && ($objCategory->getLevel() < 4)
                    ) {
                        // DEBUG <<<      
                        // echo "<a href=" . $objCategory->getUrl() . ">" . $objCategory->getName() . "</a>"; echo '<hr>'; 
                        // echo '$objCategory'; echo '<hr>'; print_r($objCategory); echo '<hr>';      
                        // >>> DEBUG
                    }
                }
    }

    /**
     *
     */
    public function getAllCategories() {
        $collectionCat=Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('is_active');
        foreach ($collectionCat as $objCategory) {
            $objCategory->getChildren();
            // DEBUG <<<      
            // echo '$cat'; echo '<hr>'; print_r($cat->getChildren()); echo '<hr>'; 
            // echo '$objCategory'; echo '<hr>'; print_r($objCategory); echo '<hr>';      
            // >>> DEBUG           
        }
        // DEBUG <<<
        // echo '$arObjProducts'; echo '<hr>'; print_r($arObjProducts); echo '<hr>';
        // die();
        // >>> DEBUG 
        return $collectionCat;
    }

    /**
     *
     */
    public function getAdditionalInfo($arObjProducts=array()) {
        foreach ($arObjProducts as $key=> $objProduct) {
            $objProduct->arCategories=$objProduct->getCategoryIds(); // ar_categories
        }
        // DEBUG <<<
        // echo '$arObjProducts'; echo '<hr>'; print_r($arObjProducts); echo '<hr>';
        // die();
        // >>> DEBUG   
        return $arObjProducts;
    }

    /**
     *
     */
    public function additionalFilter($arObjProducts=array()) {
        foreach ($arObjProducts as $key=> $objProduct) {
            if (!$objProduct->stock_item->is_in_stock) {
                // unset($arObjProducts[$key]);
            }
            // DEBUG <<<
            // echo '$objProduct->stock_item'; echo '<hr>'; print_r($objProduct->stock_item->is_in_stock); echo '<hr>';
            // >>> DEBUG
        }
        // DEBUG <<<
        // echo '$arObjProducts'; echo '<hr>'; print_r($arObjProducts); echo '<hr>';
        // die();
        // >>> DEBUG   
        return $arObjProducts;
    }

    /**
     *
     */
    public function getProductsByCategory($arObjProducts=NULL) {
        $arProductsByCategory=array();
        $objCategory=Mage::getModel('catalog/category');
        $objParentCategory=Mage::getModel('catalog/category');
        foreach ($arObjProducts as $objProduct) {
            // /*
            foreach ($objProduct->ar_categories as $categoryId) {
                $objCategory->load($categoryId);
                if ($objCategory->getName() != 'Товары для главной страницы') {
                    $objParentCategory->load($objCategory->parent_id);
                    $arCategory['arRoot']['name']=$objParentCategory->getName();
                    $arCategory['arLast']['name']=$objCategory->getName();
                    if ($objProduct->getName() == 'КТЛ с перфорацией') {
                        // echo '$objCategory->getParentCategory()'; echo '<hr>'; print_r($objCategory->getParentCategory()); echo '<hr>';
                        // echo $objCategory->parent_id;
                        // print_r($objParentCategory);
                        // echo '$objCategory'; echo '<hr>'; print_r($objCategory); echo '<hr>';
                        // echo $arCategory['arRoot']['name']; echo '  <hr>';
                        // echo $arCategory['arLast']['name']; echo '  <br>';
                    }
                    // echo '$arCategory'; echo '<hr>'; print_r($arCategory); echo '<hr>';                
                    if ($objParentCategory->getId() == $_REQUEST['section'])
                        $arProductsByCategory[$arCategory['arRoot']['name']][$arCategory['arLast']['name']][$objProduct->getProductUrl()]=$objProduct;
                }
            }
            // DEBUG <<<
            // if ($objProduct->entity_id > 50) $arCategory['name'] = 'test';
            // >>> DEBUG
            // */                 
        }
        // DEBUG <<<
        // echo '$arProductsByCategory'; echo '<hr>'; print_r($arProductsByCategory); echo '<hr>';
        // die();
        // >>> DEBUG     
        return $arProductsByCategory;
    }

// >>> NEW FUNCTIONAL ====================
// STANDART FUNCTIONAL <<< ===============
    /**
     *
     */
    protected function _beforeToHtml() {
        $collection=Mage::getResourceModel("catalog/product_collection");
        Mage::getSingleton("catalog/product_status")->addVisibleFilterToCollection($collection);
        // Mage::getSingleton("catalog/product_visibility")->addVisibleInCatalogFilterToCollection($collection);
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);
        $collection=$this->_addProductAttributesAndPrices($collection)
                ->addStoreFilter()
                ->setPageSize($this->getProductsCount())
                ->addAttributeToFilter('type_id',array('in'=>array('simple','bundle')))           // virtual bundle grouped configurable
                // ->addAttributeToFilter('is_salable', '1')
                // ->addAttributeToFilter('required_options', '0')          
                // ->addAttributeToFilter('visibility', '4')
                // ->addCategoryFilter($category)    
                ->addAttributeToSort('name','ASC')
                ->setCurPage(1)
        ;
        $collection=$this->getAdditionalInfo($collection);
        // $collection = $this->additionalFilter($collection);
        $this->setProductCollection($collection);
        // ===
        // $this->getCategoriesTree();
        // 
        /*
          Mage::dispatchEvent("catalog_block_product_list_collection", array(
          "collection"=>$collection,
          ));
          return parent::_beforeToHtml();
          // */
    }

    /**
     *
     */
    public function getToolbarBlock() {
        if ($blockName=$this->getToolbarBlockName()) {
            if ($block=$this->getLayout()->getBlock($blockName)) {
                return $block;
            }
        }
        $block=$this->getLayout()->createBlock($this->_defaultToolbarBlock,microtime());
        return $block;
    }

// >>> STANDART FUNCTIONAL ===============
}

?>
<?php

// TEMP <<<
/*
  $cart = Mage::getModel("checkout/cart");
  $cart->addProduct($entityId, $qty);
  $cart->save();
  ====
  $collection = Mage::getModel('catalog/product')
  ->getCollection()
  ->addAttributeToSelect('*');
  foreach ($collection as $product) {
  echo $product->getName() . "<br />";
  }
  ===
  Mage::app("default")->setCurrentStore( Mage_Core_Model_App::ADMIN_STORE_ID );

  $products = Mage::getModel('catalog/product')->getCollection()
  ->addAttributeToFilter('type_id', 'simple') //тип продукта simple, configurable...
  ->addAttributeToFilter('visibility', '4') //видимость, 4-видимый в каталоге и в поиске
  ->addAttributeToSort('sku', 'ASC'); //сортировка
  ===
  $_cat         = $this->getProduct()->getCategory();
  $_parent_cat  = $_cat->getParentCategory()->getName();
  // */
// >>> TEMP
?>