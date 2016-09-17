insert into `user`(id, first_name, last_name, email)
select id, SUBSTRING_INDEX(name, ' ', 1), SUBSTRING_INDEX(name, ' ', -1), email from member;

insert into `church_link`(church_id, user_id, acl_levels_id)
select 1, id, 2 from user;

insert into `transaction_type`(id, type_id, `name`)
select concat('100', `value`), 0, description from select_option where upstream_name = 'contribution_type'
union all
select id, 1, name from withdraw_type;

INSERT INTO `transaction`(`church_id`,`admin_id`,`user_id`,`type_id`,`category_id`,`amount_value`,`amount_type`, `amount_identification`,`date_created`,`comment`)
select                    1, 1100, member_id, 0, concat('100', contribution_type_id), amount, payment_type_id, '', `timestamp`, `comment` from contribution
union all
select                    1, 1100, 0, 1, withdraw_type_id, amount * -1, 0, invoice_number, `timestamp`, description from withdraw

