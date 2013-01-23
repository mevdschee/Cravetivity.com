<?php
function authenticate($username,$password)
{
  global $db;
  if (!$user = $db->q1("select * from users as u where username = ? and password = ? limit 1",'ss',$username,$password))
  { header("Status: 403 Forbidden");
    error("User '$username' not found");
  }
  return $user;
}

function error($message)
{
  global $debug;
  if ($debug)
  { header('Content-Type: text/plain');
    echo "Error: ".$message."\n";
    debug_print_backtrace();
  }
  die();
}

function redirect($url)
{
  die(header("Location: $url"));
}