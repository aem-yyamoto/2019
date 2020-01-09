/* initialize data of db */

/* add admin user */
insert into users (email, password, created, modified, num_post, total_good, nickname, flag_admin, flag_reflect) values ("admin@gmail.com", "$2y$10$Qop2P60u1Q2rtyuQPNEVJe23jrA6Xcqj80A/XHycAksvThUe0DFp.", now(), now(), 0, 0, "admin", true, true);
insert into users (email, password, created, modified, num_post, total_good, nickname, flag_admin, flag_reflect) values ("guest@gmail.com", null, now(), now(), null, null, "guest", null, true);

/* add main information (title, attention) */
insert into main (title, attention) values ("title", "attention");

/* add pager_setting */
insert into pager_setting (show_num) values (30);

/* add category */
insert into category (category) values ("本");
insert into category (category) values ("小説");

/* add threads */
insert into threads (created_user_id, title, created, modified, category, flag_reflect, num_post) values ("admin@gmail.com", "オススメの本01", now(), now(), "本", true, 0);
insert into threads (created_user_id, title, created, modified, category, flag_reflect, num_post) values ("admin@gmail.com", "オススメの本02", now(), now(), "本", true, 0);
insert into threads (created_user_id, title, created, modified, category, flag_reflect, num_post) values ("admin@gmail.com", "オススメの本03", now(), now(), "小説", true, 0);
