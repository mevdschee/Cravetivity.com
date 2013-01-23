<?php
if (!$categories = $db->q("select category_id from users_categories where user_id = ?",'i',$user['id']))
{ error("No categories found");
}
$ids = implode(',',array_map(function($v){ return $v['category_id']+0; },$categories));
$site = $db->q1("select s.* from sites as s left join users_sites as us on s.id = us.site_id and us.user_id = ? where s.category_id in ($ids) and us.id is null limit 1",'i',$user['id']);
if (!$site)
{ redirect('/exhausted');
}
if (!$db->q("insert into users_sites (site_id,user_id, created) values (?,?,NOW())",'ii',$site['id'],$user['id']))
{ error("Cannot register visit");
}
redirect($site[url]);
