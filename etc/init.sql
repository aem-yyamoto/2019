create database board_php;

/* userの権限の設定 ローカルホストからdbuserにアクセスできるようにする */
grant all on board_php.* to dbboard@localhost identified by 'mu4uJsif';

use board_php;

create table users(
    email varchar(255) unique primary key, /* unique: 重複禁止 */
    password varchar(255),
    created datetime, /*  作った時間 */
    modified datetime, /* 更新時間 */
    num_post int, /* 投稿数 */
    total_good int, /* 合計いいね！ */
    nickname varchar(255), /* ニックネーム */
    flag_admin boolean,
    flag_reflect boolean
);

create table threads(
    thread_id int not null auto_increment primary key,
    created_user_id varchar(255),
    title varchar(255) unique,
    created datetime, /*  作った時間 */
    modified datetime, /* 更新時間 */
    category varchar(255), /* カテゴリー */
    flag_reflect boolean,
    num_post int
);

create table articles(
    article_id int not null,
    thread_id int not null,
    created_user_id varchar(255),
    text varchar(255),
    created datetime, /*  作った時間 */
    modified datetime, /* 更新時間 */
    quote_article_id int, /* 引用元のarticle_id */
    flag_reflect boolean, /* 反映フラグ */
    nickname varchar(255),
    flag_exist boolean /* 退会したかのフラグ */
);

create table goods(
    article_id int not null,
    thread_id int not null,
    from_user_id varchar(255),
    to_user_id varchar(255),
    time datetime,
    flag_exist boolean
);

create table blacklist(
    user_id varchar(255),
    created datetime /*  作った時間 */
);

create table pager_setting(
    show_num int not null /* １ページに何個の記事を出力するか */
);

create table main(
    title varchar(255) not null, /* タイトル */
    attention varchar(255) /* 注意書き */
);

create table categories(
    category_id int not null auto_increment primary key,
    category varchar(255) not null unique/* カテゴリー */
);

desc users;
desc threads;
desc articles;
desc goods;
desc blacklist;
desc pager_setting;
desc main;
desc categories;