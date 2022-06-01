<?php

function plaintextDatesToArray($str)
{
    // input: SáuBảySáuBảy
    // output: [Sáu, Bảy, Sáu, Bảy]
    $pieces = preg_split('/(?=[A-Z])/', $str);
    unset($pieces[0]);
    return array_values($pieces);
}

function plaintextStartsToArray($str)
{
    // input: 1166
    // output: [1, 1, 6, 6]
    return str_split($str);
}

function plaintextTotalsToArray($str)
{
    // input: 4445
    // output: [4, 4, 5, 5]
    return plaintextStartsToArray($str);
}

function plaintextRoomsToArray($str)
{
    // input: C.S_A02C.S_A02
    // output: [C.S_A02, C.S_A02]
    $result = [];
    // input: C.A0021.B104
    // output: [C., 1.]
    preg_match_all('/.\./', $str, $address);
    $address = $address[0];

    // input: C.A0021.B104
    // output: [A002, B104]
    $room = preg_split('/.\./', $str);
    unset($room[0]);

    $n = count($address);
    for ($i = 0; $i < $n; $i++) {
        $result[] = $address[$i] . $room[$i + 1];
    }

    return array_values($result);
}

function plaintextTeachersToArray($str)
{
    // input: 1062410624
    // output: [10624, 10624]
    return str_split($str, 5);
}
