09/07/2023
ALTER TABLE `funds` ADD `approved` TINYINT NOT NULL DEFAULT '0' AFTER `branch_id`;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `status`, `created_at`, `updated_at`) 
VALUES (NULL, 'fund-approve', 'admin', '1', '2023-07-09 00:00:00', '2023-07-09 00:00:00');