<?php
/*
    startAccount R-Auth Client API
     ---
        For R-Auth website to authorize startAccount.
                            License: Apache License 2.0
*/
//     Copyright(c) 2019 Star Inc. All Rights Reserved.

namespace RAuthClient;

define("_VER", 1);
use \Firebase\JWT\JWT;
use \RAuthClient\HttpClient;

class API
{
    public function __construct()
    {
        $this->client = new HttpClient(_VER);
    }

    private function _wrapper($result)
    {
        return $result;
    }

    public function generate(string $rp_id, string $refer)
    {
        $sta_center_host = "https://account.starinc.xyz";
        $sta_center_path = "/r-auth/rv.php?";
        $sta_center_query =  [
            "rp_id" => $rp_id,
            "refer" => $refer
        ];
        $request_url = $sta_center_host . $sta_center_path . http_build_query($sta_center_query);
        return $request_url;
    }

    public function verify(string $rp_code, string $r_session)
    {
        $data = [
            "exec" => "verifyRSession",
            "rp_code" => $rp_code,
            "r_session" => $r_session
        ];
        $result = $this->_wrapper($this->client->send($data));
        return JWT::decode($result, $rp_code, ['HS256']);
    }

    public function revoke(string $rp_code, string $r_session)
    {
        $data = [
            "exec" => "removeRSession",
            "rp_code" => $rp_code,
            "r_session" => $r_session
        ];
        return $this->_wrapper($this->client->send($data));
    }
}
