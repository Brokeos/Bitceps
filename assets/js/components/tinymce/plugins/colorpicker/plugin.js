(function () {
var colorpicker = (function () {
    'use strict';

    var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

    global.add('colorpicker', function () {
      console.warn('Color picker plugin is now built in to the core editor, please remove it from your editor configuration');
    });
    function Plugin () {
    }

    return Plugin;

}());
})();
