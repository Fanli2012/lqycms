<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url><loc><?php echo sysconfig('CMS_BASEHOST'); ?>/</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
<url><loc><?php echo sysconfig('CMS_BASEHOST'); ?>/contact.html</loc></url>
<?php $posts=arclist(array("row"=>300));foreach($posts as $row){ ?><url><loc><?php echo sysconfig('CMS_BASEHOST'); ?><?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?></loc><lastmod><?php echo date("Y-m-d",$row['pubdate']); ?></lastmod><changefreq>monthly</changefreq></url><?php } ?>
<?php $posts=arclist(array("row"=>100,"orderby"=>'rand()'));foreach($posts as $row){ ?><url><loc><?php echo sysconfig('CMS_BASEHOST'); ?><?php echo get_front_url(array("id"=>$row['id'],"catid"=>$row['typeid'],"type"=>'content')); ?></loc><lastmod><?php echo date("Y-m-d",$row['pubdate']); ?></lastmod><changefreq>monthly</changefreq></url><?php } ?>

<?php $posts=dataList("arctype");foreach($posts as $row){ ?><url><loc><?php echo sysconfig('CMS_BASEHOST'); ?><?php echo get_front_url(array("catid"=>$row['id'],"type"=>'list')); ?></loc></url><?php } ?>
</urlset>