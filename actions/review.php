<?php
$site = $db->q1("select * from sites where url = ? limit 1",'s',$url);
if (!$site)
{ $url = bin2hex($url);
  redirect("/discover/$username/$password/$url");
}
if (!$userSite = $db->q1("select * from users_sites where site_id = ? and user_id = ?",'ii',$site['id'],$user['id']))
{ if (!$db->q("insert into users_sites (site_id,user_id,`like`,created) values (?,?,0,NOW())",'ii',$site['id'],$user['id']))
  { error("Cannot register visit for review");
  }
  $userSite = $db->q1("select * from users_sites where site_id = ? and user_id = ?",'ii',$site['id'],$user['id']);
}
if (isset($_POST['review']))
{ $oldLike = $userSite['like'];
  $newLike = 0;
  if (isset($_POST['hate'])) $newLike = -1;
  if (isset($_POST['like'])) $newLike = 1;
  $oldReview = $userSite['review'];
  $newReview = $_POST['review'];
  $newReview = $newReview?:null;
  if ($oldLike != $newLike || $oldReview != $newReview)
  { if (!$db->q("update users_sites set `like` = ?, review = ? where id = ?",'isi',$newLike,$newReview,$userSite['id']))
    { error("Cannot update like");
    }
  }
  redirect($url);
}
?>
<form method="post">
<input type="submit" name="like" value="like"/> <input type="submit" name="meh" value="meh"/> <input type="submit" name="hate" value="hate" /><br/><br/>
<?php
$likeStatus = array(-1=>'hate',0=>'meh',1=>'like');
$reviews = $db->q("select u.username, us.review, us.like from users as u, users_sites as us where us.user_id = u.id and u.id!=? and us.site_id = ? and review is not null",'ii',$user['id'],$site['id']);
foreach ($reviews as $review)
{ $status = $likeStatus[$review['like']];
  echo "<a href=\"/rss/$review[username]\">$review[username]</a> says \"$status\":<br/>".nl2br(htmlentities($review['review'])).'<hr/>';
}
$review = $db->q1("select review from users_sites where site_id = ? and user_id = ? and review is not null",'ii',$site['id'],$user['id']);
$review = $review?$review['review']:'';
$status = $likeStatus[$userSite['like']];
?>
<?php echo "<a href=\"/rss/$username\">$username</a> says \"$status\":<br/>"; ?>
<textarea name="review" style="height: 300px; width: 500px;">
<?php echo htmlentities($review); ?>
</textarea><br/>
<input type="submit" name="like" value="like"/> <input type="submit" name="meh" value="meh"/> <input type="submit" name="hate" value="hate" /><br/><br/>
</form>