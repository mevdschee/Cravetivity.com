<?php
if (isset($_POST['category_id']))
{ $categoryId = $_POST['category_id'];
  if (!$db->q("insert into sites (url,category_id,user_id,created) values (?,?,?,NOW())",'sii',$url,$categoryId,$user['id']))
  { error("Site can not be added");
  }
  $siteId = $db->handle()->insert_id;
  $review = $_POST['review'];
  $like = 0;
  if (isset($_POST['hate'])) $like = -1;
  if (isset($_POST['like'])) $like = 1;
  if (!$review) $review = null;
  if (!$db->q("insert into users_sites (site_id,user_id,`like`,review,created) values (?,?,1,?,NOW())",'iis',$siteId,$user['id'],$review))
  { error("Cannot like added site");
  }
  redirect($url);
}
?>
<h3>New discovery!</h3>
<form method="post">
Category<br/>
<select name="category_id" size="2" style="height: 300px; width: 500px;">
<?php
foreach ($db->q("select * from categories") as $category)
{ echo "<option value=\"$category[id]\">$category[name]</option>";
}
?>
</select><br/>
<input type="submit" name="like" value="like"/> <input type="submit" name="meh" value="meh"/> <input type="submit" name="hate" value="hate" /><br/><br/>
<?php echo "<a href=\"/rss/$username\">$username</a> says \"meh\":<br/>"; ?>
<textarea name="review" style="height: 300px; width: 500px;">
</textarea><br/>
<input type="submit" name="like" value="like"/> <input type="submit" name="meh" value="meh"/> <input type="submit" name="hate" value="hate" /><br/><br/>
</form>
