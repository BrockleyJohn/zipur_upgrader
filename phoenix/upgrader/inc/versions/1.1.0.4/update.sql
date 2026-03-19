CREATE INDEX idx_orders_total_orders_id_class ON orders_total (orders_id, class);
CREATE INDEX idx_orders_status_id_language ON orders_status (orders_status_id, language_id);
CREATE INDEX idx_orders_last_modified ON orders (last_modified);
CREATE INDEX idx_orders_date_purchased ON orders (date_purchased);
DELETE FROM sessions;