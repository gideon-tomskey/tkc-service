<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shopify\Utils as ShopifyUtils;
use Shopify\Auth\FileSessionStorage;
use GuzzleHttp\Client;

class OrderRankingController extends Controller
{
    public function getOrders() {
        $apiKey = 'c43ce60bb06aa4033735f6f2613fdeea';
        $apiSecret = '29451d9fd9956cd342a0573fb5dc729e';
        $apiEndpoint = 'https://toms-key-company.myshopify.com/admin/api/2023-07';

        $client = new Client();

        $response = $client->get("https://c43ce60bb06aa4033735f6f2613fdeea:29451d9fd9956cd342a0573fb5dc729e@toms-key-company.myshopify.com/admin/api/2023-04/orders.json");

        $orders = json_decode($response->getBody(), true)['orders'];

        var_dump($response);

        // return view('orders.index', compact('orders'));

        // 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
        // $session = Shopify\Utils::loadCurrentSession(
        //     $headers,
        //     $cookies,
        //     $isOnline
        // );
        // $client = new Rest(
        //     $session->getShop(),
        //     $session->getAccessToken()
        // );
        // $response = $client->get('shop');
    }
}


// https://admin.shopify.com/oauth/install_custom_app?client_id=ace8a1c766bbb7a3cee48ba6c0796234&is_unified_admin_url=true&signature=eyJfcmFpbHMiOnsibWVzc2FnZSI6ImV5SmxlSEJwY21WelgyRjBJam94TmpreU1qYzJOemt4TENKd1pYSnRZVzVsYm5SZlpHOXRZV2x1SWpvaWRHOXRjeTFyWlhrdFkyOXRjR0Z1ZVM1dGVYTm9iM0JwWm5rdVkyOXRJaXdpWTJ4cFpXNTBYMmxrSWpvaVlXTmxPR0V4WXpjMk5tSmlZamRoTTJObFpUUTRZbUUyWXpBM09UWXlNelFpTENKd2RYSndiM05sSWpvaVkzVnpkRzl0WDJGd2NDSXNJbTFsY21Ob1lXNTBYMjl5WjJGdWFYcGhkR2x2Ymw5cFpDSTZNak13T0RRM05uMD0iLCJleHAiOiIyMDIzLTA4LTI0VDEyOjUzOjExLjI2NFoiLCJwdXIiOm51bGx9fQ%3D%3D--da48c9d6b13c67e5f7e07b6c98825b628fc5d1be