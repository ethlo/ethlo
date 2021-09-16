<?php
$baseUrl = 'https://www.googleapis.com/youtube/v3/';
$apiKey = 'AIzaSyDerDPffjh8EdXLXz4DZgfw2uMJbUcOEAs';
$channelId = 'UCxhi3ZkJ8SdAMvSj_XSAKpA';

$bl = array();

$params = [
    'id' => $channelId,
    'part' => 'contentDetails',
    'key' => $apiKey
];
$url = $baseUrl . 'channels?' . http_build_query($params);
$json = json_decode(file_get_contents($url), true);

$playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

$params = [
    'part' => 'snippet',
    'playlistId' => $playlist,
    'maxResults' => '50',
    'key' => $apiKey
];
$url = $baseUrl . 'playlistItems?' . http_build_query($params);
$json = json_decode(file_get_contents($url), true);

function video($v)
{
    //print_r($v);
    global $bl;
    $filtered = array();
    foreach ($v as $d)
    {
        $snippet = $v['snippet'];
        $id = $snippet['resourceId']['videoId'];
        if (!in_array($id, $bl))
        {
            $filtered['id'] = $id;
            $filtered['published_at'] = $snippet['publishedAt'];
            $filtered['title'] = $snippet['title'];
            $filtered['summary'] = preg_split('#\r?\n#', $snippet['description'], 0)[0];
            $filtered['description'] = $snippet['description'];
        }
    }
    return $filtered;
}

$videos = [];
foreach ($json['items'] as $video)
    $videos[] = video($video);

while (isset($json['nextPageToken'])) {
    $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
    $json = json_decode(file_get_contents($nextUrl), true);
    foreach ($json['items'] as $video)
        $videos[] = video($video);
}

if (PHP_SAPI === 'cli')
{
    
}
else {
    header('Content-Type: application/json');
    echo json_encode($videos);
}