<p>Name: {{ request()->input('name') }}</p>
<p>Default Name: {{ $name2 }}</p>
<p>Request URL: {{ request()->url() }}</p>
<p>Request Full URL: {{ request()->fullUrl() }}</p>
<p>Request Full URL with additional parameters: {{ request()->fullUrlWithQuery(['param2' => 'value2']) }}</p>
<p>Request Full URL without Query String: {{ request()->fullUrlWithoutQuery(['param1']) }}</p>
<p>&nbsp;</p>
<p>Host: {{ request()->host() }}</p>
<p>HTTP Host: {{ request()->httpHost() }}</p>
<p>Schema and HTTP Host: {{ request()->schemeAndHttpHost() }}</p>
<p>Request Method: {{ request()->method() }}</p>
<p>Referer: {{ request()->header('Referer') }}</p>
<p>User-Agent: {{ request()->header('User-Agent') }}</p>
<p>Custom-Header: {{ request()->header('Custom-Header', 'No value') }}</p>
<p>Bearer Token: {{ request()->bearerToken(); }}</p>
<p>IP Address: {{ request()->ip(); }}</p>
