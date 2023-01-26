<?php

ini_set('display_errors', 'On');
require_once "../libraries/FeedbackModel.php";

use Libraries\FeedbackModel;

$feedBack = new FeedbackModel();

$feedBack->saveData();

$feedBack->getMessage();
