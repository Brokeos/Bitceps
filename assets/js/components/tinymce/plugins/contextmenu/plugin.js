(function () {
var contextmenu = (function () {
    'use strict';

    var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

    global.add('contextmenu', function () {
      console.warn('Context menu plugin is now built in to the core editor, please remove it from your editor configuration');
    });
    function Plugin () {
    }

    return Plugin;

}());
})();
