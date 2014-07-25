/**
* Easylife_CmsRewrites extension
*
* NOTICE OF LICENSE
*
* This source file is subject to the MIT License
* that is bundled with this package in the file LICENSE_EASYLIFE_CMSREWRITES.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/mit-license.php
*
* @category       Easylife
* @package        Easylife_CmsRewrites
* @copyright      Copyright (c) 2013
* @license        http://opensource.org/licenses/mit-license.php MIT License
*/

if(typeof CMSRewrite=='undefined') {
    var CMSRewrite = {};
}
CMSRewrite.Rewrite = Class.create();
CMSRewrite.Rewrite.prototype = {
    initialize: function(config) {
        this.config = Object.extend({
            addRewriteTrigger    : ".add-rewrite",
            rewritesContainer   : 'rewrites-wrapper',
            templateId: 'rewrite_template'
        }, config);
        this.templateSyntax = /(^|.|\r|\n)({{(\w+)}})/;
        this.rows = [];
        this.index = 0;
        var that = this;
        $$(this.config.addRewriteTrigger).each(function(element){
            Element.observe(element, 'click', that.addRow.bind(that));
        });
    },
    addRow: function(){
        var that = this;
        var template = new Template($(this.config.templateId).innerHTML, this.templateSyntax);
        var rewriteTemplate = template.evaluate({
            id:this.index
        });
        $(this.config.rewritesContainer).insert({bottom:rewriteTemplate});
        var index = this.index;
        Element.observe($('row_' + this.index).select('button.delete')[0], 'click', function(){
            that.removeRow(index);
        });
        this.index++;
    },
    removeRow: function (index) {
        if (confirm(Translator.translate('Are you sure?'))) {
            $('row_' + index).remove();
        }
    }
}
