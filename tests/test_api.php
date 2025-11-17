<?php
error_reporting(E_ALL);

$base = 'http://127.0.0.1:8000/api.php';

function http_request($method, $url, $data=null) {
    $opts = [
        "http" => [
            "method" => $method,
            "header" => "Content-Type: application/json\r\n",
            "ignore_errors" => true
        ]
    ];
    if ($data !== null) {
        $opts["http"]["content"] = json_encode($data);
    }
    $context = stream_context_create($opts);
    $resp = @file_get_contents($url, false, $context);
    $code = 0;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $h) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $h, $m)) {
                $code = intval($m[1]);
                break;
            }
        }
    }
    $json = null;
    if ($resp !== false) {
        $json = json_decode($resp, true);
    }
    return ['code'=>$code, 'body'=>$json, 'raw'=>$resp];
}

function assert_true($cond, $msg) {
    if (!$cond) {
        echo "FAILED: $msg\n";
        exit(1);
    } else {
        echo "OK: $msg\n";
    }
}

// GET initial data
$r = http_request('GET', $base . '?search=');
assert_true($r['code'] === 200, "GET initial list");

// CREATE
$uniq = "CI Test " . time();
$postData = ['nama'=>$uniq, 'telepon'=>'0811999', 'email'=>'citest@example.com'];
$r = http_request('POST', $base, $postData);
assert_true($r['body']['status'] === "success", "POST create success");

// SEARCH created
$r = http_request('GET', $base . '?search=' . urlencode($uniq));
assert_true(isset($r['body']['data']), "Search result exists");
$found = null;
foreach ($r['body']['data'] as $c) {
    if ($c['nama'] === $uniq) { $found = $c; break; }
}
assert_true($found !== null, "Created contact found");

$id = intval($found['id']);

// UPDATE
$update = ['id'=>$id, 'nama'=>$uniq . " Updated", 'telepon'=>'0811777', 'email'=>'updated@example.com'];
$r = http_request('PUT', $base, $update);
assert_true($r['body']['status'] === "success", "PUT update success");

// VERIFY UPDATE
$r = http_request('GET', $base . '?search=' . urlencode("Updated"));
assert_true(count($r['body']['data']) >= 1, "Updated contact listed");

// DELETE
$r = http_request('DELETE', $base, ['id'=>$id]);
assert_true($r['body']['status'] === "success", "DELETE success");

// VERIFY DELETE
$r = http_request('GET', $base . '?search=' . urlencode("Updated"));
$exists = false;
foreach ($r['body']['data'] as $c) {
    if ($c['id'] == $id) $exists = true;
}
assert_true(!$exists, "Deleted contact removed");

echo "ALL TESTS PASSED\n";
exit(0);
?>
