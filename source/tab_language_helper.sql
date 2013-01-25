/*
SELECT id as idText, (SELECT text FROM hitpbx.tab_language WHERE id = idText AND language = 'en') as texto FROM hitpbx.tab_language WHERE language = 'br' AND text = '';
*/

/*
UPDATE hitpbx.tab_language SET text = 'your text here' WHERE id = 'the idText' AND language = 'br';
*/