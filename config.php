<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$db = new SQLite3('poolmate.db');

// Create tables if not exists
$db->exec('
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
)');

$db->exec('
CREATE TABLE IF NOT EXISTS rides (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    driver_id INTEGER NOT NULL,
    from_location TEXT NOT NULL,
    to_location TEXT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    seats INTEGER NOT NULL,
    FOREIGN KEY (driver_id) REFERENCES users(id)
)');

$db->exec('
CREATE TABLE IF NOT EXISTS bookings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ride_id INTEGER NOT NULL,
    passenger_id INTEGER NOT NULL,
    FOREIGN KEY (ride_id) REFERENCES rides(id),
    FOREIGN KEY (passenger_id) REFERENCES users(id)
)');
?>