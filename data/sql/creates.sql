CREATE TABLE `response_text` (
  `alias` varchar(100) NOT NULL COMMENT 'Alias',
  `text` text CHARACTER SET utf8mb4 NOT NULL COMMENT 'Text',
  `description` text NOT NULL COMMENT 'Response text description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `response_text` (`alias`, `text`, `description`) VALUES
('start', 'Hello there!', 'Message shown when /start command received');

CREATE TABLE `settings` (
  `alias` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Alias',
  `title` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Title',
  `default_value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'default value',
  `enabled` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'yes' COMMENT 'Enabled?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `states` (
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Alias',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Title'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `chat_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Chat ID',
  `nickname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Nickname',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Name',
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'SURNAME',
  `status` enum('active','disabled') COLLATE utf8mb4_unicode_ci DEFAULT 'active' COMMENT 'Access status',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users_settings` (
  `user` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'USER',
  `setting` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SETTING',
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'VALUE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users_states` (
  `user` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'USER',
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'STATE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `response_text`
  ADD PRIMARY KEY (`alias`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`alias`);

ALTER TABLE `states`
  ADD PRIMARY KEY (`alias`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`chat_id`);

ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`user`,`setting`),
  ADD KEY `users_settings_ifbk_2` (`setting`);

ALTER TABLE `users_states`
  ADD PRIMARY KEY (`user`),
  ADD KEY `users_states_ifbk_2` (`state`);

ALTER TABLE `users_settings`
  ADD CONSTRAINT `users_settings_ifbk_1` FOREIGN KEY (`user`) REFERENCES `users` (`chat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_settings_ifbk_2` FOREIGN KEY (`setting`) REFERENCES `settings` (`alias`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `users_states`
  ADD CONSTRAINT `users_states_ifbk_1` FOREIGN KEY (`user`) REFERENCES `users` (`chat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_states_ifbk_2` FOREIGN KEY (`state`) REFERENCES `states` (`alias`) ON DELETE CASCADE ON UPDATE CASCADE;

