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
                    var expirationMS = 15 * 60 * 1000; // 15min.

                    localStorage.setItem(key, JSON.stringify({
                        value: data,
                        timestamp: new Date().getTime() + expirationMS
                    }));
                }

                jsonDfd.resolveWith(null, [data]);

                return jsonDfd.promise();
            })
        }

        function getStorage(key)
        {
            var storageDfd = new jQuery.Deferred(),
            storedData = localStorage.getItem(key);

            if (!storedData)
            {
                return getJSON(key);
            }
            else
            {
                storedData = JSON.parse(storedData);
                var now  = new Date().getTime();
                if(now > storedData.timestamp)
                {
                    return getJSON(key);
                }
            }

            setTimeout(function()
            {
                storageDfd.resolveWith(null, [storedData.value]);
            });

            return storageDfd.promise();
        }

        return supportsLocalStorage ? getStorage : getJSON;

    }());

    return Cache;
});