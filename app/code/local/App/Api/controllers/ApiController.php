<?php
/**
 * Created by PhpStorm.
 * User: shaun
 * Date: 15-10-8
 * Time: 上午9:52
 */
class App_Api_ApiController extends Mage_Core_Controller_Front_Action{

    public function IndexAction(){
        $str = Mage::getSingleton('api/api');
        echo get_class($str);exit;
    }

    /**
     * get categories tree
     */
    public function get_categories($categories){
        //这里的变量 $array 将存储的是所有目录信息
        $array = '<ul>';

        foreach ($categories as $category) {
            $cat    = Mage::getModel('catalog/category')->load($category->getId());
            $count  = $cat->getProductCount(); //$count 是该目录含有产品的数量

            $array .= '<li>'
                . '<a href="' . Mage::getUrl($cat->getUrlPath()). '">' //获得到目录的 URL
                . $category->getName() //显示目录名称
                . "(".$count.")</a>"; //显示目录中产品数量

            if ($category->hasChildren()) { //检查该目录是否含有子目录，如果有，则递归生成子目录
                $children = Mage::getModel('catalog/category')
                    ->getCategories($category->getId());
                $array  .=  $this->get_categories($children); //递归生成子目录
            }
            $array .= '</li>';
        }
        return  $array . '</ul>';
    }

    /**
     * new customer session
     */
    public  function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * new shop cart session
     */
    public function _getCartSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * new product action
     */
    public function _newProduct(){
        return Mage::getModel('catalog/product');
    }

    /**
     * new category action
     */
    public function _newCategory(){
        return Mage::getModel('catalog/category');
    }

    /**
     * new user action
     */
    public function _newCustomer(){
        return Mage::getModel('customer/customer');
    }

    /**
     * new order action
     */
    public function _newOrder(){
        return Mage::getModel('sales/order');
    }

    /**
     * new cart action
     */
    public function _newCart(){
        return Mage::getModel('checkout/cart');
    }

    /**
     * new customer address action
     */
    public function _newAddress(){
        return Mage::getModel('customer/address');
    }

    /**
     * api for user sign in
     */
    public function signInAction(){
        Mage::log("receive sign action.");
        $paras = $this->getRequest()->getParams();
        if(empty($paras)){
            echo Zend_Json::encode(array("success" => false, "data" => "parameter can not be empty."));return;
        }
        $session = $this->_getSession();
        $code = $session->getData('mcode');
        if(!$code || $code['mobile'] != $paras['phone'] || $code['secret'] != $paras['secret']){
            echo Zend_Json::encode(array("success" => false, "data" => "verify phone failed."));return;
        }
        $cus_model = $this->_newCustomer();
        $customer = $cus_model->getCollection()
            ->addAttributeToFilter('phone',$paras['phone'])
            ->getFirstItem();
        if($customer->getData('entity_id')){
            echo Zend_Json::encode(array("success" => false, "data" => "phone or email already exists."));return;
        }else{
            $customer = $this->_newCustomer();
            $customer->setGroupId(1);
            $customer->setEmail($paras['email']);
            $customer->setFirstname($paras['name']);
            $customer->setLastname($paras['name']);
            $customer->setPassword($paras['password']);
            $customer->setPhone($paras['phone']);
            $customer->setConfirmation(null);
            $customer->save();
            $data = $customer->getData();
            if(!empty($data)){
                $session = $this->_getSession();
                $session->login($paras['email'],$paras['password']);
                echo Zend_Json::encode(array("success" => true, "data" => $data));return;
            }else{
                echo Zend_Json::encode(array('success' => false, 'data' => 'sign in failed.'));
            }
        }

    }

    /**
     * verify message function
     *
     */
    public function _verifyMessage($mobile,$secret){
        $this->getResponse()->setHeader('Content-Type',"application/json; charset=utf-8");

        $apiKey = "8cbe3cf619b14d74ae88b4ce7679ed66";
        $appId = "98HIH8VJdj02";
        $content = "【佳杰科技】您的验证码为：".$secret."，五分钟内有效，请尽快验证。";
        $url = "https://sms.zhiyan.net/sms/match_send.json";
        $json_arr = array(
            "mobile" => $mobile,
            "content" => $content,
            "appId"=>$appId,
            "apiKey"=>$apiKey,
            "extend" => "",
            "uid" => ""
        );
        $array =json_encode($json_arr);
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec ($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * api for verify message
     */
    public function sendSmsAction(){
        Mage::log("receive verify message action.");
        $mobile = $this->getRequest()->getParam('mobile',15210010339);
        if(!$mobile){
            echo Zend_Json::encode(array("success" => false, "data" => "phone must be provided."));return;
        }
        $secret = rand(100000, 999999);
        $result = $this->_verifyMessage($mobile,$secret);
        $res = json_decode($result,true);
        if($res['result'] == "SUCCESS"){
            $this->_getSession()->setData('mcode', array('mobile'=>$mobile, 'secret'=>$secret));
            echo Zend_Json::encode(array("success" => true, "data" => "send sms successfully."));return;
        }else{
            echo Zend_Json::encode(array("success" => false, "data" => $res['reason']));
        }
    }

    /**
     * api for user login
     */
    public function loginAction(){
        Mage::log("receive login action");
        $session = $this->_getSession();
        if($session->isLoggedIn()){
            $customerData = $session->getCustomer()->getData();
            echo Zend_Json::encode(array("success" => true, "data" => $customerData));return;
        }
        $paras = $this->getRequest()->getParams();
        if(empty($paras['username']) || empty($paras['password'])){
            echo Zend_Json::encode(array("success" => false, "data" => "email or password can not be empty."));return;
        }
        // if username is phone , then select email by phone
        if(!strstr($paras['username'],'@') && strlen($paras['username']) == 11){
            $mobileNu = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToFilter('phone', $paras['username'])
                ->getFirstItem();
            if($mobileNu->getData('email')){
                $paras['username'] = $mobileNu->getData('email');
            }else{
                echo Zend_Json::encode(array("success" => false, "data" => "phone is not exists."));
            }
        }
        try{
            $session->login($paras['username'],$paras['password']);
            $customerData = $session->getCustomer()->getData();
            echo Zend_Json::encode(array("success" => true, "data" => $customerData));return;
        } catch(Exception $e){
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));
        }
    }

    /**
     * api for user logout
     */
    public function logoutAction(){
        Mage::log("receive logout action.");
        $this->_getSession()->logout()
            ->renewSession()
            ->setBeforeAuthUrl($this->_getRefererUrl());

        echo Zend_Json::encode(array("success" => true, "data" => "logout successfully."));
    }

    /**
     * api for user to change password
     */
    public function changePasswordAction(){
        Mage::log("receive change password action.");
        $paras = $this->getRequest()->getParam('password',false);
        $session = $this->_getSession();
        $customerId = $session->getCustomerId();
        Mage::log("get customerId is :".$customerId);
        Mage::log("get password is :".$paras);
        if($customerId){
            $customer = $this->_newCustomer();
            $customer->load($customerId);
            $customer->setPassword($paras);
            $customer->save();
            $customer_data = $session->getCustomer()->getData();
            echo Zend_Json::encode(array("success" => true, "data" => "$customer_data"));
        }else{
            echo Zend_Json::encode(array("success" => false, "data" => "change password failed, please try again."));
        }
    }

    /**
     * api for post send sms code
     */
    public function postSmsCodeAction(){
        Mage::log("receive post sms code action.");
        $paras = $this->getRequest()->getParams();
        //$paras = array("mobile" => 15210010339, "secret" => 847399);
        $session = $this->_getSession();
        $mCode = $session->getData('mcode');
        if(empty($paras)){
            echo Zend_Json::encode(array("success" => false, "data" => "mobile and secret must be provided."));return;
        }
        if(!$mCode || $mCode['mobile'] != $paras['mobile'] || $mCode['secret'] != $paras['secret']){
            echo Zend_Json::encode(array("success" => false, "data" => "mobile and secret not matched."));return;
        }
        echo Zend_Json::encode(array("success" => true, "data" => "verify successfully."));return;
    }

    /**
     * api for user to forget password
     */
    public function resetPasswordAction(){
       Mage::log("receive forgot password action.");
       $session = $this->_getSession();
       $password = $this->getRequest()->getParam("password",false);
       if(!$password){
           echo Zend_Json::encode(array("success" => false, "data" => "password can not be empty."));return;
       }
       $mCode = $session->getData('mcode');
       $customer = $this->_newCustomer();
       $customer->load('phone',$mCode['mobile']);
       $email = $customer->getData('email');
       if(!empty($email)){
           $customer->setPassword($password);
           $customer->save();
           $session->login($email,$password);
           $customer_data = $session->getCustomer()->getData();
           echo Zend_Json::encode(array("success" => true, "data" => $customer_data));return;
       }else{
           echo Zend_Json::encode(array("success" => false, "data" => "reset password failed."));return;
       }
    }

    /**
     * api for edit user info
     */
    public function editUserInfoAction(){
        Mage::log("receive edit user info action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("success" => false, "data" => "please login first."));
        }
        $paras = $this->getRequest()->getParams();
        $customer = $this->_newCustomer();
        if($paras['name']){
            $customer->setName($paras['name']);
        }
        if($paras['gender']){
            $customer->setGender($paras['gender']);
        }

        try{
            $customer->save();

            echo Zend_Json::encode(array("success" => true));
        }catch (Exception $e){
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));
        }

    }

    /**
     * api for list categories
     */
    public function listCategoriesAction(){
        Mage::log("receive list category action.");
        $cate = $this->_newCategory()->getCategories(Mage::app()->getStore()->getRootCategoryId());
        $categories = $this->get_categories($cate);

        //echo Zend_Json::encode(array("success" => true, "data" => $categories));
        echo $categories;

    }

    /**
     * api for list products
     */
    public function listProductsAction(){
        Mage::log("receive list products action");
        $session = $this->_getSession();
        /*if (!$session->isLoggedIn()) {
            echo Zend_Json::encode(array("success" => false,"data" => "please login first."));return;
        }*/
        $customerId = $session->getCustomerId();
        Mage::log("get customer id is :".$customerId);
        $page = $this->getRequest()->getParam("page",1);
        $pageSize = $this->getRequest()->getParam("pageSize",10);
        $orderBy = $this->getRequest()->getParam("orderBy","price");
        $sort = $this->getRequest()->getParam("sort","asc");
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $groupId = $customer->getData('groupId');
        $products = Mage::getModel('catalog/product');
        $list = $products->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToSort($orderBy,$sort)
            ->setCurPage($page)
            ->setPageSize($pageSize)
            ->load();
        $arr = array();
        foreach($list as $pro){
            if($groupId == 2){
                $price = $pro->getData('price');
            }else{
                $price = '暂无报价';
            }
            $arr[] = array("id" => $pro->getData('entity_id'),
                     "sku" => $pro->getData('sku'),
                     "name" => $pro->getData('name'),
                     "image" => Mage::getBaseUrl('media').'catalog/product'.$pro->getData('small_image'),
                     "price" => $price);
        }
        echo Zend_Json::encode(array("success" => true, "data" => $arr));
    }

    /**
     * api for get products by category
     */
    public function getProductByCategoryAction(){
        Mage::log("receive get product by category action.");
        $session = $this->_getSession();
        $customerId = $session->getCustomerId();
        Mage::log("get customer id is :".$customerId);
        $categoryId = $this->getRequest()->getParam('categoryId');
        $sortColumn = $this->getRequest()->getParam('sortColumn');
        $sort = $this->getRequest()->getParam('sort');
        $page = $this->getRequest()->getParam('page');
        $pageSize = $this->getRequest()->getParam('pageSize');
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $groupId = $customer->getData('groupId');
        $product = $this->_newProduct()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("category_id",$categoryId)
            ->addAttributeToSort($sortColumn,$sort)
            ->setCurPage($page)
            ->setPageSize($pageSize)
            ->load();
        $arr = array();
        foreach($product as $pro){
            if($groupId == 2){
                $price = $pro->getData('price');
            }else{
                $price = '暂无报价';
            }
            $arr[] = array("id" => $pro->getData('entity_id'),
                "sku" => $pro->getData('sku'),
                "name" => $pro->getData('name'),
                "image" => Mage::getBaseUrl('media').'catalog/product'.$pro->getData('small_image'),
                "price" => $price);
        }
        echo Zend_Json::encode($arr);
    }

    /**
     * api for product info
     */
    public function productInfoAction(){
        Mage::log("receive product info action.");
        $productId = $this->getRequest()->getParam("product_id",false);
        if(!$productId){
            echo Zend_Json::encode(array("error" => "the product id must be provided."));return;
        }
        $session = $this->_getSession();
        $customerId = $session->getCustomerId();
        Mage::log("get customer id is :".$customerId);
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $groupId = $customer->getData('groupId');
        $product = $this->_newProduct()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("entity_id",$productId)
            ->load();
        $arr = array();
        foreach($product as $pro){
            if($groupId == 2){
                $price = $pro->getData('price');
            }else{
                $price = '暂无报价';
            }
            $arr[] = array("id" => $pro->getData('entity_id'),
                "sku" => $pro->getData('sku'),
                "name" => $pro->getData('name'),
                "image" => Mage::getBaseUrl('media').'catalog/product'.$pro->getData('small_image'),
                "price" => $price);
        }
        echo Zend_Json::encode(array("success" => true, "data" => $arr));
    }

    /**
     * init product function
     */
    protected function _initProduct($productId)
    {
        //$productId = (int) $this->getRequest()->getParam($product_id);
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }

    /**
     * go back function
     */
    protected function _goBack()
    {
        $returnUrl = $this->getRequest()->getParam('return_url');
        if ($returnUrl) {

            if (!$this->_isUrlInternal($returnUrl)) {
                throw new Mage_Exception('External urls redirect to "' . $returnUrl . '" denied!');
            }

            $this->_getSession()->getMessages(true);
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()
        ) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            $this->_redirect('checkout/cart');
        }
        return $this;
    }

    /**
     * api for add shop cart
     */
    public function addCartAction(){
        Mage::log("receive add cart action.");
        $cart = $this->_newCart();
        $params = $this->getRequest()->getParams();
        //$params = array("qty" => 100, "product_id" => 2);
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct($params['product_id']);
            $related = $this->getRequest()->getParam('related_product');
            /**
             * Check product availability
             */
            if (!$product) {
                echo Zend_Json::encode(array("success" => false, "data" => "no this product."));
                return;
            }
            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getCartSession()->setCartWasUpdated(true);

            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );

            if (!$this->_getCartSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()) {
                    //$message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
                    //$this->_getCartSession()->addSuccess("add ".$product->getName()." success.");
                    echo Zend_Json::encode(array("success" => true, "data" => "add product to cart successfully."));return;
                }
            }
        } catch (Mage_Core_Exception $e) {
            //echo $e->getMessage();
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));return;
        }
    }

    /**
     * api for shop cart
     */
    public function cartAction(){
        Mage::log("receive cart action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn())
        {
            echo Zend_Json::encode(array('error' => 'please login first.'));return;
        }
        $cart = $this->_newCart();

        $items = $cart->getQuote()->getAllItems();
        $arr = array();
        $arr['count'] = $cart->getQuote()->getItemsCount();
        $arr['total_price'] = $cart->getQuote()->getGrandTotal();
        foreach($items as $item){
            $arr['data'][] = array("productId" => $item->getProductId(),
                    "productName"      => $item->getName(),
                    "sku"              => $item->getSku(),
                    "qty"              => $item->getQty(),
                    "price"            => $item->getPrice(),
                    "total_price"      => $item->getRow_total()
            );
        }
        echo Zend_Json::encode(array("success" => true, "data" => $arr));return;

    }

    /**
     * api for update cart
     */
    public function updateCartAction(){
        Mage::log("receive update cart action.");
        $updateAction = (string)$this->getRequest()->getParam('update_cart_action');
        Mage::log("update action is :".$updateAction);
        switch ($updateAction) {
            case 'empty_cart':
                $this->_emptyShoppingCart();
                break;
            case 'update_qty':
                $this->_updateShoppingCart();
                break;
            default:
                $this->_updateShoppingCart();
        }
    }

    /**
     * Update customer's shopping cart
     */
    protected function _updateShoppingCart()
    {
        try {
            $cartData = $this->getRequest()->getParam('cart');
            //$cartData = array("7" => array("qty" => 12),"8" => array("qty" => 12));
            if (is_array($cartData)) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                foreach ($cartData as $index => $data) {
                    if (isset($data['qty'])) {
                        $cartData[$index]['qty'] = $filter->filter(trim($data['qty']));
                    }
                }
                $cart = $this->_newCart();
                if (! $cart->getCustomerSession()->getCustomer()->getId() && $cart->getQuote()->getCustomerId()) {
                    $cart->getQuote()->setCustomerId(null);
                }

                $cartData = $cart->suggestItemsQty($cartData);
                $cart->updateItems($cartData)
                    ->save();
            }
            $this->_getSession()->setCartWasUpdated(true);
            echo Zend_Json::encode(array("success" => true, "data" => "update cart item successfully."));return;
        } catch (Mage_Core_Exception $e) {
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));
        }
    }

    /**
     * Empty customer's shopping cart
     */
    protected function _emptyShoppingCart()
    {
        try {
            $this->_newCart()->truncate()->save();
            $this->_getSession()->setCartWasUpdated(true);
            echo Zend_Json::encode(array("success" => true, "data" => "empty shopping cart successfully."));return;
        } catch (Mage_Core_Exception $exception) {
            //$this->_getSession()->addError($exception->getMessage());
            echo Zend_Json::encode(array("success" => false, "data" => $exception->getMessage()));return;
        }
    }

    /**
     * api for delete cart
     */
    public function deleteCartAction(){
        Mage::log("receive delete cart action.");
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->_newCart()->removeItem($id)
                    ->save();
                echo Zend_Json::encode(array("success" => true, "data" => "delete cart item true."));
            } catch (Exception $e) {
                echo Zend_Json::encode(array("success" => false, "data" => "delete cart item error."));return;
            }
        }
        echo Zend_Json::encode(array("success" => false, "data" => "item id must be provided."));
    }

    /**
     * api for order list
     */
    public function orderListAction(){
        Mage::log("receive order list action.");
        $session = $this->_getSession();
        $customerId = $session->getCustomerId();
        Mage::log("get customer id is :".$customerId);
        if(!$customerId){
            echo Zend_Json::encode(array("error" => "please login in first."));return;
        }
        $order = $this->_newOrder()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("customer_id",$customerId)
            ->load();
        $arr = array();
        foreach($order as $list){
            $arr[] = array("id" => $list->getData("entity_id"),
                "status" => $list->getData("status"),
                "order_code" => $list->getData("increment_id"),
                "order_price" => $list->getData("subtotal"),
                "total_price" => $list->getData("grand_total"),
                "express" => $list->getData("shipping_amount"),
                "order_qty" => $list->getData("total_qty_ordered"),
                "order_date" => $list->getData("created_at"),
                "customer_name" => $list->getData("customer_lastname").$list->getData("customer_firstname"),
                "customer_email" => $list->getData("customer_email")
            );
        }
        echo Zend_Json::encode(array("success" => true, "data" => $arr));
    }

    /**
     * api for order info
     */
    public function orderInfoAction(){
        Mage::log("receive order info action.");
        $order_id = $this->getRequest()->getParam('id',false);
        if(!$order_id){
            echo Zend_Json::encode(array('error' => 'order id must be provided.'));return;
        }
        //product items
        //http://blog.sina.com.cn/s/blog_8a69598a0101kbsr.html
        //todo 根据实际需要的字段来展示对应的数据
        $data = array();
        $order = $this->_newOrder()->load($order_id);
        foreach($order->getAllItems() as $item){
            $data[] = $item->getData();
        }
        echo Zend_Json::encode(array("success" => true, "data" => $data));
    }

    /**
     * api for cancel order
     */
    public function cancelOrderAction(){
        Mage::log("receive cancel order action.");
        $order_id = $this->getRequest()->getParam("id",false);
        if(!$order_id){
            echo Zend_Json::encode(array("error" => "order id must be provided."));return;
        }
        $order = $this->_newOrder()->load($order_id);
        $res = $order->cancel();
        echo Zend_Json::encode(array("success" => true, "data" => $res));
    }

    /**
     * api for save order
     */
    public function saveOrderAction(){
        Mage::log("receive save order action.");
        //填写客户的 Id 号
        $session = $this->_getSession();
        $customerId = $session->getCustomerId();
        $customer   = Mage::getModel('customer/customer')->load($customerId);
        //use transaction
        $transaction     = Mage::getModel('core/resource_transaction');
        $storeId         = $customer->getStoreId();
        $reservedOrderId = Mage::getSingleton('eav/config')->getEntityType('order')
            ->fetchNewIncrementId($storeId);
        //echo $reservedOrderId;exit;
        $order = Mage::getModel('sales/order');
        $order->setIncrementId($reservedOrderId)
            ->setStoreId($storeId)
            ->setQuoteId(0)
            ->setGlobal_currency_code('CN')
            ->setBase_currency_code('CN')
            ->setStore_currency_code('CN')
            ->setOrder_currency_code('CN');
        //这里我设置成'CN', 你可以根据自己的需求修改或添加

        //保存用户信息
        $order->setCustomer_email($customer->getEmail())
            ->setCustomerFirstname($customer->getFirstname())
            ->setCustomerLastname($customer->getLastname())
            ->setCustomerGroupId($customer->getGroupId())
            ->setCustomer_is_guest(0)
            ->setCustomer($customer);
        // 保存 Billing Address
        try{
            $addressId = $this->getRequest()->getParam('address_id',false);
            if(!$addressId){
                $address = Mage::getModel('customer/address');
                $addressForm = Mage::getModel('customer/form');
                $addressForm->setFormCode('customer_address_edit')
                    ->setEntity($address);
                //$addressData    = $addressForm->extractData($this->getRequest());
                $paras = $this->getRequest()->getParams();
                $addressData = array(
                    "firstname" => $paras['name'],
                    "lastname" => $paras['name'],
                    "company" => $paras['company'],
                    "street" => $paras['street'],
                    "city" => $paras['city'],
                    "country_id" => "CN",
                    "postcode" => $paras['postcode'],
                    "telephone" => $paras['telephone']
                );
                /*$addressData = array(
                    "firstname" => "cao",
                    "lastname" => "fa",
                    "company" => "伟士集团",
                    "street" => "中关村大街111号",
                    "city" => "北京",
                    "country_id" => "CN",
                    "postcode" => "100999",
                    "telephone" => "13888888888"
                );*/
                $addressErrors  = $addressForm->validateData($addressData);
                if ($addressErrors !== true) {
                    $errors = $addressErrors;
                }

                try {
                    $addressForm->compactData($addressData);
                    $address->setCustomerId($session->getId())
                        ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                        ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));

                    $addressErrors = $address->validate();
                    if ($addressErrors !== true) {
                        $errors = array_merge($errors, $addressErrors);
                    }

                    if (count($errors) === 0) {
                        $address->save();
                        $addressId = $address->getData('entity_id');
                    } else {
                        echo Zend_Json::encode(array("success" => false, "data" => "save address failed."));return;
                    }
                } catch (Mage_Core_Exception $e) {
                    echo Zend_Json::encode(array("success" => false, "error" => $e->getMessage()));return;
                }
            }
            $billing        = $customer->getAddressItemById($addressId);
            //var_dump($billing);exit;
            //$billing        = $customer->getDefaultBillingAddress();
            //var_dump($billing);exit;
            $billingAddress = Mage::getModel('sales/order_address');
            $billingAddress->setStoreId($storeId)
                ->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
                ->setCustomerId($customer->getId())
                ->setCustomerAddressId($customer->getDefaultBilling())
                ->setCustomer_address_id($billing->getEntityId())
                ->setPrefix($billing->getPrefix())
                ->setFirstname($billing->getFirstname())
                ->setMiddlename($billing->getMiddlename())
                ->setLastname($billing->getLastname())
                ->setSuffix($billing->getSuffix())
                ->setCompany($billing->getCompany())
                ->setStreet($billing->getStreet())
                ->setCity($billing->getCity())
                ->setCountry_id($billing->getCountryId())
                ->setRegion($billing->getRegion())
                ->setRegion_id($billing->getRegionId())
                ->setPostcode($billing->getPostcode())
                ->setTelephone($billing->getTelephone())
                ->setFax($billing->getFax());

            $order->setBillingAddress($billingAddress);

            // 保存 Shipping Address
            //$shipping        = $customer->getDefaultShippingAddress();
            $shipping        = $customer->getAddressItemById($addressId);
            $shippingAddress = Mage::getModel('sales/order_address');
            $shippingAddress->setStoreId($storeId)
                ->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING)
                ->setCustomerId($customer->getId())
                ->setCustomerAddressId($customer->getDefaultShipping())
                ->setCustomer_address_id($shipping->getEntityId())
                ->setPrefix($shipping->getPrefix())
                ->setFirstname($shipping->getFirstname())
                ->setMiddlename($shipping->getMiddlename())
                ->setLastname($shipping->getLastname())
                ->setSuffix($shipping->getSuffix())
                ->setCompany($shipping->getCompany())
                ->setStreet($shipping->getStreet())
                ->setCity($shipping->getCity())
                ->setCountry_id($shipping->getCountryId())
                ->setRegion($shipping->getRegion())
                ->setRegion_id($shipping->getRegionId())
                ->setPostcode($shipping->getPostcode())
                ->setTelephone($shipping->getTelephone())
                ->setFax($shipping->getFax());

            $order->setShippingAddress($shippingAddress)
                ->setShipping_method('flatrate_flatrate')
                ->setShippingDescription('快递运输');

            //这里可以根据你的需求来设置付款方式名称
            $orderPayment = Mage::getModel('sales/order_payment');
            $orderPayment->setStoreId($storeId)
                ->setCustomerPaymentId(0)
                ->setMethod('purchaseorder');

            $order->setPayment($orderPayment);

            //这里假设有一个产品
            //请先确认你所输的产品是否存在， 这里我输的产品号 Id 是 43
            $subTotal = 0;
            $products = $this->getRequest()->getParam('products',false);
            $products = array(
                '2' => array('qty' => 3),
                '1' => array('qty' => 1)
            );

            foreach ($products as $productId => $product) {
                $_product  = Mage::getModel('catalog/product')->load($productId);
                $rowTotal  = $_product->getPrice() * $product['qty'];
                $orderItem = Mage::getModel('sales/order_item');
                $orderItem->setStoreId($storeId)
                    ->setQuoteItemId(0)
                    ->setQuoteParentItemId(NULL)
                    ->setProductId($productId)
                    ->setProductType($_product->getTypeId())
                    ->setQtyBackordered(NULL)
                    ->setTotalQtyOrdered($product['rqty'])
                    ->setQtyOrdered($product['qty'])
                    ->setName($_product->getName())
                    ->setSku($_product->getSku())
                    ->setPrice($_product->getPrice())
                    ->setBasePrice($_product->getPrice())
                    ->setOriginalPrice($_product->getPrice())
                    ->setRowTotal($rowTotal)
                    ->setBaseRowTotal($rowTotal);

                $subTotal += $rowTotal;
                $order->addItem($orderItem);
            }

            $order->setSubtotal($subTotal)
                ->setBaseSubtotal($subTotal)
                ->setGrandTotal($subTotal)
                ->setBaseGrandTotal($subTotal);

            $transaction->addObject($order);
            $transaction->addCommitCallback(array($order, 'place'));
            $transaction->addCommitCallback(array($order, 'save'));
            $transaction->save();
            echo Zend_Json::encode(array("success" => true, "data" => "make order successfully."));
        } catch (Exception $e) {
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));
        }

    }

    /**
     * api for customer save address
     */
    public function saveAddressAction(){
        Mage::log("receive save customer address action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("success" => false, "data" => "please login first."));return;
        }
        //$customerId = $session->getCustomerId();
        $address = $this->_newAddress();
        $errors = array();
        $addressForm = Mage::getModel('customer/form');
        $addressForm->setFormCode('customer_address_edit')
            ->setEntity($address);
        //$addressData    = $addressForm->extractData($this->getRequest());
        $paras = $this->getRequest()->getParams();
        $addressData = array(
            "firstname" => $paras['name'],
            "lastname" => $paras['name'],
            "company" => $paras['company'],
            "street" => $paras['street'],
            "city" => $paras['city'],
            "country_id" => "CN",
            "postcode" => $paras['postcode'],
            "telephone" => $paras['telephone']
        );
        /*$addressData = array(
            "firstname" => "li",
            "lastname" => "ha",
            "company" => "北京科技",
            "street" => "北京大街",
            "city" => "北京",
            "country_id" => "CN",
            "postcode" => "100999",
            "telephone" => "13333333332"
        );*/
        $addressErrors  = $addressForm->validateData($addressData);
        if ($addressErrors !== true) {
            $errors = $addressErrors;
        }

        try {
            $addressForm->compactData($addressData);
            $address->setCustomerId($session->getId())
                ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));

            $addressErrors = $address->validate();
            if ($addressErrors !== true) {
                $errors = array_merge($errors, $addressErrors);
            }

            if (count($errors) === 0) {
                $address->save();
                $data = $address->getData();
                echo Zend_Json::encode(array("success" => true, "data" => $data));
                return;
            } else {
                echo Zend_Json::encode(array("success" => false, "data" => "save address failed."));return;
            }
        } catch (Mage_Core_Exception $e) {
            echo Zend_Json::encode(array("success" => false, "error" => $e->getMessage()));return;
        }
    }

    /**
     * api for customer get address list
     */
    public function listAddressAction(){
        Mage::log("receive customer address action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("error" => "please login first."));return;
        }
        $address = $this->_newAddress();
        $customerId = $session->getCustomerId();
        $address_collection = $address->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter('parent_id',$customerId)
            ->load();
        $arr = array();
        foreach($address_collection as $item){
            $arr[] = $item->getData();
        }
        echo Zend_Json::encode(array("success" => true, "data" => $arr));
    }

    /**
     * api for customer edit address
     */
    public function editAddressAction(){
        Mage::log("receive edit address action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("success" => false, "data" => "pleased login first."));return;
        }
        $address  = $this->_newAddress();

        $paras = $this->getRequest()->getParams();
        $addressData = array(
            "firstname" => $paras['name'],
            "lastname" => $paras['name'],
            "company" => $paras['company'],
            "street" => $paras['street'],
            "city" => $paras['city'],
            "country_id" => "CN",
            "postcode" => $paras['postcode'],
            "telephone" => $paras['telephone']
        );
        $addressId = $paras['id'];
        /*$addressData = array(
            "firstname" => "lii",
            "lastname" => "haa",
            "company" => "北京科技1",
            "street" => "北京大街1",
            "city" => "北京",
            "country_id" => "CN",
            "postcode" => "100999",
            "telephone" => "13333333332"
        );*/
        if ($addressId) {
            $existsAddress = $session->getCustomer()->getAddressById($addressId);
            if ($existsAddress->getId() && $existsAddress->getCustomerId() == $session->getId()) {
                $address->setId($existsAddress->getId());
            }
        }

        $errors = array();
        $addressForm = Mage::getModel('customer/form');
        $addressForm->setFormCode('customer_address_edit')
            ->setEntity($address);
        //$addressData    = $addressForm->extractData($this->getRequest());
        $addressErrors  = $addressForm->validateData($addressData);
        if ($addressErrors !== true) {
            $errors = $addressErrors;
        }

        try {
            $addressForm->compactData($addressData);
            $address->setCustomerId($session->getId())
                ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));

            $addressErrors = $address->validate();
            if ($addressErrors !== true) {
                $errors = array_merge($errors, $addressErrors);
            }

            if (count($errors) === 0) {
                $address->save();
                $data = $address->getData();
                echo Zend_Json::encode(array("success" => true, "data" => $data));
                return;
            } else {
                echo Zend_Json::encode(array("success" => false, "data" => "save address failed."));return;
            }
        } catch (Mage_Core_Exception $e) {
            echo Zend_Json::encode(array("success" => false, "error" => $e->getMessage()));return;
        }
    }

    /**
     * api for customer delete address
     */
    public function deleteAddressAction(){
        Mage::log("receive delete address action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("success" => false, "data" => "pleased login first."));return;
        }
        $addressId = $this->getRequest()->getParam("id",false);
        if(!$addressId){
            echo Zend_Json::encode(array("success" => false, "data" => "address id must bu provided."));return;
        }
        $address = $this->_newAddress()->load($addressId);
        if($address->getCustomerId() != $session->getCustomerId()){
            echo Zend_Json::encode(array("success" => false, "data" => "an error occurred, this address no belong to you."));return;
        }
        try {
            $address->delete();
            echo Zend_Json::encode(array("success" => true, "data" => "delete successfully."));return;
        } catch (Exception $e){
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));return;
        }
    }

    /**
     * api for customer address detail
     */
    public function addressInfoAction(){
        Mage::log("get address info action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("success" => false, "data" => "please login first."));return;
        }
        $addressId = $this->getRequest()->getParam("id",false);
        Mage::log("get address id is :".$addressId);
        if(!$addressId){
            echo Zend_Json::encode(array("success" => false, "data" => "address must be provided."));return;
        }
        $address = $this->_newAddress()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("entity_id",$addressId)
            ->load();
        foreach($address as $add){
            $arr[] = $add->getData();
        }
        //$addressInfo = $address->getData();

        echo Zend_Json::encode(array("success" => true,"data" => $arr));

    }

    /**
     * api for add wish list
     */
    public function addWishListAction(){
        Mage::log("receive add wishlist action.");
        try {
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
            if(!$customerId){
                echo Zend_Json::encode(array("success" => false, "data" => "please login first."));return;
            }
            $wishlist = Mage::getModel('wishlist/wishlist');
            $wishlist->loadByCustomer($customerId, true);
            if (!$wishlist->getId() || $wishlist->getCustomerId() != $customerId) {
                $wishlist = null;
                echo Zend_Json::encode(array("success" => false, "data" => "wishlist error."));return;
            }
            $session = Mage::getSingleton('customer/session');

            $productId = (int)$this->getRequest()->getParam('product',2);
            if (!$productId) {
                echo Zend_Json::encode(array("success" => false, "data" => "product must be provided."));
                return;
            }

            $product = Mage::getModel('catalog/product')->load($productId);
            if (!$product->getId() || !$product->isVisibleInCatalog()) {
                echo Zend_Json::encode(array("success" => false, "data" => "product not exists."));return;
            }

            try {
                //$requestParams = $this->getRequest()->getParams();
                $requestParams = array("product" => $productId);
                if ($session->getBeforeWishlistRequest()) {
                    $requestParams = $session->getBeforeWishlistRequest();
                    $session->unsBeforeWishlistRequest();
                }
                $buyRequest = new Varien_Object($requestParams);
                $result = $wishlist->addNewItem($product, $buyRequest);
                if (is_string($result)) {
                    Mage::throwException($result);
                }
                $wishlist->save();
                echo Zend_Json::encode(array("success" => true, "data" => "add wishlist successfully."));return;
            } catch (Exception $e) {
                echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));
            }
        } catch (Exception $e) {
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));
        }
    }

    /**
     * api for list of wish list
     */
    public function wishListAction(){
        Mage::log("receive wishlist action.");
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){
            echo Zend_Json::encode(array("success" => false, "data" => "please login first."));return;
        }
        $customerId = $session->getCustomerId();
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "select a.wishlist_id, b.product_id, b.qty, b.wishlist_item_id from wishlist as a left join wishlist_item as b on a.wishlist_id = b.wishlist_id where a.customer_id = "."'$customerId'";
        $res = $read->fetchAll($sql);
        $arr = array();
        foreach($res as $item){
            $product_id = $item['product_id'];
            $product = $this->_newProduct()->load($product_id);
            $name = $product->getData('name');
            $price = $product->getPrice();
            $image = $product->getData('small_image');
            $qty = $item['qty'];
            $item_id = $item['wishlist_item_id'];

            $arr[] = array(
                "product_id" => $product_id,
                "item_id" => $item_id,
                "name" => $name,
                "price" => $price,
                "image" => Mage::getBaseUrl('media').'catalog/category'.$image,
                "qty" => $qty,
            );
        }
        echo Zend_Json::encode(array("success" => true, "data" => $arr));
    }

    /**
     * get wish list function
     */
    public function _getWishlist($wishlistId = null)
    {
        $wishlist = Mage::registry('wishlist');
        if ($wishlist) {
            return $wishlist;
        }

        try {
            if (!$wishlistId) {
                $wishlistId = $this->getRequest()->getParam('wishlist_id');
            }
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
            /* @var Mage_Wishlist_Model_Wishlist $wishlist */
            $wishlist = Mage::getModel('wishlist/wishlist');
            if ($wishlistId) {
                $wishlist->load($wishlistId);
            } else {
                $wishlist->loadByCustomer($customerId, true);
            }

            if (!$wishlist->getId() || $wishlist->getCustomerId() != $customerId) {
                $wishlist = null;
                Mage::throwException(
                    Mage::helper('wishlist')->__("Requested wishlist doesn't exist")
                );
            }

            Mage::register('wishlist', $wishlist);
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('wishlist/session')->addError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Mage::getSingleton('wishlist/session')->addException($e,
                Mage::helper('wishlist')->__('Wishlist could not be created.')
            );
            return false;
        }

        return $wishlist;
    }

    /**
     * api for remove attention product
     */
    public function removeWishListAction(){
        Mage::log("receive remove wish list action.");
        $id = (int) $this->getRequest()->getParam('item_id');
        $item = Mage::getModel('wishlist/item')->load($id);
        if (!$item->getId()) {
            echo Zend_Json::encode(array("success" => false, "data" => "item id must be provided."));return;
        }
        $wishlist = $this->_getWishlist($item->getWishlistId());
        if (!$wishlist) {
            echo Zend_Json::encode(array("success" => false, "data" => "wishlist error."));return;
        }
        try {
            $item->delete();
            $wishlist->save();

            echo Zend_Json::encode(array("success" => true, "data" => "remove item successfully."));return;
        } catch (Exception $e) {
            echo Zend_Json::encode(array("success" => false, "data" => $e->getMessage()));return;
        }
        //Mage::helper('wishlist')->calculate();

        //$this->_redirectReferer(Mage::getUrl('*/*'));
    }

    /**
     * api for cms
     */
    public function getCmsAction(){
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = "select a.title, a.identifier from cms_page as a left join cms_page_store as b on a.page_id = b.page_id where b.store_id = 1 order by a.update_time desc";
        $res = $read->fetchAll($select);
        $arr = array();
        foreach($res as $item){
            $arr[] = array("title" => $item['title'],"url" => $home_url = Mage::helper('core/url')->getHomeUrl().$item['identifier'] );
        }

        echo Zend_Json::encode(array("success" => true, "data" => $arr));
    }

    /**
     * api for delivery info
     */
    public function getDeliveryInfoAction(){
        $typeCom = $this->getRequest()->getParam('com',false);//快递公司
        $typeNu = $this->getRequest()->getParam('nu',false);  //快递单号
        if(!$typeCom || !$typeNu){
            echo Zend_Json::encode(array("success" => false, "data" => "company or order must be provided."));return;
        }
        $AppKey='XXXXXX';
        $url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=asc';
        //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
        $powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_HEADER,0);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt ($curl, CURLOPT_TIMEOUT,5);
        $get_content = curl_exec($curl);
        curl_close ($curl);

        $res = json_decode($get_content,true);
        if($res['status'] == 1){
            echo Zend_Json::encode(array("success" => true, "data" => $res['data']));
        }else if($res['status'] == 0){
            echo Zend_Json::encode(array("success" => false, "data" => "暂时没有查询到物流信息，请稍后在查"));
        }else if($res['status'] == 2){
            echo Zend_Json::encode(array("success" => false, "data" => "api error,please contact the administrator"));
        }

    }

}