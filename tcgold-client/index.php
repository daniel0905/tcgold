<?php
require 'TcGoldClient.php';
$tcGoldClient = new TcGoldClient('tam.duong@gmail.com', '123456', '127.0.0.1:8080');

// create parcel
$parcel = new Parcel();
$parcel->setItemName("Item name 11");
$parcel->setWeight(0.4);
$parcel->setVolume(0.00079);
$parcel->setDeclaredValue(1300);
$parcel->setChosenModel(Parcel::BY_VALUE);
$createParcel = $tcGoldClient->createParcel($parcel);
echo "<h4>Create parcel</h4>";
print_r(json_encode($createParcel));
echo "<br>";

// get parcel
$getSingleParcel = $tcGoldClient->getSingleParcel($createParcel->data->id);
echo "<h4>Get parcel</h4>";
print_r(json_encode($getSingleParcel));
echo "<br>";

// update parcel
$parcel->setItemName("Item name 12");
$updateParcel = $tcGoldClient->updateParcel($parcel, $createParcel->data->id);
echo "<h4>Update parcel</h4>";
print_r(json_encode($updateParcel));
echo "<br>";

// delete parcel
$deleteParcel = $tcGoldClient->deleteParcel($createParcel->data->id);
echo "<h4>Delete parcel</h4>";
print_r(json_encode($deleteParcel));
echo "<br>";

