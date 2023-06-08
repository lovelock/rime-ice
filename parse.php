<?php

$prefix = <<<EOF
# Rime dictionary
# encoding: utf-8
#

---
name: flypy_chars
version: "2020.03.19"
sort: by_weight
use_preset_vocabulary: false
...


EOF;


$input = __DIR__ . '/小鹤音形单字全码码表.json';
$output = __DIR__ . '/flypy_chars.dict.yaml';

$raw_content = file_get_contents($input);

$full = json_decode($raw_content, true);
file_put_contents($output, $prefix);

foreach ($full as $item) {
  $char = $item['character'];
  $fly_code = $item['fly_code'];
  $level = $item['level'];

  if (strpos($fly_code, "-") !== false) {
    $codes = explode(" ", $fly_code);
    $code = my_trim($codes[0]);
  } else {
    $code = my_trim($fly_code);
  }

  $line = sprintf("%s\t%s\t%s\n", $char, $code, $level++);
  file_put_contents($output, $line, FILE_APPEND);
}

function my_trim($code)
{
  $fly_code = str_replace(["-", "+", "*"], "", $code);
  $code = substr_replace($fly_code, ";", 2, 0);

  return $code;
}
