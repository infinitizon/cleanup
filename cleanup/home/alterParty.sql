ALTER TABLE PARTY_ ADD PRIMARYPHONENO_ varchar(255) default NULL;
UPDATE PARTY_ p
SET p.PRIMARYPHONENO_ = ( SELECT NO_ FROM (
SELECT PARTY_ID, IFNULL(PHONENUMBER_, PERSONALPHONENUMBER_) NO_ 
FROM PARTY_
) t 
WHERE t.PARTY_ID = p.PARTY_ID)
;