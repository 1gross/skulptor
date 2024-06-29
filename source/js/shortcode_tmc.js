(function() {
    tinymce.PluginManager.add('archbtn', function( editor, url ) {
        editor.addButton( 'archbtn', {
            type: 'button',
            text: 'Вставить телефон',
            onclick: function() {
                editor.insertContent('[phone text="+7 (3812) 38-26-06"]');
            }
        });
    });
})();