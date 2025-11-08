<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new User_Controller)->index(),
};