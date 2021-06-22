
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$deviceInfo['api_user_id']."/devices/dates/?key=".$deviceInfo['api_key_id']."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=".$fechaFinal."&d=".$deviceInfo['api_device_id'];
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $analiticos->push($responseBody);
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$deviceInfo['api_user_id']."/devices/genders/ages/emotions/dates/?key=".$deviceInfo['api_key_id']."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=".$fechaFinal."&d=".$deviceInfo['api_device_id'];
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $demograficos->push($responseBody);
        
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$deviceInfo['api_user_id']."/genders/ages/?key=".$deviceInfo['api_key_id']."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=".$fechaFinal."&d=".$deviceInfo['api_device_id'];
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $infosCards->push($responseBody);
        
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$deviceInfo['api_user_id']."/ages/genders/?key=".$deviceInfo['api_key_id']."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$deviceInfo['api_device_id'];
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        
        $responseBody = json_decode($response->getBody());
            $infosCards->push($responseBody);


        