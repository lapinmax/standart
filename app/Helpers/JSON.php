<?php

function trim_array ($element) {
    if (is_array($element)) {
        return array_map('trim_array', $element);
    }

    return trim($element);
}

function JSONError ($errors = ['0' => 'Произошла ошибка'], $data = null) {
    $response = [
        'result' => 'error',
        'errors' => []
    ];

    foreach ($errors as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $error) {
                $response['errors'][] = [
                    'code' => $key,
                    'description' => $error
                ];
            }
        } else {
            $response['errors'][] = [
                'code' => $key,
                'description' => $value
            ];
        }
    }

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    return $response;
}

function JSONSuccess ($items = null) {
    $response = [
        'result' => 'success',
        'errors' => []
    ];

    if (!is_null($items)) {
        $response['data'] = $items;
    }

    return $response;
}