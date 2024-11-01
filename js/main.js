(function() {
  window.onload = function() {
    var closeInfobox, openInfobox;
    WPLP.editableTextDatas = {};
    jQuery('#wplp_overlay .testeditor-tmce').click();
    jQuery('.wplp_editable_text').hover(function(e) {
      if (e.clientY <= window.innerHeight - 20 - jQuery('#wplp_infobox').height()) {
        return openInfobox(WPLP.infoboxText);
      }
    }, function() {
      return closeInfobox();
    });
    jQuery('.wplp_editable_image').hover(function(e) {
      if (e.clientY <= window.innerHeight - 20 - jQuery('#wplp_infobox').height()) {
        return openInfobox(WPLP.infoboxImage);
      }
    }, function() {
      return closeInfobox();
    });
    jQuery('.wplp_editable_menu').hover(function(e) {
      if (e.clientY <= window.innerHeight - 20 - jQuery('#wplp_infobox').height()) {
        return openInfobox(WPLP.infoboxMenu);
      }
    }, function() {
      return closeInfobox();
    });
    jQuery('.wplp_editable_text').dblclick(function(e) {
      var editContent;
      WPLP.editableTextDatas.postid = jQuery(this).data('postid');
      WPLP.editableTextDatas.key = jQuery(this).data('key');
      WPLP.editableTextDatas.el = this;
      editContent = function(html) {
        if (tinyMCE.editors[0]) {
          e = tinyMCE.editors[0];
          return e.setContent(html);
        } else {
          return jQuery('.wp-editor-area').val(html);
        }
      };
      editContent('');
      return jQuery.ajax({
        url: wp.ajax.settings.url,
        type: 'POST',
        data: {
          action: 'wplp_get_text',
          postid: WPLP.editableTextDatas.postid,
          key: WPLP.editableTextDatas.key
        },
        success: (function(data) {
          if (data) {
            editContent(data);
          } else {
            editContent(jQuery(WPLP.editableTextDatas.el).html());
          }
          return jQuery('#wplp_overlay').height(jQuery(window).innerHeight());
        }).bind(this)
      });
    });
    jQuery('.wplp_editable_menu').click(function(e) {
      return e.preventDefault();
    });
    jQuery('.wplp_editable_menu').dblclick(function(e) {
      e.preventDefault();
      console.log('edit menu');
      if (!this.editMode) {
        return jQuery.ajax({
          url: wp.ajax.settings.url,
          type: 'POST',
          data: {
            action: 'wplp_get_menu_list',
            postid: jQuery(this).data('postid'),
            key: jQuery(this).data('key')
          },
          success: (function(form) {
            jQuery(this).html(form);
            jQuery(this).find('.submit_menu_form').click((function(e) {
              e.preventDefault();
              return jQuery.ajax({
                url: wp.ajax.settings.url,
                type: 'POST',
                data: {
                  action: 'wplp_edit_menu',
                  postid: jQuery(e.target).parent().parent().data('postid'),
                  key: jQuery(e.target).parent().parent().data('key'),
                  value: jQuery(e.target).parent().find('select').val()
                },
                success: (function(menu) {
                  this.editMode = false;
                  return jQuery(this).html(menu);
                }).bind(this)
              });
            }).bind(this));
            return this.editMode = true;
          }).bind(this)
        });
      }
    });
    jQuery('#wplp_overlay .popup .popup-close').click(function() {
      return jQuery('#wplp_overlay').height(0);
    });
    jQuery('#wplp_overlay .popup .submit').click(function() {
      var getContent;
      getContent = function() {
        var e;
        if (tinyMCE.editors[0]) {
          e = tinyMCE.editors[0];
          return e.getContent();
        } else {
          return jQuery('.wp-editor-area').val();
        }
      };
      return jQuery.ajax({
        url: wp.ajax.settings.url,
        type: 'POST',
        data: {
          action: 'wplp_update_text',
          postid: WPLP.editableTextDatas.postid,
          key: WPLP.editableTextDatas.key,
          text: getContent()
        },
        success: function(texte) {
          jQuery(WPLP.editableTextDatas.el).html(texte);
          return jQuery('#wplp_overlay').height(0);
        }
      });
    });
    jQuery('.wplp_editable_image').each(function() {
      var uploader;
      uploader = new plupload.Uploader({
        browse_button: this,
        url: wp.ajax.settings.url,
        multipart_params: {
          postid: jQuery(this).data('postid'),
          action: 'wplp_update_image',
          key: jQuery(this).data('key')
        },
        init: {
          FilesAdded: (function(up, files) {
            return uploader.start();
          }).bind(this),
          FileUploaded: (function(u, f, r) {
            return jQuery(this).html(r.response);
          }).bind(this)
        }
      });
      return uploader.init();
    });
    /*jQuery('.btn-cta').click(function() {
      return jQuery.ajax({
        url: wp.ajax.settings.url,
        type: 'POST',
        data: {
          action: 'wplp_count_conv',
          postid: jQuery(this).data('postid')
        }
      });
    });*/
    openInfobox = function(message) {
      jQuery('#wplp_infobox').html(message);
      return jQuery('#wplp_infobox').show();
    };
    return closeInfobox = function() {
      return jQuery('#wplp_infobox').hide();
    };
  };

}).call(this);
