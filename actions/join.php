<?php
if (isset($_POST['username']))
{ $username = $_POST['username'];
  $email = $_POST['email'];
  $categoryIds = $_POST['category_id'];
  $password = sha1('randomlink'.$username.date('Y-m-d H:i:s'));
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  { error("Email not valid");
  }
  if (!$db->q("insert into users (username,password,email,created) values (?,?,?,NOW())",'sss',$username,$password,$email))
  { error("User can not be added");
  }
  $userId = $db->handle()->insert_id;
  foreach ($categoryIds as $categoryId)
  { if (!$db->q("insert into users_categories (user_id,category_id) values (?,?)",'ii',$userId,$categoryId))
    { error("User can not be added to category");
    }
  }
  $username = urlencode($username);
  $password = urlencode($password);
  redirect("/manual/$username/$password");
}
?>
<h3>Join now!</h3>
<form method="post">
Name (public)<br/>
<input name="username"/><br/>
Email (private, must be valid)<br/>
<input name="email"/><br/>
Interests (public)<br/>
<select multiple="multiple" size="5" name="category_id[]">
<?php
foreach ($db->q("select * from categories") as $category)
{ echo "<option value=\"$category[id]\">$category[name]</option>";
}
?>
</select><br/>
<input type="submit"/>
</form>
