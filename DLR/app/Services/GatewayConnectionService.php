<?php

namespace App\Services;

use App\Repository\GatewayConnectionRepository;

class GatewayConnectionService
{
    public static function checkGatewayConnection(
        string $username,
        string $password
    ) {
        $gateway_connection = GatewayConnectionRepository::getConnection(
            $username,
            $password
        );
        if (!$gateway_connection) {
            return  null;
        } else {
            return $gateway_connection;
        }
    }

    public static function getConnectionId(string $username, string $password)
    {
        $gateway_connection = GatewayConnectionRepository::getConnection(
            $username,
            $password
        );
        return $gateway_connection[0]->id;
    }
}
