CREATE TABLE `plants` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`plant_number`	INTEGER NOT NULL UNIQUE,
  `plant_name` TEXT NOT NULL UNIQUE,
  `plant_genus` TEXT NOT NULL,
  `expl_con` INTEGER NOT NULL,
  `expl_sen` INTEGER NOT NULL,
  `phys_play` INTEGER NOT NULL,
  `imag_play` INTEGER NOT NULL,
  `rest_play` INTEGER NOT NULL,
  `rules_play` INTEGER NOT NULL,
  `bio_play` INTEGER NOT NULL,
  `perennial` INTEGER NOT NULL,
  `annual` INTEGER NOT NULL,
  `full_sun` INTEGER NOT NULL,
  `partial_shade` INTEGER NOT NULL,
  `full_shade` INTEGER NOT NULL,
  `hardiness` TEXT
);

CREATE TABLE `tag_entries` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `plant_id`	INTEGER NOT NULL,
  'tag_id' INTEGER,
  FOREIGN KEY (`plant_id`) REFERENCES `plants`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
);

CREATE TABLE `tags` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name` TEXT
);

CREATE TABLE `users` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL,
  `username` TEXT NOT NULL UNIQUE,
  `password` TEXT NOT NULL,
  `is_admin` INTEGER NOT NULL
);

CREATE TABLE `sessions` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`session`	INTEGER NOT NULL UNIQUE,
  `user_id` INTEGER NOT NULL,
  `last_login` TEXT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE `images` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `file_name` TEXT NOT NULL,
  `file_type` TEXT NOT NULL,
  `file_size` INTEGER NOT NULL
);

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('TR_07', 'Cutleaf Weeping Birch', 'Betula pendula Dalecarlica', 1,1,1,1,1,0,1,0,0,1,1,0,'2-7');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FL_27', 'High Mallow', 'Malva sylvestris', 0,1,1,1,0,0,1,1,0,1,1,0,'8-Apr');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('GA_16', 'Zebra Grass', 'Miscanthus sinensis Zebrinus', 1,1,1,1,1,1,1,1,0,1,0,0,'5-9');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FE_13','Pincushion Moss','Leucobryum glaucum',0,1,0,1,1,0,1,1,0,0,1,1,'10-Apr');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FL_13','Burdock','Arctium minus',0,1,1,1,0,0,1,1,0,1,1,0,'3-10');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('SH_12','Hazelnut/Filbert','Corylus avellana',0,1,1,0,0,0,1,1,0,1,1,0,'4-8');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FL_11','Snowdrops','Galanthus nivalis',0,1,0,1,1,0,0,1,0,1,1,0,'3-7');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('GR_15','Blue violet','Viola sororia',0,1,1,0,0,0,1,1,0,1,1,0,'7-Mar');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('GA_03','Switchgrass','Panicum virgatum',1,1,1,0,1,1,1,1,0,1,1,0,'9-May');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('VI_02', 'Northern Bush Honeysuckle','Diervilla lonicera',0,1,1,1,0,0,1,1,0,1,1,0,'3-7');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FL_12','Solomans Seal','Polygonatum biflorum',0,1,1,1,0,0,1,1,0,0,1,1,'3-9'
);

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FE_11','Ostrich Fern',
'Matteuccia struthiopteris',0,1,0,1,1,1,0,1,0,0,1,1,'7-Mar'
);

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('TR_04','Red Pine',
'Pinus resinosa',1,1,1,0,1,0,1,1,0,1,1,0,'3-9');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('FL_35','Black-Eyed Susan',
'Rudbekia hirta',0,1,1,0,0,0,1,1,0,1,0,0,'7-Mar');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('SH_22','Juneberry Regent',
'Amelanchier alniflora',0,1,1,0,0,0,1,1,0,1,1,0,'2-7');

INSERT INTO 'plants' (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade, hardiness) VALUES ('SH_07','Summer-Sweet','Clethra alnifolia',0,1,1,0,0,0,1,0,0,1,1,0,'3-9');

INSERT INTO `tags` (name) VALUES ('shrub');
INSERT INTO `tags` (name) VALUES ('grass');
INSERT INTO `tags` (name) VALUES ('vine');
INSERT INTO `tags` (name) VALUES ('tree');
INSERT INTO `tags` (name) VALUES ('flower');
INSERT INTO `tags` (name) VALUES ('groundcovers');
INSERT INTO `tags` (name) VALUES ('other');

INSERT INTO `users` (name, username, password, is_admin) VALUES ('Kyle Harms', 'kyle','$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.', 1);
INSERT INTO `users` (name, username, password, is_admin) VALUES ('Miranda Medina', 'miranda','$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.', 1);

INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (1,4);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (2,5);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (3,2);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (4,7);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (5,5);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (6,1);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (7,5);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (8,6);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (9,2);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (10,3);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (11,5);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (12,7);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (13,4);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (14,5);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (15,1);
INSERT INTO `tag_entries` (plant_id, tag_id) VALUES (16,1);

DELETE FROM plants WHERE plant_name='Lily';
