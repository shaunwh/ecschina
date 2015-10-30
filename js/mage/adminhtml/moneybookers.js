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
 * @category    Phoenix
 * @package     Phoenix_Moneybookers
 * @copyright   Copyright (c) 2013 Phoenix Medien GmbH & Co. KG (http://www.phoenix-medien.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

Event.observe(window, 'load', function() {
   initMoneybookers();
});

Moneybookers = Class.create();
Moneybookers.prototype = {
    initialize: function(bannerUrl, activateemailUrl, checksecretUrl, checkemailUrl){
        this.bannerUrl = bannerUrl;
        this.activateemailUrl = activateemailUrl;
        this.checksecretUrl = checksecretUrl;
        this.checkemailUrl = checkemailUrl;

        this.txtBtnStatus0 = this.translate('验证电子邮件');
        this.txtBtnStatus1 = this.translate('激活电子钱包快速结帐');
        this.txtBtnStatus2 = this.translate('验证密语');
        this.txtErrStatus0 = this.translate('此邮件地址没有登记。');
        this.txtErrStatus2 = this.translate('这个密语不正确。激活后电子钱包会给您可以访问您的电子钱包账户称为“商船工具”新的组成部分。请选择一个秘密的单词（不使用的密码），并提供您的电子钱包管理区及以上。');
        this.txtInfStatus0 = this.translate('<strong><a href="http://www.moneybookers.com/" target="_blank">电子钱包</a></strong>所有的支付解决方案，可让商家接受借记卡和信用卡付款，银行转账和直接在您的网站最大范围的本地支付。<ul style="list-style-position: inside;list-style-type: disc;"><li>在世界上使用最广泛的付款方式和当地的付款方式。</li><li>一个接口，包括付款，银行业务和营销。</li><li>直接支付，而不需要直接注册。</li><li>电子钱包代表为高转换率将支付处理支付网关成为一种简单，快速和用户友好的操作。</li><li>极具竞争力的价格。 请<a href="http://www.moneybookers.com/app/help.pl?s=m_fees" target="_blank">点击这里</a> 获取更多的详细信息。</li></ul>') + '<img src="' + this.bannerUrl + '" alt="" />';
        this.txtInfStatus1 = this.translate('在没有一个现有电子钱包的付款方式的200多个国家的客户<strong>电子钱包快捷支付</strong> 允许你 <strong>直接</strong> 用信用卡支付，借记卡和超过50其它本地支付。');
        this.txtNotSavechanges = this.translate('请保存配置，然后再继续。');
        this.txtNotStatus0 = this.translate('电子钱包已通过电子邮件验证');
        this.txtNotStatus1 = this.translate('电子邮件被发送到激活电子钱包。请注意验证过程使用电子钱包快速结帐花费一些时间。验证过程已经完成时你将接触电子钱包。');
        this.txtNotStatus2 = this.translate('电子钱包密语进行了验证。您安装完成，你准备好接受国际和本地支付。');

        $("moneybookers_settings_moneybookers_email").setAttribute("onchange", "moneybookers.setStatus(0); moneybookers.changeUi(); document.getElementById('moneybookers_settings_customer_id').value = ''; document.getElementById('moneybookers_settings_customer_id_hidden').value = '';");
        $("moneybookers_settings_customer_id").disabled = true;
        $("moneybookers_settings_customer_id_hidden").name = document.getElementById("moneybookers_settings_customer_id").name;
        $("moneybookers_settings_customer_id_hidden").value = document.getElementById("moneybookers_settings_customer_id").value;
        $("moneybookers_settings_secret_key").setAttribute("onchange", "moneybookers.setStatus(2); moneybookers.changeUi();");

        if (this.isStoreView()) {
            this.infoOrig = {
                email: $("moneybookers_settings_moneybookers_email").value,
                customerId: $("moneybookers_settings_customer_id").value,
                key: $("moneybookers_settings_secret_key").value,
                status: this.getStatus(),
                useDefult: $("moneybookers_settings_moneybookers_email_inherit").checked
            };
            var defaults = $$("#row_moneybookers_settings_customer_id .use-default, #row_moneybookers_settings_secret_key .use-default, #row_moneybookers_settings_activationstatus .use-default");
            if (Object.isArray(defaults)) {
                for (var i=0; i<defaults.length; i++) {
                    defaults[i].hide();
                }
            }
            $("moneybookers_settings_moneybookers_email_inherit").setAttribute("onchange", "moneybookers.changeStore();");
        }

        this.changeUi();
    },

    translate: function(text) {
        try {
            if(Translator){
               return Translator.translate(text);
            }
        }
        catch(e){}
        return text;
    },

    button: function () {
        var status, response, result;
        status = this.getStatus();
        if (status < 1) {
            response = this.getHttp(this.checkemailUrl + "?email=" + $("moneybookers_settings_moneybookers_email").value);
            result = response.split(',');
            if (result[0] == "OK") {
                $("moneybookers_settings_customer_id").value = result[1];
                $("moneybookers_settings_customer_id_hidden").value = result[1];
                this.setStatus(1);
                status = 1;
                alert(this.txtNotStatus0);
            }
            else {
                $("moneybookers_settings_customer_id").value = "";
                alert(this.txtErrStatus0 + "\n("+response+")");
            }
        }
        if (status == 1) {
            this.getHttp(this.activateemailUrl);
            this.setStatus(2);
            alert(this.txtNotStatus1);
            this.alertSaveChanges();
        }
        if (status == 2) {
            response = this.getHttp(this.checksecretUrl + "?email=" + $("moneybookers_settings_moneybookers_email").value
                + "&secret=" + $("moneybookers_settings_secret_key").value
                + "&cust_id=" + $("moneybookers_settings_customer_id").value);
            if (response == "OK") {
                this.setStatus(3);
                alert(this.txtNotStatus2);
                this.alertSaveChanges();
            }
            else {
                alert(this.txtErrStatus2 + "\n("+response+")");
            }
        }
    },

    alertSaveChanges: function () {
        $("moneybookers_multifuncbutton").style.display = "none";
        alert(this.txtNotSavechanges);
    },

    getHttp: function (url) {
        var response;
        new Ajax.Request(
            url,
            {
                method:       "get",
                onComplete:   function(transport) {response = transport.responseText;},
                asynchronous: false
            });
        return response;
    },

    getInteger: function (number) {
        number = parseInt(number);
        if (isNaN(number)) return 0;
        return number;
    },

    getStatus: function () {
        var status = this.getInteger($("moneybookers_settings_activationstatus").value);
        if (status == 1 && $("moneybookers_settings_customer_id").value != '' && $("moneybookers_settings_secret_key").value == '') {
            status = 2;
            this.setStatus(status);
        }
        return status;
    },

    setStatus: function (number) {
        number = this.getInteger(number);
        if (number < 0) number = 0;
        else if (number > 3) number = 3;
        $("moneybookers_settings_activationstatus").value = number;
    },
    changeUi: function () {
        var status = this.getStatus();
        if (status < 1) {
            $("moneybookers_inf_div").update(this.txtInfStatus0);
            $("moneybookers_multifuncbutton_label").update(this.txtBtnStatus0);
        }
        if (status == 1) {
            $("moneybookers_inf_div").update(this.txtInfStatus1);
            $("moneybookers_multifuncbutton_label").update(this.txtBtnStatus1);
        }
        if (status < 2) {
            $("moneybookers_inf_div").style.display = "block";
            $("moneybookers_settings_secret_key").disabled = true;
        }
        if (status == 2) {
            $("moneybookers_multifuncbutton_label").update(this.txtBtnStatus2);
            if (this.isStoreView()) {
                $("moneybookers_settings_secret_key").enable();
                $("moneybookers_settings_secret_key_inherit").removeAttribute('checked');
            }
        }
        if (status > 2) {
            $("moneybookers_multifuncbutton").style.display = "none";
        } else {
            $("moneybookers_multifuncbutton").style.display = "block";
        }
    },

    changeStore: function () {
        if (!$("moneybookers_settings_moneybookers_email_inherit").checked) {
            if (this.infoOrig.useDefult) {
                $("moneybookers_settings_customer_id_inherit").click();
                $("moneybookers_settings_customer_id").clear();
                $("moneybookers_settings_secret_key_inherit").click();
                $("moneybookers_settings_secret_key").clear();
                $("moneybookers_settings_activationstatus_inherit").click();
                this.setStatus(0);
            }
        }
        else {
            if (this.infoOrig.useDefult) {
                $("moneybookers_settings_customer_id").setValue(this.infoOrig.customerId);
                $("moneybookers_settings_customer_id_inherit").click();
                $("moneybookers_settings_secret_key").setValue(this.infoOrig.key);
                $("moneybookers_settings_secret_key_inherit").click();
                $("moneybookers_settings_activationstatus_inherit").click();
                this.setStatus(this.infoOrig.status);
            }
        }
        this.changeUi();
    },

    isStoreView: function() {
        return $("moneybookers_settings_moneybookers_email_inherit") != undefined;
    }
}
