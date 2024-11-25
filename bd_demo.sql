CREATE DATABASE  IF NOT EXISTS `demo`;
USE `demo`;

CREATE TABLE `cache` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` text NOT NULL,
  `description` text,
  `state` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categories` VALUES (1,'Cardiología','images_categorias/zGw5rTnSK1_corazon_v2.png','La Cardiología es la parte de la medicina que se ocupa del estudio, diagnóstico, tratamiento y prevención de las enfermedades cardiovasculares. El cardiólogo es el profesional de la Medicina con la preparación específica para asistir a los pacientes con patologías cardiovasculares, tanto desde el punto de vista clínico, como mediante la utilización de técnicas especializadas en procedimientos diagnósticos y terapéuticos. El cardiólogo también es el encargado de impulsar, desarrollar y colaborar en la investigación de todo lo relacionado con las enfermedades cardiovasculares.',1,'2024-11-22 21:33:58','2024-11-22 17:01:50',0,NULL),(3,'Otorrino','images_categorias/jPc2an1kvV_otorrino_v2.png','El otorrinolaringólogo de la Clínica San Judas Tadeo es el médico especializado en las enfermedades de la cabeza y del cuello. Dentro de la cabeza, aquellas que tienen que ver con la garganta, la nariz y los oídos. La palabra \"otorrinolaringólogo\", nombre extremadamente raro, difícil de decir y de recordar, está compuesta de tres términos griegos y uno latino. Oto-oído, rino-nariz, larin-laringe, gólogo-persona que se dedica a esta ciencia.',1,'2024-11-22 21:40:06','2024-11-22 17:03:32',0,NULL),(4,'Gastroenterología','images_categorias/L35NJ1FL83_gastro_v2.png','La Gastroenterología es la rama de la medicina que se ocupa del estudio del aparato digestivo y de sus enfermedades. Trata los órganos (esófago, estómago, intestino delgado, intestino grueso, recto y ano), así como las glándulas digestivas (hígado, vías biliares y páncreas). La hepatología (hígado) y la proctología (recto y ano) son sus dos especialidades principales.',1,'2024-11-22 16:43:16','2024-11-22 17:03:40',0,NULL),(5,'Urología','images_categorias/jo3W_urologia.png','La Urología es la rama o especialidad medico-quirúrgica que previene, diagnostica y trata las afecciones médicas y quirúrgicas del aparato urinario y retroperitoneo en ambos sexos, de los genitales y el sistema reproductor en el hombre, y algunos problemas ginecológicos.',1,'2024-11-23 21:27:08','2024-11-23 21:27:08',0,NULL),(6,'Ginecología','images_categorias/Mfns_ginecologia.png','La Ginecología es la especialidad de la medicina dedicada al cuidado del sistema reproductor femenino. Los ginecólogos de la Clínica San Judas Tadeo, por lo tanto, son los especialistas que atienden las cuestiones vinculadas al útero, la vagina y los ovarios.',1,'2024-11-23 21:28:19','2024-11-24 02:47:23',0,NULL),(7,'Oftalmología','images_categorias/b8qV_oftalmologia.png','La oftalmología es la especialidad médica que se ocupa del estudio de los ojos, lo cual incluye el tratamiento de las enfermedades y los defectos típicos que padece la visión, tal es el caso del astigmatismo y estrabismo.',1,'2024-11-23 21:29:10','2024-11-23 21:29:10',0,NULL),(8,'Odontología','images_categorias/bJbi_odontoligia.png','El odontólogo de la Clínica San Judas Tadeo es el profesional encargado de la salud oral, no solo se centra en los dientes, sino también en los diversos órganos que componen la cavidad oral. Además del diagnóstico y el tratamiento de enfermedades, se ocupa de la prevención.',1,'2024-11-23 21:30:20','2024-11-23 21:30:20',0,NULL),(9,'Neurología','images_categorias/dBwc_neurologia.png','El neurólogo de la Clínica San Judas Tadeo es el especialista que atiende las enfermedades del cerebro y del resto del sistema nervioso (tanto central como periférico y autónomo). Es decir, es el médico que puede ayudarte cuando padeces dolor de cabeza (migraña o cefalea tensional, por ejemplo), dolor neuropático (neuralgias y sensaciones anormales como parestesias), mareo, vértigo, inestabilidad, alteraciones de conciencia transitorias (crisis epilépticas, confusión, etc.), déﬁcit de memoria y de otras funciones superiores (como el lenguaje, la atención-concentración y la orientación temporo-espacial), alteraciones de la marcha y del equilibrio, temblores y tics, pérdida de fuerza, ciertos problemas de visión (visión doble, pérdida de la vista, etc.), alteraciones del sueño, etc.',1,'2024-11-23 21:31:18','2024-11-24 02:47:45',0,NULL);

CREATE TABLE `doctors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `imagen` text,
  `category_id` int NOT NULL,
  `hospital_id` int NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `favorite` tinyint(1) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `about_me` text,
  `experience` json DEFAULT NULL,
  `hospital_experience` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `hospital_id` (`hospital_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `doctors` VALUES (1,'Christian','Arriola','imagen_doctor/kgGkvX.arriola_v2_jpg',1,1,'985432221',1,'carriola@fap.pe','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam tellus quis felis convallis vestibulum hendrerit et ligula. Duis at vulputate justo, non tincidunt enim. In gravida tortor a suscipit mattis. Mauris a mi sed nulla consectetur gravida. Phasellus bibendum accumsan tristique. Sed euismod nunc a consectetur euismod. Cras sollicitudin auctor turpis.','\"[{\\\"name\\\": \\\"+120 Operaciones\\\"},{\\\"name\\\": \\\"10 años de Experiencia\\\"},{\\\"name\\\": \\\"Profesor de la UPC\\\"}]\"','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam tellus quis felis convallis vestibulum hendrerit et ligula. Duis at vulputate justo, non tincidunt enim. In gravida tortor a suscipit mattis. Mauris a mi sed nulla consectetur gravida. Phasellus bibendum accumsan tristique. Sed euismod nunc a consectetur euismod. Cras sollicitudin auctor turpis.','2024-11-22 16:48:56','2024-11-22 16:55:58',0,NULL),(2,'Melissa','Acuña','imagen_doctor/70rXxo_melissa_acuna.png',6,1,'966654332',1,'macuna@hospital.pe','Vivamus commodo sagittis metus, a convallis odio placerat vitae. Donec in nibh eu arcu eleifend gravida ac et purus. Sed dui urna, sodales vitae dui vitae, pharetra sagittis leo. Nullam non semper leo. Duis malesuada cursus diam nec aliquet. Suspendisse pellentesque cursus rhoncus. Pellentesque condimentum hendrerit neque a iaculis. Proin mollis sed tortor vel finibus. Ut sollicitudin tincidunt congue.','\"[{\\\"name\\\": \\\"+100 Operaciones\\\"},{\\\"name\\\": \\\"8 años de Experiencia\\\"},{\\\"name\\\": \\\"Profesora de la PUCP\\\"}]\"','Vivamus commodo sagittis metus, a convallis odio placerat vitae. Donec in nibh eu arcu eleifend gravida ac et purus. Sed dui urna, sodales vitae dui vitae, pharetra sagittis leo.','2024-11-23 21:45:38','2024-11-23 21:45:38',0,NULL),(3,'Alfredo','Lopez','imagen_doctor/eSHJhx_alfredo_lopez.png',9,1,'975432221',1,'alopez@fap.pe','Vivamus commodo sagittis metus, a convallis odio placerat vitae. Donec in nibh eu arcu eleifend gravida ac et purus. Sed dui urna, sodales vitae dui vitae, pharetra sagittis leo. Nullam non semper leo. Duis malesuada cursus diam nec aliquet. Suspendisse pellentesque cursus rhoncus. Pellentesque condimentum hendrerit neque a iaculis. Proin mollis sed tortor vel finibus. Ut sollicitudin tincidunt congue.','\"[{\\\"name\\\": \\\"+235 Operaciones\\\"},{\\\"name\\\": \\\"15 años de Experiencia\\\"},{\\\"name\\\": \\\"Profesora de la UPC\\\"}]\"','Vivamus commodo sagittis metus, a convallis odio placerat vitae. Donec in nibh eu arcu eleifend gravida ac et purus. Sed dui urna, sodales vitae dui vitae, pharetra sagittis leo. Nullam non semper leo. Duis malesuada cursus diam nec aliquet. Suspendisse pellentesque cursus rhoncus. Pellentesque condimentum hendrerit neque a iaculis. Proin mollis sed tortor vel finibus. Ut sollicitudin tincidunt congue.','2024-11-23 21:51:04','2024-11-23 21:51:04',0,NULL),(4,'Percy','Afiler','imagen_doctor/SM7dp7_percy_afiler.png',5,1,'985431112',1,'pafiler@fap.pe','Vivamus commodo sagittis metus, a convallis odio placerat vitae. Donec in nibh eu arcu eleifend gravida ac et purus. Sed dui urna, sodales vitae dui vitae, pharetra sagittis leo. Nullam non semper leo. Duis malesuada cursus diam nec aliquet. Suspendisse pellentesque cursus rhoncus. Pellentesque condimentum hendrerit neque a iaculis. Proin mollis sed tortor vel finibus. Ut sollicitudin tincidunt congue.','\"[{\\\"name\\\": \\\"+335 Operaciones\\\"},{\\\"name\\\": \\\"20 años de Experiencia\\\"},{\\\"name\\\": \\\"Profesora de San Marcos\\\"}]\"','Vivamus commodo sagittis metus, a convallis odio placerat vitae. Donec in nibh eu arcu eleifend gravida ac et purus. Sed dui urna, sodales vitae dui vitae, pharetra sagittis leo. Nullam non semper leo. Duis malesuada cursus diam nec aliquet. Suspendisse pellentesque cursus rhoncus. Pellentesque condimentum hendrerit neque a iaculis. Proin mollis sed tortor vel finibus. Ut sollicitudin tincidunt congue.','2024-11-23 21:55:35','2024-11-23 21:55:35',0,NULL);

CREATE TABLE `hospitals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `hospitals` VALUES (1,'lorem','lorem',NULL,NULL,'2024-11-22 21:46:09','2024-11-22 21:46:09',0,NULL);

CREATE TABLE `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` VALUES ('xlNQdNGaaTTQ9DXxXtjLEcb69WdtKlQRihST5li3',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVkRRUDRieUZwS1cxdTRTUVJHQTU0Q2VxUEswamlSQnVmQ0VDcXdDVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1732130870),('fd5X8jwy21KorqlxuvS7OPTDZwzQ2EoNaqEP8mS2',NULL,'38.250.150.26','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlBpall2TUlHcTVzZlhaeUtBNXFMOFRqSUpid01HVmpESWhvTG9GWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9hcGlmYXAuY29kZXN0YXRpb24ucGUvYXBpLWRlbW8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1732144338),('FdnnF7pj7uX7lSQmOl8vUdpqmfQkkKsp3pfZQq6o',NULL,'3.239.26.68','Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)','YTozOntzOjY6Il90b2tlbiI7czo0MDoidGZWQU9GeWZhZmZEMUswRWRIQVZwdXhiZlFLU1pORm9RbzNWU3dobiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9hcGlmYXAuY29kZXN0YXRpb24ucGUvYXBpLWRlbW8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1732144337),('JJptpCA5SzPsIEd2Qb6XzyjyM39kdaHgXBaj3qOK',NULL,'38.25.71.189','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Safari/605.1.15','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGczcnhObTlpdXBkNGZXWm85bVNyV1RGRlZoZTZVZU1MYkpNc3FYWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9hcGlmYXAuY29kZXN0YXRpb24ucGUvYXBpLWRlbW8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1732148267),('AlSkomVZkEodtgvVF1ckzT2AIqW6bHrsh4hrNeKK',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlREd1BIM0RsZWV5ZWpDTkxnY2JTZkEzZHEwRTNLWVE2SzJ0N3VDZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1732316777);

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

