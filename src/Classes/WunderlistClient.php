<?php

namespace Mh\Wunderlist;

class WunderlistClient extends AbstractWunderlistClient
{

    /**
     * WunderlistClient constructor.
     *
     * @param string $clientId
     * @param string $accessToken
     */
    public function __construct($clientId, $accessToken)
    {
        parent::__construct($clientId, $accessToken);
    }
}
