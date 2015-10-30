<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Cms
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$string = "<ul>\r\n<li><a href=\"{{store direct_url=\"about-magento-demo-store\"}}\">关于我们</a></li>\r\n<li><a href=\"{{store direct_url=\"customer-service\"}}\">客户服务</a></li>\r\n<li class=\"last privacy\"><a href=\"{{store direct_url=\"privacy-policy-cookie-restriction-mode\"}}\">隐私政策</a></li>\r\n</ul>";
$block = array(
        'title'         => 'Footer Links',
        'identifier'    => 'footer_links',
        'content'       => $string,
        'is_active'     => 1,
        'stores'        => 4
);
$pageContent = <<<EOD
<p style="color: #ff0000; font-weight: bold; font-size: 13px;">请将此处内容填写为你的隐私权声明。请添加以下您的网站所使用的cookies（小量信息存储）如：Google分析。</p>
<p>本隐私权声明阐述了当您使用此网站时如何对其信息进行使用和保护。以确保您的隐私受到保护。我们会让您提供一些信息，以确保您使用该网站时您能被识别，由此可保证您的信息只能根据此隐私权声明被使用。您可以不断更新此页面来修改此声明，通过检查此页面以确保您对这些变化满意。</p>
<h2>信息采集</h2>
<p>我们需要以下相关信息：</p>
<ul>
<li>姓名</li>
<li>包括邮箱在内的联系信息</li>
<li>个人信息，例如邮编，喜好和兴趣</li>
<li>其他客户调查或提供的相关信息</li>
</ul>
<p>请参照<a href="#list">我们收集的会话列表</a>查看我们采集的详细会话（小量信息存储）列表。</p>
<h2>如何处理采集的信息</h2>
<p>我们需要这些信息来了解您的需求，并为您提供更好的服务，特别是由于以下原因：</p>
<ul>
<li>内部记录的保存。</li>
<li>我们可以使用这些信息改进我们的产品和服务。</li>
<li>我们可以定时发送邮件给您，提供有关新产品、特价产品或其它认为您会感兴趣的产品信息。</li>
<li>我们也可以通过电子邮件，电话，传真或信件与您联系来做市场调研。我们可以根据您的兴趣来定制网站。</li>
</ul>
<h2>安全性</h2>
<p>我们致力于确保您的信息安全。为了防止未经授权的访问或信息流露，我们已经通过适当的物理，电子和管理程序维护和保障我们在线收集的信息。</p>
<h2>如何使用cookies（小量信息存储）</h2>
<p>Cookie是一种小文件，要求允许被添加在您的计算机硬盘驱动器上。一旦你允许添加该文件可以帮助分析网络流量或当你访问一个特定的网站时让你知道。 Cookie允许Web应用程序将您作为一个个体来运行。这样Web应用程序可以根据您的需要运行，通过收集和记忆您的偏好、喜欢和不喜欢的信息。</p>
<p>我们使用流量日志Cookies来识别正在使用的网页。它可以帮助我们分析网页流量，并改善我们的网站，以满足客户的需要。我们只使用此信息进行统计分析，然后将此数据从系统中删除。</p>
<p>总之，Cookies帮助我们通过监测您觉得哪些网页有用、哪些没用，为您提供一个更优化的网站。除非您愿意与我们分享您的那些信息，一个Cookies决不会让我们访问到您的计算机或任何有关您的信息。您可以选择接受或拒绝Cookies。大多数Web浏览器自动接受Cookies，但是通常您想拒绝，可以修改浏览器设置为拒绝Cookie。这可能不会让您充分利用网站的优越性。</p>
<h2>其他网站链接</h2>
<p>我们的网站可能包含对其他网站的链接。然而，一旦你使用这些链接离开我们的网站，你应该注意到我们不能控制这些网站。因此，如果您浏览的这些网站并不受本隐私声明的保护和控制，我们便不能为您提供的信息进行隐私权保护。您应该谨慎，并仔细查看适用于该网站的隐私权声明。</p>
<h2>管理您的个人信息</h2>
<p>您可以选择以下方式限制采集或使用您的个人信息：</p>
<ul>
<li>当您被要求在网站上填写表格时，查找并点击表明您不希望被任何人使用这些信息来作直接促销用途的选项。</li>
<li>如果您先前已同意我们使用您的个人资料作直接促销用途，你可以随时改变主意只需书面或发邮件给 {{config path="trans_email/ident_general/email"}}</li>
</ul>
<p>我们不会出售，宣传或出租您的个人信息给第三方，除非我们得到您的允许或法律要求这样做。我们可以通过使用您的个人信息把我们认为您会感兴趣的第三方的促销信息发送给您，如果您表明希望我们这样做。</p>
<p>　　在1998年数据保护法下，您可以要求我们提供您详细的个人信息，您将支付一小笔费用。如果您想要您的信息副本，请写信给我们。 {{config path="general/store_information/address"}}.</p>
<p>如果您认为我们持有你的任何信息不正确或不完整，请写信或尽快给我们发电子邮件到上述地址。我们将及时纠正发现的错误信息。</p>
<h2><a name="list"></a>我们收集的会话列表</h2>
<p>下表列出了我们的cookies收集和信息存储。</p>
<table class="data-table">
<thead>
<tr><th>COOKIE名字</th><th>COOKIE 描述</th></tr>
</thead>
<tbody>
<tr><th>CART</th>
<td>您的购物车协会.</td>
</tr>
<tr><th>CATEGORY_INFO</th>
<td>存储类信息在网页上，允许更快速地显示页面。</td>
</tr>
<tr><th>COMPARE</th>
<td>你在比较产品列表中有的项目</td>
</tr>
<tr><th>CURRENCY</th>
<td>您首选货币</td>
</tr>
<tr><th>CUSTOMER</th>
<td>您客户ID与存储的加密版本。</td>
</tr>
<tr><th>CUSTOMER_AUTH</th>
<td>你正在登录进店的一个指标.</td>
</tr>
<tr><th>CUSTOMER_INFO</th>
<td>属于你的客户群的加密版本。</td>
</tr>
<tr><th>CUSTOMER_SEGMENT_IDS</th>
<td>存储的客户分类ID</td>
</tr>
<tr><th>EXTERNAL_NO_CACHE</th>
<td>一个标志，指示是否缓存被禁用。</td>
</tr>
<tr><th>FRONTEND</th>
<td>你在服务器上sesssionID.</td>
</tr>
<tr><th>GUEST-VIEW</th>
<td>允许客人来编辑他们的订单。</td>
</tr>
<tr><th>LAST_CATEGORY</th>
<td>您所访问的最后一类。</td>
</tr>
<tr><th>LAST_PRODUCT</th>
<td>您查看最新的产品。</td>
</tr>
<tr><th>NEWMESSAGE</th>
<td>指示是否已收到新的消息。</td>
</tr>
<tr><th>NO_CACHE</th>
<td>指示是否允许使用缓存。</td>
</tr>
<tr><th>PERSISTENT_SHOPPING_CART</th>
<td>您的购物车和查看历史信息如果你已要求网站的链接。</td>
</tr>
<tr><th>POLL</th>
<td>您最近民意调查投票英寸的ID</td>
</tr>
<tr><th>POLLN</th>
<td>你有什么民意调查投票的信息。</td>
</tr>
<tr><th>RECENTLYCOMPARED</th>
<td>最近比较的项目。</td>
</tr>
<tr><th>STF</th>
<td>你已经通过电子邮件发送给朋友的信息产品。</td>
</tr>
<tr><th>STORE</th>
<td>商店视图或语言选择。</td>
</tr>
<tr><th>USER_ALLOWED_SAVE_COOKIE</th>
<td>指示客户是否允许使用cookies。</td>
</tr>
<tr><th>VIEWED_PRODUCT_IDS</th>
<td>您最近查看过的产品。</td>
</tr>
<tr><th>WISHLIST</th>
<td>产品的加密列表添加到您收藏。</td>
</tr>
<tr><th>WISHLIST_CNT</th>
<td>愿望清单项目数量.</td>
</tr>
</tbody>
</table>
EOD;

$home = <<<EOD
<div class="col-left side-col">
<p class="home-callout"><a href="{{store direct_url="apparel/shoes/womens/anashria-womens-premier-leather-sandal.html"}}"><img src="{{skin url='images/ph_callout_left_top.gif'}}" alt="" border="0" /></a></p>
<p class="home-callout"><img src="{{skin url='images/ph_callout_left_rebel.jpg'}}" alt="" border="0" /></p>
{{block type="tag/popular" template="tag/popular.phtml"}}</div>
<div class="home-spot">
<p class="home-callout"><img src="{{skin url='images/home_main_callout.jpg'}}" alt="" width="470" border="0" /></p>
<p class="home-callout"><img src="{{skin url='images/free_shipping_callout.jpg'}}" alt="" width="470" border="0" /></p>
<div class="box best-selling">
<h3>销售最好的产品</h3>
<table border="0" cellspacing="0">
<tbody>
<tr class="odd">
<td><a href="{{store direct_url="sony-vaio-vgn-txn27n-b-11-1-notebook-pc.html"}}"><img class="product-img" src="{{skin url='images/media/best_selling_img01.jpg'}}" alt="" width="95" border="0" /></a>
<div class="product-description">
<p><a href="{{store direct_url="sony-vaio-vgn-txn27n-b-11-1-notebook-pc.html"}}">索尼VAIO VGN-TXN27N/ B11.1英寸笔记本电脑</a></p>
<p>查看所有的 <a href="{{store direct_url="electronics/computers/laptops.html"}}">笔记本电脑</a></p>
</div>
</td>
<td><a href="{{store direct_url="nine-west-women-s-lucero-pump.html"}}"><img class="product-img" src="{{skin url='images/media/best_selling_img02.jpg'}}" alt="" width="95" border="0" /></a>
<div class="product-description">
<p><a href="{{store direct_url="nine-west-women-s-lucero-pump.html"}}">九西妇女的卢塞罗泵</a></p>
<p>查看所有的<a href="{{store direct_url="apparel/shoes.html"}}">鞋子</a></p>
</div>
</td>
</tr>
<tr class="even">
<td><a href="{{store direct_url="olympus-stylus-750-7-1mp-digital-camera.html"}}"><img class="product-img" src="{{skin url='images/media/best_selling_img03.jpg'}}" alt="" width="95" border="0" /></a>
<div class="product-description">
<p><a href="{{store direct_url="olympus-stylus-750-7-1mp-digital-camera.html"}}">奥林巴斯7507.1MP数码相机</a></p>
<p>查看所有的 <a href="{{store direct_url="electronics/cameras/digital-cameras.html"}}">数码相机</a></p>
</div>
</td>
<td><a href="{{store direct_url="acer-ferrari-3200-notebook-computer-pc.html"}}"><img class="product-img" src="{{skin url='images/media/best_selling_img04.jpg'}}" alt="" width="95" border="0" /></a>
<div class="product-description">
<p><a href="{{store direct_url="acer-ferrari-3200-notebook-computer-pc.html"}}">宏基法拉利3200笔记本电脑PC</a></p>
<p>查看所有的 <a href="{{store direct_url="electronics/computers/laptops.html"}}">笔记本电脑</a></p>
</div>
</td>
</tr>
<tr class="odd">
<td><a href="{{store direct_url="asics-men-s-gel-kayano-xii.html"}}"><img class="product-img" src="{{skin url='images/media/best_selling_img05.jpg'}}" alt="" width="95" border="0" /></a>
<div class="product-description">
<p><a href="{{store direct_url="asics-men-s-gel-kayano-xii.html"}}">ASICS&reg;男士GEL-草野&reg;十二</a></p>
<p>查看所有的 <a href="{{store direct_url="apparel/shoes.html"}}">鞋子</a></p>
</div>
</td>
<td><a href="{{store direct_url="coalesce-functioning-on-impatience-t-shirt.html"}}"><img class="product-img" src="{{skin url='images/media/best_selling_img06.jpg'}}" alt="" width="95" border="0" /></a>
<div class="product-description">
<p><a href="{{store direct_url="coalesce-functioning-on-impatience-t-shirt.html"}}">Coalesce: 功能不凡的T桖</a></p>
<p>查看所有的 <a href="{{store direct_url="apparel/shirts.html"}}">T桖</a></p>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
EOD;

$cmsPages = array(
    array(
        'title'         => '404 Not Found 1',
        'root_template' => 'two_columns_right',
        'meta_keywords' => 'Page keywords',
        'meta_description' => 'Page description',
        'identifier'    => 'no-route',
        'content'       => "<div class=\"page-head-alt\">
<h3>糟糕，出错了。。。。。。</h3>
</div>
<dl><dt>没有找到您想进入的页面，以下是可能出现的原因：</dt><dd>
<ul class=\"disc\">
<li> 您是否输入了正确的网址？请确保拼写正确。</li>
<li>您是否点击的链接？此链接是否已过期？</li>
</ul>
</dd></dl>
<p>&nbsp;</p>
<dl><dt>您能做什么？</dt><dd>不要担心，您会得到帮助。您可以在Magento 演示商店通过很多方式找到该页面。</dd><dd>
<ul class=\"disc\">
<li><a onclick=\"history.go(-1);\" href=\"#\">Go back</a> 返回到上一级页面</li>
<li> 通过页面顶部的搜索条搜索您想找的产品</li>
<li>点击以下链接使您找到该页面<br /><a href=\"{{store url=\"\"}}\">商店首页</a><br /><a href=\"{{store url=\"customer/account\"}}\">我的账户</a></li>
</ul>
</dd></dl>
<p>&nbsp;</p>
<p><img style=\"margin-right: 15px;\" src=\"{{skin url=\'images/media/404_callout1.jpg\'}}\" alt=\"\" /><img src=\"{{skin url=\'images/media/404_callout2.jpg\'}}\" alt=\"\" /></p>",
        'is_active'     => 1,
        'stores'        => array(4),
        'sort_order'    => 0
    ),
    array(
        'title'         => '主页',
        'root_template' => 'two_columns_right',
        'identifier'    => 'home',
        'content'       => $home,
        'is_active'     => 1,
        'stores'        => array(4),
        'sort_order'    => 0
    ),
    array(
        'title'         => '关于我们',
        'root_template' => 'two_columns_right',
        'identifier'    => 'about-magento-demo-store',
        'content'       => "<div class=\"page-head\">
<h3>关于Magento演示商店</h3>
</div>
<div class=\"col3-set\">
<div class=\"col-1\">
<p><img src=\"http://var-dev.varien.com:81/dev/minu/magento/skin/frontend/default/default/images/media/about_us_img.jpg\" alt=\"办公头像\" /></p>
<p style=\"line-height: 1.2em;\"><small>如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。</small></p>
<p style=\"color: #888; font: 1.2em/1.4em georgia, serif;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。</p>
</div>
<div class=\"col-2\">
<p><strong style=\"color: #de036f;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。</strong></p>
<p>现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</p>
<p>电子商务，时代和需求的产物。如果在中国安排去美国旅游，会被各种各样的旅行安排惹恼。可是从此刻起，进入电子商店，是否有货，库存、制造生产公司都可以免费得到各种信息，添加评论、缺货、商品标签。创建一个纯粹的足球事业的新报纸，衬衫网站？现在就可以开发。</p>
</div>
<div class=\"col-3\">
<p>如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。</p>
<div class=\"divider\">&nbsp;</div>
<p>在使用magento演示商店的所有人 - 祝你们有个愉快的电子商务之旅！</p>
<p style=\"line-height: 1.2em;\"><strong style=\"font: italic 2em Georgia, serif;\">John Doe</strong><br /><small>重要贡献者</small></p>
</div>
</div>",
        'is_active'     => 1,
        'stores'        => array(4),
        'sort_order'    => 0
    ),
    array(
        'title'         => '客户服务',
        'root_template' => 'three_columns',
        'identifier'    => 'customer-service',
        'content'       => "<div class=\"page-head\">
<h3>客户服务</h3>
</div>
<ul class=\"disc\" style=\"margin-bottom: 15px;\">
<li><a href=\"#answer1\">配送方式</a></li>
<li><a href=\"#answer2\">隐私权及保护</a></li>
<li><a href=\"#answer3\">退货及换货</a></li>
<li><a href=\"#answer4\">订购</a></li>
<li><a href=\"#answer5\">付款，价格与促销</a></li>
<li><a href=\"#answer6\">查看订单</a></li>
<li><a href=\"#answer7\">更新账户信息</a></li>
</ul>
<dl><dt id=\"answer1\">配送方式</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd><dt id=\"answer2\">隐私权及保护</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd><dt id=\"answer3\">退货及换货</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd><dt id=\"answer4\">订购</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd><dt id=\"answer5\">付款，价格与促销</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd><dt id=\"answer6\">查看订单</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd><dt id=\"answer7\">更新账户信息</dt><dd style=\"margin-bottom: 10px;\">如果您有任何开发网站的需求，请联系我们。我们具有真实性、有银行声明、实体店。中国的经济无处不在。您只需动一动鼠标，我们的网站就在身边，触手可及。未来为您敞开大门。现在我们的生活处于iPhone时代，一切方便快捷。只需点击鼠标就可以知道商品价格。我们仍在为了柴米酱醋而努力工作。我们想抗衰老，远离疾病和饥饿等。但这些都不是我们真正想要的，我们想追求更多。想自由思考、写作不受时间和法律的约束。</dd></dl>",
        'is_active'     => 1,
        'stores'        => array(4),
        'sort_order'    => 0
    ),
    array(
        'title'         => '启用 Cookies',
        'root_template' => 'one_column',
        'identifier'    => 'enable-cookies',
        'content'       => "<div class=\"std\">
<ul class=\"messages\">
<li class=\"notice-msg\">
<ul>
<li>请启动网页浏览器 cookies 再继续。</li>
</ul>
</li>
</ul>
<div class=\"page-title\">
<h1><a name=\"top\"></a>什么是 Cookies?</h1>
</div>
<p>Cookie是小段的数据被发送到您的计算机，当你访问一个网站。在以后的访问，这一数据，然后返回到该网站。 Cookie可以帮助我们自动识别你，每当你访问我们的网站，这样我们就可以个性化体验并为您提供更好的服务。我们还使用cookie（以及类似的浏览器数据，如快闪饼干）为防止欺诈和其他用途。如果您的网页浏览器设置为拒绝cookies，，您将无法从我们的网站完成购买，或利用我们网站的某些功能，如存储在您的购物车中的物品或接收个性化的建议。因此，我们强烈建议您从我们的网站来配置您的网页浏览器接受cookies。</p>
<h2 class=\"subtitle\">Cookies的启用</h2>
<ul class=\"disc\">
<li><a href=\"#ie7\">IE 7.x</a></li>
<li><a href=\"#ie6\">IE 6.x</a></li>
<li><a href=\"#firefox\">火狐</a></li>
<li><a href=\"#opera\">Opera 7.x</a></li>
</ul>
<h3><a name=\"ie7\"></a>IEr 7.x</h3>
<ol>
<li>
<p>启动IE</p>
</li>
<li>
<p>在 <strong>工具</strong> 菜单下, 点击 <strong>Internet选项</strong></p>
<p><img src=\"{{skin url=\"images/cookies/ie7-1.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>点击<strong>隐私</strong> tab</p>
<p><img src=\"{{skin url=\"images/cookies/ie7-2.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>点击<strong>高级</strong> button</p>
<p><img src=\"{{skin url=\"images/cookies/ie7-3.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>在复选框中<strong>勾上自动处理Cookie</strong>, 在另一项复选框上<strong>勾上总是接受 session cookies </strong>box</p>
<p><img src=\"{{skin url=\"images/cookies/ie7-4.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>点击<strong>确认</strong></p>
<p><img src=\"{{skin url=\"images/cookies/ie7-5.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>点击 <strong>确认</strong></p>
<p><img src=\"{{skin url=\"images/cookies/ie7-6.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>重启IE</p>
</li>
</ol>
<p class=\"a-top\"><a href=\"#top\">回到顶部</a></p>
<h3><a name=\"ie6\"></a>IE 6.x</h3>
<ol>
<li>
<p>在工具菜单下选择<strong>Internet选项</strong> </p>
<p><img src=\"{{skin url=\"images/cookies/ie6-1.gif\"}}\" alt=\"\" /></p>
</li>
<li>
<p>点击 <strong>隐私</strong> tab</p>
</li>
<li>
<p>点击 <strong>默认</strong> 按钮 （或 <strong>在中下部</strong>点击手动设置） <strong>设置</strong>. 点击 <strong>确认</strong></p>
<p><img src=\"{{skin url=\"images/cookies/ie6-2.gif\"}}\" alt=\"\" /></p>
</li>
</ol>
<p class=\"a-top\"><a href=\"#top\">回到顶部</a></p>
<h3><a name=\"firefox\"></a>火狐</h3>
<ol>
<li>
<p>点击 <strong>工具</strong>菜单</p>
</li>
<li>
<p>在新窗口点击 <strong>选项.</strong> </p>
</li>
<li>
<p>在窗口左边区域点击 <strong>隐私</strong></p>
<p><img src=\"{{skin url=\"images/cookies/firefox.png\"}}\" alt=\"\" /></p>
</li>
<li>
<p>展开 <strong>Cookies</strong> 区域</p>
</li>
<li>
<p>点击<strong>启用 cookies</strong> 和<strong>正常接收cookies</strong> checkboxes</p>
</li>
<li>
<p>保存更改点击 <strong>确认</strong>.</p>
</li>
</ol>
<p class=\"a-top\"><a href=\"#top\">回到顶部</a></p>
<h3><a name=\"opera\"></a>Opera 7.x</h3>
<ol>
<li>
<p>点击 <strong>工具</strong> 菜单</p>
</li>
<li>
<p>在新窗口中点击 <strong>首选项</strong></p>
</li>
<li>
<p>在左下方区域点击 <strong>隐私</strong>)</p>
<p><img src=\"{{skin url=\"images/cookies/opera.png\"}}\" alt=\"\" /></p>
</li>
<li>
<p>勾上<strong>启用 cookies</strong> 选项，并且 <strong>接受所有的cookies</strong> \"<strong></strong>\" </p>
</li>
<li>
<p>保存更改点击 <strong>确认</strong></p>
</li>
</ol>
<p class=\"a-top\"><a href=\"#top\">回到顶部</a></p>
</div>",
        'is_active'     => 1,
        'stores'        => array(4)
    ),
	array(
		'title'           => '隐私政策',
		'content_heading' => '隐私政策',
		'root_template'   => 'one_column',
		'identifier'      => 'privacy-policy-cookie-restriction-mode',
		'content'         => $pageContent,
		'is_active'       => 1,
		'stores'          => array(4),
		'sort_order'      => 0
	)
);

foreach ($cmsPages as $data) {
    Mage::getModel('cms/page')->setData($data)->save();
}

$footerLinksBlock = Mage::getModel('cms/block')->setData($block)->save();