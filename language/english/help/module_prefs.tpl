<div id="help-template" class=outer>

    <h1 class="head">
        <a class="ui-corner-all tooltip" href="<{$xoops_url}>/modules/uhqgeolocate/admin/index.php"
           title="UHQ_GeoLocate Administration">UHQ_GeoLocate
        </a>
        :: Module Preferences
    </h1>

    <h4 class="even">Enable Geolocation Service?</h4>
    <p class="odd">This option enables the module. Disabling this will return null results whenever the functions are
        called. Any modules that use this one will not get geolocation information.</p>

    <h4 class="even">IPv4 Location Provider</h4>
    <p class="odd">This is where you may select your IPv4 location provider.</p>

    <h4 class="even">IPv6 Location Provider</h4>
    <p class="odd">This is where you may select your IPv6 location provider.</p>

    <h4 class="even">Show Diagnostic Array?</h4>
    <p class="odd">If this is set to yes, a print_r of the data array which generates the admin page will be
        displayed.</p>

    <h4 class="even">IPv4 API Key</h4>
    <p class="odd">This is your key/license which is required for you to access an external API provider. If this key is
        invalid, you may have difficulty getting geolocation information via the
        API.</p>

    <h4 class="even">IPv6 API Key</h4>
    <p class="odd">This is exactly like the IPv4 API key, except it's used for your v6 location provider.</p>

    <h4 class="even">Cache API Results?</h4>
    <p class="odd">This option caches all web API calls until the cache is manually cleared. This is enabled by default
        and will prevent multiple queries for the same IP from using many external
        queries.</p>

    <h4 class="even">Cache Expiry (Days)</h4>
    <p class="odd">When caching is used, cached results may be locally retained and marked as valid for a specific time
        period. This prevents resource exhaustion on an API where some providers may
        specifiy or enforce a query limit.</p>
</div>
