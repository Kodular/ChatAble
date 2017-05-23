<?php

//Start API
session_start();
require_once('../core/functions.php');
$ChatAble = new CHATABLE();

// Handle the function
if (!isset($_GET['function'])) {
  exit("Request a method");
} else {
  $function = $_GET['function'];
}


if ($function == "login") {
  if (!isset($_GET['user']) or !isset($_GET['password'])) {
    exit("Missing params");
  }

  $user = $_GET['user'];
  $password = md5($_GET['password']);
  if (strpos($user, '@') != false) {
    $email = true;
  } else {
    $email = false;
  }

  $result = $ChatAble->login($user,$password,$email);


} elseif ($function == "google_login") {
  if (!isset($_GET['email'])) {
    exit("Missing params");
  }

  $email = $_GET['email'];

  $result = $ChatAble->google_login($email);


}  elseif ($function == "signup") {
  if (!isset($_GET['email']) or !isset($_GET['username']) or !isset($_GET['password'])) {
    exit("Missing params");
  }

  $email = strtolower(html_entity_decode($_GET['email']));
  $username = strtolower(html_entity_decode($_GET['username']));
  $password = md5(html_entity_decode($_GET['password']));

  $result = $ChatAble->signup($email,$username,$password);


}  elseif ($function == "edit_account") {
  if (!isset($_GET['id']) or !isset($_GET['param']) or !isset($_GET['value'])) {
    exit("Missing params");
  }

  $id = $_GET['id'];
  $param = $_GET['param'];
  if ($param == "password") {
    $value = md5($_GET['value']);
  } else {
    $value = strtolower($_GET['value']);
  }

  $result = $ChatAble->edit_account($id,$param,$value);


} elseif ($function == "get_data") {
  if (!isset($_GET['user']) or  empty($_GET['user'])) {
    exit("Missing email");
  }

  $user = $_GET['user'];
  if (strpos($user, '@') != false) {
    $type = "email";
  } elseif (is_numeric($user)) {
    $type = "id";
  } else {
    $type = "username";
  }

  $result = $ChatAble->get_data($user,$type);


} elseif ($function == "unread_counter") {
  if (!isset($_GET['id'])) {
    exit("Missing id");
  }

  $id = $_GET['id'];

  $result = $ChatAble->unread_counter($id);


} elseif ($function == "get_private_chats") {
  if (!isset($_GET['id'])) {
    exit("Missing id");
  }

  $id = $_GET['id'];
  if (isset($_GET['request'])) {
    $request = $_GET['request'];
  } else{
    $request = "normal";
  }

  $result = $ChatAble->get_private_chats($id,$request);


} elseif ($function == "create_private_chat") {
  if (!isset($_GET['id']) or !isset($_GET['guest'])) {
    exit("Missing params");
  }

  $id = $_GET['id'];
  $guest = $_GET['guest'];
  if (is_numeric($_GET['guest'])) {
    $type = "id";
  } elseif (strpos($guest, '@') != false) {
    $type = "email";
  } else {
    $type = "username";
    $guest = strtolower($guest);
  }

  $result = $ChatAble->create_private_chat($id,$guest,$type);


} elseif ($function == "post_private_message") {
  if (!isset($_GET['userId']) or !isset($_GET['convId']) or !isset($_GET['content'])) {
    exit("Missing params");
  }

  $userId = $_GET['userId'];
  $convId = $_GET['convId'];
  $content = html_entity_decode($_GET['content']);
  $passwd = $_GET['passwd'];
  if (isset($_GET['type'])) {
    $type = $_GET['type'];
  } else {
    $type = "text";
  }

  $result = $ChatAble->post_private_message($userId,$convId,$content,$type,$passwd);


} elseif ($function == "count_private_messages") {
  if (!isset($_GET['convId'])) {
    exit("Missing params");
  }

  $convId = $_GET['convId'];

  $result = $ChatAble->count_private_messages($convId);


} elseif ($function == "get_support_tickets") {
  if (!isset($_GET['id'])) {
    exit("Missing id");
  }

  $id = $_GET['id'];
  if (isset($_GET['request'])) {
    $request = $_GET['request'];
  } else{
    $request = "normal";
  }

  $result = $ChatAble->get_support_tickets($id,$request);


} elseif ($function == "create_support_ticket") {
  if (!isset($_GET['id']) or !isset($_GET['title']) or !isset($_GET['content'])) {
    exit("Missing params");
  }

  $id = $_GET['id'];
  $title = ucfirst(html_entity_decode($_GET['title']));
  $content = ucfirst(html_entity_decode($_GET['content']));

  $result = $ChatAble->create_support_ticket($id,$title,$content);


} elseif ($function == "post_support_message") {
  if (!isset($_GET['userId']) or !isset($_GET['ticketId']) or !isset($_GET['content'])) {
    exit("Missing params");
  }

  $userId = $_GET['userId'];
  $ticketId = $_GET['ticketId'];
  $content = html_entity_decode($_GET['content']);
  $passwd = $_GET['passwd'];
  if (isset($_GET['type'])) {
    $type = $_GET['type'];
  } else {
    $type = "text";
  }

  $result = $ChatAble->post_support_message($userId,$ticketId,$content,$type,$passwd);


} elseif ($function == "count_support_messages") {
  if (!isset($_GET['ticketId'])) {
    exit("Missing params");
  }

  $ticketId = $_GET['ticketId'];

  $result = $ChatAble->count_support_messages($ticketId);


} elseif ($function == "get_group_chats") {
  if (!isset($_GET['id'])) {
    exit("Missing id");
  }

  $id = $_GET['id'];
  if (isset($_GET['request'])) {
    $request = $_GET['request'];
  } else{
    $request = "normal";
  }

  $result = $ChatAble->get_group_chats($id,$request);


} elseif ($function == "create_group_chat") {
  if (!isset($_GET['id']) or !isset($_GET['title']) or !isset($_GET['alias']) or !isset($_GET['password'])) {
    exit("Missing params");
  }

  $id = $_GET['id'];
  $title = html_entity_decode($_GET['title']);
  $alias = strtolower($_GET['alias']);
  $password = (empty($_GET['password'])) ? "": md5(html_entity_decode($_GET['password']));

  $result = $ChatAble->create_group_chat($id,$title,$alias,$password);


} elseif ($function == "post_group_message") {
  if (!isset($_GET['userId']) or !isset($_GET['groupId']) or !isset($_GET['content'])) {
    exit("Missing params");
  }

  $userId = $_GET['userId'];
  $groupId = $_GET['groupId'];
  $content = html_entity_decode($_GET['content']);
  $passwd = $_GET['passwd'];
  if (isset($_GET['type'])) {
    $type = $_GET['type'];
  } else {
    $type = "text";
  }

  $result = $ChatAble->post_group_message($userId,$groupId,$content,$type,$passwd);


} elseif ($function == "count_group_messages") {
  if (!isset($_GET['groupId'])) {
    exit("Missing params");
  }

  $groupId = $_GET['groupId'];

  $result = $ChatAble->count_group_messages($groupId);


} elseif ($function == "join_group") {
  if (!isset($_GET['id']) or !isset($_GET['input'])) {
    exit("Missing params");
  }

  $id = $_GET['id'];
  $input = $_GET['input'];
  if (is_numeric($input)) {
    $mode = "id";
  } else {
    $mode = "alias";
    $input = strtolower($input);
  }

  $result = $ChatAble->join_group($id,$input,$mode);


} elseif ($function == "join_group_password") {
  if (!isset($_GET['id']) or !isset($_GET['groupId']) or !isset($_GET['password'])) {
    exit("Missing params");
  }

  $id = $_GET['id'];
  $groupId = $_GET['groupId'];
  $password = md5(html_entity_decode($_GET['password']));

  $result = $ChatAble->join_group_password($id,$groupId,$password);


} else {
  echo "Bad Request";
}