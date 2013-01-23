<?php
$email = $user['email'];
if (!$categories = $db->q("select category_id from users_categories where user_id = ?",'i',$user['id']))
{ error("No categories found");
}
$ids = array_map(function($v){ return $v['category_id']+0; },$categories);
$flash = '';
if (isset($_POST['category_id']))
{ $newEmail = $_POST['email'];
  if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
  { error("Email not valid");
  }
  if ($newEmail!=$email)
  { if (!$db->q("update users set email = ? where id = ?",'si',$newEmail,$user['id']));
    { error("User can not be updated");
    }
  }
  $categoryIds = $_POST['category_id'];
  if (!$db->q("delete from users_categories where user_id = ?",'i',$user['id']))
  { error("User can not be removed from category");
  }
  foreach ($categoryIds as $categoryId)
  { if (!$db->q("insert into users_categories (user_id,category_id) values (?,?)",'ii',$user['id'],$categoryId))
    { error("User can not be added to category");
    }
  }
  redirect('#');
}
?>
<form method="post">
Email (private, must be valid)<br/>
<input name="email" value="<?php echo $email; ?>"/><br/>
Interests (public)<br/>
<select multiple="multiple" size="5" name="category_id[]">
<?php
foreach ($db->q("select * from categories") as $category)
{ $selected = in_array($category['id'],$ids)?' selected="selected"':'';
  echo "<option value=\"$category[id]\"$selected>$category[name]</option>";
}
?>
</select><br/>
<input type="submit"/>
</form>
