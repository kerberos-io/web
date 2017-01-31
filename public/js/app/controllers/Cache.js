/**************
*   Cache
**/

define(["jquery", "underscore"], function($, _)
{
    var Cache = (function()
    {
        var supportsLocalStorage = 'localStorage' in window;

        function getJSON(key)
        {
            var promise = jQuery.getJSON(key);

            return promise.pipe(function(data)
            {
                var jsonDfd = new jQuery.Deferred();

                if(supportsLocalStorage)
                {
                    localStorage.setItem(key, JSON.stringify(data));
                }

                jsonDfd.resolveWith(null, [data]);

                return jsonDfd.promise();
            })
        }

        function getStorage(key)
        {
            var storageDfd = new jQuery.Deferred(),
            storedData = localStorage.getItem(key);

            if (!storedData) return getJSON(key);

            setTimeout(function()
            {
                storageDfd.resolveWith(null, [JSON.parse(storedData)]);
            });

            return storageDfd.promise();
        }

        return supportsLocalStorage ? getStorage : getJSON;

    }());

    return Cache;
});