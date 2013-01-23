<?php
foreach ($db->q("select * from users") as $user)
{ $username = urlencode($user['username']);
  echo "<a href=\"/rss/$username\">$user[username]</a><br/>";
}
echo '<a href="/subscribe">subscribe</a>';