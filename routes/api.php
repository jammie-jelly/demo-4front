<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

// Swagger UI route
Route::get('/documentation', function () {
    return view('swagger');
});

// OpenAPI spec route
Route::get('/openapi.json', function () {
    return response()->json([
        'openapi' => '3.0.0',
        'info' => [
            'title' => 'Money Tracker API',
            'version' => '1.0.0',
            'description' => 'API for managing wallets and transactions',
        ],
        'servers' => [
            ['url' => 'http://localhost:8000/api', 'description' => 'Local Development Server'],
        ],
        'paths' => [
            '/users' => [
                'post' => [
                    'summary' => 'Create a new user',
                    'tags' => ['Users'],
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/UserInput',
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        '201' => [
                            'description' => 'User created successfully',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/User',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/users/{userId}/profile' => [
                'get' => [
                    'summary' => 'Get user profile with all wallets and balances',
                    'tags' => ['Users'],
                    'parameters' => [
                        [
                            'name' => 'userId',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'User profile retrieved successfully',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/UserProfile',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/users/{userId}/wallets' => [
                'post' => [
                    'summary' => 'Create a new wallet for a user',
                    'tags' => ['Wallets'],
                    'parameters' => [
                        [
                            'name' => 'userId',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/WalletInput',
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        '201' => [
                            'description' => 'Wallet created successfully',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Wallet',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/wallets/{walletId}' => [
                'get' => [
                    'summary' => 'Get wallet details with transactions',
                    'tags' => ['Wallets'],
                    'parameters' => [
                        [
                            'name' => 'walletId',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Wallet retrieved successfully',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/WalletWithTransactions',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/wallets/{walletId}/transactions' => [
                'post' => [
                    'summary' => 'Add a transaction to a wallet',
                    'tags' => ['Transactions'],
                    'parameters' => [
                        [
                            'name' => 'walletId',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/TransactionInput',
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        '201' => [
                            'description' => 'Transaction created successfully',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Transaction',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/wallets/all' => [
                'get' => [
                    'summary' => 'Get all users with their total wallet balances',
                    'tags' => ['Wallets'],
                    'responses' => [
                        '200' => [
                            'description' => 'All users and their total balances retrieved successfully',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'array',
                                        'items' => [
                                            '$ref' => '#/components/schemas/UserBalance',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'components' => [
            'schemas' => [
                'User' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'name' => ['type' => 'string', 'example' => 'John Doe'],
                        'email' => ['type' => 'string', 'format' => 'email', 'example' => 'john@example.com'],
                        'membership' => ['type' => 'string', 'enum' => ['Foundation', 'Economy'], 'example' => 'Foundation'],
                    ],
                ],
                'UserInput' => [
                    'type' => 'object',
                    'required' => ['name', 'email'],
                    'properties' => [
                        'name' => ['type' => 'string', 'example' => 'John Doe'],
                        'email' => ['type' => 'string', 'format' => 'email', 'example' => 'john@example.com'],
                        'membership' => ['type' => 'string', 'enum' => ['Foundation', 'Economy'], 'example' => 'Foundation', 'nullable' => true],
                    ],
                ],
                'UserProfile' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'name' => ['type' => 'string'],
                        'email' => ['type' => 'string', 'format' => 'email'],
                        'wallets' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/Wallet'],
                        ],
                        'total_balance' => ['type' => 'number', 'format' => 'decimal'],
                    ],
                ],
                'Wallet' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'user_id' => ['type' => 'integer', 'example' => 1],
                        'name' => ['type' => 'string', 'example' => 'Business Wallet'],
                        'balance' => ['type' => 'number', 'format' => 'decimal', 'example' => 5000.00],
                    ],
                ],
                'WalletInput' => [
                    'type' => 'object',
                    'required' => ['name'],
                    'properties' => [
                        'name' => ['type' => 'string', 'example' => 'Business Wallet'],
                    ],
                ],
                'WalletWithTransactions' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'user_id' => ['type' => 'integer'],
                        'name' => ['type' => 'string'],
                        'balance' => ['type' => 'number', 'format' => 'decimal'],
                        'transactions' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/Transaction'],
                        ],
                    ],
                ],
                'Transaction' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'wallet_id' => ['type' => 'integer', 'example' => 1],
                        'type' => ['type' => 'string', 'enum' => ['income', 'expense'], 'example' => 'income'],
                        'amount' => ['type' => 'number', 'format' => 'decimal', 'example' => 1000.00],
                        'description' => ['type' => 'string', 'nullable' => true, 'example' => 'Initial deposit'],
                    ],
                ],
                'TransactionInput' => [
                    'type' => 'object',
                    'required' => ['type', 'amount'],
                    'properties' => [
                        'type' => ['type' => 'string', 'enum' => ['income', 'expense']],
                        'amount' => ['type' => 'number', 'format' => 'decimal', 'minimum' => 0.01],
                        'description' => ['type' => 'string', 'nullable' => true],
                    ],
                ],
                'UserBalance' => [
                    'type' => 'object',
                    'properties' => [
                        'user_name' => ['type' => 'string', 'example' => 'John Doe'],
                        'total_balance' => ['type' => 'number', 'format' => 'decimal', 'example' => 6500.00],
                    ],
                ],
            ],
        ],
    ]);
});

// API Routes
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/{userId}/wallets', [WalletController::class, 'store']);
Route::post('/user/membership', [UserController::class, 'updateMembership']);
Route::get('/users/{userId}/profile', [ProfileController::class, 'show']);
Route::get('/wallets/all', [WalletController::class, 'getAllWallets']);
Route::get('/wallets/{walletId}', [WalletController::class, 'show']);
Route::post('/wallets/{walletId}/transactions', [TransactionController::class, 'store']);

