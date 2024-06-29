acf.add_filter('wysiwyg_tinymce_settings', function( mceInit, id ){

    // do something to mceInit
    mceInit.valid_children = '-ol[p],-li[p]';

    // return
    return mceInit;

});
