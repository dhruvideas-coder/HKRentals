<?php
$ch = curl_init('http://127.0.0.1:8000/cart/add');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['product_id' => 1, 'name' => 'Chair', 'price' => 4, 'quantity' => 1]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
echo curl_exec($ch);
