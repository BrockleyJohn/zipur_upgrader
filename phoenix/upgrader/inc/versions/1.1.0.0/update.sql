UPDATE configuration SET configuration_value = 'override' WHERE configuration_key = 'TEMPLATE_SELECTION';

INSERT INTO hooks (hooks_site, hooks_group, hooks_action, hooks_code, hooks_class, hooks_method) VALUES ('shop', 'advanced_search_result', 'productListing', 'filter_category_brand', 'product_searcher', 'hook');