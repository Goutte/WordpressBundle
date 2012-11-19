
-- POSTS

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
 (3, 1, '2012-11-19 01:38:22', '2012-11-19 01:38:22', 'Welcome to WordPress. This is your first post draft. Edit or delete it, then start testing!', 'Hello world 2!', 'This is your first post draft.', 'draft', 'open', 'open', '', 'hello-world-2', '', '', '2012-11-19 01:38:22', '2012-11-19 01:38:22', '', 0, 'http://localhost/FREE/shine/mob/wp/?p=3', 0, 'post', '', 1)
,(4, 1, '2012-11-19 10:05:28', '2012-11-19 10:05:28', '', 'Intruders!', '', 'inherit', 'open', 'open', '', 'intruders_detected', '', '', '2012-11-19 10:05:28', '2012-11-19 10:05:28', '', '0', 'http://localhost/FREE/shine/mob/wp/wp-content/uploads/2012/11/intruders_detected.png', '0', 'attachment', 'image/png', '0')
,(5, 1, '2012-11-19 12:01:10', '2012-11-19 12:01:10', '', 'Galaxy', '', 'inherit', 'open', 'open', '', 'Galaxy', '', '', '2012-11-19 12:01:10', '2012-11-19 12:01:10', '', 0, 'http://localhost/FREE/shine/mob/wp/wp-content/uploads/2012/11/Galaxy.gif', 0, 'attachment', 'image/gif', 0)
;

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
 (2, 4, '_wp_attached_file', '2012/11/intruders_detected.png')
,(3, 4, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:120;s:6:"height";i:71;s:4:"file";s:30:"2012/11/intruders_detected.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:10:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";}}')
,(4, 1, '_wp_something', 'good')
;
