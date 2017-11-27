/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'underscore',
    'Magento_Ui/js/grid/provider'
], function ($, _, Element) {
    'use strict';

    return Element.extend({

        /**
         * Processes data before applying it.
         *
         * @param {Object} data - Data to be processed.
         * @returns {Object}
         */
        processData: function (data) {
            var items = data.items;

            _.each(items, function (record, index) {
                record._rowIndex = index;
            });
            
            //Modification. Get average rating based on full result collection, instead if pagintaed collection
            var itemsAll = data.items_all;
            var total = 0;
            var size = 0;
            _.each(itemsAll, function (record, index) {
                record._rowIndex = index;
                total += parseFloat(record.raiting);
                size++;
            });
            var average = total / size;
            if(total > 0){
                $("#average_rating").text(parseFloat(Math.round(average * 100) / 100).toFixed(2));
                $("#averageContainer").removeClass('hidden');
            }
            
            return data;
        }
        /**
         * Processes data before applying it.
         * 
         * Calculate average rating
         *
         * @param {Object} data - Data to be processed.
         * @returns {Object}
         */

    });
});
