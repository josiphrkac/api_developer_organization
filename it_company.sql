Tables for Database:

CREATE TABLE `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `emp_role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `emp_salary` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- it_company.projects definition

CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_id` (`lead_id`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
