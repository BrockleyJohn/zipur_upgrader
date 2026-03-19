CREATE TABLE analytics_events (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  customer_id INT UNSIGNED DEFAULT NULL,
  merchant_id INT UNSIGNED NOT NULL DEFAULT 0,
  event_type VARCHAR(255) NOT NULL,
  product_id INT UNSIGNED DEFAULT NULL,
  payload LONGTEXT NOT NULL,
  page_url TEXT DEFAULT NULL,
  referrer TEXT DEFAULT NULL,
  domain VARCHAR(255) DEFAULT NULL,
  user_agent TEXT DEFAULT NULL,
  ip_address VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_event_type (event_type),
  INDEX idx_product (product_id),
  INDEX idx_merchant (merchant_id),
  INDEX idx_created_at (created_at),
  INDEX idx_customer_id (customer_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE customers ADD status INT NOT NULL DEFAULT '1';
ALTER TABLE products_description DROP products_viewed; 
