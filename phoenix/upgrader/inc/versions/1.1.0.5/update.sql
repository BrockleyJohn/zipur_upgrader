CREATE TABLE outgoing_tpl_info (
  id INT NOT NULL,
  languages_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  text LONGTEXT NOT NULL,
  PRIMARY KEY (id, languages_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO outgoing_tpl_info (id, languages_id, title, text)
SELECT ot.id, l_all.languages_id, ot.title, ot.text
FROM outgoing_tpl ot
JOIN configuration c ON c.configuration_key = 'DEFAULT_LANGUAGE'
JOIN languages l_en ON l_en.code = c.configuration_value
JOIN languages l_all
LEFT JOIN outgoing_tpl_info oti
  ON oti.id = ot.id AND oti.languages_id = l_all.languages_id
WHERE oti.id IS NULL;

ALTER TABLE outgoing ADD languages_id INT NOT NULL AFTER id;

UPDATE outgoing o
JOIN configuration c ON c.configuration_key = 'DEFAULT_LANGUAGE'
JOIN languages l ON l.code = c.configuration_value
SET o.languages_id = l.languages_id;

ALTER TABLE outgoing_tpl
  DROP title,
  DROP text;