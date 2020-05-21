<?php
// startAccount R-Auth Client API - stala_libs httpClient
// License: Apache License 2.0
// (c) 2019 Star Inc.

namespace RAuthClient;

class HttpClient
{
    public function __construct(int $stalaVer)
    {
        $this->stalaVer = $stalaVer;
        $this->host = "https://restapi.starinc.xyz/rauth";
    }

    public function send(
        string $path,
        string $data,
        int $json_decode = 0
    ) {
        $data_string = http_build_query($data);
        $request_url = sprintf("%s/%s", $this->host, $path);

        $client = curl_init();
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_URL, $request_url);
        curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($client, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $client,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . strlen($data_string),
                'Stala-Ver: ' . $this->stalaVer
            )
        );
        $result = curl_exec($client);
        curl_close($client);

        switch ($json_decode) {
            case 0:
                return json_decode($result);

            case 1:
                return json_decode($result, true);

            default:
                return $result;
        }
    }
}
