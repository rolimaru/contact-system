<?php

$conn = mysqli_connect("localhost", "root", "", "contact-system");

if (!$conn) {
    die("Connection Failed" . mysqli_connect_error());
} else {
    // echo "Connected";
}
