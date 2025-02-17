/*
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 *
 */

pimcore.registerNS('coreshop.product.resource');
coreshop.product.resource = Class.create(coreshop.resource, {
    initialize: function () {
        coreshop.global.addStoreWithRoute('coreshop_product_units', 'coreshop_product_unit_list');
        pimcore.globalmanager.get('coreshop_product_units').load();
        coreshop.broker.fireEvent('resource.register', 'coreshop.product', this);
    },

    openResource: function (item) {
        if (item === 'product_price_rule') {
            this.openProductPriceRule();
        }if (item === 'product_unit') {
            this.openProductUnit();
        }
    },

    openProductPriceRule: function () {
        try {
            pimcore.globalmanager.get('coreshop_product_price_rule_panel').activate();
        }
        catch (e) {
            pimcore.globalmanager.add('coreshop_product_price_rule_panel', new coreshop.product.pricerule.panel());
        }
    },

    openProductUnit: function () {
        try {
            pimcore.globalmanager.get('coreshop_product_unit_panel').activate();
        }
        catch (e) {
            pimcore.globalmanager.add('coreshop_product_unit_panel', new coreshop.product.unit.panel());
        }
    }
});

coreshop.broker.addListener('pimcore.ready', function() {
    new coreshop.product.resource();
});
