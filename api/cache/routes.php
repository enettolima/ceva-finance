<?php $o = array();

// ** THIS IS AN AUTO GENERATED FILE. DO NOT EDIT MANUALLY ** 

//==================== v1 ====================

$o['v1'] = array();

//==== v1 resources/{s0} ====

$o['v1']['resources/{s0}'] = array (
    'GET' => 
    array (
        'url' => 'resources/{id}',
        'className' => 'Luracast\\Restler\\Resources',
        'path' => 'resources',
        'methodName' => 'get',
        'arguments' => 
        array (
            'id' => 0,
        ),
        'defaults' => 
        array (
            0 => '',
        ),
        'metadata' => 
        array (
            'description' => '',
            'longDescription' => '',
            'access' => 'hybrid',
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'string',
                    'name' => 'id',
                    'label' => 'Id',
                    'default' => '',
                    'required' => false,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'path',
                    ),
                ),
            ),
            'throws' => 
            array (
                0 => 
                array (
                    'code' => 500,
                    'message' => 'RestException',
                    'exception' => 'Exception',
                ),
            ),
            'return' => 
            array (
                'type' => 
                array (
                    0 => 'null',
                    1 => 'stdClass',
                ),
                'description' => '',
            ),
            'url' => 'GET {id}',
            'category' => 'Framework',
            'package' => 'Restler',
            'author' => 
            array (
                0 => 
                array (
                    'email' => 'arul@luracast.com',
                    'name' => 'R.Arul Kumaran',
                ),
            ),
            'copyright' => '2010 Luracast',
            'license' => 'http://www.opensource.org/licenses/lgpl-license.php LGPL',
            'link' => 
            array (
                0 => 'http://luracast.com/products/restler/',
            ),
            'version' => '3.0.0rc6',
            'scope' => 
            array (
                '*' => 'Luracast\\Restler\\',
                'String' => 'Luracast\\Restler\\Data\\String',
                'Scope' => 'Luracast\\Restler\\Scope',
                'stdClass' => 'stdClass',
            ),
            'resourcePath' => 'resources',
            'classDescription' => 'API Class to create Swagger Spec 1.1 compatible id and operation listing',
        ),
        'accessLevel' => 1,
    ),
);

//==== v1 resources ====

$o['v1']['resources'] = array (
    'GET' => 
    array (
        'url' => 'resources',
        'className' => 'Luracast\\Restler\\Resources',
        'path' => 'resources',
        'methodName' => 'index',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => '',
            'longDescription' => '',
            'access' => 'hybrid',
            'return' => 
            array (
                'type' => 'stdClass',
                'description' => '',
                'children' => 
                array (
                ),
            ),
            'category' => 'Framework',
            'package' => 'Restler',
            'author' => 
            array (
                0 => 
                array (
                    'email' => 'arul@luracast.com',
                    'name' => 'R.Arul Kumaran',
                ),
            ),
            'copyright' => '2010 Luracast',
            'license' => 'http://www.opensource.org/licenses/lgpl-license.php LGPL',
            'link' => 
            array (
                0 => 'http://luracast.com/products/restler/',
            ),
            'version' => '3.0.0rc6',
            'scope' => 
            array (
                '*' => 'Luracast\\Restler\\',
                'String' => 'Luracast\\Restler\\Data\\String',
                'Scope' => 'Luracast\\Restler\\Scope',
                'stdClass' => 'stdClass',
            ),
            'resourcePath' => 'resources',
            'classDescription' => 'API Class to create Swagger Spec 1.1 compatible id and operation listing',
            'param' => 
            array (
            ),
        ),
        'accessLevel' => 1,
    ),
);

//==== v1 resources/index ====

$o['v1']['resources/index'] = array (
    'GET' => 
    array (
        'url' => 'resources',
        'className' => 'Luracast\\Restler\\Resources',
        'path' => 'resources',
        'methodName' => 'index',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => '',
            'longDescription' => '',
            'access' => 'hybrid',
            'return' => 
            array (
                'type' => 'stdClass',
                'description' => '',
                'children' => 
                array (
                ),
            ),
            'category' => 'Framework',
            'package' => 'Restler',
            'author' => 
            array (
                0 => 
                array (
                    'email' => 'arul@luracast.com',
                    'name' => 'R.Arul Kumaran',
                ),
            ),
            'copyright' => '2010 Luracast',
            'license' => 'http://www.opensource.org/licenses/lgpl-license.php LGPL',
            'link' => 
            array (
                0 => 'http://luracast.com/products/restler/',
            ),
            'version' => '3.0.0rc6',
            'scope' => 
            array (
                '*' => 'Luracast\\Restler\\',
                'String' => 'Luracast\\Restler\\Data\\String',
                'Scope' => 'Luracast\\Restler\\Scope',
                'stdClass' => 'stdClass',
            ),
            'resourcePath' => 'resources',
            'classDescription' => 'API Class to create Swagger Spec 1.1 compatible id and operation listing',
            'param' => 
            array (
            ),
        ),
        'accessLevel' => 1,
    ),
);

//==== v1 resources/verifyaccess ====

$o['v1']['resources/verifyaccess'] = array (
    'GET' => 
    array (
        'url' => 'resources/verifyaccess',
        'className' => 'Luracast\\Restler\\Resources',
        'path' => 'resources',
        'methodName' => 'verifyAccess',
        'arguments' => 
        array (
            'route' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Verifies that the requesting user is allowed to view the docs for this API',
            'longDescription' => '',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'route',
                    'type' => 'mixed',
                    'label' => 'Route',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'query',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'boolean',
                'description' => 'True if the user should be able to view this API\'s docs',
            ),
            'category' => 'Framework',
            'package' => 'Restler',
            'author' => 
            array (
                0 => 
                array (
                    'email' => 'arul@luracast.com',
                    'name' => 'R.Arul Kumaran',
                ),
            ),
            'copyright' => '2010 Luracast',
            'license' => 'http://www.opensource.org/licenses/lgpl-license.php LGPL',
            'link' => 
            array (
                0 => 'http://luracast.com/products/restler/',
            ),
            'version' => '3.0.0rc6',
            'scope' => 
            array (
                '*' => 'Luracast\\Restler\\',
                'String' => 'Luracast\\Restler\\Data\\String',
                'Scope' => 'Luracast\\Restler\\Scope',
                'stdClass' => 'stdClass',
            ),
            'resourcePath' => 'resources',
            'classDescription' => 'API Class to create Swagger Spec 1.1 compatible id and operation listing',
        ),
        'accessLevel' => 3,
    ),
);

//==== v1 simpleauth/key ====

$o['v1']['simpleauth/key'] = array (
    'GET' => 
    array (
        'url' => 'simpleauth/key',
        'className' => 'SimpleAuth',
        'path' => 'simpleauth',
        'methodName' => 'key',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => 'API Key to allow method to be visible',
            'longDescription' => '',
            'access' => 'protected',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested id',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'int',
                    'name' => 'id',
                    'description' => 'Book to be fetched',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
                'iAuthenticate' => 'Luracast\\Restler\\iAuthenticate',
            ),
            'resourcePath' => 'simpleauth',
        ),
        'accessLevel' => 2,
    ),
);

//==== v1 book/create ====

$o['v1']['book/create'] = array (
    'POST' => 
    array (
        'url' => 'book/create',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'create',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to create a new book',
            'longDescription' => 'Add a new book',
            'url' => 'POST create',
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'array',
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 book/byID/{n0} ====

$o['v1']['book/byID/{n0}'] = array (
    'GET' => 
    array (
        'url' => 'book/byID/{id}',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'byID',
        'arguments' => 
        array (
            'id' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth Book Record by ID',
            'longDescription' => 'Fech a record for a specific book by ID',
            'url' => 
            array (
                'description' => 'GET byID/{id}',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested id',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'int',
                    'name' => 'id',
                    'description' => 'Book to be fetched',
                    'label' => 'Id',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'path',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 book/byID ====

$o['v1']['book/byID'] = array (
    'POST' => 
    array (
        'url' => 'book/byID',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'byID',
        'arguments' => 
        array (
            'id' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth Book Record by ID',
            'longDescription' => 'Fech a record for a specific book by ID',
            'url' => 
            array (
                'description' => 'GET byID/{id}',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested id',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'int',
                    'name' => 'id',
                    'description' => 'Book to be fetched',
                    'label' => 'Id',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 book/loadAll ====

$o['v1']['book/loadAll'] = array (
    'GET' => 
    array (
        'url' => 'book/loadAll',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'loadAll',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth All Books',
            'longDescription' => 'Fech all records from the database',
            'url' => 
            array (
                'description' => 'GET loadAll',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Book',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
            ),
        ),
        'accessLevel' => 0,
    ),
    'POST' => 
    array (
        'url' => 'book/loadAll',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'loadAll',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth All Books',
            'longDescription' => 'Fech all records from the database',
            'url' => 
            array (
                'description' => 'GET loadAll',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Book',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 book/put ====

$o['v1']['book/put'] = array (
    'GET' => 
    array (
        'url' => 'book/put',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'put',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to Update book information',
            'longDescription' => 'Update book on database',
            'url' => 
            array (
                'description' => 'GET put',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Book',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'query',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
    'POST' => 
    array (
        'url' => 'book/put',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'put',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to Update book information',
            'longDescription' => 'Update book on database',
            'url' => 
            array (
                'description' => 'GET put',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Book',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 book/delete ====

$o['v1']['book/delete'] = array (
    'GET' => 
    array (
        'url' => 'book/delete',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'delete',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to delete a book',
            'longDescription' => 'Delete book from database',
            'url' => 
            array (
                'description' => 'GET delete',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Book',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'query',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
    'POST' => 
    array (
        'url' => 'book/delete',
        'className' => 'Book',
        'path' => 'book',
        'methodName' => 'delete',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to delete a book',
            'longDescription' => 'Delete book from database',
            'url' => 
            array (
                'description' => 'GET delete',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Book',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'book',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 user/byUsername/{s0} ====

$o['v1']['user/byUsername/{s0}'] = array (
    'GET' => 
    array (
        'url' => 'user/byUsername/{username}',
        'className' => 'User',
        'path' => 'user',
        'methodName' => 'byUsername',
        'arguments' => 
        array (
            'username' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth User Record by Username',
            'longDescription' => 'Fech a record for a specific Natural user by Username',
            'url' => 
            array (
                'description' => 'GET byUsername/{username}',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested username',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'string',
                    'name' => 'username',
                    'description' => 'User to be fetched',
                    'label' => 'Username',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'path',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'user',
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 user/byUsername ====

$o['v1']['user/byUsername'] = array (
    'POST' => 
    array (
        'url' => 'user/byUsername',
        'className' => 'User',
        'path' => 'user',
        'methodName' => 'byUsername',
        'arguments' => 
        array (
            'username' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth User Record by Username',
            'longDescription' => 'Fech a record for a specific Natural user by Username',
            'url' => 
            array (
                'description' => 'GET byUsername/{username}',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested username',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'string',
                    'name' => 'username',
                    'description' => 'User to be fetched',
                    'label' => 'Username',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'user',
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 cars/create ====

$o['v1']['cars/create'] = array (
    'POST' => 
    array (
        'url' => 'cars/create',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'create',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to create a new cars',
            'longDescription' => 'Add a new cars',
            'url' => 'POST create',
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'array',
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 cars/byID/{n0} ====

$o['v1']['cars/byID/{n0}'] = array (
    'GET' => 
    array (
        'url' => 'cars/byID/{id}',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'byID',
        'arguments' => 
        array (
            'id' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth Cars Record by ID',
            'longDescription' => 'Fech a record for a specific cars by ID',
            'url' => 
            array (
                'description' => 'GET byID/{id}',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested id',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'int',
                    'name' => 'id',
                    'description' => 'Cars to be fetched',
                    'label' => 'Id',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'path',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 cars/byID ====

$o['v1']['cars/byID'] = array (
    'POST' => 
    array (
        'url' => 'cars/byID',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'byID',
        'arguments' => 
        array (
            'id' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth Cars Record by ID',
            'longDescription' => 'Fech a record for a specific cars by ID',
            'url' => 
            array (
                'description' => 'GET byID/{id}',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found for requested id',
                    'exception' => 'User',
                ),
            ),
            'param' => 
            array (
                0 => 
                array (
                    'type' => 'int',
                    'name' => 'id',
                    'description' => 'Cars to be fetched',
                    'label' => 'Id',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 cars/loadAll ====

$o['v1']['cars/loadAll'] = array (
    'GET' => 
    array (
        'url' => 'cars/loadAll',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'loadAll',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth All Carss',
            'longDescription' => 'Fech all records from the database',
            'url' => 
            array (
                'description' => 'GET loadAll',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Cars',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
            ),
        ),
        'accessLevel' => 0,
    ),
    'POST' => 
    array (
        'url' => 'cars/loadAll',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'loadAll',
        'arguments' => 
        array (
        ),
        'defaults' => 
        array (
        ),
        'metadata' => 
        array (
            'description' => 'Method to fecth All Carss',
            'longDescription' => 'Fech all records from the database',
            'url' => 
            array (
                'description' => 'GET loadAll',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Cars',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 cars/put ====

$o['v1']['cars/put'] = array (
    'GET' => 
    array (
        'url' => 'cars/put',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'put',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to Update cars information',
            'longDescription' => 'Update cars on database',
            'url' => 
            array (
                'description' => 'GET put',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Cars',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'query',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
    'POST' => 
    array (
        'url' => 'cars/put',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'put',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to Update cars information',
            'longDescription' => 'Update cars on database',
            'url' => 
            array (
                'description' => 'GET put',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Cars',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==== v1 cars/delete ====

$o['v1']['cars/delete'] = array (
    'GET' => 
    array (
        'url' => 'cars/delete',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'delete',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to delete a cars',
            'longDescription' => 'Delete cars from database',
            'url' => 
            array (
                'description' => 'GET delete',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Cars',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'query',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
    'POST' => 
    array (
        'url' => 'cars/delete',
        'className' => 'Cars',
        'path' => 'cars',
        'methodName' => 'delete',
        'arguments' => 
        array (
            'request_data' => 0,
        ),
        'defaults' => 
        array (
            0 => NULL,
        ),
        'metadata' => 
        array (
            'description' => 'Method to delete a cars',
            'longDescription' => 'Delete cars from database',
            'url' => 
            array (
                'description' => 'GET delete',
            ),
            'smart-auto-routing' => 'false',
            'access' => 'public',
            'throws' => 
            array (
                0 => 
                array (
                    'code' => '404',
                    'message' => 'not found',
                    'exception' => 'Cars',
                ),
            ),
            'return' => 
            array (
                'type' => 'mixed',
                'description' => '',
            ),
            'scope' => 
            array (
                '*' => '',
            ),
            'resourcePath' => 'cars',
            'classDescription' => 'All methods in this class are protected',
            'param' => 
            array (
                0 => 
                array (
                    'name' => 'request_data',
                    'label' => 'Request Data',
                    'default' => NULL,
                    'required' => true,
                    'children' => 
                    array (
                    ),
                    'type' => 'array',
                    'properties' => 
                    array (
                        'from' => 'body',
                    ),
                ),
            ),
        ),
        'accessLevel' => 0,
    ),
);

//==================== apiVersionMap ====================

$o['apiVersionMap'] = array();

//==== apiVersionMap Luracast\Restler\Resources ====

$o['apiVersionMap']['Luracast\Restler\Resources'] = array (
    1 => 'Luracast\\Restler\\Resources',
);

//==== apiVersionMap SimpleAuth ====

$o['apiVersionMap']['SimpleAuth'] = array (
    1 => 'SimpleAuth',
);

//==== apiVersionMap Book ====

$o['apiVersionMap']['Book'] = array (
    1 => 'Book',
);

//==== apiVersionMap User ====

$o['apiVersionMap']['User'] = array (
    1 => 'User',
);

//==== apiVersionMap Cars ====

$o['apiVersionMap']['Cars'] = array (
    1 => 'Cars',
);
return $o;