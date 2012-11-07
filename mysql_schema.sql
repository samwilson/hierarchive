CREATE TABLE IF NOT EXISTS groups (
  id int(6) NOT NULL AUTO_INCREMENT,
  owner_id int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `name` (`name`),
  KEY owner_id (owner_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS permissions (
  id int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB;

INSERT INTO permissions (id, `name`) VALUES
(3, 'Create Resources'),
(2, 'Read Contents'),
(1, 'Read Metadata'),
(5, 'Update Contents'),
(4, 'Update Metadata');

CREATE TABLE IF NOT EXISTS resource_permissions (
  resource_id int(6) NOT NULL,
  permission_id int(2) NOT NULL,
  group_id int(6) NOT NULL,
  PRIMARY KEY (resource_id,permission_id,group_id),
  KEY resource_permissions_ibfk_3 (group_id),
  KEY resource_permissions_ibfk_2 (permission_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS resources (
  id int(6) NOT NULL AUTO_INCREMENT,
  title varchar(200) NOT NULL,
  parent_id int(6) DEFAULT NULL,
  description text NOT NULL,
  PRIMARY KEY (id),
  KEY parent_id (parent_id)
) ENGINE=InnoDB;

INSERT INTO resources (id, title, parent_id, description) VALUES
(1, 'Hierarchical Archive', NULL, 'A document repository.');

CREATE TABLE IF NOT EXISTS users (
  id int(6) NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS group_members (
  group_id int(2) NOT NULL,
  user_id int(6) NOT NULL,
  PRIMARY KEY (group_id,user_id)
) ENGINE=InnoDB;


ALTER TABLE `groups`
  ADD CONSTRAINT groups_owner FOREIGN KEY (owner_id) REFERENCES `users` (id);

ALTER TABLE `resource_permissions`
  ADD CONSTRAINT resource_permissions_group FOREIGN KEY (group_id) REFERENCES `groups` (id),
  ADD CONSTRAINT resource_permissions_resource FOREIGN KEY (resource_id) REFERENCES `resources` (id),
  ADD CONSTRAINT resource_permissions_permission FOREIGN KEY (permission_id) REFERENCES `permissions` (id);

ALTER TABLE `resources`
  ADD CONSTRAINT resources_parent FOREIGN KEY (parent_id) REFERENCES resources (id);

ALTER TABLE `group_members`
  ADD CONSTRAINT group_members_group FOREIGN KEY (group_id) REFERENCES `groups` (id),
  ADD CONSTRAINT group_members_user FOREIGN KEY (user_id) REFERENCES `users` (id);
