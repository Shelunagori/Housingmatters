
/** ledgers indexes **/
db.getCollection("ledgers").ensureIndex({
  "_id": NumberInt(1)
},[
  
]);

/** ledgers records **/
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000028"),
  "auto_id": NumberInt(426),
  "transaction_date": NumberInt(1433109600),
  "debit": "35122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000029"),
  "auto_id": NumberInt(427),
  "transaction_date": NumberInt(1433109600),
  "credit": "35122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(81),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00002b"),
  "auto_id": NumberInt(428),
  "transaction_date": NumberInt(1433109600),
  "debit": "35331",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00002c"),
  "auto_id": NumberInt(429),
  "transaction_date": NumberInt(1433109600),
  "credit": "35331",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(48),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00002e"),
  "auto_id": NumberInt(430),
  "transaction_date": NumberInt(1433109600),
  "debit": "44444",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00002f"),
  "auto_id": NumberInt(431),
  "transaction_date": NumberInt(1433109600),
  "credit": "44444",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(47),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000031"),
  "auto_id": NumberInt(432),
  "transaction_date": NumberInt(1433109600),
  "debit": "10122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000020"),
  "auto_id": NumberInt(421),
  "transaction_date": NumberInt(1432764000),
  "credit": "55000",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(49),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000032"),
  "auto_id": NumberInt(433),
  "transaction_date": NumberInt(1433109600),
  "credit": "10122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(66),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000034"),
  "auto_id": NumberInt(434),
  "transaction_date": NumberInt(1433196000),
  "debit": "10122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000035"),
  "auto_id": NumberInt(435),
  "transaction_date": NumberInt(1433196000),
  "credit": "10122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(68),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000037"),
  "auto_id": NumberInt(436),
  "transaction_date": NumberInt(1433196000),
  "debit": "51303",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c9"),
  "auto_id": NumberInt(720),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(84),
  "debit": NumberInt(35657),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002cb"),
  "auto_id": NumberInt(721),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002cc"),
  "auto_id": NumberInt(722),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002cd"),
  "auto_id": NumberInt(723),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002ce"),
  "auto_id": NumberInt(724),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002cf"),
  "auto_id": NumberInt(725),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d0"),
  "auto_id": NumberInt(726),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d1"),
  "auto_id": NumberInt(727),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d2"),
  "auto_id": NumberInt(728),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d3"),
  "auto_id": NumberInt(729),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d4"),
  "auto_id": NumberInt(730),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d5"),
  "auto_id": NumberInt(731),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d6"),
  "auto_id": NumberInt(732),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(85),
  "debit": NumberInt(35657),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(54),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d8"),
  "auto_id": NumberInt(733),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002d9"),
  "auto_id": NumberInt(734),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002da"),
  "auto_id": NumberInt(735),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002db"),
  "auto_id": NumberInt(736),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002dc"),
  "auto_id": NumberInt(737),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002dd"),
  "auto_id": NumberInt(738),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002de"),
  "auto_id": NumberInt(739),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002df"),
  "auto_id": NumberInt(740),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e0"),
  "auto_id": NumberInt(741),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e1"),
  "auto_id": NumberInt(742),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14664),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e2"),
  "auto_id": NumberInt(743),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(86),
  "debit": NumberInt(26303),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(55),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e4"),
  "auto_id": NumberInt(744),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e5"),
  "auto_id": NumberInt(745),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e6"),
  "auto_id": NumberInt(746),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e7"),
  "auto_id": NumberInt(747),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e8"),
  "auto_id": NumberInt(748),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002e9"),
  "auto_id": NumberInt(749),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002ea"),
  "auto_id": NumberInt(750),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002eb"),
  "auto_id": NumberInt(751),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002ec"),
  "auto_id": NumberInt(752),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002ed"),
  "auto_id": NumberInt(753),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002ee"),
  "auto_id": NumberInt(754),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(93),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(56),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f0"),
  "auto_id": NumberInt(755),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f1"),
  "auto_id": NumberInt(756),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f2"),
  "auto_id": NumberInt(757),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f3"),
  "auto_id": NumberInt(758),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f4"),
  "auto_id": NumberInt(759),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f5"),
  "auto_id": NumberInt(760),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f6"),
  "auto_id": NumberInt(761),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f7"),
  "auto_id": NumberInt(762),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f8"),
  "auto_id": NumberInt(763),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002f9"),
  "auto_id": NumberInt(764),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15209),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002fa"),
  "auto_id": NumberInt(765),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(101),
  "debit": NumberInt(26848),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(57),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002fc"),
  "auto_id": NumberInt(766),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002fd"),
  "auto_id": NumberInt(767),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002fe"),
  "auto_id": NumberInt(768),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a0002ff"),
  "auto_id": NumberInt(769),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000300"),
  "auto_id": NumberInt(770),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000301"),
  "auto_id": NumberInt(771),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000302"),
  "auto_id": NumberInt(772),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000303"),
  "auto_id": NumberInt(773),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000304"),
  "auto_id": NumberInt(774),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000305"),
  "auto_id": NumberInt(775),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000306"),
  "auto_id": NumberInt(776),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000307"),
  "auto_id": NumberInt(777),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(199),
  "debit": NumberInt(35657),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000308"),
  "auto_id": NumberInt(778),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3349),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a00030b"),
  "auto_id": NumberInt(780),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a00030c"),
  "auto_id": NumberInt(781),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a00030d"),
  "auto_id": NumberInt(782),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a00030e"),
  "auto_id": NumberInt(783),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00030f"),
  "auto_id": NumberInt(784),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000310"),
  "auto_id": NumberInt(785),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1238),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000311"),
  "auto_id": NumberInt(786),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000312"),
  "auto_id": NumberInt(787),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000313"),
  "auto_id": NumberInt(788),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000314"),
  "auto_id": NumberInt(789),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000315"),
  "auto_id": NumberInt(790),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(200),
  "debit": NumberInt(10460),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000316"),
  "auto_id": NumberInt(791),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1034),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000319"),
  "auto_id": NumberInt(793),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00031a"),
  "auto_id": NumberInt(794),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00031b"),
  "auto_id": NumberInt(795),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00031c"),
  "auto_id": NumberInt(796),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00031d"),
  "auto_id": NumberInt(797),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00031e"),
  "auto_id": NumberInt(798),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a00031f"),
  "auto_id": NumberInt(799),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000320"),
  "auto_id": NumberInt(800),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000321"),
  "auto_id": NumberInt(801),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000322"),
  "auto_id": NumberInt(802),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000323"),
  "auto_id": NumberInt(803),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(201),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000324"),
  "auto_id": NumberInt(804),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1960),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000000"),
  "auto_id": NumberInt(806),
  "ledger_account_id": NumberInt(12),
  "ledger_sub_account_id": null,
  "debit": NumberInt(0),
  "credit": NumberInt(439230),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000001"),
  "auto_id": NumberInt(807),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(132),
  "debit": NumberInt(0),
  "credit": NumberInt(165),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000076"),
  "auto_id": NumberInt(131),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000077"),
  "auto_id": NumberInt(132),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000078"),
  "auto_id": NumberInt(133),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000079"),
  "auto_id": NumberInt(134),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200007c"),
  "auto_id": NumberInt(137),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(10),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200007d"),
  "auto_id": NumberInt(138),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(70),
  "debit": NumberInt(10),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200007f"),
  "auto_id": NumberInt(139),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000080"),
  "auto_id": NumberInt(140),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000081"),
  "auto_id": NumberInt(141),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000082"),
  "auto_id": NumberInt(142),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000083"),
  "auto_id": NumberInt(143),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000084"),
  "auto_id": NumberInt(144),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000085"),
  "auto_id": NumberInt(145),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000086"),
  "auto_id": NumberInt(146),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000087"),
  "auto_id": NumberInt(147),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000088"),
  "auto_id": NumberInt(148),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000089"),
  "auto_id": NumberInt(149),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(71),
  "debit": NumberInt(34222),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200008b"),
  "auto_id": NumberInt(150),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200008c"),
  "auto_id": NumberInt(151),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200008d"),
  "auto_id": NumberInt(152),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200008e"),
  "auto_id": NumberInt(153),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200008f"),
  "auto_id": NumberInt(154),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000090"),
  "auto_id": NumberInt(155),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000091"),
  "auto_id": NumberInt(156),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000092"),
  "auto_id": NumberInt(157),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000093"),
  "auto_id": NumberInt(158),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000094"),
  "auto_id": NumberInt(159),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000095"),
  "auto_id": NumberInt(160),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14664),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000096"),
  "auto_id": NumberInt(161),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(72),
  "debit": NumberInt(51303),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000098"),
  "auto_id": NumberInt(162),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000099"),
  "auto_id": NumberInt(163),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200009a"),
  "auto_id": NumberInt(164),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200009b"),
  "auto_id": NumberInt(165),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200009c"),
  "auto_id": NumberInt(166),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200009d"),
  "auto_id": NumberInt(167),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200009e"),
  "auto_id": NumberInt(168),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200009f"),
  "auto_id": NumberInt(169),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a0"),
  "auto_id": NumberInt(170),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a1"),
  "auto_id": NumberInt(171),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15379),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a2"),
  "auto_id": NumberInt(172),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a3"),
  "auto_id": NumberInt(173),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(73),
  "debit": NumberInt(36384),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(12),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a5"),
  "auto_id": NumberInt(174),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a6"),
  "auto_id": NumberInt(175),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a7"),
  "auto_id": NumberInt(176),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a8"),
  "auto_id": NumberInt(177),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000a9"),
  "auto_id": NumberInt(178),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000aa"),
  "auto_id": NumberInt(179),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000ab"),
  "auto_id": NumberInt(180),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000ac"),
  "auto_id": NumberInt(181),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000ad"),
  "auto_id": NumberInt(182),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000ae"),
  "auto_id": NumberInt(183),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15379),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000af"),
  "auto_id": NumberInt(184),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b0"),
  "auto_id": NumberInt(185),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(74),
  "debit": NumberInt(36384),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(13),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b2"),
  "auto_id": NumberInt(186),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b3"),
  "auto_id": NumberInt(187),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b4"),
  "auto_id": NumberInt(188),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b5"),
  "auto_id": NumberInt(189),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b6"),
  "auto_id": NumberInt(190),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b7"),
  "auto_id": NumberInt(191),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b8"),
  "auto_id": NumberInt(192),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000b9"),
  "auto_id": NumberInt(193),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000ba"),
  "auto_id": NumberInt(194),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000bb"),
  "auto_id": NumberInt(195),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000bc"),
  "auto_id": NumberInt(196),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe4220000bd"),
  "auto_id": NumberInt(197),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(75),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(14),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000bf"),
  "auto_id": NumberInt(198),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c0"),
  "auto_id": NumberInt(199),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c1"),
  "auto_id": NumberInt(200),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c2"),
  "auto_id": NumberInt(201),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c3"),
  "auto_id": NumberInt(202),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c4"),
  "auto_id": NumberInt(203),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c5"),
  "auto_id": NumberInt(204),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c6"),
  "auto_id": NumberInt(205),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c7"),
  "auto_id": NumberInt(206),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c8"),
  "auto_id": NumberInt(207),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000c9"),
  "auto_id": NumberInt(208),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ca"),
  "auto_id": NumberInt(209),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(76),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(15),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000cc"),
  "auto_id": NumberInt(210),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000cd"),
  "auto_id": NumberInt(211),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ce"),
  "auto_id": NumberInt(212),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000cf"),
  "auto_id": NumberInt(213),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d0"),
  "auto_id": NumberInt(214),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d1"),
  "auto_id": NumberInt(215),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d2"),
  "auto_id": NumberInt(216),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d3"),
  "auto_id": NumberInt(217),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d4"),
  "auto_id": NumberInt(218),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d5"),
  "auto_id": NumberInt(219),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d6"),
  "auto_id": NumberInt(220),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d7"),
  "auto_id": NumberInt(221),
  "ledger_account_id": NumberInt(43),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(840),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d8"),
  "auto_id": NumberInt(222),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(77),
  "debit": NumberInt(35962),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000d9"),
  "auto_id": NumberInt(223),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(142),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000da"),
  "auto_id": NumberInt(224),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(77),
  "debit": NumberInt(142),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(16),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000dc"),
  "auto_id": NumberInt(225),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000dd"),
  "auto_id": NumberInt(226),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000de"),
  "auto_id": NumberInt(227),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000df"),
  "auto_id": NumberInt(228),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e0"),
  "auto_id": NumberInt(229),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e1"),
  "auto_id": NumberInt(230),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e2"),
  "auto_id": NumberInt(231),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e3"),
  "auto_id": NumberInt(232),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e4"),
  "auto_id": NumberInt(233),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e5"),
  "auto_id": NumberInt(234),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e6"),
  "auto_id": NumberInt(235),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(78),
  "debit": NumberInt(34222),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(17),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e8"),
  "auto_id": NumberInt(236),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000e9"),
  "auto_id": NumberInt(237),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ea"),
  "auto_id": NumberInt(238),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000eb"),
  "auto_id": NumberInt(239),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ec"),
  "auto_id": NumberInt(240),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ed"),
  "auto_id": NumberInt(241),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ee"),
  "auto_id": NumberInt(242),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ef"),
  "auto_id": NumberInt(243),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f0"),
  "auto_id": NumberInt(244),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f1"),
  "auto_id": NumberInt(245),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f2"),
  "auto_id": NumberInt(246),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f3"),
  "auto_id": NumberInt(247),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(79),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(18),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f5"),
  "auto_id": NumberInt(248),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f6"),
  "auto_id": NumberInt(249),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f7"),
  "auto_id": NumberInt(250),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f8"),
  "auto_id": NumberInt(251),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000f9"),
  "auto_id": NumberInt(252),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000fa"),
  "auto_id": NumberInt(253),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000fb"),
  "auto_id": NumberInt(254),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000fc"),
  "auto_id": NumberInt(255),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000fd"),
  "auto_id": NumberInt(256),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000fe"),
  "auto_id": NumberInt(257),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe4220000ff"),
  "auto_id": NumberInt(258),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(80),
  "debit": NumberInt(34222),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe422000101"),
  "auto_id": NumberInt(259),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe422000102"),
  "auto_id": NumberInt(260),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe422000103"),
  "auto_id": NumberInt(261),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a55f66fbe422000104"),
  "auto_id": NumberInt(262),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:57.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000105"),
  "auto_id": NumberInt(263),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:57.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000106"),
  "auto_id": NumberInt(264),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000107"),
  "auto_id": NumberInt(265),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000108"),
  "auto_id": NumberInt(266),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000109"),
  "auto_id": NumberInt(267),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200010a"),
  "auto_id": NumberInt(268),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200010b"),
  "auto_id": NumberInt(269),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200010c"),
  "auto_id": NumberInt(270),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(81),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200010e"),
  "auto_id": NumberInt(271),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200010f"),
  "auto_id": NumberInt(272),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000110"),
  "auto_id": NumberInt(273),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000111"),
  "auto_id": NumberInt(274),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000112"),
  "auto_id": NumberInt(275),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000113"),
  "auto_id": NumberInt(276),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000114"),
  "auto_id": NumberInt(277),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000115"),
  "auto_id": NumberInt(278),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000116"),
  "auto_id": NumberInt(279),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000117"),
  "auto_id": NumberInt(280),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000118"),
  "auto_id": NumberInt(281),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15209),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000119"),
  "auto_id": NumberInt(282),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(82),
  "debit": NumberInt(51848),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200011a"),
  "auto_id": NumberInt(283),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3205),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200011b"),
  "auto_id": NumberInt(284),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(82),
  "debit": NumberInt(3205),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(21),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200011d"),
  "auto_id": NumberInt(285),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200011e"),
  "auto_id": NumberInt(286),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200011f"),
  "auto_id": NumberInt(287),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000120"),
  "auto_id": NumberInt(288),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000121"),
  "auto_id": NumberInt(289),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000122"),
  "auto_id": NumberInt(290),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000123"),
  "auto_id": NumberInt(291),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000124"),
  "auto_id": NumberInt(292),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000125"),
  "auto_id": NumberInt(293),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000126"),
  "auto_id": NumberInt(294),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000127"),
  "auto_id": NumberInt(295),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(83),
  "debit": NumberInt(34757),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(22),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000129"),
  "auto_id": NumberInt(296),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200012a"),
  "auto_id": NumberInt(297),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200012b"),
  "auto_id": NumberInt(298),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200012c"),
  "auto_id": NumberInt(299),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200012d"),
  "auto_id": NumberInt(300),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200012e"),
  "auto_id": NumberInt(301),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200012f"),
  "auto_id": NumberInt(302),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000130"),
  "auto_id": NumberInt(303),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000131"),
  "auto_id": NumberInt(304),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000132"),
  "auto_id": NumberInt(305),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000133"),
  "auto_id": NumberInt(306),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000134"),
  "auto_id": NumberInt(307),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(84),
  "debit": NumberInt(35657),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(23),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000136"),
  "auto_id": NumberInt(308),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000137"),
  "auto_id": NumberInt(309),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000138"),
  "auto_id": NumberInt(310),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000139"),
  "auto_id": NumberInt(311),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200013a"),
  "auto_id": NumberInt(312),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200013b"),
  "auto_id": NumberInt(313),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200013c"),
  "auto_id": NumberInt(314),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200013d"),
  "auto_id": NumberInt(315),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200013e"),
  "auto_id": NumberInt(316),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200013f"),
  "auto_id": NumberInt(317),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000140"),
  "auto_id": NumberInt(318),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000141"),
  "auto_id": NumberInt(319),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(85),
  "debit": NumberInt(35657),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000142"),
  "auto_id": NumberInt(320),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1190),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000143"),
  "auto_id": NumberInt(321),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(85),
  "debit": NumberInt(1190),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000145"),
  "auto_id": NumberInt(322),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000146"),
  "auto_id": NumberInt(323),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000147"),
  "auto_id": NumberInt(324),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000148"),
  "auto_id": NumberInt(325),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000149"),
  "auto_id": NumberInt(326),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200014a"),
  "auto_id": NumberInt(327),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200014b"),
  "auto_id": NumberInt(328),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200014c"),
  "auto_id": NumberInt(329),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200014d"),
  "auto_id": NumberInt(330),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200014e"),
  "auto_id": NumberInt(331),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe42200014f"),
  "auto_id": NumberInt(332),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14664),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a65f66fbe422000150"),
  "auto_id": NumberInt(333),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(86),
  "debit": NumberInt(51303),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:58.0Z"),
  "created": ISODate("2015-08-25T06:13:58.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000152"),
  "auto_id": NumberInt(334),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000153"),
  "auto_id": NumberInt(335),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000154"),
  "auto_id": NumberInt(336),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000155"),
  "auto_id": NumberInt(337),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000156"),
  "auto_id": NumberInt(338),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000157"),
  "auto_id": NumberInt(339),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000158"),
  "auto_id": NumberInt(340),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000159"),
  "auto_id": NumberInt(341),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200015a"),
  "auto_id": NumberInt(342),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200015b"),
  "auto_id": NumberInt(343),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200015c"),
  "auto_id": NumberInt(344),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200015d"),
  "auto_id": NumberInt(345),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(93),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200015f"),
  "auto_id": NumberInt(346),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000160"),
  "auto_id": NumberInt(347),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000161"),
  "auto_id": NumberInt(348),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000162"),
  "auto_id": NumberInt(349),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000163"),
  "auto_id": NumberInt(350),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000164"),
  "auto_id": NumberInt(351),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000165"),
  "auto_id": NumberInt(352),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000166"),
  "auto_id": NumberInt(353),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000167"),
  "auto_id": NumberInt(354),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000168"),
  "auto_id": NumberInt(355),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000169"),
  "auto_id": NumberInt(356),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15209),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200016a"),
  "auto_id": NumberInt(357),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(101),
  "debit": NumberInt(51848),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200016c"),
  "auto_id": NumberInt(358),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200016d"),
  "auto_id": NumberInt(359),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200016e"),
  "auto_id": NumberInt(360),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200016f"),
  "auto_id": NumberInt(361),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000170"),
  "auto_id": NumberInt(362),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000171"),
  "auto_id": NumberInt(363),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000172"),
  "auto_id": NumberInt(364),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000173"),
  "auto_id": NumberInt(365),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000174"),
  "auto_id": NumberInt(366),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000175"),
  "auto_id": NumberInt(367),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000176"),
  "auto_id": NumberInt(368),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000177"),
  "auto_id": NumberInt(369),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(199),
  "debit": NumberInt(35657),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000178"),
  "auto_id": NumberInt(370),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3146),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000179"),
  "auto_id": NumberInt(371),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(199),
  "debit": NumberInt(3146),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200017b"),
  "auto_id": NumberInt(372),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200017c"),
  "auto_id": NumberInt(373),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200017d"),
  "auto_id": NumberInt(374),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200017e"),
  "auto_id": NumberInt(375),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200017f"),
  "auto_id": NumberInt(376),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000180"),
  "auto_id": NumberInt(377),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1238),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000181"),
  "auto_id": NumberInt(378),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000182"),
  "auto_id": NumberInt(379),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000183"),
  "auto_id": NumberInt(380),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000184"),
  "auto_id": NumberInt(381),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000185"),
  "auto_id": NumberInt(382),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000186"),
  "auto_id": NumberInt(383),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(200),
  "debit": NumberInt(35460),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000187"),
  "auto_id": NumberInt(384),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(568),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000188"),
  "auto_id": NumberInt(385),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(200),
  "debit": NumberInt(568),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200018a"),
  "auto_id": NumberInt(386),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200018b"),
  "auto_id": NumberInt(387),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200018c"),
  "auto_id": NumberInt(388),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200018d"),
  "auto_id": NumberInt(389),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200018e"),
  "auto_id": NumberInt(390),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe42200018f"),
  "auto_id": NumberInt(391),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000190"),
  "auto_id": NumberInt(392),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000191"),
  "auto_id": NumberInt(393),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000192"),
  "auto_id": NumberInt(394),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000193"),
  "auto_id": NumberInt(395),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000194"),
  "auto_id": NumberInt(396),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000195"),
  "auto_id": NumberInt(397),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(201),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000196"),
  "auto_id": NumberInt(398),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1157),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a75f66fbe422000197"),
  "auto_id": NumberInt(399),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(201),
  "debit": NumberInt(1157),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:59.0Z"),
  "created": ISODate("2015-08-25T06:13:59.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000001"),
  "auto_id": NumberInt(400),
  "transaction_date": NumberInt(1432072800),
  "debit": "25000",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000002"),
  "auto_id": NumberInt(401),
  "transaction_date": NumberInt(1432072800),
  "credit": "25000",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(93),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000004"),
  "auto_id": NumberInt(402),
  "transaction_date": NumberInt(1432159200),
  "debit": "35122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000005"),
  "auto_id": NumberInt(403),
  "transaction_date": NumberInt(1432159200),
  "credit": "35122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(67),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000007"),
  "auto_id": NumberInt(404),
  "transaction_date": NumberInt(1432159200),
  "debit": "8722",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000008"),
  "auto_id": NumberInt(405),
  "transaction_date": NumberInt(1432159200),
  "credit": "8722",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(71),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d00000a"),
  "auto_id": NumberInt(406),
  "transaction_date": NumberInt(1432159200),
  "debit": "9322",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d00000b"),
  "auto_id": NumberInt(407),
  "transaction_date": NumberInt(1432159200),
  "credit": "9322",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(49),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d00000d"),
  "auto_id": NumberInt(408),
  "transaction_date": NumberInt(1432159200),
  "debit": "35122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d00000e"),
  "auto_id": NumberInt(409),
  "transaction_date": NumberInt(1432159200),
  "credit": "35122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(76),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000010"),
  "auto_id": NumberInt(410),
  "transaction_date": NumberInt(1432159200),
  "debit": "34822",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000011"),
  "auto_id": NumberInt(411),
  "transaction_date": NumberInt(1432159200),
  "credit": "34822",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(70),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000013"),
  "auto_id": NumberInt(412),
  "transaction_date": NumberInt(1432245600),
  "debit": "9322",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000014"),
  "auto_id": NumberInt(413),
  "transaction_date": NumberInt(1432245600),
  "credit": "9322",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(93),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000016"),
  "auto_id": NumberInt(414),
  "transaction_date": NumberInt(1432332000),
  "debit": "34222",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0ced5f66fb881d000017"),
  "auto_id": NumberInt(415),
  "transaction_date": NumberInt(1432332000),
  "credit": "34222",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(80),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:29.0Z"),
  "created": ISODate("2015-08-25T06:36:29.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000019"),
  "auto_id": NumberInt(416),
  "transaction_date": NumberInt(1432591200),
  "debit": "51303",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00001a"),
  "auto_id": NumberInt(417),
  "transaction_date": NumberInt(1432591200),
  "credit": "51303",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(72),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00001f"),
  "auto_id": NumberInt(420),
  "transaction_date": NumberInt(1432764000),
  "debit": "55000",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(11),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b1"),
  "auto_id": NumberInt(462),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b2"),
  "auto_id": NumberInt(463),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b3"),
  "auto_id": NumberInt(464),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b4"),
  "auto_id": NumberInt(465),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b5"),
  "auto_id": NumberInt(466),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b6"),
  "auto_id": NumberInt(467),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b7"),
  "auto_id": NumberInt(468),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b8"),
  "auto_id": NumberInt(469),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001b9"),
  "auto_id": NumberInt(470),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ba"),
  "auto_id": NumberInt(471),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001bb"),
  "auto_id": NumberInt(472),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(48),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001bd"),
  "auto_id": NumberInt(473),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001be"),
  "auto_id": NumberInt(474),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001bf"),
  "auto_id": NumberInt(475),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c0"),
  "auto_id": NumberInt(476),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c1"),
  "auto_id": NumberInt(477),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c2"),
  "auto_id": NumberInt(478),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c3"),
  "auto_id": NumberInt(479),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c4"),
  "auto_id": NumberInt(480),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c5"),
  "auto_id": NumberInt(481),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c6"),
  "auto_id": NumberInt(482),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c7"),
  "auto_id": NumberInt(483),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(49),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(32),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001c9"),
  "auto_id": NumberInt(484),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ca"),
  "auto_id": NumberInt(485),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001cb"),
  "auto_id": NumberInt(486),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001cc"),
  "auto_id": NumberInt(487),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001cd"),
  "auto_id": NumberInt(488),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ce"),
  "auto_id": NumberInt(489),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001cf"),
  "auto_id": NumberInt(490),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d0"),
  "auto_id": NumberInt(491),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d1"),
  "auto_id": NumberInt(492),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d2"),
  "auto_id": NumberInt(493),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d3"),
  "auto_id": NumberInt(494),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(50),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(33),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d5"),
  "auto_id": NumberInt(495),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d6"),
  "auto_id": NumberInt(496),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d7"),
  "auto_id": NumberInt(497),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d8"),
  "auto_id": NumberInt(498),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001d9"),
  "auto_id": NumberInt(499),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001da"),
  "auto_id": NumberInt(500),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001db"),
  "auto_id": NumberInt(501),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001dc"),
  "auto_id": NumberInt(502),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001dd"),
  "auto_id": NumberInt(503),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001de"),
  "auto_id": NumberInt(504),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001df"),
  "auto_id": NumberInt(505),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(47),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(34),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e1"),
  "auto_id": NumberInt(506),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e2"),
  "auto_id": NumberInt(507),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e3"),
  "auto_id": NumberInt(508),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e4"),
  "auto_id": NumberInt(509),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e5"),
  "auto_id": NumberInt(510),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e6"),
  "auto_id": NumberInt(511),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e7"),
  "auto_id": NumberInt(512),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e8"),
  "auto_id": NumberInt(513),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001e9"),
  "auto_id": NumberInt(514),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ea"),
  "auto_id": NumberInt(515),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001eb"),
  "auto_id": NumberInt(516),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(66),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(35),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ed"),
  "auto_id": NumberInt(517),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ee"),
  "auto_id": NumberInt(518),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001ef"),
  "auto_id": NumberInt(519),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f0"),
  "auto_id": NumberInt(520),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f1"),
  "auto_id": NumberInt(521),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f2"),
  "auto_id": NumberInt(522),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f3"),
  "auto_id": NumberInt(523),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f4"),
  "auto_id": NumberInt(524),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f5"),
  "auto_id": NumberInt(525),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f6"),
  "auto_id": NumberInt(526),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b845f66fb682a0001f7"),
  "auto_id": NumberInt(527),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(67),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(36),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:08.0Z"),
  "created": ISODate("2015-08-26T10:57:08.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001f9"),
  "auto_id": NumberInt(528),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001fa"),
  "auto_id": NumberInt(529),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001fb"),
  "auto_id": NumberInt(530),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001fc"),
  "auto_id": NumberInt(531),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001fd"),
  "auto_id": NumberInt(532),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001fe"),
  "auto_id": NumberInt(533),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a0001ff"),
  "auto_id": NumberInt(534),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000200"),
  "auto_id": NumberInt(535),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000201"),
  "auto_id": NumberInt(536),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000202"),
  "auto_id": NumberInt(537),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000203"),
  "auto_id": NumberInt(538),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(68),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(37),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000205"),
  "auto_id": NumberInt(539),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000206"),
  "auto_id": NumberInt(540),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000207"),
  "auto_id": NumberInt(541),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000208"),
  "auto_id": NumberInt(542),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000209"),
  "auto_id": NumberInt(543),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00020a"),
  "auto_id": NumberInt(544),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1238),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00020b"),
  "auto_id": NumberInt(545),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00020c"),
  "auto_id": NumberInt(546),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00020d"),
  "auto_id": NumberInt(547),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00020e"),
  "auto_id": NumberInt(548),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00020f"),
  "auto_id": NumberInt(549),
  "ledger_account_id": NumberInt(43),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(840),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000210"),
  "auto_id": NumberInt(550),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(69),
  "debit": NumberInt(11300),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(38),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000212"),
  "auto_id": NumberInt(551),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000213"),
  "auto_id": NumberInt(552),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000214"),
  "auto_id": NumberInt(553),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000215"),
  "auto_id": NumberInt(554),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000216"),
  "auto_id": NumberInt(555),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000217"),
  "auto_id": NumberInt(556),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000218"),
  "auto_id": NumberInt(557),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000219"),
  "auto_id": NumberInt(558),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00021a"),
  "auto_id": NumberInt(559),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00021b"),
  "auto_id": NumberInt(560),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00021c"),
  "auto_id": NumberInt(561),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(70),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(39),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00021e"),
  "auto_id": NumberInt(562),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00021f"),
  "auto_id": NumberInt(563),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000220"),
  "auto_id": NumberInt(564),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000221"),
  "auto_id": NumberInt(565),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000222"),
  "auto_id": NumberInt(566),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000223"),
  "auto_id": NumberInt(567),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000224"),
  "auto_id": NumberInt(568),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000225"),
  "auto_id": NumberInt(569),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000226"),
  "auto_id": NumberInt(570),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000227"),
  "auto_id": NumberInt(571),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(71),
  "debit": NumberInt(9222),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(40),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000229"),
  "auto_id": NumberInt(572),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00022a"),
  "auto_id": NumberInt(573),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00022b"),
  "auto_id": NumberInt(574),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00022c"),
  "auto_id": NumberInt(575),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00022d"),
  "auto_id": NumberInt(576),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00022e"),
  "auto_id": NumberInt(577),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00022f"),
  "auto_id": NumberInt(578),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000230"),
  "auto_id": NumberInt(579),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000231"),
  "auto_id": NumberInt(580),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000232"),
  "auto_id": NumberInt(581),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14664),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000233"),
  "auto_id": NumberInt(582),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(72),
  "debit": NumberInt(26303),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(41),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000235"),
  "auto_id": NumberInt(583),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000236"),
  "auto_id": NumberInt(584),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000237"),
  "auto_id": NumberInt(585),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000238"),
  "auto_id": NumberInt(586),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000239"),
  "auto_id": NumberInt(587),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00023a"),
  "auto_id": NumberInt(588),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00023b"),
  "auto_id": NumberInt(589),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00023c"),
  "auto_id": NumberInt(590),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00023d"),
  "auto_id": NumberInt(591),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00023e"),
  "auto_id": NumberInt(592),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15379),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a00023f"),
  "auto_id": NumberInt(593),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b855f66fb682a000240"),
  "auto_id": NumberInt(594),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(73),
  "debit": NumberInt(36384),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(42),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:09.0Z"),
  "created": ISODate("2015-08-26T10:57:09.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000242"),
  "auto_id": NumberInt(595),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000243"),
  "auto_id": NumberInt(596),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000244"),
  "auto_id": NumberInt(597),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000245"),
  "auto_id": NumberInt(598),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000246"),
  "auto_id": NumberInt(599),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000247"),
  "auto_id": NumberInt(600),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000248"),
  "auto_id": NumberInt(601),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000249"),
  "auto_id": NumberInt(602),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00024a"),
  "auto_id": NumberInt(603),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00024b"),
  "auto_id": NumberInt(604),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15379),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00024c"),
  "auto_id": NumberInt(605),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00024d"),
  "auto_id": NumberInt(606),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(74),
  "debit": NumberInt(36384),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(43),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00024f"),
  "auto_id": NumberInt(607),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000250"),
  "auto_id": NumberInt(608),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000251"),
  "auto_id": NumberInt(609),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000252"),
  "auto_id": NumberInt(610),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000253"),
  "auto_id": NumberInt(611),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000254"),
  "auto_id": NumberInt(612),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000255"),
  "auto_id": NumberInt(613),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000256"),
  "auto_id": NumberInt(614),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000257"),
  "auto_id": NumberInt(615),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000258"),
  "auto_id": NumberInt(616),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000259"),
  "auto_id": NumberInt(617),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(75),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(44),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00025b"),
  "auto_id": NumberInt(618),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00025c"),
  "auto_id": NumberInt(619),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00025d"),
  "auto_id": NumberInt(620),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00025e"),
  "auto_id": NumberInt(621),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00025f"),
  "auto_id": NumberInt(622),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000260"),
  "auto_id": NumberInt(623),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000261"),
  "auto_id": NumberInt(624),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000262"),
  "auto_id": NumberInt(625),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000263"),
  "auto_id": NumberInt(626),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000264"),
  "auto_id": NumberInt(627),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000265"),
  "auto_id": NumberInt(628),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(76),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(45),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000267"),
  "auto_id": NumberInt(629),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000268"),
  "auto_id": NumberInt(630),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000269"),
  "auto_id": NumberInt(631),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00026a"),
  "auto_id": NumberInt(632),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00026b"),
  "auto_id": NumberInt(633),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00026c"),
  "auto_id": NumberInt(634),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00026d"),
  "auto_id": NumberInt(635),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00026e"),
  "auto_id": NumberInt(636),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00026f"),
  "auto_id": NumberInt(637),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000270"),
  "auto_id": NumberInt(638),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000271"),
  "auto_id": NumberInt(639),
  "ledger_account_id": NumberInt(43),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(840),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000272"),
  "auto_id": NumberInt(640),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(77),
  "debit": NumberInt(10962),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000273"),
  "auto_id": NumberInt(641),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(380),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000276"),
  "auto_id": NumberInt(643),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000277"),
  "auto_id": NumberInt(644),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000278"),
  "auto_id": NumberInt(645),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000279"),
  "auto_id": NumberInt(646),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00027a"),
  "auto_id": NumberInt(647),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00027b"),
  "auto_id": NumberInt(648),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00027c"),
  "auto_id": NumberInt(649),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00027d"),
  "auto_id": NumberInt(650),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00027e"),
  "auto_id": NumberInt(651),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a00027f"),
  "auto_id": NumberInt(652),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(78),
  "debit": NumberInt(9222),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(47),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000281"),
  "auto_id": NumberInt(653),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000282"),
  "auto_id": NumberInt(654),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000283"),
  "auto_id": NumberInt(655),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000284"),
  "auto_id": NumberInt(656),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000285"),
  "auto_id": NumberInt(657),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000286"),
  "auto_id": NumberInt(658),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000287"),
  "auto_id": NumberInt(659),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000288"),
  "auto_id": NumberInt(660),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000289"),
  "auto_id": NumberInt(661),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00028a"),
  "auto_id": NumberInt(662),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00028b"),
  "auto_id": NumberInt(663),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(79),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(48),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00028d"),
  "auto_id": NumberInt(664),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00028e"),
  "auto_id": NumberInt(665),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00028f"),
  "auto_id": NumberInt(666),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000290"),
  "auto_id": NumberInt(667),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000291"),
  "auto_id": NumberInt(668),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000292"),
  "auto_id": NumberInt(669),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000293"),
  "auto_id": NumberInt(670),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000294"),
  "auto_id": NumberInt(671),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000295"),
  "auto_id": NumberInt(672),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000296"),
  "auto_id": NumberInt(673),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(80),
  "debit": NumberInt(9222),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(49),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000298"),
  "auto_id": NumberInt(674),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a000299"),
  "auto_id": NumberInt(675),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00029a"),
  "auto_id": NumberInt(676),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00029b"),
  "auto_id": NumberInt(677),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00029c"),
  "auto_id": NumberInt(678),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00029d"),
  "auto_id": NumberInt(679),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00029e"),
  "auto_id": NumberInt(680),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a00029f"),
  "auto_id": NumberInt(681),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a0"),
  "auto_id": NumberInt(682),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a1"),
  "auto_id": NumberInt(683),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a2"),
  "auto_id": NumberInt(684),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(81),
  "debit": NumberInt(10122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(50),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a4"),
  "auto_id": NumberInt(685),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a5"),
  "auto_id": NumberInt(686),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a6"),
  "auto_id": NumberInt(687),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a7"),
  "auto_id": NumberInt(688),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(855),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a8"),
  "auto_id": NumberInt(689),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(2595),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002a9"),
  "auto_id": NumberInt(690),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002aa"),
  "auto_id": NumberInt(691),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002ab"),
  "auto_id": NumberInt(692),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002ac"),
  "auto_id": NumberInt(693),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002ad"),
  "auto_id": NumberInt(694),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(15209),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002ae"),
  "auto_id": NumberInt(695),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(82),
  "debit": NumberInt(26848),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002af"),
  "auto_id": NumberInt(696),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(5463),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b2"),
  "auto_id": NumberInt(698),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b3"),
  "auto_id": NumberInt(699),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b4"),
  "auto_id": NumberInt(700),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b5"),
  "auto_id": NumberInt(701),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b6"),
  "auto_id": NumberInt(702),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b7"),
  "auto_id": NumberInt(703),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b8"),
  "auto_id": NumberInt(704),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b9"),
  "auto_id": NumberInt(705),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002ba"),
  "auto_id": NumberInt(706),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002bb"),
  "auto_id": NumberInt(707),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002bc"),
  "auto_id": NumberInt(708),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(83),
  "debit": NumberInt(34757),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(52),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002be"),
  "auto_id": NumberInt(709),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3350),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002bf"),
  "auto_id": NumberInt(710),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c0"),
  "auto_id": NumberInt(711),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(8400),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c1"),
  "auto_id": NumberInt(712),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1275),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c2"),
  "auto_id": NumberInt(713),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3750),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c3"),
  "auto_id": NumberInt(714),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c4"),
  "auto_id": NumberInt(715),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(330),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c5"),
  "auto_id": NumberInt(716),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(150),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c6"),
  "auto_id": NumberInt(717),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(75),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c7"),
  "auto_id": NumberInt(718),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(14652),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002c8"),
  "auto_id": NumberInt(719),
  "ledger_account_id": NumberInt(94),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(53),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000049"),
  "auto_id": NumberInt(448),
  "transaction_date": NumberInt(1432504800),
  "debit": "34757",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(203),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00004a"),
  "auto_id": NumberInt(449),
  "transaction_date": NumberInt(1432504800),
  "credit": "34757",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(83),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(25),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00004c"),
  "auto_id": NumberInt(450),
  "transaction_date": NumberInt(1433368800),
  "debit": "35657",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(203),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00004d"),
  "auto_id": NumberInt(451),
  "transaction_date": NumberInt(1433368800),
  "credit": "35657",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(84),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(26),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc14b45f66fbe81f000001"),
  "auto_id": NumberInt(452),
  "transaction_date": NumberInt(1432751400),
  "debit": "35122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T07:09:40.0Z"),
  "created": ISODate("2015-08-25T07:09:40.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc15185f66fbe81f000004"),
  "auto_id": NumberInt(454),
  "transaction_date": NumberInt(1433097000),
  "debit": "51848",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T07:11:20.0Z"),
  "created": ISODate("2015-08-25T07:11:20.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc15185f66fbe81f000005"),
  "auto_id": NumberInt(455),
  "transaction_date": NumberInt(1433097000),
  "credit": "51848",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(101),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(28),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T07:11:20.0Z"),
  "created": ISODate("2015-08-25T07:11:20.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000336"),
  "auto_id": NumberInt(1),
  "ledger_account_id": NumberInt(12),
  "ledger_sub_account_id": null,
  "debit": NumberInt(0),
  "credit": NumberInt(316714),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000337"),
  "auto_id": NumberInt(2),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(85),
  "debit": NumberInt(39571),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000338"),
  "auto_id": NumberInt(3),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(85),
  "debit": NumberInt(327),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000339"),
  "auto_id": NumberInt(4),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": 199,
  "debit": NumberInt(104571),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700033a"),
  "auto_id": NumberInt(5),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": 199,
  "debit": NumberInt(3420),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700033b"),
  "auto_id": NumberInt(6),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": 200,
  "debit": NumberInt(18869),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700033c"),
  "auto_id": NumberInt(7),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": 200,
  "debit": NumberInt(151),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700033d"),
  "auto_id": NumberInt(8),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(77),
  "debit": NumberInt(4710),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700033e"),
  "auto_id": NumberInt(9),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(47),
  "debit": NumberInt(9322),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700033f"),
  "auto_id": NumberInt(10),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(49),
  "debit": NumberInt(9322),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000340"),
  "auto_id": NumberInt(11),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(50),
  "debit": NumberInt(0),
  "credit": NumberInt(19803),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000341"),
  "auto_id": NumberInt(12),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": 201,
  "debit": NumberInt(38467),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000342"),
  "auto_id": NumberInt(13),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": 201,
  "debit": NumberInt(724),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000343"),
  "auto_id": NumberInt(14),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(78),
  "debit": NumberInt(0),
  "credit": NumberInt(10686),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000344"),
  "auto_id": NumberInt(15),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(67),
  "debit": NumberInt(9602),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000345"),
  "auto_id": NumberInt(16),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(67),
  "debit": NumberInt(419),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000346"),
  "auto_id": NumberInt(17),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(69),
  "debit": NumberInt(0),
  "credit": NumberInt(2598),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000347"),
  "auto_id": NumberInt(18),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(70),
  "debit": NumberInt(322),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000349"),
  "auto_id": NumberInt(20),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(82),
  "debit": NumberInt(106543),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb5427000348"),
  "auto_id": NumberInt(19),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(70),
  "debit": NumberInt(322),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55db2a425f66fb542700034a"),
  "auto_id": NumberInt(21),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(82),
  "debit": NumberInt(3139),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-08-24T14:29:22.0Z"),
  "created": ISODate("2015-08-24T14:29:22.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000001"),
  "auto_id": NumberInt(22),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000002"),
  "auto_id": NumberInt(23),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000003"),
  "auto_id": NumberInt(24),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000004"),
  "auto_id": NumberInt(25),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000005"),
  "auto_id": NumberInt(26),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000006"),
  "auto_id": NumberInt(27),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000007"),
  "auto_id": NumberInt(28),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000008"),
  "auto_id": NumberInt(29),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000009"),
  "auto_id": NumberInt(30),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200000a"),
  "auto_id": NumberInt(31),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200000b"),
  "auto_id": NumberInt(32),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200000c"),
  "auto_id": NumberInt(33),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(48),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(1),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200000e"),
  "auto_id": NumberInt(34),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200000f"),
  "auto_id": NumberInt(35),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000010"),
  "auto_id": NumberInt(36),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000011"),
  "auto_id": NumberInt(37),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000012"),
  "auto_id": NumberInt(38),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000013"),
  "auto_id": NumberInt(39),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000014"),
  "auto_id": NumberInt(40),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000015"),
  "auto_id": NumberInt(41),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000016"),
  "auto_id": NumberInt(42),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000017"),
  "auto_id": NumberInt(43),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000018"),
  "auto_id": NumberInt(44),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe422000019"),
  "auto_id": NumberInt(45),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(49),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200001a"),
  "auto_id": NumberInt(46),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(280),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a25f66fbe42200001b"),
  "auto_id": NumberInt(47),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(49),
  "debit": NumberInt(280),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(2),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:54.0Z"),
  "created": ISODate("2015-08-25T06:13:54.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200001d"),
  "auto_id": NumberInt(48),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200001e"),
  "auto_id": NumberInt(49),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200001f"),
  "auto_id": NumberInt(50),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000020"),
  "auto_id": NumberInt(51),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000021"),
  "auto_id": NumberInt(52),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000022"),
  "auto_id": NumberInt(53),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000023"),
  "auto_id": NumberInt(54),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000024"),
  "auto_id": NumberInt(55),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000025"),
  "auto_id": NumberInt(56),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000026"),
  "auto_id": NumberInt(57),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000027"),
  "auto_id": NumberInt(58),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000028"),
  "auto_id": NumberInt(59),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(50),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(3),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200002a"),
  "auto_id": NumberInt(60),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200002b"),
  "auto_id": NumberInt(61),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200002c"),
  "auto_id": NumberInt(62),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200002d"),
  "auto_id": NumberInt(63),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200002e"),
  "auto_id": NumberInt(64),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200002f"),
  "auto_id": NumberInt(65),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000030"),
  "auto_id": NumberInt(66),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000031"),
  "auto_id": NumberInt(67),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000032"),
  "auto_id": NumberInt(68),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000033"),
  "auto_id": NumberInt(69),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000034"),
  "auto_id": NumberInt(70),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000035"),
  "auto_id": NumberInt(71),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(47),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000036"),
  "auto_id": NumberInt(72),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(280),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000037"),
  "auto_id": NumberInt(73),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(47),
  "debit": NumberInt(280),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(4),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000039"),
  "auto_id": NumberInt(74),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200003a"),
  "auto_id": NumberInt(75),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200003b"),
  "auto_id": NumberInt(76),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200003c"),
  "auto_id": NumberInt(77),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200003d"),
  "auto_id": NumberInt(78),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200003e"),
  "auto_id": NumberInt(79),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200003f"),
  "auto_id": NumberInt(80),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000040"),
  "auto_id": NumberInt(81),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000041"),
  "auto_id": NumberInt(82),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000042"),
  "auto_id": NumberInt(83),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000043"),
  "auto_id": NumberInt(84),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000044"),
  "auto_id": NumberInt(85),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(66),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(5),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000046"),
  "auto_id": NumberInt(86),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000047"),
  "auto_id": NumberInt(87),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000048"),
  "auto_id": NumberInt(88),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000049"),
  "auto_id": NumberInt(89),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200004a"),
  "auto_id": NumberInt(90),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200004b"),
  "auto_id": NumberInt(91),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200004c"),
  "auto_id": NumberInt(92),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200004d"),
  "auto_id": NumberInt(93),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200004e"),
  "auto_id": NumberInt(94),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200004f"),
  "auto_id": NumberInt(95),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000050"),
  "auto_id": NumberInt(96),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000051"),
  "auto_id": NumberInt(97),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(67),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000052"),
  "auto_id": NumberInt(98),
  "ledger_account_id": NumberInt(41),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(289),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000053"),
  "auto_id": NumberInt(99),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(67),
  "debit": NumberInt(289),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(6),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000055"),
  "auto_id": NumberInt(100),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000056"),
  "auto_id": NumberInt(101),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000057"),
  "auto_id": NumberInt(102),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000058"),
  "auto_id": NumberInt(103),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000059"),
  "auto_id": NumberInt(104),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200005a"),
  "auto_id": NumberInt(105),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200005b"),
  "auto_id": NumberInt(106),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200005c"),
  "auto_id": NumberInt(107),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200005d"),
  "auto_id": NumberInt(108),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200005e"),
  "auto_id": NumberInt(109),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200005f"),
  "auto_id": NumberInt(110),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000060"),
  "auto_id": NumberInt(111),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(68),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(7),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000062"),
  "auto_id": NumberInt(112),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000063"),
  "auto_id": NumberInt(113),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000064"),
  "auto_id": NumberInt(114),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000065"),
  "auto_id": NumberInt(115),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000066"),
  "auto_id": NumberInt(116),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000067"),
  "auto_id": NumberInt(117),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1238),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000068"),
  "auto_id": NumberInt(118),
  "ledger_account_id": NumberInt(87),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(105),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe422000069"),
  "auto_id": NumberInt(119),
  "ledger_account_id": NumberInt(81),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(129),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200006a"),
  "auto_id": NumberInt(120),
  "ledger_account_id": NumberInt(82),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(55),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200006b"),
  "auto_id": NumberInt(121),
  "ledger_account_id": NumberInt(93),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(25000),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200006c"),
  "auto_id": NumberInt(122),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200006d"),
  "auto_id": NumberInt(123),
  "ledger_account_id": NumberInt(43),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(840),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a35f66fbe42200006e"),
  "auto_id": NumberInt(124),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(69),
  "debit": NumberInt(36300),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(8),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:55.0Z"),
  "created": ISODate("2015-08-25T06:13:55.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000070"),
  "auto_id": NumberInt(125),
  "ledger_account_id": NumberInt(84),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000071"),
  "auto_id": NumberInt(126),
  "ledger_account_id": NumberInt(86),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(1250),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000072"),
  "auto_id": NumberInt(127),
  "ledger_account_id": NumberInt(42),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(3875),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000073"),
  "auto_id": NumberInt(128),
  "ledger_account_id": NumberInt(79),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000074"),
  "auto_id": NumberInt(129),
  "ledger_account_id": NumberInt(80),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(540),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe422000075"),
  "auto_id": NumberInt(130),
  "ledger_account_id": NumberInt(83),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(900),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200007a"),
  "auto_id": NumberInt(135),
  "ledger_account_id": NumberInt(95),
  "ledger_sub_account_id": null,
  "debit": null,
  "credit": NumberInt(853),
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc07a45f66fbe42200007b"),
  "auto_id": NumberInt(136),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(70),
  "debit": NumberInt(35122),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(9),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1427826600),
  "modified": ISODate("2015-08-25T06:13:56.0Z"),
  "created": ISODate("2015-08-25T06:13:56.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00001c"),
  "auto_id": NumberInt(418),
  "transaction_date": NumberInt(1432677600),
  "debit": "35122",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00001d"),
  "auto_id": NumberInt(419),
  "transaction_date": NumberInt(1432677600),
  "credit": "35122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(79),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(10),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000038"),
  "auto_id": NumberInt(437),
  "transaction_date": NumberInt(1433196000),
  "credit": "51303",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(86),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(19),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00003a"),
  "auto_id": NumberInt(438),
  "transaction_date": NumberInt(1433196000),
  "debit": "33702",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(202),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d00003b"),
  "auto_id": NumberInt(439),
  "transaction_date": NumberInt(1433196000),
  "credit": "33702",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(69),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(20),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000046"),
  "auto_id": NumberInt(446),
  "transaction_date": NumberInt(1432332000),
  "debit": "36384",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(203),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc0cee5f66fb881d000047"),
  "auto_id": NumberInt(447),
  "transaction_date": NumberInt(1432332000),
  "credit": "36384",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(73),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(24),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T06:36:30.0Z"),
  "created": ISODate("2015-08-25T06:36:30.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc14b45f66fbe81f000002"),
  "auto_id": NumberInt(453),
  "transaction_date": NumberInt(1432751400),
  "credit": "35122",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(75),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(27),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T07:09:40.0Z"),
  "created": ISODate("2015-08-25T07:09:40.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc43965f66fb881d00004f"),
  "auto_id": NumberInt(456),
  "transaction_date": NumberInt(1432319400),
  "debit": "76745",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(203),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T10:29:42.0Z"),
  "created": ISODate("2015-08-25T10:29:42.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc43965f66fb881d000050"),
  "auto_id": NumberInt(457),
  "transaction_date": NumberInt(1432319400),
  "credit": "76745",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(85),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(29),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T10:29:42.0Z"),
  "created": ISODate("2015-08-25T10:29:42.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc43d25f66fb682a00001f"),
  "auto_id": NumberInt(458),
  "transaction_date": NumberInt(1432319400),
  "debit": "48255",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(203),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T10:30:42.0Z"),
  "created": ISODate("2015-08-25T10:30:42.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dc43d25f66fb682a000020"),
  "auto_id": NumberInt(459),
  "transaction_date": NumberInt(1432319400),
  "credit": "48255",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(199),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(30),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-25T10:30:42.0Z"),
  "created": ISODate("2015-08-25T10:30:42.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd95b75f66fb541a000001"),
  "auto_id": NumberInt(460),
  "transaction_date": NumberInt(1432146600),
  "debit": "36384",
  "credit": null,
  "ledger_account_id": NumberInt(33),
  "ledger_sub_account_id": NumberInt(203),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-26T10:32:23.0Z"),
  "created": ISODate("2015-08-26T10:32:23.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd95b75f66fb541a000002"),
  "auto_id": NumberInt(461),
  "transaction_date": NumberInt(1432146600),
  "credit": "36384",
  "debit": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(74),
  "table_name": "new_cash_bank",
  "element_id": NumberInt(31),
  "society_id": NumberInt(3),
  "modified": ISODate("2015-08-26T10:32:23.0Z"),
  "created": ISODate("2015-08-26T10:32:23.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b865f66fb682a000274"),
  "auto_id": NumberInt(642),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(77),
  "debit": NumberInt(380),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(46),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-26T10:57:10.0Z"),
  "created": ISODate("2015-08-26T10:57:10.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b875f66fb682a0002b0"),
  "auto_id": NumberInt(697),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(82),
  "debit": NumberInt(5463),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(51),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-26T10:57:11.0Z"),
  "created": ISODate("2015-08-26T10:57:11.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b885f66fb682a000309"),
  "auto_id": NumberInt(779),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(199),
  "debit": NumberInt(3349),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(58),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-26T10:57:12.0Z"),
  "created": ISODate("2015-08-26T10:57:12.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000317"),
  "auto_id": NumberInt(792),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(200),
  "debit": NumberInt(1034),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(59),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55dd9b895f66fb682a000325"),
  "auto_id": NumberInt(805),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(201),
  "debit": NumberInt(1960),
  "credit": null,
  "table_name": "new_regular_bill",
  "element_id": NumberInt(60),
  "society_id": NumberInt(3),
  "transaction_date": NumberInt(1435689000),
  "intrest_on_arrears": "YES",
  "modified": ISODate("2015-08-26T10:57:13.0Z"),
  "created": ISODate("2015-08-26T10:57:13.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000002"),
  "auto_id": NumberInt(808),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(155),
  "debit": NumberInt(12143),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000003"),
  "auto_id": NumberInt(809),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(161),
  "debit": NumberInt(28842),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000004"),
  "auto_id": NumberInt(810),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(161),
  "debit": NumberInt(1288),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000005"),
  "auto_id": NumberInt(811),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(162),
  "debit": NumberInt(22508),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000006"),
  "auto_id": NumberInt(812),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(162),
  "debit": NumberInt(506),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000007"),
  "auto_id": NumberInt(813),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(170),
  "debit": NumberInt(0),
  "credit": NumberInt(11426),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000008"),
  "auto_id": NumberInt(814),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(138),
  "debit": NumberInt(22760),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000009"),
  "auto_id": NumberInt(815),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(138),
  "debit": NumberInt(22),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700000a"),
  "auto_id": NumberInt(816),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(139),
  "debit": NumberInt(9),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700000b"),
  "auto_id": NumberInt(817),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(140),
  "debit": NumberInt(19288),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700000c"),
  "auto_id": NumberInt(818),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(145),
  "debit": NumberInt(10114),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700000d"),
  "auto_id": NumberInt(819),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(146),
  "debit": NumberInt(0),
  "credit": NumberInt(10024),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700000e"),
  "auto_id": NumberInt(820),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(150),
  "debit": NumberInt(8464),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700000f"),
  "auto_id": NumberInt(821),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(167),
  "debit": NumberInt(0),
  "credit": NumberInt(7778),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000010"),
  "auto_id": NumberInt(822),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(168),
  "debit": NumberInt(587),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000013"),
  "auto_id": NumberInt(825),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(175),
  "debit": NumberInt(8716),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000014"),
  "auto_id": NumberInt(826),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(175),
  "debit": NumberInt(196),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000015"),
  "auto_id": NumberInt(827),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(177),
  "debit": NumberInt(2799),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000016"),
  "auto_id": NumberInt(828),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(178),
  "debit": NumberInt(6721),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000017"),
  "auto_id": NumberInt(829),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(180),
  "debit": NumberInt(0),
  "credit": NumberInt(4470),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000018"),
  "auto_id": NumberInt(830),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(181),
  "debit": NumberInt(0),
  "credit": NumberInt(3387),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000019"),
  "auto_id": NumberInt(831),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(182),
  "debit": NumberInt(854),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700001a"),
  "auto_id": NumberInt(832),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(183),
  "debit": NumberInt(0),
  "credit": NumberInt(1846),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700001b"),
  "auto_id": NumberInt(833),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(184),
  "debit": NumberInt(0),
  "credit": NumberInt(2592),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700001c"),
  "auto_id": NumberInt(834),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(186),
  "debit": NumberInt(11029),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700001d"),
  "auto_id": NumberInt(835),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(187),
  "debit": NumberInt(155023),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700001e"),
  "auto_id": NumberInt(836),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(187),
  "debit": NumberInt(11302),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba81700001f"),
  "auto_id": NumberInt(837),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(189),
  "debit": NumberInt(68344),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000020"),
  "auto_id": NumberInt(838),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(189),
  "debit": NumberInt(7614),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000021"),
  "auto_id": NumberInt(839),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(191),
  "debit": NumberInt(10024),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000022"),
  "auto_id": NumberInt(840),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(192),
  "debit": NumberInt(5786),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000023"),
  "auto_id": NumberInt(841),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(193),
  "debit": NumberInt(9883),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000024"),
  "auto_id": NumberInt(842),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(197),
  "debit": NumberInt(19950),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000025"),
  "auto_id": NumberInt(843),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(197),
  "debit": NumberInt(449),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000026"),
  "auto_id": NumberInt(844),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(198),
  "debit": NumberInt(20460),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000027"),
  "auto_id": NumberInt(845),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(198),
  "debit": NumberInt(460),
  "credit": null,
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "arrear_int_type": "YES",
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000028"),
  "auto_id": NumberInt(846),
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(163),
  "debit": NumberInt(9497),
  "credit": NumberInt(0),
  "table_name": "opening_balance",
  "element_id": null,
  "society_id": NumberInt(2),
  "transaction_date": NumberInt(1427839200),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "created": ISODate("2015-09-11T05:57:49.0Z")
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000011"),
  "auto_id": NumberInt(823),
  "created": ISODate("2015-09-11T05:57:49.0Z"),
  "credit": NumberInt(0),
  "debit": NumberInt(5200),
  "element_id": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(171),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "society_id": NumberInt(2),
  "table_name": "opening_balance",
  "transaction_date": NumberInt(1427839200)
});
db.getCollection("ledgers").insert({
  "_id": ObjectId("55f26d5d5f66fba817000012"),
  "arrear_int_type": "YES",
  "auto_id": NumberInt(824),
  "created": ISODate("2015-09-11T05:57:49.0Z"),
  "credit": null,
  "debit": NumberInt(80),
  "element_id": null,
  "ledger_account_id": NumberInt(34),
  "ledger_sub_account_id": NumberInt(171),
  "modified": ISODate("2015-09-11T05:57:49.0Z"),
  "society_id": NumberInt(2),
  "table_name": "opening_balance",
  "transaction_date": NumberInt(1427839200)
});
