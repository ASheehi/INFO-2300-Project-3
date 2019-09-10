-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );

CREATE TABLE `users` (
    `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
 	`username`	TEXT NOT NULL UNIQUE,
    `password` TEXT NOT NULL
);

CREATE TABLE `images` (
    `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
 	`name`	TEXT NOT NULL UNIQUE,
    `file_name` TEXT NOT NULL,
    `file_ext` TEXT NOT NULL,
    `description` TEXT,
    `user_id` INTEGER NOT NULL
);

CREATE TABLE `tags` (
    `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
 	`name`	TEXT NOT NULL UNIQUE
);

CREATE TABLE `image_tags` (
    `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
 	`image_id`	INTEGER NOT NULL,
    `tag_id` INTEGER NOT NULL
);

CREATE TABLE sessions (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE
);

-- TODO: initial seed data

-- TODO: FOR HASHED PASSWORDS, LEAVE A COMMENT WITH THE PLAIN TEXT PASSWORD!

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');

INSERT INTO users (id, username, password) VALUES (1, 'ajs636', '$2y$10$V/1LtHgbUfQtle41RLuAk.pvppdZ3BTgiaFvld13RgUXp5Tib23f6'); -- password: penguin

INSERT INTO users (id, username, password) VALUES (2, 'asheehi', '$2y$10$5N6odSULDU3bZf/9wIhGXO69/YHWWUFcb2ZnryKNU876oj1fQQoXK'); -- password: hedgehog

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (1, "Olin Library", 'olin.jpeg', 'jpeg', 'This is Olin, where all the people study!', 2);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (2, "Duffield", 'duffield.jpg', 'jpg', 'This is Duffield, where all the Engineers come from!', 1);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (3, "Appel", 'appel.jpeg', 'jpeg', 'The best dining hall on North hands-down!', 1);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (4, "Baker Flagpole", 'slope.jpeg', 'jpeg', 'A beautiful view of baker flagpole!', 1);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (5, "Balch Hall", 'balch.jpeg', 'jpeg', 'Balch Hall on a spooky winter day...', 2);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (6, "Arts Quad", 'arts.jpeg', 'jpeg', 'Arts quad on a surprisingly nice day :)', 1);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (7, "Cascadilla Gorge", 'casc.jpeg', 'jpeg', 'The best gorge on campus', 1);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (8, "Waterfall", 'waterfall.jpeg', 'jpeg', 'Waterfall on North!', 2);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (9, "Sunny Arts Quad", 'quad.jpeg', 'jpeg', 'A beautiful fall day on the quad!', 2);

-- Source: (original photo) Anthony Sheehi --
INSERT INTO images (id, name, file_name, file_ext, description, user_id) VALUES (10, "Bingalee Dingalee", 'clock.jpeg', 'jpeg', 'Oh the infamous clock tower...', 2);

INSERT INTO tags (id, name) VALUES (1, "North");

INSERT INTO tags (id, name) VALUES (2, "Central");

INSERT INTO tags (id, name) VALUES (3, "West");

INSERT INTO tags (id, name) VALUES (4, "Nature");

INSERT INTO tags (id, name) VALUES (5, "Historic");

INSERT INTO image_tags (image_id, tag_id) VALUES (8, 1);

INSERT INTO image_tags (image_id, tag_id) VALUES (8, 4);

INSERT INTO image_tags (image_id, tag_id) VALUES (1, 2);

INSERT INTO image_tags (image_id, tag_id) VALUES (1, 5);

INSERT INTO image_tags (image_id, tag_id) VALUES (2, 2);

INSERT INTO image_tags (image_id, tag_id) VALUES (3, 1);

INSERT INTO image_tags (image_id, tag_id) VALUES (4, 3);

INSERT INTO image_tags (image_id, tag_id) VALUES (4, 4);

INSERT INTO image_tags (image_id, tag_id) VALUES (4, 5);

INSERT INTO image_tags (image_id, tag_id) VALUES (5, 1);

INSERT INTO image_tags (image_id, tag_id) VALUES (5, 5);

INSERT INTO image_tags (image_id, tag_id) VALUES (6, 2);

INSERT INTO image_tags (image_id, tag_id) VALUES (7, 4);

INSERT INTO image_tags (image_id, tag_id) VALUES (7, 5);

INSERT INTO image_tags (image_id, tag_id) VALUES (9, 4);

INSERT INTO image_tags (image_id, tag_id) VALUES (9, 2);


COMMIT;
