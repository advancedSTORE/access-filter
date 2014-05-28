<h2>1. Configuration</h2>
<h4>Publish package config</h4>
<p>Run the following command if you are installing for the first time.</p>
<pre><code>
    php artisan config:publish advanced-store/access-filter
</code></pre>
<p>
    Edit the configuration file accessFilterConfig and add the userPermissions.
    These should come either from your Sentry/User models or be hardcoded for
    testing purpose. In future these will be extractable through the ad4mat API
    client.
</p>
<h4>Publish package config</h4>

<p>Add following lines to your app.php.</p>
<h4>Provider</h4>
<pre>
<code>
    'AdvancedStore\AccessFilter\AccessFilterServiceProvider',
</code>
</pre>

<h4>Aliases</h4>
<pre>
<code>
    'YourAlias' => 'AdvancedStore\AccessFilter\Facades\AccessFilterFacade',
</code>
</pre>

<p>
    Edit the configuration file permissionList.php and insert your
    route-names and the most nested minimum required permission the user
    must have to access this route.
</p>
<p>
    My convention for permission naming is :
</p>
<pre>
<code>
        [{SystemName}].{ApplicationName}.{Root}.{SubScope}.[0..* {SubScope}]
</code>
</pre>

<p>
    Example :
</p>
<p>
    Route-name is "admin/users"
    Required permission could be "myApplicationName.admin.users.listAll"
    The configuration array would look like this.
</p>
<pre>
    <code>
        return [
            "admin/users"   =>  [
                "myApplicationName.admin.users.listAll",
            ],
        ]
    </code>
</pre>


<p>
    It is also possible to set multiple sub-permissions which are equally leveled.
    The user is required to have only one of there. Notice that I prefer to use
    also dotted naming for my route-names.
</p>
<pre>
<code>
    return [
        "admin.users.index" =>  [
            "ad4mat.admin.users.read",
            "ad4mat.admin.users.self",
        ],
    ]
</code>
    </pre>
<p>
    This can come in handy if the user should have the possibility to get
    access to the users.index route but he should only see his own profile or all
    , you can decide that inside of your controller.
</p>
<h2>2. Usage</h2>
<p>
    To check for a certain permission for example if you want to use it in a
    sidebar menu to display only certain elements.
</p>

<h3>Structure</h3>
<pre>
<code>
    YourAlias::hasPermission( permissionString )
</code>
</pre>

Example from my code

<code>
    @if( AccessFilter::hasPermission('ad4mat.admin.roles.read') )
</code>

<p>
    If you want to use it to protect resources/routes than you create filter which
    calls the filter method and add it to which ever resource/route you like.
</p>

<p>Create Filter</p>
<pre>
<code>
    Route::filter('accessFilter', function(){
        return AccessFilter::filter();
    });
</code>
</pre>
<p>
    Notice Laravel only creates route-names for resources if you use single routes
    you have to add them yourself. These are the ones matches against the configuration array.
</p>