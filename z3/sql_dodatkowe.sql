-- Uruchom w phpMyAdmin w tej samej bazie, w której masz tabelę users z LAB1.
CREATE TABLE IF NOT EXISTS user_avatars (
  user_id INT NOT NULL PRIMARY KEY,
  filename VARCHAR(100) NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Jeżeli identyfikator users.id ma typ SMALLINT, osobna tabela nadal działa.
