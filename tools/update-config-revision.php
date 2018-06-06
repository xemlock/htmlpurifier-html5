<?php

$configFile = __DIR__ . '/../library/HTMLPurifier/HTML5Config.php';
$config = file_get_contents($configFile);

$revisionRegex = '/(?<=const REVISION = )(?P<revision>[^;]+)(?=;)/';

if (!preg_match($revisionRegex, $config, $match)) {
    echo 'Unable to find HTML5Config::REVISION', PHP_EOL;
    exit(1);
}

$currentRevision = $match['revision'];

$datePrefix = date('Ymd');
$counter = !strncmp($currentRevision, $datePrefix, strlen($datePrefix))
    ? substr($currentRevision, strlen($datePrefix), 2)
    : 0;

$newRevision = sprintf("%8d%02d", $datePrefix, $counter + 1);

$newConfig = preg_replace($revisionRegex, $newRevision, $config);

file_put_contents($configFile, $newConfig);

echo "HTML5Config::REVISION updated to ", $newRevision, PHP_EOL;
