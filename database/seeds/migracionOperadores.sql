select sOper.nameOperator,sOper.idOperator,usuOp.name,usuOp.id
from survey_operators sOper
left join usuarios_operadores usuOp on sOper.idOperator = usuOp.name;







select tok.attribute_1,usuOp.id,usuOp.name from tokens_174561	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_259191	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_376647	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_493461	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_581766	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_759124	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_835791	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;
select tok.attribute_1,usuOp.id,usuOp.name from tokens_996661	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name order by id;



/*ACTUALIZA LOS ID DE LOS OPERADORES EN survey_operators*/
update survey_operators sOper left join usuarios_operadores usuOp on sOper.idOperator = usuOp.name set sOper.idOperator = usuOp.id;


/*ACTUALIZA LOS ID DE LOS OPERADORES EN CADA UNA DE LAS TABLAS DE TOKENS*/
update tokens_174561	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;
update tokens_259191	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;
update tokens_376647	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;
update tokens_493461	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;
update tokens_581766	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;
update tokens_759124	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;
update tokens_835791	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name	set tok.attribute_1=usuOp.id;
update tokens_996661	tok left join usuarios_operadores usuOp on tok.attribute_1 = usuOp.name set tok.attribute_1=usuOp.id;



	ALTER TABLE bbddmkp.survey_operators DROP COLUMN nameOperator;


ALTER TABLE bbddmkp.plugin_settings ADD isConfirmation TINYINT NOT NULL DEFAULT 0 AFTER value;


