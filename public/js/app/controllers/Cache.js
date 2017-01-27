/**************
*   Cache
**/

define(["jquery", "underscore"], function($, _)
{
    var Cache = (function()
    {
        var supportsLocalStorage = 'localStorage' in window;

        // both functions return a promise, so no matter which function
        // gets called inside getCache, you get the same API.
        function getJSON(key)
        {
            return jQuery.getJSON(key).then(function(data)
            {
                if(supportsLocalStorage)
                {
                    localStorage.setItem(key, JSON.stringify(data));
                }
            }).promise();
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