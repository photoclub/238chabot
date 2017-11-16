<?php

function getPhone($num) {
  $command = " Please try again.\nPHONE <phone number>";
  $num = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $add)));

  $output = 'adi ka numero';

  $answer = ['text' => $output];
  return $answer;
}