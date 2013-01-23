<?php 
if (!$user = $db->q1("select * from users as u where username = ? limit 1",'s',$username))
{ error("User '$username' not found");
}
echo '<p>Discoveries:</p><ol>';
$sites = $db->q("select s.* from sites as s where s.user_id = ?",'i',$user['id']);
foreach ($sites as $site)
{ echo "<li><a href=\"$site[url]\">$site[url]</a></li>";
}
echo '</ol>';
echo '<p>Likes:</p><ol>';
$sites = $db->q("select s.* from sites as s, users_sites as us where s.id = us.site_id and (s.user_id is null or s.user_id != ?) and us.user_id = ? and us.like=1 and us.review is null",'ii',$user['id'],$user['id']);
foreach ($sites as $site)
{ echo "<li><a href=\"$site[url]\">$site[url]</a></li>";
}
echo '</ol>';
echo '<p>Likes with review:</p><ol>';
$sites = $db->q("select s.* from sites as s, users_sites as us where s.id = us.site_id and us.user_id = ? and us.like=1 and us.review is not null",'i',$user['id']);
foreach ($sites as $site)
{
  echo "<li><a href=\"$site[url]\">$site[url]</a></li>";
}
echo '</ol>';
