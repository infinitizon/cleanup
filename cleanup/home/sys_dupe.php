DELIMITER $$
DROP PROCEDURE IF EXISTS `sys_dedupe`$$
CREATE PROCEDURE `sys_dedupe`(IN start int(2), OUT dupe_Cnt int(5))
BEGIN
	DECLARE pr_ID bigint(20); DECLARE p_ID bigint(20); DECLARE tp_ID bigint(20); DECLARE ST_ACC_NO varchar(255);
	DECLARE p_ttl_ID bigint(20); DECLARE f_nm varchar(255); DECLARE m_nm varchar(255); DECLARE l_nm varchar(255);
	DECLARE init varchar(255); DECLARE gnd_id bigint(20); DECLARE m_stat_ID bigint(20); DECLARE mdn_nm varchar(255);
	DECLARE dob datetime; DECLARE p_eml_adr varchar(255); DECLARE cty_id bigint(20); DECLARE p_phn_no varchar(255);
	DECLARE w_phn_no varchar(255); DECLARE adr_ln_1 varchar(255); DECLARE adr_ln_2 varchar(255); DECLARE adr_cty varchar(255);
	DECLARE adr_st_id bigint(20); DECLARE adr_cty_id bigint(20); DECLARE ful_nm varchar(255); 

	DECLARE finished INTEGER DEFAULT 0;
	DECLARE dupe_wt_acc CURSOR FOR
		SELECT m1.PARTYROLE_ID, m1.PARTY_ID, m1.TYPE_ID, m1.ERPST_ACC_NOS, m1.PARTYTITLE_ID, m1.FIRSTNAME_, m1.MIDDLENAME_
				, m1.LASTNAME_, m1.INITIALS_, m1.GENDER_ID, m1.MARITALSTATUSTYPE_ID, m1.MAIDENNAME_, m1.DATEOFBIRTH_
				, m1.PRIMARYEMAILADDRESS_, m1.COUNTRY_ID, m1.PRIMARYPHONENO_, m1.WORKPHONENUMBER_, m1.ADDRESSLINE1_
				, m1.ADDRESSLINE2_, m1.ADDRESSCITY_, m1.ADDRESSSTATE_ID, m1.ADDRESSCOUNTRY_ID, m1.FULLNAME_
			FROM migration_ m1
				JOIN migration_ m2
					ON (
						IFNULL(m1.TYPE_ID, 0) = IFNULL(m2.TYPE_ID, 0)
						AND IFNULL(m1.PARTYTITLE_ID, 0) = IFNULL(m2.PARTYTITLE_ID, 0)
						AND IFNULL(m1.FIRSTNAME_, 0) = IFNULL(m2.FIRSTNAME_, 0)
						AND IFNULL(m1.MIDDLENAME_, 0) = IFNULL(m2.MIDDLENAME_, 0)
						AND IFNULL(m1.LASTNAME_,0) = IFNULL(m2.LASTNAME_,0)
						AND IFNULL(m1.INITIALS_,0) = IFNULL(m2.INITIALS_,0)
						AND IFNULL(m1.GENDER_ID,0) = IFNULL(m2.GENDER_ID,0)
						AND IFNULL(m1.MARITALSTATUSTYPE_ID,0) = IFNULL(m2.MARITALSTATUSTYPE_ID,0)
						AND IFNULL(m1.DATEOFBIRTH_,0) = IFNULL(m2.DATEOFBIRTH_,0)
						AND IFNULL(m1.PRIMARYEMAILADDRESS_,0) = IFNULL(m2.PRIMARYEMAILADDRESS_,0)
						AND IFNULL(m1.COUNTRY_ID,0) = IFNULL(m2.COUNTRY_ID,0)
						AND IFNULL(m1.ADDRESSLINE1_,0) = IFNULL(m2.ADDRESSLINE1_,0)
						AND IFNULL(m1.ADDRESSLINE2_,0) = IFNULL(m2.ADDRESSLINE2_,0)
						AND IFNULL(m1.ADDRESSCITY_,0) = IFNULL(m2.ADDRESSCITY_,0)
						AND IFNULL(m1.ADDRESSSTATE_ID,0) = IFNULL(m2.ADDRESSSTATE_ID,0)
						AND IFNULL(m1.ADDRESSCOUNTRY_ID,0) = IFNULL(m2.ADDRESSCOUNTRY_ID,0)
						AND IFNULL(m1.FULLNAME_,0) = IFNULL(m2.FULLNAME_,0)
					)
			WHERE m1.PARTYROLE_ID<> m2.PARTYROLE_ID
				AND  m1.PARTY_ID <> m2.PARTY_ID
				AND  m1.CUSTOMERID_ <> m2.CUSTOMERID_
			#	AND m1.PARTYROLE_ID IN('658243963','658244042')
				AND m1.ERPST_ACC_NOS IS NOT NULL
		;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished=1;
	OPEN dupe_wt_acc;
		dupeloop: LOOP
			FETCH dupe_wt_acc INTO  pr_ID, p_ID, tp_ID, ST_ACC_NO, p_ttl_ID, f_nm, m_nm, l_nm
									, init, gnd_id, m_stat_ID, mdn_nm, dob, p_eml_adr, cty_id, p_phn_no, w_phn_no
									, adr_ln_1, adr_ln_2, adr_cty, adr_st_id, adr_cty_id, ful_nm; 
			IF finished=1 THEN
				SET dupe_Cnt = dupe_Cnt;
				LEAVE dupeloop;
			END IF;

			IF NOT EXISTS ( SELECT PARTYROLE_ID FROM migration_
							WHERE IFNULL(FIRSTNAME_,0) = IFNULL(f_nm,0)
							  AND IFNULL(PARTYTITLE_ID,0) = IFNULL(p_ttl_ID,0)
							  AND IFNULL(MIDDLENAME_,0) = IFNULL(m_nm,0)
							  AND IFNULL(LASTNAME_,0) = IFNULL(l_nm,0)
							  AND IFNULL(INITIALS_,0) = IFNULL(init,0)
							  AND IFNULL(GENDER_ID,0) = IFNULL(gnd_id,0)
							  AND IFNULL(MARITALSTATUSTYPE_ID,0) = IFNULL(m_stat_ID,0)
							  AND IFNULL(MAIDENNAME_,0) = IFNULL(mdn_nm,0)
							  AND IFNULL(DATEOFBIRTH_,0) = IFNULL(dob,0)
							  AND IFNULL(PRIMARYEMAILADDRESS_,0) = IFNULL(p_eml_adr,0)
							  AND IFNULL(COUNTRY_ID,0) = IFNULL(cty_id,0)
							  AND IFNULL(PRIMARYPHONENO_,0) = IFNULL(p_phn_no,0)
							  AND IFNULL(WORKPHONENUMBER_,0) = IFNULL(w_phn_no,0)
							  AND IFNULL(ADDRESSLINE1_,0) = IFNULL(adr_ln_1,0)
							  AND IFNULL(ADDRESSLINE2_,0) = IFNULL(adr_ln_2,0)
							  AND IFNULL(ADDRESSCITY_,0) = IFNULL(adr_cty,0)
							  AND IFNULL(ADDRESSSTATE_ID,0) = IFNULL(adr_st_id,0)
							  AND IFNULL(ADDRESSCOUNTRY_ID,0) = IFNULL(adr_cty_id,0)
							  AND IFNULL(FULLNAME_,0) = IFNULL(ful_nm,0)
							  AND ERPST_ACC_NOS IS NULL) THEN
				ITERATE dupeloop; ##If no record, then no dupe, return to the top of loop
			ELSE
				## Update Surviving guy
				UPDATE migration_ 
					SET DATEMARKEDDUPLICATE_ = NOW()
						, LASTUPDATEBY_ = 'SYSTEM-B-SysMergeSuvivingCust'
						, VERSION_ = VERSION_ + 1
				WHERE PARTYROLE_ID=pr_ID;		
				## Update the dupes
				UPDATE migration_ 
					SET ISDUPLICATE_=1
						, DUPLICATE_ID = pr_ID
						, DATEMARKEDDUPLICATE_ = NOW()
						, LASTUPDATEBY_ = 'SYSTEM-B-SysMergeMergedCusts'
						, VERSION_ = VERSION_ + 1
				WHERE PARTYROLE_ID IN (SELECT PARTYROLE_ID 
										FROM (
												SELECT PARTYROLE_ID FROM migration_
												WHERE IFNULL(FIRSTNAME_,0) = IFNULL(f_nm,0)
												  AND IFNULL(MIDDLENAME_,0) = IFNULL(m_nm,0)
												  AND IFNULL(LASTNAME_,0) = IFNULL(l_nm,0)
												  AND IFNULL(INITIALS_,0) = IFNULL(init,0)
												  AND IFNULL(GENDER_ID,0) = IFNULL(gnd_id,0)
												  AND IFNULL(MARITALSTATUSTYPE_ID,0) = IFNULL(m_stat_ID,0)
												  AND IFNULL(MAIDENNAME_,0) = IFNULL(mdn_nm,0)
												  AND IFNULL(DATEOFBIRTH_,0) = IFNULL(dob,0)
												  AND IFNULL(PRIMARYEMAILADDRESS_,0) = IFNULL(p_eml_adr,0)
												  AND IFNULL(COUNTRY_ID,0) = IFNULL(cty_id,0)
												  AND IFNULL(PRIMARYPHONENO_,0) = IFNULL(p_phn_no,0)
												  AND IFNULL(WORKPHONENUMBER_,0) = IFNULL(w_phn_no,0)
												  AND IFNULL(ADDRESSLINE1_,0) = IFNULL(adr_ln_1,0)
												  AND IFNULL(ADDRESSLINE2_,0) = IFNULL(adr_ln_2,0)
												  AND IFNULL(ADDRESSCITY_,0) = IFNULL(adr_cty,0)
												  AND IFNULL(ADDRESSSTATE_ID,0) = IFNULL(adr_st_id,0)
												  AND IFNULL(ADDRESSCOUNTRY_ID,0) = IFNULL(adr_cty_id,0)
												  AND IFNULL(FULLNAME_,0) = IFNULL(ful_nm,0)
												  AND ERPST_ACC_NOS IS NULL
												) as d
											);
				SET dupe_Cnt = dupe_Cnt + 1;
			END IF;

		END LOOP dupeloop;
	CLOSE dupe_wt_acc;
END$$
DELIMITER ;

SET @dupe_Cnt = 0;
CALL sys_dedupe(@dupe_Cnt);
SELECT @dupe_Cnt;