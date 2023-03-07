SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `employee` (
                            `emp_id` int(11) NOT NULL,
                            `emp_name` varchar(255) NOT NULL,
                            `emp_role` varchar(255) NOT NULL,
                            `emp_salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `employee` (`emp_id`, `emp_name`, `emp_role`, `emp_salary`) VALUES
                                                                            (1, 'ante', 'frontend', 5000),
                                                                            (2, 'mate', 'backend', 3500),
                                                                            (3, 'pero', 'QA', 2000),
                                                                            (4, 'sheldon', 'frontend', 6000),
                                                                            (5, 'ray', 'backend', 3000),
                                                                            (6, 'penny', 'QA', 2500),
                                                                            (7, 'josip', 'project_manager', 7000),
                                                                            (8, 'mirko', 'project_manager', 7000);

CREATE TABLE `project` (
                           `project_id` int(11) NOT NULL,
                           `project_name` varchar(255) NOT NULL,
                           `lead_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `project` (`project_id`, `project_name`, `lead_id`) VALUES
                                                                    (1, 'Web Application', 1),
                                                                    (2, 'Mobile Application', 4);

CREATE TABLE `project_managment` (
                                     `request_id` int(11) NOT NULL,
                                     `project_type` varchar(255) NOT NULL,
                                     `project_budget` varchar(255) NOT NULL,
                                     `project_description` varchar(255) NOT NULL,
                                     `project_deadline` date DEFAULT NULL,
                                     `proj_manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `project_managment` (`request_id`, `project_type`, `project_budget`, `project_description`, `project_deadline`, `proj_manager_id`) VALUES
                                                                                                                                                   (1, 'Web Application', '1000$', 'Online web shop for clothes.', '2023-11-22', 7),
                                                                                                                                                   (3, 'Mobile Application', '5000$', 'Mobile application for downloading chords.', '2024-11-22', 8),
                                                                                                                                                   (4, 'Mobile App', '2000$', 'Mobile app for video system.', '2023-05-30', 7);


ALTER TABLE `employee`
    ADD PRIMARY KEY (`emp_id`);

ALTER TABLE `project`
    ADD PRIMARY KEY (`project_id`),
  ADD KEY `lead_id` (`lead_id`);

ALTER TABLE `project_managment`
    ADD PRIMARY KEY (`request_id`),
  ADD KEY `proj_manager_id` (`proj_manager_id`);


ALTER TABLE `employee`
    MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `project`
    MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `project_managment`
    MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `project`
    ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `employee` (`emp_id`);

ALTER TABLE `project_managment`
    ADD CONSTRAINT `project_managment_ibfk_1` FOREIGN KEY (`proj_manager_id`) REFERENCES `employee` (`emp_id`);
COMMIT;
