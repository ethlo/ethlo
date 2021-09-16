<?php

$allowed = array('name', 'html_url', 'description', 'language', 'updated_at', 'open_issues_count', 'forks_count', 'watchers_count', 'stargazers_count');

$bl = array(
    'ethlo',
    'ethlo.github.com',
    'gcode-stats',
    'spring-actuator-addons',
    'greencode',
    'flexwsdl',
    'openapi-tools',
    'tindvik',
    'jaxb2-sbdh',
    'jaxb2-epcis',
    'jaxb2-despatch-advice',
    'webclient-security',
    'castsaver',
    '0gly',
    'epcis-test',
    'hmbk',
    'logback-filters',
    'macbook-pro-on-linux',
    'trivial-deb',
    'stop',
    'gcode_stats',
    'jard',
    'api-documenter',
    'blackbox-it',
    'cache-sync',
    'eclipselink-maven-plugin-test',
    'ebs-server'
);

$opts = [
    'http' => [
        'method' => 'GET',
        'header' => [
            'User-Agent: PHP'
        ]
    ]
];

$context = stream_context_create($opts);
$content = file_get_contents('https://api.github.com/users/ethlo/repos?per_page=1000', false, $context);
$data = json_decode($content, true);

$filtered = array();
foreach ($data as $d) {
    if ($d['fork'] == false && !in_array($d['name'], $bl)) {
        $filtered[] = array_intersect_key($d, array_flip($allowed));
    }
}


usort($filtered, function ($a, $b) {
    $r = $b['stargazers_count'] <=> $a['stargazers_count'];
    if ($r == 0) {
        $r = $b['forks_count'] <=> $a['forks_count'];
        if ($r == 0) {
            $r = $b['updated_at'] <=> $a['updated_at'];
        }
    }
    return $r;
});

header('Content-Type: application/json');
echo json_encode($filtered);
