BEGIN TRANSACTION;
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`user_id`	TEXT NOT NULL,
	`recent_command`	TEXT,
	`message`	TEXT,
	`context`	TEXT,
	`when`	TEXT DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO `sessions` VALUES (1,'1234','recipe','adobo','[{"title":"Dry Adobo Seasoning (Adobo Seco)","item_url":"http:\/\/www.recipezaar.com\/Dry-Adobo-Seasoning-Adobo-Seco-211317","image_url":"http:\/\/img.recipepuppy.com\/34983.jpg","subtitle":"garlic powder, black pepper, oregano, onion powder, salt","buttons":[{"type":"web_url","url":"http:\/\/www.recipezaar.com\/Dry-Adobo-Seasoning-Adobo-Seco-211317","title":"Learn more"}]},{"title":"Famous Chicken Adobo","item_url":"http:\/\/allrecipes.com\/Recipe\/Famous-Chicken-Adobo\/Detail.aspx","image_url":"http:\/\/img.recipepuppy.com\/26241.jpg","subtitle":"bay leaf, black pepper, garlic, garlic powder, soy sauce, onions, vegetable oil, white vinegar","buttons":[{"type":"web_url","url":"http:\/\/allrecipes.com\/Recipe\/Famous-Chicken-Adobo\/Detail.aspx","title":"Learn more"}]},{"title":"Adobo Bisaya","item_url":"http:\/\/www.recipezaar.com\/Adobo-Bisaya-259503","image_url":"http:\/\/arifbakery-patisserie.co.uk\/wp-content\/themes\/nevia\/images\/shop-01.jpg","subtitle":"brown sugar, garlic, black pepper, leaves, pepper, pork, soy sauce, vinegar, water","buttons":[{"type":"web_url","url":"http:\/\/www.recipezaar.com\/Adobo-Bisaya-259503","title":"Learn more"}]}]','2017-11-16 03:18:09');
COMMIT;
